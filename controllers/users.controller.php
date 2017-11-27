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
        if ($_POST && isset($_POST['login']) && isset($_POST['password']))
        {
            $user = $this->model->getByLogin($_POST['login']);
            $hash = md5(Config::get('salt').$_POST['password']);
            if ($user && $user['is_active'] && $hash == $user['password'])
            {
                Session::set('login', $user['login']);//Наличие логина в сессие означает, что пользователь выполнил вход
                Session::set('role', $user['role']);
            }
            if ($_SESSION['role'] == 'admin')//Проверка роли пользователя!!!!
            {
                Router::redirect('/admin/');//переход на админ панель если администратор
            }
            else
            {
                Router::redirect('/pages');//переход на админ панель если user
            }
        }
    }
    public function admin_logout()
    {
        Session::destroy();
        Router::redirect('/admin/');
    }



}

?>