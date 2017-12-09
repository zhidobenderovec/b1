<?php

class Message extends Model
{
    /*
    public function save($data, $id = null)
    {
        if ( !isset($data['name']) || !isset($data['email']) || !isset($data['message']))
        {
            return false;
        }

        $id = (int)$id;
        $name = $this->db->escape($data['name']);
        $email = $this->db->escape($data['email']);
        $message = $this->db->escape($data['message']);
        $date = date('Y-m-d');


        if ( !$id )
        {
            // Add new record
            $sql = "
              insert into messages
                set name = '{$name}',
                  email = '{$email}',
                  messages = '{$message}',
                  datem = '{$date}'
            ";
        } else
        {
            // Update existing record
            $sql = "
              update messages
                set name = '{$name}',
                  email = '{$email}',
                  messages = '{$message}',
                  datem = '{$date}'
                where id = ($id)
            ";
        }
        return $this->db->query($sql);
    }
    */
    public function save($data, $id = null)
    {
        if ( !isset($data['name']) || !isset($data['email']) || !isset($data['message']))
        {
            return false;
        }

        $id = (int)$id;
        $name = $this->db->escape($data['name']);
        $email = $this->db->escape($data['email']);
        $message = $this->db->escape($data['message']);
        $date = isset($data['date']) ? $data['date'] : date('Y-m-d');

        $answer = $this->db->escape($data['answer']);
        $viewed = $this->db->escape($data['viewed']);
        if ($data['answer'])
        {
            $answered = 1;
        }
        else
        {
            $answered = isset($data['answered']) ? 1 : 0;
        }
        $active = isset($data['active']) ? 1 : 0;


        if ( !$id )
        {
            // Add new record
            $sql = "
              insert into messages
                set name = '{$name}',
                  email = '{$email}',
                  messages = '{$message}',
                  datem = '{$date}',
                  
                  answer = '{$answer}',
                  viewed = '{$viewed}',
                  answered = '{$answered}',
                  is_active = '{$active}'
            ";
        } else
        {
            // Update existing record
            $sql = "
              update messages
                set name = '{$name}',
                  email = '{$email}',
                  messages = '{$message}',
                  datem = '{$date}',
                  
                  answer = '{$answer}',
                  viewed = '{$viewed}',
                  answered = '{$answered}',
                  is_active = '{$active}'
                where id = ($id)
            ";
        }
        return $this->db->query($sql);
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

    //--- Работа с базой messages по id ----- Для Сообщений принимает id, возврат строки
    public function getByMessadeId($category_id)
    {
        $id = (int)$category_id;
        $sql = "select * from messages where id = '{$id}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }
}

?>