<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Origin,Accept, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    use App\User;
    use Firebase\JWT\JWT;

    require_once __DIR__."/../../config.php";

    // Getting via form data for img i.e $_POST
    if(
       !(
           (isset($_POST['email']) && !empty($_POST['email']))
            && (isset($_POST['password']) && !empty($_POST['password']))
            && (isset($_POST['name']) && !empty($_POST['name']))
            && (isset($_POST['number']) && !empty($_POST['number']))
            && (isset($_POST['gender']) && !empty($_POST['gender']))
       )
    ){
        http_response_code(402);
        echo json_encode(array(
            "error"=>"Please fill all details"
        ));
        exit();
    }

    $usr_name = $_POST['name']; 
    $usr_email = $_POST['email']; 
    $usr_password = $_POST['password']; 
    $usr_number = $_POST['number']; 
    $usr_gender = $_POST['gender']; 

    $user = new User($pdoconn);


    if(isset($_FILES['user_img'])){
        $img_name = explode(".",$_FILES['user_img']['name']);
        $img_tmp_name = $_FILES['user_img']['tmp_name'];
        $error = $_FILES['user_img']['error'];

        if($error > 0){
            $response = array(
                "error" => "Error uploading the file!",
            );
            exit();
        }
        
        $upload_path_db = "files/images/";

        $upload_path = (realpath((__DIR__."/../../files/images/")))."/";

        $file_name = (explode("@",$usr_email)[0])."-img.".($img_name[(count($img_name)-1)]);
        
        if((move_uploaded_file($img_tmp_name,($upload_path.$file_name)))){
            $newUser = $user->insert(array(
                "email"=>$usr_email,
                "password"=>$usr_password,
                "name"=>$usr_name,
                "gender"=>$usr_gender,
                "number"=>$usr_number,
                "path"=>($upload_path_db.$file_name),
            ));
        }
        else{
            $newUser = $user->insert(array(
                "email"=>$usr_email,
                "password"=>$usr_password,
                "name"=>$usr_name,
                "gender"=>$usr_gender,
                "number"=>$usr_number,
            ));
        }
    }else{
        $newUser = $user->insert(array(
            "email"=>$usr_email,
            "password"=>$usr_password,
            "name"=>$usr_name,
            "gender"=>$usr_gender,
            "number"=>$usr_number,
        ));
    }

    if(!($newUser)){
        http_response_code(402);
        echo json_encode(array(
            "error"=>"Something went wrong, please try again."
        ));
        exit();
    }else{
        echo json_encode(array(
            "msg"=>"Sign Up Successfull!"
        ));
    }
?>