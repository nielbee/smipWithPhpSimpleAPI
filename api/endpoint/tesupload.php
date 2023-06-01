<?php

include_once("./api/src/simpleApi.php");
include_once("./api/src/config.php");

$sa = new SimpleApi;
$sa->setHost($defaultDBhost);
$sa->setUser($defaultDBuser);
$sa->setPassword($defaultDBpass);
$sa->setDatabse($defaultDBname);
//$jsonFromClient = json_decode(file_get_contents('php://input'),true);
//get token from header
$sendertoken = $_SERVER["HTTP_TOKEN"];
//header('Content-Type: application/json; charset=utf-8');
$IDuser = $sa->getUserFromToken($sendertoken);
//allowed role
$allowedrole=array(
    "siswa","admin"
);

//main :


    if ($sa->isThisTokenAllowed($sendertoken,$allowedrole)){
      echo $sa->userDirectory($sendertoken);
      move_uploaded_file($_FILES["fileToUpload"]["name"],$sa->userDirectory($sendertoken).$_FILES["fileToUpload"]["tmp_name"]);
    
    }
    else{
        //role is not allowed
        echo json_encode(array("status"=>"not allowed")) ;
    }    





?>