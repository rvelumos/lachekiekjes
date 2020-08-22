<?
$max_no_img=1; 
?>

<?=$this->getCrumblePath();?>
<? 
if($settings['img_quota']!=0)
	echo $this->image_quota_status();
$quota = $this->image_quota();

if($quota==FALSE)
	$disabled = "disabled = disabled ";

?>

<?if(isset($msg['image']))echo $msg['image'];?>
<div class='editform'>

<form method="post" enctype="multipart/form-data" name="add_blog_form" action="<?=htmlentities($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'])?>" >
<table>
<tr><td><input type="hidden" name="upload_images" value="add_blog" /></td></tr>
<tr><td><img src='<?=ROOT?>images/plus.png' onclick="add()" alt='Rij toevoegen'/> <a href='#' onclick="add()">Extra veld toevoegen</a><p></p></td></tr>
<? for($i=1; $i<=$max_no_img; $i++){?>
    <tr><td class='fields'><span>Afbeelding:</span><?if(isset($error['afbeelding'])){?><span class='error_astx'>*</span><?}?>  </td></tr>
    <tr><td class='fields'><input type="file" class='file' name="afbeeldingen[]" value="" /></td><td><?if(isset($error['afbeelding'])){ echo $error['afbeelding'];}?></td></tr>
<? } ?>
<tr><td>
<div id='image_input'>
</div></td></tr>

<tr><td>
<div id='last_field'>
</div></td></tr>

<tr><td class='fields'><input type="submit" class="submit" value="Toevoegen" /></td></tr>
</table>
</form>
</div>


