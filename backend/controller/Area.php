<?php
$url = "../index.php?mod=area&act=list";
require_once "../model/Area.php";
$model = new Area;

$area_id = (int) $_POST['area_id'];
$area_name = $model->processData($_POST['area_name']);

if($area_id > 0) {
	$model->updateArea($area_id,$area_name);
	header('location:'.$url);
}else{
	$model->insertArea($area_name);
	header('location:'.$url);
}

?>