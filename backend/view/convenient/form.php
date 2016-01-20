<?php
$id = 0;
if(isset($_GET['id'])){
    $id = (int) $_GET['id'];
    require_once "model/Backend.php";
    $model = new Backend;
    $detail = $model->getDetail("convenient",$id);
}
?>
<div class="row">
    <div class="col-md-8">

        <!-- Custom Tabs -->
        <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=convenient&act=list'">Danh sách</button>
        <div style="clear:both;margin-bottom:10px"></div>

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"><?php echo ($id > 0) ? "Cập nhật" : "Thêm mới" ?> tiện nghi</h3>

            </div><!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="post" action="controller/Convenient.php" enctype="multipart/form-data">
                <?php if($id> 0){ ?>
                <input type="hidden" value="<?php echo $id; ?>" name="id" />
                <?php } ?>
                <div class="box-body">
                    <div class="form-group">
                        <label for="name">Tên</label>
                        <input  value="<?php echo isset($detail['name'])  ? $detail['name'] : "" ?>" type="text" name="name" id="name" class="form-control required">
                    </div>
                </div><!-- /.box-body -->
                <div class="box-body">
                    <div class="form-group">
                        <label for="name">Giá / tháng</label>
                        <input  value="<?php echo isset($detail['price'])  ? $detail['price'] : "" ?>" type="text" name="price" id="price" class="form-control required number">
                    </div>
                </div><!-- /.box-body -->
                <div class="box-body">
                    <div class="form-group">
                        <label for="name">Mô tả thêm</label>
                        <textarea  name="description" id="description" class="form-control" rows="5"><?php echo isset($detail['description'])  ? $detail['description'] : "" ?></textarea>
                    </div>
                </div><!-- /.box-body -->                
                <div class="box-body">
                    <div class="form-group">
                        <label>Hình ảnh</label>
                        <input type="radio" id="choose_img_sv" name="choose_img" value="1" checked="checked"/> Chọn ảnh từ server
                        &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="choose_img_cp" name="choose_img" value="2" /> Chọn ảnh từ máy tính
                        <div id="from_sv">
                            <input type="hidden" name="image_url" id="image_url" class="form-control" value="<?php if(!empty($detail['image_url'])) echo "../".$detail['image_url']; ?>" /><br />
                            <?php if(!empty($detail['image_url'])){ ?>
                            <img id="img_thumnails" src="../<?php echo $detail['image_url']; ?>" height="100" />
                            <?php }else{ ?>
                            <img id="img_thumnails" src="static/img/no_image.jpg" width="100" />
                            <?php } ?>
                            <button class="btn btn-default " type="button" onclick="BrowseServer('Images:/','image_url')" >Upload</button>
                        </div>
                        <div id="from_cp" style="display:none;padding:15px;margin-bottom:10px">
                            <input type="file" name="image_url_upload" />
                        </div>

                    </div>
                </div>
                <div class="box-footer">
                     <button class="btn btn-primary btnSave" type="submit">Save</button>
                     <button class="btn btn-primary" type="reset" onclick="location.href='index.php?mod=convenient&act=list'">Cancel</button>
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
