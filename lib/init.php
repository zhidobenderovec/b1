<?php
//--Доступ всего кода к настройкам сайта--

require_once (ROOT.DS.'config'.DS.'config.php');

//----Подключаем файл работы с Excel ----
require_once (ROOT.DS.'Classes'.DS.'PHPExcel.php'); // Подключаем библиотеку PHPExcel
//----Подключаем файл работы с Excel ----
require_once (ROOT.DS.'Rembish'.DS.'PHPrar.php'); // Подключаем библиотеку PHPrar (создание rar-архива)
//----Правила наименования файлов----
function __autoload($class_name)
{
    $lib_path  = ROOT.DS.'lib'.DS.strtolower($class_name).'.class.php';
    $controllers_path  = ROOT.DS.'controllers'.DS.str_replace( 'controller', '', strtolower($class_name)).'.controller.php';
    $model_path  = ROOT.DS.'models'.DS.strtolower($class_name).'.php';

    if (file_exists($lib_path))
    {
        require_once ($lib_path);
    }
    elseif (file_exists($controllers_path))
    {
        require_once ($controllers_path);
    }
    elseif (file_exists($model_path))
    {
        require_once ($model_path);
    }
    else
    {
        throw new Exception('Не удалось включить класс - Failed to include class: '.$class_name);
    }
}

function __($key, $default_value = '')
{
    return Lang::get($key, $default_value);
}

?>