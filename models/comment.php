<?php

class Comment extends Model
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

    public function save($data, $id = null)
    {
        if ( !isset($data['alias']) || !isset($data['category']) || !isset($data['body']))
        {
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
        $analytics = isset($data['analytics']) ? 1 : 0;

        if ( !$id )
        {
            // Add new record
            $sql = "
              insert into pages
                set category = '{$category}',
                  alias = '{$alias}',
                  tegs = '{$tegs}',
                  dates = '{$dates}',
                  body = '{$body}',
                  comments = '{$comments}',
                  img = '{$img}'
                  analytics = '{$analytics}'
            ";
        } else
        {
            // Update existing record
            $sql = "
              update pages
                set category = '{$category}',
                  alias = '{$alias}',
                  tegs = '{$tegs}',
                  dates = '{$dates}',
                  body = '{$body}',
                  comments = '{$comments}',
                  img = '{$img}'
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
        return $this->db->query($sql);
    }
}



?>