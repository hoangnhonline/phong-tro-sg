<?php 
include "defined.php";
?>
<html>
<!--<![endif]-->
<head>
<meta charset="utf-8" />
 <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<!-- bootstrap 3.0.2 -->
<link href="<?php echo STATIC_URL; ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />

<!-- font Awesome -->
<link href="<?php echo STATIC_URL; ?>css/font-awesome.min.css" rel="stylesheet" type="text/css" />        
<!-- Theme style -->
<link href="<?php echo STATIC_URL; ?>css/AdminLTE.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
  <!-- jQuery 2.0.2 -->
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script src="<?php echo STATIC_URL; ?>js/form.js" type="text/javascript"></script>
   
<!-- Bootstrap -->
<script src="<?php echo STATIC_URL; ?>js/bootstrap.min.js" type="text/javascript"></script>
   <script src="js/bootstrap-select.min.js" type="text/javascript"></script>         
<?php
require_once "model/Backend.php";
$model = new Backend;
$id = 0;
if(isset($_GET['id'])){
    $id = (int) $_GET['id'];
    $contract_id = (int) $_GET['contract_id'];
    require_once "model/Backend.php";
    $model = new Backend;
    $detail = $model->getDetail("doanh_thu",$id);
    $detailHD = $model->getDetail('contract', $contract_id);
    $object_id = $detailHD['object_id'];
    $detailTS = $model->getDetail('objects', $object_id);
    $name = $detailTS['name'];
    $arrPriceDT = $model->getDoanhThuThang($id, 1);    
    $arrServiceDT = $model->getDoanhThuThang($id, 2);    
    $arrConvenientDT = $model->getDoanhThuThang($id, 3);    
    $arrService = $model->getList('services', -1, -1); 
    $arrCon = $model->getList('convenient', -1, -1);    
}
?>
</head>
<body>
<div class="row" style="padding:20px">   

<div class="col-md-12">  
    
     
    <div style="clear:both;margin-bottom:10px"></div>

     <div class="box-header">

        <h3 class="box-title">HÓA ĐƠN <?php echo str_pad($detail['month'], 2, '0', STR_PAD_LEFT); ?>-<?php echo $detail['year']; ?> [<?php echo $detailHD['code']; ?>] [<?php echo $name; ?>]</h3>
        
    </div><!-- /.box-header -->
    <div class="box-body">
    	<div class="row">
        	<div class="col-md-6">
	        	<table class="table table-bordered" style="width:500px">
	        		<tr>
	        			<th style="background:#CCC;text-transform:uppercase;text-align:center" colspan='2'>Thông tin chi tiết</th>	        			
	        		</tr>
                    <?php 
                    if(!empty($arrPriceDT)){

                        foreach ($arrPriceDT as $key => $value) {
                            
                    ?>
                    <tr>
                        <th style='width:50%'>
                            <?php 
                            echo "Tiền nhà/phòng";
                          
                            ?></th>
                        <td style="text-align:right;font-weight:bold"><?php echo number_format($value['total_price']); ?></td>
                    </tr>
                    <?php }}?>
                    <tr>
                        <th colspan="2" style='background-color:#CCC'>
                            Tiền dịch vụ
                        </th>
                    </tr>
                    <?php 
                    if(!empty($arrServiceDT)){

                        foreach ($arrServiceDT as $key => $value) {
                            
                    ?>
                    <tr>
                        <th style='width:50%'>
                            <?php 
                           
                           echo $arrService['data'][$value['service_id']]['name'];
                            
                            ?></th>
                        <td style="text-align:right;font-weight:bold"><?php echo number_format($value['total_price']); ?></td>
                    </tr>
                    <?php }}?>
                    <tr>
                        <th colspan="2"  style='background-color:#CCC'>
                            Tiền tiện nghi
                        </th>
                    </tr>
                    <?php 
                    if(!empty($arrConvenientDT)){

                        foreach ($arrConvenientDT as $key => $value) {
                            
                    ?>
                    <tr>
                        <th style='width:50%'>
                            <?php                                 
                            echo $arrCon['data'][$value['service_id']]['name'];
                            ?></th>
                        <td style="text-align:right;font-weight:bold"><?php echo number_format($value['total_price']); ?></td>
                    </tr>
                    <?php }}?>
	        		<tr>
	        			<th style='width:30%;font-size:18px;font-weight:bold;background-color:#CCC'>Tiền phải thu</th>
	        			<td style="text-align:right;font-size:18px;font-weight:bold;background-color:#CCC"><?php echo number_format($detail['tien_phai_thu']); ?></td>
	        		</tr>
	        		<tr>
	        			<th style='width:30%'>Số tiền nhận</th>
	        			<td style="text-align:right;font-weight:bold"><?php echo number_format($detail['tien_nhan']); ?></td>
	        		</tr>
	        		<tr>
	        			<th style='width:30%'>Công nợ</th>
	        			<td style="text-align:right;font-weight:bold"><?php echo number_format($detail['cong_no']); ?></td>
	        		</tr>		        		
	        	</table>	        		        	
                
        	</div>
        	

	        </div>
           
        </div>  

</div>
</body>
</html>