<?php

use App\Mood;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 

    require_once __DIR__."/../../config.php";

    $mood = new Mood($pdoconn);
    $json = array();

    if(isset($_REQUEST['id']) && !(empty($_REQUEST['id']))){

        $onlyMood = $mood->getById($_REQUEST['id']);

        if(count($onlyMood) > 0){

            $json['mood']=$onlyMood[0];

            echo json_encode($json);

        }else{

            http_response_code(404);

            $json['error']="mood not found.";

            echo json_encode($json);
        }
    }else{
        $allMoods = $mood->getAll();

        if(count($allMoods) > 0){

            $json['moods']=$allMoods;

            $json['total']=count($allMoods);

            echo json_encode($json);

        }else{
            http_response_code(404);

            $json['error']="Mood not found.";
            
            echo json_encode($json);
        }
    }



?>