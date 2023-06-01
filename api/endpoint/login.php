<?php

include_once("./api/src/simpleApi.php");
include_once("./api/src/config.php");

header('Content-Type: application/json; charset=utf-8');

$jsonFromClient = json_decode(file_get_contents('php://input'),true);
//uncoment line above if client send JSON 

// you can change DB auth direcly, or from /src/config.php:
$sa = new SimpleApi;
$sa->setHost($defaultDBhost);
$sa->setUser($defaultDBuser);
$sa->setPassword($defaultDBpass);
$sa->setDatabse($defaultDBname);

//do what you want here. ex : $sa->queryToJson('select * from table');
echo $sa->generateTokenByAuth($jsonFromClient["username"],$jsonFromClient["password"],"siswa","nis","password");
?>