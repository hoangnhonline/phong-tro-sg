<?php
$id = 0;

$cityArr = $model->getList('city', -1, -1);

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if(isset($_GET['id'])){    
    require_once "model/Backend.php";
    $model = new Backend;
    $detail = $model->getDetail("users",$id);    
}else{
  $pass = randomPassword();
}
function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
?>
<div class="row">
   <div class="col-md-12">
      <!-- Custom Tabs -->        
      <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=user&act=list'">Danh sách</button>        
      <div style="clear:both;margin-bottom:10px"></div>
      <div class="box box-primary">
         <div class="box-header">
            <h3 class="box-title"><?php echo ($id > 0) ? "Cập nhật" : "Tạo mới" ?> mod</h3>
         </div>
         <!-- /.box-header -->            <!-- form start -->            
         <form role="form" method="post" action="controller/User.php" enctype="multipart/form-data">
            <?php if($id> 0){ ?>                
            <input type="hidden" value="<?php echo $id; ?>" name="id" />               
            <?php }else{
              ?>
              <p style="font-size:18px;color:blue;padding:15px;margin-left:10px">
                Mật khẩu ngẫu nhiên của Mod này sau khi tạo sẽ là: <span style="color:red"><?php echo $pass; ?></span><br />Vui lòng lưu lại mật khẩu này.
              </p>
              <input type="hidden" name="password" value="<?php echo $pass; ?>">
              <?php

            } ?>                
            <div class="box-body">
              <div class="col-md-5">
                <input type="hidden" value="2" name="group" /> 
               <div class="form-group">                        
                  <label for="name">Họ Tên <span class="required"> ( * ) </span></label>                        
                  <input  value="<?php echo isset($detail['name'])  ? $detail['name'] : "" ?>" type="text" name="name" id="name" class="form-control required">                    
                </div>
               <div class="form-group">                        
                <label for="email">Email <span class="required"> ( * ) </span></label>                        
                <input  value="<?php echo isset($detail['email'])  ? $detail['email'] : "" ?>" type="text" name="email" id="email" class="form-control required">                    
               </div>
               <div class="form-group">                        
                <label for="email">Phone <span class="required"> ( * ) </span></label>                        
                <input  value="<?php echo isset($detail['phone'])  ? $detail['phone'] : "" ?>" type="text" name="phone" id="phone" class="form-control required">                    
               </div>
               <div class="form-group">                        
                <label for="email">Skype</label>                        
                <input  value="<?php echo isset($detail['skype'])  ? $detail['skype'] : "" ?>" type="text" name="skype" id="skype" class="form-control required">                    
               </div>
               <div class="form-group">                        
                <label for="email">Yahoo</label>                        
                <input  value="<?php echo isset($detail['yahoo'])  ? $detail['yahoo'] : "" ?>" type="text" name="yahoo" id="yahoo" class="form-control required">                    
               </div>
               <div class="form-group">                        
                <label for="email">Address <span class="required"> ( * ) </span></label>                        
                <input  value="<?php echo isset($detail['address'])  ? $detail['address'] : "" ?>" type="text" name="address" id="address" class="form-control required">                    
               </div>

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
               
               <div class="clearfix"></div>
              </div>
              <div class="col-md-7" style="border:1px solid #CCC;background-color:#FFF">
                
                          
   
              </div>
               <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
            <!-- /.box-body -->                
            <div class="box-footer">                     
            	<button class="btn btn-primary btnSave" type="submit">Save</button> 
            	<button class="btn btn-primary" type="reset">Cancel</button>                
            </div>
         </form>
      </div>
   </div>
   <!-- /.col --> 
</div>
<link href="static/css/jquery-ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="ckfinder/ckfinder.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  
    $('#city_id').val(1);
    loadDistrict(1, <?php echo $id; ?>);
  
  
  $('#city_id').change(function(){
     loadDistrict($(this).val());
  });
});
 
function loadDistrict(city_id){
    $.ajax({
        url: "ajax/district.php",
        type: "POST",
        async: true,
        data: {
            city_id : city_id,
            user_id : <?php echo $id; ?>
        },
        success: function(data){                    
            $('#load_district').html(data);
        }
    });
}


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
