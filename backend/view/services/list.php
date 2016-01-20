<?php
require_once "model/Backend.php";
$model = new Backend;
$link = "index.php?mod=services&act=list";

if (isset($_GET['status']) && $_GET['status'] > 0) {
    $lang_id = (int) $_GET['status'];
    $status.="&status=$status";
} else {
    $status = -1;
}
$table = "services";
$listTotal = $model->getList($table, -1, -1);

$total_record = $listTotal['total'];

$total_page = ceil($total_record / LIMIT);

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

$offset = LIMIT * ($page - 1);

$list = $model->getList($table, $offset, LIMIT);

?>
<div class="row">
    <div class="col-md-12">
    <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=services&act=form'">Tạo mới</button>
         <div class="box-header">
                <h3 class="box-title">Danh sách dịch vụ</h3>
            </div><!-- /.box-header -->
        <div class="box">

            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <tbody><tr>
                        <th width="1%">No.</th>                        
                        <th>Tên</th>
                        <th style="text-align:right">Giá mặc định</th>
                        <th style="text-align:right">Tính theo</th>
                        <th style="text-align:center">Ngày tạo</th>
                        <th style="text-align:center">Cập nhật lần cuối</th>
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
                            <a href="index.php?mod=services&act=form&id=<?php echo $row['id']; ?>">
                                <?php echo $row['name']; ?>
                            </a>
                        </td>
                        <td align="right"><?php if($row['price'] > 0) { echo number_format($row['price']);} else { echo $row['price']; } ?></td>
                        <td align="right">
                            <?php if($row['cal_type'] == 1) echo "Phòng" ;
                            if($row['cal_type'] == 2) echo "Số lượng người" ;
                            if($row['cal_type'] == 3) echo "Số lượng sử dụng" ; ?>
                        </td> 
                        <td align="center"><?php echo date('d-m-Y H:i',$row['created_at']); ?></td>
                        <td align="center"><?php echo date('d-m-Y H:i',$row['updated_at']); ?></td>
                        <td style="white-space:nowrap">
                            <a href="index.php?mod=services&act=form&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">
                                Chỉnh sửa
                            </a>
                            <?php if($row['id'] > 2){ ?>
                            <a href="javascript:;" alias="<?php echo $row['name']; ?>" id="<?php echo $row['id']; ?>" mod="services" class="btn btn-sm btn-danger link_delete" >
                                Xóa
                            </a>
                            <?php } ?>
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