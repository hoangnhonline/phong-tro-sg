<?php 
$url = "../index.php?mod=time_start&act=list";
require_once "../model/Time.php";
$model = new Time;

$time_id = (int) $_POST['time_id'];
$time_start = $model->processData($_POST['time_start']);

$time_start_safe = $model->changeTitle($time_start);


if($time_id > 0) {	
	$model->updateTime($time_id,$time_start);
	header('location:'.$url);
}else{
	$model->insertTime($time_start);
	header('location:'.$url);
}

?>