<?php
$url = "../index.php?mod=district&act=list";
require_once "../model/Backend.php";
$model = new Backend;

$id = (int) $_POST['id'];

$arrData['city_id'] = $city_id = (int) $_POST['city_id'];
$arrData['display_order'] = 1;

$table = "district";

if($id == 0){

	$str_name = $model->processData($_POST['str_name']);	
	$tmp = explode(",", $str_name);
	$arrData['created_at'] = time();
	$arrData['updated_at'] = time();
	if(!empty($tmp)){
		foreach ($tmp as $name) {
			$arrData['name'] = $name;
			if($model->checkNameExistByParentId($table, 'city_id', $city_id, $name)){
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

header('location:'.$url.'&city_id='.$city_id);
?>