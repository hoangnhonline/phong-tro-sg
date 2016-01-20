<?php 

$url = "../index.php?mod=promotion&act=list";

require_once "../model/Promotion.php";

$model = new Promotion;


$promotion_id = (int) $_POST['promotion_id'];

$title_vi = $model->processData($_POST['title_vi']);

$title_en = $model->processData($_POST['title_en']);


$title_safe_vi = $model->changeTitle($title_vi);

$title_safe_en = $model->changeTitle($title_en);


$description_vi = $model->processData($_POST['description_vi']);

$description_en = $model->processData($_POST['description_en']);

$hot = (int) $_POST['hot'];

$content_vi = $_POST['content_vi'];

$content_en = $_POST['content_en'];

$image_url = str_replace("../", "", $model->processData($_POST['image_url']));

if($promotion_id > 0) {	

	$model->updatePromotion($promotion_id,$title_vi,$title_safe_vi,$title_en,$title_safe_en,$description_vi,$description_en,$image_url,$content_vi,$content_en,$hot);

	header('location:'.$url);

}else{

	$model->insertPromotion($title_vi,$title_safe_vi,$title_en,$title_safe_en,$description_vi,$description_en,$image_url,$content_vi,$content_en,$hot);

	header('location:'.$url);

}
?>