<header class="slidePanel-header overlay">
    <div class="overlay-panel overlay-background vertical-align">
        <div class="service-heading">
            <h2>Thêm Nhận Xét Từ Khách Hàng</h2>
        </div>
        <div class="slidePanel-actions">
            <div class="btn-group-flat">
                <button type="button" class="btn btn-floating btn-warning btn-sm waves-effect waves-float waves-light margin-right-10" id="post_sidePanel_data"><i class="icon ion-android-done" aria-hidden="true"></i></button>
                <button type="button" class="btn btn-pure btn-inverse slidePanel-close icon ion-android-close font-size-20" aria-hidden="true"></button>
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
                    <form name="form2"  class="form form-horizontal" method="post" data-ajax-action="addTestimonial" id="sidePanel_form">
                        <div class="form-body">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>Tên:</label>
                                    <input name="name" type="text" class="form-control" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>Nghề Nghiệp:</label>
                                    <input name="designation" type="text" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>Ảnh Người Dùng:</label>
                                    <input name="image" type="file" class="form-control" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>Nội Dung:</label>
                                    <textarea name="content" id="content" rows="6" class="form-control" required></textarea>
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