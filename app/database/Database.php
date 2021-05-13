<?php


namespace Database\v1;

use PDO;
use PDOException;

class Database
{
    /**
     * @var PDO
     */
    public PDO $connection;
    private string $host = 'localhost';
    private string $port = '3306';
    private string $dbname = 'logs-to-db';
    private string $username = 'admin';
    private string $password = 'ak291177';

    public function insert($data) //передавать массив объектов логов
    {
        $dbh = $this->connect();

        foreach ($data as $item) {
            $stmt = $dbh->prepare(
                "INSERT INTO logs (user_id, first_name, second_name, message, created_at) VALUES (:id, :first_name, :second_name, :message, :created_at);"
            );

            $stmt->bindParam(':id', $item->user_id);
            $stmt->bindParam(':first_name', $item->first_name);
            $stmt->bindParam(':second_name', $item->second_name);
            $stmt->bindParam(':message', $item->message);
            $stmt->bindParam(':created_at', $item->created_at);

            $stmt->execute();
        }

    }

    public function connect(): PDO
    {
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try {
            $this->connection = new PDO('mysql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->dbname, $this->username, $this->password, $options);
        } catch (PDOException $exception) {
            die('Connection error: ' . $exception->getMessage());
        }

        return $this->connection;
    }
}