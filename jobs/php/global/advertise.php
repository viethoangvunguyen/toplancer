<?php
$pdo = ORM::get_db();
if (isset($_GET['action'])) {
    if ($_GET['action'] == "post_banner") {
        add_advertise();
    }
}

$query = "SELECT p.id,p.title,p.slots, count(b.type_id) as count
FROM `".$config['db']['pre']."qbm_types`  p LEFT JOIN `".$config['db']['pre']."qbm_banners` b ON p.id = b.type_id AND b.`status`='success' AND b.time_expired < ".time()." GROUP BY p.id, p.title, p.slots HAVING COUNT(b.type_id) < p.slots OR COUNT(b.type_id) IS NULL";

$queryRecords = $pdo->query($query);

$avaiable_type= [];
foreach ($queryRecords as $info) {
    $avaiable_type[] = $info['id'];
}

$rows = ORM::for_table($config['db']['pre'] . 'qbm_types')
->where('status','1')
->where_in('id',$avaiable_type)
->order_by_desc('id')
->find_many();
$types = array();
foreach ($rows as $row) {
$types[$row['id']]['id'] = $row['id'];
$types[$row['id']]['title'] = $row['title'];
$types[$row['id']]['price'] = $row['price'];
$types[$row['id']]['slots'] = $row['slots'];
}

function add_advertise() {
    global $config,$link;

    if (isset($_POST['type'])) {
        $type = $_POST['type'];
    }
    if (isset($_POST['title'])) {
        $title = $_POST['title'];
    }
    if (isset($_POST['url'])) {
        $url = $_POST['url'];
    }
    $type_info = ORM::for_table($config['db']['pre'] . 'qbm_types')->find_one($type);
    if (isset($_POST['period'])) {
        $period = $_POST['period'];
        $amount = $period* $type_info['price']/10;
    }
    $balance = ORM::for_table($config['db']['pre'] . 'user')
    ->where('id', $_SESSION['user']['id'])
    ->find_one();
    if($balance['balance'] >= $amount) {
    if (isset($_FILES['file']) && $_FILES['file']['tmp_name'] != "") {
        $valid_formats = array("jpeg", "jpg", "png");
        $filename = stripslashes($_FILES['file']['name']);
        $ext = getExtension($filename);
        $ext = strtolower($ext);
        //File extension check
        if (in_array($ext, $valid_formats)) {
            $uploaddir = "C:/xampp/htdocs/jobs/storage/banner_advertise/"; //Image upload directory
            $filename = stripslashes($_FILES['file']['name']);
            $size = filesize($_FILES['file']['tmp_name']);
            //Convert extension into a lower case format

            $ext = getExtension($filename);
            $ext = strtolower($ext);
            $now = time();
            $image_name = $now.'_'.$_FILES['file']['name'];
            $newLogo = $uploaddir . $image_name;
            if(file_exists($newLogo)){
                unlink($newLogo);
            }
            //Moving file to uploads folder
            if (move_uploaded_file($_FILES['file']['tmp_name'], $newLogo)) {

                add_banner($type,$title,$url,$image_name,$period,$amount,$balance['balance']);
                $status = "success";
                $message = __("Lưu thành công.");
                $redirect_url = $config['site_url'].'advertise-here?success=true';
                headerRedirect($redirect_url);
                message(__("Success"),__("Payment Successful"),$link['BANNER-ADS']);
                //header("Location: ".$config['site_url']."index1");
            } else {
                $status = "error";
                $message = __("Lỗi: Hãy thử lại.");
            }
        }
        else {
            $status = "error";
            $message = __("Chỉ cho phép định dạng ảnh jpg, jpeg png");
        }

    }
} else {
    $status = "error";
     $message = __("Số dư tài khoản không đủ.");
}
    
}

function add_banner($type_id,$title,$url,$image_name,$days,$amount,$balance_s) {
    $status = 'pending';
    global $config;
    $sql = "INSERT INTO `"."ql_qbm_banners` (
        type_id, title, user_id, status, url, file, days_purchased, amount, registered) VALUES (
        '".$type_id."',
        '".$title."',
        '".$_SESSION['user']['id']."',
        '".$status."',
        '".$url."',
        '".$image_name."',
        '".$days."',
        '".$amount."',
        '".time()."'
    )";
    $payment_status = 'pending';
    $transaction_type = "wallet";
    $balance = $balance_s - $amount;
    $result = ORM::for_table($config['db']['pre'].'qbm_banners')->raw_query($sql)->find_many();
    $id = ORM::get_db()->lastInsertId();
    $sql_balance = "UPDATE `"."ql_user` SET balance = '".$balance."' WHERE id = '".$_SESSION['user']['id']."'";
    $result_balance = ORM::for_table($config['db']['pre'].'user')->raw_query($sql_balance)->find_many(); 
    $sql_trans = "INSERT INTO `".$config['db']['pre']."qbm_transactions` (
        banner_id, payer_name, payer_id, gross, currency, payment_status, transaction_type, created) VALUES (
        '".$id."',
        '".$_SESSION['user']['username']."',
        '".$_SESSION['user']['id']."',
        '".$amount."',
        '".$config['currency_code']."',
        '".$payment_status."',
        '".$transaction_type."',
        '".time()."'
    )";

    $result_trans = ORM::for_table($config['db']['pre'].'qbm_transactions')->raw_query($sql_trans)->find_many();   
}
//Print Template
HtmlTemplate::display('global/advertise-here', array(
    'types' => $types
));
exit;
?>