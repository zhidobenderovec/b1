<?php
//Контроллер страниц редактирования продуктов. Методы - по страницам
class BasketsController extends Controller
{
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Basket();
    }

    //Функция обслуживания корзины index.html
    public function index()
    {
        if ($_POST)
        {
            $buy = isset($_POST['buy']) ? (int)($_POST['buy']) : null;
            if(($buy) && (($_POST['email']) || ($_POST['phone'])))
            {
                $this->data['product'] = $this->model->getProduct();

                $total_cost = 0;//сумма
                $array[0] = 0;
                $application[0] = 0;//массив заказа
                //$this->data['product'] = $this->model->getProduct();
                foreach (($this->data['product']) as $thing)
                {
                    $id_pieces = $thing['id_product'];
                    if (isset($_COOKIE[$id_pieces]))
                    {

                        $quantity = htmlspecialchars($_COOKIE[$id_pieces]);
                        $application[$id_pieces] = $quantity;//в массив
                        $total_cost = $total_cost + $quantity * $thing['price'];
                    }
                }

                $array['ordered'] = serialize( $application );//массив преобразовавается в строку
                $array['name'] = isset($_POST['name']) ? ($_POST['name']) : 0;
                $array['id'] = isset($_POST['id']) ? (int)($_POST['id']) : 0;
                $array['email'] = isset($_POST['email']) ? ($_POST['email']) : 0;
                $array['phone'] = isset($_POST['phone']) ? ($_POST['phone']) : 0;
                $array['city'] = isset($_POST['city']) ? ($_POST['city']) : 0;
                $array['amount'] = $total_cost;

                $result = $this->model->save($array);

                if ($result)
                {
                    Session::setFlash('Pade was sawed.');
                    Router::redirect('/transparencys/yesbasket/');//
                }
                else
                {
                    Session::setFlash('Error');
                    Router::redirect('/transparencys/errorbasket/');//
                }
            }
            else
            {
                Router::redirect('/transparencys/errorbasket/');//
            }

        }
        $this->data['directory'] = $this->model->getCatalog();
        $this->data['product'] = $this->model->getProduct();
    }

    //Функция удаления товара из корзины
    public function delete()
    {

        if (isset($this->params[0]))
        {
            $id = ($this->params[0]);

            if($id)
            {
                $id_pieces = $id;//id товара we
                $pieces = 0;// количество товара er
                setcookie($id_pieces, $pieces, 10, '/');

                Session::setFlash('Product was deleted of in the basket.');
                //Возврат на предыдущую страницу, с которой был запрос в корзину
                Router::redirect('/baskets/');//Было Router::redirect('/users/pages/');

            }

        }
    }

    //Функция удаления всех товаров из корзины
    public function deleteall()
    {
        $this->data['product'] = $this->model->getProduct();

        foreach (($this->data['product']) as $thing)
        {
            $id_pieces = $thing['id_product'];
            if (isset($_COOKIE[$id_pieces]))
            {

                $pieces = 0;// количество товара er
                setcookie($id_pieces, $pieces, 10, '/');

            }

        }
        Session::setFlash('Products was deleted of in the basket.');
        //Возврат на предыдущую страницу, с которой был запрос в корзину
       Router::redirect('/baskets/');//Было Router::redirect('/users/pages/');
    }


    //Функция увеличения количества товара в корзине
    public function enlarge()
    {
        if (isset($this->params[0]))
        {
            $id = ($this->params[0]);

            if ($id)
            {
                $id_pieces = $id;//id товара
                $pieces = ($_COOKIE[$id_pieces]) + 1;// количество товара

                // проверка на превышение количества товара//
                $quantity = $this->model->getByProductId($id_pieces);
                if ($pieces > $quantity['quantity'])
                {
                    $pieces = $quantity['quantity'];
                }
                setcookie($id_pieces, $pieces, 0, '/');

                Session::setFlash('Product in the basket enlarge.');
                //Возврат на предыдущую страницу, с которой был запрос в корзину
                header("Location: {$_SERVER['HTTP_REFERER']}");
                exit;
            }
        }
    }

    //Функция уменьшения количества товара в корзине
    public function reduce()
    {
        if (isset($this->params[0]))
        {
            $id = ($this->params[0]);

            if ($id)
            {
                $id_pieces = $id;//id товара
                $pieces = ($_COOKIE[$id_pieces]) - 1;// количество товара

                // проверка на количества товара меньше 1//
                if ($pieces <= 1)
                {
                    $pieces = 1;
                }
                setcookie($id_pieces, $pieces, 0, '/');

                Session::setFlash('Product in the basket reduce.');
                //Возврат на предыдущую страницу, с которой был запрос в корзину
                header("Location: {$_SERVER['HTTP_REFERER']}");
                exit;
            }
        }
    }

    //Функция уменьшения количества товара в корзине
    public function personal()
    {

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

      //Функция обслуживания страницы таблицы списка товаров admin_index.html
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
*/
}

?>