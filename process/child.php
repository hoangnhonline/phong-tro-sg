<?php 
session_start();
require_once "../backend/model/Backend.php";
$model = new Backend();
$id = (int) $_POST['id'];
$child = $_POST['child'];


$arrCustom = array();
if($child=="type_bds"){	
	echo "<option data-alias='' value='0'>-- Loại nhà đất --</option>";
	$arrResult = $model->getChild('type_bds','type', $id);	
}
if($child=="district"){	
	echo "<option data-alias='' value='0'>-- Chọn Quận/Huyện --</option>";
	$arrResult = $model->getChild('district','city_id', $id);	
}
if($child=="price"){
	echo "<option data-alias='' value='0'>-- Chọn khoảng giá --</option>";
	$arrResult = $model->getChild('price','type', $id);	
}
//$arrResult = $model->getChild($table, $column, $id, -1, $arrCustom);


if(!empty($arrResult)){
	foreach ($arrResult as $key => $value) {
		echo "<option data-alias='".$value['alias']."' value='".$value['id']."'>".$value['name']."</option>";
	}
}
?>