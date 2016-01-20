<?php
$url = "../index.php?mod=ward&act=list";
require_once "../model/Backend.php";
$model = new Backend;

$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

$arrData['district_id'] = $district_id = (int) $_POST['district_id'];
$arrData['city_id'] = $city_id = (int) $_POST['city_id'];
$arrData['display_order'] = 1;

$table = "ward";

if($id == 0){

	$str_name = $model->processData($_POST['str_name']);	
	$tmp = explode(",", $str_name);
	$arrData['created_at'] = time();
	$arrData['updated_at'] = time();
	if(!empty($tmp)){
		foreach ($tmp as $name) {
			$arrData['name'] = $name;
			if($model->checkNameExistByParentId($table, 'district_id', $district_id, $name)){
				$model->insert($table, $arrData);	
			}			
		}
	}

}else{
	$arrData['name'] = $model->processData($_POST['name']);
	$arrData['id'] = $id;
	$arrData['updated_at'] = time();
	$model->update($table, $arrData);	
}

header('location:'.$url);
?>