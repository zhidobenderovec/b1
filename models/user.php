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

}

?>