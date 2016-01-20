<?php

require_once "Db.php";



class Time extends Db {



    function getDetailTime($id) {

        $sql = "SELECT * FROM time_start WHERE time_id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row;

    }

    function getTimeByID($id) {

        $sql = "SELECT time_start FROM time_start WHERE time_id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row['time_start'];

    }



    function getListTimeByStatus($status=-1,$offset = -1, $limit = -1) {

        $sql = "SELECT * FROM time_start WHERE (status = $status OR $status = -1)  AND status > 0 ";

        if ($limit > 0 && $offset >= 0)

            $sql .= " LIMIT $offset,$limit";

        $rs = mysql_query($sql) or die(mysql_error());

        return $rs;

    }    

    function updateStatus($id,$status) {        

        $time = time();

        $sql = "UPDATE time_start

                    SET status = $status,                 

                    update_time =  $time         

                    WHERE time_id = $id ";

        mysql_query($sql) or die(mysql_error() . $sql);

    }



    function updateTime($id,$time_start) {        

        $time = time();

        $sql = "UPDATE time_start

                    SET time_start = '$time_start',                  

                    time_start_safe = '$time_start_safe',

                    update_time =  $time         

                    WHERE time_id = $id ";

        mysql_query($sql) or die(mysql_error() . $sql);

    }

    function insertTime($time_start){

        try{

            $time = time();

            $sql = "INSERT INTO time_start VALUES(NULL,'$time_start','$time_start_safe',$time,$time,1)";

            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());       

        }catch(Exception $ex){            

            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Time','function' => 'insertTime' , 'error'=>$ex->getMessage(),'sql'=>$sql);

            $this->logError($arrLog);

        }

    }    



}



?>