<?php
overall_header(__("My Banner"));
?>
 <!-- Google fonts -->
 <link rel="stylesheet"
        href="//fonts.googleapis.com/css?family=Roboto:300,400,400italic,500,900%7CRoboto+Slab:300,400%7CRoboto+Mono:400" />

    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="http://localhost/jobs/admin/assets/js/plugins/slick/slick.min.css" />
    <link rel="stylesheet" href="http://localhost/jobs/admin/assets/js/plugins/slick/slick-theme.min.css" />
    <!-- css select2 -->
    <link rel="stylesheet" href="http://localhost/jobs/admin/assets/js/plugins/select2/select2.min.css" />
    <link rel="stylesheet" href="http://localhost/jobs/admin/assets/js/plugins/select2/select2-bootstrap.css" />
    <!-- Zeunix CSS stylesheets -->
    <link rel="stylesheet" id="css-font-awesome" href="http://localhost/jobs/admin/assets/css/font-awesome.css" />
    <link rel="stylesheet" id="css-ionicons" href="http://localhost/jobs/admin/assets/css/ionicons.css" />
    <link rel="stylesheet" id="css-bootstrap" href="http://localhost/jobs/admin/assets/css/bootstrap.css" />
    <link rel="stylesheet" id="css-app" href="http://localhost/jobs/admin/assets/css/app.css?1" />
    <link rel="stylesheet" id="css-app-custom" href="http://localhost/jobs/admin/assets/css/app-custom.css" />
    <link rel="stylesheet" id="css-app-animation" href="http://localhost/jobs/admin/assets/css/animation.css" />
    <!-- End Stylesheets -->
    <link rel="stylesheet" href="http://localhost/jobs/admin/assets/css/category.css?1" />

    <link rel="stylesheet" href="http://localhost/jobs/admin/assets/js/plugins/asscrollable/asScrollable.min.css">
    <link rel="stylesheet" href="http://localhost/jobs/admin/assets/js/plugins/slidepanel/slidePanel.min.css">
    <link rel="stylesheet" href="http://localhost/jobs/admin/assets/js/plugins/datatables/jquery.dataTables.min.css" />

    <!--alerts CSS -->
    <link href="http://localhost/jobs/admin/assets/js/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <link href="http://localhost/jobs/admin/assets/js/plugins/alertify/alertify.min.css" rel="stylesheet" type="text/css">
<!-- Dashboard Container -->
<div class="dashboard-container">

    <?php include_once TEMPLATE_PATH.'/dashboard_sidebar.php'; ?>


    <!-- Dashboard Content
    ================================================== -->
    <div class="dashboard-content-container" data-simplebar>
        <div class="dashboard-content-inner" >

        <div class="container-fluid p-y-md">
        <!-- Partial Table -->
        <div class="card">
            <div class="card-header">
                <h4>Banner Quảng Cáo</h4>
            </div>
            <div class="card-block">
                <div id="js-table-list">
                    <table id="ajax_datatable" class="js-table-checkable table table-vcenter table-hover" data-tablesaw-mode="stack" data-plugin="animateList" data-animate="fade" data-child="tr" data-selectable="selectable">
                        <thead>
                        <tr>
                            <th>ID:</th>
                            <th>Tiêu đề</th>
                            <th>Số tiền</th>
                            <th>Url</th>
                            <th>Ảnh</th>
                            <th>Số ngày</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1;
                            foreach($banner_ads as $banner) { ?>
                            <tr>
                            <?php 
                              $t_status = $banner['status'];
                              $status = '';
                              if ($t_status == "success") {
                                  $status = '<span class="label label-success">'.__("Thành công").'</span>';
                              } elseif ($t_status == "pending") {
                                  $status = '<span class="label label-warning">'.__("Đang chờ").'</span>';
                              } else{
                                  $status = '<span class="label label-danger">'.__("Từ chối").'</span>';
                              }
                              $image = '<div class="pull-left m-r"><img class="img-avatar img-avatar-48" src="'.$config['site_url'].'storage/banner_advertise/'.$banner['file'].'"></div>';
                            ?>
                            <td><?php echo $count;?></td>
                            <td><?php _esc($banner['title']);?></td>
                            <td><?php _esc($banner['amount']);?></td>
                            <td><?php _esc($banner['url']);?></td>
                            <td><?php _esc($image);?></td>
                            <td><?php _esc($banner['days_purchased']);?></td>
                            <td><?php _esc($status);?></td>
                            <td><?php _esc(Date('H:i:s d/m/Y',$banner['registered']));?></td>
                            </tr>
                            <?php $count++; } ?>
                        </tbody>
                    </table>

                </div>


            </div>
            <!-- .card-block -->
        </div>
        <!-- .card -->
        <!-- End Partial Table -->

    </div>
                </div>
            </div>
            <!-- Row / End -->

            <script>
                $(document).on('change', "#project_status" ,function(e){
                    $('#form_search').submit();
                });
            </script>
            <?php include_once TEMPLATE_PATH.'/overall_footer_dashboard.php'; ?>

