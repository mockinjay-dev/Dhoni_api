<?php
namespace App;

class SQLConnection{
    private $pdo;
    private $host = "localhost";
    private $user = "root";
    private $database = "spotifydb";
    private $pwd= "";

    public function connect(){
        try {
            
            if($this->pdo == null){

                // $this->pdo = new \PDO("sqlite:".Config::PATH_OF_FILE);
                $this->pdo = new \PDO("mysql:host=$this->host; dbname=$this->database", $this->user, $this->pwd, array( \PDO::ATTR_PERSISTENT => true ));
                
                $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            }

            return $this->pdo;

        } catch (\PDOException $th) {
            throw new \Exception("ERR in SQLConnection : - ".$th, 1);
        }
    }
}