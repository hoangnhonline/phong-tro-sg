<nav class="navbar navbar-static-top" role="navigation">

                <!-- Sidebar toggle button-->

                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">

                    <span class="sr-only">Toggle navigation</span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>

                    <span class="icon-bar"></span>

                </a>

                <div class="navbar-right">

                    <ul class="nav navbar-nav">                        
                        <!-- User Account: style can be found in dropdown.less -->

                        <li class="dropdown user user-menu">

                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                                <i class="glyphicon glyphicon-user"></i>

                                <span><?php echo $_SESSION['name']; ?> <i class="caret"></i></span>

                            </a>

                            <ul class="dropdown-menu" id="menu_top">                           
                                                                                            
                                <li class="user-footer">                                   

                                    <div class="pull-right">

                                        <a href="index.php?mod=user&act=changepass" class="btn btn-default btn-flat" style="color:red">
                                            Đổi mật khẩu
                                        </a>

                                    </div>

                                </li>    
                                <!-- Menu Footer-->

                                <li class="user-footer">                                   

                                    <div class="pull-right">

                                        <a href="logout.php" class="btn btn-default btn-flat" style="color:red">Đăng xuất</a>

                                    </div>

                                </li>

                            </ul>
                            <style type="text/css">
                            #menu_top li {display: inline;float: left}
                            </style>
                        </li>

                    </ul>

                </div>

            </nav>