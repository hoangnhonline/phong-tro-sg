<?php
class Home{

    function __construct() {
        if($_SERVER['SERVER_NAME']=='nhadat.dev'){
            mysql_connect('localhost', 'root', '') or die("Can't connect to server");
               mysql_select_db('nhadat') or die("Can't connect database");
        }else{
        mysql_connect('localhost', '', '') or die("Can't connect to server");
            mysql_select_db('') or die("Can't connect database"); 
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
    function throw_ex($e){
        throw new Exception($e);
    }
    function dangky($arrData){
        $full_name = $arrData['full_name'];
        $phone = $arrData['phone'];
        $email = $arrData['email'];
        $password = md5($arrData['password']);
        $description = $arrData['description'];
        $image_url = $arrData['image_url'];
        $date = time();
        $sql = "INSERT INTO users VALUES (NULL,'$email','$password',2,'$full_name','$phone','$image_url','$description',$date,$date,2)";
        $rs = mysql_query($sql) or die(mysql_error());
    }
    function checkemailexist($email){
        $sql = "SELECT user_id FROM users WHERE email = '$email' AND status > 0 ";
        $rs = mysql_query($sql) or die(mysql_error());
        $row = mysql_num_rows($rs);
        if($row==0){
            return "1";
        }else{
            return "0";
        }
    }
    function getListText(){
        $arrResult = array();
        $sql = "SELECT * FROM text";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arrResult[$row['id']] = $row['text'];
        }
        return $arrResult;
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
    function getListImageByAlbum($album_id){
        $arrResult = array();
        $sql = "SELECT * FROM imagesalbum WHERE album_id = $album_id";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arrResult[] = $row;
        }
        return $arrResult;
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
    function insertPost($user_id, $post_title,$post_alias,$image_url,$content,$address,$price,$cal_type,$total_area,$contact,$phone,$type_id,$estate_type_id,$city_id,$district_id,$project_type_id,$direction_id,$area_id,$legal_id,$price_id,$horizontal,$lengths,$road,$floors,$bedroom,$video_url,$longt,$latt,$str_image,$arrAddon) {
        try{
            $arrTmp = array();
            if($str_image){
                $arrTmp = explode(';', $str_image);
            }
            $time = time();
            $sql = "INSERT INTO post VALUES
                            (NULL,'$post_title','$post_alias','$image_url','$content','$address','$price',
                                $cal_type,'$total_area','$contact','$phone',$type_id,$estate_type_id,$city_id,
                                $district_id,$project_type_id,$direction_id,$area_id,$legal_id,$price_id,'$horizontal',
                                '$lengths','$road','$floors','$bedroom',$time,$time,2,$user_id,'$post_title','$post_title','$post_title',0,'$video_url','$longt','$latt')";
            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());
            $post_id = mysql_insert_id();
            if(!empty($arrTmp)){
                foreach ($arrTmp as $url) {
                    if($url){
                        $url_1  =  str_replace('.', '_690x460.', $url);
                        $url_2  =  str_replace('.', '_2.', $url);
                        $url_3  =  str_replace('.', '_4.', $url);
                        mysql_query("INSERT INTO images VALUES(null,'$url','$url_1','$url_2','$url_3',$post_id,1,1)") or die(mysql_error());
                    }
                }
            }
            if(!empty($arrAddon)){
                foreach($arrAddon as $addon_id){
                    mysql_query("INSERT INTO post_addon VALUES($post_id,$addon_id)");
                }
            }
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Home','function' => 'insertPost' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function updatePost($post_id,$post_title,$post_alias,$image_url,$content,$address,$price,$cal_type,$total_area,$contact,$phone,$type_id,$estate_type_id,$city_id,$district_id,$project_type_id,$direction_id,$area_id,$legal_id,$price_id,$horizontal,$lengths,$road,$floors,$bedroom,$video_url,$longt,$latt,$str_image,$arrAddon) {
        try{
            $arrTmp = array();
            if($str_image){
                $arrTmp = explode(';', $str_image);
            }
            $time = time();
            $sql = "UPDATE post
                    SET post_title = '$post_title',post_alias='$post_alias',image_url = '$image_url',
                        address = '$address',content = '$content',price ='$price',
                        cal_type = $cal_type,total_area = '$total_area',contact='$contact',
                        phone = '$phone',type_id = $type_id,estate_type_id = $estate_type_id,
                        city_id = $city_id,district_id = $district_id,area_id = $area_id,
                        project_type_id = $project_type_id,direction_id = $direction_id,
                        legal_id = $legal_id,price_id = $price_id,horizontal = '$horizontal',
                        lengths = '$lengths',road = '$road', floors = '$floors', bedroom = '$bedroom',
                        update_time = $time, title = '$post_title',video_url='$video_url',longt = '$longt',latt = '$latt',
                        meta_k = '$post_title',meta_d = '$post_title' WHERE post_id = $post_id";
            mysql_query($sql);
            if(!empty($arrTmp)){
                foreach ($arrTmp as $url) {
                    if($url){
                        $url_1  =  str_replace('.', '_690x460.', $url);
                        $url_2  =  str_replace('.', '_2.', $url);
                        $url_3  =  str_replace('.', '_4.', $url);
                        mysql_query("INSERT INTO images VALUES(null,'$url','$url_1','$url_2','$url_3',$post_id,1,1)") or die(mysql_error());
                    }
                }
            }
            if(!empty($arrAddon)){
                mysql_query("DELETE FROM post_addon WHERE post_id = $post_id");
                foreach($arrAddon as $addon_id){
                    mysql_query("INSERT INTO post_addon VALUES($post_id,$addon_id)");
                }
            }else{
                mysql_query("DELETE FROM post_addon WHERE post_id = $post_id");
            }
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Home','function' => 'updatePost' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function checklogin($email,$password){
        $row = array();
        $password = md5($password);
        $sql = "SELECT * FROM users WHERE email = '$email' and password='$password' AND status > 0 ";
        $rs = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_assoc($rs);
        return $row;
    }
    function getDetailUser($user_id) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM users WHERE user_id = $user_id ";
            $rs = mysql_query($sql) or die(mysql_error());
            $row = mysql_fetch_assoc($rs);
            $arrResult['data'] = $row;
            $arrResult['post']['daduyet'] = $arrResult['post']['chuaduyet'] = $arrResult['post']['khongduyet'] = array();
            $sql = "SELECT * FROM post WHERE user_id = $user_id AND status > 0 ";
            $rs = mysql_query($sql) or die(mysql_error());
            while($row = mysql_fetch_assoc($rs)){
                if($row['status']==1){
                    $arrResult['post']['daduyet'][$row['post_id']] = $row;
                }
                if($row['status']==2){
                    $arrResult['post']['chuaduyet'][$row['post_id']] = $row;
                }
                if($row['status']==3){
                    $arrResult['post']['khongduyet'][$row['post_id']] = $row;
                }
            }

            $arrResult['total'] = mysql_num_rows($rs);
            return $arrResult;
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Home','function' => 'getDetailUser' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function getListEstateType($offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM estate_type WHERE status = 1 ";

            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";

            $rs = mysql_query($sql) or die(mysql_error());
            while($row = mysql_fetch_assoc($rs)){
               $arrResult['data'][$row['estate_type_id']] = $row;
            }
            $arrResult['total'] = mysql_num_rows($rs);
            return $arrResult;
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Post','function' => 'getListEstateType' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function getListProjectType($offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM project_type WHERE status = 1 ";

            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";

            $rs = mysql_query($sql) or die(mysql_error());
            while($row = mysql_fetch_assoc($rs)){
               $arrResult['data'][$row['project_type_id']] = $row;
            }
            $arrResult['total'] = mysql_num_rows($rs);
            return $arrResult;
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Post','function' => 'getListEstateType' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function getListLegal($offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM legal WHERE status = 1 ";

            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";

            $rs = mysql_query($sql) or die(mysql_error());
            while($row = mysql_fetch_assoc($rs)){
               $arrResult['data'][$row['legal_id']] = $row;
            }
            $arrResult['total'] = mysql_num_rows($rs);
            return $arrResult;
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Post','function' => 'getListEstateType' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function getListPrice($offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM price WHERE status = 1 ";

            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";

            $rs = mysql_query($sql) or die(mysql_error());
            while($row = mysql_fetch_assoc($rs)){
               $arrResult['data'][$row['price_id']] = $row;
            }
            $arrResult['total'] = mysql_num_rows($rs);
            return $arrResult;
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Post','function' => 'getListEstateType' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function getListAddon($offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM addon WHERE status = 1 ";

            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";

            $rs = mysql_query($sql) or die(mysql_error());
            while($row = mysql_fetch_assoc($rs)){
               $arrResult['data'][$row['addon_id']] = $row;
            }
            $arrResult['total'] = mysql_num_rows($rs);
            return $arrResult;
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Post','function' => 'getListEstateType' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function getListArea($offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM area WHERE status = 1 ";

            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";

            $rs = mysql_query($sql) or die(mysql_error());
            while($row = mysql_fetch_assoc($rs)){
               $arrResult['data'][$row['area_id']] = $row;
            }
            $arrResult['total'] = mysql_num_rows($rs);
            return $arrResult;
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Post','function' => 'getListEstateType' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function getListDirection($offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM direction WHERE status = 1 ";

            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";

            $rs = mysql_query($sql) or die(mysql_error());
            while($row = mysql_fetch_assoc($rs)){
               $arrResult['data'][$row['direction_id']] = $row;
            }
            $arrResult['total'] = mysql_num_rows($rs);
            return $arrResult;
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Post','function' => 'getListEstateType' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }

    function getListDistrict($city_id=-1, $offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM district WHERE status = 1 AND (city_id = $city_id OR $city_id = -1 ) ";

            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";

            $rs = mysql_query($sql) or die(mysql_error());
            while($row = mysql_fetch_assoc($rs)){
               $arrResult['data'][$row['district_id']] = $row;
            }
            $arrResult['total'] = mysql_num_rows($rs);
            return $arrResult;
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Post','function' => 'getListEstateType' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function getListPostHot($offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM post WHERE hot = 1 ";
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
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Home','function' => 'getListPostHost' , 'error'=>$ex->getMessage(),'sql'=>$sql);
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
    function getListArticle($cate_id=-1,$offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM articles WHERE (category_id = $cate_id OR $cate_id = -1) ";
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
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Home','function' => 'getListArticle' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function getListProject($project_type_id=-1,$offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM project WHERE (project_type_id = $project_type_id OR $project_type_id = -1) ";
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
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Home','function' => 'getListProject' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function getDetailEstateTypeByID($estate_type_id){
        $sql = "SELECT * FROM estate_type WHERE estate_type_id = $estate_type_id";
        $rs = mysql_query($sql);
        $row = mysql_fetch_assoc($rs);
        return $row;
    }
    function getDetailProjectTypeByID($project_type_id){
        $sql = "SELECT * FROM project_type WHERE project_type_id = $project_type_id";
        $rs = mysql_query($sql);
        $row = mysql_fetch_assoc($rs);
        return $row;
    }
    function getEstateIDByAlias($alias){
        $sql = "SELECT * FROM estate_type WHERE estate_alias = '$alias'";
        $rs = mysql_query($sql);
        $row = mysql_fetch_assoc($rs);
        return $row['estate_type_id'];
    }
    function getProjectTypeIDByAlias($alias){
        $sql = "SELECT * FROM project_type WHERE project_type_alias = '$alias'";
        $rs = mysql_query($sql);
        $row = mysql_fetch_assoc($rs);
        return $row['project_type_id'];
    }
    function getDetailArticle($article_id) {
        $arrReturn = array();
        $str_image = "";
        $sql = "SELECT * FROM articles WHERE article_id = $article_id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row =mysql_fetch_assoc($rs);
        $arrReturn['data']= $row;

        $sql = "SELECT * FROM images WHERE object_id = $article_id AND object_type = 2";
        $rs = mysql_query($sql) or die(mysql_error());
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn['images'][] = $row;
            $str_image.= $row['url'].";";
        }
        $arrReturn['str_image'] = $str_image;
        return $arrReturn;
    }
    function getDetailProject($project_id) {
        $arrReturn = array();
        $str_image = "";
        $sql = "SELECT * FROM project WHERE project_id = $project_id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row =mysql_fetch_assoc($rs);
        $arrReturn['data']= $row;

        $sql = "SELECT * FROM images WHERE object_id = $project_id AND object_type = 3";
        $rs = mysql_query($sql) or die(mysql_error());
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn['images'][] = $row;
            $str_image.= $row['url'].";";
        }
        $arrReturn['str_image'] = $str_image;
        return $arrReturn;
    }
    function getListProjectHot() {
        $arrReturn = array();
        $sql = "SELECT * FROM project WHERE hot = 1 ORDER BY update_time DESC LIMIT 0,5";
        $rs = mysql_query($sql) or die(mysql_error());
        while($row =mysql_fetch_assoc($rs)){
            $arrReturn[]= $row;
        }
        return $arrReturn;
    }
    function getListArticlesHot() {
        $arrReturn = array();
        $sql = "SELECT * FROM articles WHERE status = 1 ORDER BY update_time DESC LIMIT 0,2";
        $rs = mysql_query($sql) or die(mysql_error());
        while($row =mysql_fetch_assoc($rs)){
            $arrReturn[]= $row;
        }
        return $arrReturn;
    }
    function getDetailPost($id){
        $arrReturn = array();
        $str_image = "";
        $sql = "SELECT * FROM post WHERE post_id = $id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row =mysql_fetch_assoc($rs);
        $arrReturn['data']= $row;

        $sql = "SELECT * FROM images WHERE object_id = $id AND object_type = 1";
        $rs = mysql_query($sql) or die(mysql_error());
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn['images'][] = $row;
            $str_image.= $row['url'].";";
        }
        $arrReturn['str_image'] = $str_image;

         $sql = "SELECT * FROM post_addon WHERE post_id = $id";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn['addon'][] = $row['addon_id'];
        }
        return $arrReturn;
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
    function getRouteNameByID($id,$lang="vi") {
        $sql = "SELECT route_name_vi,route_name_en FROM route WHERE route_id = $id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_assoc($rs);
        return $row['route_name_'.$lang];
    }
    function countReviewByEmailID($email_id) {
        $sql = "SELECT count(detail_id) as total FROM rating_detail WHERE email_id = $email_id AND status = 1";
        $rs = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_assoc($rs);
        return $row['total'];
    }
    function countUsefulByEmailID($email_id) {
        $sql = "SELECT count(detail_id) as total FROM rating_detail WHERE email_id = $email_id AND status = 1 AND is_helpful = 1";
        $rs = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_assoc($rs);
        return $row['total'];
    }
    function getListMoiGioi($offset,$limit){
        $arrReturn = array();
        $sql = "SELECT * FROM users WHERE users.group = 2 AND status = 1 LIMIT $offset,$limit";
        $rs = mysql_query($sql) or die(mysql_error().$sql);
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn[$row['user_id']] = $row;
        }
        return $arrReturn;
    }
    function getListBlockFooter($offset,$limit){
        $arrReturn = array();
        $sql = "SELECT * FROM block WHERE status =1 LIMIT $offset,$limit";
        $rs = mysql_query($sql) or die(mysql_error());
        while($row = mysql_fetch_assoc($rs)){
            $block_id = $row['block_id'];
            $block_name = $row['block_name'];
            $arrReturn[$block_id]['name'] = $block_name;
            $sql1 = "SELECT * FROM link WHERE block_id = $block_id";
            $rs1 = mysql_query($sql1) or die(mysql_error());
            while($row1 = mysql_fetch_assoc($rs1)){
                $arrReturn[$block_id]['link'][] = $row1;
            }
        }
        return $arrReturn;
    }

    function getListNhaxeHaveTicket($vstart,$vend,$dstart){
        $arrResult = array();
        try{
            $sql = "SELECT nhaxe_id FROM ticket WHERE status > 0 AND tinh_id_start = $vstart AND tinh_id_end = $vend
            AND date_start = $dstart GROUP BY nhaxe_id "  ;
            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());

            while($row = mysql_fetch_assoc($rs)){
                $nhaxe_id = $row['nhaxe_id'];
                $arrResult[$nhaxe_id] = $this->getDetailNhaxe2($nhaxe_id);
            }

        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Nhaxe','function' => 'getListNhaxeHaveTicket' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }

        return $arrResult;
    }
    function paginationex($page,$page_show,$total_page,$link,$option=1){
        $dau=1;
        $cuoi=0;
        $dau=$page - floor($page_show/2);
        $p = "";
        if($dau<1) $dau=1;
        $cuoi=$dau+$page_show;
        if($cuoi>$total_page)
        {

            $cuoi=$total_page+1;
            $dau=$cuoi-$page_show;
            if($dau<1) $dau=1;
        }
        echo '<ul class="pagination">';
        if($page > 1){
            $p = $option == 1 ? ".html" :"";
            $class = ($page==1) ? " class='active'" : "first" ;
            echo "<li ".$class."><a  href=".$link.$p.">«</a></li>"    ;
        }
        for($i=$dau; $i<$cuoi; $i++)
        {
            $p = $option == 1 ? "_$i.html" :"&page=$i";
            ($page==$i) ? $class = " class='active'" : $class="inactive" ;
            echo "<li ".$class."><a  href=".$link.$p.">$i</a></li>";
        }
        if($page < $total_page) {
            $p = $option == 1 ? "_$total_page.html" :"&page=$total_page";
            $class = ($page==$total_page) ?  "class='active'" : "last" ;
            echo "<li ".$class."><a  href=".$link.$p.">»</a></li>";
        }
        echo "</ul>";
    }
}
?>