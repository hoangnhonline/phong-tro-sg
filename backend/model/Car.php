<?php

require_once "Db.php";

if(!isset($_SESSION)) 

{ 

    session_start(); 

}  

class Car extends Db {



    function getDetailCar($id) {

        $sql = "SELECT * FROM car_type WHERE type_id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row;

    }

    function getCarNameByID($id) {

        $sql = "SELECT type_name_vi FROM car_type WHERE type_id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row['type_name_vi'];

    }



    function getListCarByStatus($status=-1,$offset = -1, $limit = -1) {

        $sql = "SELECT * FROM car_type WHERE (status = $status OR $status = -1)  AND status > 0 ";

        if ($limit > 0 && $offset >= 0)

            $sql .= " LIMIT $offset,$limit";

        $rs = mysql_query($sql) or die(mysql_error());

        return $rs;

    }    

    function updateStatus($id,$status) {        

        $time = time();

        $sql = "UPDATE car_type

                    SET status = $status,                 

                    update_time =  $time         

                    WHERE type_id = $id ";

        mysql_query($sql) or die(mysql_error() . $sql);

    }



    function updateCar($id,$type_name_vi,$type_name_en) {

        $user_id = $_SESSION['user_id'];        

        $time = time();

        $sql = "UPDATE car_type

                    SET type_name_vi = '$type_name_vi',                  

                    type_name_en = '$type_name_en',

                    update_time =  $time,

                    user_id = $user_id         

                    WHERE type_id = $id ";

        mysql_query($sql) or die(mysql_error() . $sql);

    }

    function insertCar($type_name_vi,$type_name_en){

        try{

            $time = time();

            $sql = "INSERT INTO car_type VALUES(NULL,'$type_name_vi','$type_name_en',$time,$time,1,$user_id)";

            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());       

        }catch(Exception $ex){            

            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Car','function' => 'insertCar' , 'error'=>$ex->getMessage(),'sql'=>$sql);

            $this->logError($arrLog);

        }

    }    



}



?>