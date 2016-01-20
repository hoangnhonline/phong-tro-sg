<?php 
$modArr = $model->getListMod();
?>
<?php if(!empty($modArr)){ ?>
<section class="news-highlight-home-block row" style="padding:0px;" id="mod-list">
  <h3 class="tit-block">Quản lý nhà</h3>
  <ul class="list-box">   
    <?php foreach ($modArr as $mod) { ?>     
    <li>
      <div class="col-md-4 col-sm-3 col-xs-3">
        <img src="<?php echo $mod['image_url']; ?>" class="img-responsive" alt="<?php echo $mod['name']; ?>" />
      </div>
      <div class="col-md-8 col-sm-9 col-xs-9">
        <div class="mod-name"><?php echo $mod['name']; ?></div>
        <div class="mod-phone"><?php echo $mod['phone']; ?></div>
        <div class="mod-email"><?php echo $mod['email']; ?></div>  
      </div>
    </li>
    <?php } ?>
  </ul>
</section><!-- End /.slideshow -->
<?php } ?>