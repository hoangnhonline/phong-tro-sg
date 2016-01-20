<?php
$id = 0;
if(isset($_GET['id'])){
    $id = (int) $_GET['id'];
    $contract_id = (int) $_GET['contract_id'];
    require_once "model/Backend.php";
    $model = new Backend;
    $detail = $model->getDetail("doanh_thu",$id);
    $detailHD = $model->getDetail('contract', $contract_id);

    $arrPriceDT = $model->getDoanhThuThang($id, 1);    
    $arrServiceDT = $model->getDoanhThuThang($id, 2);    
    $arrConvenientDT = $model->getDoanhThuThang($id, 3);    
    $arrService = $model->getList('services', -1, -1); 
    $arrCon = $model->getList('convenient', -1, -1);    
}
?>
<div class="row">   
   
    <div class="col-md-12">

        <!-- Custom Tabs -->

        <button class="btn btn-default btn-sm" onclick="location.href='index.php?mod=doanhthu&act=list&contract_id=<?php echo $contract_id; ?>'">Quay lại</button>
        <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=doanhthu&act=form&id=<?php echo $id; ?>&contract_id=<?php echo $contract_id; ?>'">Chỉnh sửa</button>
        
         
        <div style="clear:both;margin-bottom:10px"></div>

         <div class="box-header">

            <h3 class="box-title">Chi tiết doanh thu HD : <?php echo $detailHD['code']; ?> thang <?php echo $detail['month']; ?>-<?php echo $detail['year']; ?></h3>
            
        </div><!-- /.box-header -->
        <div class="box-body">
        	<div class="row">
	        	<div class="col-md-6">
		        	<table class="table table-bordered" style="width:500px">
		        		<tr>
		        			<th style="background:#134a24;color:#FFF;text-transform:uppercase;text-align:center" colspan='2'>Thông tin chi tiết</th>	        			
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
		        			<th style='width:30%;font-size:18px;font-weight:bold;color:red'>Tiền phải thu</th>
		        			<td style="text-align:right;font-size:18px;font-weight:bold;color:red"><?php echo number_format($detail['tien_phai_thu']); ?></td>
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
