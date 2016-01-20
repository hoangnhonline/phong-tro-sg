<?php
require "model/Post.php";
$modelPost = new Post();

$arrProjectType = $modelPost->getListProjectType(-1,-1);
$arrDistrict = $modelPost->getListDistrict(1,-1,-1);
$project_id=-1;
$data = array();
if(isset($_GET['project_id'])){
    $project_id = (int) $_GET['project_id'];
    $detail = $modelPost->getDetailProject($project_id);
    $data = $detail['data'];
}
?>
<script type="text/javascript" src="static/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="static/ckfinder/ckfinder.js"></script>
<script type="text/javascript" src="static/js/ajaxupload.js"></script>
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
function SetFileField( fileUrl, data ){
    document.getElementById( data["selectActionData"] ).value = fileUrl;
    $('#hinh_dai_dien').attr('src', fileUrl).show();
}
</script>
<div class="row">

    <form method="post" action="controller/Project.php">
    <?php if($project_id){ ?>
    <input type="hidden" name="project_id" id="project_id" value="<?php echo $project_id; ?>"/>
    <?php } ?>
    <div class="col-md-7">

        <!-- Custom Tabs -->

        <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=project&act=list'">Danh sách dự án</button>

        <div style="clear:both;margin-bottom:10px"></div>

         <div class="box-header">

                <h3 class="box-title"><?php echo (isset($project_id) && $project_id > 0) ? "Cập nhật" : "Tạo mới" ?> dự án </h3>

            </div><!-- /.box-header -->



        <div class="nav-tabs-custom">

            <div class="button">

                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>Quận/huyện<span class="required"> ( * ) </span></label>
                                <input type="hidden" name="city_id" value="1" id="city_id">
                                <select class="form-control required" name="district_id" id="district_id">
                                    <option value="0">---chọn---</option>
                                    <?php foreach($arrDistrict['data'] as $v) { ?>
                                    <option <?php echo $data['district_id']==$v['district_id'] ? "selected" : ""; ?> value="<?php echo $v['district_id']; ?>"><?php echo $v['district_name']; ?></option>
                                    <?php } ?>
                                </select>

                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Loại dự án<span class="required"> ( * ) </span></label>
                                <select class="form-control required" name="project_type_id" id="project_type_id">
                                    <option value="0">---chọn---</option>
                                    <?php foreach($arrProjectType['data'] as $v) { ?>
                                    <option <?php echo $data['project_type_id']==$v['project_type_id'] ? "selected" : ""; ?> value="<?php echo $v['project_type_id']; ?>"><?php echo $v['project_type_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                    <div class="col-md-12 ngaydi" >
                        <div class="form-group">
                            <label>Tên dự án</label>
                            <input type="text" name="project_name" id="project_name" class="form-control" value="<?php if(isset($data['project_name'])) echo $data['project_name']; ?>" />
                        </div>
                    </div>
                    <div class="col-md-12 ngaydi" >
                        <div class="form-group">
                            <label>Địa chỉ</label>
                            <input type="text" name="address" id="address" class="form-control" value="<?php if(isset($data['address'])) echo $data['address']; ?>"/>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-6" >
                        <div class="form-group">
                            <label>Người liên hệ</label>
                            <input type="text" name="contact" id="contact" class="form-control" value="<?php if(isset($data['contact'])) echo $data['contact']; ?>" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">

                            <label>Số ĐT LH</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="<?php if(isset($data['phone'])) echo $data['phone']; ?>" />

                        </div>

                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12" >
                    <div class="checkbox" style="margin-bottom:20px">

                    <label class="">

                        <input type="checkbox" name="hot" value="1" <?php echo ($data['hot']==1) ? "checked" : ""; ?> />

                        <strong>Dự án HOT</strong>

                    </label>

                    </div>
                    </div>
                    <div class="col-md-12" >
                        <div class="form-group">
                            <label>Link Video (Youtube)</label>
                            <input type="text" name="video_url" id="video_url" class="form-control" value="<?php if(isset($data['video_url'])) echo $data['video_url']; ?>"/>
                            <input type="hidden" name="longt" id="longt" class="form-control" value="<?php if(isset($data['longt'])) echo $data['longt']; ?>"/>
                            <input type="hidden" name="latt" id="latt" class="form-control" value="<?php if(isset($data['latt'])) echo $data['latt']; ?>"/>
                        </div>
                    </div>
                </div>


            </div>


        </div><!-- nav-tabs-custom -->



    </div><!-- /.col -->

        <div class="col-md-5">

            <!-- Custom Tabs -->
            <div style="clear:both;margin-bottom:30px"></div>
             <div class="box-header">
                    <h3 class="box-title">&nbsp;</h3>
                </div><!-- /.box-header -->
            <div class="nav-tabs-custom" style="margin-top:30px" >

                <div class="button">



                </div>

            </div><!-- nav-tabs-custom -->
        </div><!-- /.col -->

        <div class="col-md-12 nav-tabs-custom">
            <div class="row">
                <div class="form-group col-md-12" style="padding-top:5px">
                    <label>Hình ảnh</label>
                    <button class="btn btn-primary" type="button" id="btnUpload" style="margin-bottom:10px">Upload</button>
                    <div id="load_hinh">

                    </div>
                    <?php if(isset($detail['images']) && $detail['images']){ ?>
                    <div id="images_post">
                        <?php foreach ($detail['images'] as $v) {
                            $checked = $v['url'] == $data['image_url'] ? "checked='checked'" :  "";
                            ?>
                        <div class="col-md-2 image_upload" id="img_<?php echo $v['image_id']; ?>">
                            <img src="../<?php echo $v['url_3']; ?>" width="150"><br />
                            <p style="width:70%;float:left;margin-top:10px">
                                <input type="radio" <?php echo $checked; ?> name="image_url" value="<?php echo $v['url']; ?>" id="daidien_<?php echo $v['image_id']; ?>" /> Ảnh đại diện
                            </p>
                            <p style="width:30%;float:left;text-align:right;margin-top:10px">
                                <span class="del_img" style="cursor:pointer" data-value="<?php echo $v['image_id']; ?>">Xóa</span>
                            </p>
                        </div>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Giới thiệu sơ lược</span></label>
                        <textarea name="description" id="description" class="form-control" rows="5"><?php if(isset($data['description'])) echo $data['description']; ?></textarea>

                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Nội dung chi tiết</span></label>
                        <textarea name="content" id="content" class="form-control" rows="10"><?php if(isset($data['content'])) echo $data['content']; ?></textarea>

                    </div>
                </div>
                </div>


            <div class="button">

                <button class="btn btn-primary btnSave" type="submit" >Save</button>

                <button class="btn btn-primary" type="reset">Cancel</button>

            </div>

        </div>

    </form>

</div>
<script src="js/form.js" type="text/javascript"></script>
<div id="div_upload" style="display:none">
    <div id="loading" style="display:none"><img src="img/loading.gif" width="470" /></div>
    <form id="upload_images" method="post" enctype="multipart/form-data" enctype="multipart/form-data" action="ajax.php">
        <div style="margin: auto;">
            <!---<img src="img/add.jpg" id="add_images" width="32" align="right" />           -->
            <div class="clear"></div>
            <div id="wrapper_input_files">
                <input type="file" name="images[]" /><br />
                <input type="file" name="images[]" /><br />
                <input type="file" name="images[]" /><br />
                <input type="file" name="images[]" /><br />
                <input type="file" name="images[]" /><br />
            </div>
            <?php if($detail){ ?>
                <input type="hidden" name="is_update" value="1" />
            <?php } ?>
            <button style="margin-top: 10px;" class="btn btn-primary" type="submit" id="btn_upload_images">Upload</button>
        </div>

    </form>
</div>
<div style="display: none" id="box_uploadimages">
    <div class="upload_wrapper block_auto">
        <div class="note" style="text-align:center;">Nhấn <strong>Ctrl</strong> để chọn nhiều hình.</div>
        <form id="upload_files_new" method="post" enctype="multipart/form-data" enctype="multipart/form-data" action="ajax/upload.php">
            <fieldset style="width: 100%; margin-bottom: 10px; height: 47px; padding: 5px;">
                <legend><b>&nbsp;&nbsp;Chọn hình từ máy tính&nbsp;&nbsp;</b></legend>
                <input style="border-radius:2px;" type="file" id="myfile" name="myfile[]" multiple />
                <div class="clear"></div>
                <div class="progress_upload" style="text-align: center;border: 1px solid;border-radius: 3px;position: relative;display: none;">
                    <div class="bar_upload" style="background-color: grey;border-radius: 1px;height: 13px;width: 0%;"></div >
                    <div class="percent_upload" style="color: #FFFFFF;left: 140px;position: absolute;top: 1px;">0%</div >
                </div>
            </fieldset>
        </form>
    </div>
</div>
<link href="<?php echo STATIC_URL; ?>css/jquery-ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
$(function(){
   $('span.del_img').click(function(){
        var img_id = $(this).attr('data-value');
        if($("#daidien_" + img_id).is(":checked")){
            alert("Chọn ảnh khác làm ảnh đại diện trước khi xóa ảnh này.");
            return false;
        }else{
            if(confirm("Chắc chắn xóa ảnh này?")){
                $.ajax({
                    url: "controller/Delete.php",
                    type: "POST",
                    async: true,
                    data: {
                        'id' : img_id,
                        'mod' : 'images'
                    },
                    success: function(data){
                        $('#img_' + img_id).remove();
                    }
                });


            }else{
                return false;
            }
        }
   });
   $('#upload_images').ajaxForm({
            beforeSend: function() {
            },
            uploadProgress: function(event, position, total, percentComplete) {
                $('#loading').show();
                $('#upload_images').hide();
            },
            complete: function(res) {
                var data  = JSON.parse(res.responseText);
                //window.location.reload();
                $( "#div_upload" ).dialog('close');
                $('#btnSaveImage').show();
                $('#load_hinh').html(data.html);
                $('#load_hinh').append(data.str_image);
                $('#loading').hide();
                $('#upload_images').show();
            }
        });
        $("#btnUpload").click(function(){
            $("#div_upload" ).dialog({
                modal: true,
                title: 'Upload images',
                width: 500,
                draggable: true,
                resizable: false,
                position: "center middle"
            });
        });
        $("#add_images").click(function(){
            $( "#wrapper_input_files" ).append("<input type='file' name='images[]' /><br />");
        });
        $("#btnXoa").click(function(){
        if(confirm('Bạn có chắc chắn xóa ảnh bìa này ?')){
            $("#url_image_old, #url_image" ).val('');
            $('#imgHinh').attr('src','');
            }
        });
});

</script>
<script type="text/javascript">
var editor = CKEDITOR.replace( 'content',{
    uiColor : '#9AB8F3',
    language:'vi',
    height:400,
    width:800,
    skin:'kama',
        filebrowserFlashBrowseUrl: 'ckfinder/ckfinder.html?Type=Flash',
        filebrowserFlashUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
    toolbar:[
    ['Source','-','Save','NewPage','Preview','-','Templates'],
    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
    ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
    ['Link','Unlink','Anchor'],['Maximize', 'ShowBlocks','-','About']
    ['Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
    ['Styles','Format','Font','FontSize'],
    ['TextColor','BGColor'],

    ]
});
</script>