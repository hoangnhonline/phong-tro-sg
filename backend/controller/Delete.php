<?php
if(!isset($_SESSION))
{
     session_start();
}
require_once "../model/Backend.php";
$model = new Backend;

$id = $_POST['id'];

$mod = $_POST['mod'];

if($mod=='house'){
    // xoa post
    $sql = "DELETE FROM house WHERE id = $id";
	mysql_query($sql) or die(mysql_error() . $sql);
	// xoa images
	$sql = "DELETE FROM images WHERE object_id = $id AND object_type = 1";
	mysql_query($sql) or die(mysql_error() . $sql);

	$sql = "DELETE FROM house_addon WHERE house_id = $id";
	mysql_query($sql) or die(mysql_error() . $sql);
	exit;
}elseif($mod=='room'){
    // xoa post
    $sql = "DELETE FROM objects WHERE id = $id AND object_type = 1";
	mysql_query($sql) or die(mysql_error() . $sql);
	// xoa images
	$sql = "DELETE FROM images WHERE object_id = $id AND object_type = 2";
	mysql_query($sql) or die(mysql_error() . $sql);

	$sql = "DELETE FROM room_info WHERE room_id = $id";
	mysql_query($sql) or die(mysql_error() . $sql);

	$sql = "DELETE FROM room_services WHERE room_id = $id";
	mysql_query($sql) or die(mysql_error() . $sql);
	exit;
}elseif($mod=="houserent"){
	 // xoa post
    $sql = "DELETE FROM objects WHERE id = $id AND object_type = 2";
	mysql_query($sql) or die(mysql_error() . $sql);
	// xoa images
	$sql = "DELETE FROM images WHERE object_id = $id AND object_type = 1";
	mysql_query($sql) or die(mysql_error() . $sql);
	
	$sql = "DELETE FROM house_addon WHERE house_id = $id";
	mysql_query($sql) or die(mysql_error() . $sql);

	$sql = "DELETE FROM house_purpose WHERE house_id = $id";
	mysql_query($sql) or die(mysql_error() . $sql);
	exit;
}elseif($mod=='articles'){
    // xoa project
    $sql = "DELETE FROM articles WHERE id = $id";
	mysql_query($sql) or die(mysql_error() . $sql);
	// xoa images
	
	exit;
}elseif($mod=='pages'){
    // xoa project
    $sql = "DELETE FROM pages WHERE id = $id";
	mysql_query($sql) or die(mysql_error() . $sql);
	// xoa images
	
	exit;
}elseif($mod=='contract'){
    // xoa project
    $sql = "DELETE FROM contract WHERE id = $id";
	mysql_query($sql) or die(mysql_error() . $sql);
	// xoa images
	
	exit;
}elseif($mod=='district'){
    // xoa project
    $sql = "DELETE FROM district WHERE id = $id";
	mysql_query($sql) or die(mysql_error() . $sql);
	exit;
}elseif($mod=='banner'){
    // xoa project
    $sql = "DELETE FROM banner WHERE id = $id";
	mysql_query($sql) or die(mysql_error() . $sql);
	exit;
}elseif($mod=='expense'){
    // xoa project
    $sql = "DELETE FROM expense WHERE id = $id";
	mysql_query($sql) or die(mysql_error() . $sql);
	exit;
}elseif($mod=='ward'){
    // xoa project
    $sql = "DELETE FROM ward WHERE id = $id";
	mysql_query($sql) or die(mysql_error() . $sql);
	exit;
}elseif($mod=='services'){
    // xoa project
    if($id > 2){
	    $sql = "DELETE FROM services WHERE id = $id";
		mysql_query($sql) or die(mysql_error() . $sql);
	}
	exit;
}elseif($mod=='estate_type'){
    // xoa project

    $sql = "DELETE FROM estate_type WHERE id = $id";
	mysql_query($sql) or die(mysql_error() . $sql);
	exit;
}elseif($mod=='project_type'){
    // xoa project
    $sql = "DELETE FROM project_type WHERE id = $id";
	mysql_query($sql) or die(mysql_error() . $sql);
	exit;
}elseif($mod=='addon'){
    // xoa project
    $sql = "DELETE FROM addon WHERE id = $id";
	mysql_query($sql) or die(mysql_error() . $sql);
	exit;
}elseif($mod=='convenient'){
    // xoa project
    $sql = "DELETE FROM convenient WHERE id = $id";
	mysql_query($sql) or die(mysql_error() . $sql);
	exit;
}elseif($mod=='area'){
    // xoa project
    $sql = "DELETE FROM area WHERE area_id = $id";
	mysql_query($sql) or die(mysql_error() . $sql);
	exit;
}elseif($mod=='price'){
    // xoa project
    $sql = "DELETE FROM price WHERE price_id = $id";
	mysql_query($sql) or die(mysql_error() . $sql);
	exit;
}elseif($mod=='direction'){
    // xoa project
    $sql = "DELETE FROM direction WHERE id = $id";
	mysql_query($sql) or die(mysql_error() . $sql);
	exit;
}elseif($mod=='legal'){
    // xoa project
    $sql = "DELETE FROM legal WHERE legal_id = $id";
	mysql_query($sql) or die(mysql_error() . $sql);
	exit;
}elseif($mod=='articles'){
    //xoa articles
    $sql = "DELETE FROM articles WHERE article_id = $id";
	mysql_query($sql) or die(mysql_error() . $sql);
	//xoa images
	$sql = "DELETE FROM images WHERE article_id = $id AND object_type = 2";
	mysql_query($sql) or die(mysql_error() . $sql);
	//xoa tag
	$sql = "DELETE FROM articles_tag WHERE article_id = $id AND object_type = 2";
	mysql_query($sql) or die(mysql_error() . $sql);
	exit();
}elseif($mod=='image'){
    $pk = 'image_id';
}elseif($mod=='images'){
    $sql = "DELETE FROM images WHERE id = $id";
	mysql_query($sql) or die(mysql_error() . $sql);
	exit;
}elseif($mod=='city'){
    $sql = "DELETE FROM city WHERE id = $id";
	mysql_query($sql) or die(mysql_error() . $sql);
	exit;
}elseif($mod=='imagesalbum'){
    $sql = "DELETE FROM imagesalbum WHERE image_id = $id";
	mysql_query($sql) or die(mysql_error() . $sql);
	exit;
}elseif($mod=='text'){
    $sql = "DELETE FROM text WHERE id = $id";
	mysql_query($sql) or die(mysql_error() . $sql);
	exit;
}elseif($mod=='seo'){
    $sql = "DELETE FROM seo WHERE id = $id";
	mysql_query($sql) or die(mysql_error() . $sql);
	exit;
}elseif($mod=='users'){
    $sql = "DELETE FROM users WHERE id = $id";
	mysql_query($sql) or die(mysql_error() . $sql);
	exit;
}elseif($mod=='customers'){
    $sql = "DELETE FROM customers WHERE id = $id";
	mysql_query($sql) or die(mysql_error() . $sql);
	exit;
}elseif($mod=='block'){
    $sql = "DELETE FROM block WHERE block_id = $id";
	mysql_query($sql) or die(mysql_error() . $sql);
	$sql = "DELETE FROM link WHERE block_id = $id";
	mysql_query($sql) or die(mysql_error() . $sql);
	exit;
}
$time = time();

$sql = "UPDATE ".$mod." SET status = 0 WHERE ".$pk." = ".$id;
mysql_query($sql) or die(mysql_error() . $sql);
?>
