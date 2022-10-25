# OMS Cetak Foto v1.0

## About

This web application is created by Fikri Miftah A. for Woowprint

This app is an Simple Order Management System developed with CodeIgniter 4 as main back-end framework & Bootstrap 5 as the main front-end kit

## Installation & Deployment Guide

- Extract the files
- Upload the files into your hosting server or put it inside `htdocs` folder of your local server (eg. XAMPP)
- Edit the base url configuration by open file `./app/Config/App.php` and edit `public $baseURL = 'http://localhost/woowprint/';`, change the `http://localhost/woowprint/` into application path, remember to put https instead of http if your server use ssl
- Import the `woowprint.sql` into your mysql database server
- Edit the `.env` file. On line 42 - 45 change the database credentials based on your database server configuration.
- Done

## Default Configuration

The default configuration for administrator login is
username : `admin`
password : `admin`

you can login with it and create your own credentials, after that you're free to delete it.

## Developer

- [Fikri Miftah Akmaludin](https://www.akuonline.my.id)
- [Github : vkr16](https://www.github.com/vkr16)
