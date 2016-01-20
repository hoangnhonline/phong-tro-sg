<?php

require_once "Db.php";

if(!isset($_SESSION)) 

{ 

    session_start(); 

}  

class Page extends Db {



    function getDetailPage($id) {

        $sql = "SELECT * FROM page WHERE page_id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row;

    }

   



    function getListPage($offset = -1, $limit = -1) {

        $arrResult = array();

        $sql = "SELECT * FROM page WHERE status=1";

        
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

        $sql = "UPDATE page

                    SET status = $status,                 

                    update_time =  $time         

                    WHERE page_id = $id ";

        mysql_query($sql) or die(mysql_error() . $sql);

    }



    function updatePage($page_id,$page_title_vi,$page_title_en,$content_vi,$content_en,$status,$tinh_id) {        

        $time = time();      

        

        $sql = "UPDATE page

                    SET page_title_vi = '$page_title_vi',

                    page_title_en = '$page_title_en',

                    content_vi  = '$content_vi',

                    content_en = '$content_en', 

                    tinh_id = $tinh_id
       
                    WHERE page_id = $page_id ";                    

        mysql_query($sql) or die(mysql_error() . $sql);

    }

    function insertPage($page_title_vi,$page_title_en,$content_vi,$content_en,$status,$page_id){

        try{

            $user_id = $_SESSION['user_id'];

            $time = time();

            $sql = "INSERT INTO page VALUES(NULL,'$page_title_vi','$page_title_en','$content_vi','$content_en',1,$page_id)";

            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());       

        }catch(Exception $ex){            

            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Page','function' => 'insertPage' , 'error'=>$ex->getMessage(),'sql'=>$sql);

            $this->logError($arrLog);

        }

    }    



}



?>