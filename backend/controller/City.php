<?php
$url = "../index.php?mod=city&act=list";
require_once "../model/Backend.php";
$model = new Backend;

$id = (int) $_POST['id'];

$arrData['name'] = $name = $model->processData($_POST['name']);
$arrData['alias'] = $model->changeTitle($name);

$arrData['display_order'] = 1;

$table = "city";
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