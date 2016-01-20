<?php 
if($_SESSION['level']==1){
    $user_id = isset($_GET['user_id']) ? (int) $_GET['user_id'] : -1;    
}else{
   $user_id = $_SESSION['user_id']; 
}
?>
<div class="row">
    <div class="col-md-12">   

     	<div class="box-header">

            <h3 class="box-title">THỐNG KÊ</h3>

        </div><!-- /.box-header -->
        <div class="box-body">
        	<div class="row">
        	<div class="col-md-4">
	        	<table class="table table-bordered">
	        		<tr>
	        			<th colspan="2" style="text-align:center">
	        				NHÀ CHO THUÊ
	        			</th>        			
	        		</tr>
	        		<tr>
	        			<th width="50%">
	        				<span class="label label-lg label-success">Đang trống</span>
	        			</th>
	        			<td>
                            <a target="_blank" href="index.php?mod=houserent&act=list&status=1"><?php echo $a1 = $model->countObject(2, 1, $user_id); ?></a>
	        			</td>
	        		</tr>
	        		<tr>
	        			<th>
	        				<span class="label label-warning">Đã cọc</span>
	        			</th>
	        			<td>
                            <a target="_blank" href="index.php?mod=houserent&act=list&status=2"><?php echo $b1 = $model->countObject(2, 2, $user_id); ?></a>
	        			</td>
	        		</tr>
	        		<tr>
	        			<th>
	        				<span class="label label-primary">Đang ở</span>
	        			</th>
	        			<td>
                            <a target="_blank" href="index.php?mod=houserent&act=list&status=3"><?php echo $c1 = $model->countObject(2, 3, $user_id); ?></a>
	        			</td>
	        		</tr>
	        		<tr>
	        			<th>
	        				<span class="label label-danger">Chờ gia hạn</span>
	        			</th>
	        			<td>
                            <a target="_blank" href="index.php?mod=houserent&act=list&status=4"><?php echo $d1 = $model->countObject(2, 4, $user_id); ?></a>
	        			</td>
	        		</tr>
	        		<tr>
	        			<th>
	        				Tổng cộng
	        			</th>
	        			<th>
                            <a target="_blank" href="index.php?mod=houserent&act=list"><?php echo $a1 + $b1 + $c1 + $d1; ?></a>
	        			</th>
	        		</tr>
	        	</table>
        	</div>
        	<div class="col-md-4">
	        	<table class="table table-bordered">
	        		<tr>
	        			<th colspan="2" style="text-align:center">
	        				PHÒNG CHO THUÊ
	        			</th>        			
	        		</tr>
	        		<tr>
	        			<th width="50%">
	        				<span class="label label-lg label-success">Đang trống</span>
	        			</th>
	        			<td>
                            <a target="_blank" href="index.php?mod=room&act=list&status=1"><?php echo $a = $model->countObject(1, 1, $user_id); ?></a>
	        			</td>
	        		</tr>
	        		<tr>
	        			<th>
	        				<span class="label label-warning">Đã cọc</span>
	        			</th>
	        			<td>
                            <a target="_blank" href="index.php?mod=room&act=list&status=2"><?php echo $b = $model->countObject(1, 2, $user_id); ?></a>
	        			</td>
	        		</tr>
	        		<tr>
	        			<th>
	        				<span class="label label-primary">Đang ở</span>
	        			</th>
	        			<td>
                            <a target="_blank" href="index.php?mod=room&act=list&status=3"><?php echo $c = $model->countObject(1, 3, $user_id); ?></a>
	        			</td>
	        		</tr>
	        		<tr>
	        			<th>
	        				<span class="label label-danger">Chờ gia hạn</span>
	        			</th>
	        			<td>
                            <a target="_blank" href="index.php?mod=room&act=list&status=4"><?php echo $d = $model->countObject(1, 4, $user_id); ?></a>
	        			</td>
	        		</tr>
	        		<tr>
	        			<th>
	        				Tổng cộng
	        			</th>
	        			<th>
                            <a target="_blank" href="index.php?mod=room&act=list"><?php echo ($a + $b + $c + $d); ?></a>
	        			</th>
	        		</tr>
	        	</table>
        	</div>
        	<div class="col-md-4">
	        	<table class="table table-bordered">
	        		<tr>
	        			<th colspan="2" style="text-align:center">
	        				NHÀ BÁN
	        			</th>        			
	        		</tr>
	        		<tr>
	        			<th width="50%">
	        				<span class="label label-lg label-success">Chưa bán</span>
	        			</th>
	        			<td>
                            <a target="_blank" href="index.php?mod=housesell&act=list&status=1"><?php echo $a2 = $model->countObject(3, 1, $user_id); ?></a>
	        			</td>
	        		</tr>
	        		<tr>
	        			<th>
	        				<span class="label label-warning">Đã cọc</span>
	        			</th>
	        			<td>
                            <a target="_blank" href="index.php?mod=housesell&act=list&status=2"><?php echo $b2 = $model->countObject(3, 2, $user_id); ?></a>
	        			</td>
	        		</tr>	        		
	        		<tr>
	        			<th>
	        				Tổng cộng
	        			</th>
	        			<th>
                            <a target="_blank" href="index.php?mod=houserent&act=list"><?php echo $a2 + $b2; ?></a>
	        			</th>
	        		</tr>
	        	</table>
        	</div>
        </div>
        </div> <!--//BOX BODY-->
    </div>
    <div class="col-md-12">
    	<div class="box-header">

            <h3 class="box-title">HỢP ĐỒNG ĐẾN HẠN THU TIỀN</h3>

        </div><!-- /.box-header -->
        <div class="box-body">
        		<?php 
        		$arrDenHan = $model->getListContractDenHan($user_id);

        		?>
        		<table class="table table-bordered table-hover">
        			<tr>
        				<th>
        					No.
        				</th>
        				<th>
        					Mã HD
        				</th>
        				<th>
        					Phòng / Nhà
        				</th>
        				<th style="text-align:center">
        					Ngày bắt đầu HD
        				</th>
        				<th style="text-align:center">
        					Ngày thu
        				</th>
        				<th style="text-align:right">
        					Tiền thuê
        				</th>
        				<th style="text-align:right">
        					Tiền dịch vụ<br>
        					Chưa bao gồm điện [nước]

        				</th>
        				<th style="text-align:right">
        					Tổng cộng tạm tính
        				</th>
                        <th>
                            Detail
                        </th>

        			</tr>
        			<?php if(!empty($arrDenHan)){
        				$i = 0;
        				foreach ($arrDenHan as $key => $value) {
        					$i++;
                            $totalSer = 0;                            
                            if($value['object_type'] == 1){
                                $arrServiceHouse = $model->getHouseServices($value['house_id']);
                                $serviceSelectedArr = $model->getContractService($value['id']);
                                
                                if(!empty($serviceSelectedArr)){
                                    foreach ($serviceSelectedArr as $k => $v) {
                                        if($v['cal_type']==1){
                                            $totalSer += $arrServiceHouse[$v['service_id']]['price'];
                                        }
                                        if($v['cal_type']==2){
                                            $totalSer += $arrServiceHouse[$v['service_id']]['price']*$value['no_person'];   
                                        }
                                    }
                                }
                            }
                            
                            
        			?>
        			<tr>
        				<td><?php echo $i; ?></td>
        				<td><?php echo $value['code']; ?></td>
        				<td><?php echo $value['name']; ?></td>
        				<td style="text-align:center"><?php echo date('d-m-Y', strtotime($value['start_date'])); ?></td>
        				<td style="text-align:center"><?php echo date('d', strtotime($value['start_date'])); ?></td>
        				<td style="text-align:right"><?php echo number_format($value['price']); ?></td>
        				<td style="text-align:right"><?php echo number_format($totalSer); ?></td>
        				<td style="text-align:right"><?php echo number_format($totalSer + $value['price']); ?></td>
                        <td>
                            <a href="index.php?mod=doanhthu&act=list&contract_id=<?php echo $value['id']; ?>">
                                <span class="label label-primary">Detail</span>
                            </a>
                        </td>
        			</tr>
        			<?php } } ?>
        		</table>
        	
        	
        	
        </div>
    </div>
     <div class="col-md-12">
    	<div class="box-header">

            <h3 class="box-title">HỢP ĐỒNG SẮP HẾT HẠN</h3>

        </div><!-- /.box-header -->
        <div class="box-body">
        		<?php 
        		$arrDenHan = $model->getListContractSapHetHan($user_id);

        		?>
        		<table class="table table-bordered table-hover">
        			<tr>
        				<th>
        					No.
        				</th>
        				<th>
        					Mã HD
        				</th>
        				<th>
        					Phòng / Nhà
        				</th>
        				<th style="text-align:center">
        					Ngày hết hạn HD
        				</th>
                        <th>Detail</th>


        			</tr>
        			<?php if(!empty($arrDenHan)){
        				$i = 0;
        				foreach ($arrDenHan as $key => $value) {
        					$i++;
        			?>
        			<tr>
        				<td><?php echo $i; ?></td>
        				<td><?php echo $value['code']; ?></td>
        				<td><?php echo $value['name']; ?></td>
        				<td style="text-align:center"><?php echo date('d-m-Y', strtotime($value['end_date'])); ?></td>       				
                        <td>
                            <a href="index.php?mod=contract&act=edit&id=<?php echo $value['id']; ?>">
                                <span class="label label-primary">Detail</span>
                            </a>
                        </td>
        				
        			</tr>
        			<?php } } ?>
        		</table>
        	
        	
        	
        </div>
    </div>
</div>
