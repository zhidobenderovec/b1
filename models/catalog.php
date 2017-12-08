<?php
//Формирование запросов к БД со страниц связаных с каталогами
class Catalog extends Model
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

    //--- Работа с базой catalog ----- Ячейки каталока товаров +
    public function getCatalog()//по умолчанию все страницы
    {
        $sql = "select * from catalog where 1";// запрос к базе данных

        return $this->db->query($sql);
    }

    //--- Работа с базой catalog по id ----- Для Товаров принимает id, возврат Name_catalog
    public function getByCatalogIdName($category_id)
    {
        $id = (int)$category_id;
        $sql = "select name_directory from catalog where id_catalog = '{$id}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

    //--- Работа с базой catalog по id ----- Для Товаров принимает id, возврат строки
    public function getByCatalogId($category_id)
    {
        $id = (int)$category_id;
        $sql = "select * from catalog where id_catalog = '{$id}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

    //--- Работа с базой catalog по id ----- Для записи Каталогов и  Подкаталогов в БД
    public function save($data, $id = null)
    {
        if (!isset($data['name'])) {
            return false;
        }

        $id = (int)$id;
        $name = $this->db->escape($data['name']);
        $directory = $this->db->escape($data['directory']);

        $img = $this->db->escape($data['img']);


        if (!$id) {
            // Add new record

            $sql = "
              insert into catalog
                set name_directory = '{$name}',
                  id_directory = '{$directory}',
                  img_catalog = '{$img}'
            ";
            if ($directory == 0)//При записи категории: id_directory = NULL
            {
                $sql = "
              insert into catalog
                set name_directory = '{$name}',
                  id_directory = NULL,
                  img_catalog = '{$img}'
            ";
            }
        } else {
            // Update existing record
            $sql = "
              update catalog
                set name_directory = '{$name}',
                  img_catalog = '{$img}'
                where id_catalog = ($id)
            ";
        }
        return $this->db->query($sql);
    }

    //--- Работа с базой catalog по id ----- Для удаления Каталогов и  Подкаталогов из БД
    public function delete($id)
    {
        $id = (int)$id;
        $sql = "delete from catalog where id_catalog = {$id}";
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