<?php
require_once "model/Backend.php";
$model = new Backend;
$link = "index.php?mod=convenient&act=list";

if (isset($_GET['status']) && $_GET['status'] > 0) {
    $lang_id = (int) $_GET['status'];
    $status.="&status=$status";
} else {
    $status = -1;
}
$table = "convenient";
$listTotal = $model->getList($table, -1, -1);

$total_record = $listTotal['total'];

$total_page = ceil($total_record / LIMIT);

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

$offset = LIMIT * ($page - 1);

$list = $model->getList($table, $offset, LIMIT);

?>
<div class="row">
    <div class="col-md-12">
    <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=convenient&act=form'">Tạo mới</button>
         <div class="box-header">
                <h3 class="box-title">Danh sách tiện nghi</h3>
            </div><!-- /.box-header -->
        <div class="box">

            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <tbody><tr>
                        <th width="1%">No.</th>
                        <th width="1%">Hình ảnh</th>
                        <th>Tên</th>
                        <th>Giá</th>
                        <th>Mô tả</th>
                        <th>Ngày tạo</th>
                        <th>Cập nhật lần cuối</th>
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
                        <td>
                            <?php if(!empty($row['image_url'])){ ?>
                            <img id="img_thumnails" src="../<?php echo $row['image_url']; ?>" height="70" />
                            <?php }else{ ?>
                            <img id="img_thumnails" src="static/img/no_image.jpg" width="70" />
                            <?php } ?>
                        </td>
                        <td>
                            <a href="index.php?mod=convenient&act=form&id=<?php echo $row['id']; ?>">
                                <?php echo $row['name']; ?>
                            </a>
                        </td>
                        <td><?php if($row['price'] > 0) { echo number_format($row['price']);} else { echo $row['price']; } ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo date('d-m-Y H:i',$row['created_at']); ?></td>
                        <td><?php echo date('d-m-Y H:i',$row['updated_at']); ?></td>
                        <td style="white-space:nowrap">
                            <a href="index.php?mod=convenient&act=form&id=<?php echo $row['id']; ?>">
                                <i class="fa fa-fw fa-edit"></i>
                            </a>
                            <a href="javascript:;" alias="<?php echo $row['name']; ?>" id="<?php echo $row['id']; ?>" mod="convenient" class="link_delete" >
                                <i class="fa fa-fw fa-trash-o"></i>
                            </a>

                        </td>
                    </tr>
                    <?php } }  ?>
                </tbody></table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">               
                <?php echo $model->phantrang($page, PAGE_SHOW, $total_page, $link); ?>
            </div>
        </div><!-- /.box -->
    </div><!-- /.col -->

</div>