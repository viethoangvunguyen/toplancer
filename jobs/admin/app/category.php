<?php
require_once('../includes.php');
?>

<link href="../assets/js/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet">

<!-- Page Content -->
<main class="app-layout-content">

    <!-- Page Content -->
    <div class="container-fluid p-y-md">
        <!-- Partial Table -->
        <div class="card">
            <div class="card-header">
                <h4>Danh Mục</h4>
            </div>
            <div class="card-block">
                <!-- /row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <div id="quickad-tbs" class="wrap">
                                <div class="quickad-tbs-body">
                                    <div class="row">
                                        <div id="quickad-sidebar" class="col-sm-4">
                                            <div id="quickad-categories-list" class="quickad-nav">
                                                <div class="quickad-nav-item active quickad-category-item quickad-js-all-services">
                                                    <div class="quickad-padding-vertical-xs">Tất Cả Danh Mục</div>
                                                </div>
                                                <ul id="quickad-category-item-list" class="ui-sortable">
                                                    <?php
                                                    $rows = ORM::for_table($config['db']['pre'].'catagory_main')
                                                        ->where('post_type','default')
                                                        ->order_by_asc('cat_order')
                                                        ->find_many();

                                                    foreach ($rows as $row) {
                                                        $catid = $row['cat_id'];
                                                        $catname = $row['cat_name'];
                                                        $caticon = $row['icon'];
                                                        $catslug = $row['slug'];
                                                        ?>
                                                        <li class="quickad-nav-item quickad-category-item" data-category-id="<?php echo $catid; ?>">
                                                            <div class="quickad-flexbox">
                                                                <div class="quickad-flex-cell quickad-vertical-middle" style="width: 1%">
                                                                    <i class="quickad-js-handle quickad-icon quickad-icon-draghandle quickad-margin-right-sm quickad-cursor-move ui-sortable-handle" title="Reorder"></i>

                                                                </div>
                                                                <div class="quickad-flex-cell quickad-vertical-middle">
                                                            <span class="displayed-value" style="display: inline;">
                                                                <i id="quickad-cat-icon" class="quickad-margin-right-sm <?php echo $caticon; ?>"
                                                                   title="<?php echo $catname; ?>"></i> <?php echo $catname; ?>
                                                            </span>
                                                                    <form method="post" id="edit-category-form" style="display: none">
                                                                        <div class="form-field form-required">
                                                                            <label for="quickad-category-name" style="color:#000;">Tiêu Đề</label>
                                                                            <input class="form-control input-lg" id="cat-name" type="text" name="name"
                                                                                   value="<?php echo $catname; ?>">
                                                                        </div>
                                                                        <div class="form-field form-required">
                                                                            <label for="quickad-category-name" style="color:#000;">Class Icon Danh Mục</label>
                                                                            <input class="form-control input-lg" id="cat-icon" type="text" name="icon" placeholder="icon-line-awesome-file-code-o"
                                                                                   value="<?php echo $caticon; ?>">
                                                                        </div>
                                                                        <div class="form-field form-required">
                                                                            <label for="quickad-category-slug" style="color:#000;">Tên Đường Dẫn</label>
                                                                            <input class="form-control input-lg" id="cat-slug" type="text" name="slug"
                                                                                   value="<?php echo $catslug; ?>">
                                                                        </div>
                                                                        <input class="form-control input-lg" id="cat-id" type="hidden" name="id"
                                                                               value="<?php echo $catid; ?>" >
                                                                        <div class="text-right" style="margin-top: 10px;">
                                                                            <button type="submit" class="btn btn-success confirm">Lưu</button>
                                                                            <button type="button" id="cancel-button" class="btn btn-default">Hủy</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                                <div class="quickad-flex-cell quickad-vertical-middle" style="width: 1%;font-size: 18px;">
                                                                    <?php
                                                                    if(get_option("userlangsel") == '1'){
                                                                    ?>
                                                                    <a href="#" class="fa fa-language text-default quickad-margin-horizontal-xs quickad-cat-lang-edit" data-category-id="<?php echo $catid; ?>" data-category-type="main" title="Edit-language"></a>
                                                                    <?php } ?>
                                                                </div>
                                                                <div class="quickad-flex-cell quickad-vertical-middle" style="width: 1%;font-size: 18px;">
                                                                    <a href="#" class="fa fa-pencil-square-o quickad-margin-horizontal-xs quickad-js-edit" title="Edit"></a>
                                                                </div>
                                                                <div class="quickad-flex-cell quickad-vertical-middle" style="width: 1%;font-size: 18px;">
                                                                    <!--<a href="#" class="fa fa-trash-o text-danger quickad-js-delete"
                                                                       title="Delete"></a>-->
                                                                    <button type="button" class="text-danger quickad-js-delete" style="border:none;background:  transparent;"><i class="fa fa-trash-o"></i></button>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    <?php  } ?>
                                                </ul>
                                            </div>

                                            <div class="form-group">
                                                <button id="quickad-new-category" type="button" class="btn btn-lg btn-block btn-success-outline"
                                                        data-original-title="" title=""><i class="dashicons dashicons-plus-alt"></i>Danh Mục Mới
                                                </button>
                                            </div>
                                            <form method="post" id="new-category-form" style="display: none">
                                                <div class="form-group quickad-margin-bottom-md">
                                                    <div class="form-field form-required">
                                                        <label for="quickad-category-name">Tiêu Đề</label>
                                                        <input class="form-control" id="quickad-category-name" type="text" name="name" required=""/>
                                                    </div>
                                                    <div class="form-field form-required">
                                                        <label for="quickad-category-slug">Tên Đường Dẫn</label>
                                                        <input class="form-control" id="quickad-category-slug" type="text" name="slug" required=""/>
                                                    </div>
                                                    <div class="form-field form-required">
                                                        <label for="quickad-category-name">Class Icon Danh Mục</label>
                                                        <input class="form-control" id="quickad-category-icon" type="text" name="icon" placeholder="fa fa-usd" required=""/>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <button type="submit" class="btn btn-success confirm">Lưu</button>
                                                    <button type="button" id="cancel-button" class="btn btn-default">Hủy</button>
                                                </div>
                                            </form>


                                        </div>

                                        <div id="quickad-services-wrapper" class="col-sm-8">
                                            <div class="panel panel-default quickad-main">
                                                <div class="panel-body">
                                                    <h4 class="quickad-block-head">
                                                        <span class="quickad-category-title">Tất Cả Danh Mục</span>
                                                        <button type="button" class="new-subcategory  ladda-button pull-right btn btn-success"
                                                                data-spinner-size="40" data-style="zoom-in">
                                                            <span class="ladda-label"><i class="glyphicon glyphicon-plus"></i>Thêm Danh Mục Con</span>
                                                        </button>
                                                    </h4>
                                                    <form method="post" id="new-subcategory-form" style="display: none">
                                                        <div class="form-group quickad-margin-bottom-md">
                                                            <div class="form-field form-required">
                                                                <label for="new-subcategory-name">Tiêu Đề</label>
                                                                <input class="form-control" id="new-subcategory-name" type="text" name="name" required=""/>
                                                                <input type="hidden" id="cat-id" name="cat_id" value="0">
                                                            </div>
                                                        </div>
                                                        <div class="text-right">
                                                            <button type="submit" class="btn btn-success confirm">Lưu</button>
                                                            <button type="button" id="cancel-button" class="btn btn-default">Hủy</button>
                                                        </div>
                                                    </form>

                                                    <p class="quickad-margin-top-xlg no-result" style="display: none;">No services found. Please add services</p>

                                                    <div class="quickad-margin-top-xlg" id="ab-services-list">
                                                        <div class="panel-group ui-sortable" id="services_list" role="tablist" aria-multiselectable="true">

                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <button type="button" id="quickad-delete" class="btn btn-danger ladda-button"
                                                                data-spinner-size="40" data-style="zoom-in"><span class="ladda-label"><i
                                                                    class="glyphicon glyphicon-trash"></i> Xóa</span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="quickad-alert" class="quickad-alert"></div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.row -->
            </div>
            <!-- .card-block -->
        </div>
        <!-- .card -->
        <!-- End Partial Table -->

    </div>
    <!-- .container-fluid -->
    <!-- End Page Content -->

</main>

<script>
    function editSubCat(id){
        $('.ajax-subcat-edit').addClass('bookme-progress');
        var data = $('#'+id).serialize();
        $.post(ajaxurl+'?action=editSubCat&'+data, function (response) {
            if (response != 0) {
                quickadAlert({success: ['Cập Nhật Thành Công']});
                $('.ajax-subcat-edit').removeClass('bookme-progress');
            } else {
                quickadAlert({error: ['Có vấn đề khi lưu, vui lòng thử lại.']});
                $('.ajax-subcat-edit').removeClass('bookme-progress');
            }
        });
    }
</script>
<?php include("../footer.php"); ?>
<script src="../assets/js/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="../assets/js/category.js?1"></script>
<script src="../assets/js/alert.js"></script>
</body></html>
