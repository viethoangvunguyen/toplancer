<?php
require_once('../includes.php');
?>

<main class="app-layout-content">

    <!-- Page Content -->
    <div class="container-fluid p-y-md">
        <!-- Partial Table -->
        <div class="card">
            <div class="card-header">
                <h4>Cài đặt hệ thống</h4>
            </div>
            <div class="card-block">
                <!-- /row -->
                <div class="row">
                    <div class="col-sm-12">


                        <div id="quickad-tbs" class="wrap">
                            <div class="quickad-tbs-body">

                                <div class="row">
                                    <div id="quickad-sidebar" class="col-sm-4">
                                        <ul class="quickad-nav" role="tablist">
                                            <li class="quickad-nav-item" data-target="#quickad_theme_setting"
                                                data-toggle="tab">Chung</li>
                                            <li class="quickad-nav-item" data-target="#quickad_logo_watermark"
                                                data-toggle="tab">Logo</li>
                                            <li class="quickad-nav-item" data-target="#quick_map" data-toggle="tab">Map
                                            </li>
                                            <li class="quickad-nav-item" data-target="#quickad_billing_details"
                                                data-toggle="tab">Thông Tin Thanh Toán</li>
                                            <li class="quickad-nav-item" data-target="#quickad_email" data-toggle="tab">
                                                Cài Đặt Email</li>
                                            <li class="quickad-nav-item" data-target="#project_setting"
                                                data-toggle="tab">Cài Đặt Dự Án</li>
                                            <li class="quickad-nav-item" data-target="#quickad_recaptcha"
                                                data-toggle="tab">Google reCAPTCHA</li>
                                            <li class="quickad-nav-item" data-target="#quickad_blog" data-toggle="tab">
                                                Cài Đặt Blog</li>
                                            <li class="quickad-nav-item" data-target="#quickad_testimonials"
                                                data-toggle="tab">Nhận Xét Từ Khách Hàng</li>
                                        </ul>
                                    </div>

                                    <div id="quickad_settings_controls" class="col-sm-8">
                                        <div class="panel panel-default quickad-main">
                                            <div class="panel-body">
                                                <div class="tab-content">

                                                    <div class="tab-pane" id="quickad_theme_setting">
                                                        <form method="post"
                                                            action="<?php echo ADMINURL;?>ajax_sidepanel.php?action=SaveSettings"
                                                            id="#quickad_theme_setting">
                                                            <div class="form-group">
                                                                <label class="">Màu chủ đề:</label>
                                                                <div>
                                                                    <input name="theme_color" type="color"
                                                                        class="form-control"
                                                                        value="<?php echo get_option("theme_color"); ?>">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="smtp_auth">Hiện/Ẩn điện thoại/email của
                                                                    người dùng</label>
                                                                <p class="help-block">Số điện thoại / Email chỉ hiển thị
                                                                    khi người dùng đã đăng nhập hoặc hiển thị Công khai.
                                                                </p>
                                                                <select name="contact_validation"
                                                                    id="contact_validation" class="form-control">
                                                                    <option value="1"
                                                                        <?php if(get_option("contact_validation") == '1'){ echo "selected"; } ?>>
                                                                        Hiển thị với người dùng đã đăng nhập</option>
                                                                    <option value="0"
                                                                        <?php if(get_option("contact_validation") == '0'){ echo "selected"; } ?>>
                                                                        Hiển thị công khai</option>
                                                                </select>
                                                            </div>

                                                            <!--Default Horizontal Form-->
                                                            <div class="form-group">
                                                                <label class="">Địa chỉ liên hệ:</label>
                                                                <div>
                                                                    <input name="contact_address" type="text"
                                                                        class="form-control"
                                                                        value="<?php echo get_option("contact_address"); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="">Email liên hệ:</label>
                                                                <div>
                                                                    <input name="contact_email" type="text"
                                                                        class="form-control"
                                                                        value="<?php echo get_option("contact_email"); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="">Số điện thoại liên hế:</label>
                                                                <div>
                                                                    <input name="contact_phone" type="text"
                                                                        class="form-control"
                                                                        value="<?php echo get_option("contact_phone"); ?>">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="">Copyright:</label>
                                                                <div>
                                                                    <input name="copyright_text" type="text"
                                                                        class="form-control"
                                                                        value="<?php echo get_option("copyright_text"); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="">Footer Text:</label>
                                                                <div>
                                                                    <textarea name="footer_text"
                                                                        class="form-control"><?php echo get_option("footer_text"); ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Link Facebook:</label>
                                                                <div>
                                                                    <input name="facebook_link" type="text"
                                                                        class="form-control"
                                                                        value="<?php echo get_option("facebook_link"); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>LInk Twitter:</label>
                                                                <div>
                                                                    <input name="twitter_link" type="text"
                                                                        class="form-control"
                                                                        value="<?php echo get_option("twitter_link"); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Link Instagram:</label>
                                                                <div>
                                                                    <input name="instagram_link" type="text"
                                                                        class="form-control"
                                                                        value="<?php echo get_option("instagram_link"); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Link LinkedIn:</label>
                                                                <div>
                                                                    <input name="linkedin_link" type="text"
                                                                        class="form-control"
                                                                        value="<?php echo get_option("linkedin_link"); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Link Pinterest:</label>
                                                                <div>
                                                                    <input name="pinterest_link" type="text"
                                                                        class="form-control"
                                                                        value="<?php echo get_option("pinterest_link"); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Link Youtube:</label>
                                                                <div>
                                                                    <input name="youtube_link" type="text"
                                                                        class="form-control"
                                                                        value="<?php echo get_option("youtube_link"); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group hidden">
                                                                <div>
                                                                    <textarea name="external_code" type="text"
                                                                        class="form-control"
                                                                        rows="5"><?php echo get_option("external_code"); ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="panel-footer">
                                                                <button name="theme_setting" type="submit"
                                                                    class="btn btn-primary btn-radius save-changes">Lưu</button>
                                                                <button class="btn btn-default" type="reset">Đặt
                                                                    lại</button>
                                                            </div>

                                                        </form>
                                                    </div>

                                                    <div class="tab-pane" id="quickad_logo_watermark">
                                                        <form method="post"
                                                            action="<?php echo ADMINURL;?>ajax_sidepanel.php?action=SaveSettings"
                                                            id="#quickad_logo_watermark" enctype="multipart/form-data">
                                                            <!-- Favicon upload-->
                                                            <div class="form-group">

                                                                <label class="control-label">Favicon
                                                                    Icon<code>*</code></label>
                                                                <div class="screenshot"><img class="redux-option-image"
                                                                        id="favicon_uploader"
                                                                        src="<?php echo $config['site_url'];?>storage/logo/<?php echo $config['site_favicon']?>"
                                                                        alt="" target="_blank" rel="external"
                                                                        style="border: 2px solid #eee;background-color: #000;max-width: 100%">
                                                                </div>
                                                                <input class="form-control input-sm" type="file"
                                                                    name="favicon"
                                                                    onchange="readURL(this,'favicon_uploader')">
                                                                <span class="help-block">Size ảnh phù hợp 16x16px</span>
                                                            </div>

                                                            <!-- Site Logo upload-->
                                                            <div class="form-group">
                                                                <label class="control-label">Logo<code>*</code></label>
                                                                <div class="screenshot"><img class="redux-option-image"
                                                                        id="image_logo_uploader"
                                                                        src="<?php echo $config['site_url'];?>storage/logo/<?php echo $config['site_logo']?>"
                                                                        alt="" target="_blank" rel="external"
                                                                        style="border: 2px solid #eee;background-color: #000;max-width: 100%">
                                                                </div>
                                                                <input class="form-control input-sm" type="file"
                                                                    name="file"
                                                                    onchange="readURL(this,'image_logo_uploader')">
                                                                <span class="help-block">Size ảnh phù hợp
                                                                    170x60px</span>
                                                            </div>
                                                            <!-- Site Logo upload-->
                                                            <div class="form-group">
                                                                <label class="control-label">Footer
                                                                    Logo<code>*</code></label>
                                                                <div class="screenshot"><img class="redux-option-image"
                                                                        id="image_flogo_uploader"
                                                                        src="<?php echo $config['site_url'];?>storage/logo/<?php echo $config['site_logo_footer']?>"
                                                                        alt="" target="_blank" rel="external"
                                                                        style="border: 2px solid #eee;background-color: #000;max-width: 100%">
                                                                </div>
                                                                <input class="form-control input-sm" type="file"
                                                                    name="footer_logo"
                                                                    onchange="readURL(this,'image_flogo_uploader')">
                                                                <span class="help-block">Ảnh hiển thị ở footer</span>
                                                            </div>

                                                            <!-- Home Banner upload-->
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    Banner trang chủ<code>*</code></label>
                                                                <div class="screenshot"><img class="redux-option-image"
                                                                        id="home_banner"
                                                                        src="<?php echo $config['site_url'];?>storage/banner/<?php echo $config['home_banner']?>"
                                                                        alt="" target="_blank" rel="external"
                                                                        width="400px"></div>
                                                                <input class="form-control input-sm" type="file"
                                                                    name="banner"
                                                                    onchange="readURL(this,'home_banner')">
                                                                <span class="help-block">Ảnh hiển thị ở trang chủ</span>
                                                            </div>
                                                            <!-- Home Banner upload-->

                                                            <!-- Admin Logo upload-->
                                                            <div class="form-group">
                                                                <label class="control-label">Admin Logo</label>
                                                                <div class="screenshot"><img class="redux-option-image"
                                                                        id="adminlogo"
                                                                        src="<?php echo $config['site_url'];?>storage/logo/<?php echo $config['site_admin_logo']?>"
                                                                        alt="" target="_blank" rel="external"
                                                                        style="border: 2px solid #eee;background-color: #000;max-width: 100%">
                                                                </div>
                                                                <input class="form-control input-sm" type="file"
                                                                    name="adminlogo"
                                                                    onchange="readURL(this,'adminlogo')">
                                                                <span class="help-block">Size ảnh phù hợp
                                                                    235x62px</span>
                                                            </div>

                                                            <!-- Admin Logo upload-->
                                                            <div class="panel-footer">
                                                                <button name="logo_watermark" type="submit"
                                                                    class="btn btn-primary btn-radius save-changes">Lưu</button>
                                                                <button class="btn btn-default" type="reset">Đặt
                                                                    lại</button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                    <div class="tab-pane" id="quick_map">
                                                        <form method="post"
                                                            action="<?php echo ADMINURL;?>ajax_sidepanel.php?action=SaveSettings"
                                                            id="#quick_map">
                                                            <div class="form-group">
                                                                <label>Hiện địa chỉ :</label>
                                                                <div>
                                                                    <select name="post_address_mode"
                                                                        class="form-control">
                                                                        <option
                                                                            <?php if(get_option("post_address_mode") == '1'){ echo "selected"; } ?>
                                                                            value="1">Cho phép</option>
                                                                        <option
                                                                            <?php if(get_option("post_address_mode") == '0'){ echo "selected"; } ?>
                                                                            value="0">Ẩn</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="map_type">Loại map
                                                                    (Google/OpenStreet)</label>
                                                                <select name="map_type" id="map_type"
                                                                    class="form-control">
                                                                    <option value="google"
                                                                        <?php if(get_option('map_type') == 'google'){ echo "selected"; } ?>>
                                                                        Google Map</option>
                                                                    <option value="openstreet"
                                                                        <?php if(get_option('map_type') == 'openstreet'){ echo "selected"; } ?>>
                                                                        OpenStreet Map</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="gmap_api_key">OpenStreet Access
                                                                    Token</label>
                                                                <input name="openstreet_access_token"
                                                                    class="form-control" type="Text"
                                                                    id="openstreet_access_token"
                                                                    value="<?php echo get_option('openstreet_access_token'); ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="gmap_api_key">Google Map API Key</label>
                                                                <input name="gmap_api_key" class="form-control"
                                                                    type="Text" id="gmap_api_key"
                                                                    value="<?php echo get_option('gmap_api_key'); ?>">
                                                            </div>
                                                            <div class="form-group" style="display: none">
                                                                <label class=""></label>
                                                                <div>
                                                                    <input type="hidden" name="map_color" type="color"
                                                                        class="form-control"
                                                                        value="<?php echo get_option('map_color'); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="">Home Map Latitude:</label>
                                                                <div>
                                                                    <input name="home_map_latitude" type="text"
                                                                        class="form-control"
                                                                        value="<?php echo get_option('home_map_latitude'); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="">Home Map Longitude:</label>
                                                                <div>
                                                                    <input name="home_map_longitude" type="text"
                                                                        class="form-control"
                                                                        value="<?php echo get_option('home_map_longitude'); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="">Contact Map Latitude:</label>
                                                                <div>
                                                                    <input name="contact_latitude" type="text"
                                                                        class="form-control"
                                                                        value="<?php echo get_option('contact_latitude'); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="">Contact Map Longitude:</label>
                                                                <div>
                                                                    <input name="contact_longitude" type="text"
                                                                        class="form-control"
                                                                        value="<?php echo get_option('contact_longitude'); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="panel-footer">
                                                                <button name="quick_map" type="submit"
                                                                    class="btn btn-primary btn-radius save-changes">Save</button>
                                                                <button class="btn btn-default"
                                                                    type="reset">Reset</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="tab-pane" id="quickad_billing_details">
                                                        <form method="post"
                                                            action="<?php echo ADMINURL;?>ajax_sidepanel.php?action=SaveSettings"
                                                            id="#quickad_billing_details">
                                                            <p>Thông tin này sẽ được sử dụng cho hóa đơn.</p>
                                                            <div class="form-group">
                                                                <label class="">Tiền tố số hóa đơn</label>
                                                                <div>
                                                                    <input name="invoice_nr_prefix" type="text"
                                                                        class="form-control"
                                                                        value="<?php echo get_option("invoice_nr_prefix"); ?>"
                                                                        placeholder="Ex: INV-">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="">Tên</label>
                                                                <div>
                                                                    <input name="invoice_admin_name" type="text"
                                                                        class="form-control"
                                                                        value="<?php echo get_option("invoice_admin_name"); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="">Email</label>
                                                                        <div>
                                                                            <input name="invoice_admin_email"
                                                                                type="text" class="form-control"
                                                                                value="<?php echo get_option("invoice_admin_email"); ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="">Điện thoại</label>
                                                                        <div>
                                                                            <input name="invoice_admin_phone"
                                                                                type="text" class="form-control"
                                                                                value="<?php echo get_option("invoice_admin_phone"); ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="">Địa chỉ</label>
                                                                <div>
                                                                    <input name="invoice_admin_address" type="text"
                                                                        class="form-control"
                                                                        value="<?php echo get_option("invoice_admin_address"); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="row" style="display: none">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="">City</label>
                                                                        <div>
                                                                            <input name="invoice_admin_city" type="text"
                                                                                class="form-control"
                                                                                value="<?php echo get_option("invoice_admin_city"); ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="">State/Province</label>
                                                                        <div>
                                                                            <input name="invoice_admin_state"
                                                                                type="text" class="form-control"
                                                                                value="<?php echo get_option("invoice_admin_state"); ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="">ZIP Code</label>
                                                                        <div>
                                                                            <input name="invoice_admin_zipcode"
                                                                                type="text" class="form-control"
                                                                                value="<?php echo get_option("invoice_admin_zipcode"); ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group" style="display: none">
                                                                <label class="">Country</label>
                                                                <div>
                                                                    <select class="form-control"
                                                                        name="invoice_admin_country">
                                                                        <?php
                                                                        $country = get_country_list();
                                                                        foreach ($country as $value){
                                                                            echo '<option value="'.$value['code'].'" '. (($value['code'] == get_option('invoice_admin_country'))? 'selected':'') .'>'.$value['asciiname'].'</option>';
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="">Loại thuế</label>
                                                                        <div>
                                                                            <input name="invoice_admin_tax_type"
                                                                                type="text" class="form-control"
                                                                                value="<?php echo get_option("invoice_admin_tax_type"); ?>"
                                                                                placeholder="Ex: VAT">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="">Mã số thuế</label>
                                                                        <div>
                                                                            <input name="invoice_admin_tax_id"
                                                                                type="text" class="form-control"
                                                                                value="<?php echo get_option("invoice_admin_tax_id"); ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6" style="display: none">
                                                                    <div class="form-group">
                                                                        <label class="">Custom Field Name</label>
                                                                        <div>
                                                                            <input name="invoice_admin_custom_name_1"
                                                                                type="text" class="form-control"
                                                                                value="<?php echo get_option("invoice_admin_custom_name_1"); ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6" style="display: none">
                                                                    <div class="form-group">
                                                                        <label class="">Custom Field Value</label>
                                                                        <div>
                                                                            <input name="invoice_admin_custom_value_1"
                                                                                type="text" class="form-control"
                                                                                value="<?php echo get_option("invoice_admin_custom_value_1"); ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6" style="display: none">
                                                                    <div class="form-group">
                                                                        <label class="">Custom Field Name</label>
                                                                        <div>
                                                                            <input name="invoice_admin_custom_name_2"
                                                                                type="text" class="form-control"
                                                                                value="<?php echo get_option("invoice_admin_custom_name_2"); ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6" style="display: none">
                                                                    <div class="form-group">
                                                                        <label class="">Custom Field Value</label>
                                                                        <div>
                                                                            <input name="invoice_admin_custom_value_2"
                                                                                type="text" class="form-control"
                                                                                value="<?php echo get_option("invoice_admin_custom_value_2"); ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel-footer">
                                                                <button name="billing_details" type="submit"
                                                                    class="btn btn-primary btn-radius save-changes">Lưu</button>
                                                                <button class="btn btn-default" type="reset">Đặt
                                                                    lại</button>
                                                            </div>

                                                        </form>
                                                    </div>

                                                    <div class="tab-pane" id="quickad_email">
                                                        <form method="post"
                                                            action="<?php echo ADMINURL;?>ajax_sidepanel.php?action=SaveSettings"
                                                            id="#quickad_email">

                                                            <div class="form-group">
                                                                <label for="admin_email">Email Quản Trị</label>
                                                                <p class="help-block">Đây là địa chỉ email mà email liên
                                                                    hệ và báo cáo sẽ được gửi đến, cũng như là địa chỉ
                                                                    gửi trong email đăng ký và thông báo.</p>
                                                                <div>
                                                                    <input name="admin_email" class="form-control"
                                                                        type="Text" id="admin_email"
                                                                        value="<?php echo get_option("admin_email");?>">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="email_template">Loại Nội Dung Email </label>
                                                                <p class="help-block">Trình chọn nội dung email văn bản
                                                                    hoặc HTML.</p>
                                                                <div>
                                                                    <select name="email_template" id="email_template"
                                                                        class="form-control">
                                                                        <option
                                                                            <?php if(get_option("email_template") == '0'){ echo "selected"; } ?>
                                                                            value="0">HTML</option>
                                                                        <option
                                                                            <?php if(get_option("email_template") == '1'){ echo "selected"; } ?>
                                                                            value="1">Văn bản</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-group" style="display: none;">
                                                                <label for="email_type">Phương thức gửi email</label>
                                                                <div>
                                                                    <select name="email_type" id="email_type"
                                                                        class="form-control">
                                                                        <option value="smtp"
                                                                            <?php if(get_option("email_type") == 'smtp'){ echo "selected"; } ?>>
                                                                            SMTP</option>
                                                                        <option value="mail"
                                                                            <?php if(get_option("email_type") == 'mail'){ echo "selected"; } ?>>
                                                                            PHPMail</option>
                                                                    </select>
                                                                </div>
                                                            </div>



                                                            <div style="margin-top: 30px;">
                                                                <div class="mailMethod-smtp mailMethods"
                                                                    <?php if($config['email_type'] != 'smtp'){ echo 'style="display: none;"'; } ?>>
                                                                    <h4 class="text-warning">Cài Đặt SMTP</h4>
                                                                    <hr>
                                                                    <div class="form-group">
                                                                        <label for="smtp_host">SMTP Host</label>
                                                                        <div>
                                                                            <input name="smtp_host" type="Text"
                                                                                class="form-control" id="smtp_host"
                                                                                value="<?php echo get_option("smtp_host");?>">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="smtp_host">SMTP Port</label>
                                                                        <input name="smtp_port" type="Text"
                                                                            class="form-control" id="smtp_port"
                                                                            value="<?php echo get_option("smtp_port");?>">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="smtp_username">Tên người dùng
                                                                            SMTP</label>
                                                                        <input name="smtp_username" class="form-control"
                                                                            type="Text" id="smtp_username"
                                                                            value="<?php echo get_option("smtp_username");?>">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="smtp_password">Mật khẩu SMTP</label>
                                                                        <input name="smtp_password" type="password"
                                                                            class="form-control" id="smtp_password"
                                                                            value="<?php echo get_option("smtp_password");?>">
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="smtp_secure">Mã hóa SMTP</label>
                                                                        <select name="smtp_secure" id="smtp_secure"
                                                                            class="form-control">
                                                                            <option value="0"
                                                                                <?php if(get_option("smtp_secure") == '0'){ echo "selected"; } ?>>
                                                                                Không</option>
                                                                            <option value="1"
                                                                                <?php if(get_option("smtp_secure") == '1'){ echo "selected"; } ?>>
                                                                                SSL</option>
                                                                            <option value="2"
                                                                                <?php if(get_option("smtp_secure") == '2'){ echo "selected"; } ?>>
                                                                                TLS</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group" style="display: none;">
                                                                        <select name="smtp_auth" id="smtp_auth"
                                                                            class="form-control">
                                                                            <option value="true"
                                                                                <?php if(get_option("smtp_auth") == 'true'){ echo "selected"; } ?>>
                                                                                On</option>
                                                                            <option value="false"
                                                                                <?php if(get_option("smtp_auth") == 'false'){ echo "selected"; } ?>>
                                                                                Off</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="mailMethod-aws mailMethods"
                                                                    <?php if($config['email_type'] != 'aws'){ echo 'style="display: none;"'; } ?>>
                                                                    <h4 class="text-warning">Amazon SES</h4>
                                                                    <hr>
                                                                    <div class="form-group">
                                                                        <label for="aws_host">AWS Region</label>
                                                                        <input name="aws_host" type="Text"
                                                                            class="form-control" id="aws_host"
                                                                            value="<?php echo get_option("aws_host");?>">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="aws_access_key">AWS SMTP
                                                                            Username</label>
                                                                        <p class="help-block">
                                                                            Note: Your SMTP user name and password are
                                                                            not the same as your AWS access key ID and
                                                                            secret access key. Do not attempt to use
                                                                            your AWS credentials to authenticate
                                                                            yourself against the SMTP endpoint. For more
                                                                            information about credential types, <a
                                                                                href="https://docs.aws.amazon.com/console/ses/using-credentials"
                                                                                target="_blank">click here.</a></p>
                                                                        <input name="aws_access_key"
                                                                            class="form-control" type="Text"
                                                                            id="aws_access_key"
                                                                            value="<?php echo get_option("aws_access_key");?>">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="aws_secret_key">AWS SMTP
                                                                            Password</label>
                                                                        <p class="help-block"></p>
                                                                        <input name="aws_secret_key" type="password"
                                                                            class="form-control" id="aws_secret_key"
                                                                            value="<?php echo get_option("aws_secret_key");?>">
                                                                    </div>

                                                                </div>
                                                                <div class="mailMethod-mandrill mailMethods"
                                                                    <?php if($config['email_type'] != 'mandrill'){ echo 'style="display: none;"'; } ?>>
                                                                    <h4 class="text-warning">Mandrill</h4>
                                                                    <hr>
                                                                    <div class="form-group">
                                                                        <label for="mandrill_user">Mandrill
                                                                            Username</label>
                                                                        <input name="mandrill_user" class="form-control"
                                                                            type="Text" id="mandrill_user"
                                                                            value="<?php echo get_option("mandrill_user");?>">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="mandrill_key">Mandrill API
                                                                            Key</label>
                                                                        <input name="mandrill_key" type="Text"
                                                                            class="form-control" id="mandrill_key"
                                                                            value="<?php echo get_option("mandrill_key");?>">
                                                                    </div>
                                                                </div>
                                                                <div class="mailMethod-sendgrid mailMethods"
                                                                    <?php if($config['email_type'] != 'sendgrid'){ echo 'style="display: none;"'; } ?>>
                                                                    <h4 class="text-warning">SendGrid</h4>
                                                                    <hr>
                                                                    <div class="form-group">
                                                                        <label for="sendgrid_user">SendGrid
                                                                            Username</label>
                                                                        <input name="sendgrid_user" class="form-control"
                                                                            type="Text" id="sendgrid_user"
                                                                            value="<?php echo get_option("sendgrid_user");?>">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="sendgrid_pass">SendGrid
                                                                            Password</label>
                                                                        <input name="sendgrid_pass" type="password"
                                                                            class="form-control" id="sendgrid_pass"
                                                                            value="<?php echo get_option("sendgrid_pass");?>">
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="panel-footer">
                                                                <button name="email_setting" type="submit"
                                                                    class="btn btn-primary btn-radius save-changes">Lưu</button>
                                                                <button class="btn btn-default" type="reset">Đặt
                                                                    lại</button>
                                                            </div>

                                                        </form>
                                                    </div>

                                                    <div class="tab-pane" id="project_setting">
                                                        <form method="post"
                                                            action="<?php echo ADMINURL;?>ajax_sidepanel.php?action=SaveSettings"
                                                            id="#project_setting">
                                                            <div class="form-group">
                                                                <h4>Cài Đặt Dự Án</h4>
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Số Tiền Nạp Tối Thiểu:
                                                                    <?php _esc($config['currency_code']); ?></label>
                                                                <p class="help-block">Đây là số tiền khi người dùng nhỏ
                                                                    nhất nạp vào ví. Số tiền phải cao hơn hoặc bằng số
                                                                    tiền này khi nạp tiền.</p>

                                                                <div>
                                                                    <input name="payment_minimum_deposit" type="number"
                                                                        class="form-control"
                                                                        value="<?php echo get_option("payment_minimum_deposit"); ?>">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Số Tiền Rút Tối Thiểu:
                                                                    <?php _esc($config['currency_code']); ?></label>
                                                                <p class="help-block">Đây là số tiền nhỏ nhất mà người
                                                                    dùng có thể tạo yêu cầu rút tiền. Nếu ví của người
                                                                    dùng thấp hơn số tiền này thì không thể rút.</p>

                                                                <div>
                                                                    <input name="payment_minimum_withdraw" type="number"
                                                                        class="form-control"
                                                                        value="<?php echo get_option("payment_minimum_withdraw"); ?>">
                                                                </div>
                                                            </div>

                                                            <div class="panel-footer">
                                                                <button name="project_setting" type="submit"
                                                                    class="btn btn-primary btn-radius save-changes">Lưu</button>
                                                                <button class="btn btn-default" type="reset">Đặt
                                                                    lại</button>
                                                            </div>

                                                        </form>
                                                    </div>
                                                   
                                                    <div class="tab-pane" id="quickad_recaptcha">
                                                        <form method="post"
                                                            action="<?php echo ADMINURL;?>ajax_sidepanel.php?action=SaveSettings"
                                                            id="#quickad_recaptcha">
                                                            <div class="form-group">
                                                                <h4>Cài đặt Google reCAPTCHA V2</h4>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Bật/ Tắt Xác Thực reCAPTCHA:</label>
                                                                <div>
                                                                    <select name="recaptcha_mode" id="recaptcha_mode"
                                                                        class="form-control">
                                                                        <option
                                                                            <?php if(get_option("recaptcha_mode") == '1'){ echo "selected"; } ?>
                                                                            value="1">Bật</option>
                                                                        <option
                                                                            <?php if(get_option("recaptcha_mode") == '0'){ echo "selected"; } ?>
                                                                            value="0">Tắt</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>reCAPTCHA Public Key:</label>
                                                                <div>
                                                                    <input name="recaptcha_public_key" type="text"
                                                                        class="form-control"
                                                                        value="<?php echo get_option("recaptcha_public_key"); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>reCAPTCHA Private Key:</label>
                                                                <div>
                                                                    <input name="recaptcha_private_key" type="text"
                                                                        class="form-control"
                                                                        value="<?php echo get_option("recaptcha_private_key"); ?>">
                                                                </div>
                                                            </div>

                                                            <div class="panel-footer">
                                                                <button name="recaptcha_setting" type="submit"
                                                                    class="btn btn-primary btn-radius save-changes">Lưu</button>
                                                                <button class="btn btn-default" type="reset">Đặt
                                                                    lại</button>
                                                            </div>

                                                        </form>
                                                    </div>

                                                    <div class="tab-pane" id="quickad_blog">
                                                        <form method="post"
                                                            action="<?php echo ADMINURL;?>ajax_sidepanel.php?action=SaveSettings"
                                                            id="#quickad_blog">
                                                            <div class="form-group">
                                                                <label>Bật/ Tắt Blog:</label>
                                                                <div>
                                                                    <select name="blog_enable" id="blog_enable"
                                                                        class="form-control">
                                                                        <option
                                                                            <?php if(get_option("blog_enable") == '1'){ echo "selected"; } ?>
                                                                            value="1">Bật</option>
                                                                        <option
                                                                            <?php if(get_option("blog_enable") == '0'){ echo "selected"; } ?>
                                                                            value="0">Tắt</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Ảnh Banner:</label>
                                                                <div>
                                                                    <select name="blog_banner" id="blog_banner"
                                                                        class="form-control">
                                                                        <option
                                                                            <?php if(get_option("blog_banner") == '1'){ echo "selected"; } ?>
                                                                            value="1">Hiện</option>
                                                                        <option
                                                                            <?php if(get_option("blog_banner") == '0'){ echo "selected"; } ?>
                                                                            value="0">Ẩn</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Hiện/ Ẩn Blog trên trang chủ:</label>
                                                                <div>
                                                                    <select name="show_blog_home" id="show_blog_home"
                                                                        class="form-control">
                                                                        <option
                                                                            <?php if(get_option("show_blog_home") == '1'){ echo "selected"; } ?>
                                                                            value="1">Hiện</option>
                                                                        <option
                                                                            <?php if(get_option("show_blog_home") == '0'){ echo "selected"; } ?>
                                                                            value="0">Ẩn</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Bật/ Tắt Bình Luận:</label>
                                                                <div>
                                                                    <select name="blog_comment_enable"
                                                                        id="blog_comment_enable" class="form-control">
                                                                        <option
                                                                            <?php if(get_option("blog_comment_enable") == '1'){ echo "selected"; } ?>
                                                                            value="1">Bật</option>
                                                                        <option
                                                                            <?php if(get_option("blog_comment_enable") == '0'){ echo "selected"; } ?>
                                                                            value="0">Tắt</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Phê Duyệt Bình Luận:</label>
                                                                <div>
                                                                    <select name="blog_comment_approval"
                                                                        id="blog_comment_approval" class="form-control">
                                                                        <option
                                                                            <?php if(get_option("blog_comment_approval") == '1'){ echo "selected"; } ?>
                                                                            value="1">Tắt phê duyệt tự động với tất cả
                                                                            bình luận
                                                                        </option>
                                                                        <option
                                                                            <?php if(get_option("blog_comment_approval") == '2'){ echo "selected"; } ?>
                                                                            value="2">Tự động phê duyệt bình luận của
                                                                            người dùng đã đăng nhập
                                                                        </option>
                                                                        <option
                                                                            <?php if(get_option("blog_comment_approval") == '3'){ echo "selected"; } ?>
                                                                            value="3">Tự động phê duyệt tất cả bình luận
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Người Dùng Nhận Xét:</label>
                                                                <p class="help-block">Người dùng không đăng nhập phải
                                                                    nhập tên và địa chỉ email của họ.</p>
                                                                <div>
                                                                    <select name="blog_comment_user"
                                                                        id="blog_comment_user" class="form-control">
                                                                        <option
                                                                            <?php if(get_option("blog_comment_user") == '1'){ echo "selected"; } ?>
                                                                            value="1">Tất cả</option>
                                                                        <option
                                                                            <?php if(get_option("blog_comment_user") == '0'){ echo "selected"; } ?>
                                                                            value="0">Chỉ người dùng đã đăng nhập
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="panel-footer">
                                                                <button name="blog_setting" type="submit"
                                                                    class="btn btn-primary btn-radius save-changes">Lưu</button>
                                                                <button class="btn btn-default" type="reset">Đặt
                                                                    lại</button>
                                                            </div>

                                                        </form>
                                                    </div>

                                                    <div class="tab-pane" id="quickad_testimonials">
                                                        <form method="post"
                                                            action="<?php echo ADMINURL;?>ajax_sidepanel.php?action=SaveSettings"
                                                            id="#quickad_testimonials">
                                                            <div class="form-group">
                                                                <label>Bật/ Tắt Nhận Xét Từ Khách Hàng:</label>
                                                                <div>
                                                                    <select name="testimonials_enable"
                                                                        id="testimonials_enable" class="form-control">
                                                                        <option
                                                                            <?php if(get_option("testimonials_enable") == '1'){ echo "selected"; } ?>
                                                                            value="1">Bật</option>
                                                                        <option
                                                                            <?php if(get_option("testimonials_enable") == '0'){ echo "selected"; } ?>
                                                                            value="0">Tắt</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Hiện Trong Bài Viết Blog:</label>
                                                                <div>
                                                                    <select name="show_testimonials_blog"
                                                                        id="show_testimonials_blog"
                                                                        class="form-control">
                                                                        <option
                                                                            <?php if(get_option("show_testimonials_blog") == '1'){ echo "selected"; } ?>
                                                                            value="1">Hiện</option>
                                                                        <option
                                                                            <?php if(get_option("show_testimonials_blog") == '0'){ echo "selected"; } ?>
                                                                            value="0">Ẩn</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Hiện Trên Trang Chủ:</label>
                                                                <div>
                                                                    <select name="show_testimonials_home"
                                                                        id="show_testimonials_home"
                                                                        class="form-control">
                                                                        <option
                                                                            <?php if(get_option("show_testimonials_home") == '1'){ echo "selected"; } ?>
                                                                            value="1">Hiện</option>
                                                                        <option
                                                                            <?php if(get_option("show_testimonials_home") == '0'){ echo "selected"; } ?>
                                                                            value="0">Ẩn</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="panel-footer">
                                                                <button name="testimonials_setting" type="submit"
                                                                    class="btn btn-primary btn-radius save-changes">Lưu</button>
                                                                <button class="btn btn-default" type="reset">Đặt
                                                                    lại</button>
                                                            </div>

                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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


<?php include("../footer.php"); ?>
<script>
var url = window.location.href;
var activeTab = url.substring(url.indexOf("#") + 1);
if (url.indexOf("#") > -1) {
    if (activeTab.length > 0) {
        $(".quickad-nav-item").removeClass("active");
        $(".tab-pane").removeClass("active in");
        $("li[data-target = #" + activeTab + "]").addClass("active");
        $("#" + activeTab).addClass("active in");
        $('a[href="#' + activeTab + '"]').tab('show')
    }
}
</script>
<script>
$(".save-changes").on('click', function() {
    $(".save-changes").addClass("bookme-progress");
});
// wait for the DOM to be loaded
$(document).ready(function() {
    // bind 'myForm' and provide a simple callback function
    $('form').ajaxForm(function(data) {
        if (data == 0) {
            alertify.error("Unknown Error generated.");
        } else {
            data = JSON.parse(data);
            if (data.status == "success") {
                alertify.success(data.message);
            } else {
                alertify.error(data.message);
            }
        }
        $(".save-changes").removeClass('bookme-progress');
    });

    /* Mail Method Changer */
    $("#email_type").on('change', function() {
        $(".mailMethods").hide();
        $(".mailMethod-" + $(this).val()).fadeIn('fast');
    });
});
</script>
<!-- Page JS Code -->
<script>
$(function() {
    // Init page helpers (BS Datepicker + BS Colorpicker + Select2 + Masked Input + Tags Inputs plugins)
    App.initHelpers('select2');
});
</script>
<script>
var url = document.URL;
var id = url.substring(url.lastIndexOf('#') + 1);
window.addEventListener('popstate', function(event) {
    // Log the state data to the console
    console.log(event.state);
});
</script>
</body>

</html>