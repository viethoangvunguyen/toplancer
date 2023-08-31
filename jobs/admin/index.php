<?php
require_once('includes.php');
check_update_product();

$total_active_item = ORM::for_table($config['db']['pre'].'product')->where('status','active')->count();
$total_pending_item = ORM::for_table($config['db']['pre'].'product')->where('status','pending')->count();
$banned_user = ORM::for_table($config['db']['pre'].'user')->where('status',2)->count();
$total_user = ORM::for_table($config['db']['pre'].'user')->count();

$community_earning = 0;
$rows_1 = ORM::for_table($config['db']['pre'].'transaction')
    ->select_many('amount')
    ->where('transaction_method', 'membership')
    ->where('status','success')
    ->find_many();

foreach ($rows_1 as $fetch){
    $community_earning += $fetch['amount'];
}
$rows_2 = ORM::for_table($config['db']['pre'].'transaction')
    ->select_many('amount')
    ->where('transaction_method', 'project_fee')
    ->where('status','success')
    ->find_many();
foreach ($rows_2 as $fetch){
    $community_earning += $fetch['amount'];
}
$totalearning = $community_earning." ".$config['currency_sign'];

$open_projects = ORM::for_table($config['db']['pre'].'project')->where('status','open')->count();
$completed_projects = ORM::for_table($config['db']['pre'].'project')->where('status','completed')->count();
$freelancers = ORM::for_table($config['db']['pre'].'user')->where('user_type','user')->count();
$employers = ORM::for_table($config['db']['pre'].'user')->where('user_type','employer')->count();
?>

<main class="app-layout-content">

    <!-- Page Content -->
    <div class="container-fluid p-y-md">
        <!-- Stats -->
        <div class="row">
            <div class="col-sm-6 col-lg-3">
                <a class="card" href="app/projects.php?status=open">
                    <div class="card-block clearfix">
                        <div class="pull-right">
                            <p class="h6 text-muted m-t-0 m-b-xs"><?php _e("Open Projects") ?></p>
                            <p class="h3 text-blue m-t-sm m-b-0 float-right"><?php echo $open_projects; ?></p>
                        </div>
                        <div class="pull-left m-r">
                            <span class="img-avatar img-avatar-48 bg-blue bg-inverse"><i
                                    class="ion-ios-bell fa-1-5x"></i></span>
                        </div>
                    </div>
                </a>
            </div>
            <!-- .col-sm-6 -->

            <div class="col-sm-6 col-lg-3">
                <a class="card bg-orange bg-inverse" href="app/projects.php?status=completed">
                    <div class="card-block clearfix">
                        <div class="pull-right">
                            <p class="h6 text-muted m-t-0 m-b-xs"><?php _e("Completed Projects") ?></p>
                            <p class="h3 m-t-sm m-b-0 float-right"><?php echo $completed_projects; ?></p>
                        </div>
                        <div class="pull-left m-r">
                            <span class="img-avatar img-avatar-48 bg-gray-light-o"><i
                                    class="ion-ios-information fa-1-5x"></i></span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3">
                <a class="card bg-red bg-inverse" href="app/post_active.php">
                    <div class="card-block clearfix">
                        <div class="pull-right">
                            <p class="h6 text-muted m-t-0 m-b-xs"><?php _e("Active Jobs") ?></p>
                            <p class="h3 m-t-sm m-b-0 float-right"><?php echo $total_active_item; ?></p>
                        </div>
                        <div class="pull-left m-r">
                            <span class="img-avatar img-avatar-48 bg-gray-light-o"><i
                                    class="ion-briefcase fa-1-5x"></i></span>
                        </div>
                    </div>
                </a>
            </div>
            <!-- .col-sm-6 -->
            <div class="col-sm-6 col-lg-3">
                <a class="card bg-green bg-inverse" href="app/post_pending.php">
                    <div class="card-block clearfix">
                        <div class="pull-right">
                            <p class="h6 text-muted m-t-0 m-b-xs"><?php _e("New Jobs") ?></p>
                            <p class="h3 m-t-sm m-b-0 float-right"><?php echo $total_pending_item; ?></p>
                        </div>
                        <div class="pull-left m-r">
                            <span class="img-avatar img-avatar-48 bg-gray-light-o"><i
                                    class="ion-briefcase fa-1-5x"></i></span>
                        </div>
                    </div>
                </a>
            </div>
            <!-- .col-sm-6 -->
            <div class="col-sm-6 col-lg-3">
                <a class="card bg-purple bg-inverse" href="global/users.php">
                    <div class="card-block clearfix">
                        <div class="pull-right">
                            <p class="h6 text-muted m-t-0 m-b-xs"><?php _e("Total Users") ?></p>
                            <p class="h3 m-t-sm m-b-0 float-right"><?php echo $total_user; ?></p>
                        </div>
                        <div class="pull-left m-r">
                            <span class="img-avatar img-avatar-48 bg-gray-light-o"><i
                                    class="ion-ios-people fa-1-5x"></i></span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-lg-3">
                <a class="card bg-cyan bg-inverse" href="global/users.php?type=freelancer">
                    <div class="card-block clearfix">
                        <div class="pull-right">
                            <p class="h6 text-muted m-t-0 m-b-xs"><?php _e("Freelancers") ?></p>
                            <p class="h3 m-t-sm m-b-0 float-right"><?php echo $freelancers; ?></p>
                        </div>
                        <div class="pull-left m-r">
                            <span class="img-avatar img-avatar-48 bg-gray-light-o"><i
                                    class="ion-ios-people fa-1-5x"></i></span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3">
                <a class="card bg-teal bg-inverse" href="global/users.php?type=employer">
                    <div class="card-block clearfix">
                        <div class="pull-right">
                            <p class="h6 text-muted m-t-0 m-b-xs"><?php _e("Employers") ?></p>
                            <p class="h3 m-t-sm m-b-0 float-right"><?php echo $employers; ?></p>
                        </div>
                        <div class="pull-left m-r">
                            <span class="img-avatar img-avatar-48 bg-gray-light-o"><i
                                    class="ion-ios-people fa-1-5x"></i></span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-sm-6 col-lg-3">
                <a class="card bg-blue bg-inverse" href="#">
                    <div class="card-block clearfix">
                        <div class="pull-right">
                            <p class="h6 text-muted m-t-0 m-b-xs"><?php _e("Total Income") ?></p>
                            <p class="h3 m-t-sm m-b-0 float-right" style="direction: unset;">
                                <?php echo $totalearning; ?></p>
                        </div>
                        <div class="pull-left m-r">
                            <span class="img-avatar img-avatar-48 bg-gray-light-o"><i
                                    class="ion-cash fa-1-5x"></i></span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- .row -->
        <!-- End stats -->

        <div class="row">
            <div class="col-lg-8">
                <!-- Transactions history Widget -->
                <div class="card">
                    <div class="card-header">
                        <h4><?php _e("Posts Statistics") ?></h4>
                    </div>
                    <div class="card-block">
                        <div style="height: 238px;"><canvas class="js-chartjs-lines4"></canvas></div>
                    </div>
                </div>
                <!-- .card -->
                <!-- End Transactions history Widget -->
            </div>
            <!-- .col-lg-8 -->

            <div class="col-lg-4">
                <!-- Weekly users Widget -->
                <div class="card">
                    <div class="card-header">
                        <h4><?php _e("Weekly users") ?> </h4>
                    </div>
                    <div class="card-block">
                        <div style="height: 238px;"><canvas class="js-chartjs-bars3"></canvas></div>
                    </div>
                </div>
                <!-- .card -->
                <!-- End Weekly users Widget -->
            </div>
            <!-- .col-lg-4 -->
        </div>
        <!-- .row -->

        <!-- .row -->
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <h4><?php _e("Recent Jobs") ?></h4>
                    </div>
                    <div class="card-block">
                        <?php
                        $getItem = get_items('','',false,1,5);
                        foreach ($getItem as $ads) {
                            $ad_id          = $ads['id'];
                            $ad_title       = $ads['product_name'];
                            $featured       = $ads['featured'];
                            $urgent         = $ads['urgent'];
                            $highlight      = $ads['highlight'];
                            $ad_category    = $ads['category'];
                            $ad_location    = $ads['location'];
                            $ad_created_at  = $ads['created_at'];
                            $ad_pic         = $ads['image'];
                            $ad_link        = $ads['link'];
                            $pro_employer        = $ads['username'];
                            ?>
                        <div class="pro-list">
                            <div class="pro-img p-r-10">
                                <a href="#">
                                    <img src="../storage/products/<?php echo $ad_pic; ?>" alt="<?php echo $ad_title ?>"
                                        style="width:75px; height: 75px;">
                                </a>
                            </div>
                            <div class="pro-detail">
                                <h5 class="m-t-0 m-b-5">
                                    <a
                                        href="<?php echo $link['POST-DETAIL']; ?>/<?php echo $ad_id;?>"><?php echo $ad_title; ?></a>
                                </h5>
                                <p class="text-muted font-12 m-b-5"><a
                                        href="<?php echo $link['PROFILE']; ?>/<?php echo $pro_employer; ?>"
                                        target="_blank"><?php echo $pro_employer; ?></a> | <i
                                        class="fa fa-map-marker"></i> <?php echo $ad_location; ?> </p>
                                <p class="text-muted font-12"><?php echo $ad_created_at; ?> </p>
                            </div>
                        </div>

                        <?php } ?>

                        <div class="text-right">
                            <a href="app/posts.php" class="btn btn-sm btn-rounded btn-info m-t-10">Xem tất cả</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Dự Án Gần Đây</h4>
                    </div>
                    <div class="card-block">
                        <?php
                        $getItem = get_projects('','',false,1,6);
                        foreach ($getItem as $ads) {
                            $ad_id          = $ads['id'];
                            $ad_title       = $ads['product_name'];
                            $featured       = $ads['featured'];
                            $urgent         = $ads['urgent'];
                            $highlight      = $ads['highlight'];
                            $ad_category    = $ads['category'];
                            $ad_created_at  = $ads['created_at'];
                            $pro_employer        = $ads['username'];
                            $ad_link        = $ads['link'];
                            ?>
                        <div class="pro-list">
                            <div class="pro-detail">
                                <h5 class="m-t-0 m-b-5">
                                    <a href="<?php echo $config['site_url']; ?>project/<?php echo $ad_id;?>"
                                        target="_blank"><?php echo $ad_title; ?></a>
                                </h5>
                                <p class="text-muted font-12"><a
                                        href="<?php echo $link['PROFILE']; ?>/<?php echo $pro_employer; ?>"
                                        target="_blank"><?php echo $pro_employer; ?></a> | <?php echo $ad_created_at; ?>
                                </p>
                            </div>
                        </div>

                        <?php } ?>

                        <div class="text-right">
                            <a href="projects.php" class="btn btn-sm btn-rounded btn-info m-t-10">Xem tất cả</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Đăng Ký Gần Đây </h4>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th>Tên</th>
                                        <th>Loại</th>
                                        <th>Email</th>
                                        <th>Trạng Thái</th>
                                        <th>Ngày Tạo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                $rows = ORM::for_table($config['db']['pre'].'user')
                                    ->order_by_desc('id')
                                    ->limit(10)
                                    ->find_many();

                                foreach ($rows as $info) {
                                    $username = $info['username'];
                                    $status = $info['status'];
                                    $type = $info['user_type'] == 'user' ? 'Freelancer': 'Employer';
                                    if ($status == "0"){
                                        $status = '<span class="label label-info">Chờ Xác Thực</span>';
                                    }
                                    elseif($status == "1")
                                    {
                                        $status = '<span class="label label-success">Đã Xác Thực</span>';
                                    }
                                    else{
                                        $status = '<span class="label label-warning">Khóa</span>';
                                    }
                                    ?>
                                    <tr>
                                        <td class="txt-oflo"><?php echo $info['name']; ?>
                                            <p class="text-muted m-b-0 fs-12"><a
                                                    href="<?php echo $link['PROFILE']; ?>/<?php echo $username; ?>"
                                                    target="_blank">@ <?php echo $username; ?></a></p>
                                        </td>
                                        <td class="txt-oflo"><?php echo $type; ?></td>
                                        <td><span
                                                class="label label-info label-rounded"><?php echo $info['email']; ?></span>
                                        </td>
                                        <td class="txt-oflo"><?php echo $status; ?></td>
                                        <td class="txt-oflo"><?php echo timeAgo($info['created_at']); ?></td>
                                    </tr>
                                    <?php } ?>


                                </tbody>
                            </table>
                            <a href="users.php">Xem thêm</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- .container-fluid -->
    <!-- End Page Content -->

</main>

<?php include("footer.php"); ?>

<!--Code For Chart-->
<!-- Page Plugins -->
<script src="assets/js/plugins/slick/slick.min.js"></script>
<script src="assets/js/plugins/chartjs/Chart.min.js"></script>


<?php
$today = date('Y-m-d');
$todayPost = ORM::for_table($config['db']['pre'].'project')->where_like('created_at', ''.$today.'%')->count();
$todayUser = ORM::for_table($config['db']['pre'].'user')->where_like('created_at', ''.$today.'%')->count();

$minusValue = $today;
$minusValue2 = $today;
$minusValue3 = $today;
$chartPostValue = "'".$todayPost."'";
$chartUserValue = "'".$todayUser."'";
$chartWeeklyLable = "'".date('M-d')."'";
for ($x = 0; $x <= 5; $x++) {
    $minusValue = date('M-d', strtotime('-1 day', strtotime($minusValue)));
    $chartWeeklyLable .= ",'".$minusValue."'";

    $minusValue2 = date('Y-m-d', strtotime('-1 day', strtotime($minusValue2)));
    $rows = ORM::for_table($config['db']['pre'].'product')->where_like('created_at', ''.$minusValue2.'%')->count();
    $chartPostValue .= ",'".$rows."'";

    $minusValue3 = date('Y-m-d', strtotime('-1 day', strtotime($minusValue3)));
    $rows = ORM::for_table($config['db']['pre'].'user')->where_like('created_at', ''.$minusValue3.'%')->count();
    $chartUserValue .= ",'".$rows."'";
}
?>

<script>
// Lines Chart Data 3
var $dashChartLinesData3 = {
    labels: [<?php echo $chartWeeklyLable; ?>],
    datasets: [{
        label: 'This Week',
        fillColor: App.hexToRgba(App.colors.blue, 50),
        pointColor: App.colors.blue,
        data: [<?php echo $chartUserValue; ?>]
    }]
};

// Lines Chart Data 4
var $dashChartLinesData4 = {
    labels: [<?php echo $chartWeeklyLable; ?>],
    datasets: [{
        label: 'This Week',
        strokeColor: App.colors.blue,
        pointColor: '#fff',
        pointStrokeColor: App.colors.blue,
        data: [<?php echo $chartPostValue; ?>]
    }]
};
</script>
<!--Code For Chart-->
<!-- Page JS Code -->
<script src="<?php echo ADMINURL; ?>assets/js/pages/index.js"></script>
<script>
$(function() {
    // Init page helpers (Slick Slider plugin)
    App.initHelpers('slick');
});
</script>

</body>

</html>