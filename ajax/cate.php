<?php           
require_once "../backend/model/Frontend.php";
$model = new Frontend;
$city_id = $_POST['city_id'];
$type_id = $_POST['type_id'];
$price_id = $_POST['price_id'];
$district_id = $_POST['district_id'];

$roomTotalArr = $model->getList("objects", -1, -1, array('city_id' => $city_id, 'type_id' => $type_id, 'price_id' => $price_id));

$total_record_room = $roomTotalArr['total'];

$total_page_room = ceil($total_record_room / 24);         

$page = isset($_POST['page']) ? (int) $_POST['page'] : 1;

$offset = 24 * ($page - 1);


$roomArr = $model->getList("objects", $offset, 24, array('city_id' => $city_id, 'type_id' => $type_id, 'price_id' => $price_id));
?>

  <?php if(!empty($roomArr['data'])){
    foreach ($roomArr['data'] as $key => $value) {                        
      //var_dump("<pre>", $value);                         
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
<script>
$(document).ready(function(){

  $("img.lazy").lazyload({
      effect : "fadeIn"
  });

});
</script>