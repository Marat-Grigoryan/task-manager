# task management

## local setup

```bash
 cp .env.example .env
```

```bash
 cp .docker/docker-compose.override.yml.example .docker/docker-compose.override.yml
```

```bash
 cd .docker
```

```bash
 docker-compose up -d
```

```bash
 sh deploy.sh
```

### application starts at

 http://127.0.0.1:8000


```bash
 docker exec task-management php artisan passport:keys
```

```bash
 docker exec task-management php artisan passport:client --password
```
- client id and client secret will be generated use them to get the access token

## testing
```bash
 cp .env.testing.example .env.testing
```
```bash
 docker exec task-management php artisan migrate --env=testing
```
```bash
 docker exec task-management php artisan test
```

## api documentation
https://documenter.getpostman.com/view/3660475/2sA3BkctH2

## mailcatcher
 http://127.0.0.1:1080/

## commands

### send overdue task notification
```bash
 docker exec task-management php artisan app:send-overdue-task-notification
```