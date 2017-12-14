<?php
//Контроллер авторизации.
//Выводит форму логина

class UsersController extends Controller
{
    public function __construct(array $data = array())
    {
        parent::__construct($data);
        $this->model = new User();
    }

//Вывод и обработка формы логина
    public function admin_login()
    {


        if ($_POST && isset($_POST['login']) && isset($_POST['password']))//login
        {
            $user = $this->model->getByLogin($_POST['login']);//login!!!!!
            $hash = md5(Config::get('salt').$_POST['password']);
            if ($user && $user['is_active'] && $hash == $user['password'])//Проверка на наличие юзера, его активности и правильного пароля
            {
                Session::set('login', $user['email']);//Наличие логина в сессие означает, что пользователь выполнил вход
                Session::set('role', $user['role']);
                Session::set('name', $user['name']);
                Session::set('id', $user['id_user']);
                Session::set('phone', $user['phone']);
                Session::set('city', $user['city']);
            }

            if ($_SESSION['role'] == 'admin')//Проверка роли пользователя!!!!
            {
                Router::redirect('/admin/');//переход на админ панель если администратор
            }
            else
            {
                if (!isset($user['email']) || ($hash != $user['password']))
                {
                    echo "<script>alert(\"Неправильный почтовый адрес или пароль\");</script>";
                }
                else
                {
                    Router::redirect('/pages');//переход на админ панель если user
                }
            }
        }

    }

    public function admin_registration()
    {
        if ($_POST)
        {
            //Проверка конфликта с уже существующим адресом
            $user = $this->model->getByLogin($_POST['email']);//login!!!!!
            if (isset($user['email']))
            {
                echo "<script>alert(\"Такой почтовый адрес уже используется\");</script>";
            }
            else
            {

                $result = $this->model->save($_POST);
                if ($result) {

                    Session::setFlash('User was sawed.');
                } else {
                    Session::setFlash('Error');
                }

                if ($_POST) {
                    $user = $this->model->getByLogin($_POST['email']);//login!!!!!
                    $hash = md5(Config::get('salt') . $_POST['pass']);
                    if ($user && $user['is_active'] && $hash == $user['password'])//Проверка на наличие юзера, его активности и правильного пароля
                    {
                        Session::set('login', $user['email']);//Наличие логина в сессие означает, что пользователь выполнил вход
                        Session::set('role', $user['role']);
                        Session::set('name', $user['name']);
                        Session::set('id', $user['id_user']);
                        Session::set('city', $user['city']);
                        Session::set('phone', $user['phone']);
                    }

                    Router::redirect('/pages');//Было Router::redirect('/users/pages/');
                } else {
                    Router::redirect('/admin/users/registration');//Было Router::redirect('/users/pages/');
                }
            }
        }
        $this->data['users'] = $this->model->getUsers();
    }

    public function admin_logout()
    {
        Session::destroy();
        Router::redirect('/');//На главную страницу
    }

    //*Функция обслуживания страницы таблицы пользователей
    public function admin_index()
    {
        $params_user = App::getRouter()->getParams();
        //Возврат страницы пагинации  из URL
        if (isset($params_user[1]))
        {
            $this->data['page_number'] = strtolower($params_user[1]);
        }

        //Возврат имени статуса  из URL
        if (isset($params_user[2]))
        {
            $this->data['role_num'] = strtolower($params_user[2]);
        }
        $this->data['users'] = $this->model->getUsers();
    }

    //*Функция  записи пользователя
    public function admin_add()
    {
        if ($_POST)
        {
            $result = $this->model->save($_POST);
            if($result)
            {

                Session::setFlash('User was sawed.');
            }
            else
            {
                Session::setFlash('Error');
            }
            Router::redirect('/admin/users//1/0');//Было Router::redirect('/users/pages/');
        }
        $this->data['users'] = $this->model->getUsers();
    }

    //*Функция редактирования записи пользователя
    public function admin_edit()
    {
        if ($_POST)
        {
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $result = $this->model->save($_POST, $id);
            if($result)
            {
                Session::setFlash('User was sawed.');
            }
            else
            {
                Session::setFlash('Error');
            }
            Router::redirect('/admin/users//1/0');//Было Router::redirect('/users/pages/');
        }

        if (isset($this->params[0]))
        {
            $this->data['user'] = $this->model->getByUsersId($this->params[0]);
        }
        else
        {
            Session::setFlash('Wrong user id.');
            Router::redirect('/users/pages/');
        }


        $this->data['users'] = $this->model->getUsers();
    }

//*Функция удаления пользователя
    public function admin_delete()
    {
        if (isset($this->params[0]))
        {
            $result = $this->model->delete($this->params[0]);
            if ($result)
            {
                Session::setFlash('User was deleted.');
            }
            else
            {
                Session::setFlash('Error_user_delete.');
            }
        }
        Router::redirect('/admin/users//1/0');//Было Router::redirect('/users/pages/');
    }


}

?>