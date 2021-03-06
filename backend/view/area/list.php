<?php

require_once "model/Area.php";

$model = new Area;

$link = "index.php?mod=area&act=list";



if (isset($_GET['status']) && $_GET['status'] > 0) {

    $lang_id = (int) $_GET['status'];

    $status.="&status=$status";

} else {

    $status = -1;

}



$listTotal = $model->getListAreaByStatus($status, -1, -1);



$total_record = mysql_num_rows($listTotal);



$total_page = ceil($total_record / LIMIT);



$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;



$offset = LIMIT * ($page - 1);



$list = $model->getListAreaByStatus($status, $offset, LIMIT);



?>

<div class="row">

    <div class="col-md-12">

    <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=area&act=form'">Tạo mới</button>

         <div class="box-header">

                <h3 class="box-title">Danh sách khoảng diện tích</h3>

            </div><!-- /.box-header -->

        <div class="box">



            <div class="box-body">

                <table class="table table-bordered table-striped">

                    <tbody><tr>

                        <th style="width: 10px">No.</th>

                        <th>Name</th>

                        <th>Ngày tạo</th>

                        <th style="width: 40px">Action</th>

                    </tr>

                    <?php

                    $i = ($page-1) * LIMIT;;

                    while ($row = mysql_fetch_assoc($list)) {

                    $i++;

                    ?>

                    <tr>

                        <td><?php echo $i; ?></td>

                        <td><?php echo $row['area_name']; ?></td>

                        <td><?php echo date('d-m-Y',$row['creation_time']); ?></td>

                        <td style="white-space:nowrap">

                            <a href="index.php?mod=area&act=form&area_id=<?php echo $row['area_id']; ?>" class="btn btn-sm btn-warning"> 

                                Chỉnh sửa

                            </a>

                            <a href="javascript:;" alias="<?php echo $row['area_name']; ?>" id="<?php echo $row['area_id']; ?>" mod="area" class="btn btn-sm btn-danger link_delete" >

                                Xóa

                            </a>



                        </td>

                    </tr>

                    <?php } ?>

                </tbody></table>

            </div><!-- /.box-body -->

            <div class="box-footer clearfix">

                <!--

                <ul class="pagination pagination-sm no-margin pull-right">

                    <li><a href="#">«</a></li>

                    <li><a href="#">1</a></li>

                    <li><a href="#">2</a></li>

                    <li><a href="#">3</a></li>

                    <li><a href="#">»</a></li>

                </ul>-->

                <?php echo $model->phantrang($page, PAGE_SHOW, $total_page, $link); ?>

            </div>

        </div><!-- /.box -->

    </div><!-- /.col -->



</div>