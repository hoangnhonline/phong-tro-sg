<?php
session_start();
$user_id = $_SESSION['user_id'];

require_once "../model/Backend.php";

$model = new Backend;

$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

$object_type = (int) $_POST['object_type'];
if($object_type == 1){
    $list_url = "../index.php?mod=room&act=list";
}elseif($object_type == 2){
    $list_url = "../index.php?mod=houserent&act=list";
}else{
    $list_url = "../index.php?mod=housesell&act=list";
}

$arrData['user_id'] = $user_id;
$arrData['name'] = $name = $model->processData($_POST['name']);
$arrData['alias'] = $model->changeTitle($name);

$arrData['description'] = $_POST['description'];
$arrData['area'] = $_POST['area'];

$arrData['city_id'] = (int) $_POST['city_id'];

$arrData['district_id'] = (int) $_POST['district_id'];

$arrData['ward_id'] = (int) $_POST['ward_id'];
$arrData['type_id'] = (int) $_POST['type_id'];
$arrData['deposit'] = str_replace(",", "", $_POST['deposit']);
if($object_type == 1){
    $arrData['floor'] = (int) $_POST['floor'];
    $arrData['house_id'] = (int) $_POST['house_id'];
    $arrData['max_person'] = (int) $_POST['max_person'];
    $arrData['price_1'] = str_replace(",", "", $_POST['price_1']);
    if($_POST['price_3'] == "" || $_POST['price_3']==0){
        $arrData['price_3'] = $arrData['price_1'];
    }else{
        $arrData['price_3'] = str_replace(",", "", $_POST['price_3']);
    }
    if($_POST['price_6'] == "" || $_POST['price_6']==0){
        $arrData['price_6'] = $arrData['price_6'];
    }else{
        $arrData['price_6'] = str_replace(",", "", $_POST['price_6']);
    }   
    $arrData['object_type'] = 1;
    $arrService = $_POST['services'];
    $arrConvenient = $_POST['convenient'];
 
}
if($object_type == 2 || $object_type == 3){
    $arrData['type_id'] = (int) $_POST['type_id']; 
    if($object_type == 2){
        $arrPurpose = $_POST['purpose_id'];    
        $arrData['object_type'] = 2;
        $arrData['price'] = str_replace(",", "", $_POST['price']);
    }
    $arrData['address'] = $_POST['address'];
    $arrData['min_contract'] = $_POST['min_contract'];    
    $arrData['no_room'] = (int) $_POST['no_room'];
    $arrData['position_type'] = (int) $_POST['position_type'];
    $arrData['direction_id'] = (int) $_POST['direction_id'];
    $arrData['no_wc'] = (int) $_POST['no_wc'];
    
    
    $arrData['longitude'] = $_POST['longitude'];
    $arrData['latitude'] = $_POST['latitude'];
    
    if($object_type == 3){

        $arrData['object_type'] = 3;
        $arrData['payment'] = $_POST['payment'];
        $arrData['legal'] = $_POST['legal']; 
        $arrData['price_sell'] = $_POST['price_sell']; 
        $arrData['street'] = $_POST['street']; 
    }
    $arrData['project_name'] = $_POST['project_name']; 
}
$arrData['video_url'] = $_POST['video_url'];
$arrData['image_url'] = str_replace('../', '', $_POST['image_url']);

$str_image = $_POST['str_image'];

$arrAddon = $_POST['addon'];
$arrData['price_id'] = (int) $_POST['price_id'];

$meta_title = $model->processData($_POST['meta_title']);

$meta_keyword = $model->processData($_POST['meta_keyword']);

$meta_description = $model->processData($_POST['meta_description']);

$arrData['meta_title'] = $meta_title == '' ? $name : $meta_title;
$arrData['meta_keyword'] = $meta_keyword == '' ? $name : $meta_keyword;
$arrData['meta_description'] = $meta_description == '' ? $name : $meta_description;

$table = "objects";

if($id > 0) {
	$arrData['id'] = $id;
	$arrData['updated_at'] = time();    
    $arrData['updated_by'] = $user_id;
	$model->update($table, $arrData);	
}else{
	$arrData['created_at'] = time();
	$arrData['updated_at'] = time();
    $arrData['updated_by'] = $user_id;
    $arrData['created_by'] = $user_id;
	$id = $model->insert($table, $arrData);	
}
mysql_query("DELETE FROM objects_info WHERE object_id = $id AND type = 1");
if(!empty($arrAddon)){
    foreach($arrAddon as $addon_id){
        mysql_query("INSERT INTO objects_info VALUES($id, $addon_id, 1)") or die(mysql_error());
    }
}
mysql_query("DELETE FROM objects_info WHERE object_id = $id AND type = 2");
if(!empty($arrConvenient)){
    foreach($arrConvenient as $convenient_id){
        mysql_query("INSERT INTO objects_info VALUES($id, $convenient_id, 2)") or die(mysql_error());
    }
}

$arrTmp = array();
if($str_image){
    $arrTmp = explode(';', $str_image);
}
if($object_type == 1){
    $type_images = 2;
}elseif ($object_type == 2) {
    $type_images = 3;
}elseif ($object_type == 3) {
    $type_images = 4;
}
if(!empty($arrTmp)){
    foreach ($arrTmp as $url) {
        if($url){
            mysql_query("INSERT INTO images VALUES(null,'$url', $id, $type_images, 1)") or die(mysql_error());
        }
    }
}
if($object_type == 2){
    mysql_query("DELETE FROM house_purpose WHERE house_id = $id");
    if(!empty($arrPurpose)){
        foreach($arrPurpose as $purpose_id){
            mysql_query("INSERT INTO house_purpose VALUES($id,$purpose_id)");
        }
    }
}
header('location:'.$list_url);
?>