<div class="col-md-9 col-sm-12" style="margin-top:20px">
  <section>
  
    <ol class="breadcrumb">
      <li><a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>">Trang chủ</a></li>    
      
      
      <li class="active"><?php echo $detailArr['page_name']; ?></li>
    </ol>
  
</section><!-- End Section -->
<!--<h1 id="title-page" style="color: #651616;text-align: center; font-size: 18px; margin-top: 15px; margin-bottom: 15px;
">Bao su co</h1>-->

<div id="content-page" style="margin-top:20px;">

 <?php echo stripslashes($detailArr['content']); ?>
  </div>
<div class="clearfix"></div>

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
