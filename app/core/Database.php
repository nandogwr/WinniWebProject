<?php
class Database
{
   private $host = DB_HOST;
   private $user = DB_USER;
   private $pass = DB_PASS;
   private $db_name = DB_NAME;

   private $dbh;
   private $stmt;

   public function __construct()
   {
      $dsn = "mysql:host=$this->host;dbname=$this->db_name";

      $option = [
         PDO::ATTR_PERSISTENT => true,
         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      ];

      try {
         $this->dbh = new PDO($dsn, $this->user, $this->pass, $option);
      } catch (PDOException $e) {
         die($e->getMessage());
      }
   }

   public function query($query)
   {
      $this->stmt = $this->dbh->prepare($query);
   }

   public function bind($param, $value, $type = null)
   {
      if (is_null($type)) {
         switch (true) {
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

      $this->stmt->bindvalue($param, $value, $type);
   }

   public function execute()
   {
      try {
         $this->stmt->execute();
         return $this->stmt;
      } catch (PDOException $e) {
         die($e->getMessage());
      }
   }
   public function insert_id()
   {
      try {
         $this->execute();
         return $this->dbh->lastInsertId();
      } catch (PDOException $e) {
         die($e->getMessage());
      }
   }

   public function tableExists($table)
   {
      try {
         $this->query("SHOW TABLES LIKE :table");
         $this->bind(':table', $table);
         $this->execute();
         return $this->rowCount() > 0;
      } catch (PDOException $e) {
         return false;
      }
   }


   public function resultSet()
   {
      $this->execute();
      return $this->stmt->fetchAll(PDO::FETCH_OBJ);
   }

   public function single()
   {
      $this->execute();
      return $this->stmt->fetch(PDO::FETCH_OBJ);
   }

   public function rowCount()
   {
      return $this->stmt->rowCount();
   }
}
