<?php
include "model/Db.php";
try{

    include "../model/Db.php";
}catch(Exception $ex){

}
class Area extends Db {


    function getDetailArea($id) {

        $sql = "SELECT * FROM area WHERE area_id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row;

    }

    function getAreaByID($id) {

        $sql = "SELECT area_name FROM area WHERE area_id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row['area_name'];

    }



    function getListAreaByStatus($status=-1,$offset = -1, $limit = -1) {

        $sql = "SELECT * FROM area WHERE (status = $status OR $status = -1)  AND status > 0 ";

        if ($limit > 0 && $offset >= 0)

            $sql .= " LIMIT $offset,$limit";

        $rs = mysql_query($sql) or die(mysql_error());

        return $rs;

    }

    function updateStatus($id,$status) {

        $time = time();

        $sql = "UPDATE area

                    SET status = $status,

                    update_time =  $time

                    WHERE area_id = $id ";

        mysql_query($sql) or die(mysql_error() . $sql);

    }



    function updateArea($id,$area_name) {

        $time = time();

        $sql = "UPDATE area

                    SET area_name = '$area_name',                
                    update_time =  $time

                    WHERE area_id = $id ";

        mysql_query($sql) or die(mysql_error() . $sql);

    }

    function insertArea($area_name){

        try{

            $time = time();

            $sql = "INSERT INTO area VALUES(NULL,'$area_name',1,1,$time,$time)";

            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());

        }catch(Exception $ex){

            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Area','function' => 'insertArea' , 'error'=>$ex->getMessage(),'sql'=>$sql);

            $this->logError($arrLog);

        }

    }



}



?>