<?php
$url = "../index.php?mod=dishes&act=list";

require_once "../model/Dishes.php";

$model = new Dishes;

$id = (int) $_POST['id'];

$name = $model->processData($_POST['name']);

$name_en = $model->processData($_POST['name_en']);

$price = $model->processData($_POST['price']);

$description = $_POST['description'];

$components = $_POST['components'];

$type = (int) $_POST['type'];

$image_url = str_replace("../", "", $model->processData($_POST['image_url']));

if($id > 0) {	

	$model->updateDishes($id,$name,$name_en,$price,$description,$components,$type,$image_url);

	header('location:'.$url);

}else{

	$model->insertDishes($name,$name_en,$price,$description,$components,$type,$image_url);

	header('location:'.$url);
}
?>