# Tanuki Test Project

## Запуск проекта

1. Копируем файл окружения
```bash
cp .env.example .env
```

2. Запускаем Docker контейнеры
```bash
docker compose up -d
```

3. Устанавливаем зависимости
```bash
docker compose exec php php artisan composer install
```

4. Запускаем миграции
```bash
docker compose exec php php artisan migrate
```

5. Генерируем документацию Swagger
```bash
docker compose exec php php artisan l5-swagger:generate
```

## Документация API

Swagger UI доступен по адресу: [http://localhost:8000](http://localhost:8000)
