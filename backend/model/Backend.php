<?php
//ini_set('display_errors', '1');
class Backend {
    function __construct() {
		if($_SERVER['SERVER_NAME']=='localhost'){
            mysql_connect('localhost', 'root', 'root') or die("Can't connect to server");
               mysql_select_db('phongtro_sg') or die("Can't connect database");
        }else{
            mysql_connect('localhost', 'phongtrosgcom8c', '789424dc67cf9348b') or die("Can't connect to server");
            mysql_select_db('phongtrosg_com_8c') or die("Can't connect database");  
        }
        mysql_query("SET NAMES 'utf8'") or die(mysql_error());
    }
    function processData($str) {
        $str = trim(strip_tags($str));
        if (get_magic_quotes_gpc() == false) {
            $str = mysql_real_escape_string($str);
        }
        return $str;
    }
    function getDetailBanner($id){
        $arrReturn = array();
        $sql = mysql_query("SELECT * FROM banner WHERE id = $id");
        $arrReturn = mysql_fetch_assoc($sql);        
        return $arrReturn;
    }
    function changePass($user_id,$password) {
        
        $sql = "UPDATE users SET password = '$password' WHERE id = $user_id";
        mysql_query($sql);

    }
    /* banner */
    function insertBanner($name_event,$name_en,$start_time,$end_time,$position_id,$description,$content,$image_url,$link_url,$type_id,$size_default,$status){
        try{    
            $user_id = $_SESSION['user_id'];
            $time = time();            
            $sql = "INSERT INTO banner VALUES
                            (NULL,'$name_event','$name_en',$start_time,$end_time,$position_id,'$description','$content','$image_url','$link_url',
                            $type_id,'$size_default',$status,$time,$time,1,1)";
            $rs = mysql_query($sql) or die(mysql_error());            
        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Banner','function' => 'insertBanner' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }   

    function updateBanner($id,$name_event,$name_en,$start_time,$end_time,$position_id,$description,$content,$image_url,$link_url,$type_id,$size_default,$status){
       try{           

         
            $time = time();    
           echo $sql = "UPDATE banner
                        SET name_event = '$name_event', start_time = $start_time,end_time = $end_time,position_id = $position_id,
                            image_url = '$image_url',description = '$description',name_en = '$name_en',
                            content = '$content',type_id = $type_id, link_url = '$link_url',
                            status = '$status',updated_at = $time ,updated_by = 1
                        WHERE id = $id "; 

            $rs = mysql_query($sql) or die(mysql_error());                              
        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Banner','function' => 'updateBanner' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }  
    function countObject($object_type, $status = -1, $user_id=-1){
        $arr = array();
        $sql = "SELECT * FROM objects WHERE status = $status AND object_type = $object_type AND (user_id = $user_id OR $user_id = -1) ";
        $rs = mysql_query($sql) or die(mysql_error());
        $count = mysql_num_rows($rs);
        return $count;
    }
    function getListContractDenHan($user_id = -1){
        $arr = array();
        $sql = "SELECT contract.*, objects.name as name, objects.house_id as house_id  FROM `contract`, objects WHERE objects.id = contract.object_id AND
        DAY(start_date) - DAY(NOW()) <= 3 AND DAY(start_date) - DAY(NOW()) >= 0 AND DATE(end_date) > DATE(NOW()) AND contract.status = 1 AND (contract.user_id = $user_id OR $user_id = -1)
        ORDER BY start_date
        ";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_assoc($rs)) {
            $arr[$row['id']] = $row;   
        }
        return $arr;
    }
    function getListContractSapHetHan($user_id = -1){
        $arr = array();
        $sql = "SELECT contract.*, objects.name as name, objects.house_id as house_id  FROM `contract`, objects WHERE objects.id = contract.object_id 
        AND DATE( DATE_ADD( NOW( ) , INTERVAL 1 MONTH )) >= DATE(end_date) AND DATE(end_date) >= DATE(NOW()) AND contract.status = 1 AND (contract.user_id = $user_id OR $user_id = -1)
        ORDER BY end_date
        ";
        $rs = mysql_query($sql) or die(mysql_error());
        while ($row = mysql_fetch_assoc($rs)) {
            $arr[$row['id']] = $row;   
        }
        return $arr;
    }
    function getListByStringId($table, $string){
        $arr = array();
        $sql = "SELECT * FROM $table WHERE id IN ($string)";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arr[$row['id']] = $row;
        }
        return $arr;
    }
     function getTagsOfProductId($article_id){
        $arr = array();
        $sql = "SELECT tag_id FROM articles_tag WHERE article_id = $article_id";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arr[] = $row['tag_id']; 
        }
        return $arr;
    }
    function insertArticles($name,$alias,$image_url,$description,$content,$cate_id,$arrTag,$source,$title,$meta_d,$meta_k) {
        try{
            //$user_id = $_SESSION['user_id'];
            $time = time();
            $user_id = 1;
            $sql = "INSERT INTO articles VALUES
                            (NULL,'$name','$alias','$description','$content',$image_url,,$cate_id,1,'$source',
                                $time,$time,'$title','$meta_d','$meta_k')";
            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());
            $article_id = mysql_insert_id();
            
            if(!empty($arrTag)){
                foreach($arrTag as $tag){
                    $tag = trim($tag);
                    $tag_id = $this->checkTagTonTai($tag);
                    $this->addTagToArticle($article_id,$tag_id);
                }
            }       


        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Articles','function' => 'insertArticle' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }

    function getDoanhThuTotalUser($user_id = -1, $month = -1, $year = -1){
        $arr = array();
        $sql ="SELECT SUM( tien_nhan ) AS doanhthu, SUM( cong_no ) AS congno, 
                month , year , user_id
                FROM  doanh_thu
                WHERE ( user_id = $user_id OR $user_id = -1 ) AND ( month = $month OR $month = -1 ) AND ( year = $year OR $year = -1 )";       
        $sql.=" GROUP BY month , year ORDER BY year DESC , month DESC";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arr[] = $row;
        }
        return $arr;

    }
    function getChiPhiTotalHouse($house_id = -1, $user_id = -1, $month = -1, $year = -1){
        $arr = array();
        $sql ="SELECT SUM( price ) AS chi_phi, month , year, house_id
                FROM  house_expense
                WHERE ( house_id = $house_id OR $house_id = -1 ) AND ( user_id = $user_id OR $user_id = -1 ) AND ( month = $month OR $month = -1 ) AND ( year = $year OR $year = -1 )";       
        $sql.=" GROUP BY month , year ORDER BY year DESC , month DESC";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arr[] = $row;
        }
        return $arr;
    }
    function getChiPhiByHouse($house_id, $month, $year){
        $arr = array();
        $sql ="SELECT SUM( price ) AS chi_phi
                FROM  house_expense
                WHERE house_id = $house_id AND month = $month AND year = $year ";       
      
        $rs = mysql_query($sql) or die(mysql_error(). $sql);
        $row = mysql_fetch_assoc($rs);
        return $row['chi_phi'];
    }
    function getChiPhiDetailHouse($house_id , $month = -1, $year = -1){
        $arr = array();
        $sql ="SELECT *
                FROM  house_expense
                WHERE house_id = $house_id AND ( month = $month OR $month = -1 ) AND ( year = $year OR $year = -1 )";               
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arr[] = $row;
        }
        return $arr;
    }
    function getDetailUser($id) {

        $sql = "SELECT * FROM users WHERE id = $id";

        $rs = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_assoc($rs);

        return $row;

    }
    function getContractCodeById($id){        
        $sql = "SELECT code FROM contract WHERE id = $id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row =mysql_fetch_assoc($rs);
        return $row['code'];
    }
     function getDoanhThuMonthUser($user_id = -1, $month = -1, $year = -1){
        $arr = array();
        $sql ="SELECT contract_id, tien_nhan AS doanhthu,  cong_no  AS congno, 
                month , year 
                FROM  doanh_thu
                WHERE ( user_id = $user_id OR $user_id = -1 ) AND ( month = $month OR $month = -1 ) AND ( year = $year OR $year = -1 )";       
        $sql.=" GROUP BY contract_id ORDER BY year DESC , month DESC";        
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arr[] = $row;
        }
        return $arr;

    }
    function updateArticles($id,$name,$alias,$image_url,$description,$content,$cate_id,$arrTag,$source,$title,$meta_d,$meta_k) {
       try{
            //$user_id = $_SESSION['user_id'];
            $time = time();
            $user_id = 1;
            $sql = "UPDATE articles
                        SET name = '$name',   alias = '$alias',
                        image_url = '$image_url',source = '$source',
                        description = '$description',content = '$content',                    
                        is_hot = $is_hot,                   
                        updated_at = $time,
                        meta_title='$meta_title',
                        meta_d = '$meta_d',
                        meta_k = '$meta_k'              
                        WHERE id = $id ";
            mysql_query($sql)  or $this->throw_ex(mysql_error());  

            if(!empty($arrTag)){                  
                mysql_query("DELETE FROM articles_tag WHERE article_id = $article_id AND object_type = 2");
                foreach($arrTag as $tag){
                    $tag_id = $this->checkTagTonTai($tag);
                    $this->addTagToArticle($article_id,$tag_id);
                }
            }else{
                mysql_query("DELETE FROM articles_tag WHERE article_id = $article_id AND object_type = 2");
            }
           

        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Articles','function' => 'updateArticle' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
     function checkTagTonTai($tag){
        $sql = "SELECT tag_id FROM tag WHERE BINARY tag_name LIKE '%$tag%'";
        $rs = mysql_query($sql);
        $row = mysql_num_rows($rs);
        if($row == 1){
            $row = mysql_fetch_assoc($rs);
            $idTag = $row['tag_id'];
        }else{
            $tag_kd = $this->changeTitle($tag);
            $idTag = $this->insertTag($tag,$tag_kd);
        }
        return $idTag;
    }
    function insertTag($tag,$tag_kd){
        $sql = "INSERT INTO tag VALUES (NULL,'$tag','$tag_kd')";
        $rs = mysql_query($sql) or die(mysql_error());
        $id= mysql_insert_id();
        return $id;         
    }
    function addTagToArticle($article_id,$tag_id){
        $sql = "INSERT INTO articles_tag VALUES ($article_id,$tag_id,2)";
        mysql_query($sql) or die(mysql_error());
    }
     function getDetailArticle($id) {
        $arrReturn = array();
        $str_image = "";
        $sql = "SELECT * FROM articles WHERE id = $id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row =mysql_fetch_assoc($rs);
        $arrReturn['data']= $row;

        $sql = "SELECT * FROM images WHERE object_id = $id AND object_type = 2";
        $rs = mysql_query($sql) or die(mysql_error());
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn['images'][] = $row;
            $str_image.= $row['url'].";";            
        }
        $arrReturn['str_image'] = $str_image;        
        return $arrReturn;
    }
    function getListArticle($keyword='',$category_id = -1, $offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM articles WHERE status = 1 AND (category_id = $category_id OR $category_id = $category_id) ";
            if(trim($keyword) != ''){
                $sql.= " AND name LIKE '%".$keyword."%' " ;
            }    
            $sql.="  ORDER BY id DESC ";
            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";            
            $rs = mysql_query($sql) or die(mysql_error());
            while($row = mysql_fetch_assoc($rs)){
               $arrResult['data'][] = $row; 
            }

            $arrResult['total'] = mysql_num_rows($rs);   
            return $arrResult;  
        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Articles','function' => 'getListArticle' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function getListBannerByPosition($position_id){
        $arrReturn = array();
        $sql = mysql_query("SELECT * FROM banner WHERE position_id = $position_id");
        while($row = mysql_fetch_assoc($sql)){
            $arrReturn[] = $row;
        }
        return $arrReturn;
    }
    function getListInfoObject($object_id, $type){
        $arr = array();
        $sql = "SELECT info_id FROM objects_info WHERE object_id = $object_id AND type = $type";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arr[] = $row['info_id'];
        }
        return $arr;
    }
    function getListByArrId($table, $arrID){        
        $arr = array();
        if(!empty($arrID)){
            $string = implode(",", $arrID);
        }
        $sql = "SELECT * FROM $table WHERE id IN ($string)";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arr[$row['id']] = $row;
        }
        return $arr;
    }
    function getListDistrictIDAsset($user_id){
        $arrSelected = array();
        $sql = "SELECT id FROM district WHERE user_id = $user_id";
        $rs = mysql_query($sql);

        while($row = mysql_fetch_assoc($rs)){
            $arrSelected[] = $row['id'];
        }
        return $arrSelected;
    }
    function countRentByStringDistrictId($table, $string, $object_type){
        $total = 0;
        $sql = "SELECT * FROM $table WHERE district_id IN ($string) AND object_type = $object_type ";        
        $rs = mysql_query($sql);
        $total = mysql_num_rows($rs);
        return $total;
    }
    function getListHouseContainRoomByStringDistrictId($string){
        $arr = array();
        $sql = "SELECT * FROM house WHERE district_id IN ($string) AND type = 1";  
       
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arr[$row['id']] = $row;
        }
        return $arr;
    }
    function getListRentByStringDistrictId($table, $string){
        $arr = array();
        $sql = "SELECT * FROM $table WHERE district_id IN ($string) ";
        if($table=="house"){
            $sql.=" AND type = 2 ";
        }
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arr[$row['id']] = $row;
        }
        return $arr;
    }
    function changeTitle($str) {
        $str = $this->stripUnicode($str);
        $str = str_replace("?", "", $str);
        $str = str_replace("&", "", $str);
        $str = str_replace("'", "", $str);
        $str = str_replace("  ", " ", $str);
        $str = trim($str);
        $str = mb_convert_case($str, MB_CASE_LOWER, 'utf-8'); // MB_CASE_UPPER/MB_CASE_TITLE/MB_CASE_LOWER
        $str = str_replace(" ", "-", $str);
        $str = str_replace("---", "-", $str);
        $str = str_replace("--", "-", $str);
        $str = str_replace('"', '', $str);
        $str = str_replace('"', "", $str);
        $str = str_replace(":", "", $str);
        $str = str_replace("(", "", $str);
        $str = str_replace(")", "", $str);
        $str = str_replace(",", "", $str);
        $str = str_replace(".", "", $str);
        $str = str_replace("?", "", $str);
        $str = str_replace("'", "", $str);
        $str = str_replace('"', "", $str);
        $str = str_replace("%", "", $str);
        for($i = 0;$i<=strlen($str);$i++){
            $str = str_replace(" ", "-", $str);
            $str = str_replace("--", "-", $str);
        }

        return $str;
    }
    function throw_ex($e){
        throw new Exception($e);
    }
    function insert($table,$arrParams){
        $column = $values = "";

        foreach ($arrParams as $key => $value) {
            $value = addslashes($value);
            $column .= "$key".",";
            $values .= "'".$value."'".",";
        }
        $column = rtrim($column,",");
        $values = rtrim($values,",");
        $sql = "INSERT INTO ".$table."(".$column.") VALUES (".$values.")";
        mysql_query($sql) or die(mysql_error().$sql);
        $id = mysql_insert_id();
        return $id;
    }
    function update($table,$arrParams){
        $str = "";
        foreach ($arrParams as $key => $value) {
            $str.= $key."= '".$value."',";
        }
        $str = rtrim($str,",");        
        $sql = "UPDATE ".$table." SET ".$str." WHERE id = ".$arrParams['id'];
        mysql_query($sql) or die(mysql_error().$sql);
    }
    function getRelation($table, $select, $column, $parent_id, $type=-1){
        $arr = array();
        $sql = "SELECT $select FROM $table WHERE $column = $parent_id ";        
        $rs = mysql_query($sql);
        while( $row = mysql_fetch_assoc($rs)){
            $arr[] = $row[$select];
        }
        return $arr;
    }
     function getContractService($id){
        $arr = array();
        $sql = "SELECT * FROM contract_service WHERE contract_id = $id ";        
        $rs = mysql_query($sql);
        while( $row = mysql_fetch_assoc($rs)){
            $arr[] = $row;
        }
        return $arr;
    }
     function getContractCon($id){
        $arr = array();
        $sql = "SELECT * FROM contract_convenient WHERE contract_id = $id ";        
        $rs = mysql_query($sql);
        while( $row = mysql_fetch_assoc($rs)){
            $arr[] = $row;
        }
        return $arr;
    }
    function getChild($table, $column, $parent_id, $type=-1, $arrCustom = array()){
        $arr = array();
        $sql = "SELECT * FROM $table WHERE $column = $parent_id ";
        if($type > 0){
            $sql.=" AND object_type = $type";
        }        
        if(!empty($arrCustom)){             
            foreach ($arrCustom as $column => $value) {
                if($value > 0){
                    $sql.= " AND $column = $value ";
                }
            }
        }       
		//echo $sql;
        $rs = mysql_query($sql);
        while( $row = mysql_fetch_assoc($rs)){
            $arr[$row['id']] = $row;
        }
        return $arr;
    }
    function getDoanhThuThang($doanhthu_id, $type_id){
        $arr = array();
        $sql = "SELECT * FROM contract_service_month WHERE doanhthu_id = $doanhthu_id AND type = $type_id ";
        $rs = mysql_query($sql);
        while( $row = mysql_fetch_assoc($rs)){
            $arr[$row['id']] = $row;
        }
        return $arr;
    }
    function getHouseServices($house_id){
        $arr = array();
        $sql = "SELECT * FROM house_services WHERE house_id = $house_id ";        
        $rs = mysql_query($sql);
        while( $row = mysql_fetch_assoc($rs)){            
            $arr[$row['service_id']] = $row;
        }
        return $arr;
    }

    function checkDoanhThu($contract_id){
        $sql = "SELECT id FROM doanh_thu WHERE contract_id = $contract_id ";        
        $rs = mysql_query($sql);
        $row = mysql_num_rows($rs);
        return $row > 0 ? true : false;
    }
    function getListRelation($table, $column_select, $column, $value){
        $arr = array();
        $sql = "SELECT $column_select FROM $table WHERE $column = $value";
        $rs = mysql_query($sql);
        while( $row = mysql_fetch_assoc($rs)){
            $arr[] = $row[$column_select];
        }
        return $arr;
    }
    function getContractByObjectId($object_id, $object_type){
        $sql = "SELECT id FROM contract WHERE object_type = $object_type AND object_id = $object_id AND status = 1";
        $rs = mysql_query($sql);
        $row = mysql_fetch_assoc($rs);
        return $row['id'];
    }
    function getListRoomInfo($room_id, $type){
        $arr = array();
        $sql = "SELECT object_id FROM room_info WHERE room_id = $room_id AND type = $type";
        $rs = mysql_query($sql);
        while( $row = mysql_fetch_assoc($rs)){
            $arr[] = $row['object_id'];
        }
        return $arr;
    }
    function checkNameExistByParentId($table, $column, $value, $name){
        $name = trim($name);
        $sql = "SELECT id FROM $table WHERE name = '$name' AND $column = $value";
        $rs = mysql_query($sql);
        $num = mysql_num_rows($rs);
        return $num > 0 ? false : true;        
    }
    function getNameById($table, $id){
        $sql = "SELECT name FROM $table WHERE id = $id";
        $rs = mysql_query($sql);
        $row = mysql_fetch_assoc($rs);
        return $row['name'];
    }
    function getDetail($table, $id){
        $sql = "SELECT * FROM $table WHERE id = $id";
        $rs = mysql_query($sql);
        $row = mysql_fetch_assoc($rs);
        return $row;
    }
    function getList($table,$offset = -1 , $limit = -1, $arrCustom = array()){
        try{
            $arrResult = array();
            $sql = "SELECT * FROM $table";

            if(!empty($arrCustom)){
                $sql.= " WHERE 1 = 1 ";                
                foreach ($arrCustom as $column => $value) {
                    if($value > 0 || ($value != '' && $value != '-1')){
                        $sql.= " AND $column = '$value' ";
                    }
                }
            }
            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";
            
            $rs = mysql_query($sql) or die(mysql_error());
            while($row = mysql_fetch_assoc($rs)){
               $arrResult['data'][$row['id']] = $row;
            }
            $arrResult['total'] = mysql_num_rows($rs);
            return $arrResult;
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Post','function' => 'getListEstateType' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    

    function getListUserPost($status=-1,$district_id=-1,$type_id=-1,$estate_type_id=-1,$direction_id=-1,$legal_id=-1,$project_type_id=-1,$offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM post WHERE (district_id = $district_id OR $district_id = -1) AND (status = $status OR $status = -1)  ";
            $sql.=" AND (type_id = $type_id OR $type_id = -1) AND (estate_type_id = $estate_type_id OR $estate_type_id = -1) ";
            $sql.=" AND (direction_id = $direction_id OR $direction_id = -1) ";
            $sql.=" AND (legal_id = $legal_id OR $legal_id = -1) ";
            $sql.=" AND (project_type_id = $project_type_id OR $project_type_id = -1) ";
            $sql.=" AND user_id > 1 ORDER BY creation_time DESC ";
            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";
            $rs = mysql_query($sql) or die(mysql_error());
            while($row = mysql_fetch_assoc($rs)){
               $arrResult['data'][] = $row;
            }

            $arrResult['total'] = mysql_num_rows($rs);
            return $arrResult;
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Post','function' => 'getListUserPost' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function getListPost($district_id=-1,$type_id=-1,$estate_type_id=-1,$direction_id=-1,$area_id=-1,$legal_id=-1,$price_id=-1,$project_type_id=-1,$offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM post WHERE (district_id = $district_id OR $district_id = -1) ";
            $sql.=" AND (type_id = $type_id OR $type_id = -1) AND (estate_type_id = $estate_type_id OR $estate_type_id = -1) ";
            $sql.=" AND (direction_id = $direction_id OR $direction_id = -1) AND (area_id = $area_id OR $area_id = -1) ";
            $sql.=" AND (legal_id = $legal_id OR $legal_id = -1) AND (price_id = $price_id OR $price_id = -1) ";
            $sql.=" AND (project_type_id = $project_type_id OR $project_type_id = -1) ";
            $sql.=" AND status = 1 ORDER BY creation_time DESC ";
            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";

            $rs = mysql_query($sql) or die(mysql_error());
            while($row = mysql_fetch_assoc($rs)){
               $arrResult['data'][] = $row;
            }

            $arrResult['total'] = mysql_num_rows($rs);
            return $arrResult;
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Post','function' => 'getListPost' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    
    function logError($arrLog){
        $time = date('d-m-Y H:i:s');
         ////put content to file
        $createdTime = date('Y/m/d');

        // path to log folder
        $logFolder = "../logs/errors/$createdTime";

        // If not existed => create it
        if (!is_dir($logFolder)) mkdir($logFolder, 0777, true);
        // path to log file
        $logFile = $logFolder . "/error_model.log";
        // Put content in it
        $fp   = fopen($logFile, 'a');
        fwrite($fp, json_encode($arrLog)."\r\n");
        fclose($fp);
    }
    function stripUnicode($str) {
        if (!$str)
            return false;
        $unicode = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'd' => 'đ',
            'D' => 'Đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
            '' => '?',
            '-' => '/'
        );
        foreach ($unicode as $khongdau => $codau) {
            $arr = explode("|", $codau);
            $str = str_replace($arr, $khongdau, $str);
        }
        return $str;
    }

    function phantrang($page, $page_show, $total_page, $link) {
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
        echo "<div id='thanhphantrang'>";
        if ($page > 1) {
            ($page == 1) ? $class = " class='selected'" : $class = "";
            echo "<a" . $class . " href=" . $link . "&page=1>Đầu</a>";
        }
        for ($i = $dau; $i < $cuoi; $i++) {
            ($page == $i) ? $class = " class='selected'" : $class = "";
            echo "<a" . $class . " href=" . $link . "&page=$i>$i</a>";
        }
        if ($page < $total_page) {
            ($page == $total_page) ? $class = " class='selected'" : $class = "";
            echo "<a" . $class . " href=" . $link . "&page=$total_page>Cuối</a>";
        }
        echo "</div>";
    }



    public function Login(){

		$email = trim(strip_tags($_POST['email']));
        $password = trim(strip_tags($_POST['password']));
        if (get_magic_quotes_gpc() == false) {
            $email = trim(mysql_real_escape_string($email));
            $password = trim(mysql_real_escape_string($password));
        }
        $password = md5($password);
       echo $sql = "SELECT * FROM users WHERE email='$email' AND password ='$password'";
       //die();
        $user = mysql_query($sql) or die(mysql_error());

        $no_row = mysql_num_rows($user);
        if ($no_row == 1) {//success
            $row = mysql_fetch_assoc($user);
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['level'] = $row['level'];
            $_SESSION['image_url'] = $row['image_url'];
            header("location:index.php");
        }
        else
            header("location:login.php"); //fail
	}


	function phantrang2($page,$page_show,$total_page,$link){
		$dau=1;
		$cuoi=0;
		$dau=$page - floor($page_show/2);
		if($dau<1) $dau=1;
		$cuoi=$dau+$page_show;
		if($cuoi>$total_page)
		{

			$cuoi=$total_page+1;
			$dau=$cuoi-$page_show;
			if($dau<1) $dau=1;
		}
		echo '<div class="pagination pagination__posts"><ul>';
		if($page > 1){
			($page==1) ? $class = " class='active'" : $class="first" ;
			echo "<li ".$class."><a href=".$link."-1.html>First</a></li>"	;
		}
		for($i=$dau; $i<$cuoi; $i++)
		{
			($page==$i) ? $class = " class='active'" : $class="inactive" ;
			echo "<li ".$class."><a href=".$link."-$i.html>$i</a></li>";
		}
		if($page < $total_page) {
			($page==$total_page) ? $class = "class='active'" : $class="last" ;
			echo "<li ".$class."><a href=".$link."-$total_page.html>Last</a></li>";
		}
		echo "</ul></div>";
	}
    function smtpmailer($to, $from, $from_name, $subject, $body) {

		//ini_set('display_errors',1);
        global $error;
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug = 1;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->Username = GUSER;
        $mail->Password = GPWD;
        $mail->SetFrom($from, $from_name);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->CharSet="utf-8";
        $mail->IsHTML(true);
        $mail->AddAddress($to);
		//var_dump($mail->ErrorInfo);
        if(!$mail->Send()) {
            $error = 'Gởi mail bị lỗi : '.$mail->ErrorInfo;
            return false;
        } else {
            $error = 'Thư của bạn đã được gởi đi !';
            return true;
        }
    }
    function checkemailexist($email){
        $sql = "SELECT id FROM newsletter WHERE email = '$email' AND status = 1 ";
        $rs = mysql_query($sql) or die(mysql_error());
        $row = mysql_num_rows($rs);
        if($row==0){
            return "1";
        }else{
            return "0";
        }
    }

    function uploadImages($file_upload){
        $allowedExts = array("jpg", "jpeg", "gif", "png");
        $arrResult = array();
        if(!is_dir("../../upload/images/".date('Y/m/d')."/"))
        mkdir("../../upload/images/".date('Y/m/d')."/",0777,true);

        $url = "../../upload/images/".date('Y/m/d')."/";
            $extension = end(explode(".", $file_upload["name"]));
            if ((($file_upload["type"] == "image/gif") || ($file_upload["type"] == "image/jpeg") || ($file_upload["type"] == "image/png")
            || ($file_upload["type"] == "image/jpeg")) 
            && in_array($extension, $allowedExts))
              {
              if ($file_upload["error"] > 0)
                {
                //echo "Return Code: " . $file_upload["error"] . "<br />";
                }
              else
                {       
            
                if (file_exists($url. $file_upload["name"]))
                  {
                  //echo $file_upload["name"] . " đã tồn tại. "."<br />";       
                  }
                else
                  {

                    $arrPartImage = explode('.', $file_upload["name"]);

                    // Get image extension
                    $imgExt = array_pop($arrPartImage);

                    // Get image not extension
                    $img = preg_replace('/(.*)(_\d+x\d+)/', '$1', implode('.', $arrPartImage));
                    
                    $img = $this->changeTitle($img);
                    $img = $this->countImage($url,$img);                    
                    $name = "{$img}.{$imgExt}";

         
                   
                    if(move_uploaded_file($file_upload["tmp_name"],$url. $name)==true){                                    
                        $hinh = str_replace("../","",$url). $name;
                        $arrReturn['filename'] = $hinh;               
                    }
                  }
                }
                
              }
              
        return $arrReturn;      
   
    }
    function countImage($url,$img){
          $dh  = opendir($url);
            while (false !== ($filename = readdir($dh))) {
                $arrFiles[] = $filename;
            }
            sort($arrFiles);

            unset($arrFiles[0]);
            unset($arrFiles[1]);
            $nameReturn = $img.'-'.(count($arrFiles)+1);
           /* 
           if(!empty($arrFiles)){
            foreach ($arrFiles as $files) {
                $arrTmp = explode(".",$files);
                $arrName[] = $arrTmp[0];
            }
           }

           $nameReturn = $img.'-'.(count($arrFiles)+1);
           
           if(in_array($img, $arrName)){
                for($i = 0; $i<=9;$i++){             
                    if($i==0){
                        $newname =  $img;
                    }else{
                        $newname =  $img.'-'.$i;
                    }
                    if(in_array($newname, $arrName)){
                        $nameReturn = $img.'-'.($i+1);
                        
                    }else{
                        $nameReturn = $nameReturn;
                    }
                }
                
           }else{
             $nameReturn = $img;
           } 
           */          
            return $nameReturn;
    } 


}

?>
