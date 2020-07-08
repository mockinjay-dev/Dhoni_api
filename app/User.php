<?php
    namespace App;

    class User{

        private $pdoconn;

        public function __construct($pdoconn) {
            $this->pdoconn = $pdoconn;
        }


        public function login($data) {
            $sql = 'SELECT *
                    FROM `users` 
                    WHERE email=:email AND password=:password';

            $query = $this->pdoconn->prepare($sql);

            $query->execute([
                ":email"=>$data["email"],
                ":password"=>$data["password"],
            ]);

            return $query->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function insert($data){

            $sql = 'INSERT INTO `users` (
                        name, 
                        email,
                        number,
                        password,
                        gender,
                        path
                    ) 
                    VALUES (
                        :name,
                        :email,
                        :number,
                        :password,
                        :gender,
                        :path
                    )';

            $query = $this->pdoconn->prepare($sql);

            if(isset($data['path'])){
                $query->execute([
                    ':name'=>$data['name'],
                    ':email'=>$data['email'],
                    ':number'=>$data['number'],
                    ':password'=>$data['password'],
                    ':gender'=>$data['gender'],
                    ':path'=>$data['path']
                ]);
            }else{
                $query->execute([
                    ':name'=>$data['name'],
                    ':email'=>$data['email'],
                    ':number'=>$data['number'],
                    ':password'=>$data['password'],
                    ':gender'=>$data['gender'],
                    ':path'=>null
                ]);
            }

            return $this->pdoconn->lastInsertId();
        }
        
        public function getAll(){
            $sql = 'SELECT *
                    FROM  `users`';
            $query = $this->pdoconn->prepare($sql);
            $query->execute();

            return $query->fetchAll(\PDO::FETCH_ASSOC);
        }
        
        public function getById($id){
            $sql = 'SELECT *
                    FROM  `users`
                    WHERE id=:id';

            $query = $this->pdoconn->prepare($sql);
            $query->bindValue(':id',$id);
            $query->execute();

            return $query->fetchAll(\PDO::FETCH_ASSOC);
        }
        
        public function update($data){

            if(isset($data['path'])){
                $sql = 'UPDATE `users` 
                        SET 
                            name=:name,
                            email=:email,
                            number=:number,
                            password=:password,
                            gender=:gender,
                            path=:path
                        WHERE id=:id';
                $query = $this->pdoconn->prepare($sql);

                $query->execute([
                    ':id'=>$data['id'],
                    ':name'=>$data['name'],
                    ':email'=>$data['email'],
                    ':number'=>$data['number'],
                    ':password'=>$data['password'],
                    ':gender'=>$data['gender'],
                    ':path'=>$data['path']
                ]);
            }else{
                $sql = 'UPDATE `users` 
                        SET 
                            name=:name,
                            email=:email,
                            number=:number,
                            password=:password,
                            gender=:gender
                        WHERE id=:id';

                $query = $this->pdoconn->prepare($sql);

                $query->execute([
                    ':id'=>$data['id'],
                    ':name'=>$data['name'],
                    ':email'=>$data['email'],
                    ':number'=>$data['number'],
                    ':password'=>$data['password'],
                    ':gender'=>$data['gender'],
                ]);
            }

            return $query->rowCount() > 0;
        }
        
        public function delete($id){
            $sql = 'DELETE FROM `users` 
                    WHERE id=:id';

            $query = $this->pdoconn->prepare($sql);
            $query->bindValue(':id',$id);

            return $query->execute();
        }
        
    }
    
?>