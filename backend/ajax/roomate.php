<?php $count = $_POST['count']; ?>
<div class="col-md-12 roomate" style="border:1px solid #CCC; padding:10px;margin-bottom:15px;">                        
    <input type="hidden" name="roomate_id[]" value="0">
    <div class="col-md-4">
        <div class="form-group">
            <label for="name">Tên</label>
            <input type="text" name="name_roomate[]" class="form-control required">
        </div>
    </div>                        
    <div class="col-md-4">
        <div class="form-group">
            <label>Giới tính</label><br />
            <label class="radio-inline"><input checked="checked" type="radio" name="gender_roomate_<?php echo $count; ?>" value="1">Nam</label>
            <label class="radio-inline"><input type="radio" name="gender_roomate_<?php echo $count; ?>" value="2">Nữ</label>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="name">Điện thoại</label>
            <input type="text" name="phone_roomate[]" class="form-control required">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="name">Email</label>
            <input type="email" name="email_roomate[]" class="form-control">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="name">Ngày sinh</label>
            <input type="text" name="birthday_roomate[]" id="birthday_roomate" class="form-control">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="name">CMND</label>
            <input type="text" name="cmnd_roomate[]" class="form-control">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="name">Địa chỉ/Quê quán</label>
            <textarea  name="address_roomate[]" class="form-control" rows="3"></textarea>
        </div>  
    </div>
</div>
<script type="text/javascript">
$(function(){
    $("input[type='checkbox'], input[type='radio']").iCheck({
        checkboxClass: 'icheckbox_minimal',
        radioClass: 'iradio_minimal'
    });
});
</script>