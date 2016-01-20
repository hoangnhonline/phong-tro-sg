<?php

require_once "Db.php";
if(!isset($_SESSION)) 
{ 
    session_start(); 
}  


class Services extends Db {



    function getDetailService($id) {

        $sql = "SELECT * FROM services WHERE service_id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row;

    }
    function getServiceNameByID($id,$lang="vi") {

        $sql = "SELECT service_name_vi,service_name_en FROM services WHERE service_id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);
        
        return $row['service_name_'.$lang];

    }
   



    function getListServiceByStatus($status=-1,$offset = -1, $limit = -1) {

        $sql = "SELECT * FROM services WHERE (status = $status OR $status = -1)  AND status > 0 ";

        if ($limit > 0 && $offset >= 0)

            $sql .= " LIMIT $offset,$limit";

        $rs = mysql_query($sql) or die(mysql_error());

        return $rs;

    }    

    function updateStatus($id,$status) {        

        $time = time();

        $sql = "UPDATE services

                    SET status = $status,                 

                    update_time =  $time         

                    WHERE service_id = $id ";

        mysql_query($sql) or die(mysql_error() . $sql);

    }



    function updateService($id,$service_name_vi,$service_name_en,$service_name_safe_vi,$service_name_safe_en) {        

        $time = time();
        $user_id = $_SESSION['user_id'];
        $sql = "UPDATE services

                    SET service_name_vi = '$service_name_vi',

                    service_name_en = '$service_name_en',

                    service_name_safe_vi  = '$service_name_safe_vi',

                    service_name_safe_en = '$service_name_safe_en',

                    update_time =  $time  ,
                    user_id = $user_id       

                    WHERE service_id = $id ";

        mysql_query($sql) or die(mysql_error() . $sql);

    }

    function insertService($service_name_vi,$service_name_en,$service_name_safe_vi,$service_name_safe_en){

        try{
            $user_id = $_SESSION['user_id'];
            $time = time();

            $sql = "INSERT INTO services VALUES(NULL,'$service_name_vi','$service_name_safe_vi','$service_name_en','$service_name_safe_en',NULL,$time,$time,1,$user_id)";

            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());       

        }catch(Exception $ex){            

            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Services','function' => 'insertServices' , 'error'=>$ex->getMessage(),'sql'=>$sql);

            $this->logError($arrLog);

        }

    }    



}



?>