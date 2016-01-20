<?php
$url = "../index.php?mod=user&act=list";
require_once "../model/Backend.php";
$model = new Backend;

$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

$arrData['name'] = $name = $model->processData($_POST['name']);

$arrData['email'] = $model->processData($_POST['email']);
$arrData['yahoo'] = $model->processData($_POST['yahoo']);
$arrData['skype'] = $model->processData($_POST['skype']);
$arrData['phone'] = $model->processData($_POST['phone']);
$arrData['address'] = $model->processData($_POST['address']);

$image_url_upload = $_FILES['image_url_upload'];

if(($image_url_upload['name']!='')){
	$arrRe = $model->uploadImages($image_url_upload);	
	$image_url = $arrRe['filename'];
}else{
	$image_url = str_replace('../', '', $_POST['image_url']);
}

$arrData['image_url'] = $image_url;

$arrData['level'] = 2;
$arrData['status'] = 1;

$table = "users";
if($id > 0) {	
	$arrData['id'] = $id;
	$arrData['updated_at'] = time();
	$model->update($table, $arrData);	
}else{
	$arrData['created_at'] = time();
	$arrData['updated_at'] = time();
	$pass = $model->processData($_POST['password']);
	$arrData['password'] = md5($pass);
	$id = $model->insert($table, $arrData);	
}
header('location:'.$url);
?>