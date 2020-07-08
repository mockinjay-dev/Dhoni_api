<?php

use App\Artist;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

    require_once __DIR__."/../../config.php";

    $artist = new Artist($pdoconn);
    $json = array();

    if(isset($_REQUEST['id']) && !(empty($_REQUEST['id']))){

        $onlyArtist = $artist->getById($_REQUEST['id']);

        if(count($onlyArtist) > 0){

            $json['artist']=$onlyArtist[0];

            echo json_encode($json);

        }else{

            http_response_code(404);

            $json['error']="Artist not found.";

            echo json_encode($json);
        }
    }else{
        $allartists = $artist->getAll();

        if(count($allartists) > 0){

            $json['artists']=$allartists;

            $json['total']=count($allartists);

            echo json_encode($json);

        }else{
            http_response_code(404);

            $json['error']="Artist not found.";
            
            echo json_encode($json);
        }
    }


?>