<section class="news-highlight-home-block row" style="margin-bottom:20px;">
  <h3 class="tit-block">Phòng nổi bật</h3>
  <?php 
$rs = mysql_query("SELECT * FROM objects WHERE object_type =  1  ORDER BY RAND() LIMIT 0,5") or die(mysql_error());
while($value = mysql_fetch_assoc($rs)){
  ?>
  <div class="room-footer">
    <div class="col-sm-5">
      <a href="chi-tiet/<?php echo $value['alias']; ?>-<?php echo $value['id']; ?>.html">
        <img data-original="<?php echo $value['image_url']; ?>" class="img-responsive lazy" />
      </a>
    </div>
    <div class="col-sm-7">
      <div class="f-title"><a href="chi-tiet/<?php echo $value['alias']; ?>-<?php echo $value['id']; ?>.html">
        <?php echo $value['name']; ?></a></div>
      <div class="f-address"><?php echo $model->getNameById('district', $value['district_id']); ?></div>
      <div class="f-price"><?php echo number_format($value['price_1']); ?></div>
    </div>
  </div>
  <?php } ?>
</section><!-- End /.slideshow -->