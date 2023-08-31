<?php
// Path to root directory of app.
define("ROOTPATH", dirname(__FILE__));
// Path to app folder.
define("APPPATH", ROOTPATH."/php/");

// Check if SSL enabled
$protocol = isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] && $_SERVER["HTTPS"] != "off"
    ? "https://" : "http://";

// Define APPURL
$site_url = $protocol
    . $_SERVER["HTTP_HOST"]
    . (dirname($_SERVER["SCRIPT_NAME"]) == DIRECTORY_SEPARATOR ? "" : "/")
    . trim(str_replace("\\", "/", dirname($_SERVER["SCRIPT_NAME"])), "/");

define("SITEURL", $site_url);

require_once ROOTPATH . '/includes/config.php';

if(!isset($config['installed'])) {
    $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
    $site_url = $protocol . $_SERVER['HTTP_HOST'] . str_replace ("index.php", "", $_SERVER['PHP_SELF']);
    header("Location: ".$site_url."install/");
    exit;
}

require_once ROOTPATH . '/includes/lib/AltoRouter.php';

// Start routing.
$router = new AltoRouter();
$bp = trim(str_replace("\\", "/", dirname($_SERVER["SCRIPT_NAME"])), "/");
$router->setBasePath($bp ? "/".$bp : "");

/* Setup the URL routing. This is production ready. */
foreach (glob(APPPATH."*") as $dir) {
    if(is_dir($dir) && file_exists($dir.'/_route.php')){
        require_once $dir.'/_route.php';
    }

}
// API Routes
require_once ROOTPATH . '/includes/autoload.php';
define("TEMPLATE_PATH", ROOTPATH.'/templates/'.$config['tpl_name']);
define("TEMPLATE_URL", SITEURL.'/templates/'.$config['tpl_name']);

$config['app_url'] = get_site_url(SITEURL)."/php/";

/* Match the current request */
$match=$router->match();

if(isset($match['params']['lang'])) {
    if ($match['params']['lang'] != ""){
        change_user_lang($match['params']['lang']);
    }
}
if(file_exists(ROOTPATH . '/includes/lang/lang_'.$config['lang'].'.php')){
    require_once ROOTPATH . '/includes/lang/lang_'.$config['lang'].'.php';
}else{
    require_once ROOTPATH . '/includes/lang/lang_english.php';
}

if($match) {
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $_GET = array_merge($match['params'],$_GET);
    }

    sec_session_start();
    $mysqli = db_connect();

    require APPPATH.$match['target'];
}
else {
   header("HTTP/1.0 404 Not Found");
   require APPPATH.'global/404.php';
}