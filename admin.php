<?php
session_start();

$title = 'Administrator gedeelte website';
$page = 'admin';

require('config.inc.php');
//require('classes/db_class.php');
require('admin/classes/admin_class.php');
include("classes/browser.php");
//menu items laden
$admin = new Admin;
$settings = $admin->getSettings();

require('admin/templates/top_admin.php');

if (isset($_SESSION['auth_admin_login'])){
	
	if(isset($_GET['uitloggen'])){
		session_destroy();
		echo "<meta http-equiv=\"refresh\" content=\"2;URL=admin.php\" />";
		echo "<p class='notify_login'>Je bent nu uitgelogd, moment geduld...</p>";
		die();
	}
	
	//include('templates/admin_template.php');	

	switch($_GET['section']){
		
		case "settings": 
			$admin->setSettings($settings);
		break;
		
		case "content": 
			$admin->contentOverview();
		break;
		
		case "photoalbums": 
			$admin->albumOverview();
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
	
require('admin/templates/admin_bottom.php');
}else{
	$admin->authLogin();
}

$admin = NULL;

?>