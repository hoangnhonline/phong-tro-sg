<?php
ini_set('display_errors',0);
//var_dump($_SERVER['DOCUMENT_ROOT']);
ob_start();
session_start();
if(!isset($_SESSION))
{
    session_start();
}
if(isset($_SESSION['user_id'])== FALSE) {
    $_SESSION['back']= $_SERVER['REQUEST_URI'];
    $_SESSION['error']= "Bạn chưa đăng nhập";
    header("location: login.php");
}
include "defined.php";
$mod='';
if(isset($_GET['mod']))
{
    $mod = $_GET['mod'];
}
$_SESSION['fullname'] = "Admin";
require_once "model/Backend.php";
$model = new Backend;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin | phongtrosg.com</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?php echo STATIC_URL; ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />

        <!-- font Awesome -->
        <link href="<?php echo STATIC_URL; ?>css/font-awesome.min.css" rel="stylesheet" type="text/css" />        
        <!-- Theme style -->
        <link href="<?php echo STATIC_URL; ?>css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <link href="css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
          <!-- jQuery 2.0.2 -->
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
        <script src="<?php echo STATIC_URL; ?>js/form.js" type="text/javascript"></script>
           
        <!-- Bootstrap -->
        <script src="<?php echo STATIC_URL; ?>js/bootstrap.min.js" type="text/javascript"></script>
           <script src="js/bootstrap-select.min.js" type="text/javascript"></script>         
        <!-- AdminLTE App -->
        <script src="<?php echo STATIC_URL; ?>js/AdminLTE/app.js" type="text/javascript"></script>
        <script src="<?php echo STATIC_URL; ?>js/number.js" type="text/javascript"></script>

        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="<?php echo STATIC_URL; ?>js/AdminLTE/dashboard.js" type="text/javascript"></script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <script type="text/javascript">
        $(function(){
            $('input.number').number(true, 0);
            $('.selectpicker').selectpicker();
            $('.datepicker').datepicker({
                dateFormat :'dd-mm-yy'
            });
        });
        </script>
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="index.php" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                phongtrosg.com
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <?php include URL_LAYOUT."top.php"; ?>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <?php include URL_LAYOUT."sidebar.php"; ?>
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Main content -->
                <section class="content">
                    <?php
                     $act = isset($_GET['act']) ? $_GET['act'] : "";

                    if ($mod=="") include "view/dashboard/index.php";
                    else include "view/".$mod.'/'.$act.'.php';

                    ?>
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->



<script type="text/javascript" src="../js/lazy.js"></script>
<script type="text/javascript">
$(document).ready(function(){

  $("img.lazy").lazyload({
      effect : "fadeIn"
  });

});
</script>
    </body>
</html>
