<?php
require_once "Db.php";
if(!isset($_SESSION)) 
{ 
    session_start(); 
}  
class Nhaxe extends Db {

    function getDetailNhaxe($id) {
        $sql = "SELECT * FROM nhaxe WHERE nhaxe_id = $id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_assoc($rs);
        return $row;
    }
    function getDetailNhaxe2($id) {
        $sql = "SELECT nhaxe_id,nhaxe_name_vi,nhaxe_name_en FROM nhaxe WHERE nhaxe_id = $id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_assoc($rs);
        return $row;
    }
    function getIDByNameSafe($str) {

        $sql = "SELECT nhaxe_id FROM nhaxe WHERE nhaxe_name_safe_vi = '$str' AND status > 0 ";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row['nhaxe_id'];

    }
    function getNhaxeNameByID($id,$lang="vi") {
        $sql = "SELECT * FROM nhaxe WHERE nhaxe_id = $id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_assoc($rs);
        return $row['nhaxe_name_'.$lang];
    }
   
    function getListNhaxeHaveTicket($vstart,$vend,$dstart){
        $arrResult = array();
        try{
            $sql = "SELECT nhaxe_id FROM ticket WHERE status > 0 AND tinh_id_start = $vstart AND tinh_id_end = $vend
            AND date_start = $dstart GROUP BY nhaxe_id "  ;                      
  
            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());  

            while($row = mysql_fetch_assoc($rs)){
                $nhaxe_id = $row['nhaxe_id'];
                $arrResult[$nhaxe_id] = $this->getDetailNhaxe2($nhaxe_id);
            }            

        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Nhaxe','function' => 'getListNhaxeHaveTicket' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
        
        return $arrResult;
    }
    function getListNhaxe($keyword = '',$hot = -1,$offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM nhaxe WHERE (hot = $hot OR $hot = -1)  AND status > 0 ";
            if($keyword!=''){
                $sql.=" AND nhaxe_name_vi LIKE '%".$keyword."%' "; 
            }
            $sql.= " ORDER BY display_order ";
            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";        
            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());  
            while($row = mysql_fetch_assoc($rs)){
                $arrResult['data'][] = $row; 
            }

            $arrResult['total'] = mysql_num_rows($rs);     
        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Nhaxe','function' => 'getListNhaxe' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
        
        return $arrResult;
    }    
    function updateStatus($id,$status) {        
        $time = time();
        $sql = "UPDATE nhaxe
                    SET status = $status,                 
                    update_time =  $time         
                    WHERE nhaxe_id = $id ";
        mysql_query($sql) or die(mysql_error() . $sql);
    }

    function updateNhaxe($id,$nhaxe_name_vi,$nhaxe_name_en,$nhaxe_name_safe_vi,$nhaxe_name_safe_en,$address_vi,$address_en,$phone,$description_vi,$description_en,$image_url,$thumbnail_url,$hot){
        $time = time();
        $user_id = $_SESSION['user_id'];
        $sql = "UPDATE nhaxe
                    SET nhaxe_name_vi = '$nhaxe_name_vi',
                    nhaxe_name_en = '$nhaxe_name_en',
                    nhaxe_name_safe_vi  = '$nhaxe_name_safe_vi',
                    nhaxe_name_safe_en = '$nhaxe_name_safe_en',
                    address_vi  = '$address_vi',
                    address_en = '$address_en',
                    phone  = '$phone',
                    description_vi = '$description_vi',
                    description_en  = '$description_en',
                    image_url = '$image_url',
                    thumbnail_url = '$thumbnail_url',
                    hot = $hot,
                    update_time =  $time,
                    user_id = $user_id         
                    WHERE nhaxe_id = $id ";
        mysql_query($sql) or die(mysql_error() . $sql);
    }
    function insertNhaxe($nhaxe_name_vi,$nhaxe_name_en,$nhaxe_name_safe_vi,$nhaxe_name_safe_en,$address_vi,$address_en,$phone,$description_vi,$description_en,$image_url,$thumbnail_url,$hot){
        try{
            $user_id = $_SESSION['user_id'];
            $time = time();
            $sql = "INSERT INTO nhaxe VALUES(NULL,'$nhaxe_name_vi','$nhaxe_name_safe_vi','$nhaxe_name_en','$nhaxe_name_safe_en','$address_vi','$address_en','$phone',
                '$description_vi','$description_en','$image_url','$thumbnail_url',$time,$time,$hot,1,$user_id,1)";
            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());       
        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Nhaxe','function' => 'insertNhaxe' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }    

}

?>