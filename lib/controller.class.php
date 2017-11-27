<?php

/**
 * Created by PhpStorm.
 * User: Wolf
 * Date: 04.10.2017
 * Time: 17:58
 */

//----Основной класс контроллера----
class Controller
{
    protected $data;

    protected $model;

    protected $params;

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    public  function __construct($data = array())
    {
        $this->data = $data;
        $this->params = App::getRouter()->getParams();
    }
}

?>