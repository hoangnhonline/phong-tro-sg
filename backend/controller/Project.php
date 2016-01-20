<?php 

$url = "../index.php?mod=project&act=list";

require_once "../model/Project.php";

$model = new Project;

$project_id = (int) $_POST['project_id'];

$district_id = (int) $_POST['district_id'];

$project_type_id = (int) $_POST['project_type_id'];

$project_name = $_POST['project_name'];

$project_alias = $model->changeTitle($project_name);

$video_url = $_POST['video_url'];

$longt = $_POST['longt'];

$latt = $_POST['latt'];

$address = $_POST['address'];

$content = $_POST['content'];

$contact = $_POST['contact'];

$phone = $_POST['phone'];

$hot = $_POST['hot'];

$description = $_POST['description'];

$image_url = str_replace('../', '', $_POST['image_url']);

$str_image = $_POST['str_image'];


if($project_id > 0) {	
	$model->updateProject($project_id,$project_name,$project_alias,$project_type_id,$district_id,$address,$contact,$phone,$image_url,$video_url,$description,$content,$hot,$longt,$latt,$str_image);		
}else{	
	$model->insertProject($project_name,$project_alias,$project_type_id,$district_id,$address,$contact,$phone,$image_url,$video_url,$description,$content,$hot,$longt,$latt,$str_image);	
}

header('location:'.$url."&project_type_id=".$project_type_id."&district_id=".$district_id);


?>