<?php 
  $city_id = isset($_GET['city_id']) && (int) $_GET['city_id'] > 0 ?  $_GET['city_id'] : 1;
  $cityArr = $model->getList('city', -1, -1);
?>
<section class="section-top-home-block clearfix">
  <?php include "blocks/home/slideshow.php"; ?>
  <?php include "blocks/home/guide.php"; ?>
</section><!-- End Section -->

<div class="col-md-9 col-sm-12">
  <?php 
  $arrDistrictDetail = array();
  $arrDistrict = $model->getListDistrictHaveRoom($city_id);
  if(!empty($arrDistrict)){
  ?> 
  <section class="latest-room-block-home">
  <div class="">
    <h1 class="title-section"><span>Phòng cho thuê đang và sắp trống</span></h1>
    <div class="body-main col-md-12 content_room">
         <?php           
          $roomArr = $model->getList("objects", 0, 100, array('city_id' => $city_id, 'object_type' => 1, 'status' => 1));
          ?>
            <ul class="list">
              <?php if(!empty($roomArr['data'])){
                foreach ($roomArr['data'] as $key => $value) {                        
                  //var_dump("<pre>", $value);                         
              ?>
              <li class="col-md-3 col-sm-4 col-sx-4 li_content_room">
                <div class="room-item">
               <a href="chi-tiet/<?php echo $value['alias']; ?>-<?php echo $value['id']; ?>.html" class="info">
                  <div class="thumb view-first" style="position:relative">
                  <?php if($value['status']==1){ ?>
                  <label class="label label-success lable-lg" style="position:absolute; top : 5px; right: 5px;font-size:15px">Đang trống</label>                            
                  <?php } ?> 
                  <?php if($value['status']==2){ ?>
                  <label class="label label-info lable-lg" style="position:absolute; top : 5px; right: 5px;font-size:15px">Đã cọc</label>                            
                  <?php } ?>    
                  <?php if($value['status']==3){ ?>
                  <label class="label label-warning lable-lg" style="position:absolute; top : 5px; right: 5px;font-size:15px">Đang ở</label>                            
                  <?php } ?>
                  <?php if($value['status']==4){ ?>
                  <label class="label label-danger lable-lg" style="position:absolute; top : 5px; right: 5px;font-size:15px">Chờ gia hạn</label>                            
                  <?php } ?>                                             
                      <img class="lazy" data-original="<?php echo $value['image_url']; ?>" style="height:150px;width:100%" alt="<?php echo $value['name']; ?>">
                      <div class="mask">   

                        <ul>
                          <?php if($value['object_type'] == 1) { ?>
                         <li><span class="bold">Diện tích</span>: <?php echo $value['area']; ?> m2<li>
                          <li><span class="bold">Số người ở</span> : <?php echo $value['max_person']; ?></li>
                          <li><span class="bold">Tầng</span> : <?php echo $value['floor']; ?></li>
                          <?php } ?>
                         
                        </ul>                          
                     
                      </div>                          
                  </div>
       </a>
                  <div class="body-text">         
                    <p class="address"><?php echo $model->getNameById('district', $value['district_id']); ?>, <?php echo $model->getNameById('city', $value['city_id']); ?></p>
                    <p class="price"><span class="name">Giá: </span> <span class="num"><?php echo number_format($value['price_1']); ?> VNĐ</span></p>
                    <p class="room-number"><span class="name">Phòng:</span> 
                      <a href="chi-tiet/<?php echo $value['alias']; ?>-<?php echo $value['id']; ?>.html">
                          <span class="num"><?php echo $value['name']; ?></span>
                      </a>
                    </p>
                  </div>
                </div>
              </li>
              <?php } } ?>
              <?php 
              $sapHetHan = $model->getListContractSapHetHan();
              if(!empty($sapHetHan)){
                foreach ($sapHetHan as $key => $value) {                        
                  //var_dump("<pre>", $value);                         
              ?>
              <li class="col-md-3 col-sm-4 col-sx-4 li_content_room">
                <div class="room-item">
               <a href="chi-tiet/<?php echo $value['alias']; ?>-<?php echo $value['id']; ?>.html" class="info">
                  <div class="thumb view-first" style="position:relative">
                  
                  <label class="label label-danger lable-lg" style="position:absolute; top : 5px; right: 5px;font-size:15px">Còn <?php echo $value['songay']; ?> ngày</label>                            
                  
                      <img class="lazy" data-original="<?php echo $value['image_url']; ?>" style="height:150px;width:100%" alt="<?php echo $value['name']; ?>">
                      <div class="mask">   

                        <ul>
                          <?php if($value['object_type'] == 1) { ?>
                         <li><span class="bold">Diện tích</span>: <?php echo $value['area']; ?> m2<li>
                          <li><span class="bold">Số người ở</span> : <?php echo $value['max_person']; ?></li>
                          <li><span class="bold">Tầng</span> : <?php echo $value['floor']; ?></li>
                          <?php } ?>
                         
                        </ul>                          
                     
                      </div>                          
                  </div>
       </a>
                  <div class="body-text">         
                    <p class="address"><?php echo $model->getNameById('district', $value['district_id']); ?>, <?php echo $model->getNameById('city', $value['city_id']); ?></p>
                    <p class="price"><span class="name">Giá: </span> <span class="num"><?php echo number_format($value['price_1']); ?> VNĐ</span></p>
                    <p class="room-number"><span class="name">Phòng:</span> 
                      <a href="chi-tiet/<?php echo $value['alias']; ?>-<?php echo $value['id']; ?>.html">
                          <span class="num"><?php echo $value['name']; ?></span>
                      </a>
                    </p>
                  </div>
                </div>
              </li>
              <?php } } ?>
            </ul>
            <div class="clearfix"></div>            
            
          </div>
          <div class="clearfix"></div>
          <h1 class="title-section"><span>Tất cả phòng cho thuê</span></h1>
    <div class="aaaaa">
      <!-- Nav tabs -->
      <ul class="met_filters met_portfolio_filters">
        <li><a href="cho-thue-phong/ho-chi-minh.html" data-filter="*" class="activePortfolio">Tất cả</a></li>
        <?php 
        
       
        if(!empty($arrDistrict)){
          $str_id = implode(',', $arrDistrict);

          $arrDistrictDetail = $model->getListDistrictByString($city_id, $str_id);
        }
        
        if(!empty($arrDistrictDetail)){
          foreach ($arrDistrictDetail as $id => $district) {            
            $detailCity = $model->getDetail('city', $district['city_id']);
        ?>
        <li>
          <a href="cho-thue-phong/<?php echo $detailCity['alias']; ?>/<?php echo $district['alias'] ?>.html" class="">
          <?php echo $district['name'] ?>
          </a>
        </li>
        <?php } } ?>                  
      </ul>
    </div>
    <div class="clearfix"></div>
          
          <div class="body-main col-md-12 content_room">
         <?php           
         
          $roomTotalArr = $model->getList("objects", -1, -1, array('city_id' => $city_id, 'object_type' => 1));
          
          $total_record_room = $roomTotalArr['total'];

          $total_page_room = ceil($total_record_room / 24);         

          $page = 1;

          $offset = 0;

          $roomArr = $model->getList("objects", 0, 24, array('city_id' => $city_id, 'object_type' => 1));
          ?>
            <ul class="list" id="list-room-home">
              <?php if(!empty($roomArr['data'])){
                foreach ($roomArr['data'] as $key => $value) {                        
                  //var_dump("<pre>", $value);                         
              ?>
              <li class="col-md-3 col-sm-4 col-sx-4 li_content_room">
                <div class="room-item">
               <a href="chi-tiet/<?php echo $value['alias']; ?>-<?php echo $value['id']; ?>.html" class="info">
                  <div class="thumb view-first" style="position:relative">
                  <?php if($value['status']==1){ ?>
                  <label class="label label-success lable-lg" style="position:absolute; top : 5px; right: 5px;font-size:15px">Đang trống</label>                            
                  <?php } ?> 
                  <?php if($value['status']==2){ ?>
                  <label class="label label-info lable-lg" style="position:absolute; top : 5px; right: 5px;font-size:15px">Đã cọc</label>                            
                  <?php } ?>    
                  <?php if($value['status']==3){ ?>
                  <label class="label label-warning lable-lg" style="position:absolute; top : 5px; right: 5px;font-size:15px">Đang ở</label>                            
                  <?php } ?>
                  <?php if($value['status']==4){ ?>
                  <label class="label label-danger lable-lg" style="position:absolute; top : 5px; right: 5px;font-size:15px">Chờ gia hạn</label>                            
                  <?php } ?>                                             
                      <img class="lazy" data-original="<?php echo $value['image_url']; ?>" style="height:150px;width:100%" alt="<?php echo $value['name']; ?>">
                      <div class="mask">   

                        <ul>
                          <?php if($value['object_type'] == 1) { ?>
			                   <li><span class="bold">Diện tích</span>: <?php echo $value['area']; ?> m2<li>
                          <li><span class="bold">Số người ở</span> : <?php echo $value['max_person']; ?></li>
                          <li><span class="bold">Tầng</span> : <?php echo $value['floor']; ?></li>
                          <?php } ?>
                         
                        </ul>                          
                     
                      </div>                          
                  </div>
		   </a>
                  <div class="body-text">         
                    <p class="address"><?php echo $model->getNameById('district', $value['district_id']); ?>, <?php echo $model->getNameById('city', $value['city_id']); ?></p>
                    <p class="price"><span class="name">Giá: </span> <span class="num"><?php echo number_format($value['price_1']); ?> VNĐ</span></p>
                    <p class="room-number"><span class="name">Phòng:</span> 
                      <a href="chi-tiet/<?php echo $value['alias']; ?>-<?php echo $value['id']; ?>.html">
                          <span class="num"><?php echo $value['name']; ?></span>
                      </a>
                    </p>
                  </div>
                </div>
              </li>
              <?php } } ?>
            </ul>
            <div class="clearfix"></div>
            <?php if($total_page_room >0){ ?>
              <ul class="phan-trang">
                <?php for($i=1; $i<=$total_page_room ; $i++){ ?>
                <li class="page <?php if($i==1) echo "active"; ?>" data-page="<?php echo $i; ?>" 
                  data-city="<?php echo $city_id; ?>" data-object-type="1" data-parent="list-room-home">
                  <span><?php echo $i; ?></span>
                </li>
                <?php } ?>
              </ul>
              <?php } ?>
            
          </div>
        
  </div><!-- End /.container -->
</section><!-- End Section --> 
<?php } ?>     
<div class="clearfix"></div>
<?php 
$arrDistrictDetail = array();      
$arrDistrict = $model->getListDistrictHaveHouse($city_id);
if(!empty($arrDistrict)){
?>
<section class="latest-room-block-home" style="margin-top:0px">
  <div>
    <h1 class="title-section"><span>Nhà cho thuê đang và sắp trống</span></h1>
    
    <div class="aaaaa">
      <!-- Nav tabs -->
     
      <ul class="met_filters met_portfolio_filters">
        <li><a href="cho-thue-nha-nguyen-can/ho-chi-minh.html" data-filter="*" class="activePortfolio">Tất cả</a></li>
        <?php 
               
    
        if(!empty($arrDistrict)){
          $str_id = implode(',', $arrDistrict);

          $arrDistrictDetail = $model->getListDistrictByString($city_id, $str_id);
        }
        
        if(!empty($arrDistrictDetail)){
          foreach ($arrDistrictDetail as $id => $district) {
           $detailCity = $model->getDetail('city', $district['city_id']);
        ?>
        <li>
          <a href="cho-thue-nha-nguyen-can/<?php echo $detailCity['alias']; ?>/<?php echo $district['alias'] ?>.html" class="">
          <?php echo $district['name'] ?>
          </a>
        </li>
        
        <?php } } ?>                  
      </ul>
    </div>
    <div class="clearfix"></div>
         
          <div class="body-main col-md-12 content_room">
           <?php                             
          $houseTotalArr = $model->getList("objects", -1, -1, array('city_id' => $city_id, 'object_type' => 2));
          $total_record_house = $houseTotalArr['total'];

          $total_page_house = ceil($total_record_house / 24);         

          $page = 1;

          $offset = 0;
          $houseArr = $model->getList("objects", 0, 24, array('city_id' => $city_id, 'object_type' => 2));
          ?>
            <ul class="list" id="list-house-home">
              
              <?php if(!empty($houseArr['data'])){
                foreach ($houseArr['data'] as $key => $value) {                        
              ?>
              <li class="col-md-3 col-sm-4 col-sx-4 li_content_room">
                <div class="room-item">
                  <div class="thumb view-first" style="position:relative">
                  <?php if($value['status']==1){ ?>
                  <label class="label label-success lable-lg" style="position:absolute; top : 5px; right: 5px;font-size:15px">Đang trống</label>                            
                  <?php } ?> 
                  <?php if($value['status']==2){ ?>
                  <label class="label label-info lable-lg" style="position:absolute; top : 5px; right: 5px;font-size:15px">Đã cọc</label>                            
                  <?php } ?>    
                  <?php if($value['status']==3){ ?>
                  <label class="label label-warning lable-lg" style="position:absolute; top : 5px; right: 5px;font-size:15px">Đang ở</label>                            
                  <?php } ?>
                  <?php if($value['status']==4){ ?>
                  <label class="label label-danger lable-lg" style="position:absolute; top : 5px; right: 5px;font-size:15px">Chờ gia hạn</label>                            
                  <?php } ?>                                       
                      <img class="lazy" data-original="<?php echo $value['image_url']; ?>" style="height:150px;width:100%" alt="<?php echo $value['name']; ?>">
                      <div class="mask">                              
                          <ul>
                          <li><span class="bold">Số phòng ngủ</span> : <?php echo $value['no_room']; ?></li>
                          <li><span class="bold">Số WC</span> : <?php echo $value['no_wc']; ?></li>
                          </ul>
                          <a href="chi-tiet/<?php echo $value['alias']; ?>-<?php echo $value['id']; ?>.html" class="info">Chi tiết</a>
                      </div>                          
                  </div>
                  <div class="body-text">
                    <p class="acreage"><span class="name">Diện tích:</span> <span class="num"><?php echo $value['area']; ?></span></p>
                    <p class="address"><?php echo $model->getNameById('district', $value['district_id']); ?>, <?php echo $model->getNameById('city', $value['city_id']); ?></p>
                    <p class="price"><span class="name">Giá: </span> <span class="num"><?php echo number_format($value['price']); ?> VNĐ</span></p>
                    <p class="room-number"><span class="name">Nhà:</span> 
                      <a href="chi-tiet/<?php echo $value['alias']; ?>-<?php echo $value['id']; ?>.html">
                        <span class="num"><?php echo $value['name']; ?></span>
                      </a>
                    </p>
                  </div>
                </div>
              </li>
              <?php } } ?>
              
            </ul>
             <div class="clearfix"></div>
              <?php if($total_page_house >0){ ?>
                <ul class="phan-trang">
                  <?php for($i=1; $i<=$total_page_house ; $i++){ ?>
                  <li class="page <?php if($i==1) echo "active"; ?>" data-page="<?php echo $i; ?>" 
                    data-city="<?php echo $city_id; ?>" data-object-type="2" data-parent="list-house-home">
                    <span><?php echo $i; ?></span>
                  </li>
                  <?php } ?>
                </ul>
                <?php } ?>
          </div>
          
  </div><!-- End /.container -->
</section><!-- End Section -->  
<?php } ?>
</div><!--col-md-9-->
<div class="col-md-3 col-sm-12" id="right-sidebar">
  <?php include "blocks/home/search.php"; ?>
  <?php include "blocks/home/mod.php"; ?>
  <?php include "blocks/home/room.php"; ?>
  <?php include "blocks/home/support.php"; ?>
</div><!--col-md-3-->

<style type="text/css">
#support{
  padding-left: 10px
}
#support li{
  font-size: 16px;
  font-weight: bold;
}
span.support-value{
  color:#FF3000;
}
</style>

<script type="text/javascript">
$(document).ready(function(){
  $('li.page').click(function(){
    var obj = $(this);
    
    obj.parent().find('.page').removeClass('active');
    obj.addClass('active');
    var page = $(this).attr('data-page');
    var city_id = $(this).attr('data-city');
    var object_type = $(this).attr('data-object-type');
    var parent = $(this).attr('data-parent');
    $.ajax({
      url : 'ajax/list.php',
      type : 'POST',
      data : {
        page : page,
        city_id : city_id,
        object_type : object_type
      },
      success : function(data){
        $('#' + parent).html(data);
	$('html, body').animate({
      	   scrollTop: $("#" + parent).parent().parent().offset().top
      	}, 500);
      }
    });
  });
});
</script>
