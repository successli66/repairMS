<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>维修管理系统</title>
        <!--屏幕自适应-->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="/Public/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="/Public/plugins/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="/Public/plugins/ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="/Public/dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="/Public/dist/css/skins/_all-skins.min.css">
        <!-- iCheck(表单美化) -->
        <link rel="stylesheet" href="/Public/plugins/iCheck/all.css">
        <!-- Morris chart（莫里斯图表） -->
        <link rel="stylesheet" href="/Public/plugins/morris/morris.css"> 
        <!-- Date Picker（日期选择器）-->
        <link rel="stylesheet" href="/Public/plugins/datepicker/datepicker3.css">
        <!-- Daterange picker（时间区间选择器） -->
        <link rel="stylesheet" href="/Public/plugins/daterangepicker/daterangepicker.css">
        <!-- Bootstrap time Picker（bootstrap时间选择器） -->
        <link rel="stylesheet" href="/Public/plugins/timepicker/bootstrap-timepicker.min.css">
        <!--引入joliAdmin时钟样式-->
        <link rel="stylesheet" type="text/css" id="theme" href="/Public/other/JoliAdmin/theme-default2.css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="other/html5shiv/html5shiv.min.js"></script>
        <script src="other/respond/respond.min.js"></script>
        <![endif]-->

        <!--引入js文件-->
        <!-- jQuery 2.2.3 -->
        <script type="text/javascript" src="/Public/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="/Public/plugins/jQueryUI/jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
            $.widget.bridge('uibutton', $.ui.button);
        </script>
        <!-- Bootstrap 3.3.6 -->
        <script src="/Public/bootstrap/js/bootstrap.min.js"></script>
        <!-- Morris.js charts -->
        <script src="/Public/plugins/raphael/raphael.min.js"></script>
        <script src="/Public/plugins/morris/morris.min.js"></script>
        <!-- Sparkline -->
        <script src="/Public/plugins/sparkline/jquery.sparkline.min.js"></script>
        <!-- jvectormap -->
        <script src="/Public/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="/Public/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
        <!-- jQuery Knob Chart -->
        <script src="/Public/plugins/knob/jquery.knob.js"></script>
        <!-- daterangepicker -->
        <script src="/Public/plugins/moment/moment.js"></script>
        <script src="/Public/plugins/daterangepicker/daterangepicker.js"></script>
        <!-- datepicker -->
        <script src="/Public/plugins/datepicker/bootstrap-datepicker.js"></script>
        <script src="/Public/plugins/datepicker/locales/bootstrap-datepicker.zh-CN.js"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="/Public/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
        <!-- Slimscroll -->
        <script src="/Public/plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="/Public/plugins/fastclick/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="/Public/dist/js/app.min.js"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="/Public/dist/js/pages/dashboard.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="/Public/dist/js/demo.js"></script>
        <!-- InputMask -->
        <script src="/Public/plugins/input-mask/jquery.inputmask.js"></script>
        <script src="/Public/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
        <script src="/Public/plugins/input-mask/jquery.inputmask.extensions.js"></script>
        <!-- bootstrap time picker -->
        <script src="/Public/plugins/timepicker/bootstrap-timepicker.min.js"></script>
        <!--joliAdmin时钟js-->
        <script src="/Public/other/JoliAdmin/time.js"></script>

        <style>
            .pages a,.pages span {
                display:inline-block;
                padding:2px 5px;
                margin:0 1px;
                border:1px solid #f0f0f0;
                -webkit-border-radius:3px;
                -moz-border-radius:3px;
                border-radius:3px;
            }
            .pages a,.pages li {
                display:inline-block;
                list-style: none;
                text-decoration:none; color:#58A0D3;
            }
            .pages a.first,.pages a.prev,.pages a.next,.pages a.end{
                margin:0;
            }
            .pages a:hover{
                border-color:#50A8E6;
            }
            .pages span.current{
                background:#50A8E6;
                color:#FFF;
                font-weight:700;
                border-color:#50A8E6;
            }
        </style>

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">        

            
            

<!--头部-->
<header class="main-header">
    <!-- Logo -->
    <a href="index.html" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><span class="glyphicon glyphicon-home"></span></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><img src="/Public/image/logo.png" class="img-rounded"><b> 维修管理平台</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">切换导航</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages（信息）: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-danger"><?php echo session('newRepairCount');?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 4 messages</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li><!-- start message -->
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="/Public/image/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                        </div>
                                        <h4>
                                            Support Team
                                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <!-- end message -->
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="/Public/image/dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                                        </div>
                                        <h4>
                                            AdminLTE Design Team
                                            <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="/Public/image/dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                                        </div>
                                        <h4>
                                            Developers
                                            <small><i class="fa fa-clock-o"></i> Today</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="/Public/image/dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                                        </div>
                                        <h4>
                                            Sales Department
                                            <small><i class="fa fa-clock-o"></i> Yesterday</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="/Public/image/dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                                        </div>
                                        <h4>
                                            Reviewers
                                            <small><i class="fa fa-clock-o"></i> 2 days</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="#">See All Messages</a></li>
                    </ul>
                </li>               
                <!-- Tasks（任务）: style can be found in dropdown.less -->
                <li class="dropdown tasks-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-spinner"></i>
                        <span class="label label-warning">9</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 9 tasks</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Design some buttons
                                            <small class="pull-right">20%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">20% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <!-- end task item -->
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Create a nice theme
                                            <small class="pull-right">40%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">40% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <!-- end task item -->
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Some task I need to do
                                            <small class="pull-right">60%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">60% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <!-- end task item -->
                                <li><!-- Task item -->
                                    <a href="#">
                                        <h3>
                                            Make beautiful transitions
                                            <small class="pull-right">80%</small>
                                        </h3>
                                        <div class="progress xs">
                                            <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                <span class="sr-only">80% Complete</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <!-- end task item -->
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="#">View all tasks</a>
                        </li>
                    </ul>
                </li>
                <!-- Notifications（提醒）: style can be found in dropdown.less -->
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-success">10</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have 10 notifications</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li>
                                    <a href="#">
                                        <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                                        page and may cause design problems
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-users text-red"></i> 5 new members joined
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-user text-red"></i> You changed your username
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer"><a href="#">View all</a></li>
                    </ul>
                </li>
                <!-- User Account（用户信息）: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="/Public/image/logo.png" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?php echo session('user')['real_name'];?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image（头像） -->
                        <li class="user-header">
                            <img src="/Public/image/logo.png" class="img-circle" alt="User Image">

                            <p>
                                <?php echo session('user')['real_name'];?> - <?php echo session('user')['post'];?>
                                <small>工号：<?php echo session('user')['work_number'];?></small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="row">
                                <div class="col-xs-6 text-center">
                                    <a href="#"><small><?php echo session('company')['company_name'];?></small></a>
                                </div>
                                <div class="col-xs-6 text-center">
                                    <a href="#"><small><?php echo session('department')['department_name'];?></small></a>
                                </div>
                            </div>
                            <!-- /.row -->
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?php echo U('User/info');?>" ><i class="fa fa-drivers-license-o fa-2x"></i></a>
                            </div>
                            <div class="pull-right">
                                <a href="<?php echo U('Login/logout');?>" ><i class="fa fa-power-off fa-2x" style="color: red"></i></a>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<!-- Left side column（左侧导航栏）. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel（左侧用户信息） -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/Public/image/logo.png" class="img-rounded" alt="User Image">
            </div>
            <div class="pull-left info">
                <p class="text-center"><?php echo session('user')['real_name'];?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form（搜索） -->
        <!--        <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="搜索...">
                        <span class="input-group-btn">
                            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>-->
        <!-- /.search form -->
        <!-- sidebar menu（左侧主菜单）: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header"><h6 class="text-center"><big>主菜单</big></h6></li>
            <!--左侧栏首页-->
            <li class="active treeview">
                <a href="<?php echo U('Admin/Index/index'); ?>">
                    <i class="fa fa-th-large"></i> <span>首页</span>
                </a>
            </li>           
            <li class="treeview">
                <a href="<?php echo U('admin/repair/repairList'); ?>">
                    <i class="fa fa-wrench"></i>
                    <span>维护维修</span>
                    <span class="pull-right-container">
                        <small class="label pull-right bg-yellow"><?php echo session('repairingCount');?></small>
                        <small class="label pull-right bg-red"><?php echo session('newRepairCount');?></small>
                    </span>
                </a>
            </li>
            <li class="treeview">
                <a href="index.html">
                    <i class="fa fa-pencil-square-o"></i> 
                    <span>工作计划</span>
                    <span class="pull-right-container">
                        <small class="label pull-right bg-green">1</small>      
                    </span>
                </a>
            </li>
            <li class="treeview">
                <a href="index.html">
                    <i class="fa fa-history"></i> 
                    <span>工作绩效</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>    
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="overview.html">
                            <i class="fa fa-male"></i>个人绩效
                        </a>
                    </li>
                    <li>
                        <a href="overview.html">
                            <i class="fa fa-line-chart"></i>部门绩效
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="index.html">
                    <i class="fa fa-pie-chart"></i> 
                    <span>报表分析</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>    
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="overview.html">
                            <i class="fa fa-area-chart"></i>总体分析
                        </a>
                    </li>
                    <li>
                        <a href="overview.html">
                            <i class="fa fa-bar-chart-o"></i>单项分析
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="<?php echo U('Admin/User/addressBook'); ?>">
                    <i class="fa fa-address-book-o"></i> 
                    <span>通讯录</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-th-list"></i>
                    <span>维修项目管理</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>    
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo U('Admin/Project/projectList'); ?>">
                            <i class="fa fa-flag"></i>项目表
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo U('Admin/Department/departmentList'); ?>">
                            <i class="fa fa-sitemap"></i>设备库
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo U('Admin/Part/partList'); ?>">
                            <i class="fa fa-puzzle-piece"></i>配件库
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-th-list"></i>
                    <span>组织管理</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>    
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo U('Admin/Company/companyList'); ?>">
                            <i class="fa fa-flag"></i>公司划分
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo U('Admin/Department/departmentList'); ?>">
                            <i class="fa fa-sitemap"></i>部门划分
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-puzzle-piece"></i>工作划分(暂时不需要)
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-comments-o"></i> 
                    <span>微信管理</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>    
                    </span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-tablet"></i> 
                    <span>APP管理</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>    
                    </span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-unlock-alt"></i>
                    <span>Admin</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>    
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="<?php echo U('Admin/User/userList');?>">
                            <i class="fa fa-user-circle-o"></i>用户管理
                        </a>
                    </li>
                    <li>
                        <a href="pages/layout/boxed.html">
                            <i class="fa fa-users"></i>组管理
                        </a>
                    </li>
                    <li>
                        <a href="pages/layout/fixed.html">
                            <i class="fa fa-toggle-on"></i>权限管理
                        </a>
                    </li>
                    <li class="">
                        <a href="<?php echo U('Admin/Admin/sysInfo'); ?>">
                            <i class="fa fa-desktop"></i>系统信息
                        </a>
                    </li>
                </ul>
            </li>
        </ul>

    </section>
    <!-- /.sidebar -->
</aside>



<div class="content-wrapper">
    <section class="content-header">
        <h1>
            报修信息
            <small>Report Information</small>
        </h1>
    </section>
    <section class="content">
        <div class="box box-info">
            <div class="box-header bg-info">
                <h3 class="box-title">报修详情</h3>    
                <a type="button" class="btn btn-default pull-right btn-sm" href="<?php echo U('repairList?p='.I('get.p'));?>"><i class="fa fa-reply"> 返回列表</i></a>
            </div>
            <div class="box-body bg-info">
                <div class="row">
                    <div class="col-md-3" style="height: 100px">
                        <h5 class="text-center">维修单号：<?php echo $data['repair_order'];?></h5>
                        <div class="text-center">
                            <?php if($data['repair_status'] == 1):?>
                            <h4 class="text-center label bg-red">新报修</h4>
                            <?php endif;?>
                            <?php if($data['repair_status'] == 2):?>
                            <h4 class="text-center label bg-yellow">维修中</h4>
                            <?php endif;?> 
                            <?php if($data['repair_status'] == 3):?>
                            <h4 class="text-center label bg-blue">已维修</h4>
                            <?php endif;?> 
                            <?php if($data['repair_status'] == 4):?>
                            <h4 class="text-center label bg-green">已办结</h4>
                            <?php endif;?>
                        </div>
                        <div class="text-center">
                            <h5><a type="button" class="btn btn-sm btn-default" href="<?php echo U('detail',array('id'=>I('get.id'),'p'=>I('get.p')));?>">报修详情...</a></h5>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <?php if(in_array($data['repair_status'],array(1,2,3,4))):?>
                        <div class="col-md-2">
                            <i class="fa fa-paper-plane-o fa-2x" style="color: green"></i>
                            <i class="fa fa-angle-double-right" style="color: green"></i>
                            <i class="fa fa-angle-double-right" style="color: green"></i>
                            <i class="fa fa-angle-double-right" style="color: green"></i>
                            <i class="fa fa-angle-double-right" style="color: green"></i>
                            <i class="fa fa-angle-double-right" style="color: green"></i>
                            <i class="fa fa-angle-double-right" style="color: green"></i>
                            <i class="fa fa-angle-double-right" style="color: green"></i>
                            <h5 class="text-green">新报修</h5>
                            <h5 class="text-green"><?php echo $data['report_time'];?></h5>
                        </div>
                        <?php endif;?>
                        <?php if(in_array($data['repair_status'],array(2,3,4))):?>
                        <div class="col-md-2">
                            <i class="fa fa-spinner fa-2x" style="color: green"></i>
                            <i class="fa fa-angle-double-right" style="color: green"></i>
                            <i class="fa fa-angle-double-right" style="color: green"></i>
                            <i class="fa fa-angle-double-right" style="color: green"></i>
                            <i class="fa fa-angle-double-right" style="color: green"></i>
                            <i class="fa fa-angle-double-right" style="color: green"></i>
                            <i class="fa fa-angle-double-right" style="color: green"></i>
                            <i class="fa fa-angle-double-right" style="color: green"></i>
                            <h5 class="text-green">开始维修</h5>
                            <h5 class="text-green"><?php echo $evData[0]['event_time'];?></h5>
                        </div>
                        <?php endif;?>
                        <?php if(in_array($data['repair_status'],array(3,4))):?>
                        <div class="col-md-2">
                            <i class="fa fa-wrench fa-2x" style="color: green"></i>
                            <i class="fa fa-angle-double-right" style="color: green"></i>
                            <i class="fa fa-angle-double-right" style="color: green"></i>
                            <i class="fa fa-angle-double-right" style="color: green"></i>
                            <i class="fa fa-angle-double-right" style="color: green"></i>
                            <i class="fa fa-angle-double-right" style="color: green"></i>
                            <i class="fa fa-angle-double-right" style="color: green"></i>
                            <i class="fa fa-angle-double-right" style="color: green"></i>
                            <h5 class="text-green">已维修</h5>
                            <h5 class="text-green"><?php echo $evData[1]['event_time'];?></h5>
                        </div>
                        <?php endif;?>
                        <?php if(in_array($data['repair_status'],array(4))):?>
                        <div class="col-md-2">
                            <i class="fa fa-check fa-2x" style="color: green"></i>
                            <h5 class="text-green">已办结</h5>
                            <h5 class="text-green"><?php echo $evData[2]['event_time'];?></h5>
                        </div>
                        <?php endif;?>
                        <?php if(in_array($data['repair_status'],array(1,2,3))):?>
                        <div class="col-md-1 ">
                            <a class="btn btn-sm btn-default" href="<?php echo U($data['next'],array('repair_id'=>I('get.id'),'project_id'=>$data['project_id'],'p'=>I('get.p')));?>"><i class="fa fa-arrow-circle-down"></i> 下 一 步 </a>
                        </div>
                        <?php endif;?>
                    </div>
                </div>
                <div style="height: 20px"></div>

                <!--时间轴开始-->
                <div class="row">
                    <div class="col-md-12">
                        <!-- The time line -->
                        <ul class="timeline">

                            <!-- 报送信息 -->
                            <!-- 时间轴标签 -->
                            <li class="time-label">
                                <span class="bg-red">
                                    <?php echo $data['report_time']?>
                                </span>
                            </li>
                            <!-- 时间轴内容 -->
                            <li>
                                <i class="fa fa-paper-plane-o bg-red"></i>
                                <div class="timeline-item">
                                    <h3 class="timeline-header"><a href="#"><?php echo $data['real_name']?></a> 报送维修信息</h3>
                                    <div class="timeline-body">
                                        <table>
                                            <tr>
                                                <td>报修人 ： </td>
                                                <td> <?php echo $data['real_name'];?></td>
                                            </tr>
                                            <tr>
                                                <td>报修单位 ：</td>
                                                <td> <?php echo $data['company_name'];?></td>
                                            </tr>
                                            <tr>
                                                <td>联系人 ： </td>
                                                <td> <?php echo $data['contact'];?></td>
                                            </tr>
                                            <tr>
                                                <td>联系电话 ： </td>
                                                <td> <?php echo $data['phone'];?></td>
                                            </tr>
                                            <tr>
                                                <td>维修地址 ： </td>
                                                <td> <?php echo $data['address'];?></td>
                                            </tr>
                                            <tr>
                                                <td>设备编号 ： </td>
                                                <td> <?php echo $data['serial_number'];?></td>
                                            </tr>
                                            <tr>
                                                <td> 故障描述 ： </td>   
                                            </tr>
                                        </table>
                                        <?php echo $data['descr'];?>
                                    </div>
                                </div>
                            </li>

                            <!--接报办理，安排维修人员、预约时间-->
                            <?php if(in_array($data['repair_status'],array(2,3,4))):?>
                            <li class="time-label">
                                <span class="bg-yellow">
                                    <?php echo $evData[0]['event_time']?>
                                </span>
                            </li>
                            <li>
                                <i class="fa fa-spinner bg-yellow"></i>
                                <div class="timeline-item">
                                    <h3 class="timeline-header">
                                        <a href="#"><?php echo $evData[0]['real_name'];?></a> 接报，维修开始 
                                        <?php if($data['repair_status'] == 2):?>
                                        <a class="pull-right" href="<?php echo U('edit_select',array('repair_id'=>I('get.id'),'p'=>I('get.p')));?>"> 修改</a>
                                        <?php endif;?>
                                    </h3>
                                    <div class="timeline-body">
                                        <h5>预约维修时间：</h5>
                                        <?php echo $evData[0]['repair_time'];?>
                                        <h5>预约维修人员：</h5>
                                        <?php foreach($evData[0]['repair_user'] as $k=>$v):?>
                                        <a class="btn btn-default btn-sm" href="#"><?php echo $v['real_name']?></a>
                                        <?php endforeach;?>
                                    </div>
                                </div>
                            </li>
                            <?php endif;?>

                            <!--维修完成，显示维修信息和费用-->
                            <?php if(in_array($data['repair_status'],array(3,4))):?>
                            <li class="time-label">
                                <span class="bg-blue">
                                    <?php echo $evData[1]['event_time']?>
                                </span>
                            </li>
                            <li>
                                <i class="fa fa-wrench bg-blue"></i>
                                <div class="timeline-item">
                                    <h3 class="timeline-header">
                                        <a href="#"><?php echo $evData[1]['real_name'];?></a> 维修完毕 
                                        <?php if($data['repair_status'] == 3):?>
                                        <a class="pull-right" href="<?php echo U('edit_repaired',array('repair_id'=>I('get.id'),'project_id'=>$data['project_id'],'p'=>I('get.p')));?>"> 修改</a>
                                        <?php endif;?>
                                    </h3>
                                    <div class="timeline-body">
                                        <h5>实际维修时间：</h5>
                                        <?php echo $evData[1]['repair_time'];?>
                                        <h5>实际维修人员：</h5>
                                        <?php foreach($evData[1]['repair_user'] as $k=>$v):?>
                                        <a class="btn btn-default btn-sm" href="#"><?php echo $v['real_name']?></a>
                                        <?php endforeach;?>
                                        <h5>费用明细：</h5>
                                        <table border="1" class="text-center">  
                                            <tr>
                                                <td> 收 费 项 </td>
                                                <td> 价 格(元) </td>
                                                <td> 数 量 </td>
                                                <td> 总 价(元)</td>
                                            </tr>
                                            <?php $sum = 0;?>
                                            <?php foreach($fData as $k=>$v):?>
                                            <tr>
                                                <?php if($v['fee_item'] == 0):?>
                                                <td>人工费</td>
                                                <td><?php echo $v['price'];?></td>
                                                <td><?php echo $v['number'];?></td>
                                                <td><?php echo $v['price']*$v['number'];?></td>
                                                <?php else:?>
                                                <td><?php echo $v['part']['part_name'];?></td>
                                                <td><?php echo $v['price'];?></td>
                                                <td> <?php echo $v['number'];?></td>
                                                <td> <?php echo $v['price']*$v['number'];?></td>
                                                <?php endif;?>
                                                <?php $sum += $v['price']*$v['number']?>
                                            </tr>
                                            <?php endforeach;?>
                                        </table>
                                        <h5>总费用：<?php echo $sum;?> 元</h5>
                                    </div>
                                </div>
                            </li>
                            <?php endif;?>


                            <!-- 办结 -->
                            <?php if(in_array($data['repair_status'],array(4))):?>
                            <li class="time-label">
                                <span class="bg-green">
                                    <?php echo $evData[2]['event_time'];?>
                                </span>
                            </li>
                            <li>
                                <i class="fa fa-check bg-green"></i>
                                <div class="timeline-item">
                                    <h3 class="timeline-header">
                                        <a href="#"><?php echo $evData[2]['real_name'];?></a> 维修办结
                                        <?php if($data['repair_status'] == 4):?>
                                        <a class="pull-right" href="<?php echo U('edit_end',array('repair_id'=>I('get.id'),'p'=>I('get.p')));?>"> 修改</a>
                                        <?php endif;?>
                                    </h3>

                                    <div class="timeline-body">
                                        <h5>办结说明：</h5>
                                        <?php echo $evData[2]['descr'];?>
                                    </div>
                                </div>
                            </li>
                            <?php endif;?>

                            <!-- END timeline item -->
                            <li>
                                <i class="fa fa-clock-o bg-gray"></i>
                            </li>
                        </ul>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
        </div>
    </section>
</div>


<div class="wrapper"></div>
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 0.0.1
            </div>
            <strong>Copyright &copy; 2016-2017 <a href="#">lishen</a>.</strong> All rights reserved.
        </footer>

        <!-- Control Sidebar（控制侧边栏） -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Create the tabs -->
            <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <!-- Home tab content -->
                <div class="tab-pane" id="control-sidebar-home-tab">
                    <h3 class="control-sidebar-heading">最近活动</h3>
                    <ul class="control-sidebar-menu">
                        <li>
                            <a href="javascript:void(0)">
                                <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                                    <p>Will be 23 on April 24th</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <i class="menu-icon fa fa-user bg-yellow"></i>

                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                                    <p>New phone +1(800)555-1234</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                                    <p>nora@example.com</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <i class="menu-icon fa fa-file-code-o bg-green"></i>

                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                                    <p>Execution time 5 seconds</p>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- /.control-sidebar-menu -->

                    <h3 class="control-sidebar-heading">任务进程</h3>
                    <ul class="control-sidebar-menu">
                        <li>
                            <a href="javascript:void(0)">
                                <h4 class="control-sidebar-subheading">
                                    Custom Template Design
                                    <span class="label label-danger pull-right">70%</span>
                                </h4>

                                <div class="progress progress-xxs">
                                    <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <h4 class="control-sidebar-subheading">
                                    Update Resume
                                    <span class="label label-success pull-right">95%</span>
                                </h4>

                                <div class="progress progress-xxs">
                                    <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <h4 class="control-sidebar-subheading">
                                    Laravel Integration
                                    <span class="label label-warning pull-right">50%</span>
                                </h4>

                                <div class="progress progress-xxs">
                                    <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <h4 class="control-sidebar-subheading">
                                    Back End Framework
                                    <span class="label label-primary pull-right">68%</span>
                                </h4>

                                <div class="progress progress-xxs">
                                    <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Stats tab content -->
                <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
                <!-- /.tab-pane -->
            </div>
        </aside>
        <!-- /.control-sidebar -->
        <!-- Add the sidebar's background. This div must be placed
             immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
    <!-- ./wrapper -->


        </div>
    </body>
</html>