<?php
$id = $city_id = 0;
$addonArr = $model->getList('addon', -1, -1);
$convenientArr = $model->getList('convenient', -1, -1);
$serviceArr = $model->getList('services', -1, -1);
$arrAddonSelected = array();
$imageArr = array();
$detail = $arrAddonSelected = array();
if(isset($_GET['id'])){
    $id = (int) $_GET['id'];    
    $detail = $model->getDetail("objects", $id);
    $detailHouse = $model->getDetail("house", $detail['house_id']);
    $arrAddonSelected = $model->getListInfoObject($id, 1);
    $arrConvenientSelected = $model->getListInfoObject($id, 2);
    $imageArr = $model->getChild("images", "object_id", $id, 2); 
    $city_id  = $detail['city_id']; 
    $str_name_addon = "";
   // var_dump("<pre>", $arrAddonSelected);
    if(!empty($arrAddonSelected)){
        
        foreach ($arrAddonSelected as $key => $value) {
            $str_name_addon .= $model->getNameById('addon', $value) .", ";
        }       
    }
    $str_name_addon = rtrim($str_name_addon, ', ');  
}
if($city_id > 0){
    $arrCustomList['city_id'] = $city_id;    
}
$cityArr = $model->getList('city', -1, -1);
$districtArr = $model->getList('district', -1, -1, $arrCustomList);
$wardArr = $houseArr = array();
if(isset($detail['district_id']) && $detail['district_id'] > 0){
    $arrCustomWard['district_id'] = $detail['district_id'];
    $wardArr = $model->getList('ward', -1, -1, $arrCustomWard);
}
if(isset($detail['ward_id']) && $detail['ward_id'] > 0){
    $arrCustomHouse['ward_id'] = $detail['ward_id'];
    $houseArr = $model->getList('house', -1, -1, $arrCustomHouse);
}
?>
<div class="row">   
   
    <div class="col-md-12">

        <!-- Custom Tabs -->

        <button class="btn btn-default btn-sm" onclick="location.href='index.php?mod=room&act=list'">Quay lại</button>
        <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=room&act=form&id=<?php echo $id; ?>'">Chỉnh sửa</button>
        
         
        <div style="clear:both;margin-bottom:10px"></div>

         <div class="box-header">

            <h3 class="box-title">Chi tiết nhà : <?php echo $detail['name']; ?></h3>
            
        </div><!-- /.box-header -->
        <div class="box-body">
        	<div class="row">
	        	<div class="col-md-6">
		        	<table class="table table-bordered">
		        		<tr>
		        			<th style="background:#ccc;color:red;text-transform:uppercase;text-align:center" colspan='2'>Thông tin chi tiết</th>	        			
		        		</tr>
                        <tr>
                            <th style='width:30%'>Loại BĐS</th>
                            <td><?php echo $model->getNameById('type_bds',$detail['type_id']); ?></td>
                        </tr>
                        
		        		<tr>
		        			<th style='width:30%'>Tên phòng</th>
		        			<td><?php echo $detail['name']; ?></td>
		        		</tr>
                        <tr>
                            <th style='width:30%'>Tên nhà</th>
                            <td><?php echo $detailHouse['name']; ?></td>
                        </tr>
		        		<tr>
		        			<th style='width:30%'>Địa chỉ</th>
		        			<td><?php echo $detailHouse['address']; ?>, Phường <?php echo $model->getNameById('ward', $detail['ward_id']); ?>, 
                                <?php echo $model->getNameById('district', $detail['district_id']); ?>, 
                                <?php echo $model->getNameById('city', $detail['city_id']); ?></td>
		        		</tr>                       
                        <tr>
                            <th style='width:30%'>Giá thuê 1 tháng</th>
                            <td><?php echo number_format($detail['price_1']); ?></td>
                        </tr>
                        <tr>
                            <th style='width:30%'>Giá thuê 3 tháng</th>
                            <td><?php echo number_format($detail['price_3']); ?></td>
                        </tr>
                        <tr>
                            <th style='width:30%'>Giá thuê 6 tháng</th>
                            <td><?php echo number_format($detail['price_6']); ?></td>
                        </tr>
		        		<tr>
		        			<th style='width:30%'>Diện tích</th>
		        			<td><?php echo $detail['area']; ?></td>
		        		</tr>                        
                        <tr>
                            <th style='width:30%'>Số người ở tối đa</th>
                            <td><?php echo $detail['max_person']; ?></td>
                        </tr>
                        <tr>
                            <th style='width:30%'>Đặt cọc</th>
                            <td><?php echo number_format($detail['deposit']); ?></td>
                        </tr> 
                        <tr>
                            <th style='width:30%'>Tiện ích đi kèm</th>
                            <td><?php echo $str_name_addon; ?></td>
                        <tr> 
		        		<tr>
		        			<th style='width:30%'>Link video</th>
		        			<td><?php echo $detail['video_url']; ?></td>

		        		</tr>
		        		<tr>
		        			<th style='width:30%;vertical-align:middle'>Ảnh đại diện</th>
		        			<td><img src="../<?php echo $detail['image_url'];?>" width="120px" class="img-thumbnail"></td>
		        		</tr>		        		
		        		<tr>
		        			<th style='width:30%'>Mô tả thêm</th>
		        			<td><?php echo $detail['description']; ?></td>
		        		</tr>
		        	</table>
		        				        	
                    
	        	</div>
	        	<div class="col-md-6">
		        	<div id="myCarousel" class="carousel slide" data-ride="carousel">  
					

					  <!-- Wrapper for slides -->
					  <div class="carousel-inner" role="listbox">
					  	<?php if(!empty($imageArr)){ 
					  		$i = 0;
					  		foreach ($imageArr as $key => $value) {
					  			$i++;
					  			
					  	?>
					    <div class="item <?php echo $i == 1 ? "active" : ""; ?>">
					      <img src="../<?php echo $value['url']; ?>" alt="Chania">
					    </div>
					    <?php } } ?>
					  </div>					 
					</div>
					<div style="margin-bottom:20px" class="clearfix" ></div>
                    <div id="map-canvas"></div>
	        	</div>

	        </div>
           
        </div>
   

</div>
