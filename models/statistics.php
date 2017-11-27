<?php
//Формирование запросов по статистике
class Statistics extends Model
{
    public function getListStat()//по умолчанию все страницы
    {
        $sql = "select * from visit where 1";// запрос к базе данных

        return $this->db->query($sql);
    }

    public function getByPages($id_pages)
    {
        $id_pages = $this->db->escape($id_pages);
        $sql = "select * from id_visit where id_pages = '{$id_pages}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

    public function getByIdVisit($id_visit)
    {
        $id_visit = (int)$id_visit;
        $sql = "select * from visit where id_visit = '{$id_visit}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

    public function saveVisit($data, $id_visit = null)
    {
        if (!isset($data['id_visit']) || !isset($data['id_pages'])) {
            return false;
        }

        $id_visit = (int)$id_visit;
        $id_pages = $this->db->escape($data['id_pages']);
        $views = $this->db->escape($data['views']);
        $total = $this->db->escape($data['total']);

        if (!$id_visit) {
            // Add new record
            $sql = "
              insert into visit
                set id_pages = '{$id_pages}',
                  views = '{$views}',
                  total = '{$total}'
            ";
        } else {
            // Update existing record
            $sql = "
              update visit
                set id_pages = '{$id_pages}',
                  views = '{$views}',
                  total = '{$total}'
                where id_visit = ($id_visit)
            ";
        }
        return $this->db->query($sql);
    }
    public function deleteVisit($id_visit)
    {
        $id_visit = (int)$id_visit;
        $sql = "delete from visit where id_visit = {$id_visit}";
        return $this->db->query($sql);//команда
    }

    public function getLocation()//по умолчанию все страницы
    {
        $sql = "select * from location where 1";// запрос к базе данных

        return $this->db->query($sql);
    }
}
?>
