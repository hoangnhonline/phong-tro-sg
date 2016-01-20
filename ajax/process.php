<?php 
require_once "../backend/model/Frontend.php";
$model = new Frontend;

$arrParam['name'] = $model->processData($_POST['name']);
$arrParam['email'] = $model->processData($_POST['email']);
$arrParam['title'] = $model->processData($_POST['title']);
$arrParam['content'] = $model->processData($_POST['content']);
$arrParam['status'] = 1;
$arrParam['type'] = 3;
$arrParam['creation_time'] = time();
$arrParam['update_time'] = time();

$column = $values = "";

foreach ($arrParam as $key => $value) {
	$column .= "$key".",";
	$values .= "'".$value."'".",";
}
$column = rtrim($column,",");
$values = rtrim($values,",");
$sql = "INSERT INTO sendcontent(".$column.") VALUES (".$values.")"; 

mysql_query($sql) or die(mysql_error());
$id = mysql_insert_id();
if($id > 0){
	echo "success";
}else{
	echo "error";
}
?>