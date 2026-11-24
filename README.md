# Emotion AI Human (감정 표현형 AI 가상 인간)

Google Gemini API를 활용하여 사용자와 자연스러운 대화를 나누며, 대화 맥락과 감정에 따라 사전에 제작된 표정 영상과 여성 목소리 음성(TTS)을 동기화하여 출력하는 가상 인간 AI 챗봇 서비스입니다.

---

## 1. 주요 특징

- **캐릭터 일관성**: 한국 아이돌 스타일의 20대 초반 여성 캐릭터('루나')의 외형, 성격, 목소리 정체성 지속 유지
- **5가지 감정 시스템**: `NEUTRAL` (평온), `HAPPY` (행복), `SAD` (슬픔), `ANGRY` (분노/서운함), `SURPRISED` (놀람)
- **감정 동기화 영상 전환**: 검은 화면 깜빡임을 방지하는 듀얼 버퍼 크로스페이드(Crossfade) 영상 전환 기술 적용
- **감정 표현형 TTS 음성**: `gemini-3.8-flash-tts` 모델을 활용하여 감정과 어조 지시문(`voice_style`)이 반영된 맑고 자연스러운 한국어 여성 음성(`Kore`) 출력
- **반응형 웹 UI**: 모바일 최적화 및 데스크톱 듀얼 컬럼(비디오+채팅창) 지원
- **데이터베이스 연동**: MySQL 8.0 기반 대화 세션 및 메시지 기록 저장 (서비스 안정성을 위한 SQLite 자동 폴백 지원)
- **보안 및 예외 처리**: API 키 프론트엔드 노출 차단, `.env` 보호, XSS/SQL Injection 방어, 무료 API 한도 초과 시 안내 메시지 제공

---

## 2. 기술 스택

| 구분 | 기술 |
|---|---|
| Backend | PHP 8.0+ (PDO, cURL, OpenSSL) |
| Frontend | Pure HTML5, CSS3 (Glassmorphism & Mobile-first), Vanilla JavaScript |
| Database | MySQL 8.0 / MariaDB (SQLite fallback) |
| LLM | Google Gemini 3.1 Flash-Lite (`gemini-3.1-flash-lite`) |
| TTS | Google Gemini 3.8 Flash TTS (`gemini-3.8-flash-tts`) |
| Web Server | Apache (XAMPP) |

---

## 3. 디렉터리 구조

```text
chatbot 4/
├── index.php                 # 메인 웹 페이지
├── .env                      # API 키 및 DB 환경설정
├── .env.example              # 환경설정 템플릿
├── .gitignore                # Git 제외 파일 목록
├── .htaccess                 # 웹 접근 제어 및 보안 헤더
│
├── config/
│   ├── config.php            # 환경변수 로더 및 시스템 설정
│   └── database.php          # PDO 데이터베이스 연결 관리자
│
├── api/
│   ├── chat.php              # LLM 대화 생성 API
│   ├── tts.php               # TTS 음성 생성 및 오디오 스트리밍 API
│   ├── conversations.php     # 대화 목록 조회 / 생성 / 삭제 API
│   └── health.php            # 시스템 상태 점검 API
│
├── services/
│   ├── GeminiChatService.php # Gemini LLM 대화 서비스
│   ├── GeminiTTSService.php  # Gemini TTS 음성 변환 서비스
│   ├── EmotionService.php    # 감정 분류 및 미디어 매핑 서비스
│   └── ConversationService.php # 대화 및 메시지 DB 관리 서비스
│
├── includes/
│   ├── bootstrap.php         # 애플리케이션 부트스트랩
│   ├── response.php          # 표준 API JSON 응답 헬퍼
│   └── security.php          # 입력값 검증 및 보안 헬퍼
│
├── assets/
│   ├── css/
│   │   └── style.css         # 반응형 모바일/데스크톱 스타일시트
│   ├── js/
│   │   ├── app.js            # 메인 애플리케이션 진입점
│   │   ├── chat.js           # 대화 송수신 및 메시지 렌더링
│   │   ├── video.js          # 비디오 듀얼 버퍼 크로스페이드 전환
│   │   ├── audio.js          # TTS 오디오 재생/정지 및 캐싱
│   │   └── ui.js             # UI 상태 및 드로어 관리
│   ├── images/               # 캐릭터 포스터 및 감정별 이미지
│   └── videos/               # 감정별 9:16 루프 영상 (neutral, happy, sad, angry, surprised)
│
├── database/
│   └── schema.sql            # MySQL 데이터베이스 스키마
└── README.md
```

---

## 4. cURL 테스트 가이드

### 4.1 헬스 체크 API
```bash
curl -s "http://localhost/chatbot%204/api/health.php"
```

### 4.2 대화 목록 조회
```bash
curl -s "http://localhost/chatbot%204/api/conversations.php"
```

### 4.3 새 대화 생성
```bash
curl -s -X POST "http://localhost/chatbot%204/api/conversations.php" \
     -H "Content-Type: application/json; charset=utf-8" \
     -d '{"title": "새 대화"}'
```

### 4.4 메시지 전송 및 감정 답변 수신 (LLM)
```bash
curl -s -X POST "http://localhost/chatbot%204/api/chat.php" \
     -H "Content-Type: application/json; charset=utf-8" \
     -d '{"conversation_id": 1, "message": "오늘 날씨가 정말 좋다! 너는 기분 어때?"}'
```

### 4.5 감정 음성 합성 (TTS)
```bash
curl -s -X POST "http://localhost/chatbot%204/api/tts.php" \
     -H "Content-Type: application/json; charset=utf-8" \
     -d '{"text": "안녕! 오늘 날씨 너무 좋다.", "emotion": "HAPPY", "intensity": 0.8}' \
     --output speech.wav
```

