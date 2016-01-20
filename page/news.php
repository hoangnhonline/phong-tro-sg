<section class="section-top-home-block clearfix">
  <div class="container">
    <ol class="breadcrumb">
      <li><a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>">Trang chủ</a></li>    
      
      <li class="active">Tin tức</li>
    </ol>
  </div><!-- End /.container -->
</section><!-- End Section -->
  
<section class="room-detail-page">
	<div class="container">
		<?php $sql = "SELECT * FROM articles ORDER BY id DESC LIMIT 0,4"; 
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
        ?>
		<div class="row item-news">
			<div class="col-md-3">
				<a href="chi-tiet-tin/<?php echo $row['alias']?>-<?php echo $row['id']; ?>.html">
					<img data-original="<?php echo $row['image_url']; ?>" class="img-responsive img-thumbnail lazy" >
				</a>
			</div>
			<div class="col-md-9">
				<h2 class="new-title">
					<a href="chi-tiet-tin/<?php echo $row['alias']?>-<?php echo $row['id']; ?>.html"><?php echo $row['name']; ?></a></h2>
				<div class="new-desc"><?php echo $row['description']; ?></div>
			</div>
		</div>
		<?php } ?>
	</div>
</section>