<div class='crumble_path'><a href='index.php?section=portfolio'>Portfolio</a> &raquo; <?=$cat['name']?> bewerken</div>
<? if(isset($msg['info'])) echo $msg['info']?>
<div class='editform'>
<form method="post" enctype="multipart/form-data" name="edit_form" action="<?=$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']?>" >
<input type="hidden" name="edit_cat" value="edit_cat" />
				<table style='margin-top:10px; float:left;'><tr><td class='header'>Categorie wijzigen:</td></tr>
				<tr><td class='fields'>Naam : <? if(isset($error['name'])) echo $error['name']?></td></tr>
                <tr><td class='fields'><input class='field <? if(isset($error['name'])){?>input_error<?}?>' type="text" name="name" value="<?=$cat['name']?>"/></td></tr>
                <tr><td class='fields'>Status:</td></tr><tr><td> <select name='status'>
 <?if($cat['status']==0){?>
<option value='<?=$cat['status']; ?>'>Niet actief</option>
<?}else{?>
<option value='<?=$cat['status']; ?>'>Actief</option>
<?}?>
<option value=' '> </option>
<option value='0'>Niet actief</option>
<option value='1'>Actief</option>
</select></td></tr>
				<tr><td class='fields'><input type="submit" class="submit" value="Wijzigen" /></td></tr></table></form>
</div>