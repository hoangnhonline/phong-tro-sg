<?php 
$user_id = $_SESSION['user_id'];
$detail=$model->getDetailUser($user_id);

?>
<div class="row">
    <div class="col-md-8">
        <!-- Custom Tabs -->        
        <div style="clear:both;margin-bottom:10px"></div>
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Đổi mật khẩu</h3> </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="controller/ChangePass.php" id="form_changepass">
                <?php if($user_id> 0){ ?>
                <input type="hidden" value="<?php echo $user_id; ?>" name="user_id" />
                <?php } ?>
                <input type="hidden" name="act" value="changepass" />
                <div class="box-body">
                	<div class="form-group">
                        <label for="exampleInputEmail1"> Mật khẩu hiện tại <span class="required"> ( * ) </span></label>
                        <input value=""  type="password" name="old_pass" id="old_pass" class="form-control required"> 
                        <input value="<?php echo $detail['password']; ?>"  type="hidden" name="old_pass_md5" id="old_pass_md5" class="form-control required"> 
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> Mật khẩu mới <span class="required"> ( * ) </span></label>
                        <input value=""  type="password" name="password" id="password" class="form-control required"> 
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> Nhập lại mật khẩu mới <span class="required"> ( * ) </span></label>
                        <input value=""  type="password" name="re_password" id="re_password" class="form-control required"> 
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button class="btn btn-primary " id="btnChangePass" type="button">Save</button>
                    <button class="btn btn-primary" type="reset" onclick="location.href='index.php'">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /.col -->
</div>
<script>
    $(function(){
        $('#btnChangePass').click(function(){
            var flag = true;
            if($('#old_pass').val()=='' || $('#password').val()=='' || $('#re_password').val()==''){
                alert('Vui lòng nhập đầy đủ!'); return false;
            }
            if($('#password').val() != $('#re_password').val()){
                alert('Mật khẩu nhập 2 lần không giống nhau!');return false;
            }           
            $.ajax({
                url: "ajax/process.php",
                type: "POST",
                async: true,
                data: {                             
                    'action' : 'check_md5',
                    'old_pass_md5' : $('#old_pass_md5').val(),
                    'old_pass' : $('#old_pass').val()
                },
                success: function(data){                                                               
                   if($.trim(data)=="1"){
                        alert('Đổi mật khẩu thành công!');
                        $('#form_changepass').submit();
                   }else{
                    alert('Mật khẩu cũ không đúng!');return false;
                   }
                    
                }
            }); 
            console.log(flag);
            return flag;
        });
    });

</script>