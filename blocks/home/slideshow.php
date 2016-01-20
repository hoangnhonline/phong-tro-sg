 <section class="slideshow-block col-md-12">
  <div class="body-wrap">
    <div class="flexslider">
       <ul class="slides">
        <?php 
        $arrBanner = $model->getListBannerByPosition(1);
        foreach($arrBanner as $banner){              
        ?>
        <li><img src="<?php echo $banner['image_url']; ?>" alt=""></li>
        <?php } ?>             
       </ul>
    </div>
  </div>
</section><!-- End /.slideshow-block -->