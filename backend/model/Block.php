<?php
include "model/Db.php";
try{
    include "../model/Db.php";
}catch(Exception $ex){

}
if(!isset($_SESSION))
{
    session_start();
}
class Block extends Db {

    function insertBlock($block_name,$arrText,$arrLink) {
        try{
            $sql = "INSERT INTO block VALUES
                            (NULL,'$block_name',1)";
            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());
            $block_id = mysql_insert_id();
            if(!empty($arrText) && !empty($arrLink)){
                foreach ($arrText as $k=> $text) {
                    if($text){
                        $link = $arrLink[$k];
                        mysql_query("INSERT INTO link VALUES(null,'$text',$block_id,'$link',1)") or die(mysql_error());
                    }
                }
            }
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Block','function' => 'insertBlock' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function updateBlock($block_id,$block_name,$arrText,$arrLink){
        try{
            $sql = "UPDATE block
                    SET block_name = '$block_name' WHERE block_id = $block_id";
            mysql_query($sql);

            mysql_query("DELETE FROM link WHERE block_id = $block_id");

            if(!empty($arrText) && !empty($arrLink)){
                foreach ($arrText as $k=> $text) {
                    if($text){
                        $link = $arrLink[$k];
                        mysql_query("INSERT INTO link VALUES(null,'$text',$block_id,'$link',1)") or die(mysql_error());
                    }
                }
            }
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Block','function' => 'updateBlock' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }

    function getDetailBlock($block_id){
        $sql = "SELECT * FROM block WHERE block_id = $block_id";
        $rs = mysql_query($sql);
        $row = mysql_fetch_assoc($rs);
        return $row;
    }
    function getListLinkByBlock($block_id){
        $arrReturn = array();
        $sql = "SELECT * FROM link WHERE block_id = $block_id";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn[] = $row;
        }
        return $arrReturn;
    }
    function getListBlock(){
        $arrReturn = array();
        $sql = "SELECT * FROM block WHERE status = 1";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn[] = $row;
        }
        return $arrReturn;
    }
}

?>