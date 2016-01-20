<?php
require_once "model/Backend.php";
$model = new Backend;
$link = "index.php?mod=album&act=list";

if (isset($_GET['status']) && $_GET['status'] > 0) {
    $lang_id = (int) $_GET['status'];
    $status.="&status=$status";
} else {
    $status = -1;
}
$table = "album";
$listTotal = $model->getList($table, -1, -1);

$total_record = $listTotal['total'];

$total_page = ceil($total_record / LIMIT);

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

$offset = LIMIT * ($page - 1);

$list = $model->getList($table, $offset, LIMIT);

?>
<div class="row">
    <div class="col-md-12">
    <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=album&act=form'">Add new</button>
         <div class="box-header">
                <h2 class="box-title" style="text-tranform:uppercase !important;color: #B10007">ALBUM LIST</h2>
            </div><!-- /.box-header -->
        <div class="box">

            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <tbody><tr>
                        <th width="1%">No.</th>
                        <th width="140px">Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Date Taken</th>
                        <th>Created At</th>
                        <th>Last updated</th>
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
                            <img id="img_thumnails" class="img-thumbnail lazy" data-original="../<?php echo $row['image_url']; ?>" width="120" />
                            <?php }else{ ?>
                            <img id="img_thumnails" class="img-thumbnail lazy" data-original="static/img/no_image.jpg" width="120" />
                            <?php } ?>
                        </td>
                        <td>
                            <a href="index.php?mod=album&act=form&id=<?php echo $row['id']; ?>">
                                <?php echo $row['name']; ?>
                            </a>
                        </td>
                        <td><?php echo $row['category_id']; ?></td>
                        <td><?php echo $row['date_taken']; ?></td>
                        <td><?php echo date('d-m-Y H:i',$row['created_at']); ?></td>
                        <td><?php echo date('d-m-Y H:i',$row['updated_at']); ?></td>
                        <td style="white-space:nowrap">
                            <a href="index.php?mod=album&act=form&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">
                                Chỉnh sửa
                            </a>
                            <a href="javascript:;" alias="<?php echo $row['name']; ?>" id="<?php echo $row['id']; ?>" mod="album" class="btn btn-sm btn-danger link_delete" >
                                Xóa
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