<?php 

class MysqlAdapter implements Adapter {

    private $connection;
    
    public function __construct($host, $database, $user, $pass) {
        $pdo = new PDO('mysql:host=' . $host . ';dbname=' . $database, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->connection = $pdo;
    }

    public function find($email) {
        
        $sql = " SELECT id, name, email, type, data, file
                   FROM attendee
                  WHERE email = :email
        ";
        $statement = $this->connection->prepare($sql);
        $statement->bindParam('email', $email);
        $statement->execute();

        return $statement->fetchAll();
    }
}