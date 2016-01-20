<?php

require_once "Db.php";

if(!isset($_SESSION)) 
{ 

    session_start(); 

}  

class Troute extends Db {



    function getDetailTroute($id) {

        $sql = "SELECT * FROM troute WHERE troute_id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row;

    }
    


    function getListTroute($nhaxe_id=-1,$offset = -1, $limit = -1) {

        $arrResult = array();

        try{

            $sql = "SELECT * FROM troute WHERE status > 0 

            AND  (nhaxe_id = $nhaxe_id OR $nhaxe_id = -1)";

            if ($limit > 0 && $offset >= 0)

                $sql .= " LIMIT $offset,$limit";  



            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());  

            while($row = mysql_fetch_assoc($rs)){

                $arrResult['data'][] = $row; 

            }

            $arrResult['total'] = mysql_num_rows($rs);



        }catch(Exception $ex){            

            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Ttroute','function' => 'getListTtroute' , 'error'=>$ex->getMessage(),'sql'=>$sql);

            $this->logError($arrLog);

        }

        

        return $arrResult;

    }       


    function updateTroute($troute_id,$nhaxe_id,$route_id,$min_time,$max_time,$price) {        

        $time = time();
        try{
        $sql = "UPDATE troute

                    SET nhaxe_id = '$nhaxe_id',                    

                    route_id = '$route_id',

                    min_time  = '$min_time',

                    max_time = '$max_time',               
                    price = '$price',               

                    update_time =  $time

                    WHERE troute_id = $troute_id ";

        mysql_query($sql)  or $this->throw_ex(mysql_error());       

        }catch(Exception $ex){            

            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Troute','function' => 'updateTroute' , 'error'=>$ex->getMessage(),'sql'=>$sql);

            $this->logError($arrLog);

        }

    }

    function insertTroute($nhaxe_id,$route_id,$min_time,$max_time,$price){

        try{

            $user_id = $_SESSION['user_id'];

            $time = time();

            $sql = "INSERT INTO troute VALUES(NULL,$nhaxe_id,$route_id,'$min_time','$max_time','$price',$time,$time,1)";

            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());       

        }catch(Exception $ex){            

            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Troute','function' => 'insertTroute' , 'error'=>$ex->getMessage(),'sql'=>$sql);

            $this->logError($arrLog);

        }

    }    



}



?>