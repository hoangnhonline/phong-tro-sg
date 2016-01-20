<?php
$url = "../index.php?mod=convenient&act=list";
require_once "../model/Backend.php";
$model = new Backend;

$id = (int) $_POST['id'];

$arrData['name'] = $name = $model->processData($_POST['name']);

$arrData['price'] = str_replace(",", "", $model->processData($_POST['price']));

$arrData['description'] = $model->processData($_POST['description']);

$arrData['display_order'] = 1;

$image_url_upload = $_FILES['image_url_upload'];

if(($image_url_upload['name']!='')){
	$arrRe = $model->uploadImages($image_url_upload);	
	$image_url = $arrRe['filename'];
}else{
	$image_url = str_replace('../', '', $_POST['image_url']);
}

$arrData['image_url'] = $image_url;

$table = "convenient";
if($id > 0) {	
	$arrData['id'] = $id;
	$arrData['updated_at'] = time();
	$model->update($table, $arrData);	
}else{
	$arrData['created_at'] = time();
	$arrData['updated_at'] = time();
	$model->insert($table, $arrData);	
}
header('location:'.$url);
?>