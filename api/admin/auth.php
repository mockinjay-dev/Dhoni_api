<?php

use App\Admin;
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
    } catch (\Exception $e) {
        // Token is expired
        echo json_encode(array(
            "error"=>$e->getMessage(),
            "msg"=>"You have been logged out. Please Log in"
        ));
        exit();
    }
