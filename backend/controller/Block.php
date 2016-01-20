<?php

$url = "../index.php?mod=block&act=list";

require_once "../model/Block.php";

$model = new Block;

$block_id = (int) $_POST['block_id'];

$block_name = $_POST['block_name'];

$arrText = $_POST['text'];

$arrLink = $_POST['link'];

if($block_id > 0) {
	$model->updateBlock($block_id,$block_name,$arrText,$arrLink);
}else{
	$model->insertBlock($block_name,$arrText,$arrLink);
}

header('location:'.$url);

?>