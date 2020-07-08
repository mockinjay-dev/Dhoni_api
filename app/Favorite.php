<?php
    namespace App;

    class Favorite{

        private $pdoconn;

        public function __construct($pdoconn) {
            $this->pdoconn = $pdoconn;
        }
        
        public function add($user_id,$song_id){

            $sql = 'INSERT INTO `favorites` (user_id, song_id) 
                    VALUES (:user_id,:song_id)';

            $query = $this->pdoconn->prepare($sql);
            $query->bindValue(':user_id',$user_id);
            $query->bindValue(':song_id',$song_id);
            // $query->execute();

            return ($query->execute());
        }

        public function getAll($user_id) {
            
            $sql = 'SELECT DISTINCT
                        songs.id AS song_id, 
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
                    FROM `favorites`
                    LEFT JOIN `songs`
                        ON favorites.song_id = songs.id
                    LEFT JOIN `artists` 
                        ON songs.artist_id = artists.id
                    LEFT JOIN `genres` 
                        ON songs.genre_id = genres.id
                    LEFT JOIN `moods`
                        ON songs.mood_id = moods.id
                    WHERE favorites.user_id=:user_id';

            $query = $this->pdoconn->prepare($sql);
            $query->bindValue(':user_id',$user_id);
            $query->execute();

            return $query->fetchAll(\PDO::FETCH_ASSOC);
        }

        
        public function getBySongId($user_id,$song_id) {
            
            $sql = 'SELECT 
                        songs.id AS song_id, 
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
                    FROM `favorites`
                    LEFT JOIN `songs`
                        ON favorites.song_id = songs.id
                    LEFT JOIN `artists` 
                        ON songs.artist_id = artists.id
                    LEFT JOIN `genres` 
                        ON songs.genre_id = genres.id
                    LEFT JOIN `moods`
                        ON songs.mood_id = moods.id
                    WHERE favorites.user_id=:user_id and favorites.song_id=:song_id';

            $query = $this->pdoconn->prepare($sql);
            $query->bindValue(':user_id',$user_id);
            $query->bindValue(':song_id',$song_id);
            $query->execute();

            return $query->fetchAll(\PDO::FETCH_ASSOC);
        }
        
        
        public function delete($user_id,$song_id){

            $sql = 'DELETE FROM `favorites` 
                    WHERE user_id=:user_id AND song_id=:song_id';

            $query = $this->pdoconn->prepare($sql);
            $query->bindValue(':user_id',$user_id);
            $query->bindValue(':song_id',$song_id);
            $query->execute();

            return $query->rowCount() > 0;
        }
        
    }
    
?>