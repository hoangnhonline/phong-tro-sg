<?php
session_start();
$list_url = "../index.php?mod=house&act=list";

require_once "../model/Backend.php";

$model = new Backend;

$id = isset($_POST['id']) ?  (int) $_POST['id'] : 0;

$arrData['name'] = $name = $model->processData($_POST['name']);

$arrData['description'] = $_POST['description'];

$arrData['city_id'] = (int) $_POST['city_id'];

$arrData['district_id'] = (int) $_POST['district_id'];

$arrData['ward_id'] = (int) $_POST['ward_id'];

$arrData['address'] = $_POST['address'];

$arrData['no_room'] = (int) $_POST['no_room'];

$arrData['video_url'] = $_POST['video_url'];

$arrData['image_url'] = isset($_POST['image_url']) ? str_replace('../', '', $_POST['image_url']) : "";

$arrData['longitude'] = $_POST['longitude'];

$arrData['latitude'] = $_POST['latitude'];

$arrData['type'] = 1;

$arrData['user_id'] = $_SESSION['user_id'];
$str_image = isset($_POST['str_image']) ? $_POST['str_image'] : "";

$arrAddon = $_POST['addon'];
$arrServiceId = $_POST['service_id'];
//var_dump($arrServiceId);die;
$table = "house";

if($id > 0) {	
	$arrData['id'] = $id;
	$arrData['updated_at'] = time();
	$model->update($table, $arrData);	
}else{
	$arrData['created_at'] = time();
	$arrData['updated_at'] = time();
	$id = $model->insert($table, $arrData);	
}

$arrTmp = array();
if($str_image){
    $arrTmp = explode(';', $str_image);
}
if(!empty($arrTmp)){
    foreach ($arrTmp as $url) {
        if($url){
            mysql_query("INSERT INTO images VALUES(null,'$url',$id,1,1)") or die(mysql_error());
        }
    }
}
mysql_query("DELETE FROM house_addon WHERE house_id = $id");
if(!empty($arrAddon)){
    foreach($arrAddon as $addon_id){
        mysql_query("INSERT INTO house_addon VALUES($id,$addon_id)");
    }
}
echo "<pre>";
print_r($arrServiceId);
print_r($_POST['services_price']);
mysql_query("DELETE FROM house_services WHERE house_id = $id");
if(!empty($arrServiceId)){
    foreach($arrServiceId as $k => $service_id){
        $price = $_POST['services_price'][$k];
        $price = str_replace(",", "", $price);

        $cal_type = $_POST['service_cal_type'][$k];        

        if($service_id > 0 && $cal_type > 0){
            mysql_query("INSERT INTO house_services VALUES($id, $service_id, $price, $cal_type)") or die(mysql_error());
        }
    }
}
header('location:'.$list_url);
?>