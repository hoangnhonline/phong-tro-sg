<?php 
session_start();
require_once "../model/Backend.php";
$model = new Backend;

$image_id = (int) $_POST['image_id'];
$image_url = $_POST['image_url'];
$image_2 = str_replace(".", "_2.", $image_url);
$image_690 = str_replace(".", "_400x300.", $image_url);
var_dump(unlink("../../".$image_url));
var_dump(unlink("../../".$image_2));
var_dump(unlink("../../".$image_4));
var_dump(unlink("../../".$image_690));
if($image_id > 0){
	mysql_query("DELETE FROM images WHERE id = $image_id");
}
?>