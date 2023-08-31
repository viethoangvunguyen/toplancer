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

// Unset all session values
$_SESSION = array();

// get session parameters
$params = session_get_cookie_params();

// Delete the actual cookie.
setcookie(session_name(),
    '', time() - 42000,
    $params["path"],
    $params["domain"],
    $params["secure"],
    $params["httponly"]);

// Destroy session
session_destroy();
if (isset($_COOKIE['qarm'])) {
    unset($_COOKIE['qarm']);
    setcookie('qarm', null, -1, '/');
}
$url = ADMINURL."login.php";
headerRedirect($url);
?>

