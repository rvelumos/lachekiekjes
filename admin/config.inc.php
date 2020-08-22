<?php
setlocale(LC_ALL, 'nl_NL');

$prefix = "lumos_";

$ip = $_SERVER['REMOTE_ADDR'];
$url = $_SERVER['QUERY_STRING'];
$webhost = gethostbyaddr($ip);;
$server = $_SERVER['SERVER_NAME'];
$server_user = $_SERVER['HTTP_USER_AGENT'];
$method = $_SERVER['REQUEST_METHOD'];

define("SHOW_ALL_ERRORS", FALSE);
define("ROOT_URL", "https://www.ronald-designs.nl/development/projects/lachekiekjes/admin/");

ini_set('display_errors', 1); 
error_reporting(E_ALL);

?>