<?php
$url = "../index.php?mod=services&act=list";
require_once "../model/Backend.php";
$model = new Backend;

$id = (int) $_POST['id'];

$arrData['name'] = $model->processData($_POST['name']);
$arrData['price'] = $model->processData($_POST['price']);
$arrData['cal_type'] = (int) $_POST['cal_type'];

$arrData['display_order'] = 1;

$table = "services";
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