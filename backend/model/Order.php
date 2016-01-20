<?php
require_once "Db.php";
if(!isset($_SESSION)) 
{ 
    session_start(); 
}  
class Order extends Db {

    function getDetailOrder($id) {
        $sql = "SELECT * FROM orders WHERE order_id = $id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_assoc($rs);
        return $row;
    }
    function updateOrder($order_id,$status,$is_pay){
        $sql = "UPDATE orders
                    SET status = $status,                 
                    is_pay =  $is_pay         
                    WHERE order_id = $order_id ";
        mysql_query($sql) or die(mysql_error() . $sql);
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

    
    function getListOrder($mave='',$order_code="",$fullname="",$phone="",$email="",$status=-1,$method_id=-1,$is_pay=-1,$fromdate=-1,$todate=-1,$offset = -1, $limit = -1) {
        $arrResult = array();

        try{
            $sql = "SELECT orders.* FROM orders WHERE (orders.status = $status OR $status = -1) AND (is_pay = $is_pay OR $is_pay = -1) ";
            if($mave != ''){
                $sql = "SELECT orders.*,order_detail.* FROM orders,order_detail WHERE (orders.status = $status OR $status = -1) AND (is_pay = $is_pay OR $is_pay = -1) ";
            }
            $sql.=" AND ( method_id = $method_id OR $method_id = -1 ) ";         
            
            if($fullname !=''){
                $sql.=" AND orders.fullname LIKE '%$fullname%'";
            }
            if($order_code !=''){
                $sql.=" AND orders.order_code = '$order_code' ";
            }
            if($phone !=''){
                $sql.=" AND orders.phone = '$phone' ";
            }
            if($email !=''){
                $sql.=" AND orders.email = '$email' ";
            }            
            if($mave != ''){
                $sql .= " AND orders.order_id = order_detail.order_id AND order_detail.code = '$mave'";
            }
            $nows = time();
            if($fromdate > 0 && $todate > 0){
                $sql.= " AND (orders.creation_time BETWEEN $fromdate AND $todate) " ;
            }
            if($fromdate > 0 && $todate < 0){
                $sql.= " AND orders.creation_time >= $fromdate "; 
            }
            if($fromdate < 0 && $todate > 0){
                $sql.= " AND orders.creation_time <= $todate "; 
            }
            
            $sql.=" ORDER BY orders.creation_time DESC ";            
              
            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";              
            //echo $sql; 
            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());  
            while($row = mysql_fetch_assoc($rs)){
                $arrResult['data'][] = $row; 
            }
            $arrResult['total'] = mysql_num_rows($rs);

        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Order','function' => 'getListOrder' , 'error'=>$ex->getMessage(),'sql'=>$sql);
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