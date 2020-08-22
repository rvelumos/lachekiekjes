<?=$this->getCrumblePath();?>
<? if(isset($msg['notice'])) echo $msg['notice'];?>
<div class='editform'>
<form method="post" enctype="multipart/form-data" name="add_blog_form" action="<?=$_SERVER['PHP_SELF']."?".htmlentities($_SERVER['QUERY_STRING'])?>" >
<input type="hidden" name="project_form" value="add_blog" />
<table>
<tr><td class='fields'><? if(isset($msg['album_exists'])) echo $msg['album_exists'];?></td></tr>
<? if(isset($error['name'])){ ?><tr><td class='fields'></td></tr> <? }?>
<tr><td class='fields'><span>Project naam:</span><? if(isset($error['name'])) echo $error['name'];?></td></tr>
<tr><td class='fields'><input type='text' name="name" class='field <? if(isset($error['name'])){ ?>input_error<?}?>' value="<? if(isset($_POST['name'])) echo $_POST['name'];?>" /> </td></tr>
<tr><td class='fields'><span>Project omschrijving:</span></td></tr>
<tr><td class='fields'><input type='text' name="description" class='field <? if(isset($error['description'])){ ?>input_error<?}?>' value="<? if(isset($_POST['description'])) echo $_POST['description'];?>" /> </td></tr>
<tr><td class='fields'><span>Extra foto's buiten pakket:</span></td></tr>
<tr><td class='fields'><input type='text' name="photos_extra_qty" class='field' value="<? if(isset($_POST['photos_extra_qty'])) echo $_POST['photos_extra_qty'];?>" /> </td></tr>
<tr><td class='fields'><span>Extra wensen:</span></td></tr>
<tr><td class='fields'><textarea name="extra" class='area <? if(isset($error['extra'])){ ?>input_error<?}?>' ><? if(isset($_POST['extra'])) echo $_POST['extra'];?></textarea> </td></tr>
<tr><td class='fields'><span>Shoot datum:</span><? if(isset($error['start_date'])) echo $error['start_date'];?></td></tr>
<tr><td class='fields'><input type='text' name="start_date" id='calendar' class='field_small <? if(isset($error['start_date'])){ ?>input_error<?}?>' value="<? if(isset($_POST['start_date'])) echo $_POST['start_date'];?>" /> </td></tr>
<tr><td class='fields'><span>Project einddatum:</span><? if(isset($error['end_date'])) echo $error['end_date'];?></td></tr>
<tr><td class='fields'><input type='text' name="end_date" id='calendar2' class='field_small <? if(isset($error['end_date'])){ ?>input_error<?}?>' value="<? if(isset($_POST['end_date'])) echo $_POST['end_date'];?>" /> </td></tr>
<tr><td class='fields'><span>Gekozen pakket:</span><? if(isset($error['packet'])) echo $error['packet']?></td></tr>
<tr><td class='fields'><? $this->availablePackets("project");?> </td></tr>
<!--<tr><td class='fields'><span>Project thumb(max. 200x200):</span><?if(isset($error['thumb'])){?><span class='error_astx'>*</span><?}?>  </td></tr>
<tr><td class='fields'><input type="file" class='file' name="thumb" value="" /></td><td><? if(isset($error['thumb'])) echo $error['thumb'];?></td></tr>-->
<? if(isset($error['status'])){ ?><tr><td class='fields'><? if(isset($error['status'])) echo $error['status'] ?></td></tr> <? }?>
<tr><td class='fields'><span>Project zichtbaar?:</span></td></tr>
    <tr><td class='fields'><select name='status'>

 <?
 
 if(isset($_POST['status'])){
	 if($_POST['status']==0){?>
	<option value='<?=$_POST['status']; ?>'>Nee</option>
	<?}else{?>
	<option value='<?=$_POST['status']; ?>'>Ja</option>
	<?}
}?>
<option value=' '> &nbsp;</option>
<option value='0'>Nee</option>
<option value='1'>Ja</option>
</select></td><td></td></tr>
<tr><td class='fields'><input type="submit" class="submit" value="Toevoegen" /></td></tr>
</table>
</form>
</div>

