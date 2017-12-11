<?php

class Location extends Model
{


    //--- Работа с базой location ----- Получение всей таблицы расположения
    public function getLocation()
    {
        $sql = "select * from location where 1";// запрос к базе данных
        return $this->db->query($sql);
    }

    //--- Работа с базой location по id ----- Для Сообщений принимает id, возврат строки
    public function getByLocationId($location_id)
    {
        $id = (int)$location_id;
        $sql = "select * from location where id_location = '{$id}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

    public function save($data, $id = null)
    {
        if ( !isset($data['phone_1']) || !isset($data['schedule']))
        {
            return false;
        }
        $id = (int)$id;
        $phone_1 = $this->db->escape($data['phone_1']);
        $phone_2 = isset($data['phone_2']) ? ($data['phone_2']) : null;
        $phone_3 = isset($data['phone_3']) ? ($data['phone_3']) : null;
        $address = isset($data['address']) ? ($data['address']) : null;
        $schedule = $this->db->escape($data['schedule']);
        $imege = $this->db->escape($data['imege']);

        if ( !$id )
        {
            // Add new record
            $sql = "
              insert into location
                set phone_1 = '{$phone_1}',
                    phone_2 = '{$phone_2}',
                    phone_3 = '{$phone_3}',
                    address = '{$address}',
                    schedule = '{$schedule}',
                    imege = '{$imege}'
            ";
        } else
        {
            // Update existing record
            $sql = "
              update location
                set phone_1 = '{$phone_1}',
                    phone_2 = '{$phone_2}',
                    phone_3 = '{$phone_3}',
                    address = '{$address}',
                    schedule = '{$schedule}',
                    imege = '{$imege}'
                where id_location = ($id)
            ";
        }
        return $this->db->query($sql);
    }

}

?>
