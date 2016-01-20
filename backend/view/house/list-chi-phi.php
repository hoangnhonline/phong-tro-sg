<?php
if($_SESSION['level']==1){
    $user_id = isset($_GET['user_id']) ? (int) $_GET['user_id'] : -1;    
}else{
   $user_id = $_SESSION['user_id']; 
}


require_once "model/Backend.php";
$model = new Backend;
$link = "index.php?mod=doanhthu&act=list";
$detail = array();
if (isset($_GET['house_id']) && $_GET['house_id'] > 0) {
    $house_id = (int) $_GET['house_id'];    
    $detail = $model->getDetail('house', $house_id);
} else {
    $house_id = -1;
}
$month = isset($_GET['month']) ? (int) $_GET['month'] : -1;
$year = isset($_GET['year']) ? (int) $_GET['year'] : -1;
if($_SESSION['level']==1){
    $user_id = -1;    
}else{
    $user_id = $_SESSION['user_id'];    
}
$arrList = $model->getChiPhiTotalHouse($house_id, $user_id, $month, $year);
$modArr = $model->getList('users', -1, -1, array('level' => 2));


/* get list house */
$arrCustom = array('type' => 1);
if($_SESSION['level']==1){
    $arrCustom['user_id'] = -1;    
}else{
    $arrCustom['user_id'] = $_SESSION['user_id'];    
}
foreach ($arrCustom as $key => $value) {
    if ((isset($_GET[$key]) && $_GET[$key] > 0) || (isset($_GET[$key]) &&  $_GET[$key] != '' && $_GET[$key] != '-1' && $_GET[$key] != '0')) {
        $tmp = $_GET[$key];
        $link.="&".$key."=".$tmp;
        $arrCustom[$key] = $tmp;
    }
}
$houseArr = $model->getList('house', -1, -1, $arrCustom);
?>
<div class="row">
    <div class="col-md-12">    
         <div class="box-header">
                <h3 class="box-title">Danh sách chi phí 
                    <?php 
                    if($house_id > 0){
                        echo " nhà : ".$detail['name'];
                    }else{
                        echo ": Tất cả nhà";
                    }
                    ?>
                </h3>
            </div><!-- /.box-header -->
        <div class="box">

            <div class="box-body">
                <div class="panel panel-default">
                  <div class="panel-heading">Tìm kiếm</div>
                  <div class="panel-body">
                    <form class="form-inline">
                        <input type="hidden" name="mod" value="house" />
                        <input type="hidden" name="act" value="list-chi-phi" />
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="city_id">Tháng</label><br >
                            <select class="form-control" name="month" id="month">
                                <option value="-1">---Tất cả---</option>
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
                                <option value="-1">---Tất cả---</option>
                                <?php for($i = date('Y') - 5 ; $i <= date('Y') + 1; $i++) { ?>
                                <option value="<?php echo $i; ?>" <?php if($i==$year) echo "selected"; ?>>
                                    <?php echo $i ;?>
                                </option>
                                <?php } ?>
                            </select>
                          </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="district_id">Nhà</label><br >
                            <select class="form-control" name="house_id" id="house_id">
                                <option value="-1">---Tất cả---</option>
                                <?php foreach($houseArr['data'] as $v) { ?>
                                <option <?php echo (isset($_GET['house_id']) && $_GET['house_id']==$v['id']) ? "selected" : ""; ?> value="<?php echo $v['id']; ?>">
                                    <?php echo $v['name']; ?>
                                </option>
                                <?php } ?>
                            </select>
                          </div>
                    </div>
                    <div class="col-md-6"><br >
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>                        
                    </div>
                      
                      
                      
                    </form>
                  </div>
                </div>
                <div class="col-md-12" style="margin-bottom:10px">
                <?php if($house_id > 0) { ?>
                <a class="btn btn-primary" style='float:right' href="index.php?mod=house&act=chi-phi&id=<?php echo $house_id; ?>">Thêm chi phí</a>
                <?php } ?>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody><tr>
                        <th width="1%">No.</th>  
                                     
                        <th>Tháng - Năm</th> 
                             
                        <th>Chi tiết</th>               
                        
                        <th style="text-align:right">Chi phí</th>                     
                    </tr>
                    <?php
                    
                    $total = $i = 0;
                    if(!empty($arrList)){
                    foreach ($arrList  as $key => $row) {                        
                        $total += $row['chi_phi'];                       
                        
                    $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        
                        <td>
                            <a target="_blank" href="index.php?mod=list-chi-phi&act=month&month=<?php echo $row['month']; ?>&year=<?php echo $row['year']?><?php echo ($user_id > 0 && $_SESSION['level']==1) ? '&user_id='.$user_id : '';?>">
                                <?php echo str_pad($row['month'], 2, "0", STR_PAD_LEFT ); ?> - <?php echo $row['year']; ?>
                            </a>
                        </td>   
                        <?php if($house_id ==-1){ ?>
                        <td>
                           
                            <?php 
                            foreach ($houseArr['data'] as $house) {                                
                                if($model->getChiPhiByHouse($house['id'], $row['month'], $row['year']) > 0){
                                    $ctArr = $model->getChiPhiDetailHouse($house['id'], $row['month'], $row['year']);
                                    ?>
                                    <p><?php echo $house['name']; ?></p>
                                    <ul>
                                    <?php
                                    foreach ($ctArr as $k => $value) {
                                        ?>
                                        <li><span><?php echo $value['name']; ?></span> : <?php echo number_format($value['price']); ?></li>
                                        <?php
                                    }
                                    ?>
                                    </ul>
                                    <?php
                                }
                            }
                            
                            ?>
                            </ul>
                        </td>  
                        <?php } else{ ?> 
                        <td>
                            <?php
                            $ctArr = $model->getChiPhiDetailHouse($house_id, $row['month'], $row['year']);
                                    ?>
                                    <p><?php echo $house['name']; ?></p>
                                    <ul>
                                    <?php
                                    foreach ($ctArr as $k => $value) {
                                        ?>
                                        <li><span><?php echo $value['name']; ?></span> : <?php echo number_format($value['price']); ?></li>
                                        <?php
                                    }
                                    ?>
                                    </ul>
                        </td>                 
                        <?php } ?>
              
                        <td style="text-align:right"><?php echo number_format($row['chi_phi']); ?></td>                                                                    
                       
                    </tr>
                    <?php } }  ?>
                    <tr>
                        <th style="text-align:right;font-size:20px" colspan="3">Tổng cộng</th>
                        <td style="text-align:right;font-size:20px"><?php echo number_format($total); ?></td>                        
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
