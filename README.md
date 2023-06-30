<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Форум
Создание минимально жизнеспособного форума в учебных целях.

## Функционал
* Просмотр списков всех тем, постов и пользователей
* Поиск в списках и их сортировка
* Регистрация пользователя
* Зарегистрированный пользователь может:
    * Отредактировать информацию профиля и сменить пароль
    * Добавить новые темы и посты
    * Прокомментировать существующие посты
    * Удалить и отредактировать свои темы, посты и комментарии
* Администратор может назначить любого зарегистрированного пользователя модератором и снять с должности любого модератора
* Модератор может удалить любые темы, посты и комментарии без возможности восстановления
* Форум поддерживает русский и английский языки интерфейса

## Требования
* [PHP 8.1+](https://www.php.net/)
* [Laravel 10](https://laravel.com/)
* [Composer](https://getcomposer.org/)
* [MySQL](https://www.mysql.com/)
* [Node.js](https://nodejs.org/)

## Запуск
1. Клонируйте этот репозиторий и перейдите в папку проекта:
```sh
git clone https://github.com/AllaAverina/forum
cd forum
```
2. Установите зависимости:
```sh
composer install
npm install
npm run build
```
3. Запустите MySQL, измените параметры для подключения к базе данных и локализации в файле .env.example и выполните:
```sh
cp .env.example .env
```
Пример настроек для русского языка:
```sh
FAKER_LOCALE=ru_RU
APP_LOCALE=ru
```
4. Сгенерируйте ключ приложения:
```sh
php artisan key:generate
```
5. Выполните команду для запуска миграций:
```sh
php artisan migrate
```
Или если хотите заполнить базу данных фиктивными данными:
```sh
php artisan migrate --seed
```
6. Запустите веб-сервер:
```sh
php artisan serve
```
7. Откройте в браузере http://localhost:8000/

## Запуск тестов
1. Создайте новую базу данных для тестирования, измените параметры для подключения к ней в файле .env.testing и сгенерируйте ключ:
```sh
php artisan key:generate --env=testing
```
2. Затем выполните:
```sh
php artisan test 
```