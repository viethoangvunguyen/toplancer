<?php
if(checkloggedin()) {

    $where .= "where user_id =" .$_SESSION['user']['id'];
    $query = "SELECT p.*
    FROM `".$config['db']['pre']."qbm_banners`  p $where";
    $result = ORM::for_table($config['db']['pre'].'qbm_banners')->raw_query($query)->find_many();

    //Print Template
    HtmlTemplate::display('service_manage', array(
        'banner_ads' => $result
    ));
    exit;
}
else{
    error(__("Page Not Found"), __LINE__, __FILE__, 1);
    exit();
}
?>
