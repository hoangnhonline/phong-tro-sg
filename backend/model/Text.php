<?php
include "model/Db.php";
try{

    include "../model/Db.php";
}catch(Exception $ex){

}
class Text extends Db {


    function getDetailText($id) {

        $sql = "SELECT * FROM text WHERE id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row;

    }

    function getTextByID($id) {

        $sql = "SELECT text FROM text WHERE id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row['text'];

    }



    function getListText($offset = -1, $limit = -1) {

        $sql = "SELECT * FROM text ";

        if ($limit > 0 && $offset >= 0)

            $sql .= " LIMIT $offset,$limit";

        $rs = mysql_query($sql) or die(mysql_error());

        return $rs;

    }



    function updateText($id,$text) {

        $time = time();

        $sql = "UPDATE text

                    SET text = '$text'

                    WHERE id = $id ";

        mysql_query($sql) or die(mysql_error() . $sql);

    }

    function insertText($text){

        try{

            $time = time();

            $sql = "INSERT INTO text VALUES(NULL,'$text')";

            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());

        }catch(Exception $ex){

            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Text','function' => 'insertText' , 'error'=>$ex->getMessage(),'sql'=>$sql);

            $this->logError($arrLog);

        }

    }



}



?>