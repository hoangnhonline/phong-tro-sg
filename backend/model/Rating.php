<?php
require_once "Db.php";

class Rating extends Db {

    function getDetailRating($nhaxe_id,$email_id) {
        $sql = "SELECT * FROM rating_detail WHERE nhaxe_id = $nhaxe_id AND email_id = $email_id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_assoc($rs);
        return $row;
    }

    function getEmailByEmailID($email_id){
        $sql = "SELECT email FROM email_rating WHERE email_id = $email_id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_assoc($rs);
        return $row['email'];
    }

    function getListRating($nhaxe_id=-1,$lang=-1,$status = -1, $offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM email_rating WHERE (status = $status OR $status = -1 )
            AND (nhaxe_id = $nhaxe_id OR $nhaxe_id = -1 ) AND (lang = $lang OR $lang = -1 )
             ORDER BY email_id DESC ";            
            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";        
            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());  
            while($row = mysql_fetch_assoc($rs)){
                $arrResult['data'][] = $row; 
            }

            $arrResult['total'] = mysql_num_rows($rs);     
        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Rating','function' => 'getListRating' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
        
        return $arrResult;
    }       

    function updateRating($id,$code,$amount,$type,$value){
        $time = time();
        $sql = "UPDATE email_rating
                    SET  code= '$code',
                    type = '$type',
                    code_value  = '$value',
                    amount = $amount                    
                    WHERE code_id = $id ";
        mysql_query($sql) or die(mysql_error() . $sql);
    }
    function updateStatus($id,$status){
        $time = time();
        $sql = "UPDATE email_rating
                    SET  status = $status                                   
                    WHERE code_id = $id ";
        mysql_query($sql) or die(mysql_error() . $sql);
    }
    function insertRating($nhaxe_id,$lang,$list_email){
        try{            
            $time = time();
            $tmp = explode(";",$list_email);
            foreach ($tmp as $email) {
                $email = trim($email);
                $code = md5($email.$time);
                $sql = "INSERT INTO email_rating VALUES(NULL,'$email',$time,'$code',$nhaxe_id,$lang,3)";
                $rs = mysql_query($sql) or $this->throw_ex(mysql_error()); 
            }
                  
        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Rating','function' => 'insertRating' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }    
    function insertMailNhanCode($code_id,$list_email){
        try{            
            $time = time();
            $tmp = explode(";",$list_email);
            $code = $this->getCodeByID($code_id);
            foreach ($tmp as $email) {
                $email = trim($email); 
                $sql = "INSERT INTO email_code VALUES(NULL,'$email',$code_id,'$code',1)";
                $rs = mysql_query($sql) or $this->throw_ex(mysql_error()); 
            }
                  
        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Rating','function' => 'insertMailNhanCode' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function getCodeByID($code_id){
        $sql = "SELECT code FROM promotion_code WHERE code_id = $code_id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_assoc($rs);
        return $row['code'];
    }
    function getListEmailNhanCode($code_id=-1,$status = -1, $offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM email_code WHERE (status = $status OR $status = -1 )
            AND (code_id = $code_id OR $code_id = -1 )  ORDER BY id DESC ";            
            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";        
            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());  
            while($row = mysql_fetch_assoc($rs)){
                $arrResult['data'][] = $row; 
            }

            $arrResult['total'] = mysql_num_rows($rs);     
        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Rating','function' => 'getListRating' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
        
        return $arrResult;
    }

}

?>