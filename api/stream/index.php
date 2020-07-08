<?php

use App\Song;
header("Access-Control-Allow-Origin: *");
    header("HTTP/1.1 200 OK");
    // if url param is empty
    if((!isset($_REQUEST['song'])) || empty(isset($_REQUEST['song']))){
        header("HTTP/1.0 404 Not Found");
        exit();
    }

    require_once __DIR__."/../../config.php";

    $song = new Song($pdoconn);

    $file_path = $song->getSongFile($_REQUEST['song']);

    // if url param is empty
    if(count($file_path) <= 0){
        header("HTTP/1.0 404 Not Found");
        exit();
    }

    $audio = __DIR__."/../../".($file_path[0]['file_path']);

    if(!file_exists($audio)){
        header("HTTP/1.0 404 Not Found");
        exit();
    }

    $size = filesize($audio);
    
    $begin	= 0;
    $end = $size - 1;

    if (isset($_SERVER['HTTP_RANGE']))
	{
		if (preg_match('/bytes=\h*(\d+)-(\d*)[\D.*]?/i', $_SERVER['HTTP_RANGE'], $matches))
		{
			$begin	= intval($matches[1]);
			if (!empty($matches[2]))
			{
				$end	= intval($matches[2]);
			}
		}
    }
    
    if (isset($_SERVER['HTTP_RANGE']))
	{
		header('HTTP/1.1 206 Partial Content');
	}
	else
	{
		header('HTTP/1.1 200 OK');
	}
    header('Accept-Ranges: bytes');

    header('Content-Type: audio/mpeg, audio/x-mpeg, audio/x-mpeg-3, audio/mpeg3');

    header('Connection: keep-alive');

    header('Cache-Control: public, must-revalidate, max-age=0');

    header('Pragma: no-cache');


    header('Content-Length: ' . (($end - $begin) + 1));

    if (isset($_SERVER['HTTP_RANGE']))
	{
        header("Content-Range: bytes $begin-$end/$size");
    }
    
    // header('Content-Disposition: inline; filename="' . end(explode("/",$audio)));

    header('Content-Transfer-Encoding: binary');

    print readfile($audio);
?>