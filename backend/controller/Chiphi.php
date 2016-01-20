<?php 
$url = "../index.php?mod=house&act=list-chi-phi&house_id=".$_POST['house_id'];
session_start();
require_once "../model/Backend.php";
$model = new Backend;
$user_id = $_SESSION['user_id'];

$arrData['house_id'] = $house_id = (int) $_POST['house_id'];
$arrData['month'] = $month = (int) $_POST['month'];
$arrData['year'] = $year = (int) $_POST['year'];
$arrName = $_POST['name'];
$arrPrice = $_POST['price'];
if(!empty($arrName)){
	foreach ($arrName as $key => $name) {
		$price = str_replace(',', '', $arrPrice[$key]);
		if($name && $price > 0){
			$arrData['price'] = $price;
			$arrData['name'] = $name;
			$arrData['user_id'] = $user_id;
			$model->insert('house_expense', $arrData);
		}
	}
}

header('location:'.$url);
?>