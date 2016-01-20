<?php
//ini_set('display_errors', '1');
class Db {
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
    function getListProject($hot=-1, $district_id=-1, $project_type_id=-1, $offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM project WHERE (district_id = $district_id OR $district_id = -1) ";
            $sql.=" AND (hot = $hot OR $hot = -1)";
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
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Db','function' => 'getListProject' , 'error'=>$ex->getMessage(),'sql'=>$sql);
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
        $sql = "SELECT * FROM users WHERE email='$email' AND password ='$password'";
        $user = mysql_query($sql) or die(mysql_error());

        $row = mysql_num_rows($user);
        if ($row == 1) {//success
            $chitiet = mysql_fetch_assoc($user);
            $_SESSION['user_id'] = $chitiet['user_id'];
            $_SESSION['email'] = $chitiet['email'];
            $_SESSION['full_name'] = $chitiet['full_name'];
            $_SESSION['group'] = $chitiet['group'];
            header("location:index.php");
        }
        else
            header("location:login.php"); //fail
	}

//function Login

    function LayThuVienAnh($HinhMH) {
        $tmp = explode("/", $HinhMH);
        $file = end($tmp);
        $duongdan = implode("/", $tmp);
        $duongdan = str_replace("/" . $file, "", $duongdan);
        $duongdan = str_replace("http://cuacuoncaocapsg.com/", "", $duongdan);

        $dh = opendir($_SERVER['DOCUMENT_ROOT'] . "/" . $duongdan);

        $HinhAnh = "";
        while (($file = readdir($dh)) !== false) {
            $flag = false;
            if ($file !== '.' && $file !== '..') {
                $HinhAnh.=$duongdan . "/" . $file . ";";
            }
        }
        return $HinhAnh;
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


}

?>