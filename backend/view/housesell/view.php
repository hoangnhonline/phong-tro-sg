<?php
$id = $city_id = 0;
$addonArr = $model->getList('addon', -1, -1);
$arrAddonSelected = array();

$directionArr = $model->getList('direction', -1, -1);
$purposeArr = $model->getList('purpose', -1, -1);
$imageArr = array();
$detail = $arrAddonSelected = $arrPurposeSelected = array();
if(isset($_GET['id'])){
    $id = (int) $_GET['id'];    
    $detail = $model->getDetail("objects", $id);
    $arrAddonSelected = $model->getListInfoObject($id, 1);
    $arrPurposeSelected = $model->getListRelation("house_purpose", "purpose_id", "house_id", $id);
    $imageArr = $model->getChild("images", "object_id", $id, 4);
    $city_id = $detail['city_id'];    
}

if($city_id > 0){
    $arrCustomList['city_id'] = $city_id;    
}

$cityArr = $model->getList('city', -1, -1);
$districtArr = $model->getList('district', -1, -1, $arrCustomList);
$typeArr = $model->getList('type_bds', -1, -1, array('type' => 2));
$wardArr = array();
if(isset($detail['district_id']) && $detail['district_id']){
    $arrCustomWard['district_id'] = $detail['district_id'];
    $wardArr = $model->getList('ward', -1, -1, $arrCustomWard);
}
?>
<div class="row">   
   
    <div class="col-md-12">

        <!-- Custom Tabs -->

        <button class="btn btn-default btn-sm" onclick="location.href='index.php?mod=housesell&act=list'">Quay lại</button>
        <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=housesell&act=form&id=<?php echo $id; ?>'">Chỉnh sửa</button>
        
         
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
                            <th style='width:30%'>Tên dự án</th>
                            <td><?php echo $detail['project_name']; ?></td>
                        </tr>
		        		<tr>
		        			<th style='width:30%'>Tên nhà</th>
		        			<td><?php echo $detail['name']; ?></td>
		        		</tr>
		        		<tr>
		        			<th style='width:30%'>Địa chỉ</th>
		        			<td><?php echo $detail['address']; ?>, Phường <?php echo $model->getNameById('ward', $detail['ward_id']); ?>, 
                                <?php echo $model->getNameById('district', $detail['district_id']); ?>, 
                                <?php echo $model->getNameById('city', $detail['city_id']); ?></td>
		        		</tr>
                        <tr>
                            <th style='width:30%'>Hướng nhà</th>
                            <td><?php echo $model->getNameById('direction', $detail['direction_id']); ?></td>
                        </tr>
                        <tr>
                            <th style='width:30%'>Vị trí</th>
                            <td><?php echo $detail['position_type'] == 1 ? "Mặt tiền" : "Hẻm"; ?></td>
                        </tr>
                        <tr>
                            <th style='width:30%'>Đường rộng trước nhà</th>
                            <td><?php echo $detail['street']; ?></td>
                        </tr>
                        <tr>
                            <th style='width:30%'>Giá bán</th>
                            <td><?php echo ($detail['price_sell']); ?></td>
                        </tr>
		        		<tr>
		        			<th style='width:30%'>Diện tích</th>
		        			<td><?php echo $detail['area']; ?></td>
		        		</tr>
                        <tr>
                            <th style='width:30%'>Số phòng ngủ</th>
                            <td><?php echo $detail['no_room']; ?></td>
                        </tr>
                        <tr>
                            <th style='width:30%'>Số WC</th>
                            <td><?php echo $detail['no_room']; ?></td>
                        </tr>
                        <tr>
                            <th style='width:30%'>Phương thức thanh toán</th>
                            <td><?php echo ($detail['payment']); ?></td>
                        </tr> 
                        <tr>
                            <th style='width:30%'>Pháp lý</th>
                            <td><?php echo ($detail['legal']); ?></td>
                        </tr> 
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
<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
     <style>
      #map-canvas, #map_canvas {
        height: 350px;
        width:100%;
    }

    @media print {
        html, body {
            height: auto;
        }

        #map-canvas, #map_canvas {
            height: 350px;
            width:100%;
        }
    }

    #panel {
        position: absolute;
        left: 60%;
        margin-left: -100px;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
    }
    input {
        border: 1px solid  rgba(0, 0, 0, 0.5);
    }
    input.notfound {
        border: 2px solid  rgba(255, 0, 0, 0.4);
    }
</style>

<script>
    var geocoder = new google.maps.Geocoder();

    function geocodePosition(pos) {
        geocoder.geocode({
            latLng: pos
        }, function(responses) {
        });
    }
    function initialize() {
        <?php if($id>0){ ?>
        var latLng = new google.maps.LatLng(<?php echo $detail['latitude']; ?>, <?php echo $detail['longitude']; ?>);
        <?php }else{ ?>
        var latLng = new google.maps.LatLng(10.753151, 106.73088499999994);
        <?php } ?>
        var mapOptions = {
            center: latLng,
            zoom: 17,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById('map-canvas'),
                mapOptions);
        var input = /** @type {HTMLInputElement} */(document.getElementById('searchTextField'));
        var autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.bindTo('bounds', map);

        var marker = new google.maps.Marker({
            map: map,
            position: latLng
        });
        geocodePosition(marker.getPosition());
            pos = marker.getPosition();

            var latitude = 0;
            var longitude = 0;
            var countIndex = 0;
            $.each(pos, function(index, value) {
                countIndex++;
                if(countIndex==1) latitude = value;
                if(countIndex==2) {longitude = value;return;}
            });

            geocoder.geocode({
                latLng: pos
            }, function(responses) {
                if (responses && responses.length > 0) {
                    $('#latitude').val(latitude);
                    $('#longitude').val(longitude);
                }
            });
        marker.setDraggable(true);
        geocodePosition(latLng);

        google.maps.event.addListener(marker, 'dragend', function() {
            geocodePosition(marker.getPosition());
            pos = marker.getPosition();


            var latitude = 0;
            var longitude = 0;
            var countIndex = 0;
            $.each(pos, function(index, value) {
                countIndex++;
                if(countIndex==1) latitude = value;
                if(countIndex==2) {longitude = value;return;}
            });


            geocoder.geocode({
                latLng: pos
            }, function(responses) {
                if (responses && responses.length > 0) {
                    $('#latitude').val(latitude);
                    $('#longitude').val(longitude);
                }
            });
        });

        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            marker.setVisible(false);
            input.className = '';
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                // Inform the user that the place was not found and return.
                input.className = 'notfound';
                return;
            }

            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);  // Why 17? Because it looks good.
            }
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

            // geocodePosition(marker.getPosition());
            pos = marker.getPosition();

            var latitude = 0;
            var longitude = 0;
            var countIndex = 0;
            $.each(pos, function(index, value) {
                    countIndex++;
                    if(countIndex==1) latitude = value;
                    if(countIndex==2) {longitude = value;return;}
            });


            geocoder.geocode({
                latLng: pos
            }, function(responses) {
                if (responses && responses.length > 0) {
                    $('#latitude').val(latitude);
                    $('#longitude').val(longitude);
                }
            });
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize);

</script>