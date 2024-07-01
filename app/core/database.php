    <?php

    class Database {
        private $host = '127.0.0.1';
        private $port = '5432';
        private $dbname = 'gesdette';
        private $user = 'papis';
        private $password = 'Passer2020@';
        private $pdo;

 
        public function __construct() {
            $this->connect();
        }

        private function connect() {
            try {
                $dsn = "pgsql:host=$this->host;port=$this->port;dbname=$this->dbname";
                $this->pdo = new PDO($dsn, $this->user, $this->password);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Connection failed: ' . $e->getMessage());
            }
        }

        public function getConnection() {
            return $this->pdo;
        }

        // Fonction pour executer des requêtes SQL 
        public function query($sql, $params = []) {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        }
    }


    $con = new Database();
    ?>