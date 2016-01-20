<?php
include "model/Db.php";
try{

    include "../model/Db.php";
}catch(Exception $ex){

}
class Direction extends Db {


    function getDetailDirection($id) {

        $sql = "SELECT * FROM direction WHERE direction_id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row;

    }

    function getDirectionByID($id) {

        $sql = "SELECT direction_name FROM direction WHERE direction_id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row['direction_name'];

    }



    function getListDirectionByStatus($status=-1,$offset = -1, $limit = -1) {

        $sql = "SELECT * FROM direction WHERE (status = $status OR $status = -1)  AND status > 0 ";

        if ($limit > 0 && $offset >= 0)

            $sql .= " LIMIT $offset,$limit";

        $rs = mysql_query($sql) or die(mysql_error());

        return $rs;

    }

    function updateStatus($id,$status) {

        $time = time();

        $sql = "UPDATE direction

                    SET status = $status,

                    update_time =  $time

                    WHERE direction_id = $id ";

        mysql_query($sql) or die(mysql_error() . $sql);

    }



    function updateDirection($id,$direction_name) {

        $time = time();

        $sql = "UPDATE direction

                    SET direction_name = '$direction_name',                
                    update_time =  $time

                    WHERE direction_id = $id ";

        mysql_query($sql) or die(mysql_error() . $sql);

    }

    function insertDirection($direction_name){

        try{

            $time = time();

            $sql = "INSERT INTO direction VALUES(NULL,'$direction_name',1,1,$time,$time)";

            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());

        }catch(Exception $ex){

            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Direction','function' => 'insertDirection' , 'error'=>$ex->getMessage(),'sql'=>$sql);

            $this->logError($arrLog);

        }

    }



}



?>