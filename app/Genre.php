<?php
    namespace App;

    class Genre{

        private $pdoconn;

        public function __construct($pdoconn) {
            $this->pdoconn = $pdoconn;
        }
        
        public function insert($name,$description){

            $sql = 'INSERT INTO `genres` (name, description) 
                    VALUES (:name,:description)';

            $query = $this->pdoconn->prepare($sql);
            $query->bindValue(':name',$name);
            $query->bindValue(':description',$description);
            $query->execute();

            return $this->pdoconn->lastInsertId();
        }
        
        public function getAll(){
            $sql = 'SELECT *
                    FROM  `genres`';
            $query = $this->pdoconn->prepare($sql);
            $query->execute();

            return $query->fetchAll(\PDO::FETCH_ASSOC);
        }
        
        public function getById($id){
            $sql = 'SELECT *
                    FROM  `genres`
                    WHERE id=:id';

            $query = $this->pdoconn->prepare($sql);
            $query->bindValue(':id',$id);
            $query->execute();

            return $query->fetchAll(\PDO::FETCH_ASSOC);
        }
        
        public function update($data){
            $sql = 'UPDATE `genres` 
                    SET
                        name=:name,
                        description=:description
                        
                    WHERE id=:id';

            $query = $this->pdoconn->prepare($sql);
            $query->execute([
                ':id'=>$data['id'],
                ':name'=>$data['name'],
                ':description'=>$data['description'],
            ]);

            return $query->rowCount() > 0;
        }
        
        public function delete($id){
            $sql = 'DELETE FROM `genres` 
                    WHERE id=:id';

            $query = $this->pdoconn->prepare($sql);
            $query->bindValue(':id',$id);
            $query->execute();

            return $query->rowCount() > 0;
        }
        
    }
    
?>