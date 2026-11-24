$baseUrl = "http://localhost/chatbot%204"
$results = @()
$cookieJar = "$pwd\suite_cookie.txt"
Remove-Item $cookieJar -ErrorAction SilentlyContinue

function Run-Test {
    param([string]$name, [scriptblock]$action)
    Write-Host "Running: $name..." -ForegroundColor Cyan
    try {
        $res = & $action
        if ($res.pass) {
            Write-Host " [PASS] $name - $($res.msg)" -ForegroundColor Green
            $global:results += [PSCustomObject]@{ Test = $name; Status = "PASS"; Details = $res.msg }
        } else {
            Write-Host " [FAIL] $name - $($res.msg)" -ForegroundColor Red
            $global:results += [PSCustomObject]@{ Test = $name; Status = "FAIL"; Details = $res.msg }
        }
    } catch {
        Write-Host " [ERROR] $name - $_" -ForegroundColor Red
        $global:results += [PSCustomObject]@{ Test = $name; Status = "ERROR"; Details = "$_" }
    }
}

# 1. Health Check
Run-Test "1. Health Check API" {
    $out = curl.exe -s "$baseUrl/api/health.php" | ConvertFrom-Json
    $pass = ($out.success -eq $true) -and ($out.data.status -eq "healthy") -and ($out.data.database.status -eq "connected")
    return @{ pass = $pass; msg = "status=$($out.data.status), db=$($out.data.database.driver), gemini=$($out.data.gemini.configured)" }
}

# 2. User Registration
$testUser = "testuser_" + (Get-Random -Minimum 1000 -Maximum 9999)
Run-Test "2. User Registration (MySQL)" {
    $payload = '{"username":"' + $testUser + '","password":"password123","name":"수아"}'
    [System.IO.File]::WriteAllText("$pwd\temp_t.json", $payload, [System.Text.UTF8Encoding]::new($false))
    $out = curl.exe -s -c $cookieJar -X POST "$baseUrl/api/auth.php?action=register" -H "Content-Type: application/json; charset=utf-8" --data-binary "@temp_t.json" | ConvertFrom-Json
    Remove-Item temp_t.json -ErrorAction SilentlyContinue
    $pass = ($out.success -eq $true) -and ($out.data.user.name -eq "수아")
    return @{ pass = $pass; msg = "Registered ID=$($out.data.user.id), username=$($out.data.user.username), name=$($out.data.user.name)" }
}

# 3. Session Check (Auth Me)
Run-Test "3. Session Check (/api/auth.php?action=me)" {
    $out = curl.exe -s -b $cookieJar "$baseUrl/api/auth.php?action=me" | ConvertFrom-Json
    $pass = ($out.success -eq $true) -and ($out.data.is_logged_in -eq $true) -and ($out.data.user.name -eq "수아")
    return @{ pass = $pass; msg = "Logged in as $($out.data.user.name)" }
}

# 4. Create User-scoped Conversation
$userConvId = 0
Run-Test "4. Create User-scoped Conversation" {
    [System.IO.File]::WriteAllText("$pwd\temp_t.json", '{"title":"수아와의 첫 대화"}', [System.Text.UTF8Encoding]::new($false))
    $out = curl.exe -s -b $cookieJar -X POST "$baseUrl/api/conversations.php" -H "Content-Type: application/json; charset=utf-8" --data-binary "@temp_t.json" | ConvertFrom-Json
    Remove-Item temp_t.json -ErrorAction SilentlyContinue
    $global:userConvId = [int]$out.data.id
    $pass = ($out.success -eq $true) -and ($global:userConvId -gt 0)
    return @{ pass = $pass; msg = "Conversation ID=$($global:userConvId), title=$($out.data.title)" }
}

# 5. Unexpected / Philosophical Question
Run-Test "5. Unexpected Question Handling" {
    $payload = '{"conversation_id":' + $global:userConvId + ',"message":"만약 인공지능이 꿈을 꿀 수 있다면 어떤 꿈을 꿀까?"}'
    [System.IO.File]::WriteAllText("$pwd\temp_t.json", $payload, [System.Text.UTF8Encoding]::new($false))
    $out = curl.exe -s -b $cookieJar -X POST "$baseUrl/api/chat.php" -H "Content-Type: application/json; charset=utf-8" --data-binary "@temp_t.json" | ConvertFrom-Json
    Remove-Item temp_t.json -ErrorAction SilentlyContinue
    $pass = ($out.success -eq $true) -and ($out.data.reply.Length -gt 0) -and ($out.data.emotion)
    $snippet = $out.data.reply.Substring(0, [Math]::Min(35, $out.data.reply.Length))
    return @{ pass = $pass; msg = "emotion=$($out.data.emotion), reply=$snippet..." }
}

# 6. User Memory & Progress Learning
Run-Test "6. User Context & Progress Memory" {
    $payload = '{"conversation_id":' + $global:userConvId + ',"message":"나는 일러스트 그리는 걸 좋아해. 주말마다 카페에서 그림 그려!"}'
    [System.IO.File]::WriteAllText("$pwd\temp_t.json", $payload, [System.Text.UTF8Encoding]::new($false))
    $out = curl.exe -s -b $cookieJar -X POST "$baseUrl/api/chat.php" -H "Content-Type: application/json; charset=utf-8" --data-binary "@temp_t.json" | ConvertFrom-Json
    Remove-Item temp_t.json -ErrorAction SilentlyContinue
    $pass = ($out.success -eq $true) -and ($out.data.reply.Length -gt 0)
    return @{ pass = $pass; msg = "Memory input acknowledged: emotion=$($out.data.emotion)" }
}

# 7. Memory Recall in Dialogue
Run-Test "7. Memory Recall in Next Turn" {
    $payload = '{"conversation_id":' + $global:userConvId + ',"message":"수아가 주말마다 어디서 뭐 하는지 기억해?"}'
    [System.IO.File]::WriteAllText("$pwd\temp_t.json", $payload, [System.Text.UTF8Encoding]::new($false))
    $out = curl.exe -s -b $cookieJar -X POST "$baseUrl/api/chat.php" -H "Content-Type: application/json; charset=utf-8" --data-binary "@temp_t.json" | ConvertFrom-Json
    Remove-Item temp_t.json -ErrorAction SilentlyContinue
    $pass = ($out.success -eq $true) -and ($out.data.reply -match "카페|그림|일러스트")
    $snippet = $out.data.reply.Substring(0, [Math]::Min(40, $out.data.reply.Length))
    return @{ pass = $pass; msg = "Recall successful: $snippet..." }
}

# 8. TTS Audio Streaming
Run-Test "8. TTS Speech Synthesis (WAV)" {
    $ttsPayload = '{"text":"당연하지! 수아 그림 그리는 거 좋아하잖아.","emotion":"HAPPY","intensity":0.8,"voice_style":"Warm and friendly"}'
    [System.IO.File]::WriteAllText("$pwd\temp_t.json", $ttsPayload, [System.Text.UTF8Encoding]::new($false))
    curl.exe -s -D temp_h.txt -X POST "$baseUrl/api/tts.php" -H "Content-Type: application/json; charset=utf-8" --data-binary "@temp_t.json" -o temp_a.wav
    $headers = Get-Content temp_h.txt -Raw
    $fileLen = (Get-Item temp_a.wav).Length
    Remove-Item temp_t.json, temp_h.txt, temp_a.wav -ErrorAction SilentlyContinue
    $pass = ($headers -match "Content-Type:\s*audio/wav") -and ($fileLen -gt 10000)
    return @{ pass = $pass; msg = "WAV size=$fileLen bytes, Content-Type: audio/wav verified" }
}

# 9. Security (.env 403 Forbidden)
Run-Test "9. Security - .env Access Blocked" {
    $headers = curl.exe -s -I "$baseUrl/.env"
    $pass = ($headers -match "403 Forbidden")
    return @{ pass = $pass; msg = "HTTP 403 Forbidden verified" }
}

# 10. User Logout
Run-Test "10. User Logout" {
    $out = curl.exe -s -b $cookieJar -c $cookieJar -X POST "$baseUrl/api/auth.php?action=logout" | ConvertFrom-Json
    $meAfter = curl.exe -s -b $cookieJar "$baseUrl/api/auth.php?action=me" | ConvertFrom-Json
    $pass = ($out.success -eq $true) -and ($meAfter.data.is_logged_in -eq $false)
    return @{ pass = $pass; msg = "Logged out successfully" }
}

Remove-Item $cookieJar -ErrorAction SilentlyContinue

Write-Host "`n=======================================================" -ForegroundColor Yellow
Write-Host "             FINAL COMPREHENSIVE TEST REPORT           " -ForegroundColor Yellow
Write-Host "=======================================================" -ForegroundColor Yellow
$results | Format-Table -AutoSize
