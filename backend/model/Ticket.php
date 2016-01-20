<?php
require_once "Db.php";
if(!isset($_SESSION)) 
{ 
    session_start(); 
}  
class Ticket extends Db {

    function getDetailTicket($id) {
        $sql = "SELECT * FROM ticket WHERE ticket_id = $id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_assoc($rs);
        return $row;
    }

    function getTimeTicket($ticket_id){
        $arrResult = array();
        $sql = "SELECT * FROM time_ticket WHERE ticket_id = $ticket_id";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
                $arrResult[] = $row['time_id']; 
        }
        return $arrResult;
    }  
    function getServiceTicket($ticket_id){
        $arrResult = array();
        $sql = "SELECT * FROM service_ticket WHERE ticket_id = $ticket_id";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
                $arrResult[] = $row['service_id']; 
        }
        return $arrResult;
    } 

    function getListTicket($nhaxe_id=-1,$tinh_id_start=-1,$tinh_id_end=-1,$date_start=-1,$offset = -1, $limit = -1,$type=1) {
        $arrResult = array();
        try{
            $sql = "SELECT * FROM ticket WHERE status > 0 
            AND (nhaxe_id = $nhaxe_id OR $nhaxe_id = -1 ) AND (tinh_id_start = $tinh_id_start OR $tinh_id_start = -1)
            AND (tinh_id_end = $tinh_id_end OR $tinh_id_end = -1) AND  (date_start = $date_start OR $date_start = -1)";
            if($type==2) $sql.=" GROUP BY key_all "  ;
             $sql.="ORDER BY update_time ASC ";            
              
            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";              
            
            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());  
            while($row = mysql_fetch_assoc($rs)){
                $arrResult['data'][] = $row; 
            }
            $arrResult['total'] = mysql_num_rows($rs);

        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Ticket','function' => 'getListTicket' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
        
        return $arrResult;
    }
    function getListTicketFE($sort=1,$nhaxe_id="",$tinh_id_start=-1,$tinh_id_end=-1,$date_start=-1,$service="",$offset = -1, $limit = -1) {
        $arrResult = array();

        try{
            $sql = "SELECT * FROM ticket t1 ";
            if($service!=''){
                $sql.=" INNER JOIN service_ticket t2 ON (t1.ticket_id = t2.ticket_id AND t2.service_id IN ($service))";
            }else{
                $sql.=" WHERE t1.status > 0 ";
            }
            if($nhaxe_id!=""){
                $sql.= " AND nhaxe_id IN (".$nhaxe_id.") ";
            }
            $sql.=" AND (t1.tinh_id_start = $tinh_id_start OR $tinh_id_start = -1)
            AND (t1.tinh_id_end = $tinh_id_end OR $tinh_id_end = -1) AND  (t1.date_start = $date_start OR $date_start = -1)";
            $order = ($sort ==1 ) ? " t1.price DESC " : " t1.price ASC ";
             $sql.="ORDER BY $order ";            
              
            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";              
            echo $sql;die('1233');
            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());  
            while($row = mysql_fetch_assoc($rs)){
                $arrResult['data'][] = $row; 
            }
            $arrResult['total'] = mysql_num_rows($rs);

        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Ticket','function' => 'getListTicket' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
        
        return $arrResult;
    }    
    function updateStatus($id,$status) {        
        $time = time();
        $sql = "UPDATE ticket
                    SET status = $status,                 
                    update_time =  $time         
                    WHERE ticket_id = $id ";
        mysql_query($sql) or die(mysql_error() . $sql);
    }

    function updateTicket($ticket_id,$nhaxe_id,$tinh_id_start,$tinh_id_end,$place_id_start,$place_id_end,$price,$type,$duration,$amount,$car_type,$stop,$note,$date_start,$arrSer,$arrTime) {        
        $time = time(); 
        $user_id = $_SESSION['user_id'];               
        try{
            $sql = "UPDATE ticket
                        SET nhaxe_id = $nhaxe_id,
                        tinh_id_start = $tinh_id_start,
                        tinh_id_end = $tinh_id_end,
                        place_id_start = $place_id_start,
                        place_id_end = $place_id_end,
                        price = '$price',
                        type  = '$type',
                        duration = '$duration',
                        amount =  $amount,
                        car_type = '$car_type',
                        stop =  $stop,
                        note =  '$note',
                        update_time = $time, ";
                    if($date_start > 0) {     
                        $sql .= " date_start = $date_start, ";
                    }

                    $sql.=" user_id = $user_id                      
                        WHERE ticket_id = $ticket_id ";
            mysql_query($sql) or $this->throw_ex(mysql_error());  

            if(!empty($arrTime)){
                foreach ($arrTime as $time_id) {
                    $this->insertTimeTicket($ticket_id,$time_id);
                }
            }else{
                $this->deleteTimeTicket($ticket_id);
            }   
            if(!empty($arrSer)){
                foreach ($arrSer as $service_id) {
                    $this->insertServiceTicket($ticket_id,$service_id);
                }
            }else{
                $this->deleteServiceTicket($ticket_id);
            }    
        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Ticket','function' => 'updateTicket' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }

            
    }
    function getAbbreviationRoute($tinh_id_start,$tinh_id_end){
        $sql = "SELECT abbreviation FROM route WHERE tinh_id_start = $tinh_id_start AND tinh_id_end = $tinh_id_end"; 
        $rs = mysql_query($sql);
        $row = mysql_fetch_assoc($rs);
        return $row['abbreviation']; 
    }
    function insertTicket($nhaxe_id,$tinh_id_start,$tinh_id_end,$place_id_start,$place_id_end,$price,$type,$duration,$amount,$car_type,$stop,$note,$arrSer,$arrTime,$arrDates,$key_all,$str_month){        
        $user_id = $_SESSION['user_id'];
        if(!empty($arrDates)){
            foreach ($arrDates as $datestart) {
                $date_start = strtotime($datestart);
                try{
                    $time = time();
                    $sql = "INSERT INTO ticket VALUES(NULL,$nhaxe_id,$tinh_id_start,$tinh_id_end,$place_id_start,$place_id_end,
                        '$price',$type,'$duration',
                        $amount,$car_type,$stop,'$note','$date_start',$time,$time,1,$user_id,'$key_all','$str_month','')";        
                    $rs = mysql_query($sql) or $this->throw_ex(mysql_error());  
                    $ticket_id = mysql_insert_id();
                    //update code
                    $month = date('m',$date_start);
                    $day = date('d',$date_start);
                    $tmp = str_pad($ticket_id, 3, "0", STR_PAD_LEFT);

                    $abbreviation = $this->getAbbreviationRoute($tinh_id_start,$tinh_id_end);
                    $code = $abbreviation.'-'.$day.$month.$tmp;

                    mysql_query("UPDATE ticket SET code = '$code' WHERE ticket_id = $ticket_id");
                    
                    if(!empty($arrTime)){
                        foreach ($arrTime as $time_id) {
                            $this->insertTimeTicket($ticket_id,$time_id);
                        }
                    } 
                    if(!empty($arrSer)){
                        foreach ($arrSer as $service_id) {
                            $this->insertServiceTicket($ticket_id,$service_id);
                        }
                    }    
                }catch(Exception $ex){            
                    $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Ticket','function' => 'insertTicket' , 'error'=>$ex->getMessage(),'sql'=>$sql);
                    $this->logError($arrLog);
                }
            }
        }
    }    

    function deleteTimeTicket($ticket_id){
        $sql = "DELETE FROM time_ticket WHERE ticket_id = $ticket_id ";
        mysql_query($sql);
    }

    function insertTimeTicket($ticket_id,$time_id){
        $sql = "INSERT into time_ticket VALUES($ticket_id,$time_id)";
        mysql_query($sql);
    }

    function deleteServiceTicket($ticket_id){
        $sql = "DELETE FROM service_ticket WHERE ticket_id = $ticket_id ";
        mysql_query($sql);
    }

    function insertServiceTicket($ticket_id,$service_id){
        $sql = "INSERT into service_ticket VALUES($ticket_id,$service_id)";
        mysql_query($sql);
    }

    function pagination($page, $page_show, $total_page,$r=1){        
        $dau = 1;
        $cuoi = 0;
        $dau = $page - floor($page_show / 2);
        if ($dau < 1)
            $dau = 1;
        $cuoi = $dau + $page_show;
        if ($cuoi > $total_page) {

            $cuoi = $total_page + 1;
            $dau = $cuoi - $page_show;
            if ($dau < 1)
                $dau = 1;
        }
        $str='<div class="pagination-page"><div class="left t-page"><p>Page<span> '.$page.'</span> of <span>'.$total_page.'</span></p></div><div class="right t-pagination"><ul>';
        if ($page > 1) {
            ($page == 1) ? $class = " class='active'" : $class = "";
            $str.='<li><a ' . $class . ' href="javascript:;" attr-value="1"><</a><li>';
            echo "";
        }
        for ($i = $dau; $i < $cuoi; $i++) {
            ($page == $i) ? $class = " class='active'" : $class = "";
            $str.='<li><a ' . $class . ' href="javascript:;" attr-value="'.$i.'">'.$i.'</a><li>';            
        }
        if ($page < $total_page) {
            ($page == $total_page) ? $class = " class='active end'" : $class = " class='end' ";
            $str.='<li><a ' . $class . ' href="javascript:;" attr-value="'.$total_page.'">></a><li>';            
        }
        $str.="</ul></div></div>";
        return $str;       
                            
    }

}

?>