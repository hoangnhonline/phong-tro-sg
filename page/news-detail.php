<section class="section-top-home-block clearfix">
  <div class="container">
    <ol class="breadcrumb">
      <li><a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>">Trang chủ</a></li>    
      <li><a href="tin-tuc.html">Tin tức</a></li> 
      <li class="active">Chi tiết</li>
    </ol>
  </div><!-- End /.container -->
</section><!-- End Section -->
  
<section class="room-detail-page">
	<div class="container">
		<div class="col-md-8">
			<h1 class="news-detail-title"><?php echo $detail['name']; ?></h1>
			<p class="news-detail-desc">
				<?php echo $detail['description']; ?>
			</p>
			<div id="news-content">
				<?php echo str_replace("../", "", $detail['content']); ?>
			</div>
		</div>
		<div class="col-md-4">
			<section class="news-highlight-home-block">
		      <h3 class="tit-block">Tin tức khác</h3>
		      <ul class="list-box">
		        <?php $sql = "SELECT * FROM articles WHERE id <> $id ORDER BY id DESC LIMIT 0,10"; 
		        $rs = mysql_query($sql);
		        while($row = mysql_fetch_assoc($rs)){
		        ?>
		        <li class="row">
		          <div class="col-xs-4 thumb"><a href="chi-tiet-tin/<?php echo $row['alias']?>-<?php echo $row['id']; ?>.html" title=""><img class="lazy" data-original="<?php echo $row['image_url']; ?>" alt="" ></a></div>
		          <h4 class="title col-xs-8"><a href="chi-tiet-tin/<?php echo $row['alias']?>-<?php echo $row['id']; ?>.html" title=""><?php echo $row['name']; ?></a><h4>
		        </li>
		        <?php } ?>
		      </ul>
		    </section><!-- End /.slideshow -->
		</div>
	</div>
	

</section>