
<?
echo $this->getCrumblePath();
 
//if($settings['img_quota']!=0)
	//echo $this->image_quota_status();
$quota = $this->image_quota();

if($quota==FALSE)
	$disabled = "disabled = disabled ";

?>
<? 		
echo "<div class='medium_image'><img src='image.php?thumb=../{$image['image']}&amp;size=$size' alt='' /></div>";
 ?>
<? if(isset($msg['image'])) echo $msg['image']?>
<div class='editform'>

<form method="post" enctype="multipart/form-data" name="add_blog_form" action="<?=htmlentities($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'])?>" >
<table>
<tr><td><input type="hidden" name="edit_image" value="add_blog" /></td></tr>
<tr><td>Categorie: <select name='category' class='field'>
<? $this->getSelectfieldItems($category, "id", "portfoliocategories") ?>
</select><p></p></td></tr>
<tr><td>Tonen op pagina: <select name='show_page' class='field'>
<? $this->getSelectfieldItems($e_id, "show_page", "info") ?>
</select><p></p></td></tr>
 <tr><td class='fields'>Order : </td></tr>
                <tr><td class='fields'><input class='field <? if(isset($error['order'])){?>input_error<?}?>' type="text" name="order" value="<? if(isset($order)) echo $order?>"/></td></tr>
<tr><td class='fields'><input type="submit" class="submit" value="Bewerken" /></td></tr>
</table>
</form>
</div>


