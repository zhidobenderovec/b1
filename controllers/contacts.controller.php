<?php
//Контроллер контактов. Методы - по страницам
class ContactsController extends Controller
{
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Message();
    }

    public function index()
    {
        if ($_POST)
        {
            if ($this->model->save($_POST))
            {
                Session::setFlash(__('lng.thanks'));
            }
        }
    }

    public function admin_index()
    {
        $this->data =$this->model->getList();

        $params_list = App::getRouter()->getParams();
        if (isset($params_list[0]))
        {
            $this->data['page_namber'] = strtolower($params_list[0]);
        }
    }
    }

?>