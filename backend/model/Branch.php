<?php
require_once "Db.php";
if(!isset($_SESSION)) 
{ 
    session_start(); 
}  
class Branch extends Db {

    function getDetailBranch($id) {
        $sql = "SELECT * FROM branch WHERE branch_id = $id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_assoc($rs);
        return $row;
    }

    function getBranchNameByID($id) {
        $sql = "SELECT branch_name_vi FROM branch WHERE branch_id = $id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_assoc($rs);
        return $row['branch_name_vi'];
    }
   

    function getListBranchByNhaxe($nhaxe_id=-1,$offset = -1, $limit = -1) {
        $arrResult = array();
        $sql = "SELECT * FROM branch WHERE (nhaxe_id = $nhaxe_id OR $nhaxe_id = -1)  AND status > 0 ";
        if ($limit > 0 && $offset >= 0)
            $sql .= " LIMIT $offset,$limit";
        $rs = mysql_query($sql) or die(mysql_error());
        while($row = mysql_fetch_assoc($rs)){
            $arrResult['data'][] = $row; 
        }
        $arrResult['total'] = mysql_num_rows($rs);
        return $arrResult;
    }    
    function updateStatus($id,$status) {        
        $time = time();
        $sql = "UPDATE branch
                    SET status = $status,                 
                    update_time =  $time         
                    WHERE branch_id = $id ";
        mysql_query($sql) or die(mysql_error() . $sql);
    }

    function updateBranch($id,$branch_name_vi,$branch_name_en,$branch_name_safe_vi,$branch_name_safe_en,$address_vi,$address_en,$phone,$tinh_id){
        $time = time();
        $user_id = $_SESSION['user_id'];
        $sql = "UPDATE branch
                    SET branch_name_vi = '$branch_name_vi',
                    branch_name_en = '$branch_name_en',
                    branch_name_safe_vi  = '$branch_name_safe_vi',
                    branch_name_safe_en = '$branch_name_safe_en',
                    address_vi  = '$address_vi',
                    address_en = '$address_en',
                    phone  = '$phone',                    
                    tinh_id = $tinh_id,
                    update_time =  $time ,
                    user_id = $user_id
                    WHERE branch_id = $id ";
        mysql_query($sql) or die(mysql_error() . $sql);
    }
    function insertBranch($nhaxe_id,$branch_name_vi,$branch_name_en,$tinh_id,$address_vi,$address_en,$phone,$branch_name_safe_vi,$branch_name_safe_en){
        try{
            $user_id = $_SESSION['user_id'];
            $time = time();
            $sql = "INSERT INTO branch VALUES(NULL,$nhaxe_id,'$branch_name_vi','$branch_name_safe_vi','$branch_name_en','$branch_name_safe_en','$tinh_id','$address_vi','$address_en','$phone',$time,$time,1,$user_id)";
            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());       
        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Branch','function' => 'insertBranch' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }    

}

?>