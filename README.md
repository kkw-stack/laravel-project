<<<<<<< HEAD
# [메덩골정원](https://medongaule.com/)

## 서버 요구 사항
- [Laravel Document](https://laravel.com/docs/11.x/deployment#server-requirements)
  - PHP >= 8.2
  - Ctype PHP Extension
  - cURL PHP Extension
  - DOM PHP Extension
  - Fileinfo PHP Extension
  - Filter PHP Extension
  - Hash PHP Extension
  - Mbstring PHP Extension
  - OpenSSL PHP Extension
  - PCRE PHP Extension
  - PDO PHP Extension
  - Session PHP Extension
  - Tokenizer PHP Extension
  - XML PHP Extension

## 로컬 세팅
1. [php 다운로드](https://windows.php.net/downloads/releases/archives/) - C:/php 경로로 압축 풀기(version 8.3.4-TS)
  - php.ini 설정하기
  - php.ini-development파일을 복하여 php.ini로 저장
  - extension_dir 경로 수정 (extension_dir = “C:/php/ext”)
2. [composer 다운로드](https://getcomposer.org/download/)
  - Developer mode 체크
  - 설치 경로는 설치한 php 경로 (C:/php)
3. [git 프로젝트 클론](https://github.com/studio-jt/client-medongaule)
4. [필수 extension 확장](https://laravel.com/docs/11.x/deployment#server-requirements)
C:/php/php.ini 수정 : 기본적으로 활성화 되어 있는 extension이 존재하며, 이 경우에는 별도로 설정을 추가하거나 수정 할 필요 없으므로 (주석 해제)로 표기한 항목만 주석 해제해주면 됨.
  - Ctype PHP Extension (기본 확장)
  - cURL PHP Extension (주석 해제)
  - DOM PHP Extension (기본 확장)
  - Fileinfo PHP Extension (주석 해제)
  - Filter PHP Extension (기본 확장)
  - Hash PHP Extension (기본 확장)
  - Mbstring PHP Extension (주석 해제)
  - OpenSSL PHP Extension (주석 해제)
  - PCRE PHP Extension (기본 확장)
  - Pdo sqlite PHP Extension (주석 해제)
  - Session PHP Extension (기본 확장)
  - Tokenizer PHP Extension (기본 확장)
  - XML PHP Extension (기본 확장)
5. 프로젝트 폴더의 .env.example 파일을 복사 하여 .env로 저장
6. 커맨드에서 프로젝트 폴더로 이동한 후 아래 순서대로 명령어 입력
  - composer install (확장 설치, 시간이 다소 걸림)
  - php artisan migrate (데이터베이스 생성)
  - php artisan serve (서버 스타트)

### (필수 사항) 파일/이미지 업로드를 위한 Storage 세팅
1. 커맨드에 php artisan storage:link 명령어 입력
  [https://laravel.com/docs/11.x/filesystem#the-public-disk](https://laravel.com/docs/11.x/filesystem#the-public-disk)
2. public 디렉터리에 storage 폴더가 생성된것을 확인

### (선택 사항) 로컬 데이터베이스 mysql 변경 방법
1. php.ini 에서 extension 설치를 위해 pdo_mysql 주석 해제
2. 위 서버 세팅에서 진행했던 composer install 명령어로 주석 해재한 확장 기능을 설치
3. .env에서 DB 변수 수정  
  DB_CONNECTION=mysql  
  DB_HOST=127.0.0.1  
  DB_PORT=3306  
  DB_DATABASE=jt_medong_dev  
  DB_USERNAME={username} : 로컬 DB서버 USERNAME  
  DB_PASSWORD={password} : 로컬 DB서버 PASSWORD  
4. 로컬 DB 세팅
  wamp64를 활용하면 편하게 세팅할 수 있습니다.
  -  wamp64 설치 후 실행 (http://127.0.0.1:3006으로 로컬 DB 서버 생성 및 실행됨)
  - [http://localhost/phpMyAdmin](http://localhost/phpMyAdmin) 에 접속하여 아이디, 패스워드를 세팅(권장 사항 id : root, pw: [공백])
  - window 상태표시줄 우측 하단 wamp64 아이콘에서 마우스 좌클릭하여 MySQL > MySQL settings 탭으로 이동 후 default_storage_engine 값을 InnoDB로 변경, 해당 탭에서 보이지 않는다면 my.ini 파일을 열어 직접 변경, 변경하지 않았을 때 마이그레이션 단계에서 [1번 에러] 발생, 그러고 나서 [2번 에러]가 발생한다면 innodb-default-row-format 값을 dynamic으로 변경, 에러가 발생했었다면 생성된 테이블을 삭제
  [1번 에러] : SQLSTATE[42000]: Syntax error or access violation: 1071 Specified key was too long; max key length is 1000 bytes.
  [2번 에러] : SQLSTATE[HY000]: General error: 1709 Index column size too large. The maximum column size is 767 bytes.
5. 세팅 단계에서 했었던 php artisan migrate 명령어로 마이그레이션 진행
6. php artisan serve 명령어로 동작 테스트, 정상 동작한다면 성공

### React 세팅 - 예매 컴포넌트
1. npm install
2. npm run dev

### NICE API 세팅(.env)
    JT_NICE_CLIENT_ID=PM 참고
    JT_NICE_SECRET=PM 참고
    JT_NICE_PRODUCT_ID=PM 참고

### Social Login 세팅(.env)
    JT_KAKAO_CLIENT_ID=PM 참고
    JT_KAKAO_SECRET=PM 참고
    JT_NAVER_CLIENT_ID=PM 참고
    JT_NAVER_SECRET=PM 참고
    JT_GOOGLE_CLIENT_ID=PM 참고
    JT_GOOGLE_SECRET=PM 참고

### Easypay 환경 변수 추가(.env)
    JT_EASYPAY_MALL_ID=PM 참고
    JT_EASYPAY_SECRET_KEY=PM 참고
    JT_EASYPAY_TEST_MALL_ID=PM 참고
    JT_EASYPAY_TEST_SECRET_KEY=PM 참고

### ALIGO 환경 변수 추가(.env)
    JT_ALIGO_APIKEY=PM 참고
    JT_ALIGO_USERID=PM 참고
    JT_ALIGO_SENDERKEY=PM 참고
    JT_ALIGO_SENDER=PM 참고

### 공공데이터포털 환경 변수 추가(.env)
    JT_KMA_API_KEY=PM 참고

## Relese note
- 2024-04-11 : 개발 착수
- 2024-10-07 : 1차 오픈
- 2024-11-15 : 영문 오픈
=======
# laravel-project
>>>>>>> 2201c510ac0a128a03acb605c56a2c44940b9382
