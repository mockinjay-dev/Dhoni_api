<?php

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers:  Origin, Accept, Content-Type, Access-Control-Allow-Headers, X-Requested-With,X-Auth-Token, Authorization");
header("HTTP/1.1 200 OK");
    use App\User;

    require __DIR__."/../../config.php";
    require __DIR__."/../auth.php";

    $user = new User($pdoconn);

    $authUser = $user->getById($decoded->data->id);
    
    if(count($authUser) > 0){
        $json = array();
        $json['user']=$authUser[0];
        
        http_response_code(200);
        echo json_encode($json);
    }else{
        http_response_code(404);
        echo json_encode(array(
            "error"=>"User not found"
        ));
    }

?>