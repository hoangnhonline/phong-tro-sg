<?php
$url = "../index.php?mod=price&act=list";
require_once "../model/Price.php";
$model = new Price;

$price_id = (int) $_POST['price_id'];
$price_name = $model->processData($_POST['price_name']);

if($price_id > 0) {
	$model->updatePrice($price_id,$price_name);
	header('location:'.$url);
}else{
	$model->insertPrice($price_name);
	header('location:'.$url);
}

?>