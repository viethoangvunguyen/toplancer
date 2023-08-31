<?php
define("ROOTPATH", dirname(dirname(dirname(__DIR__))));
define("APPPATH", ROOTPATH."/php/");
require_once ROOTPATH . '/includes/autoload.php';
require_once ROOTPATH . '/includes/lang/lang_'.$config['lang'].'.php';
admin_session_start();
$pdo = ORM::get_db();

$fetchuser = ORM::for_table($config['db']['pre'].'user')->find_one($_GET['id']);
$category = ORM::for_table($config['db']['pre'].'catagory_main')->where('cat_id',$fetchuser['category'])->find_one();
if(!isset($_GET['id']))
{
    echo 'Error : 404 Page not found';
}
if($fetchuser['sex'] == 'Male'){
    $sex = 'Nam';
}else if($fetchuser['sex'] == 'Female'){
    $sex = "Nữ";
}else if($fetchuser['sex'] == 'Other'){
    $sex = "Khác";
}else {
    $sex = "Chưa cập nhật";
}
$fetchusername  = $fetchuser['username'];
$fetchuserpic     = $fetchuser['image'];
$type = $fetchuser['user_type'] == 'user' ? '<span class="label label-info">Freelancer</span>': '<span class="label label-success">Employer</span>';
if($fetchuserpic == "")
    $fetchuserpic = "default_user.png";
?>

<style>
.app-contacts * {
    box-sizing: border-box;
}
</style>
<div class="app-contacts">
    <header class="slidePanel-header overlay">
        <div class="overlay-panel overlay-background vertical-align">
            <div class="vertical-align-middle">
                <a class="avatar" href="#" id="emp_img_uploader">
                    <img src="<?php echo $config['site_url'];?>storage/profile/<?php echo $fetchuserpic;?>" alt=""
                        style="min-height: 100px; min-width: 100px">
                </a>
                <h3 class="name"><?php echo $fetchuser['name']; ?></h3>
                <div class="tags">
                    <?php echo $fetchuser['email'];?>
                </div>
                <div class="tags">
                    <?php echo $type;?>
                </div>
            </div>
        </div>
    </header>
    <div class="slidePanel-actions">
        <div class="btn-group-flat">
            <button type="button" class="btn btn-pure btn-inverse slidePanel-close icon ion-android-close font-size-20"
                aria-hidden="true"></button>
        </div>
    </div>
    <div class="slidePanel-inner">
        <div class="user-btm-box">
            <!-- .row -->
            <div class="row text-center m-t-10">
                <div class="col-md-6 b-r"><strong>Tên</strong>
                    <p><?php echo $fetchuser['name'];?></p>
                </div>
                <div class="col-md-6"><strong>Giới tính</strong>
                    <p><?php echo $sex;?></p>
                </div>
            </div>
            <!-- /.row -->
            <hr>
            <!-- .row -->
            <div class="row text-center m-t-10">
                <div class="col-md-6 b-r"><strong>Nghề nghiệp</strong>
                    <p><?php echo $category['cat_name'];?></p>
                </div>
                <div class="col-md-6"><strong>Ngày tham gia</strong>
                    <p><?php echo date('g:i d/m/Y', strtotime($fetchuser['created_at'])); ?></p>
                </div>
            </div>
            <!-- /.row -->
            <hr>
            <!-- .row -->
            <div class="row text-center m-t-10">
                <div class="col-md-12"><strong>Giới thiệu</strong>
                    <p class="m-t-30"><?php echo $fetchuser['description'];?></p>
                </div>

            </div>

        </div>
    </div>
</div>