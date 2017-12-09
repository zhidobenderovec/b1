<?php
//Контроллер страниц редактирования каталогов. Методы - по страницам
class CatalogsController extends Controller
{
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Catalog();
    }

  //*Функция обслуживания страницы таблицы каталогов admin_index.html+++
    public function admin_index()
    {
        $params_products = App::getRouter()->getParams();
        //Возврат name_directory (каталога товаров) по id  из URL+++
        if (isset($params_products[1]))
        {

            $this->data['directory_num'] = strtolower($params_products[1]);

            $category_id = strtolower($params_products[1]);
            $this->data['dir_name'] = $this->model->getByCatalogIdName($category_id);
        }

        $this->data['product'] = $this->model->getProduct();
        $this->data['pages'] = $this->model->getList();
        $this->data['directory'] = $this->model->getCatalog();
    }

//*Функция редактирования и записи каталогов
    public function admin_edit()
    {

        if ($_POST)
        {
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $result = $this->model->save($_POST, $id);
            if($result)
            {
                Session::setFlash('Direct was sawed.');
            }
            else
            {
                Session::setFlash('Error');
            }
            Router::redirect('/admin/catalogs//0');//Было Router::redirect('/users/pages/');
        }

        if (isset($this->params[0]))
        {
            $this->data['catalog'] = $this->model->getByCatalogId($this->params[0]);
        }
        else
        {
            Session::setFlash('Wrong page id.');
            Router::redirect('/users/pages/');
        }
        $this->data['directory'] = $this->model->getCatalog();
    }

//*Функция  записи каталогов
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
            Router::redirect('/admin/catalogs//0');//Было Router::redirect('/users/pages/');
        }
        $this->data['directory'] = $this->model->getCatalog();
    }

//*Функция удаления каталогов
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
        Router::redirect('/admin/catalogs//0');//Было Router::redirect('/users/pages/');
    }
}

?>