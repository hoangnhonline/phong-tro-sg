<?php
require_once "model/Backend.php";
$model = new Backend;
$link = "index.php?mod=price&act=list";


$table = "price";
$listTotal = $model->getList($table, -1, -1);

$total_record = $listTotal['total'];

$total_page = ceil($total_record / LIMIT);

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

$offset = LIMIT * ($page - 1);

$list = $model->getList($table, $offset, LIMIT);

?>
<div class="row">
    <div class="col-md-12">
    <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=price&act=form'">Tạo mới</button>
         <div class="box-header">
                <h3 class="box-title">Danh sách khoảng giá</h3>
            </div><!-- /.box-header -->
        <div class="box">

            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <tbody><tr>
                        <th style="width: 10px">No.</th>
                        <th>Khoảng giá</th>
                        <th>Áp dụng cho</th>
                        <th>Ngày tạo</th>
                        <th style="width: 40px">Action</th>
                    </tr>
                   <?php
                    $i = ($page-1) * LIMIT;
                    if(!empty($list['data'])){
                    foreach ($list['data'] as $key => $row) {
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['type'] == 1 ? "BDS cho thuê" : "BĐS bán"; ?></td>
                        <td><?php echo date('d-m-Y',$row['created_at']); ?></td>
                        <td style="white-space:nowrap">
                            <a href="index.php?mod=price&act=form&id=<?php echo $row['id']; ?>">
                                Chỉnh sửa
                            </a>
                            <a href="javascript:;" alias="<?php echo $row['name']; ?>" id="<?php echo $row['id']; ?>" mod="price" class="btn btn-sm btn-danger link_delete" >
                                Xóa
                            </a>

                        </td>
                    </tr>
                    <?php } } ?>
                </tbody></table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">             
                <?php echo $model->phantrang($page, PAGE_SHOW, $total_page, $link); ?>
            </div>
        </div><!-- /.box -->
    </div><!-- /.col -->

</div>