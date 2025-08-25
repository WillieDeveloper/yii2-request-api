<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Basic Project Template</h1>
</p>

Yii 2 Basic Project Template based, Yii2 Request API

[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-basic.svg)](https://packagist.org/packages/yiisoft/yii2-app-basic)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-basic.svg)](https://packagist.org/packages/yiisoft/yii2-app-basic)
[![build](https://github.com/yiisoft/yii2-app-basic/workflows/build/badge.svg)](https://github.com/yiisoft/yii2-app-basic/actions?query=workflow%3Abuild)


Системные требования
------------
PHP 7.4
MySQL 8.0
Git
Composer

Установка
------------
Выполните клонирование проекта с GitHub:
~~~
git clone git@github.com:WillieDeveloper/yii2-request-api.git
~~~
Выполните установку зависимостей:
~~~
composer install
~~~

Выполните накатку миграций:
~~~
php yii migrate --migrationPath=@yii/rbac/migrations
php yii migrate
~~~


Доступные методы REST API
------------

Получение конкретного обращения по id, получение списка обращений с фильтрацией по полям
~~~
GET http://localhost/yii2-request-api/web/requests/{id}?username=&email=&status=&message=&comment=
~~~

Создание нового обращения с уникальной комбинацией username&email
~~~
POST http://localhost/yii2-request-api/web/requests
~~~
Body:
`{
"username": "Trevor",
"email": "t.sun@google.com",
"message": "Ooops"
}`

Редактирование существующего обращения
~~~
PUT|PATCH http://localhost/yii2-request-api/web/requests/17
~~~
Body:
``{
"comment":"Hi, i`ve just fixed that) EnjoY!",
"status": "Resolved"
}``

Удаление существующего обращения
~~~
DELETE http://localhost/yii2-request-api/web/requests/17
~~~

Получение заголовков ответа
~~~
OPTIONS|HEAD http://localhost/yii2-request-api/web/requests
~~~

Конфигурация
-------------
### БД
Создайте базу данных mysql с именем yii2_request_api, создайте и назначьте необходимые права пользователю и укажите
его данные для подключения вместо {DB_USER} и {DB_PASSWORD}

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2_request_api',
    'username' => '{DB_USER}',
    'password' => '{DB_PASSWORD}',
    'charset' => 'utf8',
];
```
