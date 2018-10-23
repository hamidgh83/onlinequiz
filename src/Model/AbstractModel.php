<?php

namespace Model;

abstract class AbstractModel
{
    protected $db;

    public function __construct()
    {
        $this->db = new DatabaseHandler();
    }

    public function insert(array $data)
    {
        $columns = array_keys($data);
        $params  = $columns;
        array_walk($params, function(&$val) {
            $val = ':' . $val;
        });
        
        $query = "INSERT INTO `" . $this->getTablename() . "` (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $params) . ")";

        return $this->db->insert($query, $data);
    }

    public function update(array $data)
    {
        // not implemented
    }
    
    public function delete(int $id)
    {
        // not implemented
    }

    public function findById(int $id)
    {
        if ($result = $this->find(['id' => $id])) {
            return current($result ? $result : []);
        }

        return null;
    }

    public function find(array $criteria = [])
    {
        $query = 'SELECT * FROM `' . $this->getTableName() . '`';
        
        return $this->db->executeQuery($query, $criteria);
    }

    public function numRows(array $criteria = [])
    {
        $query = 'SELECT count(*) FROM `' . $this->getTableName() . '`';

        return $this->db->numRows($query, $criteria);
    }

    public function buildQuery(string $query)
    {
        return $this->db->executeQuery($query);
    }
}
