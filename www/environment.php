<?php
//###########################################
//############### ENVIRONMENT ###############
//###########################################
$fullURL = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
if (getenv('ENV') == "production") {
  $env = 1;
  $debug = 0;
  $minify = 1;
} else {
  $env = 0;
  $debug = 1;
  $minify = 1;
  // ini_set('display_errors', 1);
  // ini_set('display_startup_errors', 1);
  // error_reporting(E_ALL);
}

//#########################################
//############### KEYS & SALTS ############
//#########################################
$websitesalt = "###############";
$encryption_key   = "###############";
$fb_app_id = "###############";
$fb_app_secret = "###############";
$fb_default_graph_version = "v10.0";

//#########################################
//############### CONSTANTS ###############
//#########################################
$php_base_directory = "/var/www/html";
$new_code_timer = (int)getenv('NEW_CODE_TIMER');
if (str_contains($fullURL, 'brocode-v4-web.')) {
  $base_url = "https://brocode-v4-web.kooky.work";
  $static_url = "https://brocode-v4-web.kooky.work/styles";
  $cdn_url = "https://brocode-v4-web.kooky.work/uploads";
  $avatars_url = "https://brocode-v4-web.kooky.work/avatars";
  $root_url = "https://brocode-v4-web.kooky.work";
  $temp_url = "https://brocode-v4-web.kooky.work/tempfiles";
} else if (str_contains($fullURL, ':1099')) {
  $base_url = "http://192.168.1.66:1099";
  $static_url = "http://192.168.1.66:1099/styles";
  $cdn_url = "http://192.168.1.66:1099/uploads";
  $avatars_url = "http://192.168.1.66:1099/avatars";
  $root_url = "http://192.168.1.66:1099";
  $temp_url = "http://192.168.1.66:1099/tempfiles";
} else if (str_contains($fullURL, 'bangtidy.net')) {
  header("HTTP/1.1 301 Moved Permanently");
  header("Location: https://brocode.org");
} else {
  $base_url = "https://brocode.org";
  $static_url = "https://brocode.org/styles";
  $cdn_url = "https://brocode.org/uploads";
  $avatars_url = "https://brocode.org/avatars";
  $root_url = "https://brocode.org";
  $temp_url = "https://brocode.org/tempfiles";
}

//##############################################
//############### DB CREDENTIALS ###############
//##############################################
$dbhost = getenv('MYSQL_HOST');
$dbname = getenv('MYSQL_DATABASE');
$dbuser = getenv('MYSQL_USER');
$dbpw = getenv('MYSQL_PASSWORD');

//##############################################
//############### DB CREDENTIALS ###############
//##############################################
$smtp_host = 'smtp.protonmail.ch';
$smtp_username = 'bfam@brocode.org';
$smtp_password = '###############';
$smtp_ssltype = 'tls';
$smtp_port = 587;
$smtp_from = 'bfam@brocode.org';
$smtp_fromname = 'The Bro Code';

$smtp_logo = 'https://brocode.org/styles/images/logo_alt.png';

//######################################
//############### SYSYEM ###############
//######################################
$server_name = $_SERVER['SERVER_NAME'];
if (isset($_SERVER['HTTP_X_REAL_IP'])) {
  $user_ip = $_SERVER['HTTP_X_REAL_IP'];
} else {
  $user_ip = $_SERVER['REMOTE_ADDR'];
}
$user_agent = "";
if (isset($_SERVER['HTTP_USER_AGENT'])) {
  $user_agent = $_SERVER['HTTP_USER_AGENT'];
}
