<?php
require_once "Db.php";
if(!isset($_SESSION)) 
{ 
    session_start(); 
}  
class Image extends Db {

    function getDetailImage($id) {
        $sql = "SELECT * FROM image WHERE image_id = $id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_assoc($rs);
        return $row;
    }

    function getListImageByNhaxe($nhaxe_id=-1,$offset = -1, $limit = -1) {
        $sql = "SELECT * FROM image WHERE (nhaxe_id = $nhaxe_id OR $nhaxe_id = -1)  AND status > 0 ";
        if ($limit > 0 && $offset >= 0)
            $sql .= " LIMIT $offset,$limit";
        $rs = mysql_query($sql) or die(mysql_error().$sql);
        return $rs;
    }    
    function updateStatus($id,$status) {        
        $time = time();
        $sql = "UPDATE image
                    SET status = $status,                 
                    update_time =  $time         
                    WHERE image_id = $id ";
        mysql_query($sql) or die(mysql_error() . $sql);
    }
   
    function insertImage($image_url,$img_2,$img_3,$nhaxe_id){
        try{
            $user_id = $_SESSION['user_id'];
            $time = time();
            $sql = "INSERT INTO image VALUES(NULL,$nhaxe_id,'$image_url','$img_2','$img_3',$time,$time,1,$user_id)";
            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());       
        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Image','function' => 'insertImage' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }    

}

?>