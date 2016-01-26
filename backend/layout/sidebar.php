<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            <img src="../<?php echo $_SESSION['image_url']; ?>" class="img-circle" alt="User Image" />
        </div>
        <div class="pull-left info">
            <p>Hello, <?php echo $_SESSION['name']; ?></p>
        </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search..."/>
            <span class="input-group-btn">
                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
            </span>
        </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
        <li class="active">
            <a href="<?php echo BASE_URL; ?>house&act=list">
                <i class="fa fa-th"></i> <span>Nhà có phòng cho thuê</span>
            </a>
        </li>
        <li class="active">
            <a href="<?php echo BASE_URL; ?>housesell&act=list">
                <i class="fa fa-th"></i> <span>Nhà bán</span>
            </a>
        </li>  
        <!--<li class="active">
            <a href="<?php echo BASE_URL; ?>articles&act=list">
                <i class="fa fa-th"></i> <span>Tin tức</span>
            </a>
        </li>-->
        <li class="active">
            <a href="<?php echo BASE_URL; ?>room&act=list">
                <i class="fa fa-th"></i> <span>Phòng cho thuê</span>
            </a>
        </li>           
        <li class="active">
            <a href="<?php echo BASE_URL; ?>houserent&act=list">
                <i class="fa fa-th"></i> <span>Nhà cho thuê</span>
            </a>
        </li>
        <li class="active">
            <a href="<?php echo BASE_URL; ?>contract&act=list">
                <i class="fa fa-th"></i> <span>Hợp đồng</span>
            </a>
        </li>   
        <li class="active">
            <a href="<?php echo BASE_URL; ?>reportdoanhthu&act=list">
                <i class="fa fa-th"></i> <span>Doanh thu</span>
            </a>
        </li>  
        <li class="active">
            <a href="<?php echo BASE_URL; ?>house&act=list-chi-phi">
                <i class="fa fa-th"></i> <span>Chi phí</span>
            </a>
        </li>    
        <li class="active">
            <a href="<?php echo BASE_URL; ?>customers&act=list">
                <i class="fa fa-th"></i> <span>Khách hàng</span>
            </a>
        </li>
<?php if($_SESSION['level']==1){ ?>
        <li class="active">
            <a href="<?php echo BASE_URL; ?>page&act=list">
                <i class="fa fa-th"></i> <span>Trang</span>
            </a>
        </li>
        
        <li class="active">
            <a href="<?php echo BASE_URL; ?>user&act=list">
                <i class="fa fa-th"></i> <span>Mod</span>
            </a>
        </li>    
        <?php } ?>
        <li class="treeview active">
          <a href="#">
            <i class="fa fa-folder"></i> <span>Thông tin chung</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li>
                <a href="<?php echo BASE_URL; ?>addon&act=list">
                    <i class="fa fa-circle-o"></i> <span>Tiện ích</span> <!--<small class="badge pull-right bg-green">new</small>-->            </a>
            </li>
            <li>
                <a href="<?php echo BASE_URL; ?>convenient&act=list">
                    <i class="fa fa-circle-o"></i> <span>Tiện nghi</span> <!--<small class="badge pull-right bg-green">new</small>-->            </a>
            </li>     
            <li>
                <a href="<?php echo BASE_URL; ?>services&act=list">
                    <i class="fa fa-circle-o"></i> <span>Dịch vụ</span> <!--<small class="badge pull-right bg-green">new</small>-->            </a>
            </li> 
             <li>
                <a href="<?php echo BASE_URL; ?>direction&act=list">
                    <i class="fa fa-circle-o"></i> <span>Hướng nhà</span> <!--<small class="badge pull-right bg-green">new</small>-->            </a>
            </li>
            <li>
                <a href="<?php echo BASE_URL; ?>purpose&act=list">
                    <i class="fa fa-circle-o"></i> <span>Mục đích sử dụng</span> <!--<small class="badge pull-right bg-green">new</small>-->            </a>
            </li>              
            <li>
                <a href="<?php echo BASE_URL; ?>city&act=list">
                    <i class="fa fa-circle-o"></i> <span>Tỉnh / Thành</span> <!--<small class="badge pull-right bg-green">new</small>-->            </a>
            </li>         
            <li>
                <a href="<?php echo BASE_URL; ?>district&act=list">
                    <i class="fa fa-circle-o"></i> <span>Quận/Huyện</span> <!--<small class="badge pull-right bg-green">new</small>-->            </a>
            </li>      
            <li>
                <a href="<?php echo BASE_URL; ?>ward&act=list">
                    <i class="fa fa-circle-o"></i> <span>Phường / Xã</span> <!--<small class="badge pull-right bg-green">new</small>-->            </a>
            </li>       
            <li>
                <a href="<?php echo BASE_URL; ?>price&act=list">
                    <i class="fa fa-circle-o"></i> <span>Khoảng giá</span> <!--<small class="badge pull-right bg-green">new</small>-->            </a>
            </li>
<?php if($_SESSION['level']==1){ ?>
            <li>
                <a href="<?php echo BASE_URL; ?>seo&act=list">
                    <i class="fa fa-circle-o"></i> <span>SEO</span> <!--<small class="badge pull-right bg-green">new</small>-->            </a>
            </li> 
            <li>
                <a href="<?php echo BASE_URL; ?>text&act=list">
                    <i class="fa fa-circle-o"></i> <span>Text</span> <!--<small class="badge pull-right bg-green">new</small>-->            </a>
            </li>  

            <li>
                <a href="index.php?mod=banner&act=index">
                    <i class="fa fa-angle-double-right"></i> Banner
                </a>
            </li>            
<?php } ?>
          </ul>
        </li>
    </ul>
</section>
<!-- /.sidebar -->
