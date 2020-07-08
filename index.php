<?php
    header("Access-Control-Allow-Origin: *");
    header("HTTP/1.1 200 OK");

    echo json_encode(array(
        "msg"=>"Can't find anything here."
    ));
?>