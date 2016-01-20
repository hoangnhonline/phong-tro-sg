<?php   
  $cityArr = $model->getList('city', -1, -1);
  $detailType = $model->getDetail('type_bds', $type_id);
  $type = $detailType['type'];
  if($district_id > 0){
    $detailDis = $model->getDetail('district', $district_id);
    $city_id = $detailDis['city_id'];
  }
?>

<section class="section-top-home-block clearfix">
  <div class="col-md-12">
    <ol class="breadcrumb">
      <li><a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>">Trang chủ</a></li>
      
      <li><a href="#"><?php echo $detailType['type']== 1 ? "BĐS Cho Thuê" : "BĐS Bán"; ?></a></li>
      
      <li class="active"><?php echo $detailType['name'];?></li>
    </ol>
  </div><!-- End /.container -->
</section><!-- End Section -->


  <div class="panel panel-default">
    <div class="panel-heading">Tìm kiếm</div>
    <div class="panel-body">
      <form role="form" class="form-inline" action="">
        <div class="form-group">
         
          <select class="form-control selectpicker show-tick" data-live-search="true" id="type" name="type">
            <option value='0'>-- Loại hình --</option>
            <option value='2' <?php if($type==2) echo "selected"; ?>>BĐS bán</option>
            <option value='1' <?php if($type==1) echo "selected"; ?>>BĐS cho thuê</option>
          </select>
        </div>
        <div class="form-group">
         
          <select class="form-control selectpicker show-tick" data-live-search="true" name="type_id" id="type_id">
            <option data-alias=""  value='0'>-- Loại nhà đất --</option>
          </select>
        </div>
        <div class="form-group">         
          <select class="form-control selectpicker" name="city_id" id="city_id" data-live-search="true">
            <option data-alias="" value='0'>-- Chọn Tỉnh/TP --</option>
            <?php foreach ($cityArr['data'] as $key => $value) {
              ?>
              <option data-alias="<?php echo $value['alias']; ?>" value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
              <?php
            }?>
          </select>
        </div>
        <div class="form-group">         
          <select class="form-control selectpicker show-tick" name="district_id" id="district_id" data-live-search="true">
            <option data-alias="" value='0'>-- Chọn Quận/Huyện --</option>
          </select>
        </div>
        <div class="form-group">         
          <select class="form-control selectpicker show-tick" name="price_id" id="price_id" data-live-search="true">
            <option data-alias="" value='0'>-- Chọn khoảng giá --</option>
          </select>
        </div>
        <div class="form-group">         
        <button type="button" id="btnSearch" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> &nbsp;Tìm kiếm</button>
        </div>
        
      </form>
    </div>
  </div>

  <h1 style="font-size: 25px; margin-bottom: 20px;color: #167AB9;"><?php echo $detailType['name']; ?> <?php echo $type==1 ? "cho thuê" : "bán" ; ?>
    tại <?php echo $district_id > 0 ? $model->getNameById('district', $district_id).", " : ""; ?>
    <?php echo $city_id > 0 ? $model->getNameById('city', $city_id) : ""; ?>
  </h1>
<section class="latest-room-block-home">
  
    <?php     
    if($district_id == 0){
 $arrDistrictDetail = array();
        $arrDistrict = $model->getListDistrictHaveObjects($type_id, $city_id);
        $detailCity = $model->getDetail('city', $city_id);      
        if(!empty($arrDistrict)){
    ?>
    
    <div class="aaaaa">
      <!-- Nav tabs -->
      <ul class="met_filters met_portfolio_filters">
        <li><a href="<?php echo $detailType['alias'];?>/<?php echo $detailCity['alias']; ?>.html" data-filter="*" class="activePortfolio">Tất cả</a></li>
        <?php 
       
       
        if(!empty($arrDistrict)){
          $str_id = implode(',', $arrDistrict);

          $arrDistrictDetail = $model->getListDistrictByString($city_id, $str_id);
        }
        
        if(!empty($arrDistrictDetail)){
          foreach ($arrDistrictDetail as $id => $district) {
            
        ?>
        <li><a href="<?php echo $detailType['alias'];?>/<?php echo $detailCity['alias']; ?>/<?php echo $district['alias']?>.html" class=""><?php echo $district['name'] ?></a></li>
        <?php } } // !empty($arrDistrictDetail ?>                  
      </ul>
    </div>
    <div class="clearfix"></div>
          <div class="body-main col-md-12 content_room">
         <?php           
         
          $roomTotalArr = $model->getList("objects", -1, -1, array('city_id' => $city_id, 'type_id' => $type_id, 'price_id' => $price_id));
          $total_record= $roomTotalArr['total'];

          $total_page = ceil($total_record / 24);         

          $page = 1;
          $offset = 0;

          $roomArr = $model->getList("objects", 0, 24, array('city_id' => $city_id, 'type_id' => $type_id, 'price_id' => $price_id));
          ?>
            <ul class="list" id="list-room-no-district">
              <?php if(!empty($roomArr['data'])){
                foreach ($roomArr['data'] as $key => $value) {                        
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
                            <?php if($value['object_type']==1){ ?>
                            <li><span class="bold">Số người ở</span> : <?php echo $value['max_person']; ?></li>
                            <li><span class="bold">Tầng</span> : <?php echo $value['floor']; ?></li>
                            <?php }else{ ?>
                            <li><span class="bold">Số phòng ngủ</span> : <?php echo $value['no_room']; ?></li>
                            <li><span class="bold">Số WC</span> : <?php echo $value['no_wc']; ?></li>
                            <?php } ?>
                          </ul>
                          <a href="chi-tiet/<?php echo $value['alias']; ?>-<?php echo $value['id']; ?>.html" class="info">Chi tiết</a>
                      </div>                          
                  </div>
                  <div class="body-text">
                    <p class="acreage"><span class="name">Diện tích:</span> <span class="num"><?php echo $value['area']; ?></span></p>
                    <p class="address" style="height:40px"><?php echo $model->getNameById('district', $value['district_id']); ?>, <?php echo $model->getNameById('city', $value['city_id']); ?></p>
                    <p class="price"><span class="name">Giá: </span> <span class="num"><?php 
                    if($value['price_sell']){
                      echo $value['price_sell'];
                    }else{
                    echo isset($value['price_1']) ? number_format($value['price_1']) : number_format($value['price']); }  ?> VNĐ</span></p>
                    <p class="room-number"><span class="name"><?php echo $value['object_type'] == 1 ? "Phòng" : "Nhà"; ?>:</span> 
                      <a href="chi-tiet/<?php echo $value['alias']; ?>-<?php echo $value['id']; ?>.html"><span class="num"><?php echo $value['name']; ?></span></a></p>
                  </div>
                </div>
              </li>
              <?php } } ?>
            </ul>
            <div class="clearfix"></div>
              <?php if($total_page >0){ ?>
                <ul class="phan-trang">
                  <?php for($i=1; $i<=$total_page ; $i++){ ?>
                  <li class="page <?php if($i==1) echo "active"; ?>" data-page="<?php echo $i; ?>" 
                    data-city="<?php echo $city_id; ?>" data-district="0" data-type="<?php echo $type_id; ?>" data-price="<?php echo $price_id; ?>" data-parent="list-room-no-district">
                    <span><?php echo $i; ?></span>
                  </li>
                  <?php } ?>
                </ul>
                <?php } ?>
          </div>
          <?php } else{ ?>
          <div style="min-height:300px;">
            <h3 style="font-size:18px;font-weight:bold;color:red">Dữ liệu đang cập nhật.</h3>
          </div>
          <?php } //empty($roomArr['data']
        } // district_id = 0 
          else{ // district_id > 0
            ?>

      <div class="clearfix"></div>
          <div class="body-main col-md-12 content_room">
         <?php           
         
          $roomTotalArr = $model->getList("objects", -1, -1, array('city_id' => $city_id, 'type_id' => $type_id,'district_id' => $district_id, 'price_id' => $price_id));
          $total_record= $roomTotalArr['total'];

          $total_page = ceil($total_record / 24);         

          $page = 1;
          $offset = 0;
          $roomArr = $model->getList("objects", 0, 24, array('city_id' => $city_id, 'type_id' => $type_id,'district_id' => $district_id, 'price_id' => $price_id));
          ?>
            <ul class="list" id="list-room-district">
              <?php if(!empty($roomArr['data'])){
                foreach ($roomArr['data'] as $key => $value) {                        
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
                            <?php if($value['object_type']==1){ ?>
                            <li><span class="bold">Số người ở</span> : <?php echo $value['max_person']; ?></li>
                            <li><span class="bold">Tầng</span> : <?php echo $value['floor']; ?></li>
                            <?php }else{ ?>
                            <li><span class="bold">Số phòng ngủ</span> : <?php echo $value['no_room']; ?></li>
                            <li><span class="bold">Số WC</span> : <?php echo $value['no_wc']; ?></li>
                            <?php } ?>
                          </ul>
                          <a href="chi-tiet/<?php echo $value['alias']; ?>-<?php echo $value['id']; ?>.html" class="info">Chi tiết</a>
                      </div>                          
                  </div>
                  <div class="body-text">
                    <p class="acreage"><span class="name">Diện tích:</span> <span class="num"><?php echo $value['area']; ?></span></p>
                    <p class="address" style="height:40px"><?php echo $model->getNameById('district', $value['district_id']); ?>, <?php echo $model->getNameById('city', $value['city_id']); ?></p>
                    <p class="price"><span class="name">Giá: </span> <span class="num"><?php 
                    if($value['price_sell']){
                      echo $value['price_sell'];
                    }else{
                    echo isset($value['price_1']) ? number_format($value['price_1']) : number_format($value['price']); }  ?> VNĐ</span></p>
                    <p class="room-number"><span class="name"><?php echo $value['object_type'] == 1 ? "Phòng" : "Nhà"; ?>:</span> 
                      <a href="chi-tiet/<?php echo $value['alias']; ?>-<?php echo $value['id']; ?>.html"><span class="num"><?php echo $value['name']; ?></span></a></p>
                  </div>
                </div>
              </li>
              <?php } }  // if !empty($roomArr['data']
              else{ ?>
          
            <li style="font-size:18px;font-weight:bold;color:red">Dữ liệu đang cập nhật.</li>
          
          <?php } // empty($roomArr['data']?>
            </ul>
            <div class="clearfix"></div>
              <?php if($total_page >0){ ?>
                <ul class="phan-trang">
                  <?php for($i=1; $i<=$total_page ; $i++){ ?>
                  <li class="page <?php if($i==1) echo "active"; ?>" data-page="<?php echo $i; ?>" 
                    data-city="<?php echo $city_id; ?>" data-district="<?php echo $district_id; ?>" data-type="<?php echo $type_id; ?>" data-price="<?php echo $price_id; ?>" data-parent="list-room-district">
                    <span><?php echo $i; ?></span>
                  </li>
                  <?php } ?>
                </ul>
                <?php } ?>
          </div>

            <?php 
          } ?>
  
</section><!-- End Section -->    
<script type="text/javascript">
$(document).ready(function(){
  $('li.page').click(function(){
    var obj = $(this);
    
    obj.parent().find('.page').removeClass('active');
    obj.addClass('active');
    var page = $(this).attr('data-page');
    var city_id = $(this).attr('data-city');
    var price_id = $(this).attr('data-price');
    var district_id = $(this).attr('data-district');
    var type_id = $(this).attr('data-type');
    var parent = $(this).attr('data-parent');
    $.ajax({
      url : 'ajax/cate.php',
      type : 'POST',
      data : {
        page : page,
        city_id : city_id,
        type_id : type_id,
        price_id : price_id,
        district_id : district_id
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
