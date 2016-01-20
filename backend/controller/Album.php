<?php

$url = "../index.php?mod=album&act=list";

require_once "../model/Album.php";

$model = new Album;

$album_id = (int) $_POST['album_id'];

$album_name = $_POST['album_name'];

$str_image = $_POST['str_image'];

$arrImage = array();

if($str_image){
	$arrImage = explode(";",$str_image);
}

if($album_id > 0) {
	$model->updateAlbum($album_id,$album_name,$arrImage);
}else{
	$model->insertAlbum($album_name,$arrImage);
}

header('location:'.$url);

?>