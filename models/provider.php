<?php
//Формирование запросов к БД со страниц связаных с поставщиками
class Provider extends Model
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
    public function getProvider()//по умолчанию все страницы +
    {
        $sql = "select * from provider where 1";// запрос к базе данных

        return $this->db->query($sql);
    }

    //--- Работа с базой brend по id ----- Для Производителей принимает id, возврат строки
    public function getByProviderId($category_id)
    {
        $id = (int)$category_id;
        $sql = "select * from provider where id_provider = '{$id}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

    //--- Работа с базой brend ----- Производители Запись одного производителя
    public function save($data, $id = null)
    {
        if (!isset($data['name']) || !isset($data['person']) || !isset($data['phone']))
        {
            return false;
        }

        $id = (int)$id;
        $name = $this->db->escape($data['name']);
        $person = $this->db->escape($data['person']);
        $phone = $this->db->escape($data['phone']);
        $address = $this->db->escape($data['address']);
        $activity = isset($data['activity']) ? 1 : 0;
        $party = isset($data['party']) ? 1 : 0;

        if (!$id) {
            // Add new record
            $sql = "
              insert into provider
                set name_provider = '{$name}',
                    person = '{$person}',
                    phone_provider = '{$phone}',
                    address_provider = '{$address}',
                    is_activity = '{$activity}',
                    third_party = '{$party}'
            ";
        } else {
            // Update existing record
            $sql = "
              update provider
                set name_provider = '{$name}',
                    person = '{$person}',
                    phone_provider = '{$phone}',
                    address_provider = '{$address}',
                    is_activity = '{$activity}',
                    third_party = '{$party}'
                where id_provider = ($id)
            ";
        }
        return $this->db->query($sql);
    }

    //--- Работа с базой catalog по id ----- Для удаления Каталогов и  Подкаталогов из БД
    public function delete($id)
    {
        $id = (int)$id;
        $sql = "delete from provider where id_provider = {$id}";
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