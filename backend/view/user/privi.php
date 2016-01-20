<?php 
require_once "model/Backend.php"; 
$model = new Backend; 
$arrCity = $model->getListCity();
 $priviArr = array();
if(isset($_GET[ 'user_id']))
{ 
	$user_id=( int) $_GET[ 'user_id']; 
	
	$detail=$model->getDetailUser($user_id);
    $arrPri = $model->getListPrivilege(0);
    $priviArr = $model->getListPriviUser($user_id);    
}
if (isset($_GET['full_name']) && $_GET['full_name'] != '') {       
    $back_url .="&full_name=".$_GET['full_name'];
}
if (isset($_GET['username']) && $_GET['username'] != '') {       
    $back_url .="&username=".$_GET['username'];
}
if (isset($_GET['status']) && $_GET['status'] > -1) {    
    $back_url.="&status=".$_GET['status'];
}
?>
<div class="row">
    <div class="col-md-8">
        <!-- Custom Tabs -->
        <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=user&act=list<?php echo $back_url; ?>'">Back</button>
        <div style="clear:both;margin-bottom:10px"></div>
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Phân quyền nhân viên : <?php echo $detail['username']; ?></h3> </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="controller/User.php">
                <input type="hidden" name="act" value="privis" />
                <?php if($user_id> 0){ ?>
                <input type="hidden" value="<?php echo $user_id; ?>" name="user_id" />
                <?php } ?>
                <div class="box-body">
                	<table>
                        
                        <tr>
                            <?php $i = 0; foreach ($arrPri as $key => $value) { $i++;
                           ?>
                            <td class="td_privilege" style="width:250px;height:150px;vertical-align:top">
                                <p><b><input type="checkbox" name="privi[]" value="<?php echo $value['id']; ?>" 
                                <?php if(in_array($value['id'],$priviArr)) echo "checked"; ?>
                                data-type="parent" >&nbsp;&nbsp;<span style="font-weight:bold;text-transform:uppercase"><?php echo $value['id']; ?> - <?php echo $value['name']; ?></span></b></p>                                
                                <?php $parent_id = $value['id'];
                                $arrPriChild = $model->getListPrivilege($parent_id);
                                if(!empty($arrPriChild)){
                                    foreach ($arrPriChild as $child) {                                      
                                ?>
                                <p style="padding-left:30px"><input type="checkbox" name="privi[]" 
                                <?php if(in_array($child['id'],$priviArr)) echo "checked"; ?>
                                value="<?php echo $child['id']; ?>" class="child" >&nbsp;&nbsp;<?php echo $child['id']; ?> - <?php echo $child['name']; ?></p>
                                <?php } }?>

                            </td>
                            <?php if($i%3==0) echo "</tr></tr>";} ?>
                        </tr>
                        
                    </table>
                    
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button class="btn btn-primary btnSave" type="submit">Save</button>
                    <button class="btn btn-primary"  onclick="location.href='index.php?mod=user&act=list<?php echo $back_url; ?>'">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /.col -->
</div>
<script type="text/javascript">
    $(function(){
        $('checkbox.child').click(function(){
            console.log($(this).attr('checked'));
        });
    });
</script>