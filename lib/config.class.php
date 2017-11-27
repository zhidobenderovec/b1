<?php
//-- Параметры настроек приложения--
//--- Параметры соединения с базой данных---

class Config{
    protected  static $settings = array(); //----Настройки приложения в виде пар: Ключ-Значение

    public static  function  get($key)//----Получение значений хранимых в настройках
    {
        return isset(self::$settings[$key]) ? self::$settings[$key] : null;
    }

    public  static function  set($key, $value)//----Установка значений  настроек
    {
        self::$settings[$key] = $value;
    }
}

?>