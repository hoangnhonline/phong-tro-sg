<section class="section-top-home-block clearfix">
  <div class="container_bread">
    <ol class="breadcrumb">
      <li><a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>">Trang chủ</a></li>
      
      <li><a href="#"><?php echo $detailType['type']== 1 ? "BĐS Cho Thuê" : "BĐS Bán"; ?></a></li>
      <li><a href="index.php?mod=list&type_id=<?php echo $type_id; ?>"><?php echo $detailType['name'];?></a></li>
      
      <li class="active">Chi tiết</li>
    </ol>
  </div><!-- End /.container -->
</section><!-- End Section -->
  
  <section class="room-detail-page">
    <div class="container">
      
      <div class="row">
        <div class="col-md-6">
            <h3 class="title-section mb10"><span class="fs14"><?php echo $object_type == 1 ? "PHÒNG" : "NHÀ"; ?> <?php echo $detail['name']; ?></span></h3>
            <!-- Table -->
            <table class="table table-bordered table-striped  table-style1">
              <tbody>
                <tr>
                  <th style="width: 120px;">Tên <?php echo $object_type == 1 ? "Phòng" : "Nhà"; ?></th>
                  <td class="text-bold fs16"><?php echo $detail['name']; ?></td>
                </tr>
                <tr>
                  <th>Diện tích</th>
                  <td><?php echo $detail['area']; ?><sup></td>
                </tr>
                <?php if($object_type == 1){ ?>
                <tr>
                  <th>Số người ở</th>
                  <td><?php echo $detail['max_person']; ?></td>
                </tr>
                <tr>
                  <th>Tầng</th>
                  <td><?php echo $detail['floor']; ?></td>
                </tr>
                
                <tr>
                  <th>Tình trạng</th>
                  <td class="text-red">
		<?php if($detail['status']==1){ ?>
                 Đang trống                        
                  <?php } ?> 
                  <?php if($detail['status']==2){ ?>
                  Đã cọc                       
                  <?php } ?>    
                  <?php if($detail['status']==3){ ?>
                  Đang ở                     
                  <?php } ?>
                  <?php if($detail['status']==4){ ?>
                  Chờ gia hạn            
                  <?php } ?>
		</td>
                </tr>
                <tr>
                  <th>Tiện ích <?php echo $object_type == 1 ? "phòng" : "nhà"; ?></th>
                  <?php
                  $str_room_addon_id = '';
                  $arrRoomAddon = $model->getListRoomInfo($id, 1);
                  if(!empty($arrRoomAddon)){
                      $str_room_addon_id = implode(",", $arrRoomAddon);
                  }
                  //var_dump("<pre>", $arrHouseAddon);
                  ?>
                  <td><?php echo $model->getNameAddonByString($str_room_addon_id); ?></td>
                </tr>
                <?php }else{ ?>
                <tr>
                  <th>Địa chỉ</th>
                  <td><?php echo $detail['address']; ?>, Phường <?php echo $model->getNameById('ward', $detail['ward_id']); ?>, <?php echo $model->getNameById('district', $detail['district_id']); ?></td>
                </tr>
                <tr>
                  <th>Thành phố</th>
                  <td><?php echo $model->getNameById('city', $detail['city_id']); ?></td>
                </tr>
                <tr>
                  <th>Hướng</th>
                  <td><?php echo $model->getNameById('direction',$detail['direction_id']); ?></td>
                </tr>
                <tr>
                  <th>Số phòng ngủ</th>
                  <td><?php echo $detail['no_room']; ?></td>
                </tr>
                <tr>
                  <th>Số WC</th>
                  <td><?php echo $detail['no_wc']; ?></td>
                </tr>
                <?php if($object_type < 3){ ?>
                           
                <tr>
                  <th>Tiện ích chung</th>
                  <?php
                  $str_house_addon_id = '';
                  $arrHouseAddon = $model->getListRelation("house_addon", "addon_id", "house_id", $detail['id']);
                  //var_dump($arrHouseAddon);
                  if(!empty($arrHouseAddon)){
                      $str_house_addon_id = implode(",", $arrHouseAddon);
                  }
                  //var_dump("<pre>", $arrHouseAddon);
                  ?>
                  <td><?php if($str_house_addon_id) echo $model->getNameAddonByString($str_house_addon_id); ?></td>
                </tr>
                <?php }else{ ?>
                
                <tr>
                  <th>Pháp lý</th>
                  <td><?php echo $detail['legal']; ?></td>
                </tr>
                <tr>
                  <th>Thanh toán</th>
                  <td><?php echo $detail['payment']; ?></td>
                </tr>

                <?php } ?>

                <?php } ?>
              </tbody>
            </table><!-- end Table -->
        </div><!-- end col -->
        <?php if($object_type==2 || $object_type == 3){ ?>
        <div class="col-md-6">
          <h3 class="title-section mb10"><span class="fs14">Giá <?php echo $object_type==3 ? "bán" : "thuê" ; ?> <?php echo $object_type == 1 ? "phòng" : "nhà"; ?></span></h3>
          <div class="body-box well2">
            <?php if($object_type==2){ ?>
            <p class="text-bold fs14 mb15">Hợp đồng tối thiểu : <?php echo $detail['min_contract']; ?></p>
            <p class="text-bold text-red fs18 mb10">Giá tốt: <?php echo ($object_type==1) ? number_format($detail['price_1']) : number_format($detail['price']); ?> đ/tháng</p>                    
           
           
            <p  class="alert alert-danger fs15 mt20 mb0">Đặt cọc số tiền: <?php echo ($object_type==1) ? number_format($detail['deposit']) : number_format($detail['deposit']); ?> vnđ để đảm bảo hợp đồng cho bạn.<br>
              Cam kết trả lại đầy đủ 100% khi hết hợp đồng.</p>
               <?php }else{ ?>
                <p class="text-bold text-red fs18 mb10">Giá bán: <?php echo ($detail['price_sell']); ?> vnđ</p>                        
               <?php } ?>

          </div>
        </div>
        <?php } ?>
        <?php if(!empty($houseDetail)){ ?>
        <div class="col-md-6">
            <h3 class="title-section mb10"><span class="fs14">NHÀ <?php echo $houseDetail['name']; ?></span></h3>
            <!-- Table -->
            <table class="table table-bordered table-striped table-style1">
              <tbody>
                <tr>
                  <th style="width: 120px;">Tên nhà</th>
                  <td class="text-bold fs16"><?php echo $houseDetail['name']; ?></td>
                </tr>
                <tr>
                  <th>Địa chỉ</th>
                  <td><?php echo $houseDetail['address']; ?>, Phường <?php echo $model->getNameById('ward', $detail['ward_id']); ?>, <?php echo $model->getNameById('district', $detail['district_id']); ?></td>
                </tr>
                <tr>
                  <th>Thành phố</th>
                  <td><?php echo $model->getNameById('city', $detail['city_id']); ?></td>
                </tr>
                <tr>
                  <th>Phòng trống</th>
                  <td><?php echo $model->countRoomInHouse($detail['house_id'], 1); ?>/<?php echo $model->countRoomInHouse($detail['house_id']); ?></td>
                </tr>                
                <tr>
                  <th>Tiện ích chung</th>
                  <?php
                  $str_house_addon_id = '';
                  $arrHouseAddon = $model->getListRelation("house_addon", "addon_id", "house_id", $detail['house_id']);
                  if(!empty($arrHouseAddon)){
                      $str_house_addon_id = implode(",", $arrHouseAddon);
                  }
                 	
                  ?>
                  <td><?php if($str_house_addon_id) echo $model->getNameAddonByString($str_house_addon_id); ?></td>
                </tr>
              </tbody>
            </table><!-- end Table -->
          </div><!-- end col -->
          <?php } ?>
      </div><!-- end row -->
      
      <div class="row mb25">
        <div class="col-md-6">
          <div class="tabs-customize">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <?php if($object_type == 1){ ?>
              <li role="presentation" class="active"><a href="#photo-of-room" aria-controls="photo-of-room" role="tab" data-toggle="tab">Hình phòng</a></li>
              <?php if($detail['video_url']) { ?>
              <li role="presentation"><a href="#video-of-room" aria-controls="video-of-room" role="tab" data-toggle="tab">Video phòng</a></li>
              <?php } ?>
              <?php } ?>
              <li role="presentation" 
              <?php if($object_type == 2 || $object_type == 3) echo 'class="active"'; ?>
              ><a href="#photo-of-house" aria-controls="photo-of-house" role="tab" data-toggle="tab">Hình nhà</a></li>
              <?php if($houseDetail['video_url']) { ?>
              <li role="presentation"><a href="#video-of-house" aria-controls="map" role="tab" data-toggle="tab">Video nhà</a></li>
              <?php } ?>
              <li role="presentation"><a href="#map" aria-controls="map" role="tab" data-toggle="tab">Vị trí bản đồ</a></li>
            </ul>
          
            <!-- Tab panes -->
            <div class="tab-content" style="overflow: hidden;">
              <?php if($object_type == 1){ ?>
              <div role="tabpanel" class="tab-pane fade <?php if($object_type == 1) echo 'in active'; ?>" id="photo-of-room">
                <!--<img src="uploads/photo-2.jpg" alt="">-->
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                  <!-- Indicators -->
                  <ol class="carousel-indicators">
                    <?php if(!empty($imageArr)) { $countR1 = 0; foreach ($imageArr as $value) { 
                     ?>
                      <li data-target="#myCarousel" data-slide-to="<?php echo $countR1; ?>" class="<?php if($countR1==0) echo "active"; ?>"></li>
                    
                    <?php $countR1++; } } ?>              
                   
                  </ol>

                  <!-- Wrapper for slides -->
                  <div class="carousel-inner" role="listbox">
                    <?php if(!empty($imageArr)) { $countR = 0; foreach ($imageArr as $value) { $countR++;
                     ?>
                    <div class="item <?php if($countR==1) echo "active"; ?>">
                      <img src="<?php echo $value['url']; ?>" alt="Chania">
                    </div>
                    <?php } } ?>
                  </div>

                  <!-- Left and right controls -->
                  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>
              </div><!-- end /.tab-pane -->
              <?php } ?>
              <div role="tabpanel" class="tab-pane fade " id="video-of-room">
                <?php echo $detail['video_url']; ?>
              </div>
              <div role="tabpanel" class="tab-pane fade <?php if($object_type == 2 || $object_type == 3) echo 'in active'; ?>" id="photo-of-house">
                  <?php if(!empty($imageHouseArr)) { ?>
                  <div id="myCarousel2" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                      <?php  $countR5 = 0; foreach ($imageHouseArr as $value) { 
                     ?>
                      <li data-target="#myCarousel2" data-slide-to="<?php echo $countR5; ?>" class="<?php if($countR5==0) echo "active"; ?>"></li>
                    
                    <?php $countR5++; } ?>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner" role="listbox">
                      <?php  $countR3 = 0; foreach ($imageHouseArr as $value) { $countR3++;
                       ?>
                      <div class="item <?php if($countR3==1) echo "active"; ?>">
                        <img src="<?php echo $value['url']; ?>" alt="Chania">
                      </div>
                      <?php }  ?>
                 
                    </div>

                    <!-- Left and right controls -->
                    <a class="left carousel-control" href="#myCarousel2" role="button" data-slide="prev">
                      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel2" role="button" data-slide="next">
                      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                  </div>
                <?php } ?>
              </div><!-- end /.tab-pane -->
              <?php if($houseDetail['video_url']){ ?>
              <div role="tabpanel" class="tab-pane fade " id="video-of-house">
                <?php echo $houseDetail['video_url']; ?>
              </div>
              <?php } ?>
              <div role="tabpanel" class="tab-pane fade" id="map">
                 <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13182.74263649889!2d106.6997296538663!3d10.7919373432754!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317528caacaa1abf%3A0x99f3f95a29b3c119!2zxJBpbmggVGnDqm4gSG_DoG5nLCBI4buTIENow60gTWluaCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1447054505080" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
                
              </div><!-- end /.tab-pane -->
            
            </div>      
          </div><!--end Tabs -->
        </div>
        <div class="col-md-6">

          <div class="contact-info-block">
            <h3 class="title-section mb10"><span class="more fs14">Liên hệ thuê <?php echo $object_type == 1 ? "PHÒNG" : "NHÀ"; ?></span></h3>
            <div class="body-box well2">
              <p class="text-bold text-red fs16 mb10">TƯ VẤN CHỌN <?php echo $object_type==1 ? "PHÒNG" : "NHÀ"; ?>, ĐƯA KHÁCH XEM <?php echo $object_type==1 ? "PHÒNG" : "NHÀ"; ?> MIỄN PHÍ!</p>                    
              <p class="text-bold">Tiếp Đón Khách Xem Phòng Vào: 4:00 PM - 7:00 PM mỗi ngày</p>
              <p class="text-bold fs16 mt05 mb05">GỌI NGAY ĐỂ GIỮ <?php echo $object_type==1 ? "PHÒNG" : "NHÀ"; ?> ƯNG Ý NHẤT CỦA BẠN KẺO HẾT !</p>
              <p class="text-bold">Hẹn giờ xem phòng: <span class="text-red fs16"><?php echo $detailMod['phone']; ?> (<?php echo $detailMod['name']; ?>)</span></p>
              <p class="text-bold">Cần tư vấn thêm: <span class="text-red fs16"><?php echo $detailMod['phone']; ?></span></p>              
              
              <ul class="item-list mt20">
                <li class="col-xs-12">
                  <div class="item">
                    <div class="thumb"><img class="lazy" style="width:150px !important" data-original="<?php echo $detailMod['image_url']; ?>" alt=""></div>
                    <div class="body-text">
                      <p class="name"><?php echo $detailMod['name']; ?></p>
                      <p class="tel"><a href="#"><?php echo $detailMod['phone']; ?></a></p>
                      <p></p>
                    </div>
                  </div>
                </li>    
              </ul>
              <div class="clearfix"></div>  
            </div>
          </div>
        </div>
      </div><!-- end row -->
      <div id="content-detail">
        <div class="panel panel-default">
          <div class="panel-heading">Thông tin chi tiết</div>
          <div class="panel-body">
            <?php echo $detail['description']; ?>
          </div>
        </div>
        
      </div>
      <?php if($object_type==1) { ?>
      <div class="content-info-more-block mb20">
        <h3 class="title-section"><span>Tùy chọn tiện nghi cho phòng</span></h3>
        <h4 class="title-style-1">Tiện nghi đã trang bị</h4>
        <p class="fs16 mb30">Ngoài những tiện nghi đã được trang bị sẵn cho Phòng. Bạn có thể lựa chọn thêm những tiện nghi khác theo nhu cầu của mình <br>Việc chọn thêm tiện nghi sẽ làm thay đổi Giá Thuê Phòng cuối cùng của bạn.</p>
        
        <div class="body-box row">
          <ul class="item-list-convenient">
             <?php $i = 0 ; foreach ($convenientArr['data'] as $ser) { $i ++;
                ?>
              <li class="col-md-3 col-xs-6">
                <div data-value="<?php echo $ser['price']; ?>" class="item <?php if(in_array($ser['id'], $arrConvenientSelected)) echo "choose";else echo "nochoose"; ?>">
                  <div class="thumb"><img class="lazy" data-original="<?php echo $ser['image_url']; ?>" alt=""></div>
                  <div class="body-text">
                    <h5 class="tit"><?php echo $ser['name']; ?></h5>
                    <p class="des"><?php echo $ser['description']; ?></p>
                    <p class="price"><span><?php echo number_format($ser['price']); ?> đ/tháng</span></p>
                  </div>
                </div>
              </li>


                <?php
            }

            ?>            
          </ul>
        </div>
      
      </div><!-- End /.content-info-more-block -->
      <?php } ?>
      <div class="row mb25">
        <?php if($object_type == 1){ 
          if($detail['price_3'] == 0) $detail['price_3'] = $detail['price_1'];
          if($detail['price_6'] == 0) $detail['price_6'] = $detail['price_1'];
          
          ?>
        <div class="col-md-6">
          <h3 class="title-section mb10"><span class="fs14">Giá thuê <?php echo $object_type == 1 ? "phòng" : "nhà"; ?></span></h3>
          <div class="body-box well2">
            <p class="text-bold fs14 mb15">Lựa chọn thời hạn hợp đồng</p>
            <p class="text-bold text-red fs18 mb10">Giá tốt: <span id="span_price_show"><?php echo number_format($detail['price_1']); ?></span> đ/tháng</p>                    
            <input type="hidden" id="price_show" value="<?php echo ($detail['price_1']); ?>">
            <div class="btn-group" role="group" aria-label="...">
              <button type="button" class="btn btn-default click-price fs16 active" data-value="<?php echo $detail['price_1']; ?>">1 tháng</button>
              <button type="button" class="btn btn-default click-price fs16" data-value="<?php echo $detail['price_3']; ?>">3 tháng</button>
              <button type="button" class="btn btn-default click-price fs16 " data-value="<?php echo $detail['price_6']; ?>">6 tháng</button>
            </div>
   
            <p  class="alert alert-danger fs15 mt20 mb0">Đặt cọc số tiền: <?php echo ($object_type==1) ? number_format($detail['deposit']) : number_format($detail['min_deposit']); ?> vnđ để đảm bảo hợp đồng cho bạn.<br>
              Cam kết trả lại đầy đủ 100% khi hết hợp đồng.</p>
          </div>
        </div>
        
        <div class="col-md-6">
          <h3 class="title-section mb10"><span class="fs14">Giá dịch vụ</span></h3>
          <!-- Table -->
          <table class="table table-bordered table-striped  table-style1">
            <tbody>
              <?php if(!empty($houseServiceArr)){ 
                foreach ($houseServiceArr as $key => $value) {
                  
                ?>
              <tr>
                <th style="width: 140px;"><?php echo $model->getNameById('services', $value['service_id']); ?></th>
                <td><p style="width:100px; text-align:right"><?php echo number_format($value['price']); ?> đ</p></td>
              </tr>
              <?php }} ?>              
            </tbody>
          </table><!-- end Table -->
        </div>
        <?php } ?>
      </div><!-- end row -->
      
      <div class="fb-comments-block">
        <h3 class="title-section mb10"><span class="fs14">Bình luận</span></h3>
        <div>
          <div class="fb-comments" data-href="http://<?php echo $_SERVER['SERVER_NAME']; ?><?php echo $_SERVER['REQUEST_URI']; ?>" data-width="1000" data-mobile="true" data-numposts="3"></div>
        </div>
      </div><!-- end row -->
    
    </div><!-- End /.container -->
  </section><!-- End Section -->
 <script type="text/javascript">
$(document).ready(function(){
  $('.click-price').click(function(){
    var obj = $(this);
    var price = obj.attr('data-value');
    
    $('.click-price').removeClass('active');
    obj.addClass('active');
    var total_more = 0;
    $('.addmore').each(function(){
      total_more += parseInt($(this).attr('data-value'));
    });    
    price = parseInt(price);
    $('#span_price_show').html(addCommas(price+total_more));
    $('#price_show').val(price+total_more);
  });
  $('.nochoose').click(function(){
    var obj = $(this);
    var value = parseInt(obj.attr('data-value'));
    var total_price = parseInt($('#price_show').val());
    
    if(obj.hasClass('addmore')==false){
      obj.addClass('addmore');
      $('#price_show').val(total_price + value);
      $('#span_price_show').html(addCommas(total_price + value));
    }else{
      obj.removeClass('addmore');
      $('#price_show').val(total_price - value);
      $('#span_price_show').html(addCommas(total_price - value));
    }    
  });

});

 </script>
