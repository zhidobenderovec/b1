<?php
//Формирование запросов со страниц
class Basket extends Model
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

    //--- Работа с базой orders ----- Ячейки каталока заявок
    public function getOrders()//по умолчанию все страницы
    {
        $sql = "select * from orders where 1";// запрос к базе данных

        return $this->db->query($sql);
    }

    //--- Работа с базой writes ----- Ячейки каталока списаний
    public function getWrites()//по умолчанию все страницы
    {
        $sql = "select * from writes where 1";// запрос к базе данных

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

    //--- Работа с базой products по id ----- Для страницы товара
    //Получение строки продукта по его id
    public function getByProductId($product_id)
    {
        $id = (int)$product_id;
        $sql = "select * from product where id_product = '{$id}' limit 1";
        $result = $this->db->query($sql);

        return isset($result[0]) ? $result[0] : null;
    }

    //--- Работа с базой orders по id ----- Для страницы заявки
    public function getByOrdersId($orders_id)
    {
        $id = (int)$orders_id;
        $sql = "select * from orders where id_orders = '{$id}' limit 1";
        $result = $this->db->query($sql);

        return isset($result[0]) ? $result[0] : null;
    }

    //--- Работа с базой orders  ----- Запись заказа
    public function save($data, $id = null)
    {
        if (!isset($data['name']) || !isset($data['email']) || !isset($data['phone'])|| !isset($data['city']))
        {
            return false;
        }

        $id = (int)$id;
        $id_costomer = isset($data['id']) ? ($data['id']) : null;
        $name = $this->db->escape($data['name']);
        $email = $this->db->escape($data['email']);
        $phone = $this->db->escape($data['phone']);
        $city = $this->db->escape($data['city']);
        $ordered = $this->db->escape($data['ordered']);
        $date = isset($data['date']) ? $data['date'] : date('Y-m-d');
        $amount = $this->db->escape($data['amount']);

        if (!$id) {
            // Add new record
            $sql = "
              insert into orders
                set id_costomer = '{$id_costomer}',
                    costomer = '{$name}',
                    email = '{$email}',
                    phone = '{$phone}',
                    city = '{$city}',
                    ordered = '{$ordered}',
                    order_date = '{$date}',
                    amount = '{$amount}'
            ";
        } else {
            // Update existing record
            $sql = "
              update orders
                set id_costomer = '{$id_costomer}',
                    costomer = '{$name}',
                    email = '{$email}',
                    phone = '{$phone}',
                    city = '{$city}',
                    ordered = '{$ordered}',
                    order_date = '{$date}',
                    amount = '{$amount}'
                where id = ($id)
            ";
        }
        return $this->db->query($sql);
    }

    //Запись количества товара в БД после его списания заявкой
    public function saveNewQuantity($newquantity, $id)
    {
        if (!isset($newquantity) || !isset($id) )
        {
            return false;
        }

        $id = (int)$id;
        $quantity = $this->db->escape($newquantity);

        // Update existing record
        $sql = "
          update product
            set quantity = '{$quantity}'
              
            where id_product = ($id)
        ";

        return $this->db->query($sql);
    }


    //--- Работа с базой orders  ----- Извлечение заказоа usera
    public function getUsersOrder($id_costomer)
    {
        $id = (int)$id_costomer;
        $sql = "select * from orders where id_costomer = '{$id}'";
        $result = $this->db->query($sql);

        return $this->db->query($sql);
    }

    //--- Работа с базой users -----  Получение name пользователя по id
    public function getUsersId($id_user)//по умолчанию все страницы +
    {
        $id = (int)$id_user;
        $sql = "select name from users where id_user = '{$id}'";// запрос к базе данных

        $result = $this->db->query($sql);

        return isset($result[0]) ? $result[0] : null;
    }

    //--- Работа с базой orders по id ----- Для записи менеджера в Заказы
    public function saveManager($data, $id = null)
    {
        if (!isset($data['manager']))
        {
            return false;
        }

        $id = (int)$id;
        $manager = $this->db->escape($data['manager']);
        if (!$id)
        {
            // Add new record
            $sql = "
              insert into orders
                set manager_first = '{$manager}'
            ";
        }
        else
        {
            // Update existing record
            $sql = "
              update orders
                set manager_first = '{$manager}'
                where id_orders = ($id)
            ";
        }
        return $this->db->query($sql);
    }


    //--- Работа с базой provider ----- Поставщики
    public function getProvider()//по умолчанию все страницы
    {
        $sql = "select * from provider where 1";// запрос к базе данных

        return $this->db->query($sql);
    }


    //--- Работа с базой users ----- Пользователи Получение всей базы
    public function getUsers()//по умолчанию все страницы +
    {
        $sql = "select * from users where 1";// запрос к базе данных

        return $this->db->query($sql);
    }

    public function saveWrites($data, $id = null)
    {
        if (!isset($data['id_order']) || !isset($data['manager']) || !isset($data['costomer']))
        {
            return false;
        }

        $id = (int)$id;
        $costomer = isset($data['costomer']) ? ($data['costomer']) : null;
        $manager = $this->db->escape($data['manager']);
        $id_order = $this->db->escape($data['id_order']);
        $writed = $this->db->escape($data['writed']);
        $date = isset($data['date']) ? $data['date'] : date('Y-m-d');
        $amount = $this->db->escape($data['amount']);

        if (!$id) {
            // Add new record
            $sql = "
              insert into writes
                set costomer = '{$costomer}',
                    
                    id_order = '{$id_order}',
                    amount = '{$amount}',
                    manager = '{$manager}',
                    writed = '{$writed}'
            ";
        } else {
            // Update existing record
            $sql = "
              update writes
                set costomer = '{$costomer}',
                    write_date = '{$date}',
                    id_order = '{$id_order}',
                    amount = '{$amount}',
                    manager = '{$manager}',
                    writed = '{$writed}'
                where id_write = ($id)
            ";
        }
        return $this->db->query($sql);
    }

    //--- Работа с базой orders ----- Удаление заказа
    public function deleteApplications($id)
    {
        $id = (int)$id;
        $sql = "delete from orders where id_orders = {$id}";
        return $this->db->query($sql);//команда
    }

    //--- Работа с базой writes ----- Удаление списания
    public function deleteWrites($id)
    {
        $id = (int)$id;
        $sql = "delete from writes where id_write = {$id}";
        return $this->db->query($sql);//команда
    }

    //--- Работа с базой writes по id ----- Для страницы редактирования списания
    public function getByWritesId($writes_id)
    {
        $id = (int)$writes_id;
        $sql = "select * from writes where id_write = '{$id}' limit 1";
        $result = $this->db->query($sql);

        return isset($result[0]) ? $result[0] : null;
    }
}
?>
