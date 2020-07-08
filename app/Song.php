<?php
    namespace App;

    class Song{

        private $pdoconn;

        public function __construct($pdoconn) {
            $this->pdoconn = $pdoconn;
        }
        
        public function insert($details){

            $sql = 'INSERT INTO `songs` (
                        name,
                        description,
                        length,
                        artist_id,
                        genre_id,
                        mood_id,
                        file_path,
                        thumbnail
                        )
                    VALUES (
                        :name,
                        :description,
                        :length,
                        :artist_id,
                        :genre_id,
                        :mood_id,
                        :file_path,
                        :thumbnail
                        )';

            $query = $this->pdoconn->prepare($sql);

            $query->execute([
                ':name'=>$details['name'],
                ':description'=>$details['description'],
                ':length'=>$details['length'],
                ':artist_id'=>$details['artist_id'],
                ':genre_id'=>$details['genre_id'],
                ':mood_id'=>$details['mood_id'],
                ':file_path'=>$details['file_path'],
                ':thumbnail'=>$details['thumbnail'],
            ]);

            return $this->pdoconn->lastInsertId();
        }
        
        public function getAll(){
            $sql = 'SELECT 
                        songs.id, 
                        songs.name AS song_name,
                        songs.description AS song_description,
                        songs.length,
                        songs.thumbnail,
                        songs.artist_id,
                        songs.genre_id,
                        songs.mood_id,

                        artists.name AS artist_name,
                        artists.description AS artist_description,

                        genres.name AS genre_name,
                        genres.description AS genre_description,

                        moods.name AS mood_name,
                        moods.description AS mood_description
                    FROM  `songs`
                    LEFT JOIN `artists` 
                        ON songs.artist_id = artists.id
                    LEFT JOIN `genres` 
                        ON songs.genre_id = genres.id
                    LEFT JOIN `moods`
                        ON songs.mood_id = moods.id';
            $query = $this->pdoconn->prepare($sql);
            $query->execute();

            return $query->fetchAll(\PDO::FETCH_ASSOC);
        }
        
        public function getById($id){
            $sql = 'SELECT 
                        songs.id,
                        songs.name AS song_name,
                        songs.description AS song_description,
                        songs.length,
                        songs.thumbnail,
                        songs.artist_id,
                        songs.genre_id,
                        songs.mood_id,

                        artists.name AS artist_name,
                        artists.description AS artist_description,

                        genres.name AS genre_name,
                        genres.description AS genre_description,

                        moods.name AS mood_name,
                        moods.description AS mood_description

                    FROM  `songs`
                    LEFT JOIN `artists` 
                        ON songs.artist_id = artists.id
                    LEFT JOIN `genres` 
                        ON songs.genre_id = genres.id
                    LEFT JOIN `moods`
                        ON songs.mood_id = moods.id
                    WHERE songs.id=:id';

            $query = $this->pdoconn->prepare($sql);
            $query->bindValue(':id',$id);
            $query->execute();

            return $query->fetchAll(\PDO::FETCH_ASSOC);
        }
        
        
        public function getSongFile($id){
            $sql = 'SELECT 
                        file_path
                    FROM  `songs`
                    WHERE id=:id';

            $query = $this->pdoconn->prepare($sql);
            $query->bindValue(':id',$id);
            $query->execute();

            return $query->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function update($details){
            if(
                (!isset($details['thumbnail']))
                && (!isset($details['file_path']))
            ){
                $sql = 'UPDATE `songs` 
                        SET 
                            name=:name,
                            description=:description,
                            length=:length,
                            artist_id=:artist_id,
                            genre_id=:genre_id,
                            mood_id=:mood_id
                        WHERE id=:id';
                
                $query = $this->pdoconn->prepare($sql);

                $query->execute([
                    ':id'=>$details['id'],
                    ':name'=>$details['name'],
                    ':description'=>$details['description'],
                    ':length'=>$details['length'],
                    ':artist_id'=>$details['artist_id'],
                    ':genre_id'=>$details['genre_id'],
                    ':mood_id'=>$details['mood_id']
                ]);

                return $query->rowCount() > 0;
            }else{
                if(
                    (isset($details['thumbnail']))
                    && (isset($details['file_path']))
                ){
                    // both
                    $sql = 'UPDATE `songs` 
                            SET 
                                name=:name,
                                description=:description,
                                length=:length,
                                artist_id=:artist_id,
                                genre_id=:genre_id,
                                mood_id=:mood_id,
                                file_path=:file_path,
                                thumbnail=:thumbnail
                            WHERE id=:id';
                    
                    $query = $this->pdoconn->prepare($sql);

                    $query->execute([
                        ':id'=>$details['id'],
                        ':name'=>$details['name'],
                        ':description'=>$details['description'],
                        ':length'=>$details['length'],
                        ':artist_id'=>$details['artist_id'],
                        ':genre_id'=>$details['genre_id'],
                        ':mood_id'=>$details['mood_id'],
                        ':file_path'=>$details['file_path'],
                        ':thumbnail'=>$details['thumbnail']
                    ]);

                    return $query->rowCount() > 0;
                }else if(
                    (isset($details['thumbnail']))
                    && !(isset($details['file_path']))
                ){
                    // only thumbnail
                    $sql = 'UPDATE `songs` 
                            SET 
                                name=:name,
                                description=:description,
                                length=:length,
                                artist_id=:artist_id,
                                genre_id=:genre_id,
                                mood_id=:mood_id,
                                thumbnail=:thumbnail
                            WHERE id=:id';
                    
                    $query = $this->pdoconn->prepare($sql);

                    $query->execute([
                        ':id'=>$details['id'],
                        ':name'=>$details['name'],
                        ':description'=>$details['description'],
                        ':length'=>$details['length'],
                        ':artist_id'=>$details['artist_id'],
                        ':genre_id'=>$details['genre_id'],
                        ':mood_id'=>$details['mood_id'],
                        ':thumbnail'=>$details['thumbnail']
                    ]);

                    return $query->rowCount() > 0;

                } else{

                    //only song file

                    $sql = 'UPDATE `songs` 
                            SET 
                                name=:name,
                                description=:description,
                                length=:length,
                                artist_id=:artist_id,
                                genre_id=:genre_id,
                                mood_id=:mood_id,
                                file_path=:file_path
                            WHERE id=:id';
                    
                    $query = $this->pdoconn->prepare($sql);

                    $query->execute([
                        ':id'=>$details['id'],
                        ':name'=>$details['name'],
                        ':description'=>$details['description'],
                        ':length'=>$details['length'],
                        ':artist_id'=>$details['artist_id'],
                        ':genre_id'=>$details['genre_id'],
                        ':mood_id'=>$details['mood_id'],
                        ':file_path'=>$details['file_path']
                    ]);

                    return $query->rowCount() > 0;

                }
            }

        }
        
        public function delete($id){
            $sql = 'DELETE FROM `songs` 
                    WHERE id=:id';

            $query = $this->pdoconn->prepare($sql);
            $query->bindValue(':id',$id);
            $query->execute();

            return $query->rowCount() > 0;
        }
        
    }
    
?>