<?php
global $config, $link;
$username = "";
$adminname = "";
$sesuserpic = "";
if(isset($_SESSION['admin']['id'])){
    $info = ORM::for_table($config['db']['pre'].'admins')->find_one($_SESSION['admin']['id']);
    $getcount = ORM::for_table($config['db']['pre'].'admins')
    ->where('id',$_SESSION['admin']['id'])
    ->count();
    if($getcount > 0){
        $username = $info['username'];
        $adminname = $info['name'];
        $sesuserpic = $info['image'];
    }
    if($sesuserpic == "")
        $sesuserpic = "default_user.png";
}

?>

<!DOCTYPE html>

<html class="app-ui">

<head>
    <!-- Meta -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

    <!-- Document title -->
    <title><?php echo $config['site_title'] ?> - Admin Panel</title>

    <meta name="description" content="<?php echo $config['site_title'] ?> - Admin Dashboard" />
    <meta name="author" content="Bylancer" />
    <meta name="robots" content="noindex, nofollow" />

    <!-- Favicons -->
    <link rel="icon" type="image/png" sizes="16x16"
        href="<?php echo $config['site_url'];?>storage/logo/<?php echo $config['site_favicon']?>">


    <!-- Google fonts -->
    <link rel="stylesheet"
        href="//fonts.googleapis.com/css?family=Roboto:300,400,400italic,500,900%7CRoboto+Slab:300,400%7CRoboto+Mono:400" />

    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="<?php echo ADMINURL; ?>assets/js/plugins/slick/slick.min.css" />
    <link rel="stylesheet" href="<?php echo ADMINURL; ?>assets/js/plugins/slick/slick-theme.min.css" />
    <!-- css select2 -->
    <link rel="stylesheet" href="<?php echo ADMINURL; ?>assets/js/plugins/select2/select2.min.css" />
    <link rel="stylesheet" href="<?php echo ADMINURL; ?>assets/js/plugins/select2/select2-bootstrap.css" />
    <!-- Zeunix CSS stylesheets -->
    <link rel="stylesheet" id="css-font-awesome" href="<?php echo ADMINURL; ?>assets/css/font-awesome.css" />
    <link rel="stylesheet" id="css-ionicons" href="<?php echo ADMINURL; ?>assets/css/ionicons.css" />
    <link rel="stylesheet" id="css-bootstrap" href="<?php echo ADMINURL; ?>assets/css/bootstrap.css" />
    <link rel="stylesheet" id="css-app" href="<?php echo ADMINURL; ?>assets/css/app.css?1" />
    <link rel="stylesheet" id="css-app-custom" href="<?php echo ADMINURL; ?>assets/css/app-custom.css" />
    <link rel="stylesheet" id="css-app-animation" href="<?php echo ADMINURL; ?>assets/css/animation.css" />
    <!-- End Stylesheets -->
    <link rel="stylesheet" href="<?php echo ADMINURL; ?>assets/css/category.css?1" />

    <link rel="stylesheet" href="<?php echo ADMINURL; ?>assets/js/plugins/asscrollable/asScrollable.min.css">
    <link rel="stylesheet" href="<?php echo ADMINURL; ?>assets/js/plugins/slidepanel/slidePanel.min.css">
    <link rel="stylesheet" href="<?php echo ADMINURL; ?>assets/js/plugins/datatables/jquery.dataTables.min.css" />

    <!--alerts CSS -->
    <link href="<?php echo ADMINURL; ?>assets/js/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <link href="<?php echo ADMINURL; ?>assets/js/plugins/alertify/alertify.min.css" rel="stylesheet" type="text/css">
    <script>
    var ajaxurl = '<?php echo ADMINURL."admin_ajax.php" ?>';
    var sidepanel_ajaxurl = '<?php echo ADMINURL."ajax_sidepanel.php"; ?>';
    </script>
    <?php
    if(!empty($config['quickad_secret_file'])){
        ?>
    <script>
    var ajaxurl = '<?php echo ADMINURL.$config['quickad_secret_file'].'.php'; ?>';
    </script>
    <?php
    }
    ?>

</head>

<body class="app-ui layout-has-drawer layout-has-fixed-header">

    <div class="app-layout-canvas">
        <div class="app-layout-container">

            <!-- Drawer -->
            <aside class="app-layout-drawer">
                <!-- Drawer scroll area -->
                <div class="app-layout-drawer-scroll">
                    <!-- Drawer logo -->
                    <div id="logo" class="drawer-header">
                        <a href="<?php echo ADMINURL; ?>index.php">
                            <img class="img-responsive"
                                src="<?php echo $config['site_url'];?>storage/logo/<?php echo $config['site_admin_logo']?>"
                                title="admin" alt="admin" /></a>
                    </div>

                    <!-- Drawer navigation -->
                    <nav class="drawer-main">
                        <ul class="nav nav-drawer">
                            <li class="nav-item nav-drawer-header">Dashboard</li>

                            <li class="nav-item">
                                <a href="<?php echo ADMINURL; ?>index.php"><i class="ion-ios-speedometer-outline"></i>
                                    Bảng Điều Khiển</a>
                            </li>
                            <li class="nav-item nav-drawer-header">Quản Lý Dự Án</li>
                            <li class="nav-item nav-item-has-subnav">
                                <a href="#"><i class="ion-briefcase"></i> Dự Án</a>
                                <ul class="nav nav-subnav">
                                    <li><a href="<?php echo ADMINURL; ?>app/projects.php?status=open">Đang Mở</a></li>
                                    <li><a href="<?php echo ADMINURL; ?>app/projects.php?status=under_development">Đang
                                            Tiến Hành</a></li>
                                    <li><a href="<?php echo ADMINURL; ?>app/projects.php?status=completed">Hoàn
                                            Thành</a></li>
                                    <li><a href="<?php echo ADMINURL; ?>app/projects.php?status=close">Đóng</a></li>
                                    <li><a href="<?php echo ADMINURL; ?>app/projects.php">Tất Cả Dự Án</a></li>
                                </ul>
                            </li>
                            <li class="nav-item nav-drawer-header">Quản Lý Việc Làm</li>
                            <li class="nav-item nav-item-has-subnav">
                                <a href="#"><i class="ion-briefcase"></i> Việc Làm</a>
                                <ul class="nav nav-subnav">
                                    <li><a href="<?php echo ADMINURL; ?>app/post_active.php">Đang Tuyển</a></li>
                                    <li><a href="<?php echo ADMINURL; ?>app/post_pending.php">Chờ Xử Lý</a></li>
                                    <li><a href="<?php echo ADMINURL; ?>app/post_hidden.php">Bị Ẩn</a></li>
                                    <li><a href="<?php echo ADMINURL; ?>app/post_resubmit.php">Gửi Lại</a></li>
                                    <li><a href="<?php echo ADMINURL; ?>app/post_expire.php">Hết Hạn</a></li>
                                    <li><a href="<?php echo ADMINURL; ?>app/posts.php">Tất Cả Việc Làm</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo ADMINURL; ?>app/companies.php"><i class="fa fa-bank"></i> Công
                                    Ty</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo ADMINURL; ?>app/post-types.php"><i class="fa fa-suitcase"></i> Loại
                                    Việc Làm</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo ADMINURL; ?>app/salary-types.php"><i class="fa fa-dollar"></i> Loại
                                    Lương</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo ADMINURL; ?>app/resumes.php"><i class="fa fa-paperclip"></i> Sơ Yếu
                                    Lí Lịch</a>
                            </li>
                            <li class="nav-item nav-drawer-header">Quản Lý</li>
                            <li class="nav-item">
                                <a href="<?php echo ADMINURL; ?>app/category.php"><i class="ion-ios-list-outline"></i>
                                    Danh Mục</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a href="<?php echo ADMINURL; ?>app/custom_field.php"><i
                                        class="ion-android-options"></i> Custom Fields</a>
                            </li> -->
                            <li class="nav-item nav-item-has-subnav">
                                <a href="#"><i class="ion-bag"></i> Gói Thành Viên</a>
                                <ul class="nav nav-subnav">
                                    <li><a href="<?php echo ADMINURL; ?>global/membership_plan.php">Các Gói</a></li>
                                    <li class="hidden"><a
                                            href="<?php echo ADMINURL; ?>global/membership_package.php">Package</a></li>
                                    <li><a href="<?php echo ADMINURL; ?>global/upgrades.php">Nâng Cấp</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo ADMINURL; ?>global/transactions.php"><i
                                        class="ion-arrow-graph-up-right"></i> Giao Dịch</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo ADMINURL; ?>app/withdrawal.php"><i class="fa fa-bank"></i> Yêu Cầu
                                    Rút Tiền</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo ADMINURL; ?>global/email-template.php"><i class="ion-ios-email"></i>
                                    Mẫu Email </a>
                            </li>

                            <li class="nav-item nav-drawer-header">Nội Dung</li>
                            <li class="nav-item nav-item-has-subnav">
                                <a href="#"><i class="ion-ios-paper-outline"></i> Blog </a>
                                <ul class="nav nav-subnav">
                                    <li><a href="<?php echo ADMINURL; ?>global/blog.php">Tất Cả Blog</a></li>
                                    <li><a href="<?php echo ADMINURL; ?>global/blog-new.php">Thêm Mới</a></li>
                                    <li><a href="<?php echo ADMINURL; ?>global/blog-cat.php">Danh Mục</a></li>
                                    <li><a href="<?php echo ADMINURL; ?>global/blog-comments.php">Bình Luận</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo ADMINURL; ?>global/testimonials.php"><i class="ion-document"></i>
                                    Nhận Xét Từ Khách Hàng </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo ADMINURL; ?>global/faq_entries.php"><i class="ion-clipboard"></i>
                                    FAQ</a>
                            </li>
                            <li class="nav-item nav-drawer-header">Tài Khoản</li>
                            <li class="nav-item">
                                <a href="<?php echo ADMINURL; ?>global/users.php"><i class="ion-ios-people"></i> Người
                                    Dùng</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo ADMINURL; ?>global/admins.php"><i class="ion-android-contact"></i>
                                    Quản Trị Viên</a>
                            </li>
                            <li class="nav-item nav-item-has-subnav">
                                <a href="#"><i class="fa fa-weixin"></i> Trò Chuyện </a>
                                <ul class="nav nav-subnav">
                                    <li><a href="<?php echo ADMINURL; ?>app/chating.php">Tin Nhắn</a></li>
                                </ul>
                            </li>
                            <li class="nav-item nav-drawer-header">Cài Đặt</li>
                            <li class="nav-item">
                                <a href="http://localhost/jobs/admin/global/setting.php"><i
                                        class="ion-android-settings"></i> Cài Đặt</a>

                            </li>
                            <li class="nav-item">
                                <a href="<?php echo ADMINURL; ?>app/advertise.php"><i
                                        class="ion-ios-monitor-outline"></i> Banner Quảng Cáo</a>
                            </li>
                            <li class="nav-item">
                                <a href="logout.php"><i class="ion-ios-people-outline"></i> Đăng Xuất</a>
                            </li>
                        </ul>
                    </nav>
                    <!-- End drawer navigation -->

                    <div class="drawer-footer">
                        <p class="copyright"><a href="" target="_blank">Hoang V. K63 HEDSPI</a> &copy;</p>
                    </div>
                </div>
                <!-- End drawer scroll area -->
            </aside>
            <!-- End drawer -->

            <!-- Header -->
            <header class="app-layout-header">
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target="#header-navbar-collapse" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <button class="pull-left hidden-lg hidden-md navbar-toggle" type="button"
                                data-toggle="layout" data-action="sidebar_toggle">
                                <span class="sr-only">Toggle drawer</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="collapse navbar-collapse" id="header-navbar-collapse">

                            <!-- .navbar-left -->

                            <ul class="nav navbar-nav navbar-right navbar-toolbar hidden-sm hidden-xs">

                                <li>
                                    <!-- Opens the modal found at the bottom of the page -->
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#apps-modal"><i
                                            class="ion-grid"></i></a>
                                </li>
                                <li class="dropdown dropdown-profile">
                                    <a href="#" data-toggle="dropdown">
                                        <span class="m-r-sm"><?php echo $adminname;?> <span class="caret"></span></span>
                                        <img class="img-avatar img-avatar-48"
                                            src="<?php echo $config['site_url'];?>storage/profile/<?php echo $sesuserpic;?>"
                                            alt="<?php echo $adminname;?>" />
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="<?php echo ADMINURL; ?>logout.php">Đăng Xuất</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <!-- .navbar-right -->
                        </div>
                    </div>
                    <!-- .container-fluid -->
                </nav>
                <!-- .navbar-default -->
            </header>
            <!-- End header -->