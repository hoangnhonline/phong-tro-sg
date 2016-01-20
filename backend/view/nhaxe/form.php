<?php 
if(isset($_GET['nhaxe_id'])){
    $nhaxe_id = (int) $_GET['nhaxe_id'];
    require_once "model/Nhaxe.php";
    $model = new Nhaxe;
    $detail = $model->getDetailNhaxe($nhaxe_id);    
}
?>
<script type="text/javascript" src="static/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="static/ckfinder/ckfinder.js"></script>
<script type="text/javascript">
function BrowseServer( startupPath, functionData ){    
    var finder = new CKFinder();
    finder.basePath = 'ckfinder/'; //Đường path nơi đặt ckfinder
    finder.startupPath = startupPath; //Đường path hiện sẵn cho user chọn file
    finder.selectActionFunction = SetFileField; // hàm sẽ được gọi khi 1 file được chọn
    finder.selectActionData = functionData; //id của text field cần hiện địa chỉ hình
    //finder.selectThumbnailActionFunction = ShowThumbnails; //hàm sẽ được gọi khi 1 file thumnail được chọn    
    finder.popup(); // Bật cửa sổ CKFinder
} //BrowseServer
function BrowseServer2( startupPath, functionData ){    
    var finder = new CKFinder();
    finder.basePath = 'ckfinder/'; //Đường path nơi đặt ckfinder
    finder.startupPath = startupPath; //Đường path hiện sẵn cho user chọn file
    finder.selectActionFunction = SetFileField2; // hàm sẽ được gọi khi 1 file được chọn
    finder.selectActionData = functionData; //id của text field cần hiện địa chỉ hình
    //finder.selectThumbnailActionFunction = ShowThumbnails; //hàm sẽ được gọi khi 1 file thumnail được chọn    
    finder.popup(); // Bật cửa sổ CKFinder
} //BrowseServer

function SetFileField( fileUrl, data ){
    document.getElementById( data["selectActionData"] ).value = fileUrl;
    $('#hinh_dai_dien').attr('src', fileUrl).show();
}
function SetFileField2( fileUrl, data ){
    document.getElementById( data["selectActionData"] ).value = fileUrl;
    $('#thumbnail_url_input').attr('src', fileUrl).show();
}
</script>
<div class="row">
    <div class="col-md-8">
        <form method="post" action="controller/Nhaxe.php">            
        <!-- Custom Tabs -->
        <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=nhaxe&act=list'">Danh sách nhà xe</button>
        <div style="clear:both;margin-bottom:10px"></div>
         <div class="box-header">
                <h3 class="box-title"><?php echo ($nhaxe_id > 0) ? "Cập nhật" : "Tạo mới" ?> nhà xe <?php echo ($nhaxe_id > 0) ? " : ".$detail['nhaxe_name_vi'] : ""; ?></h3>
                <?php if($nhaxe_id> 0){ ?>
                <input type="hidden" value="<?php echo $nhaxe_id; ?>" name="nhaxe_id" />
                <?php } ?>
            </div><!-- /.box-header -->
        <div class="nav-tabs-custom">

            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab_1">
                    <img src="<?php echo STATIC_URL?>img/vi.png"/>
                </a></li>
                <li class=""><a data-toggle="tab" href="#tab_2">
                    <img src="<?php echo STATIC_URL?>img/uk_.png"/>
                </a></li>              
                <li class="pull-right"><a class="text-muted" href="#"><i class="fa fa-gear"></i></a></li>
            </ul>
            <div class="tab-content">
                <div id="tab_1" class="tab-pane active">
                    <div class="form-group">
                        <label>Tên nhà xe <span class="required"> ( * ) </span></label>
                        <input type="text" name="nhaxe_name_vi" class="form-control required" value="<?php echo isset($detail['nhaxe_name_vi'])  ? $detail['nhaxe_name_vi'] : "" ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ (trụ sở chính)<span class="required"> ( * ) </span></label>
                        <textarea rows="3" class="form-control required" name="address_vi"><?php if(isset($detail['address_vi'])) echo $detail['address_vi']; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Giới thiệu <span class="required"> ( * ) </span></label>                        
                        <textarea rows="5" class="form-control required" name="description_vi"><?php if(isset($detail['description_vi'])) echo $detail['description_vi']; ?></textarea>
                    </div>
                   
                </div><!-- /.tab-pane -->
                <div id="tab_2" class="tab-pane">
                    <div class="form-group">
                        <label>Tên nhà xe <span class="required"> ( * ) </span></label>
                        <input type="text" name="nhaxe_name_en" class="form-control required" value="<?php echo isset($detail['nhaxe_name_en'])  ? $detail['nhaxe_name_en'] : "" ?>">
                    </div>
                    <div class="form-group">
                        <label>Địa chỉ  (trụ sở chính)<span class="required"> ( * ) </span></label>
                        <textarea rows="3" class="form-control required" name="address_en"><?php if(isset($detail['address_en'])) echo $detail['address_en']; ?></textarea>                       
                    </div>
                    <div class="form-group">
                        <label>Giới thiệu <span class="required"> ( * ) </span></label>                        
                        <textarea rows="5" class="form-control required" name="description_en"><?php if(isset($detail['description_en'])) echo $detail['description_en']; ?></textarea>
                    </div>
                </div><!-- /.tab-pane -->
            </div><!-- /.tab-content -->
            <div class="button">
                <div class="checkbox" style="margin-bottom:20px">
                <label class="">
                    <input type="checkbox" name="hot" value="1" <?php echo ($detail['hot']==1) ? "checked" : ""; ?> />               
                    <strong>NHÀ XE UY TÍN</strong>
                </label>                                                
                </div>
                <div class="form-group">
                    <label>Số điện thoại <span class="required"> ( * ) </span></label>
                    <input type="text" name="phone" class="form-control required" value="<?php echo isset($detail['phone'])  ? $detail['phone'] : "" ?>">
                </div>
                <div class="form-group">
                    <p style="color:red;font-size:20px">Logo chuẩn : 150 x 100px<br />
                        Hình đại diện chuẩn : 540 x 375px<br /></p>
                    <label>Logo &nbsp;&nbsp;&nbsp;</label>
                    <input type="hidden" name="image_url" id="image_url" class="form-control" value="<?php echo isset($detail['image_url'])  ? $detail['image_url'] : "" ?>">
                    <img src="<?php echo isset($detail['image_url'])  ? "../".$detail['image_url'] : "" ?>" id="hinh_dai_dien" width="200" style="<?php echo isset($detail['image_url'])  ? "" : "display:none;" ?>margin-top:5px"/>
                    <button class="btn btn-primary" type="button" onclick="BrowseServer('Images:/','image_url')" >Chọn ảnh</button>
                </div>
                <div class="form-group">
                    <label>Hình đại diện &nbsp;&nbsp;&nbsp;</label>
                    <input type="hidden" name="thumbnail_url" id="thumbnail_url" class="form-control" value="<?php echo isset($detail['thumbnail_url'])  ? $detail['thumbnail_url'] : "" ?>">
                    
                    <img src="<?php echo  "../".$detail['thumbnail_url']; ?>" id="thumbnail_url_input" width="400" style="<?php echo isset($detail['thumbnail_url'])  ? "" : "display:none;" ?>margin-top:5px"/>
                    
                    <button class="btn btn-primary" type="button" onclick="BrowseServer2('Images:/','thumbnail_url')" >Chọn ảnh</button>
                </div>
            </div>
            <div class="button">
                <button class="btn btn-primary btnSave" type="submit">Save</button>
                <button class="btn btn-primary" type="reset">Cancel</button>
            </div>
           
        </div><!-- nav-tabs-custom -->
    </form>
    </div><!-- /.col --> 
</div>