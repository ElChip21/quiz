<?php
class DatabaseConnection {
    private $hostname = 'localhost';
    private $dbname = 'quiz';
    private $username = 'root';
    private $password = '';

    private $pdo;

    public function __construct() {
        $dsn = "mysql:host=$this->hostname;dbname=$this->dbname";

        // Tentative de connexion avec levée d'une exception en cas de problème
        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            throw new Exception('Erreur de connexion à la base de données : ' . $e->getMessage());
        }
    }

    public function getPDO() {
        return $this->pdo;
    }
}
?>
