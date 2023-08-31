<?php
/**
 * Check if user can manage admin (Used for demo)
 *
 * @return bool
 */
function check_allow()
{
    if(isset($_SESSION['admin']['id']) && $_SESSION['admin']['id'] == 1)
    {
        return TRUE;
    }
    else
    {
        return TRUE;
    }
}

/**
 * Start admin session
 */
function admin_session_start() {
    define("CAN_REGISTER", "no");
    define("DEFAULT_ROLE", "admin");
    define("SECURE", FALSE);    // FOR DEVELOPMENT ONLY!!!!
    $session_name = 'sec_session_id';   // Set a custom session name
    $secure = SECURE;
    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
    // Sets the session name to the one set above.
    session_name($session_name);
    session_start();            // Start the PHP session
    session_regenerate_id();    // regenerated the session, delete the old one.
}

/**
 * Check admin logged in
 *
 * @return bool|void
 */
function checkloggedadmin(){

    global $config,$password;
    $mysqli = db_connect();
    // Check if all session variables are set
    if (isset($_SESSION['admin']['id'],
        $_SESSION['admin']['username'],
        $_SESSION['admin']['login_string']))
    {
        $user_id = $_SESSION['admin']['id'];
        $login_string = $_SESSION['admin']['login_string'];
        $username = $_SESSION['admin']['username'];

        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        if ($stmt = $mysqli->prepare("SELECT password_hash FROM `".$config['db']['pre']."admins` WHERE id = ? LIMIT 1")) {
            // Bind "$user_id" to parameter.
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                // If the user exists get variables from result.
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);

                if (hash_equals($login_check, $login_string) ){
                    // Logged In!!!!
                    return true;
                } else {
                    // Not logged in
                    return false;
                }
            } else {
                // Not logged in
                return false;
            }
        } else {
            // Not logged in
            return false;
        }
    }

    // check user login via cookie, if the session variable expired
    if(!empty($_COOKIE["qarm"])){
        $hash = explode(".", $_COOKIE["qarm"], 2);

        if (count($hash) == 2) {
            $count = ORM::for_table($config['db']['pre'].'admins')
                ->where('id', $hash[0])
                ->count();
            if($count){
                $admin = ORM::for_table($config['db']['pre'].'admins')
                    ->select_many('id','username','password_hash','permission')
                    ->where('id', $hash[0])
                    ->find_one();

                $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
                $login_string = hash('sha512', $admin['password_hash'] . $user_browser);
                if (hash_equals($login_string,$hash[1]))
                {
                    // update cookie expire time
                    setcookie("qarm", $admin['id'].".".$login_string, time()+86400*30, "/");
                    // update session data
                    $_SESSION['admin']['id']  = $admin['id'];
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $admin['username']); // XSS protection as we might print this value
                    $_SESSION['admin']['username'] = $username;
                    $_SESSION['admin']['login_string'] = $login_string;

                    // Logged In!!!!
                    return true;
                }
            }
        }
    }

    // Not logged in
    return false;
}

/**
 * Admin login
 *
 * @param string $email
 * @param string $password
 * @return bool|void
 */
function adminlogin($email,$password){

    global $config, $user_id, $username,  $db_password, $where;
    $mysqli = db_connect();

    $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';

    if(!preg_match("/^[[:alnum:]]+$/", $email))
    {
        if(!preg_match($regex,$email))
        {
            return false;
        }
        else{
            //checking in email
            $where = " WHERE email = ? ";
        }
    }
    else{
        //checking in username
        $where = " WHERE username = ? ";
    }

    // Using prepared statements means that SQL injection is not possible.
    $sql = "SELECT id, username, password_hash, permission 
        FROM `".$config['db']['pre']."admins`
        $where
        LIMIT 1";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param('s', $email);  // Bind "$email" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();

        // get variables from result.
        $stmt->bind_result($user_id, $username, $db_password, $permission);
        $stmt->fetch();

        if ($stmt->num_rows == 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts

            // Check if the password in the database matches
            // the password the user submitted. We are using
            // the password_verify function to avoid timing attacks.
            if (password_verify($password, $db_password)) {
                // Password is correct!
                // Login successful.
                $user_browser = $_SERVER['HTTP_USER_AGENT']; // Get the user-agent string of the user.
                $user_id = preg_replace("/[^0-9]+/", "", $user_id); // XSS protection as we might print this value
                $_SESSION['admin']['id']  = $user_id;
                $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username); // XSS protection as we might print this value
                $_SESSION['admin']['username'] = $username;
                $_SESSION['admin']['login_string'] = hash('sha512', $db_password . $user_browser);

                $_SESSION['admin']['permission']  = $permission;

                setcookie("qarm", $user_id.".".$_SESSION['admin']['login_string'], time()+86400*30, "/");

                return true;

            } else {
                // Password is not correct
                return false;
            }
        } else {
            // No user exists.
            return false;
        }
    }

}

function validation_attempt_exceed(){
    $number = get_option("validation_attempt");
    if($number == NULL){
        $number = 1;
    }else{
        $number++;
    }

    if($number <= 5){
        update_option("validation_attempt",$number);
        return false;
    } else{
        update_option("validation_attempt",0);
        return true;
    }
}

/**
 * After transaction status changed to success
 *
 * @param int $transaction_id
 * @return bool|void
 */
function transaction_success($transaction_id){

    global $config;
    $mysqli = db_connect();

    $result = $mysqli->query("SELECT * FROM `".$config['db']['pre']."transaction` WHERE `id` = '" . $transaction_id . "' LIMIT 1");
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        $info = mysqli_fetch_assoc($result);

        $item_pro_id = $info['product_id'];
        $user_id = $info['user_id'];
        $item_amount = $info['amount'];
        $trans_title = $info['product_name'];
        $trans_desc = $info['transaction_description'];

        if($info['transaction_method'] == 'membership'){
            $subcription_id = $item_pro_id;
            $plan_interval = $info['frequency'];

            // Check that the payment is valid
            $subsc_details = mysqli_fetch_array(mysqli_query($mysqli,"SELECT * FROM ".$config['db']['pre']."plans WHERE id='".validate_input($subcription_id)."' LIMIT 1"));

            $term = 0;
            if($plan_interval == 'MONTHLY') {
                $term = 2678400;
            }elseif($plan_interval == 'YEARLY') {
                $term = 31536000;
            }elseif($plan_interval == 'LIFETIME') {
                $term = 3153600000;
            }

            $sub_group_id = $subsc_details['id'];

            // Check valid user
            $user_check = mysqli_num_rows(mysqli_query($mysqli,"SELECT 1 FROM ".$config['db']['pre']."user WHERE id='".validate_input($user_id)."' LIMIT 1"));

            if(!$user_check)
            {
                exit('error, user does not exist');
            }

            $subsc_check = mysqli_num_rows(mysqli_query($mysqli,"select * from `".$config['db']['pre']."upgrades` WHERE `user_id` = '".validate_input($user_id)."' LIMIT 1 ;"));

            if($subsc_check == 1)
            {
                $txn_type = 'subscr_update';
            }
            else
            {
                $txn_type = 'subscr_signup';
            }

            // Add time to their subscription
            $expires = (time()+$term);

            if($txn_type == 'subscr_update')
            {
                mysqli_query($mysqli,"UPDATE `".$config['db']['pre']."upgrades` SET `sub_id` = '".validate_input($subcription_id)."',`upgrade_expires` = '".validate_input($expires)."' WHERE `user_id` = '".validate_input($user_id)."' LIMIT 1 ");

                mysqli_query($mysqli,"UPDATE `".$config['db']['pre']."user` SET `group_id` = '".validate_input($sub_group_id)."' WHERE `id` = '".validate_input($user_id)."' LIMIT 1 ;");

            }elseif($txn_type == 'subscr_signup')
            {
                mysqli_query($mysqli,"INSERT INTO `".$config['db']['pre']."upgrades` (`sub_id` ,`user_id` ,`upgrade_lasttime` ,`upgrade_expires`) VALUES ('".validate_input($subcription_id)."', '".validate_input($user_id)."', '".time()."','".validate_input($expires)."')") OR error(mysqli_error($mysqli));

                mysqli_query($mysqli,"UPDATE `".$config['db']['pre']."user` SET `group_id` = '".validate_input($sub_group_id)."' WHERE `id` = '".validate_input($user_id)."' LIMIT 1 ;");
            }


        }
        elseif($info['transaction_method'] == 'deposit'){
            $user = ORM::for_table($config['db']['pre'] . 'user')
                ->select('balance')
                ->find_one($user_id);
            $balance = $user['balance'];
            $add_balance = $balance + $item_amount;

            $user = ORM::for_table($config['db']['pre'] . 'user')->find_one($user_id);
            $user->set('balance', $add_balance);
            $user->save();
        }
        else{
            $item_featured = $info['featured'];
            $item_urgent = $info['urgent'];
            $item_highlight = $info['highlight'];

            if($item_featured == 1){
                $mysqli->query("UPDATE ". $config['db']['pre'] . "product set featured = '$item_featured' where id='".$item_pro_id."' LIMIT 1");
            }
            if($item_urgent == 1){
                $mysqli->query("UPDATE ". $config['db']['pre'] . "product set urgent = '$item_urgent' where id='".$item_pro_id."' LIMIT 1");
            }
            if($item_highlight == 1){
                $mysqli->query("UPDATE ". $config['db']['pre'] . "product set highlight = '$item_highlight' where id='".$item_pro_id."' LIMIT 1");
            }

            $query = "SELECT 1 FROM ".$config['db']['pre']."product_resubmit WHERE product_id='" . $item_pro_id . "' and user_id='" . $user_id . "' LIMIT 1";
            $query_result = mysqli_query(db_connect(), $query);
            $num_rows = mysqli_num_rows($query_result);
            if($num_rows == 1){
                if($item_featured == 1){
                    $mysqli->query("UPDATE ". $config['db']['pre'] . "product_resubmit set featured = '$item_featured' where product_id='".$item_pro_id."' LIMIT 1");
                }
                if($item_urgent == 1){
                    $mysqli->query("UPDATE ". $config['db']['pre'] . "product_resubmit set urgent = '$item_urgent' where product_id='".$item_pro_id."' LIMIT 1");
                }
                if($item_highlight == 1){
                    $mysqli->query("UPDATE ". $config['db']['pre'] . "product_resubmit set highlight = '$item_highlight' where product_id='".$item_pro_id."' LIMIT 1");
                }
            }
        }

        //Transaction status Updating "Success"
        $mysqli->query("UPDATE ". $config['db']['pre'] . "transaction set status = 'success' where id='".$transaction_id."' LIMIT 1");

        //Add Amount in balance table
        $result2 = $mysqli->query("SELECT * FROM `".$config['db']['pre']."balance` WHERE id = '1' LIMIT 1");
        if (mysqli_num_rows($result2) > 0) {
            $info2 = mysqli_fetch_assoc($result2);
            $current_amount=$info2['current_balance'];
            $total_earning=$info2['total_earning'];

            $updated_amount=($item_amount+$current_amount);
            $total_earning=($item_amount+$total_earning);

            $mysqli->query("UPDATE ". $config['db']['pre'] . "balance set current_balance = '" . $updated_amount . "', total_earning = '" . $total_earning . "' where id='1' LIMIT 1");
        }
        return true;
    }
    else{
        return false;
    }
}

/**
 * Get all variables from the language file
 *
 * @param string $filePath
 * @return array
 */
function getLanguageFileVariable($filePath){
    $lang = array();
    if(file_exists($filePath)){
        include_once $filePath;
    }
    return $lang;
}
