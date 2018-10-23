<?php

namespace Model;

use PDO;
use PDOException;

class DatabaseHandler
{
    private $db;

    public function __construct()
    {
        // Database info
        $host   = 'localhost';
        $dbUser = 'root';
        $dbPass = 'root';
        $dbName = 'onlinequiz';

        $this->db = $this->connect($host, $dbUser, $dbPass, $dbName);
    }
    
    /**
     * Connect to database
     *
     * @param string $host
     * @param string $dbUser
     * @param string $dbPass
     * @param string $dbName
     * @return mysqli
     */
    public function connect($host = 'localhost', $dbUser = 'root', $dbPass = '', $dbName)
    {
        // PDO options
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $conn = "mysql:host=$host;dbname=$dbName;charset=utf8mb4";
        try {
            $db = new PDO($conn, $dbUser, $dbPass, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $db;
    }

    public function insert($sql, $params)
    {
        $stmt = $this->db->prepare($sql);

        $stmt->execute($params); 

        return $this->db->lastInsertId();
    }

    /**
     * Execute a given query
     *
     * @param string $sql
     * @return array
     */
    public function executeQuery($sql, $params = [])
    {
        if(count($params) > 0) {
            $conditions = array_keys($params);
            array_walk($conditions, function(&$val) {
                $val = $val . '=:' . $val;
            });

            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }

        $stmt = $this->db->prepare($sql);
        
        $stmt->execute($params); 

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get number of rows 
     *
     * @param string $sql
     * @param array $params
     * @return int
     */
    public function numRows($sql, $params = [])
    {
        if(count($params) > 0) {
            $conditions = array_keys($params);
            array_walk($conditions, function(&$val) {
                $val = $val . '=:' . $val;
            });

            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }
        
        $result = $this->db->prepare($sql); 
        
        $result->execute($params); 
        
        return $result->fetchColumn(); 
    }
}