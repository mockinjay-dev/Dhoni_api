<?php
    namespace App;
    
    class Admin{
        
        private $pdoconn;
        
        public function __construct($pdoconn) {
            $this->pdoconn = $pdoconn;
        }
        public function isAdmin($email){
            $sql = 'SELECT email
                    FROM `admin` 
                    WHERE email=:email';

            $query = $this->pdoconn->prepare($sql);
            $query->bindValue(':email',$email);

            $query->execute();

            return count($query->fetchAll(\PDO::FETCH_ASSOC)) > 0;
            
        }
        public function update($data){
            $sql = 'UPDATE `admin` 
                    SET
                        name=:name,
                        email=:email,
                        password=:password
                    WHERE id=:id';

            $query = $this->pdoconn->prepare($sql);
            
            $query->execute([
                ':id'=>$data['id'],
                ':name'=>$data['name'],
                ':email'=>$data['email'],
                ':password'=>$data['password'],
            ]);

            return $query->rowCount() > 0;
        }
        
        public function login($data) {
            $sql = 'SELECT *
                    FROM `admin` 
                    WHERE email=:email AND password=:password';

            $query = $this->pdoconn->prepare($sql);

            $query->execute([
                ":email"=>$data["email"],
                ":password"=>$data["password"],
            ]);

            return $query->fetchAll(\PDO::FETCH_ASSOC);
        }
        
        public function insert($data){

            $sql = 'INSERT INTO `admin` (
                        name, 
                        email,
                        number,
                        password
                    ) 
                    VALUES (
                        :name,
                        :email,
                        :number,
                        :password
                    )';

            $query = $this->pdoconn->prepare($sql);

            $query->execute([
                ':name'=>$data['name'],
                ':email'=>$data['email'],
                ':number'=>$data['number'],
                ':password'=>$data['password'],
            ]);

            return $this->pdoconn->lastInsertId();
        }
        
        public function getAll(){
            $sql = 'SELECT *
                    FROM  `admin`';
            $query = $this->pdoconn->prepare($sql);
            $query->execute();

            return $query->fetchAll(\PDO::FETCH_ASSOC);
        }
        
        public function getById($id){
            $sql = 'SELECT *
                    FROM  `admin`
                    WHERE id=:id';

            $query = $this->pdoconn->prepare($sql);
            $query->bindValue(':id',$id);
            $query->execute();

            return $query->fetchAll(\PDO::FETCH_ASSOC);
        }
        
        public function delete($id){
            $sql = 'DELETE FROM `admin` 
                    WHERE id=:id';

            $query = $this->pdoconn->prepare($sql);
            $query->bindValue(':id',$id);

            return $query->execute();
        }
        
    }
    
?>