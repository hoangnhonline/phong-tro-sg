<?php 
session_start();
$url = "../index.php";

require_once "../model/Backend.php";

$model = new Backend;

$act = $_POST['act'];

if($act == "checkPass"){

	$user_id = (int) $_POST['user_id'];
	$password = md5($_POST['password']);	
    $row = $model->getDetailUser($user_id);
    if ($password == $row['password'])
        echo "1";
    else
        echo "0";

	exit();

}elseif($act == "changepass"){

	$user_id = $_SESSION['user_id'];
	$password = md5($_POST['password']);
	$model->changePass($user_id,$password);
	session_destroy();    
	header('location:../login.php');

}
header('location:../index.php');
?>