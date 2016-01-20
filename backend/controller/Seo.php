<?php
$url = "../index.php?mod=seo&act=list";
require_once "../model/Backend.php";
$model = new Backend;

$id = (int) $_POST['id'];

$arrData['meta_title'] = $name = $model->processData($_POST['meta_title']);
$arrData['meta_keyword'] = $name = $model->processData($_POST['meta_keyword']);

$arrData['meta_description'] = $model->processData($_POST['meta_description']);


$table = "seo";
if($id > 0) {	
	$arrData['id'] = $id;
	
	$model->update($table, $arrData);	
}else{
	
	$model->insert($table, $arrData);	
}
header('location:'.$url);
?>