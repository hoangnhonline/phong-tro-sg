<?php

function resizeHoang($file,$width,$height,$file_name,$des){
	require_once "class.resize.php";
	$re = new resizes;
	$re->load($file);
	$re->resize($width,$height);
	$re->save($des.$file_name);
}
function changeTitle($str) {
    $str = stripUnicode($str);
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
    $str = str_replace("%", "", $str);
    return $str;
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

$mod == $_POST['mod'];
if($mod=="banner"){
    $width_1 = (int) $_POST['width'];
    $height_1 = (int) $_POST['height'];
}else{
    $width_1 = 700; $height_1 = 450;
}

$width_2 = 166; $height_2 = 107;
$width_3 = 470; $height_3 = 300;

$allowedExts = array("jpg", "jpeg", "gif", "png");
$arrRes['text'] = "<div><ul>";
$strHinhAnh = "";

if(!is_dir("../../upload/".date('Y')."/".date('m')."/".date('d')."/".time().'/'))
mkdir("../../upload/".date('Y')."/".date('m')."/".date('d')."/".time().'/',0777,true);

$url = "../../upload/".date('Y')."/".date('m')."/".date('d')."/".time().'/';

for($i=0;$i<count($_FILES['images']['name']);$i++){
	$extension = end(explode(".", $_FILES["images"]["name"][$i]));
	if ((($_FILES["images"]["type"][$i] == "image/gif") || ($_FILES["images"]["type"][$i] == "image/jpeg") || ($_FILES["images"]["type"][$i] == "image/png")
	|| ($_FILES["images"]["type"][$i] == "image/jpeg"))	
	&& in_array($extension, $allowedExts))
	  {
	  if ($_FILES["images"]["error"][$i] > 0)
		{
		//echo "Return Code: " . $_FILES["images"]["error"][$i] . "<br />";
		}
	  else
		{		
	
		if (file_exists($url. $_FILES["images"]["name"][$i]))
		  {
		  //echo $_FILES["images"]["name"][$i] . " đã tồn tại. "."<br />";		 
		  }
		else
		  {

		  	$arrPartImage = explode('.', $_FILES["images"]["name"][$i]);

            // Get image extension
            $imgExt = array_pop($arrPartImage);

            // Get image not extension
            $img = preg_replace('/(.*)(_\d+x\d+)/', '$1', implode('.', $arrPartImage));
            
            $img = changeTitle($img);
            $img = $img."_".time();
            $name = "{$img}.{$imgExt}";

            $name_1 = "{$img}_{$width_1}x{$height_1}.{$imgExt}";
            if($mod!='banner'){
                $name_2 = "{$img}_{$width_2}x{$height_2}.{$imgExt}";
                $name_3 = "{$img}_{$width_3}x{$height_3}.{$imgExt}";
            }else{
                $name = $name_1; 
            }

            if(move_uploaded_file($_FILES["images"]["tmp_name"][$i],$url. $name)==true){
                if($mod!='banner'){
                	resizeHoang(
    					$url.$name,
    					$width_1,$height_1,
    					$name_1,
    					$url
    				);
    				resizeHoang(
    					$url.$name,
    					$width_2,$height_2,
    					$name_2,
    					$url
    				);
    				resizeHoang(
    					$url.$name,
    					$width_3,$height_3,
    					$name_3,
    					$url
    				);
                }
				$count++;
				$strHinhAnh.= str_replace("../","",$url). $name_1.";";
                $name_2 = $mod=="banner" ? $name_1 : $name_2;
				$arrRes['text'] .="<li style='float:left;display:inline;margin-right:10px;text-align:center'>				
					<img src='"."../".str_replace("../","",$url). $name_2."' width='166' /><br />				
					</li>";
            }
		  }
		}
		
	  }
	  
	  $arrRes['text'].="</ul></div>";
}

if($count>0){
	$strHinhAnh= substr($strHinhAnh,0,-1);
	$arrRes['thongbao'] = "Upload thành công $count images";
	$arrRes['str_hinhanh']="<input type='hidden' id='str_hinh_anh' name='str_hinh_anh' value='".$strHinhAnh."'>";
}else{
	$arrRes['thongbao'] = "Có lỗi xảy ra ! Không upload được file .";
}
echo json_encode($arrRes);
?>