<?php
require_once "model/Backend.php";
$model = new Backend;
$link = "index.php?mod=doanhthu&act=list";

if (isset($_GET['contract_id']) && $_GET['contract_id'] > 0) {
    $contract_id = (int) $_GET['contract_id'];    
    $detail = $model->getDetail('contract', $contract_id);
} else {
    $contract_id = -1;
}

$limit = "100";
$table = "doanh_thu";

$listTotal = $model->getList($table, -1, -1, array('contract_id' => $contract_id));

$total_record = $listTotal['total'];

$total_page = ceil($total_record / $limit);

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

$offset = $limit * ($page - 1);

$list = $model->getList($table, $offset, $limit, array('contract_id' => $contract_id));

?>
<div class="row">
    <div class="col-md-12">
        <?php if($detail['status']==1){ ?>
    <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=doanhthu&act=form&contract_id=<?php echo $contract_id; ?>'">Thêm mới doanh thu tháng</button>
    <?php } ?>
         <div class="box-header">
                <h3 class="box-title">Chi tiết doanh thu của HD : <?php echo $detail['code']?></h3>
            </div><!-- /.box-header -->
        <div class="box">

            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <tbody><tr>
                        <th width="1%">No.</th>                 
                        <th>Tháng - Năm</th>                        
                        <th style="text-align:right">Tổng tiền</th>
                        <th style="text-align:right">Tiền thu</th>
                        <th style="text-align:right">Công nợ</th>
                        <th style="width: 40px">Action</th>
                    </tr>
                    <?php
                    $i = ($page-1) * $limit;
                    $total = $nhan = $no = 0;
                    if(!empty($list['data'])){
                    foreach ($list['data'] as $key => $row) {                        
                        $total += $row['tien_phai_thu'];
                        $nhan += $row['tien_nhan'];
                        $no += $row['cong_no'];
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        
                        <td>
                            <a href="index.php?mod=addon&act=form&id=<?php echo $row['id']; ?>">
                                <?php echo str_pad($row['month'], 2, "0", STR_PAD_LEFT ); ?> - <?php echo $row['year']; ?>
                            </a>
                        </td>                        
                        <td style="text-align:right"><?php echo number_format($row['tien_phai_thu']); ?></td>
                        <td style="text-align:right"><?php echo number_format($row['tien_nhan']); ?></td>
                        <td style="text-align:right"><?php echo number_format($row['cong_no']); ?></td>                        
                        <td style="white-space:nowrap">
                            <a class="btn btn-sm btn-success" target="_blank" href="print.php?id=<?php echo $row['id']; ?>&contract_id=<?php echo $contract_id; ?>">
                                In
                            </a>
                            <?php if($detail['status']==1){ ?>
                            <a class="btn btn-sm btn-warning" href="index.php?mod=doanhthu&act=view&id=<?php echo $row['id']; ?>&contract_id=<?php echo $contract_id; ?>" title="Xem chi tiết">
                                Chỉnh sửa
                            </a>
                            <a class="btn btn-sm btn-danger" href="index.php?mod=doanhthu&act=edit&id=<?php echo $row['id']; ?>&contract_id=<?php echo $contract_id; ?>">
                                Xóa
                            </a>                            

<?php } ?>
                        </td>
                    </tr>
                    <?php } }  ?>
                    <tr>
                        <th style="text-align:right;font-size:20px" colspan="2">Tổng cộng</th>
                        <td style="text-align:right;font-size:20px"><?php echo number_format($total); ?></td>
                        <td style="text-align:right;font-size:20px"><?php echo number_format($nhan); ?></td>
                        <td style="text-align:right;font-size:20px"><?php echo number_format($no); ?></td>
                        <td>&nbsp;</td>
                    </tr>
                </tbody></table>
            </div><!-- /.box-body -->            
        </div><!-- /.box -->
    </div><!-- /.col -->

</div>