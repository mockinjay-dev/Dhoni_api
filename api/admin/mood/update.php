<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Origin,Accept, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("HTTP/1.1 200 OK");

use App\Admin;
use App\Mood;
    
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

    $data = json_decode(file_get_contents("php://input"));

    if(
        !(
            (isset($data->name) && !empty($data->name))
            && (isset($data->description) && !empty($data->description))
            && (isset($data->id) && !empty($data->id))
        )
    ){
        http_response_code(400);
        echo json_encode(array(
            "error"=>"Please fill all details",
        ));
        exit();
    }

    
    $mood = new Mood($pdoconn);

    if(($mood->update(array(
        "id" => $data->id,
        "name" => $data->name,
        "description" => $data->description
    )))){
        echo json_encode(array(
            "msg"=>"mood updated!"
        ));
    }else{
        http_response_code(400);
        echo json_encode(array(
            "error"=>"Unable to create new mood."
        ));
    }


?>