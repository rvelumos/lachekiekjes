<?
session_start();

//ini_set('display_errors', 1); 
//error_reporting(E_ALL);
if($_SESSION['login_user']!=""){
	$edit_size = 150;
	
	if($_GET['thumb']!=""){
		$fn = $_GET['thumb'];
	}elseif($_GET['view_image']){
		$image=$_GET['view_image'];
		
		$link=mysqli_connect('localhost', '?', '?', "?");;
		
		$path = array();
		  if (isset($_SERVER['REQUEST_URI'])) {
			$request_path = explode('?', $_SERVER['REQUEST_URI']);
		
			$path['base'] = rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/');
			$path['call_utf8'] = substr(urldecode($request_path[0]), strlen($path['base']) + 1);
			$path['call'] = utf8_decode($path['call_utf8']);
			if ($path['call'] == basename($_SERVER['PHP_SELF'])) {
			  $path['call'] = '';
			}
			
			if ( ! isset($request_path[1])) {
				$request_path[1] = null;
			}
			
			$path['call_parts'] = explode('/', $path['call']);
		
			$path['query_utf8'] = urldecode($request_path[1]);
			$path['query'] = utf8_decode(urldecode($request_path[1]));
			$vars = explode('&', $path['query']);
			foreach ($vars as $var) {
			  $t = explode('=', $var);
			  if(!isset($t[1]))$t[1]=null;
			  $path['query_vars'][$t[0]] = $t[1];
			}
		  }
	
		//require('../config.inc.php');
	
		$sql="SELECT * FROM userimages WHERE id = '".$image."'";
			if(!$result = $link->query($sql))	
				die("Fout bij genereren afbeelding");
		$rs=$result->fetch_array(MYSQLI_BOTH);
		
		$fn = "admin/".$rs['image'];
	}else{
		$fn = $_GET['image_details'];
	}
	
	
	$size = getimagesize($fn);
	$ratio = $size[0]/$size[1]; // width/height
	
	//$edit_size = $_GET['size'];
	
	
	if( $ratio > 1) {
		$width = $edit_size;
		$height = $edit_size/$ratio;
	}
	else {
		$width = $edit_size*$ratio;
		$height = $edit_size;
	}
	
	if(isset($image)){
		$width=$size[0];
		$height=$size[1];	
	}
	
	$src = imagecreatefromstring(file_get_contents($fn));
	$dst = imagecreatetruecolor($width,$height);
	
	
	imagecopyresampled($dst,$src,0,0,0,0,$width,$height,$size[0],$size[1]);
	imagedestroy($src);
	imagejpeg($dst,NULL,100);// adjust format as needed
	imagedestroy($dst);
}else{
	die("Toegang geweigerd.");	
}
?>