<?php

require_once "Db.php";
if(!isset($_SESSION)) 
{ 
    session_start(); 
}  
class Question extends Db {

    function getDetailQuestion($question_id) {
        $sql = "SELECT * FROM question WHERE question_id = $question_id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row =mysql_fetch_assoc($rs);
        return $row;
    }  
   
    function getListQuestion() {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM question WHERE status = 1 ";
            
            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";
            
            $rs = mysql_query($sql) or die(mysql_error());
            while($row = mysql_fetch_assoc($rs)){
               $arrResult['data'][] = $row; 
            }

            $arrResult['total'] = mysql_num_rows($rs);   
            return $arrResult;  
        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Question','function' => 'getListArticle' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
   

    function insertQuestion($content,$answer) {
        try{        
        $time = time();
        $sql = "INSERT INTO question VALUES
                        (NULL,'$content','$answer',$time,$time,1)";
        $rs = mysql_query($sql) or $this->throw_ex(mysql_error());       
        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Question','function' => 'insertQuestion' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }    

    function updateQuestion($question_id,$content,$answer) {
       try{    
        $time = time();
        $sql = "UPDATE question
                    SET content = '$content',
                    answer= '$answer',
                    update_time = $time
                    WHERE question_id = $question_id ";
        mysql_query($sql)  or $this->throw_ex(mysql_error());       
        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Question','function' => 'updateQuestion' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }

}

?>