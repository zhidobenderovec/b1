<?php
//Контроллер страниц редактирования продуктов. Методы - по страницам
class ProductsController extends Controller
{
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Product();
    }

/*
//*Функция обслуживания просмотров страницы ???
    public function view()
    {
        $params = App::getRouter()->getParams();

        if (isset($params[0]))
        {
            $alias = strtolower($params[0]);
            //echo "Here will be a page with '{$alias}' alias.";
            $this->data['page'] = $this->model->getByAlias($alias);
        }

    }

*/  //Функция обслуживания страницы таблицы списка товаров admin_index.html
    public function admin_index()
    {
        //Возврат номера страницы пагинации по id  из URL
        $params_products = App::getRouter()->getParams();
        if (isset($params_products[1]))
        {

            $this->data['catalog_num'] = strtolower($params_products[1]);
        }

        //Возврат name_directory (каталога товаров) по id  из URL
        if (isset($params_products[2]))
        {

            $this->data['directory_num'] = strtolower($params_products[2]);

            $category_id = strtolower($params_products[2]);
            $this->data['dir_name'] = $this->model->getByCatalogIdName($category_id);
        }

        //Возврат суб name_directory (подкаталога товаров) по id  из URL
            if (isset($params_products[3]))
        {
            $this->data['subdirectory_num'] = strtolower($params_products[3]);

            $category_id = strtolower($params_products[3]);
            $this->data['subdir_name'] = $this->model->getByCatalogIdName($category_id);
        }

        if (isset($params_products[4]))
        //Возврат названия производителя по id  из URL
        {
            $this->data['brend_num'] = strtolower($params_products[4]);

            $brend_id = strtolower($params_products[4]);
            $this->data['brend_name'] = $this->model->getByBrendIdName($brend_id);
        }

        //Возврат названия поставщика по id  из URL
        if (isset($params_products[5]))
        {
            $this->data['provider_num'] = strtolower($params_products[5]);

            $provider_id = strtolower($params_products[5]);
            $this->data['provider_name'] = $this->model->getByProviderIdName($provider_id);
        }

        if (isset($params_products[6]))
        {

            $this->data['direction_num'] = strtolower($params_products[6]);
        }

        $this->data['pages'] = $this->model->getList();
        $this->data['directory'] = $this->model->getCatalog();
        $this->data['brend'] = $this->model->getBrend();
        $this->data['provider'] = $this->model->getProvider();
        $this->data['product'] = $this->model->getProduct();
        $this->data['increase'] = $this->model->getProductIncrease();
        $this->data['reduction'] = $this->model->getProductReduction();
    }

//Функция редактирования и записи товара
    public function admin_edit()
    {

        if ($_POST)
        {
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $result = $this->model->save($_POST, $id);
            if($result)
            {
                Session::setFlash('Pade was sawed.');
            }
            else
            {
                Session::setFlash('Error');
            }
            Router::redirect('/admin/products//1/0/0/0/0/0');//Было Router::redirect('/users/pages/');
        }

        if (isset($this->params[0]))
        {
            $this->data['product'] = $this->model->getByProductId($this->params[0]);
        }
        else
        {
            Session::setFlash('Wrong page id.');
            Router::redirect('/users/pages/');
        }
        $this->data['directory'] = $this->model->getCatalog();
        $this->data['brend'] = $this->model->getBrend();
        $this->data['provider'] = $this->model->getProvider();
    }

//Функция удаления товара
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
        Router::redirect('/admin/products//1/0/0/0/0/0');//Было Router::redirect('/users/pages/');
    }

//Функция добавление нового товара
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
            Router::redirect('/admin/products//1/0/0/0/0/0');//Было Router::redirect('/users/pages/');
        }
        $this->data['directory'] = $this->model->getCatalog();
        $this->data['brend'] = $this->model->getBrend();
        $this->data['provider'] = $this->model->getProvider();
    }

}

?>