<?php
define("ROOTPATH", dirname(dirname(dirname(__DIR__))));
define("APPPATH", ROOTPATH."/php/");
require_once ROOTPATH . '/includes/autoload.php';
require_once ROOTPATH . '/includes/lang/lang_'.$config['lang'].'.php';
admin_session_start();
$pdo = ORM::get_db();
?>
<header class="slidePanel-header overlay">
    <div class="overlay-panel overlay-background vertical-align">
        <div class="service-heading">
            <h2>Thêm Gói Thành Viên</h2>
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
                    <form name="form2" class="form" method="post" data-ajax-action="addMembershipPlan"
                        id="sidePanel_form">
                        <div class="form-body">
                            <div class="row form-group">
                                <label class="col-sm-4 control-label">Kích Hoạt</label>
                                <div class="col-sm-8">
                                    <label class="css-input switch switch-sm switch-success">
                                        <input name="active" type="checkbox" value="1" checked /><span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-4 control-label">Tên Gói</label>
                                <div class="col-sm-8">
                                    <input name="name" type="Text" class="form-control" placeholder="Tên Gói">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-4 control-label">Huy Hiệu Gói</label>
                                <div class="col-sm-8">
                                    <input name="badge" type="text" class="form-control" placeholder="Url huy hiệu">
                                    <p class="help-block">Url hình ảnh cho Huy hiệu này sẽ hiển thị trong hồ sơ người
                                        dùng sau tên người dùng.</p>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-4 control-label">Giá Tháng</label>
                                <div class="col-sm-8">
                                    <input name="monthly_price" type="number" class="form-control" id="monthly_price"
                                        placeholder="Giá Tháng" value="">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-4 control-label">Giá Năm</label>
                                <div class="col-sm-8">
                                    <input name="annual_price" type="number" class="form-control" id="annual_price"
                                        placeholder="Giá Năm" value="">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-4 control-label">Giá Trọn Đời</label>
                                <div class="col-sm-8">
                                    <input name="lifetime_price" type="number" class="form-control" id="sub_amount"
                                        placeholder="Giá Trọn Đời" value="">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-4 control-label">Khuyến Khích</label>
                                <div class="col-sm-8">
                                    <label class="css-input switch switch-sm switch-success">
                                        <input name="recommended" type="checkbox" value="yes" checked /><span></span>
                                    </label>
                                </div>
                            </div>
                            <h4>Cài Đặt Gói</h4>
                            <hr>
                            <div class="row form-group">
                                <label class="col-sm-4 control-label">Tỷ lệ phần trăm hoa hồng của nhà tuyển
                                    dụng</label>
                                <div class="col-sm-6">
                                    <input name="employer_commission" type="number" class="form-control" value="10">
                                    <p class="help-block">Đây là tỷ lệ phần trăm được khấu trừ từ tài khoản của Nhà
                                        tuyển dụng khi một dự án được chấp nhận. Tỷ lệ phần trăm được tính từ số tiền
                                        giá thầu cuối cùng.</p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-sm-4 control-label">Tỷ lệ phần trăm hoa hồng của Freelancer</label>
                                <div class="col-sm-6">
                                    <input name="freelancer_commission" type="number" class="form-control" value="10">
                                    <p class="help-block">Đây là tỷ lệ phần trăm được khấu trừ từ tài khoản Freelancer
                                        khi một dự án được chấp nhận. Tỷ lệ phần trăm được tính từ số tiền giá thầu cuối
                                        cùng.</p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-sm-4 control-label">Giá thầu cho Freelancer</label>
                                <div class="col-sm-6">
                                    <input name="bids" type="number" class="form-control" value="10">
                                    <p class="help-block">Đây là giới hạn giá thầu cho Freelancer. Không giới hạn nhập
                                        999</p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-sm-4 control-label">Giới hạn kỹ năng</label>
                                <div class="col-sm-6">
                                    <input name="skills" type="number" class="form-control" value="5">
                                    <p class="help-block">Đây là giới hạn về kỹ năng thêm cho Freelancer. Không giới hạn
                                        nhập 999</p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-sm-4 control-label">Giới hạn đăng việc làm (Tối đa Không)</label>
                                <div class="col-sm-6">
                                    <input name="ad_limit" type="number" class="form-control" id="ad_limit"
                                        placeholder="Ad Limit" value="10">
                                    <p class="help-block">Đối với không giới hạn, hãy nhập 999</p>
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-sm-4 control-label">Số ngày hết hạn của việc làm</label>
                                <div class="col-sm-6">
                                    <input name="ad_duration" type="number" class="form-control"
                                        placeholder="Ad Duration" value="7">
                                </div>
                            </div>

                            <div class="row form-group">
                                <label class="col-sm-4 control-label">Phí huy hiệu Hot trend</label>
                                <div class="col-sm-6">
                                    <input name="featured_project_fee" type="number" class="form-control" value="5">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-4 control-label">Thời gian huy hiệu Hot trend</label>
                                <div class="col-sm-6">
                                    <input name="featured_duration" type="Text" class="form-control" value="30">
                                    <p class="help-block">Thời lượng hiển thị Huy hiệu Hot trend (tính bằng ngày).</p>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-4 control-label">Phí huy hiệu khẩn cấp</label>
                                <div class="col-sm-6">
                                    <input name="urgent_project_fee" type="number" class="form-control" value="5">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-4 control-label">Thời gian khẩn cấp</label>
                                <div class="col-sm-6">
                                    <input name="urgent_duration" type="Text" class="form-control" value="30">
                                    <p class="help-block">Thời lượng hiển thị Huy hiệu Khẩn cấp (tính bằng ngày).</p>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-4 control-label">Phí huy hiệu Top Picks</label>
                                <div class="col-sm-6">
                                    <input name="highlight_project_fee" type="number" class="form-control" value="5">
                                </div>
                            </div>
                            <div class="row form-group">
                                <label class="col-sm-4 control-label">Thời gian huy hiệu Top Picks</label>
                                <div class="col-sm-6">
                                    <input name="highlight_duration" type="Text" class="form-control" value="30">
                                    <p class="help-block">Thời lượng hiển thị Top Picks (tính bằng ngày).</p>
                                </div>
                            </div>
                            <h3 class="heading">Tùy chọn gói </h3>
                            <div class="row form-group">
                                <div class="inside" style="padding: 0 20px">
                                    <label class="css-input css-checkbox css-checkbox-primary">
                                        <input type="checkbox" name="top_search_result" value="yes"
                                            checked><span></span>
                                        Top trong kết quả tìm kiếm và danh mục.
                                    </label>
                                    <br>
                                    <label class="css-input css-checkbox css-checkbox-primary">
                                        <input type="checkbox" name="show_on_home" value="yes"><span></span>
                                        Hiển thị tin việc làm trên phần quảng cáo cao cấp của trang chủ.
                                    </label>
                                    <br>
                                    <label class="css-input css-checkbox css-checkbox-primary">
                                        <input type="checkbox" name="show_in_home_search" value="yes"><span></span>
                                        Hiển thị tin việc làm trên danh sách kết quả tìm kiếm trang chủ.
                                    </label>

                                </div>
                            </div>
                            <input type="hidden" name="submit">
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
</div>
<script>
$(function() {
    App.initHelpers('select2');
});
</script>