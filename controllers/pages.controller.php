<?php
//Контроллер страниц. Методы - по страницам
class PagesController extends Controller
{
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Page();
    }



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
        //10 самых посещаемых товаров (views)
        $this->data['top'] = $this->model->getProductTop();


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

    public function admin_index()
    {
        $this->data['pages'] = $this->model->getList();
        $this->data['messages'] = $this->model->getMessages();
        $this->data['users'] = $this->model->getUsers();
        $this->data['orders'] = $this->model->getOrders();
    }

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
        if ($_POST)
        {

            // $id = isset($_COOKIE['id']) ? (int)($_COOKIE['id']) : 0;
            $id = isset($_POST['id']) ? (int)($_POST['id']) : null;
            if($id)
            {
                $inquiry = isset($_POST['quantity']) ? (int)($_POST['quantity']) : 0;
                //$quantity = isset($_COOKIE['quantity']) ? (int)($_COOKIE['quantity']) : 0;
                // unset($_POST);//Очистка _POST

                $id_pieces = $id;//id товара we

                $pieces = $inquiry + ($_COOKIE[$id_pieces]);// количество товара er

                // проверка на превышение количества товара.//
                $quantity = $this->model->getByProductId($id_pieces);
                if ($pieces > $quantity['quantity'])
                {
                    $pieces = $quantity['quantity'];
                }

                setcookie($id_pieces,$pieces,0,'/');
                // setcookie("1", $quantity,time()+3600*2, '/');

                //if($id)
                // {

                Session::setFlash('Product in the basket.');
                //Возврат на предыдущую страницу, с которой был запрос в корзину
                header("Location: {$_SERVER['HTTP_REFERER']}");
                exit;
                //Router::redirect('/pages/product/2');//Было Router::redirect('/users/pages/');
            }

        }

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
        if ($_POST)
        {

           // $id = isset($_COOKIE['id']) ? (int)($_COOKIE['id']) : 0;
            $id = isset($_POST['id']) ? (int)($_POST['id']) : null;
            if($id)
            {
            $inquiry = isset($_POST['quantity']) ? (int)($_POST['quantity']) : 0;
            //$quantity = isset($_COOKIE['quantity']) ? (int)($_COOKIE['quantity']) : 0;
           // unset($_POST);//Очистка _POST

            $id_pieces = $id;//id товара we

            $pieces = $inquiry + ($_COOKIE[$id_pieces]);// количество товара er

            // проверка на превышение количества товара.//
            $quantity = $this->model->getByProductId($id_pieces);
            if ($pieces > $quantity['quantity'])
            {
                $pieces = $quantity['quantity'];
            }

            setcookie($id_pieces,$pieces,0,'/');
               // setcookie("1", $quantity,time()+3600*2, '/');

            //if($id)
           // {

                Session::setFlash('Product in the basket.');
                //Возврат на предыдущую страницу, с которой был запрос в корзину
                header("Location: {$_SERVER['HTTP_REFERER']}");
                exit;
                //Router::redirect('/pages/product/2');//Было Router::redirect('/users/pages/');
            }

        }



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

    public function save()////////Почему save!!!!!!!!!!!!!!!!!!
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
}

?>