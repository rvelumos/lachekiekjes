<? if(isset($msg['notice'])) echo $msg['notice']?>
<div class='editform'>
	
<b>Ip toevoegen aan blacklist</b>
<form method="post" enctype="multipart/form-data" name="blacklist_form" action="<?=$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']?>" >
<input type="hidden" name="add_blacklist" value="new_info" />
				<table style='margin-top:10px; float:left;'>
					<tr><td class='fields'>IP : <? if(isset($error['ip'])) echo $error['ip']?></td><td></td></tr>
                <tr><td class='fields'><input type='text' class='field <? if(isset($error['ip'])){?>input_error<?}?>' name='ip' value=''/></td><td></td></tr>
					<tr><td class='fields'>Reden : <? if(isset($error['ip'])) echo $error['reason']?></td><td></td></tr>
                <tr><td class='fields'><input type='text' class='field <? if(isset($error['reason'])){?>input_error<?}?>'name='reason' value=''/></td><td></td></tr>        
				<tr><td class='fields'><input type="submit" class="submit" value="Opslaan" /></td><td></td></tr></table></form>
</div>