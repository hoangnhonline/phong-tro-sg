<?php
$id = 0;
if(isset($_GET['id'])){
    $id = (int) $_GET['id'];
    require_once "model/Backend.php";
    $model = new Backend;
    $detail = $model->getDetail("customers",$id);
}
?>
<div class="row">
    <div class="col-md-8">

        <!-- Custom Tabs -->
        <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=customers&act=list'">Danh sách</button>
        <div style="clear:both;margin-bottom:10px"></div>

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"><?php echo ($id > 0) ? "Cập nhật" : "Thêm mới" ?> khách hàng</h3>

            </div><!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="controller/Customer.php">
                <?php if($id> 0){ ?>
                <input type="hidden" value="<?php echo $id; ?>" name="id" />
                <?php } ?>
                <div class="box-body">
                    <div class="form-group">
                        <label for="name">Tên</label>
                        <input  value="<?php echo isset($detail['name'])  ? $detail['name'] : "" ?>" type="text" name="name" id="name" class="form-control required">
                    </div>
                    <div class="form-group">
                        <label>Giới tính</label>
                        <label class="radio-inline"><input type="radio" name="gender" id="gender_1" value="1"
                            <?php if((isset($detail['gender']) && $detail['gender'] == 1) || empty($detail)) { echo "checked"; } ?>
                            >Nam</label>
                        <label class="radio-inline"><input type="radio" name="gender" id="gender_2" value="2"
                            <?php if(isset($detail['gender']) && $detail['gender'] == 2) echo "checked"; ?>
                            >Nữ</label>
                    </div>
                    <div class="form-group">
                        <label for="name">Điện thoại</label>
                        <input  value="<?php echo isset($detail['phone'])  ? $detail['phone'] : "" ?>" type="text" name="phone" id="phone" class="form-control required">
                    </div>

                    <div class="form-group">
                        <label for="name">Email</label>
                        <input  value="<?php echo isset($detail['email'])  ? $detail['email'] : "" ?>" type="text" name="email" id="email" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="name">Ngày sinh</label>
                        <input  value="<?php echo isset($detail['birthday'])  ? $detail['birthday'] : "" ?>" type="text" name="birthday" id="birthday" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="name">CMND</label>
                        <input  value="<?php echo isset($detail['cmnd'])  ? $detail['cmnd'] : "" ?>" type="text" name="cmnd" id="cmnd" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="name">Địa chỉ/Quê quán</label>
                        <textarea  name="address" id="address" class="form-control" rows="3"><?php echo isset($detail['address'])  ? $detail['address'] : "" ?></textarea>
                    </div>     
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">        
                </div>
                <div class="box-footer">
                     <button class="btn btn-primary btnSave" type="submit">Save</button>
                     <button class="btn btn-primary" type="reset" onclick="location.href='index.php?mod=customers&act=list'">Cancel</button>
                </div>
            </form>
        </div>

    </div><!-- /.col -->
</div>
<link href="static/css/jquery-ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="ckfinder/ckfinder.js"></script>
<script type="text/javascript">


function split(val) {
    return val.split(/;\s*/);
}

function extractLast(term) {
    return split(term).pop();
}
function BrowseServer( startupPath, functionData ){    
    var finder = new CKFinder();
    finder.basePath = 'ckfinder/'; //Đường path nơi đặt ckfinder
    finder.startupPath = startupPath; //Đường path hiện sẵn cho user chọn file
    finder.selectActionFunction = SetFileField; // hàm sẽ được gọi khi 1 file được chọn
    finder.selectActionData = functionData; //id của text field cần hiện địa chỉ hình
    //finder.selectThumbnailActionFunction = ShowThumbnails; //hàm sẽ được gọi khi 1 file thumnail được chọn    
    finder.popup(); // Bật cửa sổ CKFinder
} //BrowseServer

function SetFileField( fileUrl, data ){
    document.getElementById( data["selectActionData"] ).value = fileUrl;
    $('#img_thumnails').attr('src',fileUrl).show();
}
function BrowseServerIcon( startupPath, functionData ){    
    var finder = new CKFinder();
    finder.basePath = 'ckfinder/'; //Đường path nơi đặt ckfinder
    finder.startupPath = startupPath; //Đường path hiện sẵn cho user chọn file
    finder.selectActionFunction = SetFileFieldIcon; // hàm sẽ được gọi khi 1 file được chọn
    finder.selectActionData = functionData; //id của text field cần hiện địa chỉ hình
    //finder.selectThumbnailActionFunction = ShowThumbnails; //hàm sẽ được gọi khi 1 file thumnail được chọn    
    finder.popup(); // Bật cửa sổ CKFinder
} //BrowseServer

function SetFileFieldIcon( fileUrl, data ){
    document.getElementById( data["selectActionData"] ).value = fileUrl;
    $('#img_icon').attr('src', fileUrl).show();
}
</script>
<script type="text/javascript">
$(function(){
    $('#choose_img_sv').on('ifChecked', function(event){
        $('#from_sv').show();
        $('#from_cp').hide();
    });
    $('#choose_img_cp').on('ifChecked', function(event){
        $('#from_cp').show();
        $('#from_sv').hide();
    });    
  
}); 
</script>
