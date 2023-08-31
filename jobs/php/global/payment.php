<?php
require_once("includes/lib/curl/curl.php");
require_once("includes/lib/curl/CurlResponse.php");

if(!checkloggedin())
{
    error(__("Page Not Found"), __LINE__, __FILE__, 1);
    exit();
}


if(isset($_GET['action']) && $_GET['action'] == 'success'){
    message(__("Success"),__("Payment Successful"),$link['TRANSACTION']);
    exit;
}elseif(isset($_GET['action']) && $_GET['action'] == 'failed'){
    error_content(__("Transaction Failed"),__("Invalid Payment Processor"));
    exit;
}

if(isset($_GET['i']) && trim($_GET['i']) == '')
{
    error(__("Invalid Payment Processor"), __LINE__, __FILE__, 1);
    exit();
}

if(isset($_GET['status']) && $_GET['status'] == 'cancel') {

    $access_token = isset($_GET['access_token']) ? $_GET['access_token'] : 0;

    if($access_token){
        payment_fail_save_detail($access_token);

        $error_msg = "Payment has been cancelled.";

        payment_error("cancel",$error_msg,$access_token);
    }else{
        error(__("Invalid Payment Processor"), __LINE__, __FILE__, 1);
        exit();
    }
}

if(isset($_GET['i']) && isset($_GET['access_token']))
{
    $access_token = $_GET['access_token'];
    if(isset($_SESSION['quickad'][$access_token])){
        $payment_settings = ORM::for_table($config['db']['pre'].'payments')
            ->select('payment_folder')
            ->where('payment_folder', $_GET['i'])
            ->find_one();

        if(!isset($payment_settings['payment_folder']))
        {
            error(__("Invalid Payment Processor"), __LINE__, __FILE__, 1);
            exit();
        }
        require_once('includes/payments/'.$payment_settings['payment_folder'].'/pay.php');
    }
}

if(isset($_POST['payment_method_id']))
{
    $access_token = $_POST['token'];
    if(!isset($_SESSION['quickad'][$access_token]['payment_type'])){
        error(__("Payment session expired"), __LINE__, __FILE__, 1);
        exit();
    }
    $payment_type = $_SESSION['quickad'][$access_token]['payment_type'];
    $_SESSION['quickad'][$access_token]['payment_mode'] = "one_time";
    $_SESSION['quickad'][$access_token]['plan_interval'] = "day";

    if($_POST['payment_method_id'] == "wallet"){
        $_SESSION['quickad'][$access_token]['folder'] = "wallet";
        $amount = $_SESSION['quickad'][$access_token]['amount'];
        $user_data = get_user_data(null,$_SESSION['user']['id']);
        $user_balance = $user_data['balance'];
        if($user_balance < $amount)
        {
            $message = __("Số tiền trong ví phải lớn hơn").' '.$config['currency_sign'].$amount.'.';
          $user_balance = $user_data['balance'];  error($message, __LINE__, __FILE__, 1);
            exit();
        }
        else {
            $deducted = $user_balance - $amount;
            //Minus From Employer Account
            $user_update = ORM::for_table($config['db']['pre'] . 'user')->find_one($_SESSION['user']['id']);
            $user_update->set('balance', $deducted);
            $user_update->save();
        }
        /*Success*/
        payment_success_save_detail($access_token);
        exit();
    }


    if (isset($payment_type)) {
        $info = ORM::for_table($config['db']['pre'].'payments')
            ->where(array(
                'payment_id' => $_POST['payment_method_id'],
                'payment_install' => '1'
            ))
            ->find_one();
        $now = time();      
        $folder = $info['payment_folder'];
        $user_data = get_user_data(null,$_SESSION['user']['id']);
        $_SESSION['quickad'][$access_token]['folder'] = $folder;
        $amount = $_SESSION['quickad'][$access_token]['amount'];
        $user_balance = $user_data['balance'];
        $deducted = $user_balance + $amount;
        //Deposit to wallet
        $user_update = ORM::for_table($config['db']['pre'] . 'user')->find_one($_SESSION['user']['id']);
        $user_update->set('balance', $deducted);
        $user_update->save();
        $ip = encode_ip($_SERVER, $_ENV);
        $insert_trans = ORM::for_table($config['db']['pre'].'transaction')->create();
        $insert_trans->status = 'success';
        $insert_trans->	product_name = 'Nạp tiền vào ví';
        // $insert_trans->product_id = ;
        $insert_trans->user_id = $_SESSION['user']['id'];
        $insert_trans->amount = $amount;
        // $insert_trans->base_amount = validate_input($_POST['email']);
        $insert_trans->currency_code = $config['currency_code'];
        // $insert_trans->featured = validate_input($_POST['sex']);
        // $insert_trans->urgent = validate_input($_POST['country']);
        // $insert_trans->highlight = $image_name;
        $insert_trans->transaction_time = $now;
        $insert_trans->transaction_gatway = 'paypal';
        $insert_trans->transaction_ip = $ip;
        $insert_trans->transaction_description = 'Nạp tiền vào ví';
        $insert_trans->transaction_method = $payment_type;
        // $insert_trans->frequency = $now;
        // $insert_trans->billing = $now;
        // $insert_trans->taxes_ids = $now;
        // $insert_trans->details = $now;
        $insert_trans->save();
        message(__("Success"),__("Nạp tiền vào ví thành công"),'/jobs/dashboard',true);
        exit;
    }else{

        error(__("Invalid Payment Processor"), __LINE__, __FILE__, 1);
        exit();
    }
}
else if(isset($_GET['access_token'])) {
    $access_token = $_GET['access_token'];
    if (isset($_SESSION['quickad'][$access_token]['payment_type'])) {
        $_SESSION['quickad'][$access_token]['name'];
        $_SESSION['quickad'][$access_token]['payment_type'];
        $payment_types = array();

        $rows = ORM::for_table($config['db']['pre'].'payments')
            ->where('payment_install', '1')
            ->find_many();
        foreach ($rows as $info)
        {
            $payment_image = $config['site_url']."includes/payments/".$info['payment_folder']."/logo/logo.png";
            $payment_types[$info['payment_id']]['id'] = $info['payment_id'];
            $payment_types[$info['payment_id']]['title'] = $info['payment_title'];
            $payment_types[$info['payment_id']]['folder'] = $info['payment_folder'];
            $payment_types[$info['payment_id']]['desc'] = $info['payment_desc'];
            $payment_types[$info['payment_id']]['image'] = $payment_image;
        }

        $product_id = $_SESSION['quickad'][$access_token]['product_id'];
        $amount = $_SESSION['quickad'][$access_token]['amount'];
        $title = $_SESSION['quickad'][$access_token]['name'];
        $trans_desc = $_SESSION['quickad'][$access_token]['trans_desc'];
        $payment_type = $_SESSION['quickad'][$access_token]['payment_type'];
        // assign posted variables to local variables
        $bank_information = nl2br(get_option('company_bank_info'));
        $userdata = get_user_data($_SESSION['user']['username']);
        $email = $userdata['email'];
        $balance = $userdata['balance'];
        //Print Template
        HtmlTemplate::display('global/payment', array(
            'payment_types' => $payment_types,
            'bank_info' => $bank_information,
            'order_title' => $title,
            'order_desc' => $trans_desc,
            'amount' => $amount,
            'price' => $amount,
            'user_balance' => $balance,
            'email' => $email,
            'payment_type' => $payment_type,
            'country_code' => strtoupper(check_user_country()),
            'stripe_publishable_key' => isset($config['stripe_publishable_key'])? $config['stripe_publishable_key']: '',
            'paystack_public_key' => isset($config['paystack_public_key'])? $config['paystack_public_key']: '',
            'sandbox_mode_2checkout' => isset($config['2checkout_sandbox_mode'])? $config['2checkout_sandbox_mode']: '',
            'checkout_account_number' => isset($config['checkout_account_number'])? $config['checkout_account_number']: '',
            'checkout_public_key' => isset($config['checkout_public_key'])? $config['checkout_public_key']: '',
            'token' => $access_token
        ));
        exit;
    }
    else{
        error(__("Invalid Payment Processor"), __LINE__, __FILE__, 1);
        exit();
    }
}
else
{
    error(__("Page Not Found"), __LINE__, __FILE__, 1);
    exit();
}

?>