<?php

require_once "Db.php";

if(!isset($_SESSION)) 

{ 

    session_start(); 

}  

class Route extends Db {



    function getDetailRoute($id) {

        $sql = "SELECT * FROM route WHERE route_id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row;

    }
    function getEndByStartID($tinh_id_start){
        $arrResult = array();
        $sql = "SELECT * FROM route WHERE tinh_id_start = $tinh_id_start"; 
        
        $rs = mysql_query($sql) or die(mysql_error());
        while($row = mysql_fetch_assoc($rs)){
            $str_id .= $row['tinh_id_end'].",";
        };
        
        if($str_id){
            $str_id = rtrim($str_id,",");
            $sql = "SELECT * FROM tinh WHERE tinh_id IN ($str_id) ORDER BY hot DESC ";
            
            $rs = mysql_query($sql);
            while($row = mysql_fetch_assoc($rs)){
                $arrResult[$row['tinh_id']] = $row;
            }
        }
        return $arrResult;
    }
   
    function detailRoute($tinh_id_start,$tinh_id_end){
        $sql = "SELECT * FROM route WHERE tinh_id_start = $tinh_id_start AND tinh_id_end = $tinh_id_end"; 
        $rs = mysql_query($sql);
        $row = mysql_fetch_assoc($rs);
        return $row; 
    }
    function getRouteNameByID($id,$lang="vi") {
        $sql = "SELECT route_name_vi,route_name_en FROM route WHERE route_id = $id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_assoc($rs);
        return $row['route_name_'.$lang];
    }

    function getListRoute($keyword='',$tinh_id_start=-1,$tinh_id_end=-1,$hot=-1,$offset = -1, $limit = -1) {

        $arrResult = array();

        try{

            $sql = "SELECT * FROM route WHERE status > 0 

            AND  (tinh_id_start = $tinh_id_start OR $tinh_id_start = -1)

            AND  (hot = $hot OR $hot = -1)

            AND (tinh_id_end = $tinh_id_end OR $tinh_id_end = -1) ";

            if(trim($keyword)!=''){

                $sql.= " AND route_name_vi LIKE '%".$keyword."%' "; 

            }

            if ($limit > 0 && $offset >= 0)

                $sql .= " LIMIT $offset,$limit";  



            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());  

            while($row = mysql_fetch_assoc($rs)){

                $arrResult['data'][] = $row; 

            }

            $arrResult['total'] = mysql_num_rows($rs);



        }catch(Exception $ex){            

            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Route','function' => 'getListRoute' , 'error'=>$ex->getMessage(),'sql'=>$sql);

            $this->logError($arrLog);

        }

        

        return $arrResult;

    }    

    function updateStatus($id,$status) {        

        $time = time();

        $sql = "UPDATE route

                    SET status = $status,                 

                    update_time =  $time         

                    WHERE route_id = $id ";

        mysql_query($sql) or die(mysql_error() . $sql);

    }



    function updateRoute($id,$route_name_vi,$route_name_en,$route_name_safe_vi,$route_name_safe_en,$abbreviation,$hot,$description,$tinh_id_start,$tinh_id_end,$distance,$duration) {        

        $time = time();

        $user_id = $_SESSION['user_id'];

        $sql = "UPDATE route

                    SET route_name_vi = '$route_name_vi',                    

                    route_name_en = '$route_name_en',

                    route_name_safe_vi  = '$route_name_safe_vi',

                    route_name_safe_en = '$route_name_safe_en',

                    abbreviation = '$abbreviation',

                    update_time =  $time,

                    description = '$description',

                    tinh_id_start =  $tinh_id_start,

                    tinh_id_end =  $tinh_id_end,

                    distance =  '$distance',

                    duration =  '$duration',

                    hot = $hot,

                    user_id = $user_id

                    WHERE route_id = $id ";

        mysql_query($sql) or die(mysql_error() . $sql);

    }

    function insertRoute($route_name_vi,$route_name_en,$route_name_safe_vi,$route_name_safe_en,$abbreviation,$hot,$description,$tinh_id_start,$tinh_id_end,$distance,$duration){

        try{

            $user_id = $_SESSION['user_id'];

            $time = time();

            $sql = "INSERT INTO route VALUES(NULL,'$route_name_vi','$route_name_safe_vi','$route_name_en','$route_name_safe_en','$abbreviation',$hot,'$description',$tinh_id_start,$tinh_id_end,'$distance','$duration',$time,$time,1,$user_id)";

            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());       

        }catch(Exception $ex){            

            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Route','function' => 'insertRoute' , 'error'=>$ex->getMessage(),'sql'=>$sql);

            $this->logError($arrLog);

        }

    }    



}



?>