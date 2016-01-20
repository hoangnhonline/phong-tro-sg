<?php
session_start();
$user_id = $_SESSION['user_id'];
$url = "../index.php?mod=contract&act=list";
require_once "../model/Backend.php";
$model = new Backend;

$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
//save customer
$customer_id_old = isset($_POST['customer_id_old']) ? (int) $_POST['customer_id_old'] : 0;
$object_type = $_POST['object_type'];
$object_id = (int) $_POST['object_id'];
$contract_id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

if($customer_id_old == 0){
	// new
	$customerArr['name'] = $model->processData($_POST['name']);	
	if($customerArr['name'] !=''){
		$customerArr['gender'] = (int) $_POST['gender'];
		$customerArr['phone'] = $model->processData($_POST['phone']);
		$customerArr['email'] = $model->processData($_POST['email']);
		$customerArr['birthday'] = $model->processData($_POST['birthday']);
		$customerArr['address'] = $model->processData($_POST['address']);
		$customerArr['cmnd'] = $model->processData($_POST['cmnd']);		
		$customerArr['updated_at'] = time();
		$customerArr['user_id'] = $user_id;
		$customerArr['status'] = 1;
		$customerArr['is_main'] = 1;
		$customer_id = (int) $_POST['customer_id'];		
		if($customer_id > 0){			
			$customerArr['id'] = $customer_id;
			$model->update('customers', $customerArr);	
		}else{
			$customerArr['created_at'] = time();
			$customer_id = $model->insert('customers', $customerArr);	
		}
		
	}
}else{
	$customer_id = $customer_id_old;
}	

if($customer_id > 0){

	$contractArr['object_id'] = (int) $_POST['object_id'];
	$contractArr['customer_id'] = $customer_id;
	$contractArr['object_type'] = (int) $_POST['object_type'];
	$contractArr['code'] = $model->processData($_POST['code']);
	$contractArr['user_id'] = $user_id;
	$contractArr['no_person'] = (int) $_POST['no_person'];
	$contractArr['start_date'] = date('Y-m-d', strtotime($_POST['start_date']));
	$contractArr['end_date'] =  date('Y-m-d', strtotime($_POST['end_date']));
	$contractArr['contract_date'] = date('Y-m-d', strtotime($_POST['contract_date']));
	$contractArr['deposit_date'] =  date('Y-m-d', strtotime($_POST['deposit_date']));
	$contractArr['no_month'] = $no_month = (int) $_POST['no_month'];
	if($no_month < 3){
	    $price = $_POST['h_price_1'];
			    
	}elseif ($no_month < 6 && $no_month > 2) {
if($_POST['h_price_3'] == 0){
	   $price = $_POST['h_price_1'];
}else{
	    $price = $_POST['h_price_3'];
}
	}else {
if($_POST['h_price_6'] == 0){
	   $price = $_POST['h_price_3'];
}else if($_POST['h_price_3'] == 0){
	   $price = $_POST['h_price_1'];
}else{
	    $price = $_POST['h_price_6'];
}
	
	}
	$contractArr['price'] = $price;
	$contractArr['deposit'] = str_replace(",", "", $_POST['deposit']);
	$contractArr['the_chan'] = (int) $_POST['the_chan'];
	$contractArr['so_dien'] = (int) $_POST['so_dien'];
	$contractArr['so_nuoc'] = (int) $_POST['so_nuoc'];
	
	$contractArr['updated_at'] = time();

	$contractArr['status'] = $_POST['status'];
	
	if($contract_id > 0){
		$contractArr['id'] = $contract_id;
		$model->update('contract', $contractArr);
		if($contractArr['status'] == 2){
			$model->update('objects', array('id' => $contractArr['object_id'], 'status' => 1));	
			$model->update('contract', array('id' => $contract_id, 'end_date' => date('Y-m-d'))); 
		}
	}else{
		$contractArr['created_at'] = time();
		$contract_id = $model->insert('contract', $contractArr);
		$start = $_POST['start_date'];
		$current = date('d-m-Y');
		if($current < $start){
			$status = 2; // coc
		}else{
			$status = 3; // dang o
		}
		mysql_query("UPDATE objects SET status = $status WHERE id = $object_id AND object_type = $object_type");
	}

	mysql_query("DELETE FROM contract_service WHERE contract_id = $contract_id");
	//save service
	if($object_type == 1){
		$detailTaiSan = $model->getDetail('objects', $object_id);
		if($detailTaiSan['house_id'] > 0){	    
		    $arrServiceHouse = $model->getHouseServices($detailTaiSan['house_id']);    
		}		
		if(!empty($_POST['service_id'])){
			foreach ($_POST['service_id'] as $service_id) {
				$dataService['service_id'] = $service_id;
				$dataService['contract_id'] = $contract_id;
				$dataService['cal_type'] = $arrServiceHouse[$service_id]['cal_type'];
				$model->insert('contract_service', $dataService);
			}
		}
		mysql_query("DELETE FROM contract_convenient WHERE contract_id = $contract_id");
		//save convenient
		if(!empty($_POST['convenient_id'])){
			foreach ($_POST['convenient_id'] as $convenient_id) {
				$dataCon['contract_id'] = $contract_id;
				$dataCon['convenient_id'] = $convenient_id;				
				$model->insert('contract_convenient', $dataCon);
			}
		}
	}	
	mysql_query("DELETE FROM contract_roomate WHERE contract_id = $contract_id");
	//save roomate
	if(!empty($_POST['name_roomate'])){
		foreach ($_POST['name_roomate'] as $k => $name_roomate) {
			if($name_roomate!=''){
				$roomateArr['name'] = $name_roomate;
				$roomateArr['gender'] = (int) $_POST['gender_roomate_'.$k];
				$roomateArr['phone'] = $model->processData($_POST['phone_roomate'][$k]);
				$roomateArr['email'] = $model->processData($_POST['email_roomate'][$k]);
				$roomateArr['birthday'] = $model->processData($_POST['birthday_roomate'][$k]);
				$roomateArr['address'] = $model->processData($_POST['address_roomate'][$k]);
				$roomateArr['cmnd'] = $model->processData($_POST['cmnd_roomate'][$k]);
				$roomateArr['updated_at'] = time();
				$roomateArr['user_id'] = $user_id;
				$roomateArr['status'] = 1;
				$roomate_id = isset($_POST['roomate_id']) ? (int) $_POST['roomate_id'][$k] : 0;
				
				if($roomate_id > 0){
					$roomateArr['id'] = $roomate_id;
					$model->update('customers', $roomateArr);
				}else{					
					$roomateArr['created_at'] = time();
					$roomate_id = $model->insert('customers', $roomateArr);
				}

				$arrContractRoomate['contract_id'] = $contract_id;
				$arrContractRoomate['customer_id'] = $roomate_id;

				$model->insert('contract_roomate', $arrContractRoomate);

				$roomateArr = array();
			}
		}
	}


}

header('location:'.$url);
?>
