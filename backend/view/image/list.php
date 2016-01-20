<?php
require_once "model/Image.php";
$model = new Image;
$link = "index.php?mod=image&act=list";

if (isset($_GET['nhaxe_id']) && $_GET['nhaxe_id'] > 0) {
    $nhaxe_id = (int) $_GET['nhaxe_id'];      
    $link.="&nhaxe_id=$nhaxe_id";
} else {
    $nhaxe_id = -1;
}

require_once "model/Nhaxe.php";
$modelNhaxe = new Nhaxe;
$detailNhaxe = $modelNhaxe->getDetailNhaxe($nhaxe_id);

$listTotal = $model->getListImageByNhaxe($nhaxe_id, -1, -1);

$total_record = mysql_num_rows($listTotal);

$total_page = ceil($total_record / 8);

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

$offset = 8 * ($page - 1);

$list = $model->getListImageByNhaxe($nhaxe_id, $offset, 8);

?>
<div class="row">
    <div class="col-md-12">
    <button class="btn btn-primary btn-sm right" 
    onclick="location.href='index.php?mod=nhaxe&act=form&nhaxe_id=<?php echo $nhaxe_id; ?>'">Chi tiết</button>
     <button class="btn btn-primary btn-sm right" 
    onclick="location.href='index.php?mod=branch&act=list&nhaxe_id=<?php echo $nhaxe_id; ?>'">Chi nhánh</button>        
         <div class="box-header">
                <h3 class="box-title">Danh sách hình ảnh nhà xe : <?php echo $detailNhaxe['nhaxe_name_vi']; ?> ( <?php echo $total_record; ?> ảnh )</h3>
            </div><!-- /.box-header -->
        <div class="box">
           
            <div class="box-body">
                <p style="color:red;font-size:20px">Kích thước upload chuẩn : 700 x 450px</p>
                <?php
                    $i = ($page-1) * 8;;
                    while ($row = mysql_fetch_assoc($list)) {                       
                    $i++;
                    ?>
                    <div style="float:left;height:107px;margin:10px;text-align:center">
                        <img src="<?php echo "../".$row['image_url']; ?>" height="107" />
                        <br />
                        <p>
                            <a href="javascript:;" alias="ảnh" id="<?php echo $row['image_id']; ?>" mod="image" class="link_delete" >    
                                <i class="fa fa-fw fa-trash-o"></i>
                            </a>    
                        </p>
                    </div>
                    <?php } ?>                
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
                <!--
                <ul class="pagination pagination-sm no-margin pull-right">
                    <li><a href="#">«</a></li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">»</a></li>
                </ul>-->
                <?php echo $model->phantrang($page, PAGE_SHOW, $total_page, $link); ?>
            </div>
            <div class="button">
                <button class="btn btn-primary btnSave" id="btnUpload" type="button">Upload hình ảnh</button>                
            </div>
            <div class="button">                
                <input type="hidden" name="nhaxe_id" id="nhaxe_id" value="<?php echo $nhaxe_id; ?>"/>
                <div id="hinhanh"></div>
                <div style="clear:both"></div>
                <div class="button" id="btnSaveImage" style="display:none">
                    <button class="btn btn-primary" id="btnSaveImageToNhaXe" type="button">Save</button>                
                </div>                
            </div>
        </div><!-- /.box -->                           
    </div><!-- /.col -->
   
</div>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<div id="div_upload" style="display:none">
    <form id="upload_images" method="post" enctype="multipart/form-data" enctype="multipart/form-data" action="controller/Upload.php">
        <div style="margin: auto;">       
            <div style="text-align:center"><img src="static/img/add.jpg" id="add_images" width="32" title="Thêm hình ảnh" alt="Thêm hình ảnh" /></div>
            <div id="wrapper_input_files">
                <input type="file" name="images[]" /><br />
                <input type="file" name="images[]" /><br />
                <input type="file" name="images[]" /><br />
            </div>            
            <div class="clear"></div>
            <button class="btn btn-danger btn-sm"  type="submit" id="btn_upload_images">Upload</button>       
               
        </div>
        
    </form>
</div>