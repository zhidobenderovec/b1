<?php
//работает с таблицей users
//Получает логин и пароль
class User extends Model
{
    public function getByLogin($login)
    {
        $email = $this->db->escape($login);//email в качестве логина
        $sql = "select * from users where email = '{$email}' limit 1";
        $result = $this->db->query($sql);
        if (isset($result[0]))
        {
            return $result[0];
        }
        return false;
    }

    //--- Работа с базой products ----- Товары Получение всей базы
    public function getUsers()//по умолчанию все страницы +
    {
        $sql = "select * from users where 1";// запрос к базе данных

        return $this->db->query($sql);
    }

    //--- Запись пользователя
    public function save($data, $id = null)
    {
        if (!isset($data['name']) || !isset($data['email']) || !isset($data['pass']) || !isset($data['phone']) )
        {
            return false;
        }

        $id = (int)$id;
        $name = $this->db->escape($data['name']);
        $email = $this->db->escape($data['email']);
        $city = $this->db->escape($data['city']);
        $pass = md5(Config::get('salt'). $this->db->escape($data['pass']));
        $phone = $this->db->escape($data['phone']);
        $role = isset($data['role']) ? ($data['role']) : "user";
        $visit = isset($data['role']) ? ($data['role']) : 1;
        $date = isset($data['date']) ? $data['date'] : date('Y-m-d');
        $active = isset($data['active']) ? 1 : 0;


        if (!$id) {
            // Add new record
            $sql = "
              insert into users
                set name = '{$name}',
                  email = '{$email}',
                  city = '{$city}',
                  password = '{$pass}',
                  phone = '{$phone}',
                  role = '{$role}',
                  visits_user = '{$visit}',
                  date_last = '{$date}',
                  is_active = '{$active}'
                  
            ";
        } else {
            // Update existing record
            $sql = "
              update users
                set name = '{$name}',
                  email = '{$email}',
                  city = '{$city}',
                  phone = '{$phone}',
                  role = '{$role}',
                  visits_user = '{$visit}',
                 
                  is_active = '{$active}'
                where id_user = ($id)
            ";
        }
        return $this->db->query($sql);
    }

    public function delete($id)
    {
        $id = (int)$id;
        $sql = "delete from users where id_user = {$id}";
        return $this->db->query($sql);//команда
    }

    //--- Работа с базой products по id ----- Для страницы товара принимает id, возврат строки товара
    public function getByUsersId($users_id)
    {
        $id = (int)$users_id;
        $sql = "select * from users where id_user = '{$id}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }
}

?>