<?php
/**
 * @version 2.3.2
 * @author Bylancer
 * @Date: 23/Dec/2022
 * @Copyright (c) 2015-22 Bylancer.com
 */
define("ROOTPATH", dirname(__DIR__));
define("APPPATH", ROOTPATH."/php/");

require_once ROOTPATH . '/includes/autoload.php';
Global $config;
require_once ROOTPATH . '/includes/lang/lang_'.$config['lang'].'.php';
$con = db_connect($config);
admin_session_start();
if (!isset($_SESSION['admin']['id'])) {
    exit('Access Denied.');
}

//Admin Ajax Function
if(isset($_GET['action'])){

    if ($_GET['action'] == "deletefaq") { deletefaq(); }
    if ($_GET['action'] == "deletebanner") { deletebanner(); }
    if ($_GET['action'] == "approve_post") { approve_post(); }
    if ($_GET['action'] == "approveitem") { approveitem(); }
    if ($_GET['action'] == "approveResubmitItem") { approveResubmitItem(); }
    if ($_GET['action'] == "activeuser") { activeuser(); }
    if ($_GET['action'] == "banuser") { banuser(); }

    if ($_GET['action'] == "deleteMembershipPlan") { deleteMembershipPlan(); }
    if ($_GET['action'] == "deleteadmin") { deleteadmin(); }
    if ($_GET['action'] == "deleteMessage") { deleteMessage(); }
    if ($_GET['action'] == "deletePost") { deletePost(); }
    if ($_GET['action'] == "deleteProject") { deleteProject(); }
    if ($_GET['action'] == "deleteads") { deleteads(); }
    if ($_GET['action'] == "deleteResubmitItem") { deleteResubmitItem(); }
    if ($_GET['action'] == "deleteTransaction") { deleteTransaction(); }

    if ($_GET['action'] == "addNewCat") { addNewCat(); }
    if ($_GET['action'] == "editCat") { editCat(); }
    if ($_GET['action'] == "deleteCat") { deleteCat(); }

    if ($_GET['action'] == "addSubCat") { addSubCat(); }
    if ($_GET['action'] == "editSubCat") { editSubCat(); }
    if ($_GET['action'] == "delSubCat") { delSubCat(); }
    if ($_GET['action'] == "getSubCat") { getSubCat(); }

    if ($_GET['action'] == "addPostType") { addPostType(); }
    if ($_GET['action'] == "editPostType") { editPostType(); }
    if ($_GET['action'] == "delPostType") { delPostType(); }

    if ($_GET['action'] == "addSalaryType") { addSalaryType(); }
    if ($_GET['action'] == "editSalaryType") { editSalaryType(); }
    if ($_GET['action'] == "delSalaryType") { delSalaryType(); }

    if ($_GET['action'] == "deleteCompany") { deleteCompany(); }
    if ($_GET['action'] == "deleteResume") { deleteResume(); }

    if ($_GET['action'] == "saveBlog") { saveBlog(); }
    if ($_GET['action'] == "deleteBlog") { deleteBlog(); }
    if ($_GET['action'] == "approveComment") { approveComment(); }
    if ($_GET['action'] == "deleteComment") { deleteComment(); }
    if ($_GET['action'] == "addBlogCat") { addBlogCat(); }
    if ($_GET['action'] == "editBlogCat") { editBlogCat(); }
    if ($_GET['action'] == "delBlogCat") { delBlogCat(); }

    if ($_GET['action'] == "deleteTestimonial") { deleteTestimonial(); }

}

if(isset($_POST['action'])){
    if ($_POST['action'] == "quickad_update_maincat_position") { quickad_update_maincat_position(); }
    if ($_POST['action'] == "quickad_update_subcat_position") { quickad_update_subcat_position(); }
    if ($_POST['action'] == "quickad_update_post_type_position") { quickad_update_post_type_position(); }
    if ($_POST['action'] == "quickad_update_salary_type_position") { quickad_update_salary_type_position(); }
    if ($_POST['action'] == "quickad_update_blog_cat_position") { quickad_update_blog_cat_position(); }
    if ($_POST['action'] == "deleteusers") { deleteusers(); }
    if ($_POST['action'] == "getsubcatbyid") {getsubcatbyid();}
    if ($_POST['action'] == "getStateByCountryID") {getStateByCountryID();}
    if ($_POST['action'] == "getCityByStateID") {getCityByStateID();}
}

function change_language_file_settings($filePath, $newArray)
{
    $lang = array();
    // Get a list of the variables in the scope before including the file
    $new = get_defined_vars();
    // Include the config file and get it's values
    include($filePath);

    // Get a list of the variables in the scope after including the file
    $old = get_defined_vars();

    // Find the difference - after this, $fileSettings contains only the variables
    // declared in the file
    $fileSettings = array_diff($lang, $newArray);

    // Update $fileSettings with any new values
    $fileSettings = array_merge($fileSettings, $newArray);
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

/**
 * @param $filename
 * @return string
 */
function getFile($filename)
{
    $file = fopen($filename, 'r') or die('Unable to open file getFile!');
    $buffer = fread($file, filesize($filename));
    fclose($file);

    return $buffer;
}

/**
 * @param $filename
 * @param $buffer
 */
function writeFile($filename, $buffer)
{
    // Delete the file before writing
    if (file_exists($filename)) {
        unlink($filename);
    }
    // Write the new file
    $file = fopen($filename, 'w') or die('Unable to open file writeFile!');
    fwrite($file, $buffer);
    fclose($file);
}
/**
 * @param $rawFilePath
 * @param $filePath
 * @param $con
 * @return mixed|string
 */
function setSqlWithDbPrefix($rawFilePath, $filePath, $prefix)
{
    if (!file_exists($rawFilePath)) {
        return '';
    }

    // Read and replace prefix
    $sql = getFile($rawFilePath);
    $sql = str_replace('<<prefix>>', $prefix, $sql);

    // Write file
    writeFile($filePath, $sql);

    return $sql;
}

/**
 * @param $con
 * @param $filePath
 * @return bool
 */

function importSql($con, $filePath)
{

    try {
        $errorDetect = false;

        // Temporary variable, used to store current query
        $tmpline = '';
        // Read in entire file
        $lines = file($filePath);
        // Loop through each line
        foreach ($lines as $line) {
            // Skip it if it's a comment
            if (substr($line, 0, 2) == '--' || trim($line) == '') {
                continue;
            }
            if (substr($line, 0, 2) == '/*') {
                continue;
            }

            // Add this line to the current segment
            $tmpline .= $line;
            // If it has a semicolon at the end, it's the end of the query
            if (substr(trim($line), -1, 1) == ';') {
                // Perform the query
                if (!$con->query($tmpline)) {
                    echo "<pre>Error performing query '<strong>" . $tmpline . "</strong>' : " . $con->error . " - Code: " . $con->errno . "</pre><br />";
                    $errorDetect = true;
                }
                // Reset temp variable to empty
                $tmpline = '';
            }
        }
        // Check if error is detected
        if ($errorDetect) {
            //dd('ERROR');
        }
    } catch (\Exception $e) {
        $msg = 'Error when importing required data : ' . $e->getMessage();
        echo '<pre>';
        print_r($msg);
        echo '</pre>';
        exit();
    }


    // Delete the SQL file
    if (file_exists($filePath)) {
        unlink($filePath);
    }

    return true;
}

function delete_ad_by_id($con,$config,$product_id){
    if(check_allow()){
        $qry1 = "DELETE FROM `".$config['db']['pre']."product` WHERE id = '$product_id' LIMIT 1";
        $qry2 = "SELECT screen_shot FROM `".$config['db']['pre']."product` WHERE id = '$product_id' LIMIT 1";

        if ($res = $con->query($qry2)) {
            while ($fetch = mysqli_fetch_assoc($res)) {

                $uploaddir =  "../storage/products/";
                $screen_sm = explode(',',$fetch['screen_shot']);
                foreach ($screen_sm as $value)
                {
                    $value = trim($value);
                    //Delete Image From ../storage ----
                    $filename1 = $uploaddir.$value;
                    if(file_exists($filename1)){
                        unlink($filename1);
                    }
                }
            }
        }
        mysqli_query($con,$qry1);
        return true;
    }
    else{
        return false;
    }
}

function delete_resubmitad_by_id($con,$config,$product_id){
    if(check_allow()){
        $reqry1 = "DELETE FROM `".$config['db']['pre']."product_resubmit` WHERE product_id = '$product_id' LIMIT 1";
        $reqry2 = "SELECT screen_shot FROM `".$config['db']['pre']."product_resubmit` WHERE product_id = '$product_id' LIMIT 1";

        if ($res = $con->query($reqry2)) {
            while ($fetch = mysqli_fetch_assoc($res)) {

                $uploaddir =  "../storage/products/";
                $screen_sm = explode(',',$fetch['screen_shot']);
                foreach ($screen_sm as $value)
                {
                    $value = trim($value);
                    //Delete Image From ../storage ----
                    $filename1 = $uploaddir.$value;
                    if(file_exists($filename1)){
                        unlink($filename1);
                    }
                }
            }
        }

        mysqli_query($con,$reqry1);
        return true;
    }
    else{
        return false;
    }
}

function deletefaq()
{
    global $con,$config;

    if(isset($_POST['id']))
    {
        $_POST['list'][] = validate_input($_POST['id']);
    }

    if (is_array($_POST['list'])) {

        $count = 0;
        $sql = "DELETE FROM `".$config['db']['pre']."faq_entries` ";

        foreach ($_POST['list'] as $value)
        {
            if($count == 0)
            {
                $sql.= "WHERE `faq_id` = '" . $value . "'";
            }
            else
            {
                $sql.= " OR `faq_id` = '" . $value . "'";
            }

            $count++;
        }


        if(check_allow())
            mysqli_query($con,$sql);

        echo 1;
        die();
    } else {
        echo 0;
        die();
    }

}

function deletebanner()
{
    global $con,$config;

    if(isset($_POST['id']))
    {
        $_POST['list'][] = validate_input($_POST['id']);
    }

    if (is_array($_POST['list'])) {

        $count = 0;
        $sql = "DELETE FROM `".$config['db']['pre']."qbm_banners` ";

        foreach ($_POST['list'] as $value)
        {
            if($count == 0)
            {
                $sql.= "WHERE `id` = '" . $value . "'";
            }
            else
            {
                $sql.= " OR `id` = '" . $value . "'";
            }

            $count++;
        }


        if(check_allow())
            mysqli_query($con,$sql);

        echo 1;
        die();
    } else {
        echo 0;
        die();
    }

}

function approveResubmitItem()
{
    global $con,$config;

    $id = validate_input($_POST['id']);
    if (trim($id) != '') {
        if(check_allow()) {
            $sql = "SELECT * FROM `" . $config['db']['pre'] . "product_resubmit` WHERE `product_id` = '" . $_POST['id'] . "' LIMIT 1";
            $result = $con->query($sql);
            $info = mysqli_fetch_assoc($result);
            $row = mysqli_num_rows($result);
            if($row > 0){
                // Get usergroup details
                $group_id = get_user_group();
                $timenow = date('d-m-Y H:i:s');
                if($group_id > 0) {
                    // Get membership details
                    $group_get_info = get_user_membership_settings();

                    $ad_duration = $group_get_info['ad_duration'];
                    $expire_time = date('d-m-Y H:i:s', strtotime($timenow . ' +'.$ad_duration.' day'));
                    $expire_timestamp = strtotime($expire_time);
                }else{
                    $ad_duration = 7;
                    $expire_time = date('d-m-Y H:i:s', strtotime($timenow . ' +'.$ad_duration.' day'));
                    $expire_timestamp = strtotime($expire_time);
                }
                $status = "";
                if($info['status'] = "expire"){
                    $status = "active";
                }else{
                    $status = $info['status'];
                }

                $desc = $info['description'];

                if($config['post_desc_editor'] == 1)
                    $description = validate_input($desc,true);
                else
                    $description = validate_input($desc);

                $product_update = ORM::for_table($config['db']['pre'].'product')->find_one(validate_input($info['product_id']));
                $product_update->set('user_id', validate_input($info['user_id']));
                $product_update->set('status', validate_input($status));
                $product_update->set('company_id', validate_input($info['company_id']));
                $product_update->set('product_name', validate_input($info['product_name']));
                $product_update->set('sub_category', validate_input($info['sub_category']));
                $product_update->set('description', $description);
                $product_update->set('salary_min', validate_input($info['salary_min']));
                $product_update->set('salary_max', validate_input($info['salary_max']));
                $product_update->set('salary_type', validate_input($info['salary_type']));
                $product_update->set('product_type', validate_input($info['product_type']));
                $product_update->set('negotiable', validate_input($info['negotiable']));
                $product_update->set('product_type', validate_input($info['product_type']));
                $product_update->set('phone', validate_input($info['phone']));
                $product_update->set('hide_phone', validate_input($info['hide_phone']));
                $product_update->set('location', validate_input($info['location']));
                $product_update->set('city', validate_input($info['city']));
                $product_update->set('state', validate_input($info['state']));
                $product_update->set('country', validate_input($info['country']));
                $product_update->set('latlong', validate_input($info['latlong']));
                $product_update->set('screen_shot', validate_input($info['screen_shot']));
                $product_update->set('tag', validate_input($info['tag']));
                $product_update->set('expire_date', $expire_timestamp);
                $product_update->save();


                $con->query("DELETE FROM `" . $config['db']['pre'] . "product_resubmit` WHERE `product_id` = '" . validate_input($_POST['id']) . "' LIMIT 1");

                //Resubmission approve Email to seller
                $product_id = validate_input($_POST['id']);
                $item_title = validate_input($info['product_name']);
                $item_author_id = $info['user_id'];

                /*SEND RESUBMISSION AD APPROVE EMAIL*/
                email_template("re_ad_approve",$item_author_id,null,$product_id,$item_title);

            }else{
                echo 0;
                die();
            }
        }
        echo 1;
        die();

    }
    else {
        echo 0;
        die();
    }

}

function approve_post()
{
    global $config;
    if(!check_allow()){
        echo 1;
        die();
    }

    if(isset($_POST['id']) && trim($_POST['id']) != ''){
        $post_id = validate_input($_POST['id']);

        $count = ORM::for_table($config['db']['pre'].'post')
            ->where('id' , $post_id)
            ->count();
        if($count){
            $post = ORM::for_table($config['db']['pre'].'post')
                ->where('id' , $post_id)
                ->find_one();
            $post->status = 'active';
            $post->save();

            $title = $post['title'];
            $user_id = $post['user_id'];

            /*SEND RESUBMISSION AD APPROVE EMAIL*/
            email_template("ad_approve",$user_id,null,$post_id,$title);

            echo 1;
            die();
        }else{
            echo 0;
            die();
        }

    }else{
        echo 0;
        die();
    }

}

function approveitem()
{
    global $con,$config,$lang,$link;
    $id = validate_input($_POST['id']);
    if (trim($id) != '') {
        if(check_allow()){
            $con->query("UPDATE `".$config['db']['pre']."product` set status='active' WHERE `id` = '".$id."'");

            $query = "SELECT product_name,user_id from `".$config['db']['pre']."product` WHERE `id` = '".$id."' LIMIT 1";
            $result = mysqli_query($con, $query);
            if (mysqli_num_rows($result) > 0) {
                $info = mysqli_fetch_assoc($result);

                //Ad approve Email to seller
                $product_id = validate_input($_POST['id']);
                $item_title = $info['product_name'];
                $item_author_id = $info['user_id'];

                /*SEND RESUBMISSION AD APPROVE EMAIL*/
                email_template("ad_approve",$item_author_id,null,$product_id,$item_title);
            }
        }

        echo 1;
        die();
    } else {
        echo 0;
        die();
    }
}

function activeuser()
{
    global $con,$config;

    $id = validate_input($_POST['id']);
    if (trim($id) != '') {
        if(check_allow())
            $con->query("UPDATE `".$config['db']['pre']."user` set status='0' WHERE `id` = '" . $id . "'");
        echo 1;
        die();
    } else {
        echo 0;
        die();
    }

}

function banuser()
{
    global $con,$config;

    $id = validate_input($_POST['id']);
    if (trim($id) != '') {
        if(check_allow())
            $con->query("UPDATE `".$config['db']['pre']."user` set status='2' WHERE `id` = '" . $id . "'");
        echo 1;
        die();
    } else {
        echo 0;
        die();
    }

}

function deleteusers()
{
    global $con,$config;

    if(isset($_POST['id']))
    {
        $_POST['list'][] = validate_input($_POST['id']);
    }

    if (is_array($_POST['list'])) {

        $count = 0;
        $sql = "DELETE FROM `".$config['db']['pre']."user` ";

        foreach ($_POST['list'] as $value)
        {
            if($count == 0)
            {
                $sql.= "WHERE `id` = '" . $value . "'";
            }
            else
            {
                $sql.= " OR `id` = '" . $value . "'";
            }

            $count++;
        }
        $sql.= " LIMIT " . count($_POST['list']);

        if(check_allow())
            mysqli_query($con,$sql);

        echo 1;
        die();
    } else {
        echo 0;
        die();
    }

}

function deleteMembershipPlan()
{
    global $con,$config;

    if(isset($_POST['id']))
    {
        $_POST['list'][] = $_POST['id'];
    }

    if (is_array($_POST['list'])) {

        $count = 0;
        $sql = "DELETE FROM `".$config['db']['pre']."plans` ";

        foreach ($_POST['list'] as $value)
        {
            if($count == 0)
            {
                $sql.= "WHERE `id` = '" . $value . "'";
            }
            else
            {
                $sql.= " OR `id` = '" . $value . "'";
            }

            $count++;
        }
        $sql.= " LIMIT " . count($_POST['list']);
        $sql_user = "UPDATE `".$config['db']['pre']."user` "."SET group_id = 'free' WHERE group_id ='". $value . "'";
        if(check_allow())
            mysqli_query($con,$sql);
            mysqli_query($con,$sql_user);
        echo 1;
        die();
    } else {
        echo 0;
        die();
    }

}

function deleteadmin()
{
    global $con,$config;

    if(isset($_POST['id']))
    {
        $_POST['list'][] = validate_input($_POST['id']);
    }

    if (is_array($_POST['list'])) {

        $count = 0;
        $sql = "DELETE FROM `".$config['db']['pre']."admins` ";

        foreach ($_POST['list'] as $value)
        {
            if($count == 0)
            {
                $sql.= "WHERE `id` = '" . $value . "'";
            }
            else
            {
                $sql.= " OR `id` = '" . $value . "'";
            }

            $count++;
        }
        $sql.= " LIMIT " . count($_POST['list']);

        if(check_allow())
            mysqli_query($con,$sql);

        echo 1;
        die();
    } else {
        echo 0;
        die();
    }

}

function deleteMessage()
{
    global $con,$config;

    if(isset($_POST['id']))
    {
        $_POST['list'][] = validate_input($_POST['id']);
    }

    if (is_array($_POST['list'])) {

        $count = 0;
        $sql = "DELETE FROM `".$config['db']['pre']."messages` ";

        foreach ($_POST['list'] as $value)
        {
            if($count == 0)
            {
                $sql.= "WHERE `message_id` = '" . $value . "'";
            }
            else
            {
                $sql.= " OR `message_id` = '" . $value . "'";
            }

            $count++;
        }
        $sql.= " LIMIT " . count($_POST['list']);

        if(check_allow())
            mysqli_query($con,$sql);

        echo 1;
        die();
    } else {
        echo 0;
        die();
    }

}

function deletePost()
{
    global $config;

    if(isset($_POST['id'])) {
        $_POST['list'][] = validate_input($_POST['id']);
    }
    $where_array = array();
    if (is_array($_POST['list'])) {
        foreach ($_POST['list'] as $value) {
            $where_array[] = array("id" => $value);
        }

        if(check_allow()){
            $post = ORM::for_table($config['db']['pre'].'post')
                ->where_any_is($where_array)
                ->find_many();
            $post->set('status', 'deleted');
            $post->save();

            echo ORM::getLastQuery();
        }

        echo 1;
        die();
    } else {
        echo 0;
        die();
    }
}

function deleteProject()
{
    global $con,$config;

    if(isset($_POST['id']))
    {
        $_POST['list'][] = validate_input($_POST['id']);
    }

    if (is_array($_POST['list'])) {

        $count = 0;
        $sql = "DELETE FROM `".$config['db']['pre']."project` ";
        foreach ($_POST['list'] as $value)
        {
            if($count == 0)
            {
                $sql.= "WHERE `id` = '" . $value . "'";
            }
            else
            {
                $sql.= " OR `id` = '" . $value . "'";
            }

            $count++;
        }
        $sql.= " LIMIT " . count($_POST['list']);

        if(check_allow()){
            mysqli_query($con,$sql);
        }

        echo 1;
        die();
    } else {
        echo 0;
        die();
    }
}

function deleteads()
{
    global $con,$config;

    if(isset($_POST['id']))
    {
        $_POST['list'][] = validate_input($_POST['id']);
    }

    if (is_array($_POST['list'])) {

        $count = 0;
        $sql = "DELETE FROM `".$config['db']['pre']."product` ";
        $sql2 = "SELECT screen_shot FROM `".$config['db']['pre']."product` ";
        foreach ($_POST['list'] as $value)
        {
            if($count == 0)
            {
                $sql.= "WHERE `id` = '" . $value . "'";
                $sql2.= "WHERE `id` = '" . $value . "'";
            }
            else
            {
                $sql.= " OR `id` = '" . $value . "'";
                $sql2.= " OR `id` = '" . $value . "'";
            }

            $count++;
        }
        $sql.= " LIMIT " . count($_POST['list']);
        $sql2.= " LIMIT " . count($_POST['list']);

        if(check_allow()){
            if ($result = $con->query($sql2)) {
                while ($row = mysqli_fetch_assoc($result)) {

                    $uploaddir =  "../storage/products/";
                    $screen_sm = explode(',',$row['screen_shot']);
                    foreach ($screen_sm as $value)
                    {
                        $value = trim($value);
                        //Delete Image From ../storage ----
                        $filename1 = $uploaddir.$value;
                        if(file_exists($filename1)){
                            unlink($filename1);
                        }
                    }
                }
            }

            mysqli_query($con,$sql);
        }

        echo 1;
        die();
    } else {
        echo 0;
        die();
    }
}

function deleteCompany(){
    global $con,$config;
    if(isset($_POST['id']))
    {
        $_POST['list'][] = validate_input($_POST['id']);
    }

    if (is_array($_POST['list']))
    {
        $count = 0;
        $sql = "DELETE FROM `".$config['db']['pre']."companies` ";
        $sql2 = "SELECT logo FROM `".$config['db']['pre']."companies` ";
        $delete_product = "DELETE FROM `".$config['db']['pre']."product`";
        $delete_reproduct = "DELETE FROM `".$config['db']['pre']."product_resubmit`";
        foreach ($_POST['list'] as $value)
        {
            if($count == 0)
            {
                $sql.= "WHERE `id` = '" . $value . "'";
                $sql2.= "WHERE `id` = '" . $value . "'";
                $delete_product.= "WHERE `id` = '" . $value . "'";
                $delete_reproduct.= "WHERE `id` = '" . $value . "'";
            }
            else
            {
                $sql.= " OR `id` = '" . $value . "'";
                $sql2.= " OR `id` = '" . $value . "'";
                $delete_product.= "OR `id` = '" . $value . "'";
                $delete_reproduct.= "OR `id` = '" . $value . "'";
            }

            $count++;
        }
        $sql.= " LIMIT " . count($_POST['list']);
        $sql2.= " LIMIT " . count($_POST['list']);
        $delete_product.= " LIMIT " . count($_POST['list']);
        $delete_reproduct.= " LIMIT " . count($_POST['list']);

        if(check_allow()){
            if ($result = $con->query($sql2)) {
                while ($row = mysqli_fetch_assoc($result)) {

                    $uploaddir =  "../storage/products/";
                    // delete logo
                    $file = $uploaddir.$row['filename'];
                    if(file_exists($file))
                        unlink($file);
                }
            }

            mysqli_query($con,$delete_product);
            mysqli_query($con,$delete_reproduct);
            mysqli_query($con,$sql);
        }

        echo 1;
        die();
    }else {
        echo 0;
        die();
    }
}

function deleteResume(){
    global $con,$config;
    if(isset($_POST['id']))
    {
        $_POST['list'][] = validate_input($_POST['id']);
    }

    if (is_array($_POST['list']))
    {
        $count = 0;
        $sql = "DELETE FROM `".$config['db']['pre']."resumes` ";
        $sql2 = "SELECT filename FROM `".$config['db']['pre']."resumes` ";
        foreach ($_POST['list'] as $value)
        {
            if($count == 0)
            {
                $sql.= "WHERE `id` = '" . $value . "'";
                $sql2.= "WHERE `id` = '" . $value . "'";
            }
            else
            {
                $sql.= " OR `id` = '" . $value . "'";
                $sql2.= " OR `id` = '" . $value . "'";
            }
            $count++;
        }
        $sql.= " LIMIT " . count($_POST['list']);

        if(check_allow()){
            if ($result = $con->query($sql2)) {
                while ($row = mysqli_fetch_assoc($result)) {

                    $uploaddir =  "../storage/resumes/";
                    // delete logo
                    $file = $uploaddir.$row['filename'];
                    if(file_exists($file))
                        unlink($file);
                }
            }
            mysqli_query($con,$sql);
        }

        echo 1;
        die();
    }else {
        echo 0;
        die();
    }
}

function deleteResubmitItem()
{
    global $con,$config;

    if(isset($_POST['id']))
    {
        $_POST['list'][] = validate_input($_POST['id']);
    }

    if (is_array($_POST['list'])) {

        $count = 0;
        $sql = "DELETE FROM `".$config['db']['pre']."product_resubmit` ";
        $sql2 = "SELECT screen_shot FROM `".$config['db']['pre']."product_resubmit` ";
        $sql3 = "SELECT screen_shot FROM `".$config['db']['pre']."product` ";
        foreach ($_POST['list'] as $value)
        {
            if($count == 0)
            {
                $sql.= "WHERE `product_id` = '" . $value . "'";
                $sql2.= "WHERE `product_id` = '" . $value . "'";
                $sql3.= "WHERE `id` = '" . $value . "'";
            }
            else
            {
                $sql.= " OR `product_id` = '" . $value . "'";
                $sql2.= " OR `product_id` = '" . $value . "'";
                $sql3.= " OR `id` = '" . $value . "'";
            }

            $count++;
        }
        $sql.= " LIMIT " . count($_POST['list']);
        $sql2.= " LIMIT " . count($_POST['list']);
        $sql3.= " LIMIT " . count($_POST['list']);

        if(check_allow()){
            if ($result = $con->query($sql2)) {
                while ($row = mysqli_fetch_assoc($result)) {


                    $result3 = $con->query($sql3);
                    $row3 = mysqli_fetch_assoc($result3);

                    $uploaddir =  "../storage/products/";
                    $screen_sm = explode(',',$row['screen_shot']);
                    $re_screen = explode(',',$row3['screen_shot']);
                    $arr = array_diff($screen_sm,$re_screen);

                    foreach ($arr as $value)
                    {
                        $value = trim($value);
                        //Delete Image From Storage ----
                        $filename1 = $uploaddir.$value;
                        if(file_exists($filename1)){
                            unlink($filename1);
                        }
                    }
                }
            }

            mysqli_query($con,$sql);
        }

        echo 1;
        die();
    } else {
        echo 0;
        die();
    }

}

function deleteTransaction()
{
    global $con,$config;

    if(isset($_POST['id']))
    {
        $_POST['list'][] = validate_input($_POST['id']);
    }

    if (is_array($_POST['list'])) {

        $count = 0;
        $sql = "DELETE FROM `".$config['db']['pre']."transaction` ";

        foreach ($_POST['list'] as $value)
        {
            if($count == 0)
            {
                $sql.= "WHERE `id` = '" . $value . "'";
            }
            else
            {
                $sql.= " OR `id` = '" . $value . "'";
            }

            $count++;
        }
        $sql.= " LIMIT " . count($_POST['list']);

        if(check_allow())
            mysqli_query($con,$sql);

        echo 1;
        die();
    } else {
        echo 0;
        die();
    }

}

/**********************
 * @param $con
 * @param $config
 * Manage Categories  add/edit//delete function
 */
function edit_langTranslation()
{
    global $con,$config;

    $id = validate_input($_POST['id']);
    $cattype = validate_input($_POST['cat_type']);
    if(check_allow()){
        foreach ($_POST['value'] as $items) {

            $code = $items['code'];
            $title = $items['title'];
            $slug = $items['slug'];

            $source = 'en';
            $target = $code;

            /*$trans = new GoogleTranslate();
            $title = $trans->translate($source, $target, $title);*/

            if($slug == "")
                $slug = create_category_slug($title);
            else
                $slug = create_category_slug($slug);

            $sql = "SELECT id FROM `".$config['db']['pre']."category_translation` where translation_id = '$id' AND lang_code = '$code'  AND category_type = '$cattype' LIMIT 1";
            $query = mysqli_query($con,$sql);
            $rowcount = mysqli_num_rows($query);
            $title = mysqli_real_escape_string($con,$title);

            if($rowcount != 0){
                $info = mysqli_fetch_array($query);
                $a = "UPDATE `".$config['db']['pre']."category_translation` set title = '$title',slug = '$slug' where id = '".$info['id']."' LIMIT 1";
                mysqli_query($con,$a);

            }else{
                $a = "INSERT into `".$config['db']['pre']."category_translation` set lang_code = '$code',title = '$title',slug = '$slug',category_type = '$cattype', translation_id = '$id' ";
                mysqli_query($con,$a);
            }
        }
        echo 1;
        die();
    }
    echo 0;
    die();
}

function addNewCat()
{
    global $con,$config;

    $post_type = isset($_POST['post_type']) ? validate_input($_POST['post_type']) : 'default';
    $name = validate_input($_POST['name']);
    $icon = validate_input($_POST['icon']);
    $slug = validate_input($_POST['slug']);
    if (trim($name) != '' && is_string($name)) {
        if($slug == "")
            $slug = create_category_slug($name);
        else
            $slug = create_category_slug($slug);

        $query = "Insert into `".$config['db']['pre']."catagory_main` set
        post_type='".$post_type."',
        cat_name='".$name."',
        slug='".$slug."',
        icon='".$icon."'";
        if(check_allow()){
            $con->query($query);
            $id = $con->insert_id;
        }
        else {
            $id = 1;
        }
        echo $name . ',' . $id . ',' . $icon. ',' . $slug;
        die();
    } else {
        echo 0;
        die();
    }
}

function editCat()
{
    global $con,$config;

    $name = validate_input($_POST['name']);
    $icon = validate_input($_POST['icon']);
    $slug = validate_input($_POST['slug']);
    $id = validate_input($_POST['id']);
    if (trim($name) != '' && is_string($name) && trim($id) != '') {
        if($slug == "")
            $slug = create_slug($name);
        else
            $slug = create_slug($slug);

        $query = "UPDATE `".$config['db']['pre']."catagory_main` SET `cat_name` = '".$name."',`icon` = '" . $icon . "',`slug` = '" . $slug . "' WHERE `cat_id` = '" . $id . "'";
        if(check_allow()){
            $con->query($query);


        }
        echo $name . ',' . $icon;
        die();
    } else {
        echo 0;
        die();
    }
}

function deleteCat()
{
    global $con,$config;

    $id = validate_input($_POST['id']);
    if (trim($id) != '') {
        if(check_allow()){
            if ($con->query("DELETE FROM `".$config['db']['pre']."catagory_main` WHERE `cat_id` = '" . $id . "'")) {
                $con->query("DELETE FROM `".$config['db']['pre']."category_translation` WHERE `translation_id` = '" . $id . "' and category_type = 'main' ");
                $query = "SELECT sub_cat_id FROM `".$config['db']['pre']."catagory_sub` WHERE `main_cat_id` = '" . $id . "'";
                $query_result = mysqli_query ($con, $query) OR error(mysqli_error($con));
                while($row = $query_result->fetch_assoc()) // use fetch_assoc here
                {
                    $id = $row['sub_cat_id'];
                    $con->query("DELETE FROM `".$config['db']['pre']."catagory_sub` WHERE `sub_cat_id` = '" . $id . "'");
                    $con->query("DELETE FROM `".$config['db']['pre']."category_translation` WHERE `translation_id` = '" . $id . "' and category_type = 'sub' ");
                }

                echo 1;
                die();
            } else {
                echo 0;
                die();
            }
        }
        else{
            echo 1;
        }
    } else {
        echo 0;
        die();
    }
}

function addSubCat()
{
    global $con,$config;
    $post_type = isset($_POST['post_type']) ? validate_input($_POST['post_type']) : 'default';
    $name = validate_input($_POST['name']);
    $cat_id = validate_input($_GET['mainid']);
    if (trim($name) != '' && is_string($name) && trim($cat_id) != '') {
        $slug = create_sub_category_slug($name);
        $query = "Insert into `".$config['db']['pre']."catagory_sub` set post_type='".$post_type."', sub_cat_name='".$name."', slug='".$slug."', main_cat_id='".$cat_id."'";
        if(check_allow()){
            $con->query($query);
            $id = $con->insert_id;

            $query = "UPDATE `".$config['db']['pre']."catagory_sub` SET `cat_order` = '" . $id . "' WHERE `sub_cat_id` = '" . $id . "'";
            $con->query($query);


        }
        else{
            $id =1;
        }

        echo $name . ',' . $id;
        die();
    } else {
        echo 0;
        die();
    }
}

function editSubCat()
{
    global $con,$config;

    $name = validate_input($_GET['title']);
    $slug = validate_input($_GET['slug']);
    $id = validate_input($_GET['id']);
    if (trim($name) != '' && is_string($name) && trim($id) != '') {

        if($slug == "")
            $slug = create_category_slug($name);
        else
            $slug = create_category_slug($slug);

        $query = "UPDATE `".$config['db']['pre']."catagory_sub` SET `sub_cat_name` = '".$name."',`slug` = '".$slug."' WHERE `sub_cat_id` = '" . $id . "'";
        if(check_allow()){
            $con->query($query);


        }

        echo 1;
        die();
    } else {
        echo 0;
        die();
    }
}

function delSubCat()
{
    global $con,$config;

    $subCatids = validate_input($_POST['subCatids']);
    if (is_array($subCatids)) {
        foreach ($subCatids as $subCatid) {
            if(check_allow()){
                $con->query("DELETE FROM `".$config['db']['pre']."catagory_sub` WHERE `sub_cat_id` = '" . $subCatid . "'");
                $con->query("DELETE FROM `".$config['db']['pre']."category_translation` WHERE `translation_id` = '" . $subCatid . "' and category_type = 'sub'");
            }
        }
        echo 1;
        die();
    } else {
        echo 0;
        die();
    }
}

function getSubCat()
{
    global $con,$config;
    $post_type = isset($_GET['post_type']) ? validate_input($_GET['post_type']) : 'default';
    $id = isset($_GET['category_id']) ? validate_input($_GET['category_id']) : 0;
    if ($id > 0) {
        $query = "SELECT * FROM `".$config['db']['pre']."catagory_sub` WHERE main_cat_id = ".$id." ORDER by cat_order ASC";
    } else {
        $query = "SELECT * FROM `".$config['db']['pre']."catagory_sub` WHERE post_type = '".$post_type."' ORDER by cat_order ASC";
    }
    $tags = '<div class="panel-group ui-sortable" id="services_list" role="tablist" aria-multiselectable="true">';

    if ($result = $con->query($query)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $name = $row['sub_cat_name'];
            $slug = $row['slug'];
            $sub_id = $row['sub_cat_id'];
            
            $userlangselect = (get_option("userlangsel") == '1')? "show" :  "hidden";

            $tags .= ' <div class="panel panel-default quickad-js-collapse" data-service-id="' . $sub_id . '">
            <div class="panel-heading" role="tab" id="s_' . $sub_id . '">
            <div class="row">
            <div class="col-sm-8 col-xs-10">
            <div class="quickad-flexbox">
            <div class="quickad-flex-cell quickad-vertical-middle" style="width: 1%">
            <i class="quickad-js-handle quickad-icon quickad-icon-draghandle quickad-margin-right-sm quickad-cursor-move ui-sortable-handle"
            title="Reorder"></i>
            </div>
            <div class="quickad-flex-cell quickad-vertical-middle">
            <a role="button"
            class="panel-title collapsed quickad-js-service-title"
            data-toggle="collapse" data-parent="#services_list"
            href="#service_' . $sub_id . '" aria-expanded="false"
            aria-controls="service_' . $sub_id . '">
            '.$name.' </a>
            </div>
            </div>
            </div>
            <div class="col-sm-4 col-xs-2">
            <div class="quickad-flexbox">
            <div class="quickad-flex-cell quickad-vertical-middle text-right"
            style="width: 10%">
            <label class="css-input css-checkbox css-checkbox-default m-t-0 m-b-0">
            <input type="checkbox" id="checkbox'.$sub_id.'" name="check-all" value="'.$sub_id.'"  class="service-checker"><span></span>
            </label>
            </div>
            </div>
            </div>
            </div>
            </div>

            <div id="service_' . $sub_id . '" class="panel-collapse collapse" role="tabpanel"
            style="height: 0">
            <div class="panel-body">
            <form method="post" id="' . $sub_id . '">
            <div class="row">
            <div class="col-md-6 col-sm-12">
            <div class="form-group">
            <label for="title_' . $sub_id . '">Tiêu đề</label>
            <input name="title" value="'.$name.'" id="title_' . $sub_id . '"
            class="form-control" type="text">

            </div>
            </div>
            <div class="col-md-6 col-sm-12">
            <div class="form-group">
            <label for="slug_' . $sub_id . '">Slug</label>
            <input name="slug" value="'.$slug.'" id="slug_' . $sub_id . '"
            class="form-control" type="text">

            <div class="panel-footer">
            <input name="id" value="' . $sub_id . '" type="hidden">
            <button type="button"
            class="'.$userlangselect.' btn btn-lg btn-warning quickad-cat-lang-edit" data-category-id="'.$sub_id.'" data-category-type="sub"> <span
            class="ladda-label"><i class="fa fa-language"></i> Edit Language</span></button>
            <button type="button"
            class="btn btn-lg btn-success ladda-button ajax-subcat-edit"
            data-style="zoom-in" data-spinner-size="40" onclick="editSubCat('.$sub_id.');"><span
            class="ladda-label">Save</span></button>
            <button class="btn btn-lg btn-default js-reset" type="reset">Reset
            </button>
            </div>
            </form>
            </div>
            </div>
            </div>';

        }

        $tags .= '</div>';
        echo $tags;
        die();
    } else {
        echo 0;
        die();
    }
}

function getsubcatbyid()
{
    global $con,$config;

    $id = isset($_POST['catid']) ? validate_input($_POST['catid']) : 0;
    $selectid = isset($_POST['selectid']) ? validate_input($_POST['selectid']) : "";

    $query = "SELECT * FROM `" . $config['db']['pre'] . "catagory_sub` WHERE main_cat_id = " . $id;
    if ($result = $con->query($query)) {

        while ($row = mysqli_fetch_assoc($result)) {
            $name = $row['sub_cat_name'];
            $sub_id = $row['sub_cat_id'];
            if($selectid == $sub_id){
                $selected_text = "selected";
            }
            else{
                $selected_text = "";
            }
            echo '<option value="'.$sub_id.'" '.$selected_text.'>'.$name.'</option>';
        }


    }
}

function quickad_update_maincat_position()
{
    global $con,$config;

    $position = $_POST['position'];
    if (is_array($position)) {
        $count = 0;
        foreach($position as $catid){

            $query = "UPDATE `".$config['db']['pre']."catagory_main` SET `cat_order` = '".$count."' WHERE `cat_id` = '" . $catid . "'";
            if(check_allow()){
                $con->query($query);
            }
            $count++;
        }

        echo 1;
        die();
    } else {
        echo 0;
        die();
    }
}

function quickad_update_subcat_position()
{
    global $con,$config;

    $position = $_POST['position'];
    if (is_array($position)) {
        $count = 0;
        foreach($position as $catid){

            $query = "UPDATE `".$config['db']['pre']."catagory_sub` SET `cat_order` = '".$count."' WHERE `sub_cat_id` = '" . $catid . "'";
            if(check_allow()){
                $con->query($query);
            }
            $count++;
        }
        echo 1;
        die();
    } else {
        echo 0;
        die();
    }
}

function quickad_update_post_type_position(){
    global $con,$config;

    $position = $_POST['position'];
    if (is_array($position)) {
        $count = 0;
        foreach($position as $id){
            $query = "UPDATE `".$config['db']['pre']."product_type` SET `position` = '".$count."' WHERE `id` = '" . $id . "'";
            if(check_allow()){
                $con->query($query);
            }
            $count++;
        }
        echo 1;
        die();
    } else {
        echo 0;
        die();
    }
}

function quickad_update_salary_type_position(){
    global $con,$config;

    $position = $_POST['position'];
    if (is_array($position)) {
        $count = 0;
        foreach($position as $id){
            $query = "UPDATE `".$config['db']['pre']."salary_type` SET `position` = '".$count."' WHERE `id` = '" . $id . "'";
            if(check_allow()){
                $con->query($query);
            }
            $count++;
        }
        echo 1;
        die();
    } else {
        echo 0;
        die();
    }
}

function quickad_update_blog_cat_position(){
    global $con,$config;
    $position = $_POST['position'];
    if (is_array($position)) {
        $count = 0;
        foreach($position as $id){
            $query = "UPDATE `".$config['db']['pre']."blog_categories` SET `position` = '".$count."' WHERE `id` = '" . $id . "'";
            if(check_allow()){
                $con->query($query);
            }
            $count++;
        }
        echo 1;
        die();
    } else {
        echo 0;
        die();
    }
}

function addPostType()
{
    global $con,$config;

    $name = validate_input($_POST['name']);
    if (trim($name) != '' && is_string($name)) {
        $query = "Insert into `".$config['db']['pre']."product_type` set title='".$name."'";
        if(check_allow()){
            $con->query($query);
            $id = $con->insert_id;

            $query = "UPDATE `".$config['db']['pre']."product_type` SET `position` = '" . $id . "' WHERE `id` = '" . $id . "'";
            $con->query($query);
        }
        else{
            $id =1;
        }
        $result = array();
        $result['name'] = $name;
        $result['id'] = $id;
        echo json_encode($result);
        die();
    } else {
        echo 0;
        die();
    }
}

function editPostType(){
    global $con,$config;

    $name = validate_input($_GET['title']);
    $status = validate_input($_GET['status']);
    $id = validate_input($_GET['id']);
    if (trim($name) != '' && is_string($name) && trim($id) != '') {

        $query = "UPDATE `".$config['db']['pre']."product_type` SET `title` = '".$name."', `active` = '".$status."' WHERE `id` = '" . $id . "'";
        if(check_allow()){
            $con->query($query);
        }

        echo 1;
        die();
    } else {
        echo 0;
        die();
    }
}

function delPostType(){
    global $con,$config;

    $ids = validate_input($_POST['ids']);
    if (is_array($ids)) {
        foreach ($ids as $id) {
            if(check_allow()){
                $con->query("DELETE FROM `".$config['db']['pre']."product_type` WHERE `id` = '" . $id . "'");
            }
        }
        echo 1;
        die();
    } else {
        echo 0;
        die();
    }
}

function addSalaryType(){
    global $con,$config;

    $name = validate_input($_POST['name']);
    if (trim($name) != '' && is_string($name)) {
        $query = "Insert into `".$config['db']['pre']."salary_type` set title='".$name."'";
        if(check_allow()){
            $con->query($query);
            $id = $con->insert_id;

            $query = "UPDATE `".$config['db']['pre']."salary_type` SET `position` = '" . $id . "' WHERE `id` = '" . $id . "'";
            $con->query($query);
        }
        else{
            $id =1;
        }
        $result = array();
        $result['name'] = $name;
        $result['id'] = $id;
        echo json_encode($result);
        die();
    } else {
        echo 0;
        die();
    }
}

function editSalaryType(){
    global $con,$config;

    $name = validate_input($_GET['title']);
    $status = validate_input($_GET['status']);
    $id = validate_input($_GET['id']);
    if (trim($name) != '' && is_string($name) && trim($id) != '') {

        $query = "UPDATE `".$config['db']['pre']."salary_type` SET `title` = '".$name."', `active` = '".$status."' WHERE `id` = '" . $id . "'";
        if(check_allow()){
            $con->query($query);
        }

        echo 1;
        die();
    } else {
        echo 0;
        die();
    }
}

function delSalaryType(){
    global $con,$config;

    $ids = validate_input($_POST['ids']);
    if (is_array($ids)) {
        foreach ($ids as $id) {
            if(check_allow()){
                $con->query("DELETE FROM `".$config['db']['pre']."salary_type` WHERE `id` = '" . $id . "'");
            }
        }
        echo 1;
        die();
    } else {
        echo 0;
        die();
    }
}

function getStateByCountryID()
{
    global $con,$config;

    $country_id = isset($_POST['id']) ? validate_input($_POST['id']) : 0;
    $selectid = isset($_POST['selectid']) ? validate_input($_POST['selectid']) : "";

    $query = "SELECT id,code,name FROM `".$config['db']['pre']."subadmin1` WHERE country_code = '".$country_id."' ORDER BY name";
    if ($result = $con->query($query)) {

        $list = '<option value="">Select State</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            $name = $row['name'];
            $state_id = $row['id'];
            $state_code = $row['code'];
            if($selectid == $state_code){
                $selected_text = "selected";
            }
            else{
                $selected_text = "";
            }
            $list .= '<option value="'.$state_code.'" '.$selected_text.'>'.$name.'</option>';
        }

        echo $list;
    }
}

function getCityByStateID()
{
    global $con,$config;

    $state_id = isset($_POST['id']) ? validate_input($_POST['id']) : 0;
    $selectid = isset($_POST['selectid']) ? validate_input($_POST['selectid']) : "";

    //$state_code = substr($state_id,3);
    $country_code = substr($state_id,0,2);
    $query = "SELECT id ,name FROM `".$config['db']['pre']."cities` WHERE subadmin1_code = '".$state_id."' and country_code = '$country_code'" ;
    $result = $con->query($query);
    if ($result){
        if(mysqli_num_rows($result) > 0){

            $list = '<option value="">Select City</option>';
            while ($row = mysqli_fetch_assoc($result)) {
                $name = $row['name'];
                $id = $row['id'];
                if($selectid == $id){
                    $selected_text = "selected";
                }
                else{
                    $selected_text = "";
                }
                $list .= '<option value="'.$id.'" '.$selected_text.'>'.$name.'</option>';
            }
            echo $list;
            die();
        }
    }else{
        echo $list = '<option value="">Select City</option>';
        die();
    }
}

function saveBlog(){
    global $con,$config;

    $title = strip_tags(validate_input($_POST['title']));
    $tags = strtolower(preg_replace('/[^a-zA-Z0-9_ ,]/', '', $_POST['tags']));
    $image = null;
    $description = validate_input($_POST['description'],true);
    $error = array();

    if(empty($title)){
        $error[] = __("Title is required");
    }
    if(empty($description)){
        $error[] = __("Description is required");
    }

    if(empty($error)){
        $target_dir = ROOTPATH . "/storage/blog/";
        $result = quick_file_upload('image',$target_dir);
        if($result['success']){
            $image = $result['file_name'];
            resizeImage(900, $target_dir . $image, $target_dir . $image);
            if(!empty($_POST['id'])) {
                // remove old image
                $info = ORM::for_table($config['db']['pre'] . 'blog')
                    ->select('image')
                    ->find_one($_POST['id']);

                if ($info['image'] != "default.png") {
                    if (file_exists($target_dir . $info['image'])) {
                        unlink($target_dir . $info['image']);
                    }
                }
            }
        }else{
            $error[] = $result['error'];
        }
    }

    if (empty($error)) {
        $id = 1;
        if(check_allow()){
            $now = date("Y-m-d H:i:s");
            if(!empty($_POST['id'])){
                $blog = ORM::for_table($config['db']['pre'].'blog')
                    ->where('id',$_POST['id'])
                    ->find_one();

                if($blog){
                    if(!empty($image)){
                        $blog->set('image', $image);
                    }
                    $blog->set('title',$title);
                    $blog->set('description',$description);
                    $blog->set('tags', $tags);
                    $blog->set('status', $_POST['status']);
                    $blog->set('updated_at', $now);
                    $blog->save();
                    $id = $_POST['id'];
                }

                ORM::for_table($config['db']['pre'].'blog_cat_relation')
                    ->where('blog_id',$_POST['id'])
                    ->delete_many();
            }else{
                $blog = ORM::for_table($config['db']['pre'].'blog')->create();
                $blog->title = $title;
                $blog->image = $image;
                $blog->description = $description;
                $blog->author = $_SESSION['admin']['id'];
                $blog->status = $_POST['status'];
                $blog->tags = $tags;
                $blog->created_at = $now;
                $blog->updated_at = $now;
                $blog->save();
                $id = $blog->id();
            }

            if(!empty($_POST['category']) && is_array($_POST['category'])){
                foreach($_POST['category'] as $cat){
                    $blog_cat = ORM::for_table($config['db']['pre'].'blog_cat_relation')->create();
                    $blog_cat->blog_id = $id;
                    $blog_cat->category_id = $cat;
                    $blog_cat->save();
                }
            }
        }
        $result = array();
        $result['status'] = 'success';
        $result['id'] = $id;
        $result['message'] = "Saved Successfully.";
        echo json_encode($result);

    } else {
        $result = array();
        $result['status'] = 'error';
        $result['message'] = implode('<br>',$error);
        echo json_encode($result);
    }
    die();
}

function deleteBlog(){
    global $con,$config;
    if(isset($_POST['id']))
    {
        $_POST['list'][] = validate_input($_POST['id']);
    }

    if (is_array($_POST['list']))
    {
        $count = 0;
        $sql = "DELETE FROM `".$config['db']['pre']."blog` ";
        $sql2 = "SELECT image FROM `".$config['db']['pre']."blog` ";
        foreach ($_POST['list'] as $value)
        {
            if($count == 0)
            {
                $sql.= "WHERE `id` = '" . $value . "'";
                $sql2.= "WHERE `id` = '" . $value . "'";
            }
            else
            {
                $sql.= " OR `id` = '" . $value . "'";
                $sql2.= " OR `id` = '" . $value . "'";
            }
            $count++;
        }
        $sql.= " LIMIT " . count($_POST['list']);

        if(check_allow()){
            if ($result = $con->query($sql2)) {
                while ($row = mysqli_fetch_assoc($result)) {

                    $uploaddir =  "../storage/blog/";
                    // delete logo
                    $file = $uploaddir.$row['image'];
                    if(file_exists($file))
                        unlink($file);
                }
            }
            mysqli_query($con,$sql);
        }

        echo 1;
        die();
    }else {
        echo 0;
        die();
    }
}

function approveComment(){
    global $con,$config;

    $query = "UPDATE `".$config['db']['pre']."blog_comment` SET `active` = '1' WHERE `id` = '" . validate_input($_POST['id']) . "'";
    if(check_allow()){
        $con->query($query);
    }

    echo 1;
    die();
}

function deleteComment(){
    global $con,$config;
    if(isset($_POST['id']))
    {
        $_POST['list'][] = validate_input($_POST['id']);
    }

    if (is_array($_POST['list']))
    {
        $count = 0;
        $sql = "DELETE FROM `".$config['db']['pre']."blog_comment` ";
        foreach ($_POST['list'] as $value)
        {
            if($count == 0)
            {
                $sql.= "WHERE `id` = '" . $value . "'";
            }
            else
            {
                $sql.= " OR `id` = '" . $value . "'";
            }
            $count++;
        }
        $sql.= " LIMIT " . count($_POST['list']);

        if(check_allow()){
            mysqli_query($con,$sql);
        }

        echo 1;
        die();
    }else {
        echo 0;
        die();
    }
}

function addBlogCat()
{
    global $con,$config;

    $name = validate_input($_POST['name']);
    if (trim($name) != '' && is_string($name)) {
        $slug = create_blog_cat_slug($name);
        $query = "Insert into `".$config['db']['pre']."blog_categories` set title='".$name."', slug='".$slug."'";
        if(check_allow()){
            $con->query($query);
            $id = $con->insert_id;

            $query = "UPDATE `".$config['db']['pre']."blog_categories` SET `position` = '" . $id . "' WHERE `id` = '" . $id . "'";
            $con->query($query);
        }
        else{
            $id =1;
        }
        $result = array();
        $result['name'] = $name;
        $result['id'] = $id;
        $result['slug'] = $slug;
        echo json_encode($result);
        die();
    } else {
        echo 0;
        die();
    }
}

function editBlogCat(){
    global $con,$config;

    $name = validate_input($_GET['title']);
    $slug = validate_input($_GET['slug']);
    $status = validate_input($_GET['status']);
    $id = validate_input($_GET['id']);
    if (trim($name) != '' && is_string($name) && trim($id) != '') {
        if(empty($slug))
            $slug = create_slug($name);
        else
            $slug = create_slug($slug);

        $query = "UPDATE `".$config['db']['pre']."blog_categories` SET `title` = '".$name."', `slug` = '".$slug."', `active` = '".$status."' WHERE `id` = '" . $id . "'";
        if(check_allow()){
            $con->query($query);
        }

        echo 1;
        die();
    } else {
        echo 0;
        die();
    }
}

function delBlogCat(){
    global $con,$config;

    $ids = validate_input($_POST['ids']);
    if (is_array($ids)) {
        foreach ($ids as $id) {
            if(check_allow()){
                $con->query("DELETE FROM `".$config['db']['pre']."blog_categories` WHERE `id` = '" . $id . "'");
            }
        }
        echo 1;
        die();
    } else {
        echo 0;
        die();
    }
}

function deleteTestimonial(){
    global $con,$config;
    if(isset($_POST['id']))
    {
        $_POST['list'][] = validate_input($_POST['id']);
    }

    if (is_array($_POST['list']))
    {
        $count = 0;
        $sql = "DELETE FROM `".$config['db']['pre']."testimonials` ";
        $sql2 = "SELECT image FROM `".$config['db']['pre']."testimonials` ";
        foreach ($_POST['list'] as $value)
        {
            if($count == 0)
            {
                $sql.= "WHERE `id` = '" . $value . "'";
                $sql2.= "WHERE `id` = '" . $value . "'";
            }
            else
            {
                $sql.= " OR `id` = '" . $value . "'";
                $sql2.= " OR `id` = '" . $value . "'";
            }
            $count++;
        }
        $sql.= " LIMIT " . count($_POST['list']);

        if(check_allow()){
            if ($result = $con->query($sql2)) {
                while ($row = mysqli_fetch_assoc($result)) {

                    $uploaddir =  "../storage/testimonials/";
                    // delete logo
                    $file = $uploaddir.$row['image'];
                    if(file_exists($file))
                        unlink($file);
                }
            }
            mysqli_query($con,$sql);
        }

        echo 1;
        die();
    }else {
        echo 0;
        die();
    }
}
?>