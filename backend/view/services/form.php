<?php
$id = 0;
if(isset($_GET['id'])){
    $id = (int) $_GET['id'];
    require_once "model/Backend.php";
    $model = new Backend;
    $detail = $model->getDetail("services",$id);
}
?>
<div class="row">
    <div class="col-md-8">

        <!-- Custom Tabs -->
        <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=services&act=list'">Danh sách</button>
        <div style="clear:both;margin-bottom:10px"></div>

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"><?php echo ($id > 0) ? "Cập nhật" : "Thêm mới" ?> dịch vụ</h3>

            </div><!-- /.box-header -->
            <div class="box-body">
            <!-- form start -->
            <form role="form" method="post" action="controller/Services.php">
                <?php if($id> 0){ ?>
                <input type="hidden" value="<?php echo $id; ?>" name="id" />
                <?php } ?>
                
                    <div class="form-group">
                        <label for="name">Tên</label>
                        <input  value="<?php echo isset($detail['name'])  ? $detail['name'] : "" ?>" type="text" name="name" id="name" class="form-control required">
                    </div>
                        
             
                    <div class="form-group">
                        <label for="name">Giá mặc định</label>
                        <input  value="<?php echo isset($detail['price'])  ? $detail['price'] : "" ?>" type="text" name="price" id="price" class="form-control">
                    </div>
               
                    <div class="form-group">
                            <label>Tính tiền theo</label>
                            <select class="form-control" name="cal_type">
                                <option value='0'>--chọn--</option>
                                <option value='1' <?php if(isset($detail['cal_type']) && $detail['cal_type'] == 1) echo "selected"; ?>>Phòng</option>
                                <option value='2' <?php if(isset($detail['cal_type']) && $detail['cal_type'] == 2) echo "selected"; ?>>Số lượng người</option>
                                <option value='3' <?php if(isset($detail['cal_type']) && $detail['cal_type'] == 3) echo "selected"; ?>>Số lượng sử dụng</option>
                            </select>
                        </div>
                </div>
                <div class="box-footer">
                     <button class="btn btn-primary btnSave" type="submit">Save</button>
                     <button class="btn btn-primary" type="reset" onclick="location.href='index.php?mod=services&act=list'">Cancel</button>
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
