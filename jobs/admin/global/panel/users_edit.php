<?php
define("ROOTPATH", dirname(dirname(dirname(__DIR__))));
define("APPPATH", ROOTPATH."/php/");
require_once ROOTPATH . '/includes/autoload.php';
require_once ROOTPATH . '/includes/lang/lang_'.$config['lang'].'.php';
admin_session_start();
$pdo = ORM::get_db();

$fetchuser = ORM::for_table($config['db']['pre'].'user')->find_one($_GET['id']);

$fetchusername  = $fetchuser['username'];
$fetchuserpic     = $fetchuser['image'];

if($fetchuserpic == "")
    $fetchuserpic = "default_user.png";

?>
<header class="slidePanel-header overlay">
    <div class="overlay-panel overlay-background vertical-align">
        <div class="service-heading">
            <h2>Chỉnh sửa người dùng</h2>
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
                    <form name="form2" class="form form-horizontal" method="post" data-ajax-action="editUser"
                        id="sidePanel_form">
                        <div class="form-body">
                            <input type="hidden" name="id" value="<?php echo $_GET['id']?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="col-md-2">
                                            <img src="<?php echo $config['site_url'];?>storage/profile/<?php echo $fetchuserpic; ?>"
                                                alt="<?php echo $fetchuser['name'];?>"
                                                style="width: 80px; border-radius: 50%">
                                        </div>
                                        <div class="col-md-10">
                                            <label class="control-label">Ảnh Đại Diện</label>
                                            <input class="form-control input-sm" type="file" id="file" name="file"
                                                placeholder=".input-sm" />
                                            <span class="help-block"> Tải lên ảnh đại diện</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputfullname">Tên</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="ion-person"></i></div>
                                            <input type="text" class="form-control" id="exampleInputfullname"
                                                placeholder="Full Name" name="name"
                                                value="<?php echo $fetchuser['name'];?>">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Trạng Thái</label>
                                        <select class="form-control" name="status">
                                            <option value="0"
                                                <?php echo ($fetchuser['status'] == "0")? "selected" : "" ?>>Chờ Xác
                                                Thực</option>
                                            <option value="1"
                                                <?php echo ($fetchuser['status'] == "1")? "selected" : "" ?>>Đã Xác Thực
                                            </option>
                                            <option value="2"
                                                <?php echo ($fetchuser['status'] == "2")? "selected" : "" ?>>Khóa
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Giới Tính</label>
                                        <select class="form-control" name="sex">
                                            <option value="Male"
                                                <?php if($fetchuser['sex'] == "Male") { echo "selected"; }?>>Nam
                                            </option>
                                            <option value="Female"
                                                <?php if($fetchuser['sex'] == "Female") { echo "selected"; }?>>Nữ
                                            </option>
                                            <option value="Other"
                                                <?php if($fetchuser['sex'] == "Other") { echo "selected"; }?>>Khác
                                            </option>
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Địa Chỉ</label>
                                        <select class="form-control" name="country">
                                            <?php $country = get_country_list($fetchuser['country'],"selected",0);
                                            foreach ($country as $value){
                                                echo '<option value="'.$value['asciiname'].'" '.$value['selected'].'>'.$value['asciiname'].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Giới Thiệu</label>
                                        <textarea name="about"
                                            class="form-control"><?php echo $fetchuser['description'];?></textarea>
                                    </div>
                                </div>

                                <h4 class="box-title m-b-0">Cài Đặt Tài Khoản</h4>
                                <hr>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputuname">Tên Đăng Nhập</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="ion-person"></i></div>
                                            <input type="text" class="form-control" id="exampleInputuname"
                                                placeholder="Username" name="username"
                                                value="<?php echo $fetchuser['username'];?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="ion-android-mail"></i></div>
                                            <input type="email" class="form-control" id="exampleInputEmail1"
                                                placeholder="Email" name="email"
                                                value="<?php echo $fetchuser['email'];?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputpwd2">Mật Khẩu Mới</label>
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="ion-android-lock"></i></div>
                                            <input type="password" class="form-control" id="exampleInputpwd2"
                                                placeholder="Nhập Mật Khẩu Mới" name="password">
                                        </div>
                                    </div>
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