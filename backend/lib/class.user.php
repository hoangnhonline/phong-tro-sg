<?php

require_once "../Model/Db.php";

class user extends db {

    function user_chitiet($idUser) {
        $sql = "SELECT * FROM users WHERE idUser = $idUser";
        $rs = mysql_query($sql) or die(mysql_error());
        return $rs;
    }

    function user_them() {

        $group = (int) $_POST['group'];
        $fullname = $this->processData($_POST['fullname']);
        $email = $this->processData($_POST['email']);
        $pass = md5('123456@');

        $sql = "INSERT INTO users
					VALUES(NULL,'$email','$pass','$group','$fullname',1)";
        mysql_query($sql) or die(mysql_error() . $sql);
    }

    function user_edit($idUser) {

        $group = (int) $_POST['group'];
        $fullname = $this->processData($_POST['fullname']);
        $email = $this->processData($_POST['email']);
        $pass = md5('123456@');

        $sql = "UPDATE users SET fullname = '$fullname',email = '$email',`password` = '$pass',`group`  = '$group',`status` = 1 WHERE idUser = $idUser";
        mysql_query($sql) or die(mysql_error() . $sql);
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

    function user_list() {
        $sql = "SELECT * FROM users WHERE status > 0 ";       
        $rs = mysql_query($sql) or die(mysql_error());
        return $rs;
    }
    function get_ten_tac_gia($idUser) {
        $sql = "SELECT email FROM users WHERE idUser = $idUser ";       
        $rs = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_assoc($rs);
        echo $row['email'];
    }

}

?>