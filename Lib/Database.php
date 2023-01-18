<?php
class Database {
    protected $host = 'localhost';
    protected $username = 'chrisvanlier';
    protected $password = '#1Geheim';
    protected $database = 'cms';
    protected $connection = null;

    // required for pdo


    public function __construct()
    {
        $this->connection = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
    }

    public function query($query, $params = [])
    {
        $statement = $this->connection->prepare($query);
        foreach ($params as $key => $value) {
            $statement->bindValue($key, $value);
        }
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}