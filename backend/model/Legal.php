<?php
include "model/Db.php";
try{

    include "../model/Db.php";
}catch(Exception $ex){

}
class Legal extends Db {


    function getDetailLegal($id) {

        $sql = "SELECT * FROM legal WHERE legal_id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row;

    }

    function getLegalByID($id) {

        $sql = "SELECT legal_name FROM legal WHERE legal_id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row['legal_name'];

    }



    function getListLegalByStatus($status=-1,$offset = -1, $limit = -1) {

        $sql = "SELECT * FROM legal WHERE (status = $status OR $status = -1)  AND status > 0 ";

        if ($limit > 0 && $offset >= 0)

            $sql .= " LIMIT $offset,$limit";

        $rs = mysql_query($sql) or die(mysql_error());

        return $rs;

    }

    function updateStatus($id,$status) {

        $time = time();

        $sql = "UPDATE legal

                    SET status = $status,

                    update_time =  $time

                    WHERE legal_id = $id ";

        mysql_query($sql) or die(mysql_error() . $sql);

    }



    function updateLegal($id,$legal_name) {

        $time = time();

        $sql = "UPDATE legal

                    SET legal_name = '$legal_name',                
                    update_time =  $time

                    WHERE legal_id = $id ";

        mysql_query($sql) or die(mysql_error() . $sql);

    }

    function insertLegal($legal_name){

        try{

            $time = time();

            $sql = "INSERT INTO legal VALUES(NULL,'$legal_name',1,1,$time,$time)";

            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());

        }catch(Exception $ex){

            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Legal','function' => 'insertLegal' , 'error'=>$ex->getMessage(),'sql'=>$sql);

            $this->logError($arrLog);

        }

    }



}



?>