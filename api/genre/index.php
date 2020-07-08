<?php

use App\Genre;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


    require_once __DIR__."/../../config.php";

    $genre = new Genre($pdoconn);
 




    if(isset($_REQUEST['id']) && !(empty($_REQUEST['id']))){

        $onlyGenre = $genre->getById($_REQUEST['id']);

        if(count($onlyGenre) > 0){

            $json['genre']=$onlyGenre[0];

            echo json_encode($json);

        }else{

            http_response_code(404);

            $json['error']="genre not found.";

            echo json_encode($json);
        }
    }else{
        $allgenres = $genre->getAll();

        if(count($allgenres) > 0){
            $json = array();
            $json['genres']=$allgenres;
            $json['total']=count($allgenres);
            echo json_encode($json);
        }else{
            http_response_code(404);

            $json['error']="genre not found.";
            
            echo json_encode($json);
        }
    }





    
?>