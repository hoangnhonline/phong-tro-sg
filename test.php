<?php 
require_once "backend/model/Frontend.php";
$model = new Frontend;

$sql = "SELECT contract.id as contract_id, start_date, end_date, objects.id AS object_id
		FROM `contract` , objects
		WHERE objects.id = contract.object_id
		AND DATE( start_date ) <= DATE( NOW( ) ) 
		";

$rs = mysql_query($sql);
while($row = mysql_fetch_assoc($rs)){
	//echo $row['object_id']."<br>";
	$arrData['id'] = $row['object_id'];
	$arrData['status'] = 3;
	update('objects', $arrData);
}

$sql1 = "SELECT contract.id as contract_id, start_date, end_date, objects.id AS object_id
		FROM `contract` , objects
		WHERE objects.id = contract.object_id
		AND DATE( end_date ) <= DATE( NOW( ) ) 
		";

$rs1 = mysql_query($sql1);
while($row1 = mysql_fetch_assoc($rs1)){
	echo $row1['end_date']."-".$row1['object_id']."<br>";
	$arrDataO['status'] =  1;
	$arrDataO['id'] = $row1['object_id'];	
	update('objects', $arrDataO);

	$arrDataC['status'] =  2; // het han
	$arrDataC['id'] = $row1['contract_id'];	
	update('contract', $arrDataC);

}

function insert($table, $arrData){
	$str_value = $str_comlumn = "";

	foreach($arrData as $key => $value){
		//xu ly value
		$str_value.= "'".$value."',";
		//xu ly comlumn
		$str_comlumn .= $key.",";	
	}

	$str_value = rtrim($str_value,",");
	$str_comlumn = rtrim($str_comlumn,",");

	echo $sql = "INSERT INTO $table (".$str_comlumn.") VALUES(".$str_value.")";
	mysql_query($sql);
	$id = mysql_insert_id();
	return $id;
}
function update($table, $arrData){
	$str_update = "";
	//name = '$name', display_order = '$display_order', updated_at = '$updated_at'
	foreach($arrData as $key => $value){
		//xu ly value
		$str_update .= $key."=". "'".$value."',";	
	}
	$str_update = rtrim($str_update,",");

	$sql = "UPDATE $table SET ".$str_update." WHERE id = ". $arrData['id'];

	mysql_query($sql);


}

?>