<?php

define('ROOT', '');
require(ROOT.'config.inc.php');

session_start();
$page = 'index';
$message="";

require(ROOT.'classes/content_class.php');


$content = new Content;

$settings = $content->getSettings();
$path_info = $content->parse_path();

if($path_info['call_parts'][0]=="album")
	$album_hash=$path_info['call_parts'][1];	

	if(isset($album_hash)){
		require(ROOT.'templates/user_template.php');
		echo $content->loadAlbumContent();
	}else{
		require(ROOT.'templates/top.php');
		echo $content->loadContent();
	}
	
		require(ROOT.'templates/bottom.php');
	if(!isset($error))
		$content->visitorLog($message);

$content = NULL;

?>