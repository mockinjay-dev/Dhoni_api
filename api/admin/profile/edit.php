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
    $data = json_decode(file_get_contents("php://input"));

    if(
        !(
            (isset($data->name) && !empty($data->name))
            && (isset($data->email) && !empty($data->email))
            && (isset($data->id) && !empty($data->id))
            && (isset($data->password) && !empty($data->password))
        )
     ){
         http_response_code(402);
         echo json_encode(array(
             "error"=>"Please fill all details"
         ));
         exit();
     }


    if($admin->update(array(
        'id'=>$data->id,
        'name'=>$data->name,
        'email'=>$data->email,
        'password'=>$data->password,
    ))){
        $json = array();
        $json['msg']="Successfully Edited!";
        echo json_encode($json);
    }

?>