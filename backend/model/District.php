<?php
include "model/Db.php";
try{

    include "../model/Db.php";
}catch(Exception $ex){

}
class District extends Db {


    function getDetailDistrict($id) {

        $sql = "SELECT * FROM district WHERE district_id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row;

    }

    function getDistrictByID($id) {

        $sql = "SELECT district_name FROM district WHERE district_id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row['district_name'];

    }



    function getListDistrictByStatus($status=-1,$offset = -1, $limit = -1) {

        $sql = "SELECT * FROM district WHERE (status = $status OR $status = -1)  AND status > 0 ";

        if ($limit > 0 && $offset >= 0)

            $sql .= " LIMIT $offset,$limit";

        $rs = mysql_query($sql) or die(mysql_error());

        return $rs;

    }

    function updateStatus($id,$status) {

        $time = time();

        $sql = "UPDATE district

                    SET status = $status,

                    update_time =  $time

                    WHERE district_id = $id ";

        mysql_query($sql) or die(mysql_error() . $sql);

    }



    function updateDistrict($id,$district_name) {

        $time = time();

        $sql = "UPDATE district

                    SET district_name = '$district_name',
                    update_time =  $time

                    WHERE district_id = $id ";

        mysql_query($sql) or die(mysql_error() . $sql);

    }

    function insertDistrict($district_name){

        try{

            $time = time();

            $sql = "INSERT INTO district VALUES(NULL,'$district_name',1,1,1,$time,$time)";

            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());

        }catch(Exception $ex){

            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'District','function' => 'insertDistrict' , 'error'=>$ex->getMessage(),'sql'=>$sql);

            $this->logError($arrLog);

        }

    }



}



?>