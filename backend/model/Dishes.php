<?php

require_once "Db.php";
if(!isset($_SESSION)) 
{ 
    session_start(); 
}  
class Dishes extends Db {

    function getDetailDishes($id) {
        $sql = "SELECT * FROM dishes WHERE id = $id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row =mysql_fetch_assoc($rs);
        return $row;
    }  
   
    function getListDishes($keyword='',$type = -1,$offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM dishes WHERE (type = $type OR $type = -1)
                    ";
            if(trim($keyword) != ''){
                $sql.= " AND name LIKE '%".$keyword."%' " ;
            }    
            $sql.=" AND status = 1 ORDER BY id DESC ";
            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";
            
            $rs = mysql_query($sql) or die(mysql_error());
            while($row = mysql_fetch_assoc($rs)){
               $arrResult['data'][] = $row; 
            }

            $arrResult['total'] = mysql_num_rows($rs);   
            return $arrResult;  
        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Dishes','function' => 'getListDishes' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
   

    function insertDishes($name,$name_en,$price,$description,$components,$type,$image_url) {
        try{
            $description = mysql_escape_string($description);
            $components = mysql_escape_string($components);
            $name_en = mysql_escape_string($name_en);
            $sql = "INSERT INTO dishes VALUES
                            (NULL,'$name','$name_en','$price','$description','$components','$type',
                                '$image_url',1)";
            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());
            $id = mysql_insert_id();           

        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Dishes','function' => 'insertDishes' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }

    function updateDishes($id,$name,$name_en,$price,$description,$components,$type,$image_url) {
       try{                
            $description = mysql_escape_string($description);
            $components = mysql_escape_string($components);
            $name_en = mysql_escape_string($name_en);
            
        $sql = "UPDATE dishes
                    SET name = '$name',price = '$price',
                    image_url = '$image_url',type = $type,name_en = '$name_en',
                    description = '$description',components = '$components'
                    WHERE id = $id ";
        mysql_query($sql)  or $this->throw_ex(mysql_error());  

        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Dishes','function' => 'updateDishes' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }

}

?>