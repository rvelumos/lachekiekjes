<?=$this->getCrumblePath();?>
<? if(isset($msg['image'])) echo $msg['image']?>
<? if(isset($msg['notice'])) echo $msg['notice']?>
<div class='editform'>
<form method="post" enctype="multipart/form-data" name="edit_album_form" action="<?=htmlentities($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'])?>" >
<table>
<tr><td><input type="hidden" name="edit_project" value="edit_album" /></td></tr>
<tr><td class='fields'><span>Project naam:</span><?if(isset($error['name'])){?><?=$error['name'];?><?}?> </td></tr>
<tr><td class='fields'><input type='text' name="name" class='field <?if(isset($error['name'])){?>input_error<?}?>' value="<?=$project_details['name']?>" /> </td></tr>
<tr><td class='fields'><span>Project omschrijving:</span></td></tr>
<tr><td class='fields'><input type='text' name="description" class='field <? if(isset($error['description'])){ ?>input_error<?}?>' value="<? if(isset($project_details['description'])) echo $project_details['description'];?>" /> </td></tr>
<tr><td class='fields'><span>Extra foto's buiten pakket:</span></td></tr>
<tr><td class='fields'><input type='text' name="photos_extra_qty" class='field' value="<? if(isset($project_details['photos_extra_qty'])) echo $project_details['photos_extra_qty'];?>" /> </td></tr>
<tr><td class='fields'><span>Extra wensen:</span></td></tr>
<tr><td class='fields'><textarea name="extra" class='area <? if(isset($error['extra'])){ ?>input_error<?}?>' ><? if(isset($project_details['extra'])) echo $project_details['extra'];?></textarea> </td></tr>
<tr><td class='fields'><span>Shoot datum:</span><? if(isset($error['start_date'])) echo $error['start_date'];?></td></tr>
<tr><td class='fields'><input type='text' name="start_date" id='calendar' class='field_small <? if(isset($error['start_date'])){ ?>input_error<?}?>' value="<? if(isset($project_details['start_date'])) echo $project_details['start_date'];?>" /> </td></tr>
<tr><td class='fields'><span>Project einddatum:</span><? if(isset($error['end_date'])) echo $error['end_date'];?></td></tr>
<tr><td class='fields'><input type='text' name="end_date" id='calendar2' class='field_small <? if(isset($error['end_date'])){ ?>input_error<?}?>' value="<? if(isset($project_details['end_date'])) echo $project_details['end_date'];?>" /> </td></tr>
<tr><td class='fields'><span>Gekozen pakket:</span><? if(isset($error['packet'])) echo $error['packet']?></td></tr>
<tr><td class='fields'><? $this->availablePackets("project", $project_id, $project_details['packet']);?> </td></tr>
<tr><td>
<div id='last_field'>
</div></td></tr>
<tr><td class='fields'><span>Status</span></td></tr>
    <tr><td class='fields'><select name='status'>
 <?if($album_details['status']==0){?>
<option value='<?=$album_details['status']; ?>'>Niet openbaar</option>
<?}else{?>
<option value='<?=$album_details['status']; ?>'>Openbaar</option>
<?}?>
<option value=' '> </option>
<option value='0'>Niet openbaar</option>
<option value='1'>Openbaar</option>
</select><? if(isset($error['status'])) echo $error['status'];?></td></tr>
<tr><td class='fields'><input type="submit" class="submit" value="Bewerken" /></td></tr>
</table>
</form>
</div>


