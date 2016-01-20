<?php
include "model/Db.php";

class Estate extends Db {


    function getDetailEstate($id) {

        $sql = "SELECT * FROM estate_type WHERE estate_type_id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row;

    }

    function getEstateByID($id) {

        $sql = "SELECT estate_type_name FROM estate_type WHERE estate_type_id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row['estate_type_name'];

    }



    function getListEstateByStatus($status=-1,$offset = -1, $limit = -1) {

        $sql = "SELECT * FROM estate_type WHERE (status = $status OR $status = -1)  AND status > 0 ";

        if ($limit > 0 && $offset >= 0)

            $sql .= " LIMIT $offset,$limit";

        $rs = mysql_query($sql) or die(mysql_error());

        return $rs;

    }

    function updateStatus($id,$status) {

        $time = time();

        $sql = "UPDATE estate_type

                    SET status = $status,

                    update_time =  $time

                    WHERE estate_type_id = $id ";

        mysql_query($sql) or die(mysql_error() . $sql);

    }



    function updateEstate($id,$estate_type_name,$estate_alias) {

        $time = time();

        $sql = "UPDATE estate_type

                    SET estate_type_name = '$estate_type_name',
                    estate_alias = '$estate_alias',
                    update_time =  $time

                    WHERE estate_type_id = $id ";

        mysql_query($sql) or die(mysql_error() . $sql);

    }

    function insertEstate($estate_type_name,$estate_alias){

        try{

            $time = time();

            $sql = "INSERT INTO estate_type VALUES(NULL,'$estate_type_name','$estate_alias',1,1,$time,$time)";

            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());

        }catch(Exception $ex){

            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Estate','function' => 'insertEstate' , 'error'=>$ex->getMessage(),'sql'=>$sql);

            $this->logError($arrLog);

        }

    }



}



?>