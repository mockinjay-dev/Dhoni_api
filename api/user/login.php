<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Origin,Accept, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("HTTP/1.1 200 OK");

    use App\User;
    use Firebase\JWT\JWT;
    require_once __DIR__."/../../config.php";

    $data = json_decode(file_get_contents("php://input"));
    
    if( 
       !(
           (isset($data->email) && !empty($data->email))
            && (isset($data->password) && !empty($data->password))
       )
    ){
        http_response_code(401);
        echo json_encode(array(
            "error"=>"Please enter email and password"
        ));
        exit();
    }

    $user = new User($pdoconn);

    $authUser = $user->login(array(
        "email"=>$data->email,
        "password"=>$data->password
    ));

    if(!(count($authUser) > 0)){
        http_response_code(401);
        echo json_encode(array(
            "error"=>"Wrong email or password."
        ));
        exit();
    }
    $now = time();
    $expIn = 5400;
    $exp = $now + $expIn;

    $token = array(
        "iat"=>$now,
        "exp"=>$exp,
        "data"=>array(
            "id"=>$authUser[0]['id'],
            "email"=>$authUser[0]['email'],
        )
    );

    $jwt =  JWT::encode($token,$_ENV['SECRET']);

    echo json_encode(array(
        "msg"=>"Welcome User !",
        "data"=>array(
            "user"=>array(
                "name"=>$authUser[0]['name'],
                "email"=>$authUser[0]['email'],
            ), 
            "token"=>$jwt,
            "expiresIn"=>$expIn,
        )
    ));
    
?>