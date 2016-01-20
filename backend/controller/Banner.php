<?php 

$url = "../index.php?mod=banner&act=list";

require_once "../model/Backend.php";

$model = new Backend;

$id = (int) $_POST['banner_id'];

$name_event = $model->processData($_POST['name_event']);


$name_en = $model->changeTitle($name_event);

$status = $_POST['status']==null ? 1 : 0;

$position_id = (int) $_POST['position_id'];

$description = $_POST['description'];
$link_url = $_POST['link_url'];

$start_time = $_POST['start_time']!='' ? strtotime($_POST['start_time']) : 0;
$end_time = $_POST['end_time']!='' ? strtotime($_POST['end_time']) : 0;

$link_url = $_POST['link_url'];
$type_id = (int) $_POST['type_id'];
if($type_id!=3) $link_url='';
$size_default = $_POST['size_default'];

$content = mysql_escape_string($_POST['content']);

$image_url_upload = $_FILES['image_url_upload'];
if(($image_url_upload['name']!='')){
	$arrRe = $model->uploadImages($image_url_upload);	
	$image_url = $arrRe['filename'];
}else{
	$image_url = str_replace('../', '', $_POST['image_url']);
}

if($id > 0) {	
	
	$model->updateBanner($id,$name_event,$name_en,$start_time,$end_time,$position_id,$description,$content,$image_url,$link_url,$type_id,$size_default,$status);

	header('location:'.$url.'&position_id='.$position_id);

}else{

	$model->insertBanner($name_event,$name_en,$start_time,$end_time,$position_id,$description,$content,$image_url,$link_url,$type_id,$size_default,$status);

	header('location:'.$url.'&position_id='.$position_id);
}
?>
