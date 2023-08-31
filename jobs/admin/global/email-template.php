<?php
require_once('../includes.php');

$default_shortcodes = [
    [
        'title' => 'Tên Web',
        'code' => '{SITE_TITLE}'
    ],
    [
        'title' => 'Web URL',
        'code' => '{SITE_URL}'
    ]
];
$email_template = [
    [
        'id' => 'signup-details',
        'title' => 'Email thông báo tạo tài khoản thành công',
        'subject' => 'email_sub_signup_details',
        'message' => 'email_message_signup_details',
        'shortcodes' => array_merge($default_shortcodes,[
            [
                'title' => 'Id người dùng',
                'code' => '{USER_ID}'
            ],
            [
                'title' => 'Tên đăng nhập',
                'code' => '{USERNAME}'
            ],
            [
                'title' => 'Họ tên người dùng',
                'code' => '{USER_FULLNAME}'
            ],
            [
                'title' => 'Email người dùng',
                'code' => '{EMAIL}'
            ],
            [
                'title' => 'Mật khẩu',
                'code' => '{PASSWORD}'
            ]
        ]),
    ],
    [
        'id' => 'create-account',
        'title' => 'Email xác minh tài khoản người dùng',
        'subject' => 'email_sub_signup_confirm',
        'message' => 'email_message_signup_confirm',
        'shortcodes' => array_merge($default_shortcodes,[
            [
                'title' => 'Id người dùng',
                'code' => '{USER_ID}'
            ],
            [
                'title' => 'Tên đăng nhập',
                'code' => '{USERNAME}'
            ],
            [
                'title' => 'Họ tên người dùng',
                'code' => '{USER_FULLNAME}'
            ],
            [
                'title' => 'Email người dùng',
                'code' => '{EMAIL}'
            ],
            [
                'title' => 'Link xác minh tài khoản',
                'code' => '{CONFIRMATION_LINK}'
            ]
        ]),
    ],
    [
        'id' => 'forgot-pass',
        'title' => 'Email quên mật khẩu',
        'subject' => 'email_sub_forgot_pass',
        'message' => 'email_message_forgot_pass',
        'shortcodes' => array_merge($default_shortcodes,[
            [
                'title' => 'Id người dùng',
                'code' => '{USER_ID}'
            ],
            [
                'title' => 'Tên đăng nhập',
                'code' => '{USERNAME}'
            ],
            [
                'title' => 'Họ tên người dùng',
                'code' => '{USER_FULLNAME}'
            ],
            [
                'title' => 'Email người dùng',
                'code' => '{EMAIL}'
            ],
            [
                'title' => 'Link đặt lại mật khẩu',
                'code' => '{FORGET_PASSWORD_LINK}'
            ]
        ]),
    ],
    [
        'id' => 'contact_us',
        'title' => 'Email liên hệ',
        'subject' => 'email_sub_contact',
        'message' => 'email_message_contact',
        'shortcodes' => array_merge($default_shortcodes,[
            [
                'title' => 'Họ tên người dùng',
                'code' => '{NAME}'
            ],
            [
                'title' => 'Email người dùng',
                'code' => '{EMAIL}'
            ],
            [
                'title' => 'Tiêu đề email liên hệ',
                'code' => '{CONTACT_SUBJECT}'
            ],
            [
                'title' => 'Nội dung email liên hệ',
                'code' => '{MESSAGE}'
            ]
        ]),
    ],
    [
        'id' => 'feedback',
        'title' => 'Email phản hồi',
        'subject' => 'email_sub_feedback',
        'message' => 'email_message_feedback',
        'shortcodes' => array_merge($default_shortcodes,[
            [
                'title' => 'Họ tên người dùng',
                'code' => '{NAME}'
            ],
            [
                'title' => 'Email người dùng',
                'code' => '{EMAIL}'
            ],
            [
                'title' => 'Số điện thoại người dùng',
                'code' => '{PHONE}'
            ],
            [
                'title' => 'Tiêu đề email phản hồi',
                'code' => '{FEEDBACK_SUBJECT}'
            ],
            [
                'title' => 'Nội dung email phản hồi',
                'code' => '{MESSAGE}'
            ]
        ]),
    ],
    [
        'id' => 'report',
        'title' => 'Email báo cáo vi phạm',
        'subject' => 'email_sub_report',
        'message' => 'email_message_report',
        'shortcodes' => array_merge($default_shortcodes,[
            [
                'title' => 'Tên người gửi',
                'code' => '{USERNAME}'
            ],
            [
                'title' => 'Họ tên người gửi',
                'code' => '{NAME}'
            ],
            [
                'title' => 'Email người gửi',
                'code' => '{EMAIL}'
            ],
            [
                'title' => 'Người dùng vi phạm',
                'code' => '{USERNAME2}'
            ],
            [
                'title' => 'Loại vi phạm',
                'code' => '{VIOLATION}'
            ],
            [
                'title' => 'URL(LINK) Vi phạm',
                'code' => '{URL}'
            ],
            [
                'title' => 'Nội dung vi phạm',
                'code' => '{DETAILS}'
            ]
        ]),
    ],
    [
        'id' => 'ad_approve',
        'title' => 'Email thông báo việc làm được phê duyệt',
        'subject' => 'email_sub_ad_approve',
        'message' => 'email_message_ad_approve',
        'shortcodes' => array_merge($default_shortcodes,[
            [
                'title' => 'Họ tên nhà tuyển dụng',
                'code' => '{SELLER_NAME}'
            ],
            [
                'title' => 'Email nhà tuyển dụng',
                'code' => '{SELLER_EMAIL}'
            ],
            [
                'title' => 'Tiêu đề tin tuyển dụng',
                'code' => '{ADTITLE}'
            ],
            [
                'title' => 'Link tin tuyển dụng',
                'code' => '{ADLINK}'
            ]
        ]),
    ],
    [
        'id' => 're_ad_approve',
        'title' => 'Email thông báo tin việc làm gửi lại được phê duyệt',
        'subject' => 'email_sub_re_ad_approve',
        'message' => 'email_message_re_ad_approve',
        'shortcodes' => array_merge($default_shortcodes,[
            [
                'title' => 'Họ tên nhà tuyển dụng',
                'code' => '{SELLER_NAME}'
            ],
            [
                'title' => 'Email nhà tuyển dụng',
                'code' => '{SELLER_EMAIL}'
            ],
            [
                'title' => 'Tiêu đề tin tuyển dụng',
                'code' => '{ADTITLE}'
            ],
            [
                'title' => 'Link tin tuyển dụng',
                'code' => '{ADLINK}'
            ]
        ]),
    ],
    [
        'id' => 'contact_to_seller',
        'title' => 'Email ứng tuyển việc làm',
        'subject' => 'email_sub_contact_seller',
        'message' => 'email_message_contact_seller',
        'shortcodes' => array_merge($default_shortcodes,[
            [
                'title' => 'Họ tên nhà tuyển dụng',
                'code' => '{SELLER_NAME}'
            ],
            [
                'title' => 'Email nhà tuyển dụng',
                'code' => '{SELLER_EMAIL}'
            ],
            [
                'title' => 'Tiêu đề tin tuyển dụng',
                'code' => '{ADTITLE}'
            ],
            [
                'title' => 'Link tin tuyển dụng',
                'code' => '{ADLINK}'
            ],
            [
                'title' => 'Họ tên người gửi',
                'code' => '{SENDER_NAME}'
            ],
            [
                'title' => 'Email người gửi',
                'code' => '{SENDER_EMAIL}'
            ],
            [
                'title' => 'Link hồ sơ người gửi',
                'code' => '{SENDER_PROFILE}'
            ],
            [
                'title' => 'Link CV',
                'code' => '{RESUME_LINK}'
            ],
            [
                'title' => 'Nội dung',
                'code' => '{MESSAGE}'
            ],
        ]),
    ],
    [
        'id' => 'project_awarded',
        'title' => 'Freelancer : Thông báo trúng thầu dự án',
        'subject' => 'email_sub_freelancer_project_awarded',
        'message' => 'emailHTML_freelancer_project_awarded',
        'shortcodes' => array_merge($default_shortcodes,[
            [
                'title' => 'Tên dự án',
                'code' => '{PROJECT_TITLE}'
            ],
            [
                'title' => 'Link dự án',
                'code' => '{PROJECT_LINK}'
            ],
            [
                'title' => 'Tên freelancer',
                'code' => '{FREELANCER_NAME}'
            ]
        ]),
    ],
    [
        'id' => 'project_revoke',
        'title' => 'Freelancer : Dự án bị thu hồi bởi nhà tuyển dụng',
        'subject' => 'email_sub_freelancer_project_revoke',
        'message' => 'emailHTML_freelancer_project_revoke',
        'shortcodes' => array_merge($default_shortcodes,[
            [
                'title' => 'Tên dự án',
                'code' => '{PROJECT_TITLE}'
            ],
            [
                'title' => 'Link dự án',
                'code' => '{PROJECT_LINK}'
            ],
            [
                'title' => 'Tên freelancer',
                'code' => '{FREELANCER_NAME}'
            ]
        ]),
    ],
    [
        'id' => 'project_accepted',
        'title' => 'Nhà tuyển dụng: Thông báo dự án được freelancer chấp nhận',
        'subject' => 'email_sub_employer_project_accepted',
        'message' => 'emailHTML_employer_project_accepted',
        'shortcodes' => array_merge($default_shortcodes,[
            [
                'title' => 'Tên dự án',
                'code' => '{PROJECT_TITLE}'
            ],
            [
                'title' => 'Link dự án',
                'code' => '{PROJECT_LINK}'
            ],
            [
                'title' => 'Tên nhà tuyển dụng',
                'code' => '{EMPLOYER_NAME}'
            ]
        ]),
    ],
    [
        'id' => 'project_approval_reject',
        'title' => 'Nhà tuyển dụng: Thông báo dự án bị freelancer từ chối',
        'subject' => 'email_sub_employer_project_approval_reject',
        'message' => 'emailHTML_employer_project_approval_reject',
        'shortcodes' => array_merge($default_shortcodes,[
            [
                'title' => 'Tên dự án',
                'code' => '{PROJECT_TITLE}'
            ],
            [
                'title' => 'Link dự án',
                'code' => '{PROJECT_LINK}'
            ],
            [
                'title' => 'Tên nhà tuyển dụng',
                'code' => '{EMPLOYER_NAME}'
            ]
        ]),
    ],
    [
        'id' => 'milestone_created',
        'title' => 'Freelancer : Cột mốc do nhà tuyển dụng tạo ra',
        'subject' => 'email_sub_milestone_created',
        'message' => 'emailHTML_milestone_created',
        'shortcodes' => array_merge($default_shortcodes,[
            [
                'title' => 'Tên dự án',
                'code' => '{PROJECT_TITLE}'
            ],
            [
                'title' => 'Link dự án',
                'code' => '{PROJECT_LINK}'
            ],
            [
                'title' => 'Tên cột mốc',
                'code' => '{MILESTONE_TITLE}'
            ],
            [
                'title' => 'Số tiền',
                'code' => '{MILESTONE_AMOUNT}'
            ]
        ]),
    ],
    [
        'id' => 'milestone_release',
        'title' => 'Freelancer : Nhà tuyển dụng đã thanh toán cột mốc',
        'subject' => 'email_sub_milestone_released',
        'message' => 'emailHTML_milestone_released',
        'shortcodes' => array_merge($default_shortcodes,[
            [
                'title' => 'Tên dự án',
                'code' => '{PROJECT_TITLE}'
            ],
            [
                'title' => 'Link dự án',
                'code' => '{PROJECT_LINK}'
            ],
            [
                'title' => 'Tên cột mốc',
                'code' => '{MILESTONE_TITLE}'
            ],
            [
                'title' => 'Số tiền',
                'code' => '{MILESTONE_AMOUNT}'
            ]
        ]),
    ],
    [
        'id' => 'milestone_release_request',
        'title' => 'Nhà tuyển dụng: Yêu cầu thanh toán cột mốc từ phía Freelancer.',
        'subject' => 'email_sub_milestone_request_to_release',
        'message' => 'emailHTML_milestone_request_to_release',
        'shortcodes' => array_merge($default_shortcodes,[
            [
                'title' => 'Tên dự án',
                'code' => '{PROJECT_TITLE}'
            ],
            [
                'title' => 'Link dự án',
                'code' => '{PROJECT_LINK}'
            ],
            [
                'title' => 'Tên cột mốc',
                'code' => '{MILESTONE_TITLE}'
            ],
            [
                'title' => 'Số tiền',
                'code' => '{MILESTONE_AMOUNT}'
            ]
        ]),
    ],
    [
        'id' => 'got_rating',
        'title' => 'Thông báo đánh giá dự án',
        'subject' => 'email_sub_got_rating',
        'message' => 'emailHTML_got_rating',
        'shortcodes' => array_merge($default_shortcodes,[
            [
                'title' => 'Tên dự án',
                'code' => '{PROJECT_TITLE}'
            ],
            [
                'title' => 'Link dự án',
                'code' => '{PROJECT_LINK}'
            ],
            [
                'title' => 'Số sao đánh giá',
                'code' => '{RATING}'
            ],
            [
                'title' => 'Nội dung đánh giá',
                'code' => '{COMMENT}'
            ]
        ]),
    ],
    [
        'id' => 'withdraw_accepted',
        'title' => 'Rút tiền: Yêu cầu được chấp thuận bởi Admin',
        'subject' => 'email_sub_withdraw_accepted',
        'message' => 'emailHTML_withdraw_accepted',
        'shortcodes' => array_merge($default_shortcodes,[
            [
                'title' => 'Số tiền rút',
                'code' => '{AMOUNT}'
            ]
        ]),
    ],
    [
        'id' => 'withdraw_rejected',
        'title' => 'Rút tiền: Yêu cầu bị từ chối bởi Admin',
        'subject' => 'email_sub_withdraw_rejected',
        'message' => 'emailHTML_withdraw_rejected',
        'shortcodes' => array_merge($default_shortcodes,[
            [
                'title' => 'Số tiền rút',
                'code' => '{AMOUNT}'
            ]
        ]),
    ],
    [
        'id' => 'new_withdraw_request',
        'title' => 'Admin : Yêu cầu rút tiền mới',
        'subject' => 'email_sub_withdraw_request',
        'message' => 'emailHTML_withdraw_request',
        'shortcodes' => array_merge($default_shortcodes,[
            [
                'title' => 'Số tiền rút',
                'code' => '{AMOUNT}'
            ]
        ]),
    ],
    [
        'id' => 'amount_deposit',
        'title' => 'Admin : Người dùng đã nạp tiền vào ví',
        'subject' => 'email_sub_amount_deposit',
        'message' => 'emailHTML_amount_deposit',
        'shortcodes' => array_merge($default_shortcodes,[
            [
                'title' => 'Số tiền nạp',
                'code' => '{AMOUNT}'
            ]
        ]),
    ],
    [
        'id' => 'banner_accepted',
        'title' => 'Banner Quảng Cáo: Yêu cầu được chấp thuận bởi Admin',
        'subject' => 'email_sub_banner_accepted',
        'message' => 'emailHTML_banner_accepted',
        'shortcodes' => array_merge($default_shortcodes,[
            [
                'title' => 'Số ngày',
                'code' => '{DAYS_PURCHASED}'
            ],
            [
                'title' => 'Số tiền',
                'code' => '{AMOUNT}'
            ],
            [
                'title' => 'URL link',
                'code' => '{URL}'
            ]
        ]),
    ],
    [
        'id' => 'banner_rejected',
        'title' => 'Banner Quảng Cáo: Yêu cầu bị từ chối bởi Admin',
        'subject' => 'email_sub_banner_rejected',
        'message' => 'emailHTML_banner_rejected',
        'shortcodes' => array_merge($default_shortcodes,[
            [
                'title' => 'Số ngày',
                'code' => '{DAYS_PURCHASED}'
            ],
            [
                'title' => 'Số tiền',
                'code' => '{AMOUNT}'
            ],
            [
                'title' => 'URL link',
                'code' => '{URL}'
            ]
        ]),
    ],
    [
        'id' => 'job_newsletter_email',
        'title' => 'Gửi thông báo email việc làm mới tới người dùng đăng kí',
        'subject' => 'email_sub_post_notification',
        'message' => 'email_message_post_notification',
        'shortcodes' => array_merge($default_shortcodes,[
            [
                'title' => 'Tiêu đề tin tuyển dụng',
                'code' => '{ADTITLE}'
            ],
            [
                'title' => 'Link tin tuyển dụng',
                'code' => '{ADLINK}'
            ]
        ]),
    ]
];
?>
<style>
#quickad-tbs .note-toolbar.panel-heading {
    padding: 0 10px 5px;
}
</style>
<link href="../assets/js/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet">

<!-- Page Content -->
<main class="app-layout-content">

    <!-- Page Content -->
    <div class="container-fluid p-y-md">
        <!-- Partial Table -->
        <div class="card">
            <div class="card-header">
                <h4>Email Thông Báo</h4>
                <div class="pull-right">
                    <a class="btn btn-sm btn-warning" href="<?php _esc(ADMINURL);?>global/setting.php#quickad_email">Cài
                        đặt Email</a>
                </div>
            </div>

            <div class="card-block">
                <!-- /row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <form method="post"
                                action="<?php echo ADMINURL;?>ajax_sidepanel.php?action=saveEmailTemplate"
                                id="saveEmailTemplate">
                                <div class="panel panel-default quickad-main">
                                    <div class="panel-body">

                                        <div id="quickad-tbs" class="wrap">
                                            <div class="quickad-tbs-body">
                                                <div class="panel panel-default quickad-main">
                                                    <div class="panel-body">
                                                        <h4 class="quickad-block-head">
                                                            <span class="quickad-category-title">Mẫu Email</span>
                                                        </h4>

                                                        <div class="quickad-margin-top-xlg">
                                                            <?php
                                                            $i = 1;
                                                            foreach($email_template as $template){
                                                                ?>
                                                            <div class="panel panel-default quickad-js-collapse">
                                                                <div class="panel-heading" role="tab"
                                                                    id="s_<?php _esc($template['id'])?>">
                                                                    <div class="row">
                                                                        <div class="col-sm-8 col-xs-10">
                                                                            <div class="quickad-flexbox">
                                                                                <div class="quickad-flex-cell quickad-vertical-middle"
                                                                                    style="width: 1%">
                                                                                    <i class="quickad-js-handle quickad-icon quickad-icon-draghandle quickad-margin-right-sm quickad-cursor-move ui-sortable-handle"
                                                                                        title="Reorder"
                                                                                        style="display: none;"></i>
                                                                                </div>
                                                                                <div
                                                                                    class="quickad-flex-cell quickad-vertical-middle">
                                                                                    <a role="button"
                                                                                        class="panel-title quickad-js-service-title collapsed"
                                                                                        data-toggle="collapse"
                                                                                        data-parent=".panel-group"
                                                                                        href="#service_<?php _esc($template['id'])?>"
                                                                                        aria-expanded="false">
                                                                                        <?php _esc($i)?>.
                                                                                        <?php _esc($template['title'])?></a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div id="service_<?php _esc($template['id'])?>"
                                                                    class="panel-collapse collapse" role="tabpanel"
                                                                    style="height: 0px;" aria-expanded="false">
                                                                    <div class="panel-body">

                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label>Tiêu đề</label>
                                                                                    <input
                                                                                        name="<?php _esc($template['subject'])?>"
                                                                                        placeholder="Nhập tiêu đề email"
                                                                                        class="form-control" type="text"
                                                                                        value="<?php echo get_option($template['subject']) ?>">

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row mailMethods mailMethod-0">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label for="pageContent">Nội
                                                                                        dung</label>
                                                                                    <textarea
                                                                                        name="<?php _esc($template['message'])?>"
                                                                                        rows="6" class="form-control"
                                                                                        id="pageContent"
                                                                                        placeholder="Nhập nội dung"><?php echo get_option($template['message']) ?></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label>Tên mã</label>
                                                                                    <table class="quickad-codes">
                                                                                        <tbody>
                                                                                            <?php foreach($template['shortcodes'] as $shortcode){ ?>
                                                                                            <tr>
                                                                                                <td><input
                                                                                                        value="<?php _esc($shortcode['code'])?>"
                                                                                                        readonly="readonly"
                                                                                                        onclick="this.select()">-
                                                                                                    <?php _esc($shortcode['title'])?>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <?php } ?>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php  $i++; }  ?>

                                                            <div class="panel-footer">
                                                                <div class="pull-left">
                                                                </div>
                                                                <button name="email_setting" type="submit"
                                                                    class="btn btn-success btn-radius save-changes">Lưu</button>
                                                                <button class="btn btn-default" type="reset">Đặt
                                                                    lại</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
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
$(".save-changes").on('click', function() {
    $(".save-changes").addClass("bookme-progress");
});
$(".ladda-button").on('click', function() {
    $(".ladda-button").addClass("bookme-progress");
});
/* Mail Method Changer */
$("#email_template").on('change', function() {
    $(".mailMethods").hide();
    $(".mailMethod-" + $(this).val()).show();
});

$(document).on('change', '.quickad-check-all-entities', function() {
    $(this).parents('.quickad-services-holder').find('.quickad-js-check-entity').prop('checked', $(this).prop(
        'checked'));
});
// wait for the DOM to be loaded
$(document).ready(function() {
    // bind 'myForm' and provide a simple callback function
    $('#saveEmailTemplate').ajaxForm(function(data) {
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
});

</script>
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
</body>

</html>