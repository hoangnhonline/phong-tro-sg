<?php

$list_url = "../index.php?mod=houserent&act=list";

require_once "../model/Backend.php";

$model = new Backend;

$id = (int) $_POST['id'];

$arrData['name'] = $name = $model->processData($_POST['name']);

$arrData['description'] = $_POST['description'];

$arrData['city_id'] = (int) $_POST['city_id'];

$arrData['district_id'] = (int) $_POST['district_id'];

$arrData['ward_id'] = (int) $_POST['ward_id'];

$arrData['address'] = $_POST['address'];

$arrData['min_contract'] = $_POST['min_contract'];
$arrData['min_deposit'] = $_POST['min_deposit'];
$arrData['area'] = $_POST['area'];
$arrData['price'] = $_POST['price'];

$arrData['no_room'] = (int) $_POST['no_room'];
$arrData['position_type'] = (int) $_POST['position_type'];
$arrData['direction_id'] = (int) $_POST['direction_id'];
$arrData['no_wc'] = (int) $_POST['no_wc'];

$arrData['video_url'] = $_POST['video_url'];

$arrData['image_url'] = str_replace('../', '', $_POST['image_url']);

$arrData['longitude'] = $_POST['longitude'];

$arrData['latitude'] = $_POST['latitude'];

$arrData['type'] = 2;

$str_image = $_POST['str_image'];

$arrAddon = $_POST['addon'];
$arrPurpose = $_POST['purpose_id'];

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
mysql_query("DELETE FROM house_purpose WHERE house_id = $id");
if(!empty($arrPurpose)){
    foreach($arrPurpose as $purpose_id){
        mysql_query("INSERT INTO house_purpose VALUES($id,$purpose_id)");
    }
}
header('location:'.$list_url);
?>