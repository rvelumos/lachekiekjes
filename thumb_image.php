<?
if($_GET['thumb']!="")
	$fn = $_GET['thumb'];
else
	$fn = $_GET['image_details'];
	
$size = getimagesize($fn);
$ratio = $size[0]/$size[1]; // width/height

$edit_size = $_GET['size'];

if( $ratio > 1) {
    $width = $edit_size;
    $height = $edit_size/$ratio;
}
else {
    $width = $edit_size*$ratio;
    $height = $edit_size;
}

$src = imagecreatefromstring(file_get_contents($fn));
$dst = imagecreatetruecolor($width,$height);
imagecopyresampled($dst,$src,0,0,0,0,$width,$height,$size[0],$size[1]);
imagedestroy($src);
imagejpeg($dst,NULL,80); // adjust format as needed
imagedestroy($dst);

?>