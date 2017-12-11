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
}

?>