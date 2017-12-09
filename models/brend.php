<?php
//Формирование запросов к БД со страниц связаных с производителями
class Brend extends Model
{

    public function getList($only_published = false)//по умолчанию все страницы
    {
        $sql = "select * from pages where 1";// запрос к базе данных
        if ($only_published)//если trye, то только опубликованные страницы
        {
            $sql .= "and analytics = 1";
        }
        return $this->db->query($sql);
    }

    //--- Работа с базой brend ----- Производители Получение всей базы
    public function getBrend()//по умолчанию все страницы +
    {
        $sql = "select * from brend where 1";// запрос к базе данных

        return $this->db->query($sql);
    }

    //--- Работа с базой brend по id ----- Для Производителей принимает id, возврат строки
    public function getByBrendId($category_id)
    {
        $id = (int)$category_id;
        $sql = "select * from brend where id_brend = '{$id}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

    //--- Работа с базой brend ----- Производители Запись одного производителя
    public function save($data, $id = null)
    {
        if (!isset($data['name']))
        {
            return false;
        }

        $id = (int)$id;
        $name = $this->db->escape($data['name']);

        if (!$id) {
            // Add new record
            $sql = "
              insert into brend
                set name_brend = '{$name}'
            ";
        } else {
            // Update existing record
            $sql = "
              update brend
                set name_brend = '{$name}'
                where id_brend = ($id)
            ";
        }
        return $this->db->query($sql);
    }

    //--- Работа с базой catalog по id ----- Для удаления Каталогов и  Подкаталогов из БД
    public function delete($id)
    {
        $id = (int)$id;
        $sql = "delete from brend where id_brend = {$id}";
        return $this->db->query($sql);//команда
    }

    //--- Работа с базой products ----- Товары Получение всей базы
    public function getProduct()//по умолчанию все страницы +
    {
        $sql = "select * from product where 1";// запрос к базе данных

        return $this->db->query($sql);
    }
}
?>