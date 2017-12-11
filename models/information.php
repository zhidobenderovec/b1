<?php

class Information extends Model
{
    //--- Работа с базой information ----- Получение строки информации
    public function getInformationId($id)
    {
        $id = (int)$id;
        $sql = "select * from information where id_information = '{$id}' limit 1"; // запрос к базе данных
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;

    }


    //--- Работа с базой information ----- Запись информации
    public function save($data, $id = null)
    {
        if (!isset($data['name']) || !isset($data['body']))
        {
            return false;
        }

        $id = (int)$id;
        $name = $this->db->escape($data['name']);
        $body = $this->db->escape($data['body']);


        if (!$id)
        {
            // Add new record

            $sql = " 
                insert into information
                        set name_information = '{$name}',
                            body_information = '{$body}'
                    ";
        } else
        {
            // Update existing record
            $sql = "
                      update information
                        set name_information = '{$name}',
                            body_information = '{$body}'
                        where id_information = ($id)
                    ";
            return $this->db->query($sql);
        }
    }


        //--- Работа с базой shares ----- Получение всей таблицы акций
    public function getShares()
    {
        $sql = "select * from shares where 1";// запрос к базе данных
        return $this->db->query($sql);
    }


    //--- Работа с базой shares ----- Ячейки каталока акций
    public function save_shares($data, $id = null)
    {
        if ((!isset($data['name']) && !isset($data['body'])) || (!isset($data['img'])) || (!isset($data['date_e'])))
        {
            return false;
        }
        $id = (int)$id;
        $name = $this->db->escape($data['name']);
        $body = $this->db->escape($data['body']);
        $img = $this->db->escape($data['img']);
        $product = isset($data['product']) ? ($data['product']) : null;
        $date_b = isset($data['date_b']) ? ($data['date_b']) : null;
        $date_e = $this->db->escape($data['date_e']);


        if ( !$id )
        {
            // Add new record
            $sql = "
                 insert into shares
                   set alias = '{$name}',
                       body = '{$body}',
                       imege_shares = '{$img}',
                       id_product = '{$product}',
                       beginning_date = '{$date_b}',
                       expiration_date = '{$date_e}'
               ";
        } else
        {
            // Update existing record
            $sql = "
                 update shares
                   set alias = '{$name}',
                       body = '{$body}',
                       imege_shares = '{$img}',
                       id_product = '{$product}',
                       beginning_date = '{$date_b}',
                       expiration_date = '{$date_e}'
                   where id_shares = ($id)
               ";
        }
        return $this->db->query($sql);
    }


    //--- Работа с базой shares ----- Новая ячейка каталога акций
    public function save_addshares()
    {

        $id = null;
        $name = "Пустая";
        $body = null;
        $img = null;
        $product = null;
        $date_b = null;
        $date_e = null;

            // Add new record
            $sql = "
                 insert into shares
                   set alias = '{$name}',
                       body = '{$body}',
                       imege_shares = '{$img}',
                       id_product = '{$product}',
                       beginning_date = '{$date_b}',
                       expiration_date = '{$date_e}'
               ";

        return $this->db->query($sql);
    }
//--- Работа с базой shares ----- Удаление акции
    public function deleteshares($id)
    {
        $id = (int)$id;
        $sql = "delete from shares where id_shares = {$id}";
        return $this->db->query($sql);
    }





    /*








       //--- Работа с базой location по id ----- Для Сообщений принимает id, возврат строки
       public function getByLocationId($location_id)
       {
           $id = (int)$location_id;
           $sql = "select * from location where id_location = '{$id}' limit 1";
           $result = $this->db->query($sql);
           return isset($result[0]) ? $result[0] : null;
       }




       /*





           public function delete($id)
           {
               $id = (int)$id;
               $sql = "delete from messages where id = {$id}";
               return $this->db->query($sql);//команда
           }



           public function getList()
           {
               $sql = "select * from messages where 1";
               return $this->db->query($sql);
           }

           //--- Работа с базой users ----- Ячейки каталока пользователей
           public function getUsers()
           {
               $sql = "select * from users where 1";// запрос к базе данных
               return $this->db->query($sql);
           }

           //--- Работа с базой messades ----- Ячейки каталока сообщений
           public function getMessages()
           {
               $sql = "select * from messages where 1";// запрос к базе данных
               return $this->db->query($sql);
           }


       */
}

?>
