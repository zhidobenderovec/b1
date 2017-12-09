<?php
//Контроллер страниц редактирования поставщиков. Методы - по страницам
class ProvidersController extends Controller
{
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Provider();
    }

    //*Функция обслуживания страницы таблицы производителей admin_index.html
    public function admin_index()
    {


        $this->data['product'] = $this->model->getProduct();
        $this->data['provider'] = $this->model->getProvider();
    }

//Функция редактирования и записи производителей
    public function admin_edit()
    {

        if ($_POST)
        {


            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $result = $this->model->save($_POST, $id);
            if($result)
            {
                Session::setFlash('Brend was sawed.');
            }
            else
            {
                Session::setFlash('Error');
            }
            Router::redirect('/admin/providers');//Было Router::redirect('/users/pages/');
        }

        if (isset($this->params[0]))
        {
            $this->data['speculator'] = $this->model->getByProviderId($this->params[0]);
        }
        else
        {
            Session::setFlash('Wrong provider id.');
            Router::redirect('/users/pages/');
        }
        $this->data['provider'] = $this->model->getProvider();
    }

//*Функция  записи нового производителя
    public function admin_add()
    {
        if ($_POST)
        {
            $result = $this->model->save($_POST);
            if($result)
            {

                Session::setFlash('Provider was sawed.');
            }
            else
            {
                Session::setFlash('Error');
            }
            Router::redirect('/admin/providers');//
        }

    }

//*Функция удаления производителя
    public function admin_delete()
    {
        if (isset($this->params[0]))
        {
            $result = $this->model->delete($this->params[0]);
            if ($result)
            {
                Session::setFlash('Provider was deleted.');
            }
            else
            {
                Session::setFlash('Error_admin_delete.');
            }
        }
        Router::redirect('/admin/providers');//Было Router::redirect('/users/pages/');
    }
}

?>