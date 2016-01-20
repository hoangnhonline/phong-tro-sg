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
class Album extends Db {

    function insertAlbum($album_name,$arrImage) {
        try{
            $sql = "INSERT INTO album VALUES
                            (NULL,'$album_name',1)";
            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());
            $album_id = mysql_insert_id();
            if(!empty($arrImage)){
                foreach ($arrImage as $image_url) {
                    if($image_url){
                        mysql_query("INSERT INTO imagesalbum VALUES(null,'$image_url',$album_id)") or die(mysql_error());
                    }
                }
            }
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Album','function' => 'insertAlbum' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function updateAlbum($album_id,$album_name,$arrImage){
        try{
            $sql = "UPDATE album
                    SET album_name = '$album_name' WHERE album_id = $album_id";
            mysql_query($sql);

            mysql_query("DELETE FROM link WHERE album_id = $album_id");

            if(!empty($arrImage)){
                foreach ($arrImage as $image_url) {
                    if($image_url){
                        mysql_query("INSERT INTO imagesalbum VALUES(null,'$image_url',$album_id)") or die(mysql_error());
                    }
                }
            }
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Album','function' => 'updateAlbum' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }

    function getDetailAlbum($album_id){
        $arrReturn = array();
        $sql = "SELECT * FROM album WHERE album_id = $album_id";
        $rs = mysql_query($sql);
        $row = mysql_fetch_assoc($rs);
        $arrReturn['data'] = $row;

        $sql1 = "SELECT * FROM imagesalbum WHERE album_id = $album_id";
        $rs1 = mysql_query($sql1);
        while($row1= mysql_fetch_assoc($rs1)){
            $arrReturn['images'][] = $row1;
        }

        return $arrReturn;
    }
    function getListLinkByAlbum($album_id){
        $arrReturn = array();
        $sql = "SELECT * FROM link WHERE album_id = $album_id";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn[] = $row;
        }
        return $arrReturn;
    }
    function getListAlbum(){
        $arrReturn = array();
        $sql = "SELECT * FROM album WHERE status = 1";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn[] = $row;
        }
        return $arrReturn;
    }
}

?>