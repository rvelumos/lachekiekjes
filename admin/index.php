<?php
session_start();

$title = 'Administrator gedeelte website';
$page = 'admin';
define("ROOT","");

require('config.inc.php');
require('classes/main_class.php');
require('classes/auth_class.php');
require('classes/admin_class.php');

//menu items laden
$main = new Main();
$admin = new Admin();
$auth = new Auth();
$settings = $main->getSettings();

if(isset($_SESSION['auth_lachekiekjes_login'])){	
	if(isset($_GET['uitloggen']) ||$auth->sessionTimeout()){
		if($auth->sessionTimeout())
			$error["login"]=$main->message("ERROR","De sessie is verlopen, log opnieuw in");
		
		session_destroy();
		$_SESSION = array();
	}
	$_SESSION['last_activity'] = time();
}

require(ROOT.'templates/top_admin.php');

if (isset($_SESSION['auth_lachekiekjes_login'])){

	if(!isset($_GET['section']))$_GET['section']="";
	switch($_GET['section']){
		
		case "settings": 
			$main->setSettings($settings);
		break;
		
		case "invoices": 
			$admin->invoiceOverview();
		break;
		
		default:
		
		case "content": 
			$admin->contentOverview();
		break;
		
		case "packets": 
			$admin->packetOverview();
		break;
		
		case "projects": 
			$admin->projectOverview();
		break;
		
		case "portfolio": 
			$admin->portfolioOverview();
		break;

		case "beveiliging": 
			$admin->security();
		break;
		
		case "log": 
			$admin->logOverview();
		break;		
	}
	
	require(ROOT.'templates/admin_bottom.php');
}else{
	$auth->authLogin();
}

$main = NULL;
$admin = NULL;

?>