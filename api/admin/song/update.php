<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("HTTP/1.1 200 OK");

use App\Admin;
use App\Song;

    require_once __DIR__."/../../../config.php";
    require __DIR__."/../auth.php";

    if(
        (!(isset($decoded->data->role))
        || !((new Admin($pdoconn))->isAdmin($decoded->data->email)))
    ){
        http_response_code(401);

        echo json_encode(array(
            "error"=>"Access Denied! Non admin user",
        ));
        exit();
    } 

    if(
        !(
            (isset($_POST['id']) && !empty($_POST['id']))
            &&(isset($_POST['name']) && !empty($_POST['name']))
            && (isset($_POST['description']) && !empty($_POST['description']))
            && (isset($_POST['length']) && !empty($_POST['length']))
            && (isset($_POST['artist_id']) && !empty($_POST['artist_id']))
            && (isset($_POST['genre_id']) && !empty($_POST['genre_id']))
            && (isset($_POST['mood_id']) && !empty($_POST['mood_id']))
        )
     ){
         http_response_code(401);
         echo json_encode(array(
             "error"=>"Please fill all details"
         ));
         exit();
     }

    //  Details
     $id = $_POST['id']; 
     $song_name = $_POST['name']; 
     $song_description = $_POST['description']; 
     $song_length = $_POST['length']; 
     $artist_id = $_POST['artist_id']; 
     $genre_id = $_POST['genre_id']; 
     $mood_id = $_POST['mood_id'];


    if((
        (!isset($_FILES['song_file']) || empty($_FILES['song_file']['tmp_name']))
        && (!(isset($_FILES['thumbnail'])) || empty($_FILES['thumbnail']['tmp_name']))
    )){

        $song = new Song($pdoconn);

        $newSong = $song->update(array(
                'id'=>$id,
                'name'=>$song_name,
                'description'=>$song_description,
                'length'=>$song_length,
                'artist_id'=>$artist_id,
                'genre_id'=>$genre_id,
                'mood_id'=>$mood_id,
            ));

        echo json_encode(array(
            "msg"=>"Song updated.",
        ));

    }else{
        // using realpath to move files, but db needs only relative path;
        $upload_path_db = "files/songs/";
        $upload_path = (realpath((__DIR__."/../../../files/songs")))."/";

        if((
            (isset($_FILES['song_file']) && !empty($_FILES['song_file']['tmp_name']))
            && ((isset($_FILES['thumbnail'])) && !empty($_FILES['thumbnail']['tmp_name']))
        )){
            // both
            
            // Song File
            $valid_files = "mp3|wav";
            $file = $_FILES['song_file'];
            $file_tmp_name = $file['tmp_name'];
            $err_file = $file['error'];

            // getting ext for validation
            $old_file_name = explode(".",$file['name']);
            $file_ext = $old_file_name[(count($old_file_name)-1)];

            // Thumbnail
            $valid_thumbs = "jpg|png|svg|jpeg";
            $thumb = $_FILES['thumbnail'];
            $thumb_tmp_name = $thumb['tmp_name'];
            $err_thmb = $thumb['error'];

            // getting ext for validation
            $old_thumb_name = explode(".",$thumb['name']);
            $thumb_ext = $old_thumb_name[(count($old_thumb_name)-1)];

            if(($err_file > 0) || ($err_thmb > 0)){
                $response = array(
                    "error" => "Error uploading the files!",
                );
                exit();
            }

            /* 
                neither != false nor === true will return the desired result.
                and you thought ONLY JS IS WEIRD ?
            */
            if(
                (!(strpos($valid_files, $file_ext) !== false))
                || (!(strpos($valid_thumbs, $thumb_ext) !== false))
            ){
                http_response_code(400);
                echo json_encode(array(
                    "error"=>"Only mp3 and wav extensions are allowed.",
                ));
                exit();
            }

            // "N a M e.ext" >>> "n-a-m-e.ext"
            $file_name= (strtolower(preg_replace("/[ _]/","-",$song_name)))."-file.".$file_ext;
            $thumb_name= (strtolower(preg_replace("/[ _]/","-",$song_name)))."-thumbnail.".$thumb_ext;

            if(
                (move_uploaded_file($file_tmp_name,($upload_path.$file_name)))
                && (move_uploaded_file($thumb_tmp_name,($upload_path.$thumb_name)))
            ){
                $song = new Song($pdoconn);

                $newSong = $song->update(array(
                        'id'=>$id,
                        'name'=>$song_name,
                        'description'=>$song_description,
                        'length'=>$song_length,
                        'artist_id'=>$artist_id,
                        'genre_id'=>$genre_id,
                        'mood_id'=>$mood_id,
                        'file_path'=>($upload_path_db.$file_name),
                        'thumbnail'=>($upload_path_db.$thumb_name),
                    ));

                echo json_encode(array(
                    "msg"=>"Song updated.",
                ));
            }else{
                echo json_encode(array(
                    "error"=>"File upload failed",
                ));
            }

        }else if(
            (isset($_FILES['song_file']) && !empty($_FILES['song_file']['tmp_name'])) 
            && (!(isset($_FILES['thumbnail'])) || empty($_FILES['thumbnail']['tmp_name']))
        ){
            // only music file

            // Song File
            $valid_files = "mp3|wav";
            $file = $_FILES['song_file'];
            $file_tmp_name = $file['tmp_name'];
            $err_file = $file['error'];

            // getting ext for validation
            $old_file_name = explode(".",$file['name']);
            $file_ext = $old_file_name[(count($old_file_name)-1)];

            if(($err_file > 0)){
                echo json_encode(array(
                    "error" => "Error uploading the files!",
                ));
                exit();
            }

            /* 
                neither != false nor === true will return the desired result.
                and you thought ONLY JS IS WEIRD ?
            */

            if(
                (!(strpos($valid_files, $file_ext) !== false))
            ){
                http_response_code(400);
                echo json_encode(array(
                    "error"=>"Only mp3 and wav extensions are allowed.",
                ));
                exit();
            }
            
            // "N a M e.ext" >>> "n-a-m-e.ext"
            $file_name= (strtolower(preg_replace("/[ _]/","-",$song_name)))."-file.".$file_ext;

            if(
                (move_uploaded_file($file_tmp_name,($upload_path.$file_name)))
            ){
                $song = new Song($pdoconn);

                $newSong = $song->update(array(
                        'id'=>$id,
                        'name'=>$song_name,
                        'description'=>$song_description,
                        'length'=>$song_length,
                        'artist_id'=>$artist_id,
                        'genre_id'=>$genre_id,
                        'mood_id'=>$mood_id,
                        'file_path'=>($upload_path_db.$file_name),
                    ));

                echo json_encode(array(
                    "msg"=>"Song updated.",
                ));

            }else{
                echo json_encode(array(
                    "error"=>"File upload failed!",
                ));
            }

        }else{
            //only thumbnail
            
            // Thumbnail
            $valid_thumbs = "jpg|png|svg|jpeg";
            $thumb = $_FILES['thumbnail'];
            $thumb_tmp_name = $thumb['tmp_name'];
            $err_thmb = $thumb['error'];

            // getting ext for validation
            $old_thumb_name = explode(".",$thumb['name']);
            $thumb_ext = $old_thumb_name[(count($old_thumb_name)-1)];

            if(($err_thmb > 0)){
                echo json_encode(array(
                    "error" => "Error uploading the files!",
                ));
                exit();
            }

            /* 
                neither != false nor === true will return the desired result.
                and you thought ONLY JS IS WEIRD ?
            */
            if(
                (!(strpos($valid_thumbs, $thumb_ext) !== false))
            ){
                http_response_code(400);
                echo json_encode(array(
                    "error"=>"Only jpg, png, svg, jpeg extensions are allowed.",
                ));
                exit();
            }

            // "N a M e.ext" >>> "n-a-m-e.ext"
            $thumb_name= (strtolower(preg_replace("/[ _]/","-",$song_name)))."-thumbnail.".$thumb_ext;

            if(
                (move_uploaded_file($thumb_tmp_name,($upload_path.$thumb_name)))
            ){
                $song = new Song($pdoconn);

                $newSong = $song->update(array(
                        'id'=>$id,
                        'name'=>$song_name,
                        'description'=>$song_description,
                        'length'=>$song_length,
                        'artist_id'=>$artist_id,
                        'genre_id'=>$genre_id,
                        'mood_id'=>$mood_id,
                        'thumbnail'=>($upload_path_db.$thumb_name),
                    ));

                    echo json_encode(array(
                        "msg"=>"Song updated.",
                    ));
            }else{
                echo json_encode(array(
                    "error"=>"File upload failed",
                ));
            }

        }
    }

?>