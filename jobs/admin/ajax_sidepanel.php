<?php
/*
Copyright (c) 2023 Bylancer.com
*/
define("ROOTPATH", dirname(__DIR__));
define("APPPATH", ROOTPATH."/php/");

require_once ROOTPATH . '/includes/autoload.php';
require_once ROOTPATH . '/includes/lang/lang_'.$config['lang'].'.php';
global $config, $lang, $link;

admin_session_start();
checkloggedadmin();

if (!isset($_SESSION['admin']['id'])) {
    exit('Access Denied.');
}

//SidePanel Ajax Function
if(isset($_GET['action'])){
    if(!check_allow()){
        $status = "Sorry:";
        $message = __("Permission denied for demo.");
        echo $json = '{"status" : "' . $status . '","message" : "' . $message . '"}';
        die();
    }

    if ($_GET['action'] == "addAdmin") { addAdmin(); }
    if ($_GET['action'] == "editAdmin") { editAdmin(); }
    if ($_GET['action'] == "addUser") { addUser(); }
    if ($_GET['action'] == "editUser") { editUser(); }

    if ($_GET['action'] == "addMembershipPlan") { addMembershipPlan(); }
    if ($_GET['action'] == "editMembershipPlan") { editMembershipPlan(); }

    if ($_GET['action'] == "addFAQentry") { addFAQentry(); }
    if ($_GET['action'] == "editFAQentry") { editFAQentry(); }

    if ($_GET['action'] == "expirePostRenew") { expirePostRenew(); }
    if ($_GET['action'] == "postEdit") { postEdit(); }
    if ($_GET['action'] == "transactionEdit") { transactionEdit(); }
    if ($_GET['action'] == "withdrawEdit") { withdrawEdit(); }
    if ($_GET['action'] == "advertiseEdit") { advertiseEdit(); }

    if ($_GET['action'] == "SaveSettings") { SaveSettings(); }
    if ($_GET['action'] == "saveEmailTemplate") { saveEmailTemplate(); }

    if ($_GET['action'] == "companyEdit") { companyEdit(); }

    if ($_GET['action'] == "addTestimonial") { addTestimonial(); }
    if ($_GET['action'] == "editTestimonial") { editTestimonial(); }

}

function companyEdit(){
    global $config,$lang;
    $errors = array();
    $response = array();

    if (isset($_POST['id'])) {

        if (empty($_POST['title'])) {
            $errors[]['message'] = __("Company Name Required.");
        }
        if (empty($_POST['content'])) {
            $errors[]['message'] = __("Company Description Required.");
        }

        if (!count($errors) > 0) {

            if($config['post_desc_editor'] == 1)
                $description = addslashes($_POST['content']);
            else
                $description = validate_input($_POST['content']);

            $now = date("Y-m-d H:i:s");

            $item_edit = ORM::for_table($config['db']['pre'].'companies')->find_one($_POST['id']);
            $item_edit->set('name', $_POST['title']);
            $item_edit->set('city', $_POST['city']);
            $item_edit->set('state', $_POST['state']);
            $item_edit->set('country', $_POST['country']);
            $item_edit->set('description', $description);
            $item_edit->set('phone', $_POST['phone']);
            $item_edit->set('fax', $_POST['fax']);
            $item_edit->set('email', $_POST['email']);
            $item_edit->set('website', $_POST['website']);
            $item_edit->set('facebook', $_POST['facebook']);
            $item_edit->set('twitter', $_POST['twitter']);
            $item_edit->set('linkedin', $_POST['linkedin']);
            $item_edit->set('pinterest', $_POST['pinterest']);
            $item_edit->set('youtube', $_POST['youtube']);
            $item_edit->set('instagram', $_POST['instagram']);
            $item_edit->set('updated_at', $now);
            $item_edit->save();

            $status = "success";
            $message = __("Lưu thành công.");

            echo $json = '{"status" : "' . $status . '","message" : "' . $message . '"}';
            die();
        }else {
            $status = "error";
            $message = __("Error: Please try again.");
        }
    } else {
        $status = "error";
        $message = __("Error: Please try again.");
    }

    $json = '{"status" : "' . $status . '","message" : "' . $message . '","errors" : ' . json_encode($errors, JSON_UNESCAPED_SLASHES) . '}';
    echo $json;
    die();
}

function addTestimonial(){
    global $lang,$config;

    $title = validate_input($_POST['name']);
    $designation = validate_input($_POST['designation']);
    $image = null;
    $description = validate_input($_POST['content']);
    $error = array();

    if(empty($title)){
        $error[] = "Name is required.";
    }
    if(empty($designation)){
        $error[] = "Designation is required.";
    }
    if(empty($description)){
        $error[] = "Content is required.";
    }

    if(empty($error)){
        $target_dir = ROOTPATH . "/storage/testimonials/";
        $result = quick_file_upload('image',$target_dir);
        if($result['success']){
            $image = $result['file_name'];
            resizeImage(100, $target_dir . $image, $target_dir . $image);
        }else{
            $error[] = $result['error'];
        }
    }

    if (empty($error)) {
        $test = ORM::for_table($config['db']['pre'].'testimonials')->create();
        $test->name = $title;
        $test->designation = $designation;
        $test->image = $image;
        $test->content = $description;
        $test->save();

        $status = "success";
        $message = __("Lưu thành công.");

        echo $json = '{"status" : "' . $status . '","message" : "' . $message . '"}';
        die();
    } else {
        $status = "error";
        $message = __("Error: Please try again.");
    }
    $json = '{"status" : "' . $status . '","message" : "' . $message . '","errors" : ' . json_encode($error, JSON_UNESCAPED_SLASHES) . '}';
    echo $json;
    die();
}

function editTestimonial(){
    global $lang,$config;

    $title = validate_input($_POST['name']);
    $designation = validate_input($_POST['designation']);
    $image = null;
    $description = validate_input($_POST['content']);
    $error = array();

    if(empty($title)){
        $error[] = "Name is required.";
    }
    if(empty($designation)){
        $error[] = "Designation is required.";
    }
    if(empty($description)){
        $error[] = "Content is required.";
    }

    if(empty($error)){
        $target_dir = ROOTPATH . "/storage/testimonials/";
        $result = quick_file_upload('image',$target_dir);
        if($result['success']){
            $image = $result['file_name'];
            resizeImage(100, $target_dir . $image, $target_dir . $image);
            // remove old image
            $info = ORM::for_table($config['db']['pre'].'testimonials')
                ->select('image')
                ->find_one($_POST['id']);

            if($info['image'] != "default.png"){
                if(file_exists($target_dir.$info['image'])){
                    unlink($target_dir.$info['image']);
                }
            }
        }else{
            $error[] = $result['error'];
        }
    }

    if (empty($error)) {
        $test = ORM::for_table($config['db']['pre'].'testimonials')->find_one($_POST['id']);
        $test->name = $title;
        $test->designation = $designation;
        if($image){
            $test->image = $image;
        }
        $test->content = $description;
        $test->save();

        $status = "success";
        $message = __("Lưu thành công.");

        echo $json = '{"status" : "' . $status . '","message" : "' . $message . '"}';
        die();
    } else {
        $status = "error";
        $message = __("Error: Please try again.");
    }
    $json = '{"status" : "' . $status . '","message" : "' . $message . '","errors" : ' . json_encode($error, JSON_UNESCAPED_SLASHES) . '}';
    echo $json;
    die();
}

function change_config_file_settings($filePath, $newSettings,$lang)
{
    // Update $fileSettings with any new values
    $fileSettings = array_merge($lang, $newSettings);
    // Build the new file as a string
    $newFileStr = "<?php\n";
    foreach ($fileSettings as $name => $val) {
        // Using var_export() allows you to set complex values such as arrays and also
        // ensures types will be correct
        $newFileStr .= '$lang["'.$name.'"] = "' . $val .'"'. ";\n";
    }
    // Closing tag intentionally omitted, you can add one if you want

    // Write it back to the file
    file_put_contents($filePath, $newFileStr);

}

function addAdmin(){
    global $config,$lang;

    if (isset($_POST['submit'])) {
        $target_dir = ROOTPATH . "/storage/profile/";
        $result = quick_file_upload('file',$target_dir);
        if($result['success']){
            $image = $result['file_name'];
            resizeImage(100, $target_dir . $image, $target_dir . $image);

            $password = $_POST["password"];
            $pass_hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 13]);

            $admins = ORM::for_table($config['db']['pre'].'admins')->create();
            $admins->username = validate_input($_POST['username']);
            $admins->password_hash = $pass_hash;
            $admins->name = validate_input($_POST['name']);
            $admins->email = validate_input($_POST['email']);
            $admins->image = $image;
            $admins->save();

            if ($admins->id()) {
                $status = "success";
                $message = __("Lưu thành công.");
            } else{
                $status = "error";
                $message = __("Error: Please try again.");
            }
        }else{
            $status = "error";
            $message = $result['error'];
        }

    } else {
        $status = "error";
        $message = __("Error: Please try again.");
    }

    echo $json = '{"status" : "' . $status . '","message" : "' . $message . '"}';
    die();
}
function editAdmin(){
    global $config,$lang;

    if (isset($_POST['id'])) {
        $password = $_POST["newPassword"];
        $status = "";
        if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {
            $target_dir = ROOTPATH . "/storage/profile/";
            $result = quick_file_upload('file',$target_dir);
            if($result['success']) {
                $image = $result['file_name'];
                resizeImage(100, $target_dir . $image, $target_dir . $image);
                // remove old image
                $info = ORM::for_table($config['db']['pre'].'admins')
                    ->select('image')
                    ->find_one(validate_input($_POST['id']));

                if ($info['image'] != "default_user.png") {
                    if (file_exists($target_dir . $info['image'])) {
                        unlink($target_dir . $info['image']);
                    }
                }
            }else{
                $status = "error";
                $message = $result['error'];
                echo $json = '{"status" : "' . $status . '","message" : "' . $message . '"}';
                die();
            }

        }


        if($status != "error"){
            if(!empty($password)){
                $pass_hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 13]);
            }
            $admins = ORM::for_table($config['db']['pre'].'admins')->find_one($_POST['id']);
            $admins->name = validate_input($_POST['name']);
            if(!empty($password))
                $admins->password_hash = $pass_hash;
            if(isset($image))
                $admins->image = $image;
            $admins->username = validate_input($_POST["username"]);
            $admins->save();

            if (!$admins) {
                $status = "error";
                $message = __("Error: Please try again.");
            } else{
                $status = "success";
                $message = __("Lưu thành công.");
            }
        }else{
            $status = "error";
            $message = __("Error: Please try again.");
        }
    } else {
        $status = "error";
        $message = __("Error: Please try again.");
    }

    echo $json = '{"status" : "' . $status . '","message" : "' . $message . '"}';
    die();
}

function addUser(){
    global $config,$lang;

    if (isset($_POST['submit'])) {

        $valid_formats = array("jpg","jpeg","png"); // Valid image formats

        if(isset($_FILES['file']['name']))
        {
            $valid_formats = array("jpg","jpeg","png"); // Valid image formats
            $filename = stripslashes($_FILES['file']['name']);
            $ext = getExtension($filename);
            $ext = strtolower($ext);
            //File extension check
            if (in_array($ext, $valid_formats)) {
                $uploaddir = '../storage/profile/';
                $original_filename = $_FILES['file']['name'];
                $random1 = rand(9999,100000);
                $random2 = rand(9999,200000);
                $username = $_POST['username'];
                $image_name = $username.'_'.$random1.$random2.'.'.$ext;

                $filename = $uploaddir . $image_name;

                $uploadedfile = $_FILES['file']['tmp_name'];

                //else if it's not bigger then 0, then it's available '
                //and we send 1 to the ajax request
                if (resizeImage(200, $filename, $uploadedfile)) {
                    $password = $_POST["password"];
                    $pass_hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 13]);
                    $now = date("Y-m-d H:i:s");

                    $insert_user = ORM::for_table($config['db']['pre'].'user')->create();
                    $insert_user->status = '0';
                    $insert_user->name = validate_input($_POST['name']);
                    $insert_user->username = validate_input($_POST['username']);
                    $insert_user->user_type = validate_input($_POST['user_type']);
                    $insert_user->password_hash = $pass_hash;
                    $insert_user->about = validate_input($_POST['about']);
                    $insert_user->email = validate_input($_POST['email']);
                    $insert_user->sex = validate_input($_POST['sex']);
                    $insert_user->description = validate_input($_POST['sex']);
                    $insert_user->country = validate_input($_POST['country']);
                    $insert_user->image = $image_name;
                    $insert_user->created_at = $now;
                    $insert_user->updated_at = $now;
                    $insert_user->save();

                    if ($insert_user->id()) {
                        $status = "success";
                        $message = __("Lưu thành công.");
                    } else{
                        $status = "error";
                        $message = __("Error: Please try again.");
                    }
                }
            }
            else {
                $error = __("Only allowed jpg, jpeg png");
                $status = "error";
                $message = $error;
            }

        } else {
            $error = __("Profile Picture Required");
            $status = "error";
            $message = $error;
        }

    } else {
        $status = "error";
        $message = __("Error: Please try again.");
    }

    echo $json = '{"status" : "' . $status . '","message" : "' . $message . '"}';
    die();
}
function editUser(){
    global $config,$lang;

    if (isset($_POST['id'])) {
        $password = $_POST["password"];

        if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != "")
        {
            $valid_formats = array("jpg","jpeg","png"); // Valid image formats
            $filename = stripslashes($_FILES['file']['name']);
            $ext = getExtension($filename);
            $ext = strtolower($ext);
            //File extension check
            if (in_array($ext, $valid_formats)) {
                $uploaddir = '../storage/profile/';
                $original_filename = $_FILES['file']['name'];
                $random1 = rand(9999,100000);
                $random2 = rand(9999,200000);

                $image_name = $random1.$random2.'.'.$ext;

                $filename = $uploaddir . $image_name;

                $uploadedfile = $_FILES['file']['tmp_name'];

                //else if it's not bigger then 0, then it's available '
                //and we send 1 to the ajax request
                if (resizeImage(200, $filename, $uploadedfile)) {

                    $info = ORM::for_table($config['db']['pre'].'user')
                        ->select('image')
                        ->find_one($_POST['id']);

                    if($info['image'] != "default_user.png"){
                        if(file_exists($uploaddir.$info['image'])){
                            unlink($uploaddir.$info['image']);
                        }
                    }

                    if(!empty($password)){
                        $pass_hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 13]);

                        $now = date("Y-m-d H:i:s");
                        $user_update = ORM::for_table($config['db']['pre'].'user')->find_one($_POST['id']);
                        $user_update->set('name', validate_input($_POST['name']));
                        $user_update->set('username', validate_input($_POST['username']));
                        $user_update->set('email', validate_input($_POST['email']));
                        $user_update->set('status', validate_input($_POST['status']));
                        $user_update->set('description', validate_input($_POST['about']));
                        $user_update->set('sex', validate_input($_POST['sex']));
                        $user_update->set('country', validate_input($_POST['country']));
                        $user_update->set('password_hash', $pass_hash);
                        $user_update->set('image', $image_name);
                        $user_update->set('updated_at', $now);
                        $user_update->save();

                    }else{
                        $now = date("Y-m-d H:i:s");
                        $user_update = ORM::for_table($config['db']['pre'].'user')->find_one($_POST['id']);
                        $user_update->set('name', validate_input($_POST['name']));
                        $user_update->set('username', validate_input($_POST['username']));
                        $user_update->set('email', validate_input($_POST['email']));
                        $user_update->set('status', validate_input($_POST['status']));
                        $user_update->set('description', validate_input($_POST['about']));
                        $user_update->set('sex', validate_input($_POST['sex']));
                        $user_update->set('country', validate_input($_POST['country']));
                        $user_update->set('image', $image_name);
                        $user_update->set('updated_at', $now);
                        $user_update->save();
                    }

                    if ($user_update) {
                        $status = "success";
                        $message = __("Lưu thành công.");
                    } else{
                        $status = "error";
                        $message = __("Error: Please try again.");
                    }
                }
            }
            else {
                $error = __("Only allowed jpg, jpeg png");
                $status = "error";
                $message = $error;
            }

        }
        else{
            if(!empty($password)){
                $pass_hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 13]);
                $now = date("Y-m-d H:i:s");

                $user_update = ORM::for_table($config['db']['pre'].'user')->find_one($_POST['id']);
                $user_update->set('name', validate_input($_POST['name']));
                $user_update->set('username', validate_input($_POST['username']));
                $user_update->set('email', validate_input($_POST['email']));
                $user_update->set('status', validate_input($_POST['status']));
                $user_update->set('description', validate_input($_POST['about']));
                $user_update->set('sex', validate_input($_POST['sex']));
                $user_update->set('country', validate_input($_POST['country']));
                $user_update->set('password_hash', $pass_hash);
                $user_update->set('updated_at', $now);
                $user_update->save();

            }else{
                $now = date("Y-m-d H:i:s");

                $user_update = ORM::for_table($config['db']['pre'].'user')->find_one($_POST['id']);
                $user_update->set('name', validate_input($_POST['name']));
                $user_update->set('username', validate_input($_POST['username']));
                $user_update->set('email', validate_input($_POST['email']));
                $user_update->set('status', validate_input($_POST['status']));
                $user_update->set('description', validate_input($_POST['about']));
                $user_update->set('sex', validate_input($_POST['sex']));
                $user_update->set('country', validate_input($_POST['country']));
                $user_update->set('updated_at', $now);
                $user_update->save();
            }


            if ($user_update) {
                $status = "success";
                $message = __("Lưu thành công.");
            } else{
                $status = "error";
                $message = __("Error: Please try again.");
            }
        }
    } else {
        $status = "error";
        $message = __("Error: Please try again.");
    }

    echo $json = '{"status" : "' . $status . '","message" : "' . $message . '"}';
    die();
}

function addMembershipPlan()
{
    global $config,$lang;

    if (isset($_POST['submit'])) {

        $recommended = isset($_POST['recommended']) ? "yes" : "no";
        $active = isset($_POST['active']) ? 1 : 0;

        $service_commission = isset($_POST['service_seller_commission']) ? $_POST['service_seller_commission'] : 0;
        $employer_commission = isset($_POST['employer_commission']) ? $_POST['employer_commission'] : 0;
        $freelancer_commission = isset($_POST['freelancer_commission']) ? $_POST['freelancer_commission'] : 0;
        $bids = isset($_POST['bids']) ? $_POST['bids'] : 0;
        $skills = isset($_POST['skills']) ? $_POST['skills'] : 0;

        $featured = isset($_POST['featured_project_fee']) ? $_POST['featured_project_fee'] : 0;
        $urgent = isset($_POST['urgent_project_fee']) ? $_POST['urgent_project_fee'] : 0;
        $highlight = isset($_POST['highlight_project_fee']) ? $_POST['highlight_project_fee'] : 0;

        $featured_duration = isset($_POST['featured_duration']) ? $_POST['featured_duration'] : 0;
        $urgent_duration = isset($_POST['urgent_duration']) ? $_POST['urgent_duration'] : 0;
        $highlight_duration = isset($_POST['highlight_duration']) ? $_POST['highlight_duration'] : 0;

        $top_search_result = isset($_POST['top_search_result']) ? "yes" : "no";
        $show_on_home = isset($_POST['show_on_home']) ? "yes" : "no";
        $show_in_home_search = isset($_POST['show_in_home_search']) ? "yes" : "no";

        $settings = array(
            'service_seller_commission' => (int) validate_input($service_commission),
            'employer_commission' => (int) validate_input($employer_commission),
            'freelancer_commission' => (int) validate_input($freelancer_commission),
            'bids' => (int) validate_input($bids),
            'skills' => (int) validate_input($skills),
            'ad_limit' => (int) $_POST['ad_limit'],
            'ad_duration' => (int) $_POST['ad_duration'],
            'featured_project_fee' => (int) $featured,
            'featured_duration' => (int) $featured_duration,
            'urgent_project_fee' => (int) $urgent,
            'urgent_duration' => (int) $urgent_duration,
            'highlight_project_fee' => (int) $highlight,
            'highlight_duration' => (int) $highlight_duration,
            'top_search_result' => $top_search_result,
            'show_on_home' => $show_on_home,
            'show_in_home_search' => $show_in_home_search,
            'custom' => array()
        );

        $insert_subscription = ORM::for_table($config['db']['pre'].'plans')->create();
        $insert_subscription->name = validate_input($_POST['name']);
        $insert_subscription->badge = $_POST['badge'];
        $insert_subscription->monthly_price = validate_input($_POST['monthly_price']);
        $insert_subscription->annual_price = validate_input($_POST['annual_price']);
        $insert_subscription->lifetime_price = validate_input($_POST['lifetime_price']);
        $insert_subscription->settings = json_encode($settings);
        $insert_subscription->status = $active;
        $insert_subscription->recommended = $recommended;
        $insert_subscription->date = date('Y-m-d H:i:s');
        $insert_subscription->save();

        if ($insert_subscription->id()) {
            $status = "success";
            $message = __("Lưu thành công.");
        } else{
            $status = "error";
            $message = __("Error: Please try again.");
        }

    } else {
        $status = "error";
        $message = __("Error: Please try again.");
    }

    echo $json = '{"status" : "' . $status . '","message" : "' . $message . '"}';
    die();
}

function editMembershipPlan()
{
    global $config;

    if (isset($_POST['submit'])) {
        $active = isset($_POST['active']) ? 1 : 0;

        $service_commission = isset($_POST['service_seller_commission']) ? $_POST['service_seller_commission'] : 0;
        $employer_commission = isset($_POST['employer_commission']) ? $_POST['employer_commission'] : 0;
        $freelancer_commission = isset($_POST['freelancer_commission']) ? $_POST['freelancer_commission'] : 0;
        $bids = isset($_POST['bids']) ? $_POST['bids'] : 0;
        $skills = isset($_POST['skills']) ? $_POST['skills'] : 0;

        $featured = isset($_POST['featured_project_fee']) ? $_POST['featured_project_fee'] : 0;
        $urgent = isset($_POST['urgent_project_fee']) ? $_POST['urgent_project_fee'] : 0;
        $highlight = isset($_POST['highlight_project_fee']) ? $_POST['highlight_project_fee'] : 0;

        $featured_duration = isset($_POST['featured_duration']) ? $_POST['featured_duration'] : 0;
        $urgent_duration = isset($_POST['urgent_duration']) ? $_POST['urgent_duration'] : 0;
        $highlight_duration = isset($_POST['highlight_duration']) ? $_POST['highlight_duration'] : 0;

        $top_search_result = isset($_POST['top_search_result']) ? "yes" : "no";
        $show_on_home = isset($_POST['show_on_home']) ? "yes" : "no";
        $show_in_home_search = isset($_POST['show_in_home_search']) ? "yes" : "no";

        $settings = array(
            'service_seller_commission' => (int) validate_input($service_commission),
            'employer_commission' => (int) validate_input($employer_commission),
            'freelancer_commission' => (int) validate_input($freelancer_commission),
            'bids' => (int) validate_input($bids),
            'skills' => (int) validate_input($skills),
            'ad_limit' => (int) validate_input($_POST['ad_limit']),
            'ad_duration' => (int) validate_input($_POST['ad_duration']),
            'featured_project_fee' => (int) $featured,
            'featured_duration' => (int) $featured_duration,
            'urgent_project_fee' => (int) $urgent,
            'urgent_duration' => (int) $urgent_duration,
            'highlight_project_fee' => (int) $highlight,
            'highlight_duration' => (int) $highlight_duration,
            'top_search_result' => $top_search_result,
            'show_on_home' => $show_on_home,
            'show_in_home_search' => $show_in_home_search,
            'custom' => array()
        );

        switch ($_POST['id']){
            case 'free':
                $plan = json_encode(array(
                    'id' => 'free',
                    'name' => validate_input($_POST['name']),
                    'badge' => $_POST['badge'],
                    'settings' => $settings,
                    'status' => $active
                ),JSON_UNESCAPED_UNICODE);
                update_option('free_membership_plan', $plan);
                break;
            case 'trial':
                $plan = json_encode(array(
                    'id' => 'trial',
                    'name' => validate_input($_POST['name']),
                    'badge' => $_POST['badge'],
                    'days' => (int) validate_input($_POST['days']),
                    'settings' => $settings,
                    'status' => $active
                ),JSON_UNESCAPED_UNICODE);
                update_option('trial_membership_plan', $plan);
                break;
            default:
                $recommended = isset($_POST['recommended']) ? "yes" : "no";

                $insert_subscription = ORM::for_table($config['db']['pre'].'plans')->find_one($_POST['id']);
                $insert_subscription->name = validate_input($_POST['name']);
                $insert_subscription->badge = $_POST['badge'];
                $insert_subscription->monthly_price = validate_input($_POST['monthly_price']);
                $insert_subscription->annual_price = validate_input($_POST['annual_price']);
                $insert_subscription->lifetime_price = validate_input($_POST['lifetime_price']);
                $insert_subscription->settings = json_encode($settings);
                $insert_subscription->status = $active;
                $insert_subscription->recommended = $recommended;
                $insert_subscription->date = date('Y-m-d H:i:s');
                $insert_subscription->save();
                break;
        }

        $status = "success";
        $message = __("Lưu thành công.");

    } else {
        $status = "error";
        $message = __("Error: Please try again.");
    }

    echo $json = '{"status" : "' . $status . '","message" : "' . $message . '"}';
    die();
}

function addFAQentry()
{
    global $config,$lang;
    $errors = array();

    if (isset($_POST['submit'])) {

        if (empty($_POST['title'])) {
            $errors[]['message'] = __("FAQ entry title required");
        }
        if (empty($_POST['content'])) {
            $errors[]['message'] = __("FAQ entry content required");
        }
        if (!count($errors) > 0) {
            $active = isset($_POST['active']) ? '1' : '0';

            $insert_faq = ORM::for_table($config['db']['pre'].'faq_entries')->create();
            $insert_faq->faq_title = validate_input($_POST['title']);
            $insert_faq->faq_content = validate_input($_POST['content']);
            $insert_faq->active = $active;
            $insert_faq->save();

            $id = $insert_faq->id();

            $status = "success";
            $message = __("Lưu thành công.");

            echo $json = '{"id" : "' . $id . '","status" : "' . $status . '","message" : "' . $message . '"}';
            die();
        }else {
            $status = "error";
            $message = __("Error: Please try again.");
        }
    } else {
        $status = "error";
        $message = __("Error: Please try again.");
    }

    $json = '{"status" : "' . $status . '","message" : "' . $message . '","errors" : ' . json_encode($errors, JSON_UNESCAPED_SLASHES) . '}';
    echo $json;
    die();
}

function editFAQentry()
{
    global $config,$lang;
    $errors = array();
    $response = array();

    if (isset($_POST['id'])) {

        if (empty($_POST['title'])) {
            $errors[]['message'] = __("FAQ entry title required");
        }
        if (empty($_POST['content'])) {
            $errors[]['message'] = __("FAQ entry content required");
        }
        if (!count($errors) > 0) {
            $active = isset($_POST['active']) ? '1' : '0';

            $pdo = ORM::get_db();
            $query = "UPDATE `".$config['db']['pre']."faq_entries` SET
                `faq_title` = '" . validate_input($_POST['title']) . "',
                `faq_content` = '" . addslashes($_POST['content']) . "',
                 `active` = '" . validate_input($active) . "'
                 WHERE `faq_id` = '".validate_input($_POST['id'])."' LIMIT 1 ";
            $query_result = $pdo->query($query);

            $status = "success";
            $message = __('Content Page Edited');

            echo $json = '{"status" : "' . $status . '","message" : "' . $message . '"}';
            die();
        }else {
            $status = "error";
            $message = __("Error");
        }
    } else {
        $status = "error";
        $message = __('Unknown Error');
    }

    $json = '{"status" : "' . $status . '","message" : "' . $message . '","errors" : ' . json_encode($errors, JSON_UNESCAPED_SLASHES) . '}';
    echo $json;
    die();
}

function expirePostRenew(){
    global $config,$lang;
    $pdo = ORM::get_db();
    $timenow = date('Y-m-d H:i:s');

    $ad_duration = isset($_REQUEST['duration']) ? $_REQUEST['duration'] : '7';

    $expire_time = date('Y-m-d H:i:s', strtotime($timenow . ' +'.$ad_duration.' day'));
    $expire_timestamp = strtotime($expire_time);

    $query = "UPDATE `".$config['db']['pre']."product` SET
    `status` = 'active', `expire_date` = '" . $expire_timestamp . "'
    WHERE  status='expire'";
    $pdo->query($query);

    $status = "success";
    $message = __("Lưu thành công.");

    echo $json = '{"status" : "' . $status . '","message" : "' . $message . '"}';
    die();
}

function approve_all_pending_post()
{
    global $config,$lang,$link;
    if(check_allow()){
        $items = ORM::for_table($config['db']['pre'].'product')
            ->select_many('id','product_name','user_id')
            ->where('status','pending')
            ->find_many();

        if (count($items) > 0) {
            foreach($items as $info){
                //Ad approve Email to seller
                $product_id = $info['id'];
                $item_title = $info['product_name'];
                $item_author_id = $info['user_id'];

                $product = ORM::for_table($config['db']['pre'].'product')->find_one($product_id);
                $product->set('status', 'active');
                $product->save();

                /*SEND RESUBMISSION AD APPROVE EMAIL*/
                email_template("ad_approve",$item_author_id,null,$product_id,$item_title);
            }
        }
    }
    $status = "success";
    $message = __("Lưu thành công.");
    echo $json = '{"status" : "' . $status . '","message" : "' . $message . '"}';
    die();
}

function postEdit()
{
    global $config,$lang;
    $errors = array();
    $response = array();

    if (isset($_POST['id'])) {

        if (empty($_POST['category'])) {
            $errors[]['message'] = __("The category and sub-category are required.");
        }
        if (empty($_POST['title'])) {
            $errors[]['message'] = __("Title is required.");
        }
        if (empty($_POST['content'])) {
            $errors[]['message'] = __("Description is required.");
        }
        if (empty($_POST['city'])) {
            $errors[]['message'] = __("The city is required.");
        }
        if (!empty($_POST['price'])) {
            if (!is_numeric($_POST['price'])) {
                $errors[]['message'] = __("Price must be a number.");
            }
        }

        if (!count($errors) > 0) {

            $urgent = isset($_POST['urgent']) ? '1' : '0';
            $featured = isset($_POST['featured']) ? '1' : '0';
            $highlight = isset($_POST['highlight']) ? '1' : '0';

            if($config['post_desc_editor'] == 1)
                $description = validate_input($_POST['content'],true);
            else
                $description = validate_input($_POST['content']);

            $start_date = validate_input($_POST['start_date']);
            $expire_date = validate_input($_POST['expire_date']);

            $pro_created_date = ORM::for_table($config['db']['pre'].'product')
                ->select('created_at')
                ->where('id',validate_input($_POST['id']))
                ->find_one();

            $old_st = date('Y-m-d', strtotime(str_replace('/', '-',$pro_created_date['created_at'])));
            $new_st = date('Y-m-d', strtotime(str_replace('/', '-',$_POST['start_date'])));

            if($old_st == $new_st){
                $start_time = $pro_created_date['created_at'];
            }else{
                $start_time = date('Y-m-d H:i:s', strtotime(str_replace('/', '-',$_POST['start_date'])));
            }
            $expire_time = date('Y-m-d H:i:s', strtotime(str_replace('/', '-',$_POST['expire_date'])));
            $expire_timestamp = strtotime(str_replace('/', '-',$expire_date));
            $now = date("Y-m-d H:i:s");

            $item_edit = ORM::for_table($config['db']['pre'].'product')->find_one($_POST['id']);
            $item_edit->set('product_name', validate_input($_POST['title']));
            $item_edit->set('status', validate_input($_POST['status']));
            $item_edit->set('category', validate_input($_POST['category']));
            $item_edit->set('sub_category', !empty($_POST['sub_category'])?$_POST['sub_category']:0);
            $item_edit->set('featured', $featured);
            $item_edit->set('urgent', $urgent);
            $item_edit->set('highlight', $highlight);
            $item_edit->set('city', validate_input($_POST['city']));
            $item_edit->set('state', validate_input($_POST['state']));
            $item_edit->set('country', validate_input($_POST['country']));
            $item_edit->set('description', $description);
            $item_edit->set('created_at', $start_time);
            $item_edit->set('expire_date', $expire_timestamp);
            $item_edit->set('updated_at', $now);
            $item_edit->save();

            $status = "success";
            $message = __("Lưu thành công.");

            echo $json = '{"status" : "' . $status . '","message" : "' . $message . '"}';
            die();
        }else {
            $status = "error";
            $message = __("Error: Please try again.");
        }
    } else {
        $status = "error";
        $message = __("Error: Please try again.");
    }

    $json = '{"status" : "' . $status . '","message" : "' . $message . '","errors" : ' . json_encode($errors, JSON_UNESCAPED_SLASHES) . '}';
    echo $json;
    die();
}

function transactionEdit()
{
    global $config,$lang;
    $errors = array();
    $response = array();

    if (isset($_POST['id'])) {

        if (isset($_POST['status'])) {

            if($_POST['status'] == "success"){
                $transaction_id = validate_input($_POST['id']);
                transaction_success($transaction_id);
            }else{
                $transaction = ORM::for_table($config['db']['pre'].'transaction')->find_one(validate_input($_POST['id']));
                $transaction->status = validate_input($_POST['status']);
                $transaction->save();
            }
            $status = "success";
            $message = __("Lưu thành công.");

        }else {
            $status = "error";
            $message = __("Error: Please try again.");
        }
    } else {
        $status = "error";
        $message = __("Error: Please try again.");
    }

    echo $json = '{"status" : "' . $status . '","message" : "' . $message . '"}';
    die();
}


function withdrawEdit()
{
    global $config,$lang,$link;
    $errors = array();
    $response = array();

    if (isset($_POST['id'])) {

        if (isset($_POST['status'])) {

            if($_POST['status'] == "reject"){
                $info = ORM::for_table($config['db']['pre'].'withdrawal')->find_one(validate_input($_POST['id']));
                $user_id = $info['user_id'];
                $amount = $info['amount'];
                add_balance_withdraw($user_id,$amount,"Yêu Cầu Rút Tiền Bị Từ Chối");
                
                /*SEND EMAIL*/
                email_template("withdraw_rejected",$user_id);
            }

            if($_POST['status'] == "success"){
                $info = ORM::for_table($config['db']['pre'].'withdrawal')->find_one(validate_input($_POST['id']));
                $user_id = $info['user_id'];

                /*CREATE TRANSACTION */
                $amount = $info['amount'];
                $now = time();
                $ip = encode_ip($_SERVER, $_ENV);
                $trans_insert = ORM::for_table($config['db']['pre'].'transaction')->create();
                $trans_insert->product_name = 'Rút tiền';
                $trans_insert->product_id = null;
                $trans_insert->user_id = $user_id;
                $trans_insert->status = 'success';
                $trans_insert->amount = $amount;
                $trans_insert->transaction_gatway = 'Ví điện tử';
                $trans_insert->transaction_ip = $ip;
                $trans_insert->transaction_time = $now;
                $trans_insert->transaction_description = 'Yêu cầu rút tiền từ người dùng';
                $trans_insert->transaction_method = 'withdraw';
                $trans_insert->save();
                /*SEND EMAIL*/
                email_template("withdraw_accepted",$user_id);
            }

            $withdraw = ORM::for_table($config['db']['pre'].'withdrawal')->find_one(validate_input($_POST['id']));
            $withdraw->status = validate_input($_POST['status']);
            $withdraw->save();

            $status = "success";
            $message = __("Lưu thành công.");


        }else {
            $status = "error";
            $message = __("Error: Please try again.");
        }
    } else {
        $status = "error";
        $message = __("Error: Please try again.");
    }

    echo $json = '{"status" : "' . $status . '","message" : "' . $message . '"}';
    die();
}

function advertiseEdit()
{
    global $config,$lang,$link;
    $errors = array();
    $response = array();

    if (isset($_POST['id'])) {

        if (isset($_POST['status'])) {

            if($_POST['status'] == "reject"){
                $info = ORM::for_table($config['db']['pre'].'qbm_banners')->find_one(validate_input($_POST['id']));
                $user_id = $info['user_id'];
                $amount = $info['amount'];
                add_balance_adv($user_id,$amount,$_POST['id']);
                $banner_trans = ORM::for_table($config['db']['pre'].'qbm_transactions')->where('banner_id' ,validate_input($_POST['id']))->find_one();
                $trans_id = $banner_trans['id'];
                $trans_insert = ORM::for_table($config['db']['pre'].'qbm_transactions')->find_one($trans_id);
                $trans_insert->payment_status = 'reject';
                $trans_insert->save();
                /*SEND EMAIL*/
                $url = $info['url'];
                $days = $info['days_purchased'];
                email_template("banner_rejected",$user_id,$amount,$url,$days);
            }

            if($_POST['status'] == "success"){
                $info = ORM::for_table($config['db']['pre'].'qbm_banners')->find_one(validate_input($_POST['id']));
                $user_id = $info['user_id'];
                $banner_trans = ORM::for_table($config['db']['pre'].'qbm_transactions')->where('banner_id' ,validate_input($_POST['id']))->find_one();
                $trans_id = $banner_trans['id'];
                $trans_insert = ORM::for_table($config['db']['pre'].'qbm_transactions')->find_one($trans_id);
                $trans_insert->payment_status = 'success';
                $trans_insert->save();
                /*SEND EMAIL*/
                $url = $info['url'];
                $days = $info['days_purchased'];
                $amount = $info['amount'];
                email_template("banner_accepted",$user_id,$amount,$url,$days);
            }
            $info_banners = ORM::for_table($config['db']['pre'].'qbm_banners')->find_one(validate_input($_POST['id']));
            $days = $info_banners['days_purchased'].' days';
            $trans = ORM::for_table($config['db']['pre'].'qbm_banners')->find_one(validate_input($_POST['id']));
            $trans->status = validate_input($_POST['status']); 
            $trans->registered = time();
            $trans->time_expired = strtotime($days, time());
            $trans->save();

            $status = "success";
            $message = __("Lưu thành công.");


        }else {
            $status = "error";
            $message = __("Error: Please try again.");
        }
    } else {
        $status = "error";
        $message = __("Error: Please try again.");
    }

    echo $json = '{"status" : "' . $status . '","message" : "' . $message . '"}';
    die();
}

function SaveSettings(){

    global $config,$lang,$link;
    $status = "";
    if (isset($_POST['logo_watermark'])) {
        $valid_formats = array("jpg","jpeg","png"); // Valid image formats
        if (isset($_FILES['banner']) && $_FILES['banner']['tmp_name'] != "") {
            $filename = stripslashes($_FILES['banner']['name']);
            $ext = getExtension($filename);
            $ext = strtolower($ext);
            //File extension check
            if (in_array($ext, $valid_formats)) {
                $uploaddir = "../storage/banner/"; //Image upload directory
                $bannername = stripslashes($_FILES['banner']['name']);
                $size = filesize($_FILES['banner']['tmp_name']);
                //Convert extension into a lower case format

                $ext = getExtension($bannername);
                $ext = strtolower($ext);
                $banner_name = "bg" . '.' . $ext;
                $newBgname = $uploaddir . $banner_name;
                //Moving file to uploads folder
                if(file_exists($newBgname)){
                    unlink($newBgname);
                }
                if (move_uploaded_file($_FILES['banner']['tmp_name'], $newBgname)) {

                    update_option("home_banner",$banner_name);
                    $status = "success";
                    $message = __("Lưu thành công.");

                } else {
                    $status = "error";
                    $message = __("Error: Please try again.");
                }
            }
            else {
                $status = "error";
                $message = __("Only allowed jpg, jpeg png");
            }

        }

        if (isset($_FILES['favicon']) && $_FILES['favicon']['tmp_name'] != "") {
            $filename = stripslashes($_FILES['favicon']['name']);
            $ext = getExtension($filename);
            $ext = strtolower($ext);
            //File extension check
            if (in_array($ext, $valid_formats)) {
                $uploaddir = "../storage/logo/"; //Image upload directory
                $filename = stripslashes($_FILES['favicon']['name']);
                $size = filesize($_FILES['favicon']['tmp_name']);
                //Convert extension into a lower case format

                $ext = getExtension($filename);
                $ext = strtolower($ext);
                $image_name = "favicon" . '.' . $ext;
                $newLogo = $uploaddir . $image_name;
                if(file_exists($newLogo)){
                    unlink($newLogo);
                }
                //Moving file to uploads folder
                if (move_uploaded_file($_FILES['favicon']['tmp_name'], $newLogo)) {

                    update_option("site_favicon",$image_name);
                    $status = "success";
                    $message = __("Lưu thành công.");

                } else {
                    $status = "error";
                    $message = __("Error: Please try again.");
                }
            }
            else {
                $status = "error";
                $message = __("Only allowed jpg, jpeg png");
            }

        }

        if (isset($_FILES['file']) && $_FILES['file']['tmp_name'] != "") {
            $filename = stripslashes($_FILES['file']['name']);
            $ext = getExtension($filename);
            $ext = strtolower($ext);
            //File extension check
            if (in_array($ext, $valid_formats)) {
                $uploaddir = "../storage/logo/"; //Image upload directory
                $filename = stripslashes($_FILES['file']['name']);
                $size = filesize($_FILES['file']['tmp_name']);
                //Convert extension into a lower case format

                $ext = getExtension($filename);
                $ext = strtolower($ext);
                $image_name = $config['tpl_name']."_logo" . '.' . $ext;
                $newLogo = $uploaddir . $image_name;
                if(file_exists($newLogo)){
                    unlink($newLogo);
                }
                //Moving file to uploads folder
                if (move_uploaded_file($_FILES['file']['tmp_name'], $newLogo)) {

                    update_option("site_logo",$image_name);
                    $status = "success";
                    $message = __("Lưu thành công.");

                } else {
                    $status = "error";
                    $message = __("Error: Please try again.");
                }
            }
            else {
                $status = "error";
                $message = __("Only allowed jpg, jpeg png");
            }

        }

        if (isset($_FILES['footer_logo']) && $_FILES['footer_logo']['tmp_name'] != "") {
            $filename = stripslashes($_FILES['footer_logo']['name']);
            $ext = getExtension($filename);
            $ext = strtolower($ext);
            //File extension check
            if (in_array($ext, $valid_formats)) {
                $uploaddir = "../storage/logo/"; //Image upload directory
                $filename = stripslashes($_FILES['footer_logo']['name']);
                $size = filesize($_FILES['footer_logo']['tmp_name']);
                //Convert extension into a lower case format

                $ext = getExtension($filename);
                $ext = strtolower($ext);
                $image_name = $config['tpl_name']."_footer_logo" . '.' . $ext;
                $newLogo = $uploaddir . $image_name;
                if(file_exists($newLogo)){
                    unlink($newLogo);
                }
                //Moving file to uploads folder
                if (move_uploaded_file($_FILES['footer_logo']['tmp_name'], $newLogo)) {

                    update_option("site_logo_footer",$image_name);
                    $status = "success";
                    $message = __("Lưu thành công.");

                } else {
                    $status = "error";
                    $message = __("Error: Please try again.");
                }
            }
            else {
                $status = "error";
                $message = __("Only allowed jpg, jpeg png");
            }

        }

        if (isset($_FILES['watermark']) && $_FILES['watermark']['tmp_name'] != "") {
            $filename = stripslashes($_FILES['watermark']['name']);
            $ext = getExtension($filename);
            $ext = strtolower($ext);
            //File extension check
            if (in_array($ext, $valid_formats)) {
                $uploaddir = "../storage/logo/"; //Image upload directory
                $filename = stripslashes($_FILES['watermark']['name']);
                $size = filesize($_FILES['watermark']['tmp_name']);
                //Convert extension into a lower case format

                $ext = getExtension($filename);
                $ext = strtolower($ext);
                $mark_name = "watermark" . '.' . $ext;
                $watermark = $uploaddir . $mark_name;
                if(file_exists($watermark)){
                    unlink($watermark);
                }
                //Moving file to uploads folder
                if (move_uploaded_file($_FILES['watermark']['tmp_name'], $watermark)) {
                    $status = "success";
                    $message = __("Lưu thành công.");

                } else {
                    $status = "error";
                    $message = __("Error: Please try again.");
                }
            }
            else {
                $status = "error";
                $message = __("Only allowed jpg, jpeg png");
            }

        }

        if (isset($_FILES['adminlogo']) && $_FILES['adminlogo']['tmp_name'] != "") {
            $filename = stripslashes($_FILES['adminlogo']['name']);
            $ext = getExtension($filename);
            $ext = strtolower($ext);
            //File extension check
            if (in_array($ext, $valid_formats)) {
                $uploaddir = "../storage/logo/"; //Image upload directory
                $filename = stripslashes($_FILES['adminlogo']['name']);
                $size = filesize($_FILES['adminlogo']['tmp_name']);
                //Convert extension into a lower case format

                $ext = getExtension($filename);
                $ext = strtolower($ext);
                $adminlogo_name = "adminlogo" . '.' . $ext;
                $adminlogo = $uploaddir . $adminlogo_name;
                if(file_exists($adminlogo)){
                    unlink($adminlogo);
                }
                //Moving file to uploads folder
                if (move_uploaded_file($_FILES['adminlogo']['tmp_name'], $adminlogo)) {
                    update_option("site_admin_logo",$adminlogo_name);
                    $status = "success";
                    $message = __("Lưu thành công.");

                } else {
                    $status = "error";
                    $message = __("Error: Please try again.");
                }
            }
            else {
                $status = "error";
                $message = __("Only allowed jpg, jpeg png");
            }

        }

        if($status == ""){
            $status = "success";
            $message = __("Lưu thành công.");
        }
    }

    if (isset($_POST['general_setting'])) {
        update_option("site_url",validate_input($_POST['site_url']));
        update_option("site_title",validate_input($_POST['site_title']));
        update_option("meta_keywords",validate_input($_POST['meta_keywords']));
        update_option("meta_description",validate_input($_POST['meta_description']));
        update_option("non_active_msg",validate_input($_POST['non_active_msg']));
        update_option("non_active_allow",validate_input($_POST['non_active_allow']));
        update_option("job_seeker_enable",validate_input($_POST['job_seeker_enable']));
        update_option("resume_enable",validate_input($_POST['resume_enable']));
        update_option("resume_files",validate_input($_POST['resume_files']));
        update_option("company_enable",validate_input($_POST['company_enable']));
        update_option("reg_no_enable",validate_input($_POST['reg_no_enable']));
        update_option("cron_exec_time",validate_input($_POST['cron_exec_time']));
        update_option("delete_expired",validate_input($_POST['delete_expired']));
        update_option("userlangsel",validate_input($_POST['userlangsel']));
        update_option("userthemesel",validate_input($_POST['userthemesel']));
        update_option("color_switcher",validate_input($_POST['color_switcher']));
        update_option("termcondition_link",validate_input($_POST['termcondition_link']));
        update_option("privacy_link",validate_input($_POST['privacy_link']));
        update_option("cookie_link",validate_input($_POST['cookie_link']));
        update_option("cookie_consent",validate_input($_POST['cookie_consent']));
        update_option("transfer_filter",validate_input($_POST['transfer_filter']));
        update_option("temp_php",validate_input($_POST['temp_php']));
        update_option("quickad_debug",validate_input($_POST['quickad_debug']));
        $status = "success";
        $message = __("Lưu thành công.");
    }

    if (isset($_POST['home_page_setting'])) {
        update_option("home_page",validate_input($_POST['home_page']));
        update_option("header_sticky",validate_input($_POST['header_sticky']));
        update_option("transparent_header",validate_input($_POST['transparent_header']));
        update_option("banner_overlay",validate_input($_POST['banner_overlay']));
        update_option("show_search_home",validate_input($_POST['show_search_home']));
        update_option("show_categories_home",validate_input($_POST['show_categories_home']));
        update_option("show_featured_jobs_home",validate_input($_POST['show_featured_jobs_home']));
        update_option("show_latest_jobs_home",validate_input($_POST['show_latest_jobs_home']));
        update_option("show_membershipplan_home",validate_input($_POST['show_membershipplan_home']));
        update_option("show_partner_logo_home",validate_input($_POST['show_partner_logo_home']));

        $status = "success";
        $message = __("Lưu thành công.");
    }

    if (isset($_POST['theme_setting'])) {
        update_option("theme_color",validate_input($_POST['theme_color']));
        update_option("contact_validation",validate_input($_POST['contact_validation']));
        update_option("contact_address",validate_input($_POST['contact_address']));
        update_option("contact_phone",validate_input($_POST['contact_phone']));
        update_option("contact_email",validate_input($_POST['contact_email']));
        update_option("footer_text",validate_input($_POST['footer_text']));
        update_option("copyright_text",validate_input($_POST['copyright_text']));
        update_option("facebook_link",validate_input($_POST['facebook_link']));
        update_option("twitter_link",validate_input($_POST['twitter_link']));
        update_option("instagram_link",validate_input($_POST['instagram_link']));
        update_option("linkedin_link",validate_input($_POST['linkedin_link']));
        update_option("pinterest_link",validate_input($_POST['pinterest_link']));
        update_option("youtube_link",validate_input($_POST['youtube_link']));
        update_option("external_code",$_POST['external_code']);
        $status = "success";
        $message = __("Lưu thành công.");
    }

    if (isset($_POST['quick_map'])) {
        update_option("post_address_mode",validate_input($_POST['post_address_mode']));
        update_option("map_type",validate_input($_POST['map_type']));
        update_option("openstreet_access_token",validate_input($_POST['openstreet_access_token']));
        update_option("gmap_api_key",validate_input($_POST['gmap_api_key']));
        update_option("map_color",validate_input($_POST['map_color']));
        update_option("home_map_latitude",validate_input($_POST['home_map_latitude']));
        update_option("home_map_longitude",validate_input($_POST['home_map_longitude']));
        update_option("contact_latitude",validate_input($_POST['contact_latitude']));
        update_option("contact_longitude",validate_input($_POST['contact_longitude']));
        $status = "success";
        $message = __("Lưu thành công.");
    }

    if (isset($_POST['live_location_track'])) {
        update_option("location_track_icon",validate_input($_POST['location_track_icon']));
        update_option("auto_detect_location",validate_input($_POST['auto_detect_location']));
        update_option("live_location_api",validate_input($_POST['live_location_api']));
        $status = "success";
        $message = __("Lưu thành công.");
    }

    if (isset($_POST['billing_details'])) {
        update_option("invoice_nr_prefix", validate_input($_POST['invoice_nr_prefix']));
        update_option("invoice_admin_name", validate_input($_POST['invoice_admin_name']));
        update_option("invoice_admin_email", validate_input($_POST['invoice_admin_email']));
        update_option("invoice_admin_phone", validate_input($_POST['invoice_admin_phone']));
        update_option("invoice_admin_address", validate_input($_POST['invoice_admin_address']));
        update_option("invoice_admin_city", validate_input($_POST['invoice_admin_city']));
        update_option("invoice_admin_state", validate_input($_POST['invoice_admin_state']));
        update_option("invoice_admin_zipcode", validate_input($_POST['invoice_admin_zipcode']));
        update_option("invoice_admin_country", validate_input($_POST['invoice_admin_country']));
        update_option("invoice_admin_tax_type", validate_input($_POST['invoice_admin_tax_type']));
        update_option("invoice_admin_tax_id", validate_input($_POST['invoice_admin_tax_id']));
        update_option("invoice_admin_custom_name_1", validate_input($_POST['invoice_admin_custom_name_1']));
        update_option("invoice_admin_custom_value_1", validate_input($_POST['invoice_admin_custom_value_1']));
        update_option("invoice_admin_custom_name_2", validate_input($_POST['invoice_admin_custom_name_2']));
        update_option("invoice_admin_custom_value_2", validate_input($_POST['invoice_admin_custom_value_2']));
        $status = "success";
        $message = __("Lưu thành công.");
    }

    if (isset($_POST['email_setting'])) {

        update_option("admin_email",validate_input($_POST['admin_email']));
        update_option("email_template",validate_input($_POST['email_template']));
        update_option("email_type",validate_input($_POST['email_type']));
        update_option("smtp_host",validate_input($_POST['smtp_host']));
        update_option("smtp_port",validate_input($_POST['smtp_port']));
        update_option("smtp_username",validate_input($_POST['smtp_username']));
        update_option("smtp_password",validate_input($_POST['smtp_password']));
        update_option("smtp_secure",validate_input($_POST['smtp_secure']));
        update_option("smtp_auth",validate_input($_POST['smtp_auth']));
        update_option("aws_host",validate_input($_POST['aws_host']));
        update_option("aws_access_key",validate_input($_POST['aws_access_key']));
        update_option("aws_secret_key",validate_input($_POST['aws_secret_key']));
        update_option("mandrill_user",validate_input($_POST['mandrill_user']));
        update_option("mandrill_key",validate_input($_POST['mandrill_key']));
        update_option("sendgrid_user",validate_input($_POST['sendgrid_user']));
        update_option("sendgrid_pass",validate_input($_POST['sendgrid_pass']));

        $status = "success";
        $message = __("Lưu thành công.");
    }

    if (isset($_POST['frontend_submission'])) {
        update_option("post_without_login",validate_input($_POST['post_without_login']));
        update_option("post_auto_approve",validate_input($_POST['post_auto_approve']));
        update_option("post_desc_editor",validate_input($_POST['post_desc_editor']));
        update_option("job_image_field",validate_input($_POST['job_image_field']));
        update_option("post_tags_mode",validate_input($_POST['post_tags_mode']));
        update_option("post_premium_listing",validate_input($_POST['post_premium_listing']));
        $status = "success";
        $message = __("Lưu thành công.");
    }

    if (isset($_POST['project_setting'])) {
        update_option("payment_minimum_withdraw",validate_input($_POST['payment_minimum_withdraw']));
        update_option("payment_minimum_deposit",validate_input($_POST['payment_minimum_deposit']));
        $status = "success";
        $message = __("Lưu thành công.");
    }
    if (isset($_POST['recaptcha_setting'])) {

        update_option("recaptcha_mode",validate_input($_POST['recaptcha_mode']));
        update_option("recaptcha_public_key",validate_input(trim($_POST['recaptcha_public_key'])));
        update_option("recaptcha_private_key",validate_input(trim($_POST['recaptcha_private_key'])));
        $status = "success";
        $message = __("Lưu thành công.");
    }

    if (isset($_POST['blog_setting'])) {

        update_option("blog_enable",validate_input($_POST['blog_enable']));
        update_option("blog_banner",validate_input($_POST['blog_banner']));
        update_option("show_blog_home",validate_input($_POST['show_blog_home']));
        update_option("blog_comment_enable",validate_input($_POST['blog_comment_enable']));
        update_option("blog_comment_approval",validate_input($_POST['blog_comment_approval']));
        update_option("blog_comment_user",validate_input($_POST['blog_comment_user']));
        $status = "success";
        $message = __("Lưu thành công.");
    }

    if (isset($_POST['testimonials_setting'])) {

        update_option("testimonials_enable",validate_input($_POST['testimonials_enable']));
        update_option("show_testimonials_blog",validate_input($_POST['show_testimonials_blog']));
        update_option("show_testimonials_home",validate_input($_POST['show_testimonials_home']));
        $status = "success";
        $message = __("Lưu thành công.");
    }

    if (isset($_POST['valid_purchase_setting'])) {

        // Set API Key
        $code = validate_input(trim($_POST['purchase_key']));
        $buyer_email = (isset($_POST['buyer_email']))? validate_input($_POST['buyer_email']) : "";
        $installing_version = 'pro';

        $url = "https://bylancer.com/api/api.php?verify-purchase=" . $code . "&version=" . $installing_version . "&site_url=". $config['site_url']."&email=" . $buyer_email;
        // Open cURL channel
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        //Set the user agent
        $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)';
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
        // Decode returned JSON
        $output = json_decode(curl_exec($ch), true);
        // Close Channel
        curl_close($ch);

        if(is_array($output)){
            if ($output['success']) {
                if(isset($config['quickad_secret_file']) && $config['quickad_secret_file'] != ""){
                    $fileName = $config['quickad_secret_file'];
                }else{
                    $fileName = get_random_string();
                }
                file_put_contents( $fileName . '.php', $output['data']);
                $success = true;
                update_option("quickad_secret_file",$fileName);
                update_option("purchase_key",validate_input($_POST['purchase_key']));
                $status = "success";
                $message = __("Purchase code verified successfully");
            } else {
                $status = "error";
                $message = $output['error'];
            }
        }else {
            $status = "error";
            $message = "No result.";
        }

    }

    echo $json = '{"status" : "' . $status . '","message" : "' . $message . '"}';
    die();
}

function saveEmailTemplate(){

    if (isset($_POST['email_setting'])) {

        /*Start: Email Subject*/
        update_option("email_sub_signup_details",$_POST['email_sub_signup_details']);
        update_option("email_sub_signup_confirm",$_POST['email_sub_signup_confirm']);
        update_option("email_sub_forgot_pass",$_POST['email_sub_forgot_pass']);
        update_option("email_sub_contact",$_POST['email_sub_contact']);
        update_option("email_sub_feedback",$_POST['email_sub_feedback']);
        update_option("email_sub_report",$_POST['email_sub_report']);
        update_option("email_sub_ad_approve",$_POST['email_sub_ad_approve']);
        update_option("email_sub_re_ad_approve",$_POST['email_sub_re_ad_approve']);
        update_option("email_sub_contact_seller",$_POST['email_sub_contact_seller']);
        update_option("email_sub_post_notification",$_POST['email_sub_post_notification']);
        /***Freelancing***/
        update_option("email_sub_freelancer_project_awarded",$_POST['email_sub_freelancer_project_awarded']);
        update_option("email_sub_freelancer_project_revoke",$_POST['email_sub_freelancer_project_revoke']);
        update_option("email_sub_employer_project_accepted",$_POST['email_sub_employer_project_accepted']);
        update_option("email_sub_employer_project_approval_reject",$_POST['email_sub_employer_project_approval_reject']);
        update_option("email_sub_milestone_created",$_POST['email_sub_milestone_created']);
        update_option("email_sub_milestone_released",$_POST['email_sub_milestone_released']);
        update_option("email_sub_milestone_request_to_release",$_POST['email_sub_milestone_request_to_release']);
        update_option("email_sub_got_rating",$_POST['email_sub_got_rating']);
        update_option("email_sub_withdraw_accepted",$_POST['email_sub_withdraw_accepted']);
        update_option("email_sub_withdraw_rejected",$_POST['email_sub_withdraw_rejected']);
        update_option("email_sub_withdraw_request",$_POST['email_sub_withdraw_request']);
        update_option("email_sub_banner_accepted",$_POST['email_sub_banner_accepted']);
        update_option("email_sub_banner_rejected",$_POST['email_sub_banner_rejected']);
        update_option("email_sub_amount_deposit",$_POST['email_sub_amount_deposit']);

        /*Start: Email Message*/
        update_option("email_message_signup_details",$_POST['email_message_signup_details']);
        update_option("email_message_signup_confirm",$_POST['email_message_signup_confirm']);
        update_option("email_message_forgot_pass",$_POST['email_message_forgot_pass']);
        update_option("email_message_contact",$_POST['email_message_contact']);
        update_option("email_message_feedback",$_POST['email_message_feedback']);
        update_option("email_message_report",$_POST['email_message_report']);
        update_option("email_message_ad_approve",$_POST['email_message_ad_approve']);
        update_option("email_message_re_ad_approve",$_POST['email_message_re_ad_approve']);
        update_option("email_message_contact_seller",$_POST['email_message_contact_seller']);
        update_option("email_message_post_notification",$_POST['email_message_post_notification']);
        /***Freelancing***/
        update_option("emailHTML_freelancer_project_awarded",$_POST['emailHTML_freelancer_project_awarded']);
        update_option("emailHTML_freelancer_project_revoke",$_POST['emailHTML_freelancer_project_revoke']);
        update_option("emailHTML_employer_project_accepted",$_POST['emailHTML_employer_project_accepted']);
        update_option("emailHTML_employer_project_approval_reject",$_POST['emailHTML_employer_project_approval_reject']);
        update_option("emailHTML_milestone_created",$_POST['emailHTML_milestone_created']);
        update_option("emailHTML_milestone_released",$_POST['emailHTML_milestone_released']);
        update_option("emailHTML_milestone_request_to_release",$_POST['emailHTML_milestone_request_to_release']);
        update_option("emailHTML_got_rating",$_POST['emailHTML_got_rating']);
        update_option("emailHTML_withdraw_accepted",$_POST['emailHTML_withdraw_accepted']);
        update_option("emailHTML_withdraw_rejected",$_POST['emailHTML_withdraw_rejected']);
        update_option("emailHTML_withdraw_request",$_POST['emailHTML_withdraw_request']);
        update_option("emailHTML_banner_accepted",$_POST['emailHTML_banner_accepted']);
        update_option("emailHTML_banner_rejected",$_POST['emailHTML_banner_rejected']);
        update_option("emailHTML_amount_deposit",$_POST['emailHTML_amount_deposit']);


        $status = "success";
        $message = __("Lưu thành công.");
    }else{
        $status = "Error";
        $message = __("Error: Please try again.");
    }

    echo $json = '{"status" : "' . $status . '","message" : "' . $message . '"}';
    die();
}

?>