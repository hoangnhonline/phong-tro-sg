<?php
require "model/Post.php";
$modelPost = new Post();

$arrEstateType = $modelPost->getListEstateType(-1,-1);
$arrProjectType = $modelPost->getListProjectType(-1,-1);
$arrLegal = $modelPost->getListLegal(-1,-1);
$arrDirection = $modelPost->getListDirection(-1,-1);
$arrPrice = $modelPost->getListPrice(-1,-1);
$arrArea = $modelPost->getListArea(-1,-1);
$arrAddon = $modelPost->getListAddon(-1,-1);
$arrDistrict = $modelPost->getListDistrict(1,-1,-1);
$post_id=-1;
$data = $arrAddonSelected = array();
if(isset($_GET['post_id'])){
    $post_id = (int) $_GET['post_id'];
    $detail = $modelPost->getDetailPost($post_id);
    $data = $detail['data'];
    $arrAddonSelected = $detail['addon'];
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

    <form method="post" action="controller/Userpost.php">
    <?php if($post_id){ ?>
    <input type="hidden" name="post_id" id="post_id" value="<?php echo $post_id; ?>"/>
    <?php } ?>
    <div class="col-md-7">

        <!-- Custom Tabs -->

        <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=ticket&act=list'">Danh sách tin</button>

        <div style="clear:both;margin-bottom:10px"></div>

         <div class="box-header">

                <h3 class="box-title"><?php echo (isset($post_id) && $post_id > 0) ? "Cập nhật" : "Tạo mới" ?> tin </h3>

            </div><!-- /.box-header -->



        <div class="nav-tabs-custom">

            <div class="button">
                <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label><span style="color:red">Trạng thái</span><span class="required"> ( * ) </span></label>
                                <select class="form-control required" name="status" id="status">
                                    <option value="0">---chọn---</option>
                                    <option value="1" <?php echo $data['status']==1 ? "selected" : ""; ?>>Duyệt</option>
                                    <option value="3" <?php echo $data['status']==3 ? "selected" : ""; ?>>Không duyệt</option>
                                </select>
                            </div>
                        </div>

                    </div>
                <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Loại tin<span class="required"> ( * ) </span></label>
                                <select class="form-control required" name="type_id" id="type_id">
                                    <option value="0">---chọn---</option>
                                    <option value="1" <?php echo $data['type_id']==1 ? "selected" : ""; ?>>Cần bán</option>
                                    <option value="2" <?php echo $data['type_id']==2 ? "selected" : ""; ?>>Cho thuê</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Loại nhà đất<span class="required"> ( * ) </span></label>
                                <select class="form-control required" name="estate_type_id" id="estate_type_id">
                                    <option value="0">---chọn---</option>
                                    <?php foreach($arrEstateType['data'] as $v) { ?>
                                    <option <?php echo $data['estate_type_id']==$v['estate_type_id'] ? "selected" : ""; ?> value="<?php echo $v['estate_type_id']; ?>"><?php echo $v['estate_type_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                        </div>

                    </div>
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
                                <label>Dự án</label>
                                <select class="form-control" name="project_type_id" id="project_type_id">
                                    <option value="0">---chọn---</option>
                                    <?php foreach($arrProjectType['data'] as $v) { ?>
                                    <option <?php echo $data['project_type_id']==$v['project_type_id'] ? "selected" : ""; ?> value="<?php echo $v['project_type_id']; ?>"><?php echo $v['project_type_name']; ?></option>
                                    <?php } ?>
                                </select>
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

                    <div class="col-md-12 ngaydi" >
                        <div class="form-group">
                            <label>Tiêu đề tin</label>
                            <input type="text" name="post_title" id="post_title" class="form-control" value="<?php if(isset($data['post_title'])) echo $data['post_title']; ?>" />
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12 ngaydi" >
                        <div class="form-group">
                            <label>Địa chỉ BĐS</label>
                            <input type="text" name="address" id="address" class="form-control" value="<?php if(isset($data['address'])) echo $data['address']; ?>"/>
                        </div>
                    </div>
                    <div class="col-md-12 ngaydi" >
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
                    <div class="row">

                    <div class="col-md-6">

                        <div class="form-group">

                            <label>Hướng</label>

                            <select class="form-control" name="direction_id" id="direction_id">

                                <option value="0">---chọn---</option>
                                <?php foreach($arrDirection['data'] as $v) { ?>
                                    <option <?php echo $data['direction_id']==$v['direction_id'] ? "selected" : ""; ?> value="<?php echo $v['direction_id']; ?>"><?php echo $v['direction_name']; ?></option>
                                <?php } ?>
                            </select>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group">

                            <label>Pháp lý</label>

                            <select class="form-control" name="legal_id" id="legal_id">

                                <option value="0">---chọn---</option>
                                <?php foreach($arrLegal['data'] as $v) { ?>
                                    <option <?php echo $data['legal_id']==$v['legal_id'] ? "selected" : ""; ?> value="<?php echo $v['legal_id']; ?>"><?php echo $v['legal_name']; ?></option>
                                <?php } ?>

                            </select>

                        </div>

                    </div>

                    </div>

                    <div class="row">

                    <div class="col-md-4">

                        <div class="form-group">

                            <label>Khoảng giá<span class="required"> ( * ) </span></label>

                            <select class="form-control required" name="price_id" id="price_id">

                                <option value="0">---chọn---</option>
                                <?php foreach($arrPrice['data'] as $v) { ?>
                                    <option <?php echo $data['price_id']==$v['price_id'] ? "selected" : ""; ?> value="<?php echo $v['price_id']; ?>"><?php echo $v['price_name']; ?></option>
                                <?php } ?>
                            </select>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="form-group">

                            <label>Giá<span class="required"> ( * ) </span></label>
                            <input name="price" id="price" class="form-control" value="<?php if(isset($data['price'])) echo $data['price']; ?>"/>

                        </div>

                    </div>
                    <div class="col-md-4">

                        <div class="form-group">

                            <label>Tính theo<span class="required"> ( * ) </span></label>
                            <select class="form-control required" name="cal_type" id="cal_type">
                                <option value="0">---chọn---</option>
                                <option <?php echo $data['cal_type']==1 ? "selected" : ""; ?> value="1">m2</option>
                                <option <?php echo $data['cal_type']==2 ? "selected" : ""; ?> value="2">Tổng diện tích</option>
                            </select>

                        </div>

                    </div>

                    </div>
                    <div class="row">

                    <div class="col-md-6">

                        <div class="form-group">

                            <label>Khoảng DT<span class="required"> ( * ) </span></label>

                            <select class="form-control required" name="area_id" id="area_id">

                                <option value="0">---chọn---</option>
                                <?php foreach($arrArea['data'] as $v) { ?>
                                    <option <?php echo $data['area_id']==$v['area_id'] ? "selected" : ""; ?> value="<?php echo $v['area_id']; ?>"><?php echo $v['area_name']; ?></option>
                                <?php } ?>
                            </select>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group">

                            <label>Diện tích (m2)<span class="required"> ( * ) </span></label>

                            <input name="total_area" id="total_area" class="form-control" value="<?php if(isset($data['total_area'])) echo $data['total_area']; ?>"/>

                        </div>

                    </div>

                    </div>

                 <div class="row">

                    <div class="col-md-6">

                        <div class="form-group">

                            <label>Chiều ngang ( m )</span></label>

                            <input name="horizontal" id="horizontal" class="form-control" value="<?php if(isset($data['horizontal'])) echo $data['horizontal']; ?>" />

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group">

                            <label>Chiều dài ( m ) </span></label>

                            <input name="lengths" id="lengths" class="form-control" value="<?php if(isset($data['lengths'])) echo $data['lengths']; ?>" />

                        </div>

                    </div>

                    </div>

                    <div class="row">

                    <div class="col-md-4">

                        <div class="form-group">

                            <label>Đường rộng</span></label>
                            <input name="road" id="road" class="form-control" value="<?php if(isset($data['road'])) echo $data['road']; ?>" />

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="form-group">

                            <label>Số lầu</span></label>
                            <input name="floors" id="floors" class="form-control" value="<?php if(isset($data['floors'])) echo $data['floors']; ?>"/>

                        </div>

                    </div>
                    <div class="col-md-4">

                        <div class="form-group">

                            <label>Số phòng ngủ</span></label>
                            <input name="bedroom" id="bedroom" class="form-control" value="<?php if(isset($data['bedroom'])) echo $data['bedroom']; ?>" />

                        </div>

                    </div>

                    </div>
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
                <div class="form-group col-md-12" style="padding-top:5px">

                    <label>Tiện ích đi kèm &nbsp;</label>
                                <br />
                    <?php $i = 0 ; foreach ($arrAddon['data'] as $ser) { $i ++;
                        ?>
                       <div class="col-md-2" style="margin-bottom:10px">
                        <input type="checkbox" name="addon[]" <?php if(isset($arrAddonSelected) && in_array($ser['addon_id'], $arrAddonSelected)) echo "checked"; ?> class="services" value="<?php echo $ser['addon_id']; ?>"/> <?php echo $ser['addon_name']; ?>  &nbsp;&nbsp;&nbsp;&nbsp;
                       </div>


                        <?php
                    }

                    ?>

                </div>
                <div class="form-group col-md-12">
                    <div class="form-group">
                        <div id="panel" style="margin-left: -260px" style="line-height: normal">
                            <input id="searchTextField" type="text" size="50" style="height: 20px;">
                        </div>
                        <div id="map-canvas"></div>
                        <input type="hidden" name="latt" id="latt" value="<?php echo $data['latt']; ?>" />
                        <input type="hidden" name="longt" id="longt" value="<?php echo $data['longt']; ?>" />
                    </div>
                </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Nội dung tin</span></label>
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
        <?php if($post_id>0){ ?>
        var latLng = new google.maps.LatLng(<?php echo $data['latt']; ?>, <?php echo $data['longt']; ?>);
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
                    $('#latt').val(latitude);
                    $('#longt').val(longitude);
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
                    $('#latt').val(latitude);
                    $('#longt').val(longitude);
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
                    $('#latt').val(latitude);
                    $('#longt').val(longitude);
                }
            });
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize);

</script>
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