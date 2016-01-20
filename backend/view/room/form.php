<?php
$id = $city_id = 0;
$addonArr = $model->getList('addon', -1, -1);
$convenientArr = $model->getList('convenient', -1, -1);
$serviceArr = $model->getList('services', -1, -1);
$arrAddonSelected = array();
$imageArr = array();
$detail = $arrAddonSelected = array();
if(isset($_GET['id'])){
    $id = (int) $_GET['id'];    
    $detail = $model->getDetail("objects", $id);
    $arrAddonSelected = $model->getListInfoObject($id, 1);
    $arrConvenientSelected = $model->getListInfoObject($id, 2);
    $imageArr = $model->getChild("images", "object_id", $id, 2);
    $city_id = $detail['city_id'];
}
if($city_id > 0){
    $arrCustomList['city_id'] = $city_id;
}
$cityArr = $model->getList('city', -1, -1);
$districtArr = $model->getList('district', -1, -1, $arrCustomList);
//var_dump($districtArr);die;
$wardArr = $houseArr = array();
if(isset($detail['district_id']) && $detail['district_id'] > 0){
    $arrCustomWard['district_id'] = $detail['district_id'];
    $wardArr = $model->getList('ward', -1, -1, $arrCustomWard);
}
if(isset($detail['ward_id']) && $detail['ward_id'] > 0){
    $arrCustomHouse['ward_id'] = $detail['ward_id'];
    $houseArr = $model->getList('house', -1, -1, $arrCustomHouse);
}
$arrTypeBDS = $model->getChild('type_bds','type', 1);  
$priceArr = $model->getList('price', -1, -1, array('type' => 1));
?>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="js/ajaxupload.js"></script>
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

    
    <?php if($id){ ?>
    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>"/>
    <?php } ?>
    <div class="col-md-12">

        <!-- Custom Tabs -->

        <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=house&act=list'">Danh sách</button>
        <form method="post" action="controller/Room.php">
         
        <div style="clear:both;margin-bottom:10px"></div>

         <div class="box-header">

            <h3 class="box-title"><?php echo (isset($id) && $id > 0) ? "Cập nhật" : "Tạo mới" ?> phòng </h3>
            <?php if($id > 0){ ?>
            <input type="hidden" value="<?php echo $id; ?>" name="id" />
            <?php } ?>
        </div><!-- /.box-header -->
        <div class="col-md-7">
        <div class="nav-tabs-custom">
            <input type="hidden" value="1" name="object_type" />            
            <div class="button">

                <div class="row">
                    <div class="col-md-12">
                            <div class="form-group">
                                <label>Loại BĐS</label>
                                <select class="form-control" name="type_id" id="type_id">
                                    <option value="0">---chọn---</option>
                                    <?php foreach($arrTypeBDS as $v) { 
                                        if($v['id']!=5){
                                    ?>
                                    <option <?php echo (!empty($detail) && $detail['type_id'] == $v['id']) ? "selected" : ""; ?> value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
                                    <?php } } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tên phòng<span class="required"> ( * ) </span></label>
                                <input class="form-control" name="name" id="name" value="<?php if(isset($detail['name'])) echo $detail['name']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Diện tích<span class="required">  </span></label>
                                <input class="form-control" name="area" id="area" value="<?php if(isset($detail['area'])) echo $detail['area']; ?>">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Tỉnh / Thành<span class="required"> ( * ) </span></label>                        
                                <select class="form-control required select-change" data-table="district" data-child="district_id" name="city_id" id="city_id">
                                    <option value="0">---chọn---</option>
                                    <?php foreach($cityArr['data'] as $v) { ?>
                                    <option <?php echo (!empty($detail) && $detail['city_id']==$v['id']) ? "selected" : ""; ?> value="<?php echo $v['id']; ?>">
                                        <?php echo $v['name']; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>

                        </div>
                        <div class="col-md-6">

                            <div class="form-group">

                                <label>Quận/huyện<span class="required"> ( * ) </span></label>                                
                                <select class="form-control required select-change" data-table="ward" data-child="ward_id" name="district_id" id="district_id">
                                    <option value="0">---chọn---</option>
                                    <?php foreach($districtArr['data'] as $v) { ?>
                                    <option <?php echo (!empty($detail) && $detail['district_id'] == $v['id']) ? "selected" : ""; ?> value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
                                    <?php } ?>
                                </select>

                            </div>

                        </div>                     

                    </div>
                    <div class="row">                       

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Phường / Xã</label>
                                <select class="form-control select-change" data-table="house" data-child="house_id" name="ward_id" id="ward_id">
                                    <option value="0">---chọn---</option>
                                    <?php foreach($wardArr['data'] as $v) { ?>
                                    <option <?php echo (!empty($detail) && $detail['ward_id'] == $v['id']) ? "selected" : ""; ?> value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nhà</label>                                
                                <select class="form-control" name="house_id" id="house_id">
                                    <option value="0">---chọn---</option>
                                    <?php foreach($houseArr['data'] as $v) { ?>
                                    <option <?php echo (!empty($detail) && $detail['house_id'] == $v['id']) ? "selected" : ""; ?> value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                    </div>


                <div class="row">                    

                    <div class="col-md-6" >
                        <div class="form-group">
                            <label>Tầng</label>
                            <input type="text" name="floor" id="floor" class="form-control" value="<?php if(isset($detail['floor'])) echo $detail['floor']; ?>" />
                        </div>
                    </div>
                    <div class="col-md-6" >
                        <div class="form-group">
                            <label>Số người</label>
                            <input type="text" name="max_person" id="max_person" class="form-control" value="<?php if(isset($detail['max_person'])) echo $detail['max_person']; ?>" />
                        </div>
                    </div>                    
                     <div class="col-md-6" >
                        <div class="form-group">
                            <label>Giá thuê 1 tháng</label>
                            <input type="text" name="price_1" id="price_1" class="form-control number" value="<?php if(isset($detail['price_1'])) echo $detail['price_1']; ?>" />
                        </div>
                    </div>
                    <div class="col-md-6" >
                        <div class="form-group">
                            <label>Giá thuê 3 tháng</label>
                            <input type="text" name="price_3" id="price_3" class="form-control number" value="<?php if(isset($detail['price_3'])) echo $detail['price_3']; ?>" />
                        </div>
                    </div>
                     <div class="col-md-6" >
                        <div class="form-group">
                            <label>Giá thuê 6 tháng</label>
                            <input type="text" name="price_6" id="price_6" class="form-control number" value="<?php if(isset($detail['price_6'])) echo $detail['price_6']; ?>" />
                        </div>
                    </div>
                     <div class="col-md-6">
                        <div class="form-group">
                            <label>Khoảng giá<span class="required"> ( * ) </span></label>
                            <select class="form-control" name="price_id" id="price_id">
                                <option value="0">---chọn---</option>
                                <?php foreach($priceArr['data'] as $v) { ?>
                                <option <?php echo (!empty($detail) && $detail['price_id'] == $v['id']) ? "selected" : ""; ?> value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6" >
                        <div class="form-group">
                            <label>Đặt cọc</label>
                            <input type="text" name="deposit" id="deposit" class="form-control number" value="<?php if(isset($detail['deposit'])) echo $detail['deposit']; ?>" />
                        </div>
                    </div>                   
                    

                    <div class="col-md-12" >
                        <div class="form-group">
                            <label>Link Video (Youtube)</label>
                            <input type="text" name="video_url" id="video_url" class="form-control" value="<?php if(isset($detail['video_url'])) echo $detail['video_url']; ?>"/>                            
                        </div>
                    </div>

                
                </div>
            </div>


        </div><!-- nav-tabs-custom -->        
        </div>        
        <div class="col-md-12 nav-tabs-custom">
            <div class="row">
                <div class="form-group col-md-12" style="padding-top:5px">
                    <label>Hình ảnh</label>
                    <button class="btn btn-primary" type="button" id="btnUpload" style="margin-bottom:10px">Upload</button>
                    <div id="load_hinh">

                    </div>
                    <?php if(isset($imageArr) && !empty($imageArr)){ ?>
                    <div id="images_post">
                        <?php foreach ($imageArr as $v) {
                            $checked = $v['url'] == $detail['image_url'] ? "checked='checked'" :  "";
                            ?>
                        <div class="col-md-2 image_upload" id="img_<?php echo $v['id']; ?>" style="border: 1px solid #CCC; padding: 10px;margin-right:2px;min-height:240px">
                            <img class="img-thumbnail lazy" data-original="../<?php echo $v['url']; ?>" width="150"><br />
                            <p style="width:50%;float:left;margin-top:10px">
                                <input type="radio" <?php echo $checked; ?> name="image_url" value="<?php echo $v['url']; ?>" id="daidien_<?php echo $v['id']; ?>" /> Ảnh đại diện
                            </p>
                            <p style="width:50%;float:left;text-align:right;margin-top:10px">
                                <span class="del_img" style="cursor:pointer" data-value="<?php echo $v['id']; ?>">Xóa</span>
                            </p>
                        </div>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>
                <div class="form-group col-md-12" style="padding-top:5px">

                    <label>Tiện ích đi kèm &nbsp;</label>
                                <br />
                    <?php $i = 0 ; foreach ($addonArr['data'] as $ser) { $i ++;
                        ?>
                       <div class="col-md-2" style="margin-bottom:10px">
                        <input type="checkbox" name="addon[]" <?php if(isset($arrAddonSelected) && in_array($ser['id'], $arrAddonSelected)) echo "checked"; ?> class="services" value="<?php echo $ser['id']; ?>"/> <?php echo $ser['name']; ?>  &nbsp;&nbsp;&nbsp;&nbsp;
                       </div>


                        <?php
                    }

                    ?>

                </div>
                <div class="form-group col-md-12" style="padding-top:5px">

                    <label>Tiện nghi có sẵn &nbsp;</label>
                                <br />
                    <?php $i = 0 ; foreach ($convenientArr['data'] as $ser) { $i ++;
                        ?>
                       <div class="col-md-2" style="margin-bottom:10px">
                        <input type="checkbox" name="convenient[]" <?php if(isset($arrConvenientSelected) && in_array($ser['id'], $arrConvenientSelected)) echo "checked"; ?> class="services" value="<?php echo $ser['id']; ?>"/> <?php echo $ser['name']; ?>  &nbsp;&nbsp;&nbsp;&nbsp;
                       </div>


                        <?php
                    }

                    ?>
                </div>
                
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Mô tả thêm</label>
                            <textarea name="description" id="content" class="form-control" rows="8"><?php if(isset($detail['description'])) echo $detail['description']; ?></textarea>

                        </div>
                    </div>           
                    

                </div>
            
                <div class="clearfix"></div>

            <div class="button">

                <button class="btn btn-primary btnSave" type="submit" >Save</button>

                <button class="btn btn-primary" type="button" onclick="location.href='index.php?mod=house&act=list'">Cancel</button>

            </div>

        </div>
   

    </form>

</div>
<link href="<?php echo STATIC_URL; ?>css/jquery-ui.css" rel="stylesheet" type="text/css" />
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

<script type="text/javascript">
$(document).ready(function(){  
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
    height:200,    
    skin:'office2003',
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