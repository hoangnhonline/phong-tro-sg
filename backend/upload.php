<?php
function resizeHoang($file,$width,$height,$file_name,$des,$tile=1){
    
    require_once "lib/class.resize.php";
    $re = new resizes;
    $re->load($file);
    $re->resize($width,$height,$tile); // giu kich thuoc that cua hinh
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
    $str = str_replace(".", "", $str);
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
$allowedExts = array("jpg", "jpeg", "gif", "png",'JPG','PNG');

$strHinhAnh = "";

$is_update = isset($_POST['is_update']) ? $_POST['is_update'] : 0;
if(!is_dir("../upload/".date('Y/m/d')."/"))
mkdir("../upload/".date('Y/m/d')."/",0777,true);

$url = "../upload/".date('Y/m/d')."/";
$html ='<div class="row">';
$str_image = "" ;
for($i=0;$i<count($_FILES['images']['name']);$i++){
    
    $extension = end(explode(".", $_FILES["myfile"]["name"][$i]));
    if ((($_FILES["myfile"]["type"][$i] == "image/gif") || ($_FILES["myfile"]["type"][$i] == "image/jpeg") || ($_FILES["myfile"]["type"][$i] == "image/png")
    || ($_FILES["myfile"]["type"][$i] == "image/pjpeg"))    
    && in_array($extension, $allowedExts))
      {
      if ($_FILES["myfile"]["error"][$i] > 0)
        {
        //echo "Return Code: " . $_FILES["myfile"]["error"][$i] . "<br />";
        }
      else
        {       
    
        if (file_exists($url. $_FILES["myfile"]["name"][$i]))
          {
          //echo $_FILES["myfile"]["name"][$i] . " đã tồn tại. "."<br />";       
          }
        else
          {

            $arrPartImage = explode('.', $_FILES["myfile"]["name"][$i]);

            // Get image extension
            $imgExt = array_pop($arrPartImage);

            // Get image not extension
            $img = preg_replace('/(.*)(_\d+x\d+)/', '$1', implode('.', $arrPartImage));
         
            $img = changeTitle($img);
            $img = $img."_".time();
            $name = "{$img}.{$imgExt}";
            $name6 = "{$img}_6.{$imgExt}";
            $name4 = "{$img}_4.{$imgExt}";
            $name2 = "{$img}_2.{$imgExt}";
            $name1 = "{$img}_690x460.{$imgExt}";

            if(move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$url.$name)==true){
        
                    resizeHoang(
                        $url.$name,
                        -1,-1,
                        $name,
                        $url
                    );
                    resizeHoang(
                        $url.$name,
                        690,460,
                        $name1,
                        $url,
                        -1
                    );
                    resizeHoang(
                        $url.$name,
                        -1,-1,
                        $name2,
                        $url,
                        2
                    );
                    resizeHoang(
                        $url.$name,
                        -1,-1,
                        $name4,
                        $url,
                        4
                    );                          
                    
            }   
            $url_image_tmp = $url.$name4;
            $url_image = str_replace('../', '', $url).$name;

          }
          }
    }
    $checked = ($i == 0 && $is_update!=1) ? "checked='checked'" : ""; 
    $html.='<div class="col-md-2 image_upload"  style="border: 1px solid #CCC; padding: 10px;margin-right:2px;min-height:240px"><img src="'.$url_image_tmp.'" width="150"><br />
    <p style="width:70%;float:left;margin-top:10px"><input type="radio" '.$checked.' name="image_url" value="'.$url_image.'" /> Ảnh đại diện</p>
    <p style="width:30%;float:left;text-align:right;margin-top:10px"><span style="cursor:pointer" data-value="'.$url_image.'">Xóa</span></p>
    </div>' ;
    $str_image.=$url_image.";";
}
$html.="</div>";

$arrReturn['html'] = $html;
$arrReturn['str_image'] = '<input type="hidden" value="'.$str_image.'" name="str_image" id="str_image" />';

echo json_encode($arrReturn);
?>