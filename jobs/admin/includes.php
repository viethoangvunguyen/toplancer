<?php
define("ROOTPATH", dirname(__DIR__));
define("APPPATH", ROOTPATH."/php/");
define("ADMINPATH", __DIR__);

require_once ROOTPATH . '/includes/autoload.php';
require_once ROOTPATH . '/includes/lang/lang_'.$config['lang'].'.php';

$admin_folder = isset($config['admin_folder'])? $config['admin_folder'] : "admin";
$admin_url = $config['site_url'].$admin_folder."/";
define("SITEURL", $config['site_url']);
define("ADMINURL", $admin_url);

$mysqli = db_connect();
admin_session_start();
if (!checkloggedadmin()) {
    headerRedirect(ADMINURL.'login.php');
}
include('header.php');