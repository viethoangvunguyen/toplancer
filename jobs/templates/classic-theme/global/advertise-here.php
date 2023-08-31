<?php overall_header(__('Advertise here')); ?>

<div id="titlebar">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2><?php _e("Advertise with us") ?></h2>
                <!-- Breadcrumbs -->
                <nav id="breadcrumbs" class="dark">
                    <ul>
                        <li><a href="<?php url("INDEX") ?>"><?php _e("Home") ?></a></li>
                        <li><?php _e("Advertise with us") ?></li>
                    </ul>
                </nav>

            </div>
        </div>
    </div>
</div>
<div class="container margin-bottom-50">
    <?php if (isset($_GET['success'])) {
    if ($_GET['success'] == "true") {
        global $config;
    ?>
    <script>
    // Tự động chuyển hướng sau 5 giây
    setTimeout(function() {
        window.location.href =
            "<?php echo $config['site_url'].'manage-banner';?>"; // Thay đổi URL theo nhu cầu của bạn
    }, 5000); // 5000 milliseconds = 5 giây
    </script>
    <style>
    .row {
        display: none !important;
    }
    </style>
    <div class="payment-confirmation-page dashboard-box margin-top-0 padding-top-0 margin-bottom-50">
        <div class="headline">
            <h3><?php _e("Success") ?></h3>
        </div>
        <div class="content with-padding padding-bottom-10">
            <i class="la la-check-circle"></i>

            <h2 class="margin-top-30"><?php _e("Success") ?></h2>

            <p><?php _e("Your banner successfully uploaded. Please wait for approval. Thanks") ?></p>
        </div>
    </div>
    <?php }} ?>
    <?php if($types != null) {?>
    <div class="row">
        <div class="col-sm-12">
            <div class="found-section section">
                <?php if($is_login){ ?>
                <div id="contact" class="ubm_container">
                    <div name="ubm" class="ubm_box" id="ubm" style="max-width: 100%;">
                        <form name="banner_form" id="post_job_form"
                            action="<?php url("advertise-here") ?>?action=post_banner" method="post"
                            onsubmit="return validateForm()" enctype="multipart/form-data" accept-charset="UTF-8">

                            <div class="dashboard-box margin-top-0">
                                <!-- Headline -->
                                <div class="headline">
                                    <div style="margin-bottom: 10px;">Bạn có muốn quảng bá trang web của bạn? Xuất bản
                                        banner
                                        của bạn trên trang web của chúng tôi. Chỉ cần điền vào mẫu dưới đây và thanh
                                        toán bằng
                                        hệ thống thanh toán. Sau đó, chúng tôi sẽ hiển thị banner của bạn theo số ngày
                                        bạn đã
                                        mua. Bạn có thể mua 10 ngày trở lên.</div>
                                </div>
                                <div class="content with-padding padding-bottom-10">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="submit-field">
                                                <h5>Loại banner *</h5>
                                                <div style="overflow: hidden; height: 100%; margin-bottom: 10px;">
                                                    <div style="width: 100%; float: left;">
                                                        <div style="padding-right: 0px;">
                                                            <select class="ubm_email" name="type" id="ubm_type"
                                                                onchange="ubm_calc();">

                                                                <?php foreach ($types as $type){ ?>
                                                                <?php  echo '<option value="'._esc($type['id'],false).'">'._esc($type['title'],false).'</option>';?>
                                                                <?php } ?>

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="submit-field">
                                                <h5>Tiêu đề banner *</h5>
                                                <input type="text" class="with-border" name="title" required>
                                            </div>
                                            <div class="submit-field">
                                                <h5>Url *</h5>
                                                <em class="ubm_comment" style="background-color: #fff;">Nhập tiêu đề
                                                    banner và url. URL sẽ liên kết với
                                                    banner khi
                                                    người dùng click sẽ đi tới url.</em>
                                                <input type="text" class="with-border" name="url" required>
                                            </div>
                                            <div class="submit-field">
                                                <h5>Tải lên hình ảnh banner của bạn. Bạn có thể sử dụng JPEG, GIF và
                                                    PNG.</h5>
                                                <div class="uploadButton">
                                                    <input class="uploadButton-input" type="file" accept="image/*"
                                                        id="job_image" name="file" />
                                                    <label class="uploadButton-button ripple-effect"
                                                        for="job_image"><?php _e("Upload Image") ?></label>
                                                    <span
                                                        class="uploadButton-file-name"><?php _e("Use 200x200px size for better view.") ?></span>
                                                </div>
                                            </div>
                                            <div style="overflow: hidden; height: 100%;display:initial;">
                                                <div style="width: 100%; float: left;">
                                                    Số ngày:
                                                    <input style="display:initial;" required="required" class="ubm_qty"
                                                        name="period" id="ubm_period" type="text" value="10"
                                                        title="How many days your banner has to be shown on our website."
                                                        onkeyup="ubm_calc();" onchange="ubm_calc();">
                                                    ngày. Tổng tiền là
                                                    <input style="display:initial;" class="ubm_qty" type="text"
                                                        name="total" id="ubm_total" disabled="disabled" value="200000"
                                                        title="Total price." readonly>
                                                    VND.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="submit" value="1">

                                <?php foreach ($types as $type){ ?>
                                <input type="hidden" id="ubm_type_<?php _esc($type['id']); ?>"
                                    value="<?php _esc($type['price']);?>">
                                <?php } ?>
                                <div style="margin-top: 5px;">Bằng cách click vào nút bên dưới, bạn đã đồng ý với <a
                                        href="#">Điều
                                        kiện &amp;
                                        Điều Khoản</a> của chúng tôi.</div>
                                <input type="submit" class="ubm_submit" id="ubm_submit" value="Gửi"
                                    style="margin-top: 10px;">
                        </form>
                    </div>
                </div>
                <?php }else{ ?>
                <h1 class="margin-bottom-20"><?php _e("Login required") ?></h1>
                <p><?php _e("Login required to access this page.") ?></p>
                <a href="#sign-in-dialog" class="button ripple-effect popup-with-zoom-anim "><?php _e("Click Here") ?>
                </a>
                <?php } ?>

            </div>
        </div>
    </div>
    <?php } else {?>
    <script>
    alert("Hết slots quảng cáo vui lòng quay lại sau.");
    </script>
    <?php } ?>
</div>
</div>
<script>
function validateForm() {
    let days = document.forms["banner_form"]["period"].value;
    var total = document.forms["banner_form"]["total"].value;
    var file = document.forms["banner_form"]["file"].value;
    var url = document.forms["banner_form"]["url"].value;
    var title = document.forms["banner_form"]["title"].value;
    <?php $balance =  $userdata['balance'];?>
    if (file == "") {
        alert("Bạn chưa tải lên hình ảnh banner.");
        return false;
    }
    if (url == "") {
        alert("Bạn chưa nhập url.");
        return false;
    } else if (!isValidURL(url)) {
        alert("Url chưa hợp lệ.");
        return false;
    }
    if (title == "") {
        alert("Bạn nhập tiêu đề.");
        return false;
    }
    if (days == "") {
        alert("Số ngày chưa đúng định dạng.");
        return false;
    } else if (days < 10) {
        alert("Số ngày phải lớn hơn hoặc bằng 10");
        return false;
    } else if (days < 10) {
        alert("Số ngày phải nhỏ hơn 365.");
        return false;
    } else if (<?php echo $balance?> >= total) {
        return true;
    } else {
        alert("Số dư trong ví nhỏ hơn số tiền bạn cần chuyển. Vui lòng nạp thêm.");
        return false;
    }
}

function isValidURL(url) {
    const pattern = /^(ftp|http|https):\/\/[^ "]+$/;
    return pattern.test(url);
}
</script>
<?php
overall_footer();
?>