<!-- PROJECT LOGO -->
<br />
<p align="center">
  <h3 align="center">Тестовое задание Simtech</h3>
</p>



<!-- TABLE OF CONTENTS -->
## Table of Contents

* [About the Project](#about-the-project)
  * [Built With](#built-with)
* [Getting Started](#getting-started)
  * [Prerequisites](#prerequisites)
  * [Installation and Start](#installation-and-start)
* [Known Bugs](#known-bugs)

<!-- ABOUT THE PROJECT -->
## About The Project

В рамках данного тестового задания реализована система обработки входящих сообщений из третье-стороннего сервиса по API. Система работает по принципу “принял запрос - сгенерировал ID задачи, положил в очередь на выполнение - система выполнила задачу и обновила статус“.
| URL | METHOD | REQUEST DATA (key: value type) | RESPONSE DATA (key: value type) | DESCRIPTION |
| --- | --- | --- | --- | --- |
| task/fib | PUT | int: integer<br/>api_token: string | task_id: integer | Создаёт задачу на вычисление ряда фибоначи |
| task/ip | PUT | ip: string<br/>api_token: string | task_id: integer | Создаёт задачу на определение ispname |
| status/{id} | GET | api_token: string | fibonacci_sequence: int[], если задача фибоначи<br/>ispname: string[], если задача ispname | Выгружает результат задачи из БД (и также удаляет его, в случае успешного завершения) |
| user/register | POST | name: string<br/>email: string<br/>password: string<br/>password_confirmation: string | api_token: string | Регистрирует нового пользователя |
| user/login | POST | email: string<br/>password: string | api_token: string | Войти под пользователем (по факту получить api_token) |

### Built With
* [Laravel](https://laravel.com)

<!-- GETTING STARTED -->
## Getting Started

### Prerequisites
* composer https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos

### Installation and Start
1. Клонировать репозиторий
```sh
git clone https://github.com/NA-Dronov/simtech-test.git
```
2. В папке проекта. Установить зависимости, используя composer
```sh
composer install
```
3. Создаем БД для приложения (описывать процесс создания, я полагаю, смысла нет)
4. В папке проекта. Создаем копию .env.example и переименовываем в .env, прописываем там параметры для соединения с созданной БД
5. В папке проекта. Генерируем APP_KEY
```sh
php artisan key:generate
```
6. В папке проекта. Применяем миграции
```sh
php artisan migrate
```
7. В папке проекта. Для запуска проекта выполнить следующую команду
```sh
php artisan serve
```
8. В папке проекта. Для запуска обработчика очередей
```sh
php artisan queue:listen
```


<!-- Known Bugs -->
## Known Bugs

При долгой обработке задачи (например > 30сек.) возникнет исключение ProcessTimedOutException и обработчик очереди перестаёт работать.
Возможные варианты решения:
* Увеличить значение timeout для очереди или выставить значение в 0
```sh
php artisan queue:listen --timeout=1200
```
* Выставить timeout для конкретных задач (в laravel 6 не работает)
```
public $timeout = 1200;
```
* Использовать супервизор