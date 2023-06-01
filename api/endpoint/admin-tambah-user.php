<?php

include_once("./api/src/simpleApi.php");
include_once("./api/src/config.php");

$sa = new SimpleApi;
$sa->setHost($defaultDBhost);
$sa->setUser($defaultDBuser);
$sa->setPassword($defaultDBpass);
$sa->setDatabse($defaultDBname);
$jsonFromClient = json_decode(file_get_contents('php://input'),true);
//get token from header
$sendertoken = $_SERVER["HTTP_TOKEN"];
header('Content-Type: application/json; charset=utf-8');
$IDuser = $sa->getUserFromToken($sendertoken);
//allowed role
$allowedrole=array(
    "admin"
);

//main :


    if ($sa->isThisTokenAllowed($sendertoken,$allowedrole)){
        $nis = $jsonFromClient["nis"];
        $nama = $jsonFromClient["nama"];
        $kelas = $jsonFromClient["nama"];
        $email = $jsonFromClient["email"];
        $no_telp = $jsonFromClient["no_telp"];
        $password = $jsonFromClient["password"];
        if($sa->insertToDBtable("siswa","'$nis','$nama','$kelas','$email','$no_telp','$password','siswa'")){
            echo json_encode(array("status"=>"succes add data"));
        }
        
    }
    else{
        //role is not allowed
        echo json_encode(array("status"=>"not allowed")) ;
    }    





?>