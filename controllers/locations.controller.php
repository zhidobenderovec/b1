<?php
//Контроллер контактов. Методы - по страницам
class LocationsController extends Controller
{
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Location();
    }

    public function index()
    {
        $this->data['localion'] = $this->model->getLocation();
    }
    //Функция редактирования контактных данных
    public function admin_index()
    {
        //$this->data =$this->model->getList();

        if ($_POST)
        {
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $result = $this->model->save($_POST, $id);
            if($result)
            {
                Session::setFlash('Location was sawed.');
            }
            else
            {
                Session::setFlash('Error');
            }
            Router::redirect('/admin');//Было Router::redirect('/users/pages/');
        }

        //Открытие контактной информации строчкой
        $this->data['localion_number'] = $this->model->getByLocationId("1");

        $this->data['localion'] = $this->model->getLocation();

    }

}

?>
