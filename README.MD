# REST API для работы с пользователями на нативном PHP

## Описание
REST API для работы с пользователями. Реализованы функции:
- Регистрация пользователя
- Авторизация пользователя
- Получение информации о пользователе
- Обновление данных пользователя
- Удаление пользователя

## Структура проекта
```
/public
│── DB.php   # Класс для работы с базой данных
│── User.php       # Класс для работы с пользователями
│── Api.php        # Основной API-контроллер
│── .htaccess      # Настройки перезаписи URL для Apache
│── README.md      # Описание проекта
```


## Использование API

### Регистрация пользователя
**POST /register**
```json
{
    "username": "JonhDoe",
    "password": "123456"
}
```

### Авторизация пользователя
**POST /login**
```json
{
    "username": "JonhDoe",
    "password": "123456"
}
```

### Получение информации о пользователе
**GET /user/{id}**

```json
{
    "id": 1,
    "username": "JonhDoe"
}
```

### Обновление данных пользователя
**PUT /user/{id}**
```json
{
    "username": "DonhJoe"
}
```

### Удаление пользователя
**DELETE /user/{id}**

## Установка

### 1. Создание базы данных
Для работы с API нужно создать базу данных и добавить в неё таблицу 'users'
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(50) NOT NULL
);
```

### 2. Настройка подключения к БД
В файле `DB.php` указать данные для подключения к базе данных:

### 3. Настройка Apache (.htaccess)
Настроить `.htaccess` файл в корневой папкек проекта для включения `mod_rewrite` и маршрутизации запросов:
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.+)$ index.php?q=$1 [L,QSA]
```


