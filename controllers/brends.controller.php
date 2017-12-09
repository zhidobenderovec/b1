<?php
//Контроллер страниц редактирования производителей. Методы - по страницам
class BrendsController extends Controller
{
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Brend();
    }

    //*Функция обслуживания страницы таблицы производителей admin_index.html
    public function admin_index()
    {


        $this->data['product'] = $this->model->getProduct();
        $this->data['brend'] = $this->model->getBrend();
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
            Router::redirect('/admin/brends');//Было Router::redirect('/users/pages/');
        }

        if (isset($this->params[0]))
        {
            $this->data['manufactory'] = $this->model->getByBrendId($this->params[0]);
        }
        else
        {
            Session::setFlash('Wrong page id.');
            Router::redirect('/users/pages/');
        }
        $this->data['brend'] = $this->model->getBrend();
    }

//*Функция  записи нового производителя
    public function admin_add()
    {
        if ($_POST)
        {
            $result = $this->model->save($_POST);
            if($result)
            {

                Session::setFlash('Page was sawed.');
            }
            else
            {
                Session::setFlash('Error');
            }
            Router::redirect('/admin/brends');//
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
                Session::setFlash('Product was deleted.');
            }
            else
            {
                Session::setFlash('Error_admin_delete.');
            }
        }
        Router::redirect('/admin/brends');//Было Router::redirect('/users/pages/');
    }
}

?>