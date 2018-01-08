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

                        //Очистка COOKIE
                        $pieces = 0;// количество товара er
                        setcookie($id_pieces, $pieces, 10, '/');
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

    //Функция удаления позиции товара из корзины
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
                //Router::redirect('/baskets/');//Было Router::redirect('/users/pages/');
                header("Location: {$_SERVER['HTTP_REFERER']}");

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
       //Router::redirect('/baskets/');//Было Router::redirect('/users/pages/');
        header("Location: {$_SERVER['HTTP_REFERER']}");
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
                header("Location: {$_SERVER['HTTP_REFERER']}");//возврат назад
                exit;
            }
        }
    }

    //Функция уменьшения количества товара в корзине
    public function personal()
    {
        $params_products = App::getRouter()->getParams();
        if (isset($params_products[0]))
        {

            $this->data['costomer_num'] = strtolower($params_products[0]);
        }

        $this->data['product'] = $this->model->getProduct();
        $this->data['directory'] = $this->model->getCatalog();
        $this->data['orders'] = $this->model->getOrders();

        $id_costomer = Session::get('id');
        $this->data['users_order'] = $this->model->getUsersOrder($id_costomer);
    }

    //Функция работы с заявками
    public function admin_index()
    {

        $this->data['orders'] = $this->model->getOrders();
    }


    //Функция работы с заявками
    public function admin_applications()
    {
        $params_applications = App::getRouter()->getParams();
        if (isset($params_applications[0]))
        {

            $this->data['applications_num'] = strtolower($params_applications[0]);
        }

        $this->data['orders'] = $this->model->getOrders();
        $this->data['writes'] = $this->model->getWrites();
        $this->data['users'] = $this->model->getUsers();
        $this->data['writes'] = $this->model->getWrites();

        //Очистка COOKIE
        $this->data['product'] = $this->model->getProduct();
        foreach (($this->data['product']) as $thing)
        {
            $id_pieces1 = $thing['id_product'];
            $pieces1 = 0;// количество товара er
            setcookie($id_pieces1, $pieces1, 10, '/');
        }
    }

    //Функция работы со списаниями
    public function admin_writes()
    {
        $params_writes = App::getRouter()->getParams();
        if (isset($params_writes[0]))
        {
            $this->data['writes_num'] = strtolower($params_writes[0]);
        }

        $this->data['orders'] = $this->model->getOrders();
        $this->data['writes'] = $this->model->getWrites();
        $this->data['users'] = $this->model->getUsers();

        //Очистка COOKIE
        $this->data['product'] = $this->model->getProduct();
        foreach (($this->data['product']) as $thing)
        {
            $id_pieces = $thing['id_product'];
            if (isset($_COOKIE[$id_pieces]))
            {
                $pieces = 0;// количество товара "0"
                setcookie($id_pieces, $pieces, 10, '/');//перезапись COOKIE в прошедшее время
            }
        }
    }

    //Функция редактирования списаний
    public function admin_editwrites()
    {
        //Списание товара: создание Акта списания и удаление позиций из базы данных
        if ($_POST)
        {
            $buy = isset($_POST['buy']) ? (int)($_POST['buy']) : null;
            if(($buy) && (($_POST['id']) || ($_POST['manager'])))
            {
                $this->data['product'] = $this->model->getProduct();

                $total_cost = 0;//сумма
                $array[0] = 0;
                $application[0] = 0;//массив заказа
                //$this->data['product'] = $this->model->getProduct();
                foreach (($this->data['product']) as $thing)
                {
                    $id_pieces = $thing['id_product'];
                    if (isset($_COOKIE[$id_pieces]))//Если есть в заказе продукт с таким id
                    {
//тут надо вставить проверку на разницу в существующем списании товара и новых кук
                        $quantity = htmlspecialchars($_COOKIE[$id_pieces]);
                        if ($quantity > $thing['quantity']) //Если товара списывается больше чем есть, то ошибка
                        {
                            Session::setFlash('Error');
                            Router::redirect('/admin/transparencys/errorproductedit/');//Сообщение об ошибки количества товара
                            exit();//при отсутствииэтой комманды программа выполняется дальше
                        }
                        else
                        {
                            //Запись нового колисества в базу товаров
                            $id = $id_pieces;
                            $newquantity =  $thing['quantity'] - $quantity;
                            $result = $this->model->saveNewQuantity($newquantity, $id);
                            if($result)
                            {
                                Session::setFlash('New Quantity was sawed.');
                            }
                            else
                            {
                                Session::setFlash('Error');
                            }
                            Router::redirect('/admin/transparencys/errorquantity/');//Сообщение об ошибки записи в БД количества товара

                        }
                        $application[$id_pieces] = $quantity;//в массив
                        $total_cost = $total_cost + $quantity * $thing['price'];
                    }
                }

                $array['writed'] = serialize( $application );//массив преобразовавается в строку
                $id = isset($_POST['id']) ? (int)($_POST['id']) : 0;
                $array['id_order'] = isset($_POST['id_order']) ? (int)($_POST['id_order']) : 0;
                $array['costomer'] = isset($_POST['costomer']) ? ($_POST['costomer']) : 0;
                $array['manager'] = isset($_POST['manager']) ? ($_POST['manager']) : 0;
                $array['amount'] = $total_cost;

                $result = $this->model->saveWrites($array, $id);

                if ($result)
                {
                    Session::setFlash('Pade was sawed.');
                    Router::redirect('/admin/transparencys/yesbasketedit/');//
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
        //-----------------------------------------------------------------------------------

        //Запись данных из БД в COOKIE
        $params_editwrites = App::getRouter()->getParams();
        if (isset($params_editwrites[0]))
        {
            //Область действия COOCIE и URL перезагрузки страницы
            $view = "/admin/baskets/editwrites/". $params_editwrites[0];

           // $this->data['consumption_num'] = strtolower($params_editwrites[0]);

            //Получение данных списания по его номеру
            $this->data['write'] = $this->model->getByWritesId($this->params[0]);
            $table = $this->data['write'];

            //цикл прогона списания
            $writed = unserialize($table['writed']);//Перевод строки списания в массив

            //Цикл выделения id товара => его количества для записи в COOKIE
            $cookie_beacon = 0;//установка маячка наличия кук
            foreach ($writed as $key => $value)//
            {
                $id_pieces = $key;//id товара
                //Была ли корекция количества,
                //если "да", то "маячёк" = 1
                if(isset($_COOKIE[$id_pieces]))//проверка на наличие кук с id товара
                {
                    if (($_COOKIE[$id_pieces]) != 0)//проверка на количество кук с id товара
                    {
                        $cookie_beacon = 1;//установка маячка если товар с id есть
                    }
                }
            }

            if ($cookie_beacon != 1)//если есть куки
            {
                //Цикл выделения id товара => его количества для записи в COOKIE
                foreach ($writed as $key => $value)//
                {
                    $id_pieces = $key;//id товара
                    $pieces = $value;//количество товара

                    //Была ли корекция количества,
                    //если "да", то данные из базы пропускаются
                    if (($_COOKIE[$id_pieces]) == 0)
                    {
                        //Запись id товара => его колличество в COOKIE
                        //setcookie($id_pieces,$pieces,0, $view);
                        setcookie($id_pieces,$pieces,0, '/');
                    }

                    //Незаметная перезагрузка страницы для отображения COOKIE
                    if(!isset($_COOKIE[$id_pieces]))
                    {
                        header('Location:'.$view);
                    }
                }
            }
        }

        $this->data['product'] = $this->model->getProduct();
    }


    //Функция списания товаров по заказу
    public function admin_look()
    {
        if ($_POST)
        {
            $id = isset($_POST['id_orders']) ? (int)($_POST['id_orders']) : null;
            if($id && ($_POST['manager']))
            {
                $result = $this->model->saveManager($_POST, $id);

                if ($result)
                {
                    Session::setFlash('Manager was sawed.');
                }
                else
                {
                    Session::setFlash('Error');
                }

                Router::redirect('/admin/baskets/applications/1');//
            }
            else
            {
                Router::redirect('/admin/transparencys/errormanager/');//
            }

        }

        //==================================================
        $params_applications = App::getRouter()->getParams();
        if (isset($params_applications[0]))
        {
            $this->data['applications_num'] = strtolower($params_applications[0]);

            $this->data['order'] = $this->model->getByOrdersId($this->params[0]);
            $order = $this->data['order'];
            $manager = $order['manager_first'];
            $this->data['manager_name'] =$this->model->getUsersId($manager);
        }

        //$this->data['orders'] = $this->model->getOrders();
        //$this->data['writes'] = $this->model->getWrites();
        $this->data['product'] = $this->model->getProduct();

    }

    //Функция скачивания заявки
    public function admin_download()
    {
        $params_applications = App::getRouter()->getParams();
        if (isset($params_applications[0]))
        {
            $this->data['applications_num'] = strtolower($params_applications[0]);

            $this->data['order'] = $this->model->getByOrdersId($this->params[0]);
            $order = $this->data['order'];
            $manager = $order['manager_first'];
            $this->data['manager_name'] =$this->model->getUsersId($manager);
        }
        $this->data['orders'] = $this->model->getOrders();
        $this->data['writes'] = $this->model->getWrites();
        $this->data['product'] = $this->model->getProduct();
        $this->data['provider'] = $this->model->getProvider();

    }

    //Функция редактирования/списания  администратором/менеджером корзины
    public function admin_consumption()
    {
        //Списание товара: создание Акта списания и удаление позиций из базы данных
        if ($_POST)
        {
            $buy = isset($_POST['buy']) ? (int)($_POST['buy']) : null;
            if(($buy) && (($_POST['id']) || ($_POST['manager'])))
            {
                $this->data['product'] = $this->model->getProduct();

                $total_cost = 0;//сумма
                $array[0] = 0;
                $application[0] = 0;//массив заказа
                //$this->data['product'] = $this->model->getProduct();
                foreach (($this->data['product']) as $thing)
                {
                    $id_pieces = $thing['id_product'];
                    if (isset($_COOKIE[$id_pieces]))//Если есть в заказе продукт с таким id
                    {

                        $quantity = htmlspecialchars($_COOKIE[$id_pieces]);
                        if ($quantity > $thing['quantity']) //Если товара списывается больше чем есть, то ошибка
                        {
                            Session::setFlash('Error');
                            Router::redirect('/admin/transparencys/errorproduct/');//Сообщение об ошибки количества товара
                            exit();//при отсутствииэтой комманды программа выполняется дальше
                        }
                        else
                        {
                            $id = $id_pieces;
                            $newquantity =  $thing['quantity'] - $quantity;
                            $result = $this->model->saveNewQuantity($newquantity, $id);
                            if($result)
                            {
                                Session::setFlash('New Quantity was sawed.');
                            }
                            else
                            {
                                Session::setFlash('Error');
                            }
                            Router::redirect('/admin/transparencys/errorquantity/');//Сообщение об ошибки записи в БД количества товара

                        }
                        $application[$id_pieces] = $quantity;//в массив
                        $total_cost = $total_cost + $quantity * $thing['price'];
/*
                        //Очистка COOKIE
                        $pieces = 0;// количество товара er
                        setcookie($id_pieces, $pieces, 10, '/');
*/
                    }
                }

                //$this->data['product'] = $this->model->getProduct();

                $array['writed'] = serialize( $application );//массив преобразовавается в строку
                $array['id_order'] = isset($_POST['id']) ? (int)($_POST['id']) : 0;
                $array['costomer'] = isset($_POST['costomer']) ? ($_POST['costomer']) : 0;
                $array['manager'] = isset($_POST['manager']) ? ($_POST['manager']) : 0;
                $array['amount'] = $total_cost;

                $result = $this->model->saveWrites($array);

                if ($result)
                {
                    Session::setFlash('Pade was sawed.');
                    Router::redirect('/admin/transparencys/yesbasket/');//
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
        //-----------------------------------------------------------------------------------



        //Запись данных из БД в COOKIE
        $params_consumption = App::getRouter()->getParams();
        if (isset($params_consumption[0]))
        {
            //Область действия COOCIE и URL перезагрузки страницы
            $view = "/admin/baskets/consumption/". $params_consumption[0];

            //$this->data['consumption_num'] = strtolower($params_consumption[0]);

            //Получение данных заказа по его номеру
            $this->data['order'] = $this->model->getByOrdersId($this->params[0]);
            $table = $this->data['order'];

            //цикл прогона заявки
            $ordered = unserialize($table['ordered']);//Перевод строки заказа в массив

            //Цикл выделения id товара => его количества для записи в COOKIE
            $cookie_beacon = 0;//установка маячка наличия кук
            foreach ($ordered as $key => $value)//
            {
                $id_pieces = $key;//id товара
                //Была ли корекция количества,
                //если "да", то "маячёк" = 1
                if(isset($_COOKIE[$id_pieces]))//проверка на наличие кук с id товара
                {
                    if (($_COOKIE[$id_pieces]) != 0)//проверка на количество кук с id товара
                    {
                        $cookie_beacon = 1;//установка маячка если товар с id есть
                    }
                }

            }

            if ($cookie_beacon != 1)//если есть куки
            {
                //Цикл выделения id товара => его количества для записи в COOKIE
                foreach ($ordered as $key => $value)//
                {
                    $id_pieces = $key;//id товара
                    $pieces = $value;//количество товара

                    //Была ли корекция количества,
                    //если "да", то данные из базы пропускаются
                    if (($_COOKIE[$id_pieces]) == 0)
                    {
                        //Запись id товара => его колличество в COOKIE
                        //setcookie($id_pieces,$pieces,0, $view);
                        setcookie($id_pieces,$pieces,0, '/');
                    }

                    //Незаметная перезагрузка страницы для отображения COOKIE
                    if(!isset($_COOKIE[$id_pieces]))
                    {
                        header('Location:'.$view);
                    }
                }
            }
        }

        $this->data['product'] = $this->model->getProduct();
    }

    public function admin_deleteapplications()
    {
        if (isset($this->params[0]))
        {
            $result = $this->model->deleteApplications($this->params[0]);
            if ($result)
            {
                Session::setFlash('User was deleted.');
            }
            else
            {
                Session::setFlash('Error_user_delete.');
            }
        }
        Router::redirect('/admin/baskets/applications/1');//Было Router::redirect('/users/pages/');
    }


}


?>