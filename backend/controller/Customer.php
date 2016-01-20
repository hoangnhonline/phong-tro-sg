<?php
$url = "../index.php?mod=customers&act=list";
require_once "../model/Backend.php";
$model = new Backend;

$id = (int) $_POST['id'];

$arrData['name'] = $name = $model->processData($_POST['name']);

$arrData['phone'] = $model->processData($_POST['phone']);
$arrData['email'] = $model->processData($_POST['email']);
$arrData['cmnd'] = $model->processData($_POST['cmnd']);
$arrData['birthday'] = $model->processData($_POST['birthday']);

$arrData['address'] = $model->processData($_POST['address']);

$arrData['user_id'] = (int) $_POST['user_id'];
$arrData['gender'] = (int) $_POST['gender'];
$arrData['status'] = 1;

$table = "customers";
if($arrData['name']){
	if($id > 0) {	
		$arrData['id'] = $id;
		$arrData['updated_at'] = time();
		$model->update($table, $arrData);	
	}else{
		$arrData['created_at'] = time();
		$arrData['updated_at'] = time();
		$model->insert($table, $arrData);	
	}
}
header('location:'.$url);
?>