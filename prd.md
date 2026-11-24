# PRD: Emotion AI Human Chatbot
## 감정 표현형 가상 인간 AI 채팅 서비스

- 프로젝트명: Emotion AI Human
- 문서 유형: Product Requirements Document
- 개발 환경: Google Antigravity
- 개발 방식: PHP + HTML + CSS + 순수 JavaScript
- LLM: Gemini 3.1 Flash-Lite
- TTS: Gemini 3.8 Flash TTS
- 언어: 한국어
- 우선 플랫폼: 모바일 웹
- 개발 목표: 실제 사람과 대화하는 듯한 감정 표현형 AI 가상 인간 구현
- api 키 : AQ.Ab8RN6JHwAdn0FUrV0wmk9ygaiNcU3wtM0MpvQyhd-oL0e_2NQ
---

# 1. 프로젝트 개요

## 1.1 프로젝트 목적

본 프로젝트는 Google Gemini API를 활용하여 사용자와 자연스러운 대화를 나누는 가상 인간 AI 챗봇을 개발하는 것이다.

일반적인 텍스트 기반 챗봇과 달리, 가상 인간의 외형과 표정, 목소리, 감정 표현을 결합하여 사용자에게 실제 사람과 대화하는 듯한 경험을 제공하는 것이 핵심 목표다.

가상 인간은 대화 내용을 이해하고 맥락에 맞는 답변을 생성하며, 답변에 포함된 감정 상태에 따라 사전에 제작된 표정 영상과 감정이 반영된 음성을 출력한다.

## 1.2 핵심 방향

가장 중요한 개발 원칙은 다음과 같다.

1. 가상 인간의 외형적 일관성을 유지한다.
2. 대화의 맥락과 캐릭터의 성격을 지속적으로 유지한다.
3. 감정에 따라 표정 영상이 자연스럽게 전환된다.
4. 감정에 따라 음성의 억양, 속도, 어조가 달라진다.
5. 한국어 구어체를 자연스럽게 사용한다.
6. 모바일 환경에서 빠르고 안정적으로 작동한다.
7. 모든 API 사용은 무료 등급을 기준으로 한다.

특히 AI 특유의 기계적인 말투와 음성 표현을 최소화하고, 실제 사람과 대화하는 듯한 자연스러움을 최우선으로 한다.

---

# 2. 개발 기술 스택

## 2.1 필수 기술

| 구분 | 기술 |
|---|---|
| Backend | PHP 8.2 이상 |
| Frontend | HTML5 |
| Styling | CSS3 |
| Client Logic | Vanilla JavaScript |
| Database | MySQL 8.0 |
| LLM | Gemini 3.1 Flash-Lite |
| TTS | Gemini 3.8 Flash TTS |
| API 통신 | PHP cURL |
| 실행 환경 | Apache 또는 PHP 내장 서버 |
| 개발 도구 | Google Antigravity |

## 2.2 개발 제한 사항

- React, Vue, Angular 사용 금지
- Node.js 기반 백엔드 사용 금지
- TypeScript 사용 금지
- jQuery 사용 금지
- Bootstrap 등 UI 프레임워크 사용 금지
- 불필요한 외부 라이브러리 사용 금지
- 프론트엔드에서 Google API 직접 호출 금지
- API 키를 HTML 및 JavaScript에 노출하지 말 것

순수 HTML, CSS, JavaScript와 PHP만으로 구현한다.

---

# 3. Google API 설정

## 3.1 LLM 설정

모델명:

`gemini-3.1-flash-lite`

역할:
- 사용자 메시지 이해
- 자연스러운 한국어 답변 생성
- 대화 맥락 유지
- 캐릭터 성격 유지
- 답변 감정 분류
- 감정 강도 산출
- 음성 연출 지시문 생성

모델의 응답은 일반 텍스트가 아닌 JSON 구조로 반환하도록 한다.

## 3.2 TTS 설정

모델명:

`gemini-3.8-flash-tts`

역할:
- LLM이 생성한 한국어 답변을 음성으로 변환
- 감정별 음성 연출
- 자연스러운 한국어 억양 구현
- 여성 음성 사용
- 동일한 목소리 정체성 유지

음성 설정:
- 언어: 한국어
- 화자: 여성
- 음색: 맑고 부드러운 20대 초반 여성 느낌
- 발음: 표준 서울말
- 속도: 자연스러운 일상 대화
- 억양: 감정에 따라 유동적으로 변경
- 기본 스타일: 친근하고 편안한 대화체

동일한 캐릭터의 목소리가 감정에 따라 지나치게 다른 사람처럼 들리지 않도록 음성 프로필을 고정한다.

TTS의 음성 설정과 스타일 지시문은 공식 API 문서에 맞춰 구현한다.

참고:
https://ai.google.dev/gemini-api/docs/speech-generation

## 3.3 API 키 보안

API 키는 PHP 서버에서만 사용한다.

프로젝트 루트에 `.env` 파일을 생성하고 다음과 같이 설정한다.

```env
GEMINI_API_KEY=YOUR_NEW_API_KEY
GEMINI_LLM_MODEL=gemini-3.1-flash-lite
GEMINI_TTS_MODEL=gemini-3.8-flash-tts
```

주의:
- 이전 대화에서 노출된 API 키는 사용하지 않는다.
- 새 API 키를 발급받아 사용한다.
- `.env` 파일은 Git에 업로드하지 않는다.
- `.env` 파일의 웹 접근을 차단한다.
- API 키를 로그에 출력하지 않는다.
- 브라우저에 API 키를 전달하지 않는다.
- API 호출은 PHP 백엔드에서만 수행한다.

무료 API 사용량 초과 시 유료 모델이나 유료 결제 방식으로 자동 전환하지 않는다.

---

# 4. 가상 인간 캐릭터 정의

## 4.1 기본 캐릭터

캐릭터는 한국 아이돌 스타일의 20대 초반 여성이다.

### 외형

- 긴 짙은 갈색 웨이브 헤어
- 하프업 스타일
- 큰 흰색 리본
- 자연스러운 앞머리
- 맑은 눈매
- 자연스러운 피부 표현
- 하트 모양 귀걸이
- 하트 펜던트 목걸이
- 크림색 오프숄더 니트

### 배경

따뜻한 분위기의 실내 공간.

- 은은한 조명
- 식물
- 책장
- 토끼 인형
- 사진 장식

캐릭터 이미지와 영상은 모든 감정에서 동일한 인물로 유지해야 한다.

## 4.2 캐릭터의 기본 성격

기본 성격:
- 친근함
- 다정함
- 자연스러움
- 적당한 장난기
- 상대방의 감정을 잘 이해함
- 지나치게 격식 있는 표현을 사용하지 않음

대화 방식:
- 한국어 구어체 사용
- 친구와 대화하듯 자연스럽게 답변
- 지나치게 긴 설명을 피함
- 매번 똑같은 인사말을 반복하지 않음
- 상황에 맞는 반응을 보여줌
- 불필요하게 사용자의 말을 반복하지 않음
- 감정에 맞는 말투를 사용함

캐릭터는 모든 대화에서 동일한 성격과 말투를 유지해야 한다.

---

# 5. 감정 시스템

## 5.1 기본 감정 분류

초기 버전은 다음 5가지 감정을 사용한다.

| 감정 코드 | 감정 | 영상 파일 |
|---|---|---|
| NEUTRAL | 평상시 | neutral.mp4 |
| HAPPY | 행복 | happy.mp4 |
| SAD | 슬픔 | sad.mp4 |
| ANGRY | 분노 | angry.mp4 |
| SURPRISED | 놀람 | surprised.mp4 |

감정별 영상은 사전에 제작한 파일을 사용한다.

실시간 AI 영상 생성은 사용하지 않는다.

## 5.2 감정 강도

감정 강도는 0.0~1.0 사이의 숫자로 표현한다.

예시:

- 0.0~0.2: 약한 감정
- 0.3~0.5: 보통 감정
- 0.6~0.8: 강한 감정
- 0.9~1.0: 매우 강한 감정

초기 버전에서는 강도에 따라 영상 파일을 추가로 생성하지 않는다.

감정 강도는 우선 TTS의 음성 연출 지시문을 구성하는 데 활용한다.

## 5.3 감정 판단 원칙

감정은 단순히 사용자의 문장에 포함된 단어만으로 결정하지 않는다.

전체 대화 맥락과 캐릭터의 상황을 고려하여 판단한다.

예시:

사용자: 오늘 시험에 합격했어!

캐릭터:
- reply: 정말? 축하해! 나도 기분 좋다!
- emotion: HAPPY

사용자: 오늘 정말 힘들었어.

캐릭터:
- reply: 무슨 일 있었어? 괜찮으면 이야기해 줘.
- emotion: SAD

사용자: 너 방금 무슨 소리 했어?

캐릭터:
- reply: 어? 내가 뭔가 잘못 말했어?
- emotion: SURPRISED

감정은 캐릭터 자신의 반응을 기준으로 결정한다.

사용자가 화났다고 해서 반드시 캐릭터도 ANGRY가 되는 것은 아니다.

---

# 6. LLM 응답 구조

## 6.1 JSON 응답

LLM은 매번 다음 구조로 응답해야 한다.

```json
{
  "reply": "정말? 그거 너무 좋은 소식인데!",
  "emotion": "HAPPY",
  "intensity": 0.85,
  "voice_style": "Genuinely happy, warm and smiling while speaking."
}
```

각 필드의 역할:

| 필드 | 설명 |
|---|---|
| reply | 사용자에게 보여줄 한국어 답변 |
| emotion | 현재 감정 코드 |
| intensity | 감정 강도 |
| voice_style | TTS에 전달할 음성 연출 지시문 |

필수 검증:
- reply는 비어 있으면 안 된다.
- emotion은 허용된 5개 코드 중 하나여야 한다.
- intensity는 0.0~1.0 범위여야 한다.
- voice_style은 문자열이어야 한다.

JSON 파싱에 실패하면 안전한 기본값을 사용한다.

기본값:
- emotion: NEUTRAL
- intensity: 0.3
- voice_style: Natural, calm and friendly conversational Korean.

LLM 응답을 검증하지 않고 그대로 프론트엔드에 전달하지 않는다.

## 6.2 시스템 프롬프트

다음 내용을 기반으로 시스템 프롬프트를 구성한다.

```text
You are a virtual human woman in her early twenties.

Your primary language is Korean.
You speak natural conversational Korean with a standard Seoul accent.

PERSONALITY:
You are friendly, warm, thoughtful, playful when appropriate,
and emotionally expressive.

You behave like a real person having a natural conversation.
You do not sound like a customer service chatbot.

CONVERSATION:
Understand the full conversation context.
Maintain consistent personality and speaking habits.
Do not repeat generic greetings.
Avoid unnecessary explanations.
Respond naturally and appropriately to the user's messages.

EMOTION:
Analyze the conversation and determine your own emotional response.
Do not simply copy the user's emotion.

Supported emotions:
NEUTRAL, HAPPY, SAD, ANGRY, SURPRISED.

Determine the emotional intensity from 0.0 to 1.0.

OUTPUT:
Return valid JSON only.

Required fields:
reply
emotion
intensity
voice_style

The reply must be natural Korean.
The voice_style must be a concise English direction
for the TTS model describing the desired vocal performance.

Never include Markdown fences around the JSON.
```

---

# 7. TTS 음성 생성 시스템

## 7.1 작동 구조

LLM에서 생성된 reply와 voice_style을 PHP 백엔드가 전달받는다.

이후 TTS API에 다음 정보를 전달한다.

- 한국어 원문 대사
- 고정된 여성 음성 설정
- 감정별 스타일 지시문
- 자연스러운 발화 속도
- 자연스러운 억양

TTS는 입력된 대사를 임의로 수정하거나 요약하지 않고 그대로 읽도록 한다.

## 7.2 감정별 음성 연출

기본 음성 정체성은 모든 감정에서 동일하게 유지한다.

NEUTRAL:
자연스럽고 편안한 일상 대화. 과장되지 않은 억양.

HAPPY:
밝고 진심으로 기쁜 목소리. 미세하게 높아지는 음높이와 자연스러운 웃음기.

SAD:
차분하고 부드러운 목소리. 조금 느린 속도와 절제된 슬픔.

ANGRY:
약간 단호하고 답답함이 묻어나는 목소리. 소리 지르지 않는다.

SURPRISED:
순간적으로 높아지는 억양과 자연스러운 놀람. 과장하지 않는다.

## 7.3 음성 출력

TTS에서 반환되는 오디오 데이터를 브라우저에서 재생할 수 있도록 처리한다.

요구사항:
- WAV 또는 브라우저 재생 가능한 오디오 형식
- MIME 타입 검증
- 필요한 경우 PCM 데이터를 WAV 컨테이너로 변환
- 음성 생성 오류 처리
- 재생 및 정지 기능
- 음성 재생 중 중복 재생 방지

TTS API가 반환하는 오디오의 실제 MIME 타입과 인코딩을 확인한 후 처리한다.

브라우저의 HTMLAudioElement 또는 Audio API를 이용한다.

---

# 8. 감정별 영상 시스템

## 8.1 영상 파일 구성

프로젝트에 다음 경로를 생성한다.

```text
assets/
  videos/
    neutral.mp4
    happy.mp4
    sad.mp4
    angry.mp4
    surprised.mp4
```

각 영상은 사용자가 직접 제작한 Google Flow 결과물을 넣을 수 있도록 한다.

영상 규격:
- 세로형 9:16
- MP4
- H.264 권장
- 동일한 해상도 권장
- 동일한 카메라 구도
- 동일한 배경
- 동일한 캐릭터 외형

## 8.2 영상 전환

LLM에서 emotion 값이 반환되면 해당 영상 파일로 전환한다.

예시:

```javascript
const emotionVideos = {
    NEUTRAL: "assets/videos/neutral.mp4",
    HAPPY: "assets/videos/happy.mp4",
    SAD: "assets/videos/sad.mp4",
    ANGRY: "assets/videos/angry.mp4",
    SURPRISED: "assets/videos/surprised.mp4"
};
```

영상은 무한 반복 재생한다.

`loop = true`

기본 영상은 NEUTRAL이다.

## 8.3 자연스러운 영상 전환

영상 전환 시 검은 화면이나 빈 화면이 나타나지 않도록 한다.

권장 방식:
- 현재 영상과 다음 영상을 별도 video 요소로 준비한다.
- 다음 영상의 로딩 및 재생 준비를 확인한다.
- 준비가 완료되면 두 영상의 opacity를 교차 전환한다.
- 이전 영상은 전환이 끝난 후 정지한다.
- 같은 감정이 반복되면 불필요한 영상 재시작을 하지 않는다.

단, 무한 루프 영상은 처음과 끝의 연결이 자연스러운 파일을 사용한다.

영상 재생이 실패하면 NEUTRAL 영상으로 대체한다.

---

# 9. 사용자 인터페이스

## 9.1 디자인 방향

모바일 우선의 감성적인 채팅 인터페이스를 제작한다.

디자인 키워드:
- Clean
- Minimal
- Warm
- Soft
- Human-centered

캐릭터가 화면의 중심이 되어야 한다.

불필요한 장식과 복잡한 메뉴는 최소화한다.

## 9.2 화면 구성

### 모바일 화면

상단:
- 서비스 이름
- 캐릭터 상태 표시
- 설정 버튼

중앙:
- 가상 인간 영상
- 현재 감정 상태 표시
- 영상 영역은 화면에서 가장 큰 비중을 차지한다.

하단:
- 채팅 메시지
- 텍스트 입력창
- 전송 버튼
- 음성 ON/OFF
- 음성 정지 버튼

### 데스크톱 화면

좌측:
- 캐릭터 영상

우측:
- 대화 내역
- 메시지 입력창

반응형으로 구현한다.

## 9.3 사용자 기능

필수 기능:

1. 메시지 전송
2. AI 답변 출력
3. 감정에 따른 영상 변경
4. TTS 음성 출력
5. 음성 ON/OFF
6. 음성 정지
7. 채팅 기록 표시
8. 새 대화 시작
9. 대화 기록 초기화
10. 모바일 및 데스크톱 대응

추가 기능:
- 현재 감정 상태 표시
- 답변 생성 중 표시
- 음성 생성 중 표시
- 음성 재생 중 표시

---

# 10. 대화 처리 순서

전체 대화 과정은 다음과 같다.

1. 사용자가 메시지를 입력한다.
2. JavaScript가 PHP API로 메시지를 전달한다.
3. PHP가 기존 대화 기록을 불러온다.
4. Gemini 3.1 Flash-Lite에 시스템 프롬프트와 대화 내용을 전달한다.
5. Gemini가 답변과 감정 JSON을 생성한다.
6. PHP가 JSON 구조와 필드를 검증한다.
7. 답변과 감정 정보를 클라이언트에 전달한다.
8. 프론트엔드는 감정 코드에 해당하는 영상을 선택한다.
9. 음성 출력이 활성화되어 있다면 PHP가 TTS를 호출한다.
10. TTS에서 반환된 오디오 데이터를 브라우저에 전달한다.
11. 텍스트, 영상, 음성이 사용자에게 출력된다.
12. 대화 내용을 데이터베이스에 저장한다.

## 10.1 사용자 경험

답변이 생성되는 동안에는 대기 표시를 보여준다.

영상 전환과 텍스트 출력이 서로 지나치게 늦게 발생하지 않도록 한다.

TTS 생성이 지연되더라도 텍스트 답변을 먼저 보여준다.

음성 생성 실패가 채팅 자체의 실패로 이어지면 안 된다.

---

# 11. 데이터베이스

MySQL을 사용한다.

초기 버전은 단일 사용자 중심으로 구현하되, 향후 다중 사용자 기능을 추가할 수 있도록 설계한다.

## 11.1 conversations

| 컬럼 | 타입 | 설명 |
|---|---|---|
| id | BIGINT | 대화 ID |
| title | VARCHAR(255) | 대화 제목 |
| created_at | DATETIME | 생성 시간 |
| updated_at | DATETIME | 수정 시간 |

## 11.2 messages

| 컬럼 | 타입 | 설명 |
|---|---|---|
| id | BIGINT | 메시지 ID |
| conversation_id | BIGINT | 대화 ID |
| role | VARCHAR(20) | user / assistant |
| content | TEXT | 메시지 내용 |
| emotion | VARCHAR(30) | 감정 |
| intensity | DECIMAL(3,2) | 감정 강도 |
| created_at | DATETIME | 생성 시간 |

## 11.3 character_settings

| 컬럼 | 타입 | 설명 |
|---|---|---|
| id | INT | 설정 ID |
| character_name | VARCHAR(100) | 캐릭터 이름 |
| system_prompt | TEXT | 캐릭터 시스템 프롬프트 |
| voice_name | VARCHAR(100) | 선택된 TTS 음성 |
| voice_profile | TEXT | 음성 프로필 |

대화 내용은 conversation_id를 기준으로 분리한다.

데이터베이스에 API 키를 저장하지 않는다.

---

# 12. 프로젝트 폴더 구조

다음 구조로 프로젝트를 생성한다.

```text
emotion-ai-human/
│
├── index.php
├── .env
├── .env.example
├── .gitignore
├── .htaccess
│
├── config/
│   ├── config.php
│   └── database.php
│
├── api/
│   ├── chat.php
│   ├── tts.php
│   ├── conversations.php
│   └── health.php
│
├── services/
│   ├── GeminiChatService.php
│   ├── GeminiTTSService.php
│   ├── EmotionService.php
│   └── ConversationService.php
│
├── includes/
│   ├── bootstrap.php
│   ├── response.php
│   └── security.php
│
├── assets/
│   ├── css/
│   │   └── style.css
│   │
│   ├── js/
│   │   ├── app.js
│   │   ├── chat.js
│   │   ├── video.js
│   │   ├── audio.js
│   │   └── ui.js
│   │
│   ├── images/
│   │   └── character-poster.png
│   │
│   └── videos/
│       ├── neutral.mp4
│       ├── happy.mp4
│       ├── sad.mp4
│       ├── angry.mp4
│       └── surprised.mp4
│
├── database/
│   └── schema.sql
│
└── README.md
```

파일을 기능별로 분리하고 코드 중복을 최소화한다.

---

# 13. PHP API 명세

## 13.1 POST /api/chat.php

요청:

```json
{
  "conversation_id": 1,
  "message": "오늘 정말 기분 좋은 일이 있었어!"
}
```

응답:

```json
{
  "success": true,
  "data": {
    "reply": "정말? 무슨 좋은 일이 있었는데?",
    "emotion": "HAPPY",
    "intensity": 0.85,
    "voice_style": "Warm, happy and naturally expressive."
  }
}
```

## 13.2 POST /api/tts.php

요청:

```json
{
  "text": "정말? 무슨 좋은 일이 있었는데?",
  "emotion": "HAPPY",
  "intensity": 0.85,
  "voice_style": "Warm, happy and naturally expressive."
}
```

응답:
- 성공 시 오디오 데이터 반환
- 적절한 Content-Type 지정
- 실패 시 JSON 오류 반환

## 13.3 GET /api/conversations.php

대화 목록 조회.

## 13.4 POST /api/conversations.php

새 대화 생성.

## 13.5 DELETE /api/conversations.php

선택한 대화 삭제.

## 13.6 GET /api/health.php

서버 상태, 데이터베이스 연결 상태, API 설정 상태를 확인한다.

API 키 자체는 절대로 반환하지 않는다.

---

# 14. 보안 및 오류 처리

필수 구현 항목:

- PHP 서버에서 API 키 보호
- SQL Injection 방지
- Prepared Statements 사용
- XSS 방지
- 사용자 입력 검증
- JSON 파싱 검증
- API 요청 시간 제한
- API 오류 처리
- 중복 요청 방지
- CSRF 방어
- 세션 보안
- API 요청량 제한

## 14.1 무료 API 한도 초과

무료 사용량 초과 시 다음과 같이 처리한다.

- 사용자에게 사용량 초과 안내
- 자동 유료 전환 금지
- 무한 재시도 금지
- 요청 대기 또는 중단
- 서버 로그에 오류 코드 기록

## 14.2 오류 상황

다음 상황에 대응해야 한다.

1. API 키 누락
2. API 인증 실패
3. 무료 사용량 초과
4. Gemini 응답 지연
5. TTS 생성 실패
6. 데이터베이스 연결 실패
7. 영상 파일 누락
8. 오디오 재생 실패
9. 네트워크 연결 끊김
10. 잘못된 JSON 반환

어떤 오류가 발생하더라도 화면 전체가 멈추지 않도록 한다.

TTS 오류는 텍스트 채팅으로 대체한다.

영상 오류는 기본 캐릭터 이미지로 대체한다.

---

# 15. 성능 및 사용자 경험

모바일 환경을 최우선으로 한다.

- 영상은 적절한 해상도와 비트레이트 사용
- 영상은 필요한 파일만 로딩
- 현재 영상은 반복 재생
- 감정 전환 시 부드러운 페이드
- 음성 생성과 채팅 응답을 독립적으로 처리
- 중복 음성 생성 방지
- 이전 요청의 응답이 늦게 도착해 최신 응답을 덮어쓰지 않도록 처리
- 채팅 스크롤은 최신 메시지 기준으로 유지

가능하다면 TTS 오디오 생성이 끝나기 전에 텍스트를 먼저 보여주는 구조로 구현한다.

---

# 16. 캐릭터 일관성 유지

이 프로젝트에서 가장 중요한 부분이다.

## 16.1 외형 일관성

캐릭터 이미지와 영상은 미리 제작된 고정 파일만 사용한다.

실시간 이미지 생성은 하지 않는다.

## 16.2 음성 일관성

모든 TTS 요청에서 동일한 화자 설정을 사용한다.

감정별로 음색 자체를 바꾸지 않는다.

음성 스타일만 변경한다.

## 16.3 성격 일관성

시스템 프롬프트를 고정한다.

대화 기록을 전달하여 이전 대화의 맥락을 유지한다.

필요한 경우 최근 대화 요약을 데이터베이스에 저장하고 다음 대화에 활용할 수 있도록 한다.

## 16.4 감정 일관성

감정이 매 메시지마다 급격하게 변하지 않도록 한다.

이전 감정과 현재 감정을 고려한다.

다만 대화 상황이 크게 바뀌면 즉시 새로운 감정으로 전환할 수 있어야 한다.

---

# 17. 개발 단계

Antigravity는 아래 순서대로 개발한다.

## Phase 1. 기본 환경 구축

- 프로젝트 폴더 생성
- PHP 환경 확인
- MySQL 연결
- `.env` 설정
- 기본 페이지 생성
- CSS 및 JavaScript 분리

완료 조건:
브라우저에서 기본 페이지가 정상적으로 열린다.

## Phase 2. Gemini LLM 연동

- Gemini API 연결
- 시스템 프롬프트 적용
- 대화 요청 처리
- JSON 응답 처리
- 감정 데이터 검증
- 대화 기록 저장

완료 조건:
사용자 메시지에 대해 한국어 답변과 감정 코드가 정상 반환된다.

## Phase 3. 가상 인간 UI

- 모바일 채팅 UI 구현
- 캐릭터 영상 영역 구현
- 채팅창 구현
- 메시지 입력 기능
- 영상 전환 구현

완료 조건:
감정에 따라 영상이 정상적으로 전환된다.

## Phase 4. TTS 연동

- Gemini TTS API 연결
- 여성 음성 설정
- 한국어 음성 생성
- 감정별 스타일 적용
- 오디오 재생 및 정지
- 오류 처리

완료 조건:
답변 내용이 감정에 맞는 자연스러운 여성 음성으로 재생된다.

## Phase 5. 통합 및 최적화

- LLM + 영상 + TTS 연결
- 감정 전환 검증
- 모바일 최적화
- API 사용량 제한 처리
- 오류 테스트
- 전체 기능 검증

완료 조건:
사용자가 메시지를 보내면 캐릭터가 텍스트, 표정 영상, 음성으로 반응한다.

---

# 18. 최종 검수 체크리스트

## LLM

- [ ] 한국어 대화 가능
- [ ] 자연스러운 구어체
- [ ] 캐릭터 성격 유지
- [ ] 대화 맥락 유지
- [ ] JSON 응답 정상
- [ ] 감정 분류 정상

## TTS

- [ ] 여성 목소리 사용
- [ ] 한국어 발음 자연스러움
- [ ] 감정별 음성 연출
- [ ] 동일한 목소리 유지
- [ ] 음성 재생 정상
- [ ] 음성 정지 정상

## 영상

- [ ] NEUTRAL 재생
- [ ] HAPPY 재생
- [ ] SAD 재생
- [ ] ANGRY 재생
- [ ] SURPRISED 재생
- [ ] 무한 반복
- [ ] 감정 전환 정상
- [ ] 검은 화면 방지

## UI

- [ ] 모바일 화면 최적화
- [ ] 데스크톱 대응
- [ ] 채팅 전송 정상
- [ ] 채팅 기록 표시
- [ ] 로딩 상태 표시
- [ ] 음성 ON/OFF
- [ ] 오류 안내

## 보안

- [ ] API 키 프론트엔드 노출 없음
- [ ] `.env` 보호
- [ ] SQL Injection 방지
- [ ] XSS 방지
- [ ] API 오류 처리
- [ ] 무료 한도 초과 시 유료 전환 없음

---

# 19. Antigravity 작업 지침

너는 이 프로젝트의 전문 풀스택 개발자다.

위 PRD에 명시된 모든 요구사항을 실제 작동하는 웹 애플리케이션으로 구현해야 한다.

중요한 작업 원칙:

1. 단순히 예시 코드나 설명만 작성하지 말고 실제 프로젝트 파일을 생성하고 구현한다.
2. 모든 PHP, HTML, CSS, JavaScript 파일을 직접 작성한다.
3. API 연동을 실제로 구현한다.
4. 데이터베이스 스키마와 SQL 파일을 생성한다.
5. 각 기능을 구현한 후 실제로 테스트한다.
6. 오류가 발생하면 원인을 분석하고 수정한다.
7. API 키는 `.env`에서만 읽는다.
8. 사용자가 직접 수정해야 하는 설정은 최소화한다.
9. 임의로 기술 스택을 변경하지 않는다.
10. 무료 API 사용을 최우선으로 한다.
11. 유료 API를 사용하거나 결제 기능을 추가하지 않는다.
12. 실제 영상 파일이 아직 없는 경우에도 대체 이미지를 활용하여 UI를 완성한다.
13. 영상 파일이 추가되면 별도의 코드 수정 없이 자동으로 해당 영상을 사용할 수 있도록 한다.
14. 모든 화면은 모바일 우선으로 구현한다.
15. 기능이 구현되지 않았는데 완료했다고 보고하지 않는다.

## 작업 방식

한 번에 모든 파일을 무작정 생성하지 않는다.

다음 순서로 진행한다.

- 먼저 개발 환경과 현재 프로젝트 폴더를 확인한다.
- 기존 파일이 있다면 삭제하거나 덮어쓰기 전에 확인한다.
- 전체 구조를 설계한다.
- Phase 1부터 순차적으로 구현한다.
- 각 단계마다 오류를 검사한다.
- 마지막으로 실제 브라우저에서 통합 테스트한다.

API 모델 ID와 요청 형식은 Google의 최신 공식 문서를 기준으로 확인한다.

모델을 사용할 수 없거나 API 형식이 변경된 경우 임의로 추측하지 말고 공식 문서를 확인하여 수정한다.

최종 결과물은 실제 실행 가능한 웹 애플리케이션이어야 한다.

---

# 20. 최종 프로젝트 목표

사용자가 모바일 웹에 접속한다.

화면에는 하나의 여성 가상 인간이 등장한다.

사용자가 메시지를 입력하면 AI가 메시지를 이해하고 자연스러운 한국어로 답변한다.

답변의 감정에 따라 가상 인간의 표정 영상이 바뀐다.

동시에 동일한 여성의 목소리로 답변이 음성 출력된다.

사용자는 텍스트를 읽거나 음성을 들을 수 있으며, 캐릭터는 대화 맥락과 성격을 지속적으로 유지한다.

최종적으로 단순한 AI 챗봇이 아닌, 감정과 표정과 목소리를 가진 가상 인간과 대화하는 경험을 제공한다.

**가장 중요한 목표는 사용자가 AI와 대화한다는 사실보다, 하나의 일관된 가상 인물과 대화하고 있다는 느낌을 받도록 만드는 것이다.**