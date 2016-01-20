<?php

$url = "../index.php?mod=post&act=list";

require_once "../model/Post.php";

$model = new Post;

$post_id = (int) $_POST['post_id'];

$city_id = (int) $_POST['city_id'];

$district_id = (int) $_POST['district_id'];

$area_id  = (int) $_POST['area_id'];

$status  = $_POST['status'];

$status = $status > 0 ? $status : null;

$total_area  = $_POST['total_area'];

$legal_id = (int) $_POST['legal_id'];

$direction_id = (int) $_POST['direction_id'];

$estate_type_id = (int) $_POST['estate_type_id'];

$type_id = (int) $_POST['type_id'];

$cal_type = (int) $_POST['cal_type'];

$price_id = (int) $_POST['price_id'];

$price = $_POST['price'];

$project_type_id = (int) $_POST['project_type_id'];

$post_title = $_POST['post_title'];

$post_alias = $model->changeTitle($post_title);

$video_url = $_POST['video_url'];

$longt = $_POST['longt'];

$latt = $_POST['latt'];

$address = $_POST['address'];

$content = $_POST['content'];

$contact = $_POST['contact'];

$phone = $_POST['phone'];

$image_url = str_replace('../', '', $_POST['image_url']);

$horizontal = $_POST['horizontal'];

$lengths = $_POST['lengths'];

$road = $_POST['road'];

$floors = $_POST['floors'];

$bedroom = $_POST['bedroom'];

$str_image = $_POST['str_image'];

$arrAddon = $_POST['addon'];

if($post_id > 0) {

	$model->updatePost($post_id,$post_title,$post_alias,$image_url,$content,$address,$price,$cal_type,$total_area,$contact,$phone,$type_id,$estate_type_id,$city_id,$district_id,$project_type_id,$direction_id,$area_id,$legal_id,$price_id,$horizontal,$lengths,$road,$floors,$bedroom,$video_url,$longt,$latt,$str_image,$arrAddon,$status);

}else{

	$model->insertPost($post_title,$post_alias,$image_url,$content,$address,$price,$cal_type,$total_area,$contact,$phone,$type_id,$estate_type_id,$city_id,$district_id,$project_type_id,$direction_id,$area_id,$legal_id,$price_id,$horizontal,$lengths,$road,$floors,$bedroom,$video_url,$longt,$latt,$str_image,$arrAddon);

}

header('location:'.$url."&estate_type_id=".$estate_type_id."&type_id=".$type_id);


?>