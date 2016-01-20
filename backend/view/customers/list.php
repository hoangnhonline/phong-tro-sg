<?php
require_once "model/Backend.php";
$model = new Backend;
$link = "index.php?mod=customers&act=list";

$table = "customers";
if($_SESSION['level']==1){
    $arrCustom['user_id'] = -1;    
}else{
    $arrCustom['user_id'] = $_SESSION['user_id'];    
}
$arrCustom['is_main'] = 1;
$listTotal = $model->getList($table, -1, -1, $arrCustom);

$total_record = $listTotal['total'];

$total_page = ceil($total_record / LIMIT);

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

$offset = LIMIT * ($page - 1);

$list = $model->getList($table, $offset, LIMIT, $arrCustom);

?>
<div class="row">
    <div class="col-md-12">
    <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=customers&act=form'">Tạo mới</button>
         <div class="box-header">
                <h3 class="box-title">Danh sách khách hàng</h3>
            </div><!-- /.box-header -->
        <div class="box">

            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <tbody><tr>
                        <th width="1%">No.</th>                        
                        <th>Tên</th>
                        <th>Giới tính</th>
                        <th>Ngày sinh</th>
                        <th>Điện Thoại</th>                        
                        <th>Email</th>
                        <th>Đc/Quê quán</th>
                        <?php if($_SESSION['user_id'] ==1){ ?>
                        <th>User tạo</th>
                        <?php } ?>
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
                            <a href="index.php?mod=customers&act=form&id=<?php echo $row['id']; ?>">
                                <?php echo $row['name']; ?>
                            </a>
                        </td>
                        <td><?php if($row['gender'] == 1) { echo "Nam";} else { echo "Nữ"; } ?></td>
                        <td><?php echo $row['birthday']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['address'] ?></td>                        
                        <td style="white-space:nowrap">
                            <a class="btn btn-sm btn-warning" href="index.php?mod=customers&act=form&id=<?php echo $row['id']; ?>">
                                
                            </a>
                            <a class="btn btn-sm btn-danger" href="javascript:;" alias="<?php echo $row['name']; ?>" id="<?php echo $row['id']; ?>" mod="customers" class="btn btn-sm btn-danger link_delete" >
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