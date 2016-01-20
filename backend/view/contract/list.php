<?php
require_once "model/Backend.php";
$model = new Backend;

$cityArr = $model->getList('city', -1, -1);
$districtArr = $model->getList('district', -1, -1);
$wardArr = $model->getList('ward', -1, -1);
$houseArr = $model->getList('house', -1, -1);
$link = "index.php?mod=contract&act=list";

$arrCustom = array('code' => '');

if($_SESSION['level']==1){
    $arrCustom['user_id'] = -1;    
}else{
    $arrCustom['user_id'] = $_SESSION['user_id'];    
}
foreach ($arrCustom as $key => $value) {
    if ((isset($_GET[$key]) && $_GET[$key] > 0) || (isset($_GET[$key]) && $_GET[$key] != '' && $_GET[$key] != '-1' && $_GET[$key] != '0')) {
        $tmp = $_GET[$key];
        $link.="&".$key."=".$tmp;
        $arrCustom[$key] = $tmp;
    }
}
$table = "contract";

$listTotal = $model->getList($table, -1, -1, $arrCustom);

$total_record = $listTotal['total'];

$total_page = ceil($total_record / LIMIT);

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

$offset = LIMIT * ($page - 1);

$list = $model->getList($table, $offset, LIMIT, $arrCustom);

?>
<div class="row">
    <div class="col-md-12">    
         <div class="box-header">
                <h3 class="box-title">Danh sách hợp đồng</h3>
            </div><!-- /.box-header -->
        <div class="box">

            <div class="box-body">     
             <div class="panel panel-default">
                  <div class="panel-heading">Tìm kiếm</div>
                  <div class="panel-body">
                    <form class="form-inline">
                        <input type="hidden" name="mod" value="contract" />
                        <input type="hidden" name="act" value="list" />
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="code">Mã HD</label><br>
                           <input name="code" id="code" class="form-control" value="<?php echo (isset($_GET['code']) && $_GET['code']!= '') ? $_GET['code'] : ""; ?>">
                          </div>
                    </div>                    
                    <div class="col-md-2"><br >
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </div>
                      
                      
                      
                    </form>
                  </div>
                </div>         
                <table class="table table-bordered table-striped">
                    <tbody><tr>
                        <th width="1%">No.</th>                        
                        <th>Thông tin chung</th>
                        <th style="text-align:right">Giá thuê</th>
                        <th style="text-align:center">Số người ở</th>
                        <th style="text-align:center">Thời hạn</th>
                        <th style="text-align:center">Ngày bắt đầu</th>
                        <th style="text-align:center">Ngày kết thúc</th>
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
                            <a href="index.php?mod=contract&act=edit&id=<?php echo $row['id']; ?>">
                                <?php echo $row['code']; ?>
                            </a>                       
                            <br />     
                            <?php
                            $detail = $model->getDetail("objects", $row['object_id']);                            
                            ?>

                            <?php echo $row['object_type'] == 1 ? "Phòng" : "Nhà" ;?> : 
                            <a href="index.php?mod=<?php echo $table; ?>&act=form&id=<?php echo $row['object_id']; ?>" target="_blank">
                            <?php echo $detail['name']; ?>
                            </a>
                            <br />
                            Người thuê : 
                            <a href="index.php?mod=customers&act=form&id=<?php echo $row['customer_id']; ?>" target="_blank">
                            <?php echo $model->getNameById("customers", $row['customer_id']); ?>
                            </a>
                        </td>      
                        <td style="text-align:right"><?php echo number_format($row['price']); ?></td>
                        <td style="text-align:center"><?php echo number_format($row['no_person']); ?></td>
                        <td style="text-align:center"><?php echo $row['no_month']; ?> tháng</td>
                        <td style="text-align:center"><?php echo date('d-m-Y', strtotime($row['start_date'])); ?></td>
                        <td style="text-align:center"><?php echo date('d-m-Y', strtotime($row['end_date'])); ?></td>                        
                        <td style="white-space:nowrap">
                            <a href="index.php?mod=doanhthu&act=list&contract_id=<?php echo $row['id']; ?>" title="xem doanh thu">
                                <i class="fa fa-fw fa-book"></i>
                            </a>
                            <a href="index.php?mod=contract&act=edit&id=<?php echo $row['id']; ?>">
                                <i class="fa fa-fw fa-edit"></i>
                            </a>
                            <a href="javascript:;" alias="<?php echo $row['code']; ?>" id="<?php echo $row['id']; ?>" mod="contract" class="link_delete" >
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
