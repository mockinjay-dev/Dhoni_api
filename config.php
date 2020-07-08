<?php
require __DIR__."/./vendor/autoload.php";

    use App\SQLConnection;


    $pdoconn = (new SQLConnection())->connect();
    
    $env = Dotenv\Dotenv::createImmutable(__DIR__);
    $env->load();
?>