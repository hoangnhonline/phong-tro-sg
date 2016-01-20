<?php
include "model/Db.php";
try{

    include "../model/Db.php";
}catch(Exception $ex){

}
class Addon extends Db {


    function getDetailAddon($id) {

        $sql = "SELECT * FROM addon WHERE addon_id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row;

    }

    function getAddonByID($id) {

        $sql = "SELECT addon_name FROM addon WHERE addon_id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row['addon_name'];

    }



    function getListAddonByStatus($status=-1,$offset = -1, $limit = -1) {

        $sql = "SELECT * FROM addon WHERE (status = $status OR $status = -1)  AND status > 0 ";

        if ($limit > 0 && $offset >= 0)

            $sql .= " LIMIT $offset,$limit";

        $rs = mysql_query($sql) or die(mysql_error());

        return $rs;

    }

    function updateStatus($id,$status) {

        $time = time();

        $sql = "UPDATE addon

                    SET status = $status,

                    update_time =  $time

                    WHERE addon_id = $id ";

        mysql_query($sql) or die(mysql_error() . $sql);

    }



    function updateAddon($id,$addon_name) {

        $time = time();

        $sql = "UPDATE addon

                    SET addon_name = '$addon_name',                
                    update_time =  $time

                    WHERE addon_id = $id ";

        mysql_query($sql) or die(mysql_error() . $sql);

    }

    function insertAddon($addon_name){

        try{

            $time = time();

            $sql = "INSERT INTO addon VALUES(NULL,'$addon_name',1,1,$time,$time)";

            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());

        }catch(Exception $ex){

            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Addon','function' => 'insertAddon' , 'error'=>$ex->getMessage(),'sql'=>$sql);

            $this->logError($arrLog);

        }

    }



}



?>