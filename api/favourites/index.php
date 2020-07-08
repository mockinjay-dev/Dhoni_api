<?php

use App\Favorite;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("HTTP/1.1 200 OK");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    
    require_once __DIR__."/../../config.php";
    require __DIR__."/../auth.php";

    $favorite = new Favorite($pdoconn);
    $json = array();




    if(isset($_REQUEST['songid']) && !(empty($_REQUEST['songid']))){

        $onlyFav = $favorite->getBySongId($decoded->data->id,$_REQUEST['songid']);

        if(count($onlyFav) > 0 && $onlyFav[0]['song_id'] !== null){

            $json['favorite']=$onlyFav[0];

            echo json_encode($json);

        }else{

            http_response_code(404);

            $json['favorite']= null;

            echo json_encode($json);
        }
    }else{
        $allfavorites = $favorite->getAll($decoded->data->id);

        if(count($allfavorites) > 0){

            $json['favorites']=$allfavorites;

            $json['total']=count($allfavorites);

            echo json_encode($json);

        }else{
            
            http_response_code(404);

            $json['favorites']=array();

            echo json_encode($json);
        }
    }


?>