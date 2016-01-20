<?php

require_once "model/Post.php";

$modelPost = new Post;

$arrEstateType = $modelPost->getListEstateType(-1,-1);
$arrProjectType = $modelPost->getListProjectType(-1,-1);
$arrLegal = $modelPost->getListLegal(-1,-1);
$arrDirection = $modelPost->getListDirection(-1,-1);
$arrAddon = $modelPost->getListAddon(-1,-1);
$arrDistrict = $modelPost->getListDistrict(1,-1,-1);

$link = "index.php?mod=userpost&act=list";

$page_show = 20;

//$district_id,$type_id,$estate_type_id,$direction_id,$area_id,$legal_id,$price_id,$project_type_id
if (isset($_GET['status']) && $_GET['status'] > 0) {
    $status = (int) $_GET['status'];
    $link.="&status=$status";
} else {
    $status = -1;
}
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
if (isset($_GET['legal_id']) && $_GET['legal_id'] > 0) {
    $legal_id = (int) $_GET['legal_id'];
    $link.="&legal_id=$legal_id";
} else {
    $legal_id = -1;
}
if (isset($_GET['project_type_id']) && $_GET['project_type_id'] > 0) {
    $project_type_id = (int) $_GET['project_type_id'];
    $link.="&project_type_id=$project_type_id";
} else {
    $project_type_id = -1;
}



$arrTotal = $modelPost->getListUserPost($status,$district_id,$type_id,$estate_type_id,$direction_id,$legal_id,$project_type_id, -1, -1);



$total_page = ceil($arrTotal['total'] / 20);



$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;



$offset = 20 * ($page - 1);



$arrList = $modelPost->getListUserPost($status,$district_id,$type_id,$estate_type_id,$direction_id,$legal_id,$project_type_id,$offset, 20);



?>

<link href="<?php echo STATIC_URL; ?>css/jquery-ui.css" rel="stylesheet" type="text/css" />

<div class="row">

    <div class="col-md-12">

         <div class="box-header">

                <h3 class="box-title">Danh sách tin ký gửi</h3>

            </div><!-- /.box-header -->

        <div class="box">

           <div class="box_search">
                    Trạng thái
                    <select name="status" class="select_search" id="status">
                            <option value='-1' >Tất cả</option>
                            <option value='1' <?php if(isset($_GET['status']) && $_GET['status'] == 1) echo "selected";?>>Đã duyệt</option>
                            <option value='2' <?php if(isset($_GET['status']) && $_GET['status'] == 2) echo "selected";?>>Chưa duyệt</option>
                            <option value='3' <?php if(isset($_GET['status']) && $_GET['status'] == 3) echo "selected";?>>Không duyệt</option>
                    </select>
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


                    <button class="btn btn-primary btn-sm right" id="btnSearch" type="button">Tìm kiếm</button>



            </div>

            <div class="box-body">



                <table class="table table-bordered table-striped">

                    <tbody><tr>

                        <th style="width: 10px">No.</th>
                        <th style="width: 120px">Ảnh đại diện</th>
                        <th>Tiêu đề</th>
                        <th>Ngày đăng</th>
                        <th>Người ký gửi</th>
                        <th>Trạng thái</th>
                        <th style="width: 40px">Action</th>

                    </tr>

                    <?php

                    if(!empty($arrList['data'])){

                    $i = ($page-1) * LIMIT;

                    foreach($arrList['data'] as $row){

                    $i++;
                    $arrDetailUserPost = $modelPost->getDetailUsersPost($row['user_id']);
                    ?>

                    <tr>

                        <td><?php echo $i; ?></td>

                       <td style="width: 10px">
                           <img src="../<?php echo $row['image_url']; ?>" width="100px"/>
                       </td>

                        <td>
                        <u><b><?php echo $row['type_id'] == 1 ? "Cần bán" : "Cho thuê" ; ?> : </b></u>
                        <a style="font-size:15px" href="index.php?mod=userpost&act=form&post_id=<?php echo $row['post_id']; ?>">
                            <?php echo $row['post_title']; ?>
                        </a>
                        <br />
                        Quận/Huyện : <b><?php echo $arrDistrict['data'][$row['district_id']]['district_name']; ?></b> <br >
                        Diện tích : <b><?php echo $row['total_area']; ?> m2</b> <br >
                        Giá : <b><?php echo $row['price']; ?><?php echo $value['cal_type']==1 ? "/ m2" : ""; ?></b>
                        </td>

                        <td><?php echo date('d-m-Y',$row['creation_time']); ?></td>
                        <td><?php echo $arrDetailUserPost['email']; ?>
                        <br />
                        <?php if($arrDetailUserPost['status']==2 ){ ?>
                            <a title="Click vào để kiểm duyệt thông tin" href="index.php?mod=users&act=form&user_id=<?php echo $row['user_id']; ?>" style="color:red">Chưa kiểm duyệt thông tin</a>
                        <?php } ?>
                        </td>
                        <td><?php
                        if($row['status']==1) echo "<span style='color:blue'>Đã duyệt</span>";
                        if($row['status']==2) echo "<span style='color:red'>Chưa duyệt</span>";
                        if($row['status']==3) echo "<span style='color:red;font-style:strike'>Không duyệt</span>";
                         ?></td>

                        <td style="white-space:nowrap">

                            <a href="index.php?mod=userpost&act=form&post_id=<?php echo $row['post_id']; ?>">

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
    function search(){

        var str_link = "index.php?mod=userpost&act=list";

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

        tmp = $('#status').val();

        if(tmp > 0){

            str_link += "&status=" + tmp ;

        }

        tmp = $('#project_type_id').val();

        if(tmp > 0){

            str_link += "&project_type_id=" + tmp ;

        }

        location.href= str_link;

    }

    $('#project_type_id,#type_id,#estate_type_id,#district_id,#status').change(function(){

        search();

    });

    $('#btnSearch').click(function(){

        search();

    });

  </script>