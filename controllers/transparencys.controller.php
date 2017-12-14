<?php
//Контроллер сообщений.
//Выводит сообщения

class TransparencysController extends Controller
{
    public function __construct(array $data = array())
    {
        parent::__construct($data);
        $this->model = new Transparency();
    }

//Вывод и обработка формы логина
    public function yesbasket()
    {

    }

    public function errorbasket()
    {

    }


}