<?php

namespace TodoPhp\Model;

use PDO;
use TodoPhp\Database\Database;

class Task
{
    public $table = 'tasks';

    private function db()
    {
        return Database::connection();
    }

    public function total()
    {
        $stmt = $this->db()->query("select count(id) from {$this->table}");
        $stmt->execute();

        return $stmt->fetchColumn(0);
    }

    public function get(array $sort, int $offset, int $limit)
    {
        $stmt = $this->db()->prepare("select id, user_name, user_email, task_text, status from {$this->table} order by {$sort[0]} {$sort[1]} limit :offset, :limit");
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id)
    {
        $stmt = $this->db()->prepare("select id, user_name, user_email, task_text, status from {$this->table} where id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function add(array $array)
    {
        $keys = array_keys($array);

        $stmt = $this->db()->prepare('insert into ' . $this->table . '(' . implode(',', $keys) . ')
            values(' . substr(str_repeat('?,', count($keys)), 0, -1) . ')');

        return $stmt->execute(array_values($array));
    }

    public function update(int $id, array $array)
    {
        $setFields = [];

        foreach ($array as $k => $v) {
            $setFields[$k] = "{$k} = ?";
        }

        $stmt = $this->db()->prepare('update ' . $this->table . ' set ' . implode(', ', $setFields) . ' where id = ?');

        $array['id'] = $id;

        return $stmt->execute(array_values($array));
    }
}