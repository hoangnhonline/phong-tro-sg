<?php
$id = 0;
if(isset($_GET['id'])){
    $id = (int) $_GET['id'];
    require_once "model/Backend.php";
    $model = new Backend;
    $detail = $model->getDetail("album",$id);
    $imageArr = $model->getChild("images", "object_id", $id, 1); 
}
?>
<div class="row">
    <div class="col-md-8">

        <!-- Custom Tabs -->
        <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=album&act=list'">LIST</button>
        <div style="clear:both;margin-bottom:10px"></div>

        <div class="box box-primary">
            <div class="box-header">
                <h2 class="box-title" style="text-tranform:uppercase !important;color: #B10007"><?php echo ($id > 0) ? "UPDATE" : "CREATE" ?> ALBUM</h2>
                <div class="clearfix"></div>
            </div><!-- /.box-header -->
            <div class="clearfix"></div>
            <div class="box-body">
            <!-- form start -->
            <form role="form" method="post" action="controller/Album.php" enctype="multipart/form-data">
                <?php if($id> 0){ ?>
                <input type="hidden" value="<?php echo $id; ?>" name="id" />
                <?php } ?>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">Album name</label>
                        <input  value="<?php echo isset($detail['name'])  ? $detail['name'] : "" ?>" type="text" name="name" id="name" class="form-control required">
                    </div>
                </div><!-- /.box-body -->
            
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Category</label>
                             <select class="form-control"  name="category_id" id="category_id">
                              <option value="0">--Select--</option>
                              <option value="1" <?php if(isset($detail['category_id']) && $detail['category_id']==1) echo "selected"; ?>>Portrait Photos</option>
                              <option value="2" <?php if(isset($detail['category_id']) && $detail['category_id']==2) echo "selected"; ?>>Event Photos</option>
                              <option value="3" <?php if(isset($detail['category_id']) && $detail['category_id']==3) echo "selected"; ?>>Family &amp; Friendship Photos</option>
                              <option value="4" <?php if(isset($detail['category_id']) && $detail['category_id']==4) echo "selected"; ?>>Out-door or Romantic Photos</option>
                              <option value="5" <?php if(isset($detail['category_id']) && $detail['category_id']==5) echo "selected"; ?>>Commercial Photos</option>
                              <option value="6" <?php if(isset($detail['category_id']) && $detail['category_id']==6) echo "selected"; ?>>Group Photography</option>
                            </select>
                        </div>    
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Date Taken</label>
                            <input  value="<?php echo isset($detail['date_taken'])  ? $detail['date_taken'] : "" ?>" type="text" name="date_taken" id="date_taken" class="form-control required datepicker">
                        </div>    
                    </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="name">Upload images</label>
                        <button class="btn btn-default" data-toggle="modal" data-target="#uploadImages">Browse</button>                       
                        
                        <div id="load_hinh" class="col-md-12" style="margin-top:15px">
                            <?php if(isset($imageArr) && !empty($imageArr)){ ?>
                            <?php foreach ($imageArr as $v) {
                                $checked = $v['url'] == $detail['image_url'] ? "checked='checked'" :  "";
                                ?>
                            <div class="col-md-3 image_upload" id="img_<?php echo $v['id']; ?>">
                                <div class="wrapper_img_upload">
                                    <img class="img-thumbnail img-up lazy" data-original="../<?php echo $v['url']; ?>">
                                    <img data-value="<?php echo $v['url']; ?>" src="img/remove.png" class="remove_image" data-id="<?php echo $v['id']; ?>">
                                </div>
                                <p style="margin-top:10px">
                                    <input type="radio" <?php echo $checked; ?> name="image_url" value="<?php echo $v['url']; ?>" id="daidien_<?php echo $v['id']; ?>" /> Ảnh đại diện
                                    <input type="hidden" name="imageArr[]" value="<?php echo $v['url']; ?>" />
                                </p>                                
                            </div>
                            <?php } ?>
                            <?php } ?>
                        </div>
                        
                    </div>
                </div>   
                 <div class="clearfix"></div>
                </div><!-- /.box-body -->    
                <div class="box-footer">
                     <button class="btn btn-primary btnSave" type="submit">Save</button>
                     <button class="btn btn-primary" type="reset" onclick="location.href='index.php?mod=album&act=list'">Cancel</button>
                </div>
            </form>
        </div>

    </div><!-- /.col -->
</div>
<div class="modal fade" id="uploadImages" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <form id="uploadForm" method="post" enctype="multipart/form-data" action="upload.php">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Browses Images</h4>
          </div>
          <div class="modal-body">
            <fieldset style="width: 100%; margin-bottom: 10px; height: 100px; padding: 5px;">
                <p style="font-weight:bold;font-size:20px">Press Ctrl to select multi images</p>
                <input style="border-radius:2px;" type="file" id="myfile" name="myfile[]" multiple />
                <div class="clear"></div>
                <div class="progress_upload" style="text-align: center;border: 1px solid;border-radius: 3px;position: relative;display: none;">
                    <div class="bar_upload" style="background-color: grey;border-radius: 1px;height: 13px;width: 0%;"></div >
                    <div class="percent_upload" style="color: #FFFFFF;left: 140px;position: absolute;top: 1px;">0%</div >
                </div>
            </fieldset>
          </div>
          <div class="modal-footer">
            <div id="loading" style="display:none;text-align:center;">
                <img src="img/loading.gif" />                 
            </div>
            <div id="wForm" style="text-align:center;">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="btnClose">Close</button>
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
          </div>
        </div>
    </form>
  </div>
</div>
</div>
<script src="static/js/form.js" type="text/javascript"></script>
<script type="text/javascript" src="static/js/ajaxupload.js"></script>
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
    $('#uploadForm').ajaxForm({
        beforeSend: function() {                
        },
        uploadProgress: function(event, position, total, percentComplete) {
            $('#loading').show();
            $('#wForm').hide();
        },
        complete: function(res) { 
            var data  = JSON.parse(res.responseText);
            $( "#btnClose" ).click();  
            $('#wForm').show();  
            $('#load_hinh').append(data.html);            
            $('#loading').hide();  
            $('#myfile').val('');

        }
    }); 
    $(document).on('click','.remove_image', function(){
        var obj = $(this);
        if(confirm('Are you sure you want to remove this image?')){
            var image_url = obj.attr('data-value');
            var image_id = obj.attr('data-id');
            $.ajax({
                url: "ajax/remove-image.php",
                type: "POST",
                async: true,
                data: {
                    image_id : image_id,
                    image_url : image_url 
                },
                success: function(data){                    
                    obj.parent().parent().remove();
                }
            });

        }    
    });
  
}); 
</script>
<script>
  $(function() {
    $( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
  });
  </script>