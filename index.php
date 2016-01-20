<?php 
session_start();
date_default_timezone_set ('Asia/Saigon');
require_once 'routes.php';
require_once "backend/model/Frontend.php";
$model = new Frontend;

//$mod = isset($_GET['mod']) && in_array($_GET['mod'], array('home', 'detail', 'list','news', 'news-detail')) ? $_GET['mod'] : 'home';
?>
<!doctype html>
<!--[if lt IE 7 ]><html dir="ltr" lang="en-US" class="no-js ie ie6 lte7 lte8 lte9"><![endif]-->
<!--[if IE 7 ]><html dir="ltr" lang="en-US" class="no-js ie ie7 lte7 lte8 lte9"><![endif]-->
<!--[if IE 8 ]><html dir="ltr" lang="en-US" class="no-js ie ie8 lte8 lte9"><![endif]-->
<!--[if IE 9 ]><html dir="ltr" lang="en-US" class="no-js ie ie9 lte9"><![endif]-->
<!--[if IE 10 ]><html dir="ltr" lang="en-US" class="no-js ie ie10 lte10"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html>
<!--<![endif]-->
<head>
<meta charset="utf-8" />
<title><?php echo $seo['meta_title']; ?></title>
<base href="http://<?php echo $_SERVER["SERVER_NAME"]; ?>">   
<meta name="description" content="<?php echo $seo['meta_description']; ?>">
<meta name="keyword" content="<?php echo $seo['meta_keyword']; ?>">
<meta name="robots" content="index,follow" />

<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/bootstrap-select.min.css" rel="stylesheet">
<link href="css/font-awesome.min.css" rel="stylesheet">
<link href="css/reset.css" rel="stylesheet">
<link href="css/style.css?v=1" rel="stylesheet">
<link href="css/flexslider.css" rel="stylesheet" rel="stylesheet">
<script src="js/jquery-1.11.0.min.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-select.min.js"></script>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
  <div id="ads-left">
  
  </div>
   <div id="ads-right">
  </div>
  <!-- â–¼WRAPPERâ–¼ -->
	<div id="wrapper">
   
    <div class="container">
      <!-- â–¼HEADERâ–¼ -->
      <?php include "blocks/header.php"; ?>
      <div class="clearfix"></div>
      <!-- â–¼MAINâ–¼ -->
      <div id="main-panel" class="clearfix">
        <!-- â–¼CONTENTâ–¼ -->
        <div id="content">
        
          <?php include "page/".$mod.".php"; ?>
            
        </div><!-- End #content -->   
                            
      </div><!-- End #main-panel -->
      <?php include "blocks/choose-me.php"; ?>
       
      <?php include "blocks/footer.php"; ?>
    </div>
   
    
    
  </div><!-- End #wrapper -->

<script src="js/jquery.flexslider-min.js"></script>
<script src="js/common.lib.js"></script> 
<script src="js/lazy.js"></script>

<script>
$(document).ready(function(){

  $("img.lazy").lazyload({
      effect : "fadeIn"
  });

});
</script>
<?php if($mod=="detail"){ ?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.5&appId=567408173358902";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php } ?>
<script type="text/javascript">
  $(document).ready(function(){
    $('#btnSearch').click(function(){
      var urlSubmit = "";
      var type_id = $('#type_id option:selected').attr('data-alias');
      if(type_id != ''){
        urlSubmit +=  "/" + type_id ;
      }else{
        alert('Vui lòng chọn Loại nhà đất');return false;
      }
      var city_id = $('#city_id option:selected').attr('data-alias');
      if(city_id != ''){
        urlSubmit +=  "/" + city_id ;
      }else{
        alert('Vui lòng chọn Tỉnh / TP');return false;
      }
      var district_id = $('#district_id option:selected').attr('data-alias');
      if(district_id != ''){
        urlSubmit +=  "/" + district_id ;
      }
      var price_id = $('#price_id option:selected').attr('data-alias');
      if(price_id != ''){
        urlSubmit +=  "/" + price_id ;
      }
      urlSubmit += ".html";
      location.href= urlSubmit;
    });
    $('#type').change(function(){
      $.ajax({
          url: "process/child.php",
          type: "POST",
          async: true,
          data: {
              id : $(this).val(),
              child : 'type_bds'
          },
          success: function(data){                    
              $('#type_id').html(data);
              $('#type_id').selectpicker('refresh')
          }
      });
      $.ajax({
          url: "process/child.php",
          type: "POST",
          async: true,
          data: {
              id : $(this).val(),
              child : 'price'
          },
          success: function(data){                    
              $('#price_id').html(data);
              $('#price_id').selectpicker('refresh')
          }
      });
    });
    $('#city_id').change(function(){
      $.ajax({
          url: "process/child.php",
          type: "POST",
          async: true,
          data: {
              id : $(this).val(),
              child : 'district'
          },
          success: function(data){                    
              $('#district_id').html(data);
              $('#district_id').selectpicker('refresh')
          }
      });
    });
  });
  <?php if(isset($type) && $type > 0){ ?>
    
      $.ajax({
          url: "process/child.php",
          type: "POST",
          async: true,
          data: {
              id : <?php echo $type; ?>,
              child : 'type_bds'
          },
          success: function(data){                    
              $('#type_id').html(data);
              <?php if(isset($type_id) && $type_id > 0){ ?>
              $('#type_id').val(<?php echo $type_id; ?>);
              <?php } ?>
              $('#type_id').selectpicker('refresh');

          }
      });
      $.ajax({
          url: "process/child.php",
          type: "POST",
          async: true,
          data: {
              id : <?php echo $type; ?>,
              child : 'price'
          },
          success: function(data){                    
              $('#price_id').html(data);
              <?php if(isset($price_id) && $price_id > 0){ ?>
              $('#price_id').val(<?php echo $price_id; ?>);
              <?php } ?>
              $('#price_id').selectpicker('refresh');

          }
      });
    
  <?php } ?>
  <?php if(isset($city_id) && $city_id > 0){ ?>
    
      $('#city_id').val(<?php echo $city_id; ?>);
      $('#city_id').selectpicker('refresh');
      $.ajax({
          url: "process/child.php",
          type: "POST",
          async: true,
          data: {
              id : <?php echo $city_id; ?>,
              child : 'district'
          },
          success: function(data){                    
              $('#district_id').html(data); 
              <?php if(isset($district_id) && $district_id > 0){ ?>
                $('#district_id').val(<?php echo $district_id; ?>);
                <?php } ?>             
              $('#district_id').selectpicker('refresh');             

          }
      });
    
  <?php } ?>
 
</script>
<script type="text/javascript" src="js/validate.js"></script>
<script type="text/javascript" src="js/form.js"></script>
<link rel="stylesheet" type="text/css" href="css/sweet.css">
<script type="text/javascript" src="js/sweet.js"></script>
<script type="text/javascript">
  $(function(){
    $('#contactForm').validate();
    $('#contactForm').ajaxForm({
            beforeSend: function() {                
            },
            uploadProgress: function(event, position, total, percentComplete) {              
            },
            complete: function(data) {  
              console.log(data);
              if($.trim(data.responseText)=='success'){           
                swal({   
                  title: "OK",   
                  text: "Gửi thông điệp thành công",   
                  type: "success",                
                  confirmButtonText: "OK",  
                   closeOnConfirm: true }, 
                   function(){   
                    $('#name, #email, #title, #content').val('');
                  });
                
              }else{    
                  swal('Error','Có lỗi xảy ra!','error');
                  $('#btnReset').click();
              }
            }
        });
    });
</script>
</body>
</html>
