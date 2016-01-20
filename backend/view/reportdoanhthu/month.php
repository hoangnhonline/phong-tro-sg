<?php
if($_SESSION['level']==1){
    $user_id = isset($_GET['user_id']) ? (int) $_GET['user_id'] : -1;    
}else{
   $user_id = $_SESSION['user_id']; 
}
require_once "model/Backend.php";
$model = new Backend;
$link = "index.php?mod=doanhthu&act=list";

if (isset($_GET['contract_id']) && $_GET['contract_id'] > 0) {
    $contract_id = (int) $_GET['contract_id'];    
    $detail = $model->getDetail('contract', $contract_id);
} else {
    $contract_id = -1;
}
$month = isset($_GET['month']) ? (int) $_GET['month'] : -1;
$year = isset($_GET['year']) ? (int) $_GET['year'] : -1;
$arrList = $model->getDoanhThuMonthUser($user_id, $month, $year);
$modArr = $model->getList('users', -1, -1, array('level' => 2));
?>
<form id="exportForm" action="export.php">
    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
    <input type="hidden" name="year" value="<?php echo $year; ?>">
    <input type="hidden" name="month" value="<?php echo $month; ?>">       
</form>
<div class="row">
    <div class="col-md-12">    
        <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=reportdoanhthu&act=list'">Xem tổng doanh tu</button>
         <div class="box-header">
                <h3 class="box-title">Report chi tiết doanh thu : <span style="color:red"> tháng <?php echo str_pad($month, 2, "0", STR_PAD_LEFT ); ?> - <?php echo $year; ?></span>
                    <?php if($user_id > 0){ ?>
                    của mod <span style="color:blue"><?php echo $model->getNameById('users', $user_id); ?></span>
                    <?php } ?>

                </h3>
            </div><!-- /.box-header -->
        <div class="box">

            <div class="box-body">
                <div class="panel panel-default">
                  <div class="panel-heading">Tìm kiếm</div>
                  <div class="panel-body">
                    <form class="form-inline">
                        <input type="hidden" name="mod" value="reportdoanhthu" />
                        <input type="hidden" name="act" value="month" />
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="city_id">Tháng</label><br >
                            <select class="form-control" name="month" id="month">                             
                                <?php for($i = 1 ; $i < 13; $i++) { ?>
                                <option value="<?php echo $i; ?>" <?php if($i==$month) echo "selected"; ?>>
                                    Tháng <?php echo $i ;?>
                                </option>
                                <?php } ?>
                            </select>
                          </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="district_id">Năm</label><br >
                            <select class="form-control" name="year" id="year">                         
                                <?php for($i = date('Y') - 5 ; $i <= date('Y') + 1; $i++) { ?>
                                <option value="<?php echo $i; ?>" <?php if($i==$year) echo "selected"; ?>>
                                    <?php echo $i ;?>
                                </option>
                                <?php } ?>
                            </select>
                          </div>
                    </div>
                    <?php if($_SESSION['level']==1){ ?>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="district_id">Mod</label><br >
                            <select class="form-control" name="user_id" id="user_id">                          
                                <?php if(!empty($modArr['data'])){ 
                                    foreach ($modArr['data'] as $key => $value) {                                        
                                ?>
                                <option value="<?php echo $value['id']; ?>" <?php if($value['id']==$user_id) echo "selected"; ?>>
                                    <?php echo $value['name'] ;?>
                                </option>
                                <?php } }  ?>
                            </select>
                          </div>
                    </div>
                    <?php } ?>
                    <div class="col-md-<?php echo ($_SESSION['level']==1) ? "6" : "8" ; ?>"><br >
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                        <?php if(!empty($arrList)){ ?>
                        <button class="btn btn-primary right" type="button" id="btnExport">Export</button>
                        <?php } ?>
                    </div>
                      
                      
                      
                    </form>
                  </div>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody><tr>
                        <th width="1%">No.</th>                 
                        <th>Mã HĐ</th>                                                
                        <th style="text-align:right">Doanh thu</th>
                        <th style="text-align:right">Công nợ</th>
                        <th style="width: 40px">Action</th>
                    </tr>
                    <?php
                    
                    $doanhthu = $congno = $i = 0;
                    if(!empty($arrList)){
                    foreach ($arrList  as $key => $row) {
                        $doanhthu += $row['doanhthu'];
                        
                        $congno += $row['congno'];
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        
                        <td>
                            <?php echo $model->getContractCodeById($row['contract_id']); ?>
                        </td>                                                
                        <td style="text-align:right"><?php echo number_format($row['doanhthu']); ?></td>
                        <td style="text-align:right"><?php echo number_format($row['congno']); ?></td>                        
                        <td style="white-space:nowrap">
                            <a href="index.php?mod=doanhthu&act=view&id=<?php echo $row['id']; ?>&contract_id=<?php echo $row['contract_id']; ?>">
                                <i class="fa fa-fw fa-edit"></i>
                            </a>                          

                        </td>
                    </tr>
                    <?php } }  ?>
                    <tr>
                        <th style="text-align:right;font-size:20px" colspan="2">Tổng cộng</th>
                        <td style="text-align:right;font-size:20px"><?php echo number_format($doanhthu); ?></td>
                        <td style="text-align:right;font-size:20px"><?php echo number_format($congno); ?></td>                        
                        <td>&nbsp;</td>
                    </tr>
                </tbody></table>
            </div><!-- /.box-body -->            
        </div><!-- /.box -->
    </div><!-- /.col -->

</div>
<script type="text/javascript">
$(document).ready(function(){
     $('#btnExport').click(function(){
        $('#exportForm').submit();
    });
});
</script>