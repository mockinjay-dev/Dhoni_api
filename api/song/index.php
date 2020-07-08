<?php

use App\Song;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

    
    require_once __DIR__."/../../config.php";
 
    $song = new Song($pdoconn);
    $json = array();


    if(isset($_REQUEST['id']) && !(empty($_REQUEST['id']))){

        $onlySong = $song->getById($_REQUEST['id']);

        if(count($onlySong) > 0){

            $json['song']=$onlySong[0];

            echo json_encode($json);

        }else{

            http_response_code(404);

            $json['error']="song not found.";

            echo json_encode($json);
        }
    }else{
        $allSongs = $song->getAll();

        if(count($allSongs) > 0){

            $json['songs']=$allSongs;

            $json['total']=count($allSongs);

            echo json_encode($json);

        }else{
            http_response_code(404);

            $json['error']="song not found.";
            
            echo json_encode($json);
        }
    }




    

?>