<?php
require_once "Db.php";

class Delete extends Db {
    
    function delete($id,$table,$key) {        
        $time = time();
        $sql = "UPDATE '$table'
                    SET status = 0,                 
                    update_time =  $time         
                    WHERE '$key' = $id ";
        mysql_query($sql) or die(mysql_error() . $sql);
    }

}

?>