<?php

require_once "model/Post.php";

$modelPost = new Post;

$arrEstateType = $modelPost->getListEstateType(-1,-1);
$arrProjectType = $modelPost->getListProjectType(-1,-1);
$arrLegal = $modelPost->getListLegal(-1,-1);
$arrDirection = $modelPost->getListDirection(-1,-1);
$arrPrice = $modelPost->getListPrice(-1,-1);
$arrArea = $modelPost->getListArea(-1,-1);
$arrAddon = $modelPost->getListAddon(-1,-1);
$arrDistrict = $modelPost->getListDistrict(1,-1,-1);

$link = "index.php?mod=post&act=list";

$page_show = 20;

//$district_id,$type_id,$estate_type_id,$direction_id,$area_id,$legal_id,$price_id,$project_type_id
if (isset($_GET['district_id']) && $_GET['district_id'] > 0) {
    $district_id = (int) $_GET['district_id'];
    $link.="&district_id=$district_id";
} else {
    $district_id = -1;
}
if (isset($_GET['type_id']) && $_GET['type_id'] > 0) {
    $type_id = (int) $_GET['type_id'];
    $link.="&type_id=$type_id";
} else {
    $type_id = -1;
}
if (isset($_GET['estate_type_id']) && $_GET['estate_type_id'] > 0) {
    $estate_type_id = (int) $_GET['estate_type_id'];
    $link.="&estate_type_id=$estate_type_id";
} else {
    $estate_type_id = -1;
}
if (isset($_GET['direction_id']) && $_GET['direction_id'] > 0) {
    $direction_id = (int) $_GET['direction_id'];
    $link.="&direction_id=$direction_id";
} else {
    $direction_id = -1;
}
if (isset($_GET['area_id']) && $_GET['area_id'] > 0) {
    $area_id = (int) $_GET['area_id'];
    $link.="&area_id=$area_id";
} else {
    $area_id = -1;
}
if (isset($_GET['legal_id']) && $_GET['legal_id'] > 0) {
    $legal_id = (int) $_GET['legal_id'];
    $link.="&legal_id=$legal_id";
} else {
    $legal_id = -1;
}
if (isset($_GET['price_id']) && $_GET['price_id'] > 0) {
    $price_id = (int) $_GET['price_id'];
    $link.="&price_id=$price_id";
} else {
    $price_id = -1;
}
if (isset($_GET['project_type_id']) && $_GET['project_type_id'] > 0) {
    $project_type_id = (int) $_GET['project_type_id'];
    $link.="&project_type_id=$project_type_id";
} else {
    $project_type_id = -1;
}



$arrTotal = $modelPost->getListPost($district_id,$type_id,$estate_type_id,$direction_id,$area_id,$legal_id,$price_id,$project_type_id, -1, -1);



$total_page = ceil($arrTotal['total'] / 20);



$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;



$offset = 20 * ($page - 1);



$arrList = $modelPost->getListPost($district_id,$type_id,$estate_type_id,$direction_id,$area_id,$legal_id,$price_id,$project_type_id,$offset, 20);
//var_dump("<pre>",$arrList);


?>

<link href="<?php echo STATIC_URL; ?>css/jquery-ui.css" rel="stylesheet" type="text/css" />

<div class="row">

    <div class="col-md-12">

    <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=post&act=form'">Tạo mới</button>

         <div class="box-header">

                <h3 class="box-title">Danh sách tin</h3>

            </div><!-- /.box-header -->

        <div class="box">

           <div class="box_search">
                    <select name="type_id" class="select_search" id="type_id">
                            <option value='-1' >Tất cả</option>
                            <option value='1' <?php if(isset($_GET['type_id']) && $_GET['type_id'] == 1) echo "selected";?>>Cần bán</option>
                            <option value='2' <?php if(isset($_GET['type_id']) && $_GET['type_id'] == 2) echo "selected";?>>Cho thuê</option>
                    </select>
                    Quận/huyện
                    <select name="district_id" class="select_search" id="district_id">
                        <option value='-1' >Tất cả</option>
                        <?php foreach ($arrDistrict['data'] as $value) { ?>

                            <option value='<?php echo $value['district_id']; ?>'

                                <?php if(isset($_GET['district_id']) && $_GET['district_id'] == $value['district_id']) echo "selected";?>

                                ><?php echo $value['district_name']; ?></option>

                        <?php } ?>
                    </select>



                    &nbsp;&nbsp;&nbsp;
                    Loại BĐS
                    <select name="estate_type_id" class="select_search" id="estate_type_id">
                        <option value='-1' >Tất cả</option>
                        <?php foreach ($arrEstateType['data'] as $value) { ?>

                            <option value='<?php echo $value['estate_type_id']; ?>'

                                <?php if(isset($_GET['estate_type_id']) && $_GET['estate_type_id'] == $value['estate_type_id']) echo "selected";?>

                                ><?php echo $value['estate_type_name']; ?></option>

                        <?php } ?>
                    </select>
                     &nbsp;&nbsp;&nbsp;
                    Dự án
                    <select name="project_type_id" class="select_search" id="project_type_id">
                        <option value='-1' >Tất cả</option>
                        <?php foreach ($arrProjectType['data'] as $value) { ?>

                            <option value='<?php echo $value['project_type_id']; ?>'

                                <?php if(isset($_GET['project_type_id']) && $_GET['project_type_id'] == $value['project_type_id']) echo "selected";?>

                                ><?php echo $value['project_type_name']; ?></option>

                        <?php } ?>
                    </select>
                    &nbsp;&nbsp;&nbsp;
                    Diện tích
                    <select name="area_id" class="select_search" id="area_id">
                        <option value='-1' >Tất cả</option>
                        <?php foreach ($arrArea['data'] as $value) { ?>

                            <option value='<?php echo $value['area_id']; ?>'

                                <?php if(isset($_GET['area_id']) && $_GET['area_id'] == $value['area_id']) echo "selected";?>

                                ><?php echo $value['area_name']; ?></option>

                        <?php } ?>
                    </select>
                    &nbsp;&nbsp;&nbsp;
                    Giá
                    <select name="price_id" class="select_search" id="price_id">
                        <option value='-1' >Tất cả</option>
                        <?php foreach ($arrPrice['data'] as $value) { ?>

                            <option value='<?php echo $value['price_id']; ?>'

                                <?php if(isset($_GET['price_id']) && $_GET['price_id'] == $value['price_id']) echo "selected";?>

                                ><?php echo $value['price_name']; ?></option>

                        <?php } ?>
                    </select>



                    <button class="btn btn-primary btn-sm right" id="btnSearch" type="button">Tìm kiếm</button>



            </div>

            <div class="box-body">



                <table class="table table-bordered table-striped">

                    <tbody><tr>

                        <th style="width: 1%">No.</th>
                        <th style="width: 50px">Hiện trang chủ</th>
                        <th style="width: 120px">Ảnh đại diện</th>

                        <th>Tiêu đề</th>

                        <th>Ngày đăng</th>

                        <th style="width: 40px">Action</th>

                    </tr>

                    <?php

                    if(!empty($arrList['data'])){

                    $i = ($page-1) * LIMIT;

                    foreach($arrList['data'] as $row){

                    $i++;

                    ?>

                    <tr>

                        <td><?php echo $i; ?></td>
                        <td align="center" valign="middle">
                            <?php if($row['hot']==1) { ?>
                            <img src="img/ok.png" class="showhome" data_value="0" data-id="<?php echo $row['post_id']; ?>" style="cursor:pointer" title="Click nếu không muốn hiện ở trang chủ"/>
                            <?php } else{ ?>
                            <img src="img/notok.png" class="showhome" data_value="1" data-id="<?php echo $row['post_id']; ?>" style="cursor:pointer" title="Click để hiện ở trang chủ" />
                            <?php } ?>
                        </td>
                       <td style="width: 10px">
                           <img src="../<?php echo $row['image_url']; ?>" width="100px"/>
                       </td>

                        <td>
                        <u><b><?php echo $row['type_id'] == 1 ? "Cần bán" : "Cho thuê" ; ?> : </b></u>
                        <a style="font-size:15px" href="index.php?mod=post&act=form&post_id=<?php echo $row['post_id']; ?>">
                            <?php echo $row['post_title']; ?>
                        </a>
                        <br />
                        Quận/Huyện : <b><?php echo $arrDistrict['data'][$row['district_id']]['district_name']; ?></b> <br >
                        Diện tích : <b><?php echo $row['total_area']; ?> m2</b> <br >
                        Giá : <b><?php echo $row['price']; ?><?php echo $value['cal_type']==1 ? "/ m2" : ""; ?></b>
                        </td>

                        <td><?php echo date('d-m-Y',$row['creation_time']); ?></td>

                        <td style="white-space:nowrap">

                            <a href="index.php?mod=post&act=form&post_id=<?php echo $row['post_id']; ?>">

                                <i class="fa fa-fw fa-edit"></i>

                            </a>

                            <a href="javascript:;" alias="<?php echo $row['post_title']; ?>" id="<?php echo $row['post_id']; ?>" mod="post" class="link_delete" >

                                <i class="fa fa-fw fa-trash-o"></i>

                            </a>



                        </td>

                    </tr>

                    <?php } }else{ ?>

                    <tr>

                        <td colspan="8" class="error_data">Không tìm thấy dữ liệu!</td>

                    </tr>

                    <?php } ?>

                </tbody></table>

            </div><!-- /.box-body -->

            <div class="box-footer clearfix">
                <div style="float:left;font-size:19px;font-weight:bold">Total : <?php echo $arrTotal['total']; ?></div>
                <!--

                <ul class="pagination pagination-sm no-margin pull-right">

                    <li><a href="#">«</a></li>

                    <li><a href="#">1</a></li>

                    <li><a href="#">2</a></li>

                    <li><a href="#">3</a></li>

                    <li><a href="#">»</a></li>

                </ul>-->

                <?php echo $modelPost->phantrang($page, $page_show, $total_page, $link); ?>

            </div>

        </div><!-- /.box -->

    </div><!-- /.col -->



</div>

 <script>
 $(function(){
    $('img.showhome').click(function(){
        var obj = $(this);
        var hot = $(this).attr('data_value');
        var post_id = $(this).attr('data-id');
        var confirms = hot ==1 ? "Chắc chắn muốn hiện ở trang chủ?" : "Chắc chắn muốn ẩn ở trang chủ?";
        var srcimg = hot==0 ? "img/notok.png" : "img/ok.png";
        var newvalue = hot==0 ? 1 : 0;
        if(confirm(confirms)){
            $.ajax({
                url: "ajax/process.php",
                type: "POST",
                async: true,
                data: {
                    'post_id' : post_id,
                    'hot' : hot,
                    'action' : 'sethotpost'
                },
                success: function(data){

                }
            });
            obj.attr({
              src: srcimg,
              data_value : newvalue
            });

        }else{
            return false;
        }

   });
 });
    function search(){

        var str_link = "index.php?mod=post&act=list";

        var tmp = $('#district_id').val();

        if(tmp > 0){

            str_link += "&district_id=" + tmp ;

        }

        tmp = $.trim($('#estate_type_id').val());

        if(tmp != ''){

            str_link += "&estate_type_id=" + tmp ;

        }

        tmp = $('#type_id').val();

        if(tmp > 0){

            str_link += "&type_id=" + tmp ;

        }

        tmp = $('#area_id').val();

        if(tmp > 0){

            str_link += "&area_id=" + tmp ;

        }
        tmp = $('#price_id').val();

        if(tmp > 0){

            str_link += "&price_id=" + tmp ;

        }

        tmp = $('#project_type_id').val();

        if(tmp > 0){

            str_link += "&project_type_id=" + tmp ;

        }

        location.href= str_link;

    }

    $('#project_type_id,#type_id,#estate_type_id,#price_id,#area_id,#district_id').change(function(){

        search();

    });

    $('#btnSearch').click(function(){

        search();

    });

  </script>