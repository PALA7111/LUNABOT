<?php
/**
 * Emotion AI Human - Chatbot Web Application
 * Pure HTML5, CSS3, Vanilla JavaScript + PHP + MySQL
 */
require_once __DIR__ . '/includes/bootstrap.php';
$appName = Config::get('app.name', 'Emotion AI Human');
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title><?= htmlspecialchars($appName) ?> - 감정 표현형 AI 가상인간</title>
    <meta name="description" content="Google Gemini와 함께하는 감정 표현형 가상 인간 챗봇 서비스">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Google Fonts Pretendard / Noto Sans KR -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="app-container">
    <!-- Header -->
    <header class="app-header">
        <div class="header-left">
            <div class="character-avatar-badge">
                <img src="assets/images/character-poster.png" alt="루나">
                <span class="character-status-dot"></span>
            </div>
            <div class="character-meta">
                <h1>루나 <span style="font-size: 0.75rem; font-weight: normal; color: var(--primary);">AI Human</span></h1>
                <span class="status-text" id="statusText">대화 가능</span>
            </div>
        </div>
        <div class="header-actions">
            <!-- User Profile / Auth Area -->
            <div id="headerUserArea">
                <button class="auth-btn-pill" id="openAuthBtn">로그인 / 가입</button>
            </div>
            <!-- Audio Toggle Button -->
            <button class="icon-btn" id="audioToggleBtn" title="음성 끄기">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/>
                </svg>
            </button>
            <!-- New Chat Button -->
            <button class="icon-btn" id="newChatHeaderBtn" title="새 대화">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                </svg>
            </button>
            <!-- History Drawer Button -->
            <button class="icon-btn" id="historyBtn" title="대화 목록">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M13 3c-4.97 0-9 4.03-9 9H1l3.89 3.89.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42C8.27 19.99 10.51 21 13 21c4.97 0 9-4.03 9-9s-4.03-9-9-9zm-1 5v5l4.28 2.54.72-1.21-3.5-2.08V8H12z"/>
                </svg>
            </button>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="app-main">
        <!-- Virtual Human Video Section -->
        <section class="video-section">
            <div class="video-container" id="videoContainer">
                <!-- Dual-buffer videos for seamless crossfading -->
                <video id="videoA" class="character-video" src="assets/videos/neutral.mp4" playsinline webkit-playsinline muted loop></video>
                <video id="videoB" class="character-video hidden" playsinline webkit-playsinline muted loop style="opacity: 0;"></video>
                <!-- Image poster fallback -->
                <img id="characterPoster" class="character-poster" src="assets/images/character-poster.png" alt="캐릭터 포스터">

                <!-- Emotion Badge Overlay -->
                <div class="emotion-badge-overlay" id="emotionBadge">
                    <span class="emotion-icon" id="emotionIcon">😌</span>
                    <span id="emotionName">평온 (30%)</span>
                </div>

                <!-- Live Audio Visualizer Overlay -->
                <div class="audio-visualizer-overlay" id="audioVisualizer">
                    <div class="sound-waves">
                        <span class="sound-bar"></span>
                        <span class="sound-bar"></span>
                        <span class="sound-bar"></span>
                        <span class="sound-bar"></span>
                        <span class="sound-bar"></span>
                    </div>
                    <span style="font-size: 0.72rem; color: #fff; font-weight: 500;">음성 재생 중</span>
                    <button class="stop-audio-btn" id="stopAudioBtn" title="음성 정지">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M6 6h12v12H6z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </section>

        <!-- Chat Conversation Section -->
        <section class="chat-section">
            <div class="messages-container" id="messagesContainer">
                <!-- Typing / Thinking Indicator (Hidden by default) -->
                <div class="typing-indicator-row" id="typingIndicator" style="display: none;">
                    <div class="typing-dots">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <span>루나가 답변을 준비 중이에요...</span>
                </div>
            </div>

            <!-- Quick Prompt Suggestions -->
            <div class="quick-prompts-container">
                <button class="quick-chip" data-prompt="오늘 시험에 합격했어!">🎉 시험 합격했어!</button>
                <button class="quick-chip" data-prompt="오늘 정말 힘들었어. 위로해 줘.">🥺 오늘 너무 힘들었어</button>
                <button class="quick-chip" data-prompt="양자역학이 뭐야? 알기 쉽게 설명해줘!">🔬 양자역학이 뭐야?</button>
                <button class="quick-chip" data-prompt="외계인이 진짜 존재할까? 넌 어떻게 생각해?">👽 외계인이 존재할까?</button>
                <button class="quick-chip" data-prompt="너 오늘 기분은 어때?">✨ 오늘 기분 어때?</button>
            </div>

            <!-- Input Bar -->
            <div class="chat-input-bar">
                <div class="input-wrapper">
                    <textarea id="chatInput" class="chat-input" rows="1" placeholder="루나에게 메시지를 입력하세요..."></textarea>
                </div>
                <button id="sendBtn" class="send-btn" title="전송">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                    </svg>
                </button>
            </div>
        </section>
    </main>

    <!-- Drawer: Conversation History -->
    <div class="drawer-backdrop" id="drawerBackdrop">
        <aside class="conversations-drawer" id="conversationsDrawer">
            <div class="drawer-header">
                <h2>대화 기록</h2>
                <button class="icon-btn" id="closeDrawerBtn" title="닫기">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                    </svg>
                </button>
            </div>
            <div class="drawer-content" id="conversationsList">
                <!-- Dynamically populated -->
            </div>
            <div class="drawer-footer">
                <button class="new-chat-btn" id="newChatDrawerBtn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                    </svg>
                    새 대화 시작하기
                </button>
            </div>
        </aside>
    </div>

    <!-- Modal: Login & Registration -->
    <div class="modal-backdrop" id="authModalBackdrop">
        <div class="auth-modal" id="authModal">
            <div class="modal-header">
                <h3 id="authModalTitle">로그인 / 회원가입</h3>
                <button class="icon-btn" id="closeAuthModalBtn" title="닫기">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                    </svg>
                </button>
            </div>
            <div class="modal-tabs">
                <button class="modal-tab-btn active" id="tabLoginBtn">로그인</button>
                <button class="modal-tab-btn" id="tabRegisterBtn">회원가입</button>
            </div>
            <div class="modal-body">
                <!-- Login Form -->
                <form id="loginForm">
                    <div class="form-group">
                        <label for="loginUsername">아이디</label>
                        <input type="text" id="loginUsername" class="form-input" placeholder="아이디를 입력하세요" required autocomplete="username">
                    </div>
                    <div class="form-group">
                        <label for="loginPassword">비밀번호</label>
                        <input type="password" id="loginPassword" class="form-input" placeholder="비밀번호를 입력하세요" required autocomplete="current-password">
                    </div>
                    <button type="submit" class="modal-submit-btn" id="loginSubmitBtn">로그인</button>
                </form>

                <!-- Register Form -->
                <form id="registerForm" style="display: none;">
                    <div class="form-group">
                        <label for="regUsername">아이디</label>
                        <input type="text" id="regUsername" class="form-input" placeholder="영문/숫자 3자 이상" required autocomplete="username">
                    </div>
                    <div class="form-group">
                        <label for="regName">이름 (루나가 불러줄 이름)</label>
                        <input type="text" id="regName" class="form-input" placeholder="예: 민우, 지은" required>
                    </div>
                    <div class="form-group">
                        <label for="regPassword">비밀번호</label>
                        <input type="password" id="regPassword" class="form-input" placeholder="4자 이상 입력" required autocomplete="new-password">
                    </div>
                    <button type="submit" class="modal-submit-btn" id="regSubmitBtn">회원가입 및 시작하기</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast-container" id="toastContainer"></div>
</div>

<!-- Scripts -->
<script src="assets/js/video.js"></script>
<script src="assets/js/audio.js"></script>
<script src="assets/js/ui.js"></script>
<script src="assets/js/chat.js"></script>
<script src="assets/js/app.js"></script>

</body>
</html>
