<?php

use App\Admin;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

    require_once __DIR__."/../../../config.php";
    require __DIR__."/../auth.php";


    $admin = new Admin($pdoconn);
    if(
        (!(isset($decoded->data->role))
        || !($admin->isAdmin($decoded->data->email)))
    ){
        $admin = null;
        http_response_code(401);
        echo json_encode(array(
            "error"=>"Access Denied! Non admin user",
        ));

        exit();
    }

    $adminUser = $admin->getById($decoded->data->id);

    if(count($adminUser) > 0){
        $json = array();
        $json['admin']=$adminUser[0];
        echo json_encode($json);
    }

?>