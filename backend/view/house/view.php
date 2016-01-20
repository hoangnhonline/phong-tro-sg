<?php
$id = 0;
$addonArr = $model->getList('addon', -1, -1);
$arrAddonSelected = array();
$cityArr = $model->getList('city', -1, -1);
$wardArr = $model->getList('ward', -1, -1);
$districtArr = $model->getList('district', -1, -1);
$serviceArr = $model->getList('services', -1, -1);
$imageArr = array();
$detail = $arrAddonSelected = $arrServiceSelected = array();
if(isset($_GET['id'])){
    $id = (int) $_GET['id'];    
    $detail = $model->getDetail("house", $id);
    $arrAddonSelected = $model->getListRelation("house_addon", "addon_id", "house_id", $id);
    $imageArr = $model->getChild("images", "object_id", $id, 1);    
    $arrServiceSelected = $model->getHouseServices($id);
    $str_name_addon = "";
   // var_dump("<pre>", $arrAddonSelected);
    if(!empty($arrAddonSelected)){
    	
    	foreach ($arrAddonSelected as $key => $value) {
    		$str_name_addon .= $model->getNameById('addon', $value) .", ";
    	}    	
    }
    $str_name_addon = rtrim($str_name_addon, ', ');
}
?>
<div class="row">   
   
    <div class="col-md-12">

        <!-- Custom Tabs -->

        <button class="btn btn-default btn-sm" onclick="location.href='index.php?mod=house&act=list'">Quay lại</button>
        <button class="btn btn-primary btn-sm" onclick="location.href='index.php?mod=house&act=form&id=<?php echo $id; ?>'">Chỉnh sửa</button>
        
         
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
		        		<tr>
		        		<tr>
		        			<th style='width:30%'>Tên nhà</th>
		        			<td><?php echo $detail['name']; ?></td>
		        		<tr>
		        		<tr>
		        			<th style='width:30%'>Địa chỉ</th>
		        			<td><?php echo $detail['address']; ?>, Phường <?php echo $model->getNameById('ward', $detail['ward_id']); ?>, <?php echo $model->getNameById('district', $detail['district_id']); ?>, <?php echo $model->getNameById('city', $detail['city_id']); ?></td>
		        		<tr>
		        		<tr>
		        			<th style='width:30%'>Số lượng phòng</th>
		        			<td><?php echo $detail['no_room']; ?></td>
		        		<tr>
		        		<tr>
		        			<th style='width:30%'>Link video</th>
		        			<td><?php echo $detail['video_url']; ?></td>

		        		<tr>
		        		<tr>
		        			<th style='width:30%;vertical-align:middle'>Ảnh đại diện</th>
		        			<td><img src="../<?php echo $detail['image_url'];?>" width="120px" class="img-thumbnail"></td>
		        		<tr>
		        		<tr>
		        			<th style='width:30%'>Tiện ích đi kèm</th>
		        			<td><?php echo $str_name_addon; ?></td>
		        		<tr>
		        		<tr>
		        			<th style='width:30%'>Mô tả thêm</th>
		        			<td><?php echo $detail['description']; ?></td>
		        		<tr>
		        	</table>
		        	<table class="table table-bordered">
		        		<tr>
		        			<th style="background:#ccc;color:red;text-transform:uppercase;text-align:center" colspan='2'>Thông tin dịch vụ</th>	        			
		        		<tr>
		        		<?php if(!empty($arrServiceSelected)){ 
		        		foreach ($arrServiceSelected as $key => $value) {		        				
		        		?>
		        		<tr>
		        			<th style='width:20%'><?php echo $model->getNameById('services', $value['service_id']); ?></th>
		        			<td><?php echo number_format($value['price']) ; ?> - ( Tính theo 
		        				<?php 
		        				if($value['cal_type']==1) echo "phòng";
		        				if($value['cal_type']==2) echo "số lượng người";
		        				if($value['cal_type']==3) echo "số lượng sử dụng";
		        				?> )
		        			</td>
		        		<tr>
		        		<?php } } ?>
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