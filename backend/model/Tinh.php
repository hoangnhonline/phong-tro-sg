<?php

require_once "Db.php";

if(!isset($_SESSION)) 

{ 

    session_start(); 

}  

class Tinh extends Db {



    function getDetailTinh($id) {

        $sql = "SELECT * FROM tinh WHERE tinh_id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row;

    }

    function getListTinhHaveTicket(){
        $sql = "SELECT tinh_id_start FROM ticket WHERE status = 1 GROUP BY tinh_id_start";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $str_id .= $row['tinh_id_start'].",";       
        }
        if($str_id){
            $str_id = rtrim($str_id,",");
            $sql = "SELECT * FROM tinh WHERE tinh_id IN ($str_id) ORDER BY display_order ASC ";
            
            $rs = mysql_query($sql);
            while($row = mysql_fetch_assoc($rs)){
                $arrResult[$row['tinh_id']] = $row;
            }
        }
        return $arrResult;
    }

    function getTinhNameByID($id,$lang='vi') {

        $sql = "SELECT tinh_name_vi,tinh_name_en FROM tinh WHERE tinh_id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row['tinh_name_'.$lang];

    }
    function getTinhNameSafeByID($id) {

        $sql = "SELECT tinh_name_safe_vi FROM tinh WHERE tinh_id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row['tinh_name_safe_vi'];

    }
    function getIDByTinhNameSafe($str) {

        $sql = "SELECT tinh_id FROM tinh WHERE tinh_name_safe_vi = '$str'";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row['tinh_id'];

    }

    function checkHavePage($tinh_id){
        $sql = "SELECT page_id FROM page WHERE tinh_id = $tinh_id";
        $rs = mysql_query($sql);
        $row = mysql_num_rows($rs);
        return $row > 0 ? true : false;
    }   



    function getListTinh($mien_id=-1,$keyword='',$hot=-1,$offset = -1, $limit = -1) {

        $arrResult = array();

        $sql = "SELECT * FROM tinh WHERE (hot = $hot OR $hot = -1) AND (mien_id = $mien_id OR $mien_id = -1) AND status > 0 ";

        if(trim($keyword)!=''){

            $sql.= " AND tinh_name_vi LIKE '%".$keyword."%' "; 

        }
        $sql.="  ORDER BY display_order ASC " ;
        if ($limit > 0 && $offset >= 0)

            $sql .= "  LIMIT $offset,$limit";

        $rs = mysql_query($sql) or die(mysql_error());

        while($row = mysql_fetch_assoc($rs)){

            $arrResult['data'][] = $row; 

        }      

        $arrResult['total'] = mysql_num_rows($rs);

        return $arrResult;

    }    

    function updateStatus($id,$status) {        

        $time = time();

        $sql = "UPDATE tinh

                    SET status = $status,                 

                    update_time =  $time         

                    WHERE tinh_id = $id ";

        mysql_query($sql) or die(mysql_error() . $sql);

    }



    function updateTinh($id,$tinh_name_vi,$tinh_name_en,$tinh_name_safe_vi,$tinh_name_safe_en,$mien_id,$hot,$image_url,$price_between) {        

        $time = time();

        $user_id = $_SESSION['user_id'];

        $image_url = trim($image_url) == '' ? NULL : $image_url;

        $price_between = trim($price_between) == '' ? NULL : $price_between;

        

        $sql = "UPDATE tinh

                    SET tinh_name_vi = '$tinh_name_vi',

                    tinh_name_en = '$tinh_name_en',

                    tinh_name_safe_vi  = '$tinh_name_safe_vi',

                    tinh_name_safe_en = '$tinh_name_safe_en', 

                    hot = $hot, ";

        if($image_url!=NULL)   $sql.= " image_url = '$image_url' ,";         

        if($price_between!=NULL)   $sql.= " price_between = '$price_between' ,";                           

                    $sql .="mien_id = $mien_id,                   

                    update_time =  $time,

                    user_id = $user_id         

                    WHERE tinh_id = $id ";                    

        mysql_query($sql) or die(mysql_error() . $sql);

    }

    function insertTinh($tinh_name_vi,$tinh_name_en,$tinh_name_safe_vi,$tinh_name_safe_en,$mien_id,$hot,$image_url,$price_between){

        try{

            $user_id = $_SESSION['user_id'];

            $time = time();

            $sql = "INSERT INTO tinh VALUES(NULL,'$tinh_name_vi','$tinh_name_safe_vi','$tinh_name_en','$tinh_name_safe_en',$mien_id,$hot,'$image_url','$price_between',1,$time,$time,1,$user_id)";

            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());       

        }catch(Exception $ex){            

            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Tinh','function' => 'insertTinh' , 'error'=>$ex->getMessage(),'sql'=>$sql);

            $this->logError($arrLog);

        }

    }    



}



?>