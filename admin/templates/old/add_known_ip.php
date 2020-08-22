
	<?=$msg['notice']?>
<div class='medium_editform'>

<b>Bekend ip toevoegen</b>
<form method="post" enctype="multipart/form-data" name="blacklist_form" action="<?=$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']?>" >
<input type="hidden" name="add_ip" value="new_info" />
				<table style='margin-top:10px; float:left;'>
					<tr><td class='fields'><span>IP :</span> <?=$error['ip']?></td><td></td></tr>
                <tr><td class='fields'><input type='text' class='field <? if($error['ip']){?>input_error<?}?>' name='ip' value='<?=$_GET['add_user_ip']?>' /></td><td></td></tr>
					<tr><td class='fields'><span>Naam :</span> <?=$error['name']?></td><td></td></tr>
                <tr><td class='fields'><input type='text' class='field <? if($error['name']){?>input_error<?}?>'name='name' value=''/></td><td></td></tr>        
				<tr><td class='fields'><input type="submit" class="submit" value="Opslaan" /></td><td></td></tr></table></form>
</div>