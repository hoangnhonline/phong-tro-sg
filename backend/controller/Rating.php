<?php 

$url = "../index.php?mod=rating&act=list";

require_once "../model/Rating.php";

$model = new Rating;


$nhaxe_id = (int) $_POST['nhaxe_id'];

$list_email = $model->processData($_POST['list_email']);

$lang = (int) $_POST['lang'];
if($lang > 0 && $nhaxe_id > 0 && $list_email != ''){
	$model->insertRating($nhaxe_id,$lang,$list_email);
}

header('location:'.$url);


?>