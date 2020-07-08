<?php

// header("Access-Control-Allow-Origin: http://localhost:3000");
// header("Access-Control-Allow-Headers:  Origin, Accept, Content-Type, Access-Control-Allow-Headers, X-Requested-With, Authorization");
// header("Access-Control-Allow-Methods: GET");
// header("Access-Control-Max-Age: 3600");
// header("Content-Type: application/json; charset=UTF-8");

use Firebase\JWT\JWT;

$authHeader = null;
    // $decoded = null;
    
    // Check for authorization header
    if(isset($_SERVER['Authorization'])){
        $authHeader = explode(" ",$_SERVER['Authorization']);
    }
    else if(isset($_SERVER['HTTP_AUTHORIZATION'])){
        $authHeader = explode(" ",$_SERVER['HTTP_AUTHORIZATION']);
    }
    else{
        http_response_code(401);
        echo json_encode(array(
            "error"=>"Access Denied! No Authorization header found",
        ));
        exit();
    }
    
    // check for Bearer <token>

    if(!(count($authHeader) > 1)){

        http_response_code(401);

        echo json_encode(array(
            "error"=>"Access Denied! No Token found",
            "msg"=>"Please login first.",
        ));
        
        exit();
    }

    // check for <token> validity
    try {
        $decoded = JWT::decode($authHeader[1],$_ENV['SECRET'],array("HS256"));
        if(!($decoded->data->id)){
            http_response_code(402);
            echo json_encode(array(
                "error"=>"An error occured,please log in again!"
            ));
            exit();
        }
    } catch (\Exception $e) {
        // Token is expired
        http_response_code(402);
        echo json_encode(array(
            "error"=>$e->getMessage(),
            "msg"=>"You have been logged out. Please Log in"
        ));
        exit();
    }
