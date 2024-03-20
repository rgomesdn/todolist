<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About TODO LIST

​TODO LIST is a web application framework created with Laravel framework and with Admin Lte that makes it simple and elegant. I published it on github as a public project, the intention is that other developers who have any difficulties or even want to take advantage of the project, can do so.
I already make it clear that, with absolute certainty, there are many points to improve and others that can even be changed with better techniques.
Here are some features already implemented:

- Multiple language
- Web and api version
- Web with basic authentication
- Api with sanctum authentication
- Sqlite database
- PHP unit
- Admin Lte for the frontend

## Attention Points

Implemented middleware that allows a task to be updated or deleted only by the user who created it. (Can also be done with Policy)

## To change the project(brand) name, follow the steps below

- Open the .env file in the project root, and change the line **_APP_NAME=TODO_LIST_**  to  **_APP_NAME=YOUR_NAME_**

## To execute the project, follow the steps below

- Open the terminal, access the project folder and run the command **_composer install_**
- Duplicate the **_.env.example_** file and rename it to **_.env_**
- Change the line **_DB_CONNECTION=mysql_** to **_DB_CONNECTION=sqlite_**
- Delete the following lines:
     - DB_HOST=127.0.0.1
     - DB_PORT=3306
     - DB_DATABASE=laravel
     - DB_USERNAME=root
     - DB_PASSWORD=

- Still in the terminal, run the command **_php artisan key:generate_**
- Still in the terminal, run the command **_npm install_**
- Still in the terminal, run the command **_npm run build_**
- Still in the terminal, run the command **_php artisan serve_**
- To run tests with phpunit. Still in the terminal, run the command **_php artisan test_**

