<?php 

    // PDO Database Class
    // Going To Connect To Database
    // Going To Create Prepared Statements
    // Going To Bind Values
    // Going To Return Rows & Results

    class Database {
        private $host = DB_HOST;
        private $user = DB_USER;
        private $password = DB_PASSWORD;
        private $dbname = DB_NAME;

        private $dbh;
        private $stmt;
        private $error;

        public function __construct() {
            // Set DSN
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );

            // Create PDO Instance
            try{
                $this->dbh = new PDO($dsn, $this->user, $this->password, $options);
            } catch(PDOException $error) {
                $this->error = $error->getMessage();
                echo $this->error;
            }
        }

        // Prepare Statement With Query
        public function query($sql) {
            $this->stmt = $this->dbh->prepare($sql);
        }

        // Bind Values
        public function bind($param, $value, $type = null) {
            if(is_null($type)) {
                switch(true) {
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                    default:
                        $type = PDO::PARAM_STR;
                }
            }

            $this->stmt->bindValue($param, $value, $type);
        }

        // Execute The Prepared Statement
        public function execute() {
            return $this->stmt->execute();
        }

        // Get Results Set As Array Of Objects
        public function resultSet() {
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        }

        // Get Single Record As Object
        public function single() {
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }

        // Get Row Count
        public function rowCount() {
            return $this->stmt->rowCount();
        }
    }

?>