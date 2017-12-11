<?php
//Формирование запросов со страниц
class Page extends Model
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

    public function getByAlias($alias)
    {
        $alias = $this->db->escape($alias);
        $sql = "select * from pages where alias = '{$alias}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

    public function getById($id)
    {
        $id = (int)$id;
        $sql = "select * from pages where id = '{$id}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

    public function getByCategory($category)
    {
        $category = $this->db->escape($category);
        $sql = "select * from categories where category = '{$category}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

//--- Работа с базой messades ----- Ячейки каталока сообщений
    public function getMessages()
    {
        $sql = "select * from messages where 1";// запрос к базе данных
        return $this->db->query($sql);
    }




    public function save($data, $id = null)
    {
        if (!isset($data['alias']) || !isset($data['category']) || !isset($data['body'])) {
            return false;
        }

        $id = (int)$id;
        $category = $this->db->escape($data['category']);
        $alias = $this->db->escape($data['alias']);
        $tegs = $this->db->escape($data['tegs']);
        $dates = $this->db->escape($data['dates']);
        $body = $this->db->escape($data['body']);
        $comments = $this->db->escape($data['comments']);
        $img = $this->db->escape($data['img']);
        $analytics = isset($data['analytics']) ? 1 : 0; //$this->db->escape($data['analytics']);

        if (!$id) {
            // Add new record
            $sql = "
              insert into pages
                set category = '{$category}',
                  alias = '{$alias}',
                  tegs = '{$tegs}',
                  dates = '{$dates}',
                  body = '{$body}',
                  comments = '{$comments}',
                  img = '{$img}',
                  analytics = '{$analytics}'
            ";
        } else {
            // Update existing record
            $sql = "
              update pages
                set category = '{$category}',
                  alias = '{$alias}',
                  tegs = '{$tegs}',
                  dates = '{$dates}',
                  body = '{$body}',
                  comments = '{$comments}',
                  img = '{$img}',
                  analytics = '{$analytics}'
                where id = ($id)
            ";
        }
        return $this->db->query($sql);
    }

    public function delete($id)
    {
        $id = (int)$id;
        $sql = "delete from pages where id = {$id}";
        return $this->db->query($sql);//команда
    }

    /*
 * Определение id последней новости
 */
    public function getMax_5id()// страницы с или без категории
    {

        if (isset($category))//если заданна категория
        {
            $sql = "select id from pages where category='{$category}' ORDER BY id DESC LIMIT 5";// запрос к базе данных
        } else {
            $sql = "select id from pages ORDER BY id DESC LIMIT 5";// запрос к базе данных
        }
        return $this->db->query($sql);
    }

    //---Работа с базой visit
    public function getListStat()//по умолчанию все страницы
    {
        $sql = "select * from visit where 1";// запрос к базе данных

        return $this->db->query($sql);
    }

    //--- Работа с базой locations ----- Контактные данные
    public function getLocation()//по умолчанию все страницы
    {
        $sql = "select * from locations where 1";// запрос к базе данных

        return $this->db->query($sql);
    }

    //--- Работа с базой shares ----- Акции
    public function getShares()//по умолчанию все страницы
    {
        $sql = "select * from shares where 1";// запрос к базе данных

        return $this->db->query($sql);
    }

    //--- Работа с базой catalog ----- Ячейки каталока товаров
    public function getCatalog()//по умолчанию все страницы
    {
        $sql = "select * from catalog where 1";// запрос к базе данных

        return $this->db->query($sql);
    }

    //--- Работа с базой products ----- Товары
    public function getProduct()//по умолчанию все страницы
    {
        $sql = "select * from product where 1";// запрос к базе данных

        return $this->db->query($sql);
    }

    //--- Работа с базой catalog по id ----- Для Товаров id
    public function getByCatalogId($category_id)
    {
        $id = (int)$category_id;
        $sql = "select * from catalog where id_catalog = '{$id}' limit 1";
        $result = $this->db->query($sql);

        return isset($result[0]) ? $result[0] : null;
    }

    //--- Работа с базой products по id ----- Для страницы товара
    public function getByProductId($product_id)
    {
        $id = (int)$product_id;
        $sql = "select * from product where id_product = '{$id}' limit 1";
        $result = $this->db->query($sql);

        return isset($result[0]) ? $result[0] : null;
    }

    /*--- Работа с базой products по views ----- Для нижней карусели
          10 самых посещаемых товаров
    */
    public function getProductTop()
    {
        $sql = "select * from product order by views desc limit 10";

        return $this->db->query($sql);
    }
}
?>