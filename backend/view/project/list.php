<?php
require_once "model/Post.php";

$modelPost = new Post;

$arrProjectType = $modelPost->getListProjectType(-1,-1);
$arrDistrict = $modelPost->getListDistrict(1,-1,-1);

$link = "index.php?mod=project&act=list";

$page_show = 20;
if (isset($_GET['hot']) && $_GET['hot'] > -1) {
    $hot = (int) $_GET['hot'];
    $link.="&hot=$hot";
} else {
    $hot = -1;
}
if (isset($_GET['district_id']) && $_GET['district_id'] > 0) {
    $district_id = (int) $_GET['district_id'];
    $link.="&district_id=$district_id";
} else {
    $district_id = -1;
}
if (isset($_GET['project_type_id']) && $_GET['project_type_id'] > 0) {
    $project_type_id = (int) $_GET['project_type_id'];
    $link.="&project_type_id=$project_type_id";
} else {
    $project_type_id = -1;
}

$arrTotal = $modelPost->getListProject($hot,$district_id,$project_type_id, -1, -1);
$limit = 20;

$total_page = ceil($arrTotal['total'] / $limit);

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

$offset = $limit * ($page - 1);

$arrList = $modelPost->getListProject($hot,$district_id,$project_type_id,$offset, $limit);

?>

<link href="<?php echo STATIC_URL; ?>css/jquery-ui.css" rel="stylesheet" type="text/css" />

<div class="row">

    <div class="col-md-12">

    <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=project&act=form'">Tạo mới</button>

         <div class="box-header">

                <h3 class="box-title">Danh sách dự án</h3>

            </div><!-- /.box-header -->

        <div class="box">

           <div class="box_search">
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
                    Loại dự án
                    <select name="project_type_id" style="width:200px;height:25px" id="project_type_id">
                        <option value='-1' >Tất cả</option>
                        <?php foreach ($arrProjectType['data'] as $value) { ?>

                            <option value='<?php echo $value['project_type_id']; ?>'

                                <?php if(isset($_GET['project_type_id']) && $_GET['project_type_id'] == $value['project_type_id']) echo "selected";?>

                                ><?php echo $value['project_type_name']; ?></option>

                        <?php } ?>
                    </select>
                    &nbsp;&nbsp;&nbsp;
                    Trạng thái
                    <select name="hot" class="select_search" id="hot">
                        <option value='-1' >Tất cả</option>
                        <option value='0' <?php if(isset($_GET['hot']) && $_GET['hot'] == 0) echo "selected";?>>Bình thường</option>
                        <option value='1' <?php if(isset($_GET['hot']) && $_GET['hot'] == 1) echo "selected";?>>Nổi bật</option>
                    </select>
                    <button class="btn btn-primary btn-sm right" id="btnSearch" type="button">Tìm kiếm</button>



            </div>

            <div class="box-body">



                <table class="table table-bordered table-striped">

                    <tbody><tr>

                        <th style="width: 10px">No.</th>
                        <th style="width: 50px">Hiện trang chủ</th>
                        <th style="width: 120px">Ảnh đại diện</th>

                        <th style="width: 10px">Quận/Huyện</th>

                        <th>Tên dự án</th>

                        <th>Loại dự án</th>

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
                            <img src="img/ok.png" class="showhome" data_value="0" data-id="<?php echo $row['project_id']; ?>" style="cursor:pointer" title="Click nếu không muốn hiện ở trang chủ"/>
                            <?php } else{ ?>
                            <img src="img/notok.png" class="showhome" data_value="1" data-id="<?php echo $row['project_id']; ?>" style="cursor:pointer" title="Click để hiện ở trang chủ" />
                            <?php } ?>
                        </td>
                       <td style="width: 10px">
                           <img src="../<?php echo $row['image_url']; ?>" width="100px"/>
                       </td>
                        <td style="width: 10px">
                            <?php echo $arrDistrict['data'][$row['district_id']]['district_name']; ?>
                        </td>

                        <td>
                            <a href="index.php?mod=project&act=form&project_id=<?php echo $row['project_id']; ?>">
                        <?php echo $row['project_name']; ?>
                        </a>
                             <?php if($row['hot']==1) { ?>

                            &nbsp;&nbsp;&nbsp;<img src="static/img/ok.gif" style="cursor:pointer" width="20" alt="Dự án hot" title="Dự án hot"/>

                            <?php } ?>
                        </td>
                        <td>
                            <?php echo $arrProjectType['data'][$row['project_type_id']]['project_type_name']; ?>
                        </td>

                        <td><?php echo date('d-m-Y',$row['creation_time']); ?></td>

                        <td style="white-space:nowrap">

                            <a href="index.php?mod=project&act=form&project_id=<?php echo $row['project_id']; ?>">

                                <i class="fa fa-fw fa-edit"></i>

                            </a>

                            <a href="javascript:;" alias="<?php echo $row['project_name']; ?>" id="<?php echo $row['project_id']; ?>" mod="project" class="link_delete" >

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
        var project_id = $(this).attr('data-id');
        var confirms = hot ==1 ? "Chắc chắn muốn hiện ở trang chủ?" : "Chắc chắn muốn ẩn ở trang chủ?";
        var srcimg = hot==0 ? "img/notok.png" : "img/ok.png";
        var newvalue = hot==0 ? 1 : 0;
        if(confirm(confirms)){
            $.ajax({
                url: "ajax/process.php",
                type: "POST",
                async: true,
                data: {
                    'project_id' : project_id,
                    'hot' : hot,
                    'action' : 'sethotproject'
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

        var str_link = "index.php?mod=project&act=list";

        var tmp = $('#district_id').val();

        if(tmp > 0){

            str_link += "&district_id=" + tmp ;

        }

       tmp = $('#hot').val();

        if(tmp > -1){

            str_link += "&hot=" + tmp ;

        }

        tmp = $('#project_type_id').val();

        if(tmp > 0){

            str_link += "&project_type_id=" + tmp ;

        }

        location.href= str_link;

    }

    $('#project_type_id,#hot,#district_id').change(function(){

        search();

    });

    $('#btnSearch').click(function(){

        search();

    });

  </script>