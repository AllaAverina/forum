<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Форум
Создание минимально жизнеспособного форума в учебных целях.

## Функционал
* Просмотр списков всех тем, постов и пользователей
* Поиск в списках
* Регистрация пользователя
* Зарегистрированный пользователь может:
    * Отредактировать информацию профиля и сменить пароль
    * Добавить новые темы и посты
    * Прокомментировать существующие посты
    * Удалить и отредактировать свои темы, посты и комментарии
* Форум поддерживает русский и английский языки интерфейса

## Требования
* [PHP 8.1+](https://www.php.net/)
* [Laravel 10](https://laravel.com/)
* [Composer](https://getcomposer.org/)
* [MySQL](https://www.mysql.com/)

## Запуск
1. Клонируйте этот репозиторий и перейдите в папку проекта:
```sh
git clone https://github.com/AllaAverina/forum
cd forum
```
2. Установите зависимости:
```sh
composer install
```
3. Запустите MySQL, измените параметры для подключения к базе данных и локализации в файле .env.example и выполните:
```sh
cp .env.example .env
```
Пример настроек для русского языка:
```sh
FAKER_LOCALE=ru_RU
APP_LOCALE=ru
APP_TIMEZONE=Europe/Moscow
```
4. Выполните команду для запуска миграций:
```sh
php artisan migrate
```
Или если хотите заполнить базу данных фиктивными данными:
```sh
php artisan migrate --seed
```
5. Запустите веб-сервер:
```sh
php artisan serve
```
6. Откройте в браузере http://localhost:8000/