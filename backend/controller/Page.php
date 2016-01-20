<?php 

$url = "../index.php?mod=page&act=list";

require_once "../model/Backend.php";

$model = new Backend;
$id = (int) $_POST['id'];

$arrData['page_name'] = $page_name = $model->processData($_POST['page_name']);

$arrData['page_alias'] = $page_alias = $model->changeTitle($page_name);

$arrData['description'] = $description = addslashes($_POST['description']);

$arrData['content'] = $content = addslashes($_POST['content']);

$image_url_upload = $_FILES['image_url_upload'];
if(($image_url_upload['name']!='')){
	$arrRe = $model->uploadImages($image_url_upload);	
	$image_url = $arrRe['filename'];
}else{
	$image_url = str_replace('../', '', $_POST['image_url']);
}
$arrData['image_url'] = $image_url;
$meta_title = $model->processData($_POST['meta_title']);
$meta_keyword = $model->processData($_POST['meta_keyword']);
$meta_description = $model->processData($_POST['meta_description']);

if($meta_title=='') $meta_title = $page_name;
if($meta_keyword=='') $meta_keyword = $page_name;
if($meta_description=='') $meta_description = $page_name;

$arrData['meta_title'] = $meta_title;
$arrData['meta_keyword'] = $meta_keyword;
$arrData['meta_description'] = $meta_description;
$arrData['status'] = 1;
$arrData['updated_at'] = time();

$table = "pages";
if($id > 0) {	
	$arrData['id'] = $id;
	$model->update($table, $arrData);	
}else{
	$arrData['created_at'] = time();	
	$model->insert($table, $arrData);	
}
header('location:'.$url);

?>