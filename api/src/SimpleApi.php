<?php
use function PHPSTORM_META\type;
//token settings
$GLOBALS["key"] = "yanginirahasia";
$GLOBALS["passphrase"] = "ini juga rahasia";
$GLOBALS["algorithm"] = "AES-256-CBC";




// dont cahange unless u know what u doing  ( jangan ganti, kecuali tau.)
class SimpleApi{
    private $host;
    private $user;
    private $password;
    private $db;
      
    public function setHost(string $hostlocation){
        $this->host = $hostlocation;
    }
    public function setUser(string $username){
        $this->user = $username;
    }
    public function setPassword(string $password){
        $this->password = $password;
    }
    public function setDatabse(string $DbName){
        $this->db = $DbName;
    }
    public function connection(){
        return mysqli_connect($this->host,$this->user,$this->password,$this->db);
    }
####################################################################################
//basic CRUD to json
    public function queryToJson($query){
        
        $res = $this->connection()->query($query);
        while($row = mysqli_fetch_assoc($res)){
            $arr[]=$row;
        }
        return json_encode($arr);
    }

    function generateTokenByUser(string $user){
        return openssl_encrypt($user."::".$GLOBALS["key"],$GLOBALS["algorithm"],$GLOBALS["passphrase"]);
    }
    public function insertToDBtable(string $tableName, string $values){
        $query = "insert into $tableName values ($values)";
        if($this->connection()->query($query)){
            return true;
        }
        else{
            return false;
        }
    }
    public function editFromDBtable(string $tableName, mixed $ID,string $newData){
        // 1st, get PK column name
         $query = "SHOW KEYS FROM $tableName WHERE Key_name = 'PRIMARY'";
         $res = $this->connection()->query($query);
         $arr = mysqli_fetch_row($res);
         //pk on array index 4
         if (gettype($ID) == "string"){
             $ID = "'".$ID."'";
         }
         $query = "update $tableName set $newData where ".$arr[4]."=".$ID;
         $this->connection()->query($query);
     }

     public function deleteFromDBtable(string $tableName, string $primaryCollumn, mixed $values){
        if (gettype($values) == "string"){
            $values = "'".$values."'";
        }
        $query = "delete from $tableName where $primaryCollumn = $values";
        $this->connection()->query($query);
    }




//encrypting token

    public function generateTokenByAuth(mixed $username, string $password, string $loginTB, string $userCol, string $passwordCol){

        if (gettype($username) != "integer"){
            $query = "select * from ".$loginTB." where ".$userCol." = '$username' and ".$passwordCol."= '$password'";
        }else{
            $query = "select * from ".$loginTB." where ".$userCol." = $username and ".$passwordCol."= '$password'";
        }
        
        $res = $this->connection()->query($query);
        $arr= null;
        while($row = mysqli_fetch_assoc($res)){
            $arr[]=$row;
        }
        $role = $arr[0]["role"];
        if($arr == null){
            $arr = array("status"=>"no data");   
        }     
        else{
            $arr=array("token"=>$this->generateTokenByUser($role."::".$username),"status"=>"OK");
        }
        return json_encode($arr);
    }



//decrypting token
    public function isThisTokenAllowed(string $token, array $listOfAlllowedRole){
        $tokenrole = $this->getRoleFromToken($token);
        $tokenIsAllowedThisEndPoint = false;
        foreach($listOfAlllowedRole as $val){
            if($val == $tokenrole){
                $tokenIsAllowedThisEndPoint = true;
            }
        }
        return $tokenIsAllowedThisEndPoint;
    }

    public function checkTokenValidity(string $token, string $userID){
        if($token == openssl_encrypt($userID."::".$GLOBALS["key"],$GLOBALS["algorithm"],$GLOBALS["passphrase"])){
            return true;
        }else{
            return false;
        }
    }


    public function getUserFromToken($token){
        $decrypted = openssl_decrypt($token,$GLOBALS["algorithm"],$GLOBALS["passphrase"]);
        $ret = explode("::",$decrypted)[1];        
        return $ret;
       
    }
    public function getRoleFromToken($token){
        $decrypted = openssl_decrypt($token,$GLOBALS["algorithm"],$GLOBALS["passphrase"]);
        return explode("::",$decrypted)[0];
    }
// manage file
    public function userDirectory($token){
        if(!is_dir("api/uploaded_files/".$this->getRoleFromToken($token))){
            mkdir("api/uploaded_files/".$this->getRoleFromToken($token));    
        }
        if(!is_dir("api/uploaded_files/".$this->getRoleFromToken($token)."/".$this->getUserFromToken($token))){
            mkdir("api/uploaded_files/".$this->getRoleFromToken($token)."/".$this->getUserFromToken($token));
        }
        return "/api/uploadedfile/".$this->getRoleFromToken($token)."/".$this->getUserFromToken($token)."/";
    }
}






?>