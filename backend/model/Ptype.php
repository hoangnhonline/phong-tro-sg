<?php
include "model/Db.php";
try{

    include "../model/Db.php";
}catch(Exception $ex){

}
class Ptype extends Db {


    function getDetailPtype($id) {

        $sql = "SELECT * FROM project_type WHERE project_type_id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row;

    }

    function getPtypeByID($id) {

        $sql = "SELECT project_type_name FROM project_type WHERE project_type_id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row['project_type_name'];

    }



    function getListPtypeByStatus($status=-1,$offset = -1, $limit = -1) {

        $sql = "SELECT * FROM project_type WHERE (status = $status OR $status = -1)  AND status > 0 ";

        if ($limit > 0 && $offset >= 0)

            $sql .= " LIMIT $offset,$limit";

        $rs = mysql_query($sql) or die(mysql_error());

        return $rs;

    }

    function updateStatus($id,$status) {

        $time = time();

        $sql = "UPDATE project_type

                    SET status = $status,

                    update_time =  $time

                    WHERE project_type_id = $id ";

        mysql_query($sql) or die(mysql_error() . $sql);

    }



    function updatePtype($id,$project_type_name,$project_type_alias) {

        $time = time();

        $sql = "UPDATE project_type

                    SET project_type_name = '$project_type_name',
                    project_type_alias = '$project_type_alias',
                    update_time =  $time

                    WHERE project_type_id = $id ";

        mysql_query($sql) or die(mysql_error() . $sql);

    }

    function insertPtype($project_type_name,$project_type_alias){

        try{

            $time = time();

            $sql = "INSERT INTO project_type VALUES(NULL,'$project_type_name','$project_type_alias',1,1,$time,$time)";

            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());

        }catch(Exception $ex){

            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Ptype','function' => 'insertPtype' , 'error'=>$ex->getMessage(),'sql'=>$sql);

            $this->logError($arrLog);

        }

    }



}



?>