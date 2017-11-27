<?php
//Контроллер страниц. Методы - по страницам
class StatisticsController extends Controller
{
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Statistics();
    }


    public function news_page()//index()
    {
        // echo 'Here will be a pages list';
        $this->data['visits'] = $this->model->getListStat();
        $this->data['visit'] = $this->model->getByIdVisit($this->params[0]);

    }

    public function view()
    {
        $params = App::getRouter()->getParams();

        if (isset($params[0]))
        {
            $id_pages = strtolower($params[0]);
            //echo "Here will be a page with '{$alias}' alias.";
            $this->data['visit'] = $this->model->getByPages($id_pages);
        }
    }

    public function admin_index_statistics()
    {
        $this->data['visits'] = $this->model->getListStat();
    }

    public function admin_add_statistics()
    {
        if ($_POST)
        {
            $result = $this->model->saveVisit($_POST);
            if($result)
            {
                Session::setFlash('Statistics was sawed.');
            }
            else
            {
                Session::setFlash('Error');
            }
        }
    }

    public function admin_edit_statistics()
    {
        if ($_POST)
        {
            $id_visit = isset($_POST['id_visit']) ? $_POST['id_visit'] : null;
            $result = $this->model->saveVisit($_POST, $id_visit);
            if($result)
            {
                Session::setFlash('Statistics was sawed.');
            }
            else
            {
                Session::setFlash('Error');
            }
        }


        if (isset($this->params[0]))
        {
            $this->data['visit'] = $this->model->getByIdVisit($this->params[0]);
        }
        else
        {
            Session::setFlash('Wrong statistics id_visit.');
        }
    }

    public function views_edit()
    {
        if ($_POST)
        {
            $id_visit = isset($_POST['id_visit']) ? $_POST['id_visit'] : null;
            $result = $this->model->saveVisit($_POST, $id_visit);
            if($result)
            {
                Session::setFlash('Statistics was sawed.');
            }
            else
            {
                Session::setFlash('Error');
            }
        }


        if (isset($this->params[0]))
        {
            $this->data['visit'] = $this->model->getByIdVisit($this->params[0]);
        }
        else
        {
            Session::setFlash('Wrong statistics id_visit.');
        }
    }

    public function statistics_delete()
    {
        if (isset($this->params[0]))
        {
            $result = $this->model->deleteVisit($this->params[0]);
            if ($result)
            {
                Session::setFlash('Statistics was deleted.');
            }
            else
            {
                Session::setFlash('Error.');
            }
        }

    }

}

?>