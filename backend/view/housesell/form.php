<?php
$id = $city_id = 0;
$addonArr = $model->getList('addon', -1, -1);
$arrAddonSelected = array();

$directionArr = $model->getList('direction', -1, -1);
$purposeArr = $model->getList('purpose', -1, -1);
$imageArr = array();
$detail = $arrAddonSelected = $arrPurposeSelected = array();
if(isset($_GET['id'])){
    $id = (int) $_GET['id'];    
    $detail = $model->getDetail("objects", $id);
    $arrAddonSelected = $model->getListInfoObject($id, 1);
    $arrPurposeSelected = $model->getListRelation("house_purpose", "purpose_id", "house_id", $id);
    $imageArr = $model->getChild("images", "object_id", $id, 4);    
    $city_id = $detail['city_id'];
}
if($city_id > 0) $arrCustomList['city_id'] = $city_id;
$cityArr = $model->getList('city', -1, -1);
$districtArr = $model->getList('district', -1, -1, $arrCustomList);
$typeArr = $model->getList('type_bds', -1, -1, array('type' => 2));
$priceArr = $model->getList('price', -1, -1, array('type' => 2));
$wardArr = array();
if(isset($detail['district_id']) && $detail['district_id']){
    $arrCustomWard['district_id'] = $detail['district_id'];
    $wardArr = $model->getList('ward', -1, -1, $arrCustomWard);
}
?>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
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

        <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=houserent&act=list'">Danh sách</button>
        <form method="post" action="controller/Room.php">
         
        <div style="clear:both;margin-bottom:10px"></div>

         <div class="box-header">

            <h3 class="box-title"><?php echo (isset($id) && $id > 0) ? "Cập nhật" : "Tạo mới" ?> nhà bán </h3>
            <?php if($id > 0){ ?>
            <input type="hidden" value="<?php echo $id; ?>" name="id" />
            <?php } ?>
        </div><!-- /.box-header -->
        <div class="nav-tabs-custom" style="background-color:#FFF">
            <div class="row">
                <div class="col-md-12">
            <div class="col-md-6">    
                <input type="hidden" name="object_type" value="3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Loại BĐS<span class="required"> ( * ) </span></label>
                            <select class="form-control" name="type_id" id="type_id">
                                <option value="0">---chọn---</option>
                                <?php foreach($typeArr['data'] as $v) { ?>
                                <option <?php echo (!empty($detail) && $detail['type_id']==$v['id']) ? "selected" : ""; ?> value="<?php echo $v['id']; ?>">
                                    <?php echo $v['name']; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Tên dự án</label>
                            <input class="form-control" name="project_name" id="project_name" value="<?php if(isset($detail['project_name'])) echo $detail['project_name']; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tên nhà<span class="required"> ( * ) </span></label>
                            <input class="form-control" name="name" id="name" value="<?php if(isset($detail['name'])) echo $detail['name']; ?>">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Diện tích<span class="required"> ( * ) </span></label>
                            <input class="form-control" name="area" id="area" value="<?php if(isset($detail['area'])) echo $detail['area']; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Giá bán<span class="required"> ( * ) </span></label>
                            <input class="form-control" name="price_sell" id="price_sell" value="<?php if(isset($detail['price_sell'])) echo $detail['price_sell']; ?>">
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
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Đường rộng trước nhà</label>
                            <input class="form-control" name="street" id="street" value="<?php if(isset($detail['street'])) echo $detail['street']; ?>">
                        </div>
                    </div>                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Số phòng ngủ<span class="required"> ( * ) </span></label>
                            <input class="form-control" name="no_room" id="no_room" value="<?php if(isset($detail['no_room'])) echo $detail['no_room']; ?>">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Số WC</label>
                            <input class="form-control" name="no_wc" id="no_wc" value="<?php if(isset($detail['no_wc'])) echo $detail['no_wc']; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Phương thức thanh toán</label>
                            <textarea name="payment" id="payment" rows="5" class="form-control"><?php if(isset($detail['payment'])) echo $detail['payment']; ?></textarea>                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pháp lý</label>
                            <textarea name="legal" id="legal" rows="5" class="form-control"><?php if(isset($detail['legal'])) echo $detail['legal']; ?></textarea>                            
                        </div>
                    </div>
                </div>   

                <div class="row">

                    <div class="col-md-12 ngaydi" >
                        <div class="form-group">
                            <label>Link Video (Youtube)</label>
                            <input type="text" name="video_url" id="video_url" class="form-control" value="<?php if(isset($detail['video_url'])) echo $detail['video_url']; ?>"/>                            
                        </div>
                    </div>

                </div>
                <div class="clearfix"></div>
            


            </div>
            <div class="col-md-6">
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Phường / Xã</label>
                            <select class="form-control" name="ward_id" id="ward_id">
                                <option value="0">---chọn---</option>
                                <?php foreach($wardArr['data'] as $v) { ?>
                                <option <?php echo (!empty($detail) && $detail['ward_id'] == $v['id']) ? "selected" : ""; ?> value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Hướng nhà</label>
                            <select class="form-control" name="direction_id" id="direction_id">
                                <option value="0">---chọn---</option>
                                <?php foreach($directionArr['data'] as $v) { ?>
                                <option <?php echo (!empty($detail) && $detail['direction_id'] == $v['id']) ? "selected" : ""; ?> value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Vị trí nhà</label>
                            <label class="radio-inline"><input type="radio" name="position_type" id="position_type_1" value="1"
                                <?php if(isset($detail['position_type']) && $detail['position_type'] == 1) echo "checked"; ?>
                                >Mặt tiền</label>
                            <label class="radio-inline"><input type="radio" name="position_type" id="position_type_2" value="2"
                                <?php if(isset($detail['position_type']) && $detail['position_type'] == 2) echo "checked"; ?>
                                >Hẻm</label>
                        </div>
                    </div>
                    
                    <div class="col-md-12" >
                        <div class="form-group">
                            <label>Địa chỉ</label>
                            <input type="text" name="address" id="address" class="form-control" value="<?php if(isset($detail['address'])) echo $detail['address']; ?>" />
                        </div>
                    </div>   
                </div>
            </div> <!--col-md-12-->
            </div>
        </div><!-- nav-tabs-custom -->

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
                            <img class="img-thumbnail" src="../<?php echo $v['url']; ?>" width="150"><br />
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
                
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Mô tả thêm</label>
                            <textarea name="description" id="description" class="form-control" rows="8"><?php if(isset($detail['description'])) echo $detail['description']; ?></textarea>

                        </div>
                    </div>
                    <input type="hidden" name="latitude" id="latitude" value="<?php echo $detail['latitude']; ?>" />
                    <input type="hidden" name="longitude" id="longitude" value="<?php echo $detail['longitude']; ?>" />
                    <div class="col-md-6">
                        <div class="form-group">
                                <label>Bản đồ</label>
                        <div id="panel" style="margin-left: -260px" style="line-height: normal">
                            <input id="searchTextField" type="text" size="50" style="height: 20px;">
                        </div>
                        <div id="map-canvas"></div>
                    </div>
                    

                </div>
                </div>
                <div class="nav-tabs-custom" style="margin-top:30px" >
                    <div class="button">

                        <div class="col-md-12" >

                            <h4 class="box-title">SEO information</h4>

                            <div class="form-group">

                                <label>Title</label>

                                <textarea name="meta_title" id="meta_title" class="form-control" rows="2"><?php if(!empty($detail)) echo $detail['meta_title']; ?></textarea>

                            </div>

                            <div class="form-group">

                                <label>Meta description</label>

                                <textarea name="meta_description" id="meta_description" class="form-control" rows="2"><?php if(!empty($detail)) echo $detail['meta_description']; ?></textarea>

                            </div>

                            <div class="form-group">

                                <label>Meta keyword</label>

                                <textarea name="meta_keyword" id="meta_keyword" class="form-control" rows="2"><?php if(!empty($detail)) echo $detail['meta_keyword']; ?></textarea>

                            </div>

                        </div>        

                    </div>  

                    <div style="clear:both"></div>

                </div><!-- nav-tabs-custom -->

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
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
     <style>
      #map-canvas, #map_canvas {
        height: 350px;
        width:100%;
    }

    @media print {
        html, body {
            height: auto;
        }

        #map-canvas, #map_canvas {
            height: 350px;
            width:100%;
        }
    }

    #panel {
        position: absolute;
        left: 60%;
        margin-left: -100px;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
    }
    input {
        border: 1px solid  rgba(0, 0, 0, 0.5);
    }
    input.notfound {
        border: 2px solid  rgba(255, 0, 0, 0.4);
    }
</style>

<script>
    var geocoder = new google.maps.Geocoder();

    function geocodePosition(pos) {
        geocoder.geocode({
            latLng: pos
        }, function(responses) {
        });
    }
    function initialize() {
        <?php if($id>0){ ?>
        var latLng = new google.maps.LatLng(<?php echo $detail['latitude']; ?>, <?php echo $detail['longitude']; ?>);
        <?php }else{ ?>
        var latLng = new google.maps.LatLng(10.753151, 106.73088499999994);
        <?php } ?>
        var mapOptions = {
            center: latLng,
            zoom: 17,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById('map-canvas'),
                mapOptions);
        var input = /** @type {HTMLInputElement} */(document.getElementById('searchTextField'));
        var autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.bindTo('bounds', map);

        var marker = new google.maps.Marker({
            map: map,
            position: latLng
        });
        geocodePosition(marker.getPosition());
            pos = marker.getPosition();

            var latitude = 0;
            var longitude = 0;
            var countIndex = 0;
            $.each(pos, function(index, value) {
                countIndex++;
                if(countIndex==1) latitude = value;
                if(countIndex==2) {longitude = value;return;}
            });

            geocoder.geocode({
                latLng: pos
            }, function(responses) {
                if (responses && responses.length > 0) {
                    $('#latitude').val(latitude);
                    $('#longitude').val(longitude);
                }
            });
        marker.setDraggable(true);
        geocodePosition(latLng);

        google.maps.event.addListener(marker, 'dragend', function() {
            geocodePosition(marker.getPosition());
            pos = marker.getPosition();


            var latitude = 0;
            var longitude = 0;
            var countIndex = 0;
            $.each(pos, function(index, value) {
                countIndex++;
                if(countIndex==1) latitude = value;
                if(countIndex==2) {longitude = value;return;}
            });


            geocoder.geocode({
                latLng: pos
            }, function(responses) {
                if (responses && responses.length > 0) {
                    $('#latitude').val(latitude);
                    $('#longitude').val(longitude);
                }
            });
        });

        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            marker.setVisible(false);
            input.className = '';
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                // Inform the user that the place was not found and return.
                input.className = 'notfound';
                return;
            }

            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);  // Why 17? Because it looks good.
            }
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

            // geocodePosition(marker.getPosition());
            pos = marker.getPosition();

            var latitude = 0;
            var longitude = 0;
            var countIndex = 0;
            $.each(pos, function(index, value) {
                    countIndex++;
                    if(countIndex==1) latitude = value;
                    if(countIndex==2) {longitude = value;return;}
            });


            geocoder.geocode({
                latLng: pos
            }, function(responses) {
                if (responses && responses.length > 0) {
                    $('#latitude').val(latitude);
                    $('#longitude').val(longitude);
                }
            });
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize);

</script>
<script type="text/javascript">
$(document).ready(function(){
    $('#searchTextField').on('keypress', function(e) {
        return e.which !== 13;
    });
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
var editor = CKEDITOR.replace( 'description',{
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