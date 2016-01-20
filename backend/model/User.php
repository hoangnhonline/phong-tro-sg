<?php

require_once "Db.php";

class User extends db {

    function getDetailUser($id) {

        $sql = "SELECT * FROM users WHERE user_id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row;

    }

    function getUserByID($id) {

        $sql = "SELECT users FROM users WHERE user_id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row['users'];

    }



    function getListUser($offset = -1, $limit = -1) {

        $sql = "SELECT * FROM users WHERE status > 0 ";

        if ($limit > 0 && $offset >= 0)

            $sql .= " LIMIT $offset,$limit";

        $rs = mysql_query($sql) or die(mysql_error());

        return $rs;

    }    

    function updateStatus($id,$status) {        

        $time = time();

        $sql = "UPDATE users

                    SET email = '$email',  
                    fullname = '$fullname',                
                    update_time =  $time         

                    WHERE user_id = $id ";

        mysql_query($sql) or die(mysql_error() . $sql);

    }



    function updateUser($id,$email,$group_id,$fullname) {        

        $time = time();

        $sql = "UPDATE users
                    SET email = '$email',
                    fullname = '$fullname',
                    group_id = $group_id,
                    update_time =  $time         
                    WHERE user_id = $id ";

        mysql_query($sql) or die(mysql_error() . $sql);

    }

    function insertUser($email,$group_id,$fullname){

        try{

            $time = time();
            $password = md5('12345@6');

            $sql = "INSERT INTO users VALUES(NULL,'$email','$password',$group_id,'$fullname',$time,$time,1)";

            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());       

        }catch(Exception $ex){            

            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'User','function' => 'insertUser' , 'error'=>$ex->getMessage(),'sql'=>$sql);

            $this->logError($arrLog);

        }

    }   

    function user_checkpass($idUser, $pass) {
        $chitiet = $this->user_chitiet($idUser);
        $row = mysql_fetch_assoc($chitiet);
        if (md5($pass) == $row['password'])
            return true;
        else
            return false;
    }

    function user_changepass() {
        $idUser = $_POST['idUser'];
        $newpass = md5(trim($_POST['newpass']));
        $sql = "UPDATE users SET password = '$newpass' WHERE idUser = $idUser";
        mysql_query($sql);
    }   

}

?>