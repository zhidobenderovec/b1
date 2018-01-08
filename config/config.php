<?php
//--Основной конфигурационный файл--

Config::set('site_name', '"Электрозенит"'); //Your Site Name

Config::set('languages', array('en','ru'));//-----Было Config::set('languages', array('en','fr'))

//Routes. Route name => method prefix--Определение вывода страниц:обычнае или для администратора
Config::set('routes', array(
    'default' => '',
    'manager' => 'manager_',
    'admin' => 'admin_',
));
//----Мой, начало------------
//-----Было Config::set('catalog', 'MVC');
//----Мой, окончание------------

Config::set('default_route', 'default');//Роут по умолчанию
Config::set('default_language', 'ru');  //Язык по умолчанию
Config::set('default_controller', 'pages');//Контролллер по умолчанию
Config::set('default_action', 'index');//Метод по умолчанию
//Config::set('default_pagination', '');//Страница по умолчанию!!!!!!!!!!!!!!!!!!!!!!!!



Config::set('db.host', 'localhost');
Config::set('db.user', 'root');
Config::set('db.password', '');
//Config::set('db.db_name', 'hippo');//Имя БД
Config::set('db.db_name', 'baraxolka');//Имя БД

Config::set('salt', 'ugj53dlut4zow2flh8xl982g');

?>