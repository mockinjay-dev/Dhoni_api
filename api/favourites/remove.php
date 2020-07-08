<?php

use App\Favorite;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("HTTP/1.1 200 OK");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    
    require_once __DIR__."/../../config.php";
    require __DIR__."/../auth.php";

    if(
        !(isset($_REQUEST['song']))
        || empty($_REQUEST['song'])
    ){
        http_response_code(400);
        echo json_encode(array(
            "error"=>"A song is expected!"
        ));
        exit();
    }

    $favorite = new Favorite($pdoconn);

    $newFav = $favorite->delete($decoded->data->id,$_REQUEST['song']);

    if(($newFav)){
        $json = array();
        $json['msg']="Removed From favorites.";
        echo json_encode($json);
    }

?>