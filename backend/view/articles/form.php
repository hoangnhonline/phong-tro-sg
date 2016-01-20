<?php 

$str_tag = "";

$link = "index.php?mod=articles&act=list";

$detail = array();

if(isset($_GET['id'])){

    $id = (int) $_GET['id'];
    require_once "model/Backend.php";
    $model = new Backend;
    $detail = $model->getDetailArticle($id);    

    $data = $detail['data'];

    $arrTag = $model->getTagsOfProductId($id);   

    if(!empty($arrTag)){       

        foreach($arrTag as $tag_id){

            $rs_tag = $model->getDetailTag($tag_id);

            $row_tag = mysql_fetch_assoc($rs_tag);

            $str_tag.=$row_tag["tag_name"]."; ";

        }   

    }  
}
?>

<script type="text/javascript" src="ckeditor/ckeditor.js"></script>

<script type="text/javascript" src="js/ajaxupload.js"></script>

<div class="row">
<div class="col-md-12">

    <button class="btn btn-primary btn-sm" onclick="location.href='<?php echo $link; ?>'">Danh sách bài viết</button>

        <form method="post" action="controller/Articles.php" enctype="multipart/form-data">            



        <!-- Custom Tabs -->

        <div style="clear:both;margin-bottom:10px"></div>

        <div class="box box-primary">    

         <div class="box-header">



                <h3 class="box-title"><?php echo (isset($id) && $id> 0) ? "Cập nhật" : "Tạo mới" ?> bài viết <?php echo (isset($id) && $id> 0) ? " : ".$data['name'] : ""; ?></h3>



                <?php if(isset($id) && $id> 0){ ?>



                <input type="hidden" value="<?php echo $id; ?>" name="id" />



                <?php } ?>



            </div><!-- /.box-header -->



        <div class="box-body">   

            <div class="col-md-12">

            <div class="col-md-6"> 
                <div class="form-group">

                        <label>Danh mục <span class="required"> ( * ) </span></label>
                        <select class="form-control" name="category_id" id="category_id">
                            <option value="0">Select</option>
                            <option value="1" <?php echo (isset($data['category_id']) && $data['category_id']==1)  ? "selected" : ""; ?>>Tin tức</option>
                            <option value="2" <?php echo (isset($data['category_id']) && $data['category_id']==2)  ? "selected" : ""; ?>>Tin dự án</option>
                        </select>
                </div>                 

                <div class="form-group">



                        <label>Tiêu đề <span class="required"> ( * ) </span></label>



                        <input type="text" name="name" class="form-control required" value="<?php echo isset($data['name'])  ? $data['name'] : "" ?>">



                </div>            

                <div class="form-group">



                    <label>Mô tả ngắn </label>                        



                    <textarea rows="5" class="form-control" name="description"><?php if(isset($data['description'])) echo $data['description']; ?></textarea>



                </div>  

                <div class="form-group">

                    <label>Nguồn</label> 

                    <input type="text" name="source" class="form-control required" value="<?php echo isset($data['source'])  ? $data['source'] : "" ?>">                

                </div>             

                <!--<div class="form-group">

                    <label>Tags</label> 

                    <textarea rows="3" class="form-control" name="tags" id="tags"><?php echo $str_tag; ?></textarea>



                </div> -->

                <div class="form-group">                                

                    <input type="checkbox" name="is_hot" id="is_hot" value="1" <?php if(!empty($data['is_hot']) && $data['is_hot']==1) echo "checked"; ?> />

                    <label style="color:red">Nổi bật (hiện trang chủ)</label>

                </div>

            </div>                         

             <div class="col-md-6">

            <!-- Custom Tabs -->

            <div style="clear:both;margin-bottom:30px"></div>

            <div class="box-header">

                

            </div><!-- /.box-header -->

            <div class="nav-tabs-custom" style="margin-top:30px" >



                <div class="button">

                    <div class="col-md-12" >

                        <h4 class="box-title">SEO information</h4>

                        <div class="form-group">

                            <label>Title</label>

                            <textarea name="meta_title" id="meta_title" class="form-control" rows="2"><?php if(!empty($data)) echo $data['meta_title']; ?></textarea>

                        </div>

                        <div class="form-group">

                            <label>Meta description</label>

                            <textarea name="meta_description" id="meta_description" class="form-control" rows="2"><?php if(!empty($data)) echo $data['meta_description']; ?></textarea>

                        </div>

                        <div class="form-group">

                            <label>Meta keyword</label>

                            <textarea name="meta_keyword" id="meta_keyword" class="form-control" rows="2"><?php if(!empty($data)) echo $data['meta_keyword']; ?></textarea>

                        </div>

                    </div>        

                </div>  

                <div style="clear:both"></div>

            </div><!-- nav-tabs-custom -->

            </div><!-- /.col --> 

            </div>         
            <div class="col-md-12">
            <div class="box-body">
                <div class="form-group">
                    <label>Ảnh đại diện</label>
                    <input type="radio" id="choose_img_sv" name="choose_img" value="1" checked="checked"/> Chọn ảnh từ server
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="choose_img_cp" name="choose_img" value="2" /> Chọn ảnh từ máy tính
                    <div id="from_sv">
                        <input type="hidden" name="image_url" id="image_url" class="form-control" value="<?php if(!empty($data['image_url'])) echo "../".$data['image_url']; ?>" /><br />
                        <?php if(!empty($data['image_url'])){ ?>
                        <img id="img_thumnails" src="../<?php echo $data['image_url']; ?>" height="100" />
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

            <div class="form-group">

                <label>Nội dung <span class="required"> ( * ) </span></label>                        

                <textarea rows="5" id="content" class="form-control" name="content"><?php if(isset($data['content'])) echo $data['content']; ?></textarea>
            </div>           

            </div>

            <div class="button">



                <button class="btn btn-primary btnSave" type="submit">Save</button>



                <button class="btn btn-primary" type="reset">Cancel</button>



            </div>


        </div><!-- nav-tabs-custom -->

        </div>

    </form>



    </div><!-- /.col --> 



</div>



<link href="<?php echo STATIC_URL; ?>css/jquery-ui.css" rel="stylesheet" type="text/css" />

<script src="js/form.js" type="text/javascript"></script>
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
<div style="display: none" id="box_uploadimages">

    <div class="upload_wrapper block_auto">

        <div class="note" style="text-align:center;">Nhấn <strong>Ctrl</strong> để chọn nhiều hình.</div>

        <form id="upload_files_new" method="post" enctype="multipart/form-data" enctype="multipart/form-data" action="ajax/upload.php"> 

            <fieldset style="width: 100%; margin-bottom: 10px; height: 47px; padding: 5px;">

                <legend><b>&nbsp;&nbsp;Chọn hình từ máy tính&nbsp;&nbsp;</b></legend>

                <input style="border-radius:2px;" type="file" id="myfile" name="myfile[]" multiple/>

                <div class="clear"></div>

                <div class="progress_upload" style="text-align: center;border: 1px solid;border-radius: 3px;position: relative;display: none;">

                    <div class="bar_upload" style="background-color: grey;border-radius: 1px;height: 13px;width: 0%;"></div >

                    <div class="percent_upload" style="color: #FFFFFF;left: 140px;position: absolute;top: 1px;">0%</div >

                </div>

            </fieldset>

        </form>

    </div>

</div>
<script type="text/javascript" src="ckfinder/ckfinder.js"></script>
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

$(function(){       

    

    $('#tags').on("keydown", function (event) {  

        if (event.keyCode === $.ui.keyCode.TAB && $(this).data("autocomplete").menu.active) {

            event.preventDefault();

        }

    }).autocomplete({

        source: function (request, response) {

            $.getJSON("ajax/tag.php", {

                term: extractLast(request.term)                

            }, response);

        },

        search: function () {

            // custom minLength

            var term = extractLast(this.value);

            if (term.length < 2) {

                return false;

            }

        },

        focus: function () {

            // prevent value inserted on focus

            return false;

        },

        select: function (event, ui) {

            var terms = split(this.value);

            // remove the current input

            terms.pop();

            // add the selected item

            terms.push(ui.item.value);

            // add placeholder to get the comma-and-space at the end

            terms.push("");

            this.value = terms.join("; ");

            return false;

        }

    });

});

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

    $('#hinh_dai_dien').attr('src','../' + fileUrl).show();

}

</script>

<script type="text/javascript">

var editor = CKEDITOR.replace( 'content',{

    uiColor : '#9AB8F3',

    language:'vi',

    height:400,

    width:800,

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