<?php
require_once "Db.php";

class Code extends Db {

    function getDetailCode($id) {
        $sql = "SELECT * FROM promotion_code WHERE code_id = $id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_assoc($rs);
        return $row;
    }

    function getListCode($status = -1, $offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM promotion_code WHERE (status = $status OR $status = -1 )";            
            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";        
            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());  
            while($row = mysql_fetch_assoc($rs)){
                $arrResult['data'][] = $row; 
            }

            $arrResult['total'] = mysql_num_rows($rs);     
        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Code','function' => 'getListCode' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
        
        return $arrResult;
    }       

    function updateCode($id,$code,$amount,$type,$value){
        $time = time();
        $sql = "UPDATE promotion_code
                    SET  code= '$code',
                    type = '$type',
                    code_value  = '$value',
                    amount = $amount                    
                    WHERE code_id = $id ";
        mysql_query($sql) or die(mysql_error() . $sql);
    }
    function updateStatus($id,$status){
        $time = time();
        $sql = "UPDATE promotion_code
                    SET  status = $status                                   
                    WHERE code_id = $id ";
        mysql_query($sql) or die(mysql_error() . $sql);
    }
    function insertCode($code,$amount, $type,$value,$status){
        try{
            $time = time();
            $sql = "INSERT INTO promotion_code VALUES(NULL,'$code',$amount,$type,'$value',2)";
            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());       
        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Code','function' => 'insertCode' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function insertEmailNhanCode($code,$amount, $type,$value,$status){
        try{
            $time = time();
            $sql = "INSERT INTO promotion_code VALUES(NULL,'$code',$amount,$type,'$value',2)";
            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());       
        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Code','function' => 'insertCode' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }    

}

?>