<?php
require_once "Db.php";

class Promotion extends Db {

    function getDetailPromotion($id) {
        $sql = "SELECT * FROM promotion WHERE promotion_id = $id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_assoc($rs);
        return $row;
    }

    function getListPromotion($keyword = '',$hot = -1,$offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM promotion WHERE (hot = $hot OR $hot = -1)  AND status > 0 ";
            if($keyword!=''){
                $sql.=" AND title_vi LIKE '%".$keyword."%' "; 
            }
            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";        
            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());  
            while($row = mysql_fetch_assoc($rs)){
                $arrResult['data'][] = $row; 
            }

            $arrResult['total'] = mysql_num_rows($rs);     
        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Promotion','function' => 'getListPromotion' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
        
        return $arrResult;
    }    
    function updateStatus($id,$status) {        
        $time = time();
        $sql = "UPDATE promotion
                    SET status = $status,                 
                    update_time =  $time         
                    WHERE promotion_id = $id ";
        mysql_query($sql) or die(mysql_error() . $sql);
    }

    function updatePromotion($id,$title_vi,$title_safe_vi,$title_en,$title_safe_en,$description_vi,$description_en,$image_url,$content_vi,$content_en,$hot){
        $time = time();
        $sql = "UPDATE promotion
                    SET title_vi = '$title_vi',
                    title_en = '$title_en',
                    title_safe_vi  = '$title_safe_vi',
                    title_safe_en = '$title_safe_en',
                    description_vi  = '$description_vi',
                    description_en = '$description_en',                    
                    content_vi = '$content_vi',
                    content_en  = '$content_en',
                    image_url = '$image_url',
                    hot = $hot,
                    update_time =  $time         
                    WHERE promotion_id = $id ";
        mysql_query($sql) or die(mysql_error() . $sql);
    }
    function insertPromotion($title_vi,$title_safe_vi,$title_en,$title_safe_en,$description_vi,$description_en,$image_url,$content_vi,$content_en,$hot){
        try{
            $time = time();
            $sql = "INSERT INTO promotion VALUES(NULL,'$title_vi','$title_safe_vi','$title_en','$title_safe_en','$description_vi','$description_en','$image_url',
                '$content_vi','$content_en',$hot,$time,$time,1)";
            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());       
        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Promotion','function' => 'insertPromotion' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }    

}

?>