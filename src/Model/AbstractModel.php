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
        return $this->db->insert($data);
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
            return each($result);
        }

        return null;
    }

    public function find(array $criteria = [])
    {
        $query = 'SELECT * FROM `' . $this->getTableName() . '`';
        
        return $this->db->executeQuery($query, $criteria);
    }

    public function buildQuery(string $query)
    {
        return $this->db->executeQuery($query);
    }
}
