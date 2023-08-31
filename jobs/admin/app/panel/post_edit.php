<?php
define("ROOTPATH", dirname(dirname(dirname(__DIR__))));
define("APPPATH", ROOTPATH."/php/");
require_once ROOTPATH . '/includes/autoload.php';
require_once ROOTPATH . '/includes/lang/lang_'.$config['lang'].'.php';
admin_session_start();
$pdo = ORM::get_db();

$info = ORM::for_table($config['db']['pre'].'product')->find_one($_GET['id']);

$item_id = $info['id'];
$status = $info['status'];
$item_title = $info['product_name'];
$item_description = nl2br(stripcslashes($info['description']));

$item_featured = $info['featured'];
$item_urgent = $info['urgent'];
$item_highlight = $info['highlight'];
$item_city = $info['city'];
$item_state = $info['state'];
$item_country = $info['country'];

$item_catid = $info['category'];
$item_subcatid = $info['sub_category'];
$get_main = get_maincat_by_id($info['category']);
$get_sub = get_subcat_by_id($info['sub_category']);
$item_category = $get_main['cat_name'];
$item_sub_category = $get_sub['sub_cat_name'];

$item_start_date = date('d/m/Y', strtotime($info['created_at']));
$expire_date_timestamp = $info['expire_date'];
$expire_date = date('d/m/Y', $expire_date_timestamp);
$item_expire_date = $expire_date;

?>
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="../assets/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css" />

<header class="slidePanel-header overlay">
    <div class="overlay-panel overlay-background vertical-align">
        <div class="service-heading">
            <h2>Chỉnh sửa - <?php echo $item_title; ?></h2>
        </div>
        <div class="slidePanel-actions">
            <div class="btn-group-flat">
                <button type="button"
                    class="btn btn-floating btn-warning btn-sm waves-effect waves-float waves-light margin-right-10"
                    id="post_sidePanel_data"><i class="icon ion-android-done" aria-hidden="true"></i></button>
                <button type="button"
                    class="btn btn-pure btn-inverse slidePanel-close icon ion-android-close font-size-20"
                    aria-hidden="true"></button>
            </div>
        </div>
    </div>
</header>
<div class="slidePanel-inner">
    <div class="panel-body">
        <!-- /.row -->
        <div class="row">
            <div class="col-sm-12">

                <div class="white-box">
                    <div id="post_error"></div>
                    <form name="form2" class="form form-horizontal" method="post" data-ajax-action="postEdit"
                        id="sidePanel_form">
                        <div class="form-body">
                            <input type="hidden" name="id" value="<?php echo $item_id ?>">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Trạng thái</label>
                                <div class="col-sm-9">
                                    <select name="status" class="form-control">
                                        <option value="active" <?php if($status == 'active') echo "selected"; ?>>Đang
                                            tuyển</option>
                                        <option value="pending" <?php if($status == 'pending') echo "selected"; ?>>Chờ
                                            phê duyệt</option>
                                        <option value="expire" <?php if($status == 'expire') echo "selected"; ?>>Hết hạn
                                        </option>
                                        <option value="rejected" <?php if($status == 'rejected') echo "selected"; ?>>Từ
                                            chối</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Danh mục</label>
                                <div class="col-sm-9">
                                    <select name="category" id="category" class="form-control select2"
                                        data-ajax-action="getsubcatbyid">
                                        <option value="">Chọn danh mục...</option>
                                        <?php
                                        $cat =  get_maincategory('default',$item_catid);
                                        foreach($cat as $option){
                                            echo '<option value="'.$option['id'].'" '.$option['selected'].'>'.$option['name'].'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Danh mục con</label>
                                <div class="col-sm-9">
                                    <select name="sub_category" id="sub_category" class="form-control select2">
                                        <option value="">Chọn danh mục con...</option>

                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Tiêu đề:</label>
                                <div class="col-sm-9">
                                    <input name="title" type="text" class="form-control"
                                        value="<?php echo $item_title ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="example-daterange1">Thời hạn:</label>
                                <div class="col-md-9">
                                    <div class="input-daterange input-group" data-date-format="dd/mm/yyyy">
                                        <input class="form-control" type="text" id="example-daterange1"
                                            name="start_date" placeholder="Start Date"
                                            value="<?php echo $item_start_date ?>" autocomplete="off"
                                            placeholder="mm/dd/yyyy">
                                        <span class="input-group-addon"><i class="ion-chevron-right"></i></span>
                                        <input class="form-control" type="text" id="example-daterange2"
                                            name="expire_date" placeholder="Expire Date"
                                            value="<?php echo $item_expire_date ?>" autocomplete="off"
                                            placeholder="mm/dd/yyyy">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Miêu tả:</label>
                                <div class="col-sm-9">
                                    <textarea name="content"
                                        <?php if($config['post_desc_editor'] == 1){ echo 'id="pageContent"'; } ?>
                                        type="text" class="form-control"
                                        rows="6"><?php echo de_sanitize($item_description) ?></textarea>

                                </div>
                            </div>

                            <!-- Select2 -->
                            <!-- Select2 (.js-select2 class is initialized in App() -> uiHelperSelect2()) -->
                            <!-- For more info and examples please check https://github.com/select2/select2 -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Quốc gia</label>
                                <div class="col-sm-9">
                                    <select name="country" class="form-control js-select2" id="country"
                                        data-ajax-action="getStateByCountryID" data-placeholder="Chọn..">
                                        <option></option>
                                        <!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                        <?php $country = get_country_list($item_country);
                                        foreach ($country as $value){
                                            echo '<option value="'.$value['code'].'" '.$value['selected'].'>'.$value['name'].'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Tỉnh</label>
                                <div class="col-sm-9">
                                    <select name="state" id="state" class="form-control js-select2"
                                        data-ajax-action="getCityByStateID" data-placeholder="Chọn..">
                                        <option value="<?php echo $item_state ?>" checked>
                                            <?php echo get_stateName_by_id($item_state) ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">City</label>
                                <div class="col-sm-9">
                                    <select name="city" id="city" class="form-control js-select2"
                                        data-placeholder="Select city..">
                                        <option value="<?php echo $item_city ?>" checked>
                                            <?php echo get_cityName_by_id($item_city) ?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Gói Premium:</label>
                                <div class="col-sm-8" style="margin-left: 10px">
                                    <label class="css-input css-checkbox css-checkbox-primary">
                                        <input type="checkbox" name="featured" value="1"
                                            <?php if($item_featured == '1') echo "checked"; ?>><span></span> Hot trend
                                    </label>
                                    <label class="css-input css-checkbox css-checkbox-primary">
                                        <input type="checkbox" name="urgent" value="1"
                                            <?php if($item_urgent == '1') echo "checked"; ?>><span></span> Khẩn Cấp
                                    </label>
                                    <label class="css-input css-checkbox css-checkbox-primary">
                                        <input type="checkbox" name="highlight" value="1"
                                            <?php if($item_highlight == '1') echo "checked"; ?>><span></span> Top Picks
                                    </label>

                                </div>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
</div>

<script>
$("#category").change(function() {
    var catid = $(this).val();
    var action = $(this).data('ajax-action');
    var data = {
        action: action,
        catid: catid
    };
    $.ajax({
        type: "POST",
        url: ajaxurl + "?action=" + action,
        data: data,
        success: function(result) {
            $("#sub_category").html(result);
        }
    });
});

$("#country").change(function() {
    var id = $(this).val();
    var action = $(this).data('ajax-action');
    var data = {
        action: action,
        id: id
    };
    $.ajax({
        type: "POST",
        url: ajaxurl,
        data: data,
        success: function(result) {
            $("#state").html(result);
            $("#state").select2();
            $("#city").html('');
            $("#city").select2();
        }
    });
});

$("#state").change(function() {
    var id = $(this).val();
    var action = $(this).data('ajax-action');
    var data = {
        action: action,
        id: id
    };
    $.ajax({
        type: "POST",
        url: ajaxurl,
        data: data,
        success: function(result) {
            $("#city").html(result);
            $("#city").select2();
        }
    });
});

jQuery(function($) {
    getsubcat("<?php echo $item_catid; ?>", "getsubcatbyid", "<?php echo $item_subcatid; ?>");
    getcountryToStateSelected("<?php echo $item_country; ?>", "getStateByCountryID",
        "<?php echo $item_state; ?>");
    getCitySelected("<?php echo $item_state; ?>", "getCityByStateID", "<?php echo $item_city; ?>");
});
</script>

<!-- Page JS Code -->


<script src="../assets/js/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script>
$(function() {
    // Init page helpers (BS Datepicker + BS Colorpicker + Select2 + Masked Input + Tags Inputs plugins)
    App.initHelpers(['datepicker', 'select2']);
});
</script>

<?php
if($config['post_desc_editor'] == 1)
{
    ?>
<link media="all" rel="stylesheet" type="text/css" href="../assets/js/plugins/simditor/styles/simditor.css" />
<script src="../assets/js/plugins/simditor/scripts/mobilecheck.js"></script>
<script src="../assets/js/plugins/simditor/scripts/module.js"></script>
<script src="../assets/js/plugins/simditor/scripts/uploader.js"></script>
<script src="../assets/js/plugins/simditor/scripts/hotkeys.js"></script>
<script src="../assets/js/plugins/simditor/scripts/simditor.js"></script>
<script>
(function() {
    $(function() {
        var $preview, editor, mobileToolbar, toolbar, allowedTags;
        Simditor.locale = 'en-US';
        toolbar = ['bold', 'italic', 'underline', 'fontScale', 'ol', 'ul', 'blockquote', 'table', 'link',
            'image'
        ];
        mobileToolbar = ["bold", "italic", "underline", "ul", "ol"];
        if (mobilecheck()) {
            toolbar = mobileToolbar;
        }
        allowedTags = ['br', 'span', 'a', 'img', 'b', 'strong', 'i', 'strike', 'u', 'font', 'p', 'ul', 'ol',
            'li', 'blockquote', 'pre', 'h1', 'h2', 'h3', 'h4', 'hr', 'table'
        ];
        editor = new Simditor({
            textarea: $('#pageContent'),
            placeholder: 'Describe what makes your ad unique...',
            toolbar: toolbar,
            pasteImage: false,
            defaultImage: 'assets/js/plugins/simditor/images/image.png',
            upload: false,
            allowedTags: allowedTags
        });
        $preview = $('#preview');
        if ($preview.length > 0) {
            return editor.on('valuechanged', function(e) {
                return $preview.html(editor.getValue());
            });
        }
    });
}).call(this);
</script>

<?php } ?>


<!-- Page JS Plugins -->