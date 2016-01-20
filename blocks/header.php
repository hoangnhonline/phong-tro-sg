<header id="header-panel">
     
    <div class="header-main col-md-12">
        <h2 class="logo">
            <a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>" title="logo phongtrosg.com">
                <img class="imghover" src="images/logo.png" alt="logo phongtrosg.com" title="logo phongtrosg.com" width="200" height="40">
            </a>
        </h2>
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>                         
        </div><!--navbar-header-->
        <div class="collapse navbar-collapse">            
            <ul class="nav navbar-nav" id="menu_bar">
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">BĐS Bán <b class="caret"></b></a>
                    <?php $sellArr = $model->getTypeBDS(2);
                    if(!empty($sellArr)){
                    ?>
                    <ul class="dropdown-menu multi-level">
                      <?php foreach ($sellArr as $key => $value) {
                       ?>
                        <li><a href="<?php echo $value['alias']?>.html"><?php echo $value['name']; ?></a></li>
                        <?php } ?>
                        
                    </ul>
                    <?php } ?>
                </li>
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">BĐS Cho Thuê<b class="caret"></b></a>
                    <?php $rentArr = $model->getTypeBDS(1);
                    if(!empty($rentArr)){
                    ?>
                    <ul class="dropdown-menu multi-level">
                      <?php foreach ($rentArr as $key => $value) {
                       ?>
                        <li><a href="<?php echo $value['alias']?>.html"><?php echo $value['name']; ?></a></li>
                        <?php } ?>
                        
                    </ul>
                    <?php } ?>
                </li>
		<li><a href="http://phongtrosg.com/trang/bao-su-co.html" target="_blank">Báo Cáo Sự Cố</a> </li>
		<li><a href="http://phongtrosg.com/trang/thanh-toan.html" target="_blank">Thanh Toán</a> </li>                   
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</header><!-- End #header-panel-->