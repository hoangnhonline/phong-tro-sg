<?php
include "model/Db.php";
try{

    include "../model/Db.php";
}catch(Exception $ex){

}
class Price extends Db {


    function getDetailPrice($id) {

        $sql = "SELECT * FROM price WHERE price_id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row;

    }

    function getPriceByID($id) {

        $sql = "SELECT price_name FROM price WHERE price_id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row['price_name'];

    }



    function getListPriceByStatus($status=-1,$offset = -1, $limit = -1) {

        $sql = "SELECT * FROM price WHERE (status = $status OR $status = -1)  AND status > 0 ";

        if ($limit > 0 && $offset >= 0)

            $sql .= " LIMIT $offset,$limit";

        $rs = mysql_query($sql) or die(mysql_error());

        return $rs;

    }

    function updateStatus($id,$status) {

        $time = time();

        $sql = "UPDATE price

                    SET status = $status,

                    update_time =  $time

                    WHERE price_id = $id ";

        mysql_query($sql) or die(mysql_error() . $sql);

    }



    function updatePrice($id,$price_name) {

        $time = time();

        $sql = "UPDATE price

                    SET price_name = '$price_name',                
                    update_time =  $time

                    WHERE price_id = $id ";

        mysql_query($sql) or die(mysql_error() . $sql);

    }

    function insertPrice($price_name){

        try{

            $time = time();

            $sql = "INSERT INTO price VALUES(NULL,'$price_name',1,1,$time,$time)";

            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());

        }catch(Exception $ex){

            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Price','function' => 'insertPrice' , 'error'=>$ex->getMessage(),'sql'=>$sql);

            $this->logError($arrLog);

        }

    }



}



?>