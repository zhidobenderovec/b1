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

    public function index()
    {
        // echo 'Here will be a pages list';
        //$this->data['pages'] = $this->model->getList();
        //$this->data['max5id'] = $this->model->getMax_5id();
        //$this->data['visits'] = $this->model->getListStat();
        //!!! $this->data['card'] = $this->model->getLocation();//БД Локации
        $this->data['stock'] = $this->model->getShares();//БД Акций
        $this->data['directory'] = $this->model->getCatalog();
        $this->data['product'] = $this->model->getProduct();

    }

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
*/  //*Функция обслуживания страницы таблицы списка товаров admin_index.html
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

    }
/*
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
            Router::redirect('/admin/pages/');//Было Router::redirect('/users/pages/');
        }
    }

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
            Router::redirect('/admin/pages/');//Было Router::redirect('/users/pages/');
        }

        if (isset($this->params[0]))
        {
            $this->data['page'] = $this->model->getById($this->params[0]);
        }
        else
        {
            Session::setFlash('Wrong page id.');
            Router::redirect('/users/pages/');
        }
    }

    public function admin_delete()
    {
        if (isset($this->params[0]))
        {
            $result = $this->model->delete($this->params[0]);
            if ($result)
            {
                Session::setFlash('Page was deleted.');
            }
            else
            {
                Session::setFlash('Error.');
            }
        }
        Router::redirect('/admin/pages/');//Было Router::redirect('/users/pages/');
    }

    public function news_list()
    {
        $this->data['pages'] = $this->model->getList();

        //Установка сатегории страницы для просмотра
        $params_list = App::getRouter()->getParams();

        if (isset($params_list[0]))
        {
            $category = strtolower($params_list[0]);
            $this->data['categories'] = $this->model->getByCategory($category);
        }
        //Установка номера страницы для пагинации
        if (isset($params_list[1]))
        {
            $this->data['page_namber'] = strtolower($params_list[1]);
        }
    }

    public function news_page()
    {
        //Установка  страницы для просмотра
        $params = App::getRouter()->getParams();

        if (isset($params[0]))
        {
            $this->data['page'] = $this->model->getById($this->params[0]);
        }
        $this->data['visits'] = $this->model->getListStat();

    }

    public function catalog()
    {
        //Установка страницы категории для просмотра
        $params_catalog = App::getRouter()->getParams();
        //directory/subdirectory
        if (isset($params_catalog[0]))
        {
            $category_id = strtolower($params_catalog[0]);
            $this->data['catalog'] = $this->model->getByCatalogId($category_id);
        }
        //page number of the page being viewed Установка номера страницы для пагинации
        if (isset($params_catalog[1]))
        {

            $this->data['catalog_num'] = strtolower($params_catalog[1]);
        }
        $this->data['directory'] = $this->model->getCatalog();
        $this->data['product'] = $this->model->getProduct();
    }

    public function product()
    {
        //Установка страницы товара для просмотра
        $params_product = App::getRouter()->getParams();

        if (isset($params_product[0]))
        {
            $product_id = strtolower($params_product[0]);
            $this->data['exemplar'] = $this->model->getByProductId($product_id);
        }
        $this->data['directory'] = $this->model->getCatalog();
        $this->data['product'] = $this->model->getProduct();
    }

    public function admin_product()
    {

        $this->data['directory'] = $this->model->getCatalog();
        $this->data['product'] = $this->model->getProduct();

    }
*/
}

?>