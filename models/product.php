<?php
//Формирование запросов к БД со страниц связаных с продуктами
class Product extends Model
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

    public function save($data, $id = null)
    {
        if (!isset($data['name']) || !isset($data['code']) || !isset($data['subdirectory']))
        {
            return false;
        }

        $id = (int)$id;
        $name = $this->db->escape($data['name']);
        $code = $this->db->escape($data['code']);
        $directory = $this->db->escape($data['directory']);
        $subdirectory = $this->db->escape($data['subdirectory']);
        $brend = $this->db->escape($data['brend']);
        $provider = $this->db->escape($data['provider']);
        $quantity = $this->db->escape($data['quantity']);
        $price = $this->db->escape($data['price']);
        $body = $this->db->escape($data['body']);
        $img = $this->db->escape($data['img']);
        $parameter = $this->db->escape($data['parameter']);
        $views = $this->db->escape($data['views']);

        if (!$id) {
            // Add new record
            $sql = "
              insert into product
                set name_product = '{$name}',
                  code = '{$code}',
                  id_directory = '{$directory}',
                  id_subdirectory = '{$subdirectory}',
                  id_brend = '{$brend}',
                  id_provider = '{$provider}',
                  quantity = '{$quantity}',
                  price = '{$price}',
                  description = '{$body}',
                  imege = '{$img}',
                  parameter = '{$parameter}',
                  views = '{$views}'
            ";
        } else {
            // Update existing record
            $sql = "
              update product
                set name_product = '{$name}',
                  code = '{$code}',
                  id_directory = '{$directory}',
                  id_subdirectory = '{$subdirectory}',
                  id_brend = '{$brend}',
                  id_provider = '{$provider}',
                  quantity = '{$quantity}',
                  price = '{$price}',
                  description = '{$body}',
                  imege = '{$img}',
                  parameter = '{$parameter}',
                  views = '{$views}'
                where id_product = ($id)
            ";
        }
        return $this->db->query($sql);
    }

    public function delete($id)
    {
        $id = (int)$id;
        $sql = "delete from product where id_product = {$id}";
        return $this->db->query($sql);//команда
    }

    //--- Работа с базой catalog ----- Ячейки каталока товаров +
    public function getCatalog()//по умолчанию все страницы
    {
        $sql = "select * from catalog where 1";// запрос к базе данных

        return $this->db->query($sql);
    }

    //--- Работа с базой products ----- Товары Получение всей базы
    public function getProduct()//по умолчанию все страницы +
    {
        $sql = "select * from product where 1";// запрос к базе данных

        return $this->db->query($sql);
    }

    //--- Работа с базой products по id ----- Для страницы товара принимает id, возврат строки товара
    public function getByProductId($product_id)
    {
        $id = (int)$product_id;
        $sql = "select * from product where id_product = '{$id}' limit 1";
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

    //--- Работа с базой catalog по id ----- Для Товаров принимает id, возврат Name_catalog
    public function getByCatalogIdName($category_id)
    {
        $id = (int)$category_id;
        $sql = "select name_directory from catalog where id_catalog = '{$id}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

    //--- Работа с базой brend ----- Производители Получение всей базы
    public function getBrend()//по умолчанию все страницы +
    {
        $sql = "select * from brend where 1";// запрос к базе данных

        return $this->db->query($sql);
    }

    //--- Работа с базой brend по id ----- Для Товаров принимает id, возврат Name_brend
    public function getByBrendIdName($brend_id)
    {
        $id = (int)$brend_id;
        $sql = "select name_brend from brend where id_brend = '{$id}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

    //--- Работа с базой provider ----- Поставщики Получение всей базы
    public function getProvider()//по умолчанию все страницы +
    {
        $sql = "select * from provider where 1";// запрос к базе данных

        return $this->db->query($sql);
    }

    //--- Работа с базой provider по id ----- Для Товаров принимает id, возврат Name_provider
    public function getByProviderIdName($provider_id)
    {
        $id = (int)$provider_id;
        $sql = "select name_provider from provider where id_provider = '{$id}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

    //--- Работа с базой products ----- Товары Получение всей базы с увеличением цены
    public function getProductIncrease()//по умолчанию все страницы +
    {
        $sql = "select * from product order by price asc";// запрос к базе данных

        return $this->db->query($sql);
    }

    //--- Работа с базой products ----- Товары Получение всей базы с уменьшением цены
    public function getProductReduction()//по умолчанию все страницы +
    {
        $sql = "select * from product order by price desc";// запрос к базе данных

        return $this->db->query($sql);
    }

}
?>