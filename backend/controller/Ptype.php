<?php
$url = "../index.php?mod=project_type&act=list";
require_once "../model/Ptype.php";
$model = new Ptype;

$project_type_id = (int) $_POST['project_type_id'];
$project_type_name = $model->processData($_POST['project_type_name']);
$project_type_alias = $model->changeTitle($project_type_name);


if($project_type_id > 0) {
	$model->updatePtype($project_type_id,$project_type_name,$project_type_alias);
	header('location:'.$url);
}else{
	$model->insertPtype($project_type_name,$project_type_alias);
	header('location:'.$url);
}

?>