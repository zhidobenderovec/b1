<?php
//Контроллер контактов. Методы - по страницам
class InformationsController extends Controller
{
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Information();
    }

    public function index()
    {
        $this->data['shares'] = $this->model->getShares();
    }

    //Функция показа страницы Доставка и оплата
    public function payment()
    {
        $this->data['information'] = $this->model->getInformationId(1);
    }

    //Функция показа страницы Гарантия
    public function guarantee()
    {
        $this->data['information'] = $this->model->getInformationId(2);
    }


    //Функция показа страницы Продавать с нами
    public function sell()
    {
        $this->data['information'] = $this->model->getInformationId(3);
    }

    //Функция показа страницы О нас
    public function about_us()
    {
        $this->data['information'] = $this->model->getInformationId(4);
    }

    //Функция показа страницы Возврат товара
    public function returns()
    {
        $this->data['information'] = $this->model->getInformationId(5);
    }

    //Функция показа страницы Условия использования сайта
    public function conditions()
    {
        $this->data['information'] = $this->model->getInformationId(6);
    }

    //Функция списка страниц информации
    public function admin_index()
    {
        $this->data['shares'] = $this->model->getShares();
    }


//Функция редактирования акции
    public function admin_shares()
    {
        if ($_POST)
        {

            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $result = $this->model->save_shares($_POST, $id);
            if($result)
            {
                Session::setFlash('Action was sawed.');
            }
            else
            {
                Session::setFlash('Error');
            }
            Router::redirect('/admin/informations/');//Было Router::redirect('/users/pages/');
        }

        $this->data['shares'] = $this->model->getShares();

    }

//Функция добавление новой акции сообщения
    public function admin_addshares()
    {

        $result = $this->model->save_addshares();
        if($result)
        {
            Session::setFlash('Action was sawed.');
        }
        else
        {
            Session::setFlash('Error');
        }
        Router::redirect('/admin/informations/shares');//Было Router::redirect('/users/pages/');


    }
    //Функция удаления акции
    public function admin_deleteshares()
    {
        if (isset($this->params[0]))
        {
            $result = $this->model->deleteshares($this->params[0]);
            if ($result)
            {
                Session::setFlash('Action was deleted.');
            }
            else
            {
                Session::setFlash('Error.');
            }
        }
        Router::redirect('/admin/informations/shares');//Было Router::redirect('/users/pages/');
    }

//Функция редактирования информации
    public function admin_edit()
    {
        if ($_POST)
        {

            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $result = $this->model->save($_POST, $id);
            if($result)
            {
                Session::setFlash('Information was sawed.');
            }
            else
            {
                Session::setFlash('Error');
            }
            Router::redirect('/admin/informations/');//Было Router::redirect('/users/pages/');
        }

        if (isset($this->params[0]))
        {
            //$ $this->data['iformation'] = $this->model->getInformationId($this->params[0]);
          // $ $this->data['iformation'] = $this->model->getInformationId(1);
            $this->data['information'] = $this->model->getInformationId($this->params[0]);

        }
        else
        {
            Session::setFlash('Wrong information id.');
            Router::redirect('/users/pages/');
        }

    }




/*
//Функция редактирования сообщения
    public function admin_addshares()
    {
        if ($_POST)
        {
            $data['name'] = "Пустой";
            $data['body'] = "Пустой";
            $data['img'] = "no";
            $data['date_e'] = "2000-01-01";
            $result = $this->model->save_shares($_POST);
            if($result)
            {
                Session::setFlash('Action was sawed.');
            }
            else
            {
                Session::setFlash('Error');
            }
            Router::redirect('/admin/informations/');//Было Router::redirect('/users/pages/');
        }

        $this->data['shares'] = $this->model->getShares();

    }


*/






























public function admin_about_us()
{
    if ($_POST)
    {
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $result = $this->model->save($_POST, $id);
        if($result)
        {
            Session::setFlash('Message was sawed.');
        }
        else
        {
            Session::setFlash('Error');
        }
        Router::redirect('/admin/contacts//1');//Было Router::redirect('/users/pages/');
    }
    //$this->data =$this->model->getList();
    if (isset($this->params[0]))
    {
        $this->data['messages_namber'] = $this->model->getByMessadeId($this->params[0]);
    }
    else
    {
        Session::setFlash('Wrong messages id.');
      // Router::redirect('/users/pages/');
    }

    $this->data['users'] = $this->model->getUsers();
    $this->data['messages'] = $this->model->getMessages();


}

    /*
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
            //$this->data =$this->model->getList();

            $params_list = App::getRouter()->getParams();
            if (isset($params_list[1]))
            {
                $this->data['page_number'] = strtolower($params_list[1]);
            }
            $this->data['users'] = $this->model->getUsers();
            $this->data['messages'] = $this->model->getMessages();
        }

        //Функция редактирования сообщения
        public function admin_edit()
        {
            if ($_POST)
            {
                $id = isset($_POST['id']) ? $_POST['id'] : null;
                $result = $this->model->save($_POST, $id);
                if($result)
                {
                    Session::setFlash('Message was sawed.');
                }
                else
                {
                    Session::setFlash('Error');
                }
                Router::redirect('/admin/contacts//1');//Было Router::redirect('/users/pages/');
            }
            //$this->data =$this->model->getList();
            if (isset($this->params[0]))
            {
                $this->data['messages_namber'] = $this->model->getByMessadeId($this->params[0]);
            }
            else
            {
                Session::setFlash('Wrong messages id.');
                Router::redirect('/users/pages/');
            }

            $this->data['users'] = $this->model->getUsers();
            $this->data['messages'] = $this->model->getMessages();
        }

    //*Функция удаления сообщения
        public function admin_delete()
        {
            if (isset($this->params[0]))
            {
                $result = $this->model->delete($this->params[0]);
                if ($result)
                {
                    Session::setFlash('Messages was deleted.');
                }
                else
                {
                    Session::setFlash('Error_admin_delete.');
                }
            }
            Router::redirect('/admin/contacts//1');//
        }



    */
}

?>
