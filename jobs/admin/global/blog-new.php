<?php
require_once('../includes.php');

$id = $title = $image = $description = $tags =  $status = null;
$categories = array();
if(!empty($_GET['id'])) {
    $sql = "SELECT b.*, GROUP_CONCAT(bc.category_id) categories FROM `".$config['db']['pre']."blog` b LEFT JOIN `".$config['db']['pre']."blog_cat_relation` bc ON bc.blog_id = b.id WHERE b.id = ".$_GET['id'];

    $info = ORM::for_table($config['db']['pre'].'blog')->raw_query($sql)->find_one();
    if (!empty($info)) {
        $id = $info['id'];
        $title = $info['title'];
        $image = $info['image'];
        $description = stripslashes($info['description']);
        $status = $info['status'];
        $tags = $info['tags'];
        $categories = explode(',',$info['categories']);
    } else {
        exit();
    }
}
?>
<style>
    #quickad-tbs .note-toolbar.panel-heading {
        padding: 0 10px 5px;
    }
    #quickad-tbs .note-editor.panel {
        border: 1px solid #d9dee4;
    }

    #quickad-tbs .redux-option-image {
        margin-bottom: 10px;
    }

    #quickad-tbs .panel.quickad-main > .panel-body {
        padding: 15px;
    }

    #quickad-tbs .panel.quickad-main .panel-body + .panel-footer {
        margin: 0 15px 15px;
        padding: 15px 0 0 0;
    }

    #quickad-tbs .blog_categories {
        margin: 0;
        max-height: 125px;
        overflow: auto;
    }

    #quickad-tbs .blog_categories li {
        margin-bottom: 5px;
        padding: 0;
        word-wrap: break-word;
    }

    #quickad-tbs .blog_categories label {
        display: flex;
        cursor: pointer;
        font-weight: normal;
    }

    #quickad-tbs .blog_categories label input {
        margin: 0 5px 0 0;
    }
</style>
<link href="../assets/css/user-html.css" rel="stylesheet">
<main class="app-layout-content">
    <div class="container-fluid p-y-md">
        <div id="quickad-tbs">
            <div class="quickad-tbs-body">
                <h2><?php if(!empty($_GET['id'])) {
                        echo 'Chỉnh Sửa Blog';
                    }else{
                        echo 'Thêm Mới Blog';
                    }
                    ?></h2>
                <hr>
                <form id="blog_form_ajax" method="post" action="#" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="post_id" value="<?php echo $id; ?>">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="title">Tiêu Đề</label>
                                <span class="help-block">Không được dùng html code.</span>
                                <div>
                                    <input name="title" class="form-control" type="Text" id="title" value="<?php echo $title; ?>"
                                           required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="post_image">Ảnh Thumbnail</label>
                                <span class="help-block">Chỉ cho phép các định dạng jpg, jpeg và png.</span>
                                <div><img class="redux-option-image" id="post_image" src="<?php echo $config['site_url'];?>storage/blog/<?php echo $image; ?>" alt="" width="400px"  <?php if(empty($image)){ ?>style="display: none" <?php } ?>></div>
                                <input class="form-control input-sm" type="file" name="image"
                                           onchange="readURL(this,'post_image')">
                            </div>
                            <div class="form-group">
                                <label for="pageContent">Nội dung</label>
                                <div class="user-html">
                                    <textarea name="description" rows="6" id="pageContent" class="form-control"><?php echo $description; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="panel panel-default quickad-main">
                                <div class="panel-heading">Xuất Bản</div>
                                <div class="panel-body">
                                    <label for="status">Trạng Thái</label>
                                    <span class="help-block">Chọn 'Đang chờ' nếu bạn muốn ẩn bài đăng.</span>
                                    <select name="status" id="status" class="form-control">
                                        <option <?php echo $status == 'publish'?'selected':''; ?> value="publish">Xuất Bản</option>
                                        <option <?php echo $status == 'pending'?'selected':''; ?> value="pending">Đang Chờ</option>
                                    </select>
                                </div>
                                <div class="panel-footer">
                                    <button id="blog_submit_btn" name="submit" type="submit" class="btn btn-success">Gửi</button>
                                </div>
                            </div>
                            <div class="panel panel-default quickad-main">
                                <div class="panel-heading">Danh Mục</div>
                                <div class="panel-body">
                                    <ul class="blog_categories">
                                    <?php
                                    $rows = ORM::for_table($config['db']['pre'].'blog_categories')
                                        ->order_by_asc('position')
                                        ->find_many();
                                    foreach ($rows as $row) { ?>
                                    <li>
                                        <label>
                                            <input value="<?php echo $row['id']; ?>" type="checkbox" name="category[]" id="category-<?php echo $row['id']; ?>" <?php echo in_array($row['id'],$categories)?'checked':''; ?>> <?php echo $row['title']; ?>
                                        </label>
                                    </li>
                                    <?php } ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel panel-default quickad-main">
                                <div class="panel-heading">Thẻ</div>
                                <div class="panel-body">
                                    <span class="help-block">Nhập thẻ mỗi thẻ cách nhau bởi dấu phẩy</span>
                                    <textarea name="tags" rows="2" class="form-control" id="tags"><?php echo $tags; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include("../footer.php"); ?>

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
            toolbar = ['bold','italic','underline','fontScale','ol','ul','blockquote','table','link','image'];
            mobileToolbar = ["bold", "italic", "underline", "ul", "ol"];
            if (mobilecheck()) {
                toolbar = mobileToolbar;
            }
            allowedTags = ['br','span','a','img','b','strong','i','strike','u','font','p','ul','ol','li','blockquote','pre','h1','h2','h3','h4','hr','table'];
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