<?php 
session_start();
$user_id = isset($_POST['user_id']) ? (int) $_POST['user_id'] : 0;
require_once "../model/Backend.php";
$model = new Backend();
$id = (int) $_POST['city_id'];
$arrResult = $model->getChild("district", 'city_id', $id);
$arrSelected = array();
if($user_id > 0){
	$arrSelected = $model->getListDistrictIDAsset($user_id);
}

$arrChoosed = array();
$sql = "SELECT id FROM district ";
if($user_id > 0 ){
	$sql.=" WHERE user_id <> $user_id ";
}
$s = mysql_query($sql);
while($r = mysql_fetch_assoc($s)){
	$arrChoosed[] = $r['id'];
}

if(!empty($arrResult)){
	foreach ($arrResult as $value) {
		if(!in_array($value['id'], $arrChoosed)){
		?>
		<div class="col-md-3" style="height:40px">
			<div class="form-group">
				<label><input type="checkbox" name="district_id[]" 
					<?php if(in_array($value['id'], $arrSelected)) echo "checked=checked"; ?>

				 value="<?php echo $value['id']; ?>">&nbsp;<?php echo $value['name']; ?></label>
			</div>
		</div>
		<?php		
	}}
}
?>