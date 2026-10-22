# usg-page

最強海巨 · Ultimate Sea Giant CTF 팀 페이지 (Laravel 13). 디자인은 [viram.dev](https://viram.dev)와 같은 톤.

- 팀 정보·멤버·대회 기록: `config/team.php` 에서 수정
- 올해 순위/레이팅: CTFtime API에서 6시간 캐시로 가져오고, 실패하면 `rating_fallback` 값 사용 (`app/Services/CtfTime.php`)
- 화면: `resources/views/team.blade.php` (빌드 없이 인라인 CSS)

## 실행

```sh
composer install && cp .env.example .env && php artisan key:generate
php artisan serve
```

## Docker (배포용)

nginx + php-fpm 두 컨테이너. PHP는 PHP2Shell 패치 버전(`php:8.5.12-fpm-alpine`)으로 고정되어 있다.

```sh
# .env 에 APP_KEY 필요 (php artisan key:generate --show)
docker compose up -d --build      # http://localhost:8090 (PORT=… 로 변경)
docker compose down
```

PHP 패치가 나오면 `Dockerfile`의 `PHP_IMAGE` 태그만 올리고 다시 빌드.

캐시된 순위 새로고침: `php artisan cache:forget ctftime.team`
