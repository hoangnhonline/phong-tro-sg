<?php
$url = "../index.php?mod=articles&act=list";
require_once "../model/Backend.php";
$model = new Backend;

$id = (int) $_POST['id'];

$arrData['name'] = $name = $model->processData($_POST['name']);

$arrData['alias'] = $model->changeTitle($name);

$arrData['description'] = $model->processData($_POST['description']);

$arrData['source'] = $model->processData($_POST['source']);

$arrData['content'] = addslashes($_POST['content']);

$arrData['is_hot'] = (int) $_POST['is_hot'];
$arrData['category_id'] = (int) $_POST['category_id'];

$image_url_upload = $_FILES['image_url_upload'];

if(($image_url_upload['name']!='')){
	$arrRe = $model->uploadImages($image_url_upload);	
	$image_url = $arrRe['filename'];
}else{
	$image_url = str_replace('../', '', $_POST['image_url']);
}

$meta_title = $model->processData($_POST['meta_title']);

$meta_keyword = $model->processData($_POST['meta_keyword']);

$meta_description = $model->processData($_POST['meta_description']);

$arrData['meta_title'] = $meta_title == '' ? $name : $meta_title;
$arrData['meta_keyword'] = $meta_keyword == '' ? $name : $meta_keyword;
$arrData['meta_description'] = $meta_description == '' ? $name : $meta_description;

$arrData['image_url'] = $image_url;

$table = "articles";

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