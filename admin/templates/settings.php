
<div style='margin:10px 25px; float:left; clear:both; width:100%;'>
<ul id="setting_tabs" class="shadetabs">
<li><a href="#" rel="setting1" class="selected">Website</a></li>
<li><a href="#" rel="setting2">CMS</a></li>
</ul>
</div>
   <div class='settingsform'>


<form method="post" enctype="multipart/form-data" name="settings_form" action="<?=$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']?>" >
<input type="hidden" name="settings" value="edit_settings" />



<!-- setting 1 -->
<div id='setting1' class='tab'>
    <p class='header'>Algemeen</p>
    <table class='hidden_settings'>
    <tr><td class='fields'>Naam website:<? if(isset($error['website_name'])) echo $error['website_name'];?> </td></tr>
    <tr><td class='fields'><input type="text" class='field' name="website_name" value="<? if(isset($settings['website_name'])) echo $settings['website_name']?>" /></td></tr>
    <tr><td class='fields'>Website bar tekst: <? if(isset($error['website_name'])) echo $error['head_titel'];?> </td></tr>
    <tr><td class='fields'><input type="text" class='field' name="head_titel" value="<? if(isset($settings['head_titel'])) echo htmlentities($settings['head_titel'])?>"  /></td></tr>
        <tr><td class='fields'>Website status:</td></tr>
        <tr><td class='fields'><select name='website_status'>
     <?if($settings['website_status']==0){?>
    <option value='0'>Gesloten</option>
    <?}elseif($settings['website_status']==1){?>
    <option value='1'>In onderhoud</option>
    <?}else{?>
    <option value='2'>Open</option>
    <?}?>
    <option value=' '>&nbsp;</option>
    <option value='0'>Gesloten</option>
    <option value='1'>In onderhoud</option>
    <option value='2'>Open</option>
    </select></td><td><? if(isset($error['website'])) echo $error['website_status'];?></td></tr>
        <tr><td class='fields'><input type="submit" class="submit" value="Wijzigen" /></td></tr>
    </table>
    
    <p class='header'>Metatags</p>
    <table class='hidden_settings'>
    <tr><td class='fields'>Description:<? if(isset($error['meta_description'])) echo $error['meta_description'];?> </td></tr>
    <tr><td class='fields'><input type="text" class='field' name="meta_description" value="<? if(isset($settings['meta_description'])) echo $settings['meta_description']?>" /></td></tr>
    <tr><td class='fields'>Keywords: <? if(isset($error['meta_keywords'])) echo $error['meta_keywords'];?> </td></tr>
    <tr><td class='fields'><input type="text" class='field' name="meta_keywords" value="<? if(isset($settings['meta_keywords'])) echo htmlentities($settings['meta_keywords'])?>"  /></td></tr>
    <tr><td class='fields'>Copyright: <? if(isset($error['meta_copyright'])) echo $error['meta_copyright'];?> </td></tr>
    <tr><td class='fields'><input type="text" class='field' name="meta_copyright" value="<? if(isset($settings['meta_copyright'])) echo htmlentities($settings['meta_copyright'])?>"  /></td></tr>
        <tr><td class='fields'>Auteur: <? if(isset($error['meta_author'])) echo $error['meta_author'];?> </td></tr>
    <tr><td class='fields'><input type="text" class='field' name="meta_author" value="<? if(isset($settings['meta_author'])) echo htmlentities($settings['meta_author'])?>"  /></td></tr>
    <tr><td class='fields'>Robots: <? if(isset($error['meta_robots'])) echo $error['meta_robots'];?> </td></tr>
    <tr><td class='fields'><input type="text" class='field' name="meta_robots" value="<? if(isset($settings['meta_robots'])) echo htmlentities($settings['meta_robots'])?>"  /></td></tr>
        <tr><td class='fields'><input type="submit" class="submit" value="Wijzigen" /></td></tr>
    </table>
    
    <p class='header'>Portfolio</p>
    <table class='hidden_settings'>
    <tr><td class='fields'>Aantal foto's per pagina: <? if(isset($error['pf_max_images'])) echo  $error['pf_max_images'];?> </td></tr>
<tr><td class='fields'><input type="text" class='small_field' name="pf_max_images" maxlength="3" size='3' value="<? if(isset($settings['pf_max_images'])) echo $settings['pf_max_images']?>"  /></td></tr>
    <tr><td class='fields'>Categorie&euml;n:</td></tr>
        <tr><td class='fields'><select name='pf_category'>
     <?if($settings['pf_category']==0){?>
    <option value='<?=$settings['pf_category']; ?>'>Nee</option>
    <?}else{?>
    <option value='<?=$settings['pf_category']; ?>'>Ja</option>
    <?}?>
    <option value=' '>&nbsp;</option>
    <option value='0'>Nee</option>
    <option value='1'>Ja</option>
    </select></td><td><? if(isset($error['pf_category'])) echo $error['pf_category'];?></td></tr>
    
    <tr><td class='fields'>Foto vergrootbaar: <? if(isset($error['pf_larger'])) echo $error['pf_larger'];?> </td></tr>
        <tr><td class='fields'><select name='pf_larger'>
     <?if($settings['pf_larger']==0){?>
    <option value='<?=$settings['pf_larger']; ?>'>Nee</option>
    <?}else{?>
    <option value='<?=$settings['pf_larger']; ?>'>Ja</option>
    <?}?>
    <option value=' '>&nbsp;</option>
    <option value='0'>Nee</option>
    <option value='1'>Ja</option>
    </select></td><td><? if(isset($error['pf_larger'])) echo $error['pf_larger'];?></td></tr>
    
    <tr><td class='fields'><input type="submit" class="submit" value="Wijzigen" /></td></tr>
    </table>
    
        
    <p class='header'>Contactformulier</p>
    <table class='hidden_settings'>
    <tr><td class='fields'>E-mail ontvanger:<? if(isset($error['website_name'])) echo $error['website_name'];?> </td></tr>
    <tr><td class='fields'><input type="text" class='field' name="em_receiver" value="<? if(isset($settings['em_receiver'])) echo $settings['em_receiver']?>" /></td></tr>
    <tr><td class='fields'>E-mail BCC: <? if(isset($error['head_titel'])) echo $error['head_titel'];?> </td></tr>
    <tr><td class='fields'><input type="text" class='field' name="em_bcc" value="<? if(isset($settings['meta_robots'])) echo $settings['em_bcc']?>"  /></td></tr>
    <tr><td class='fields'>E-mail tekst bevestiging: <? if(isset($error['text_send_mail'])) echo $error['text_send_email'];?> </td></tr>
    <tr><td class='fields'><textarea class='area' name="text_send_email" id="textarea" rows="10" cols="10"><? if(isset($settings['text_send_mail'])) echo $settings['text_send_email']?></textarea></td></tr>
    <tr><td class='fields'>E-mail template (#bericht# niet verwijderen) </td></tr>
    <tr><td><textarea class='area' name="em_template" id="textarea" rows="40" cols="20"><? if(isset($settings['em_temnplate'])) echo $settings['em_template']?></textarea></td></tr>
    <tr><td class='fields'><input type="submit" class="submit" value="Wijzigen" /></td></tr>
    </table>
</div>

<!-- setting 2 -->
<div id='setting2' class='tab'>
<p class='header'>Content instellingen</p>
<table class='hidden_settings'>
<tr><td class='fields'>Tiny MCE gebruiken: <? if(isset($error['use_tiny_mce'])) echo $error['use_tiny_mce'];?> </td></tr>
<tr><td class='fields'><select name='use_tiny_mce'>
 <?if($settings['use_tiny_mce']==0){?>
<option value='<?=$settings['use_tiny_mce']; ?>'>Nee</option>
<?}else{?>
<option value='<?=$settings['use_tiny_mce']; ?>'>Ja</option>
<?}?>
<option value=' '>&nbsp;</option>
<option value='0'>Nee</option>
<option value='1'>Ja</option>
</select></td><td><? if(isset($error['pf_category'])) echo $error['pf_category'];?></td></tr>
<tr><td class='fields'><input type="submit" class="submit" value="Wijzigen" /></td></tr>
</table>

<p class='header'>Foto instellingen</p>
<table class='hidden_settings'>
<tr><td class='fields'>Max quota (in mb, 0=ongelimiteerd): <? if(isset($error['img_quota'])) echo $error['img_quota'];?> </td></tr>
<tr><td class='fields'><input type="text" class='small_field' name="img_quota" maxlength="4" size='4' value="<? if(isset($settings['img_quota'])) echo $settings['img_quota']?>"  /></td></tr>
<tr><td class='fields'>Aantal foto's per pagina: <? if(isset($error['max_images'])) echo  $error['max_images'];?> </td></tr>
<tr><td class='fields'><input type="text" class='small_field' name="max_images" maxlength="3" size='3' value="<? if(isset($settings['max_images'])) echo $settings['max_images']?>"  /></td></tr>
<tr><td class='fields'>Foto maximum max. breedte: <? if(isset($error['max_width'])) echo  $error['max_width'];?> </td></tr>
<tr><td class='fields'><input type="text" class='small_field' name="max_width" maxlength="4" size='3' value="<? if(isset($settings['max_width'])) echo  $settings['max_width']?>"  /></td></tr>
<tr><td class='fields'>Foto maximum max. hoogte: <? if(isset($error['max_height'])) echo  $error['max_height'];?> </td></tr>
<tr><td class='fields'><input type="text" class='small_field' name="max_height" maxlength="4" size='3' value="<? if(isset($settings['max_height'])) echo $settings['max_height']?>"  /></td></tr>
<tr><td class='fields'>Preview foto grootte: <? if(isset($error['preview_size'])) echo $error['preview_size'];?> </td></tr>
<tr><td class='fields'><input type="text" class='small_field' name="preview_size" maxlength="4" size='3' value="<?=$settings['preview_size']?>"  /> px</td></tr>
<tr><td class='fields'>Niet lege albums verwijderen toestaan:</td></tr>
    <tr><td class='fields'><select name='delete_non_empty'>
 <?if($settings['delete_non_empty']==0){?>
<option value='<?=$settings['delete_non_empty']; ?>'>Nee</option>
<?}else{?>
<option value='<?=$settings['delete_non_empty']; ?>'>Ja</option>
<?}?>
<option value=' '>&nbsp;</option>
<option value='0'>Nee</option>
<option value='1'>Ja</option>
</select></td><td><? if(isset($error['delete_non_empty'])) echo $error['delete_non_empty'];?></td></tr>

<tr><td class='fields'>Toegestane extensies (komma gescheiden) <? if(isset($error['allowed_img_tags'])) echo $error['allowed_img_tags'];?> </td></tr>
<tr><td class='fields'><input type="text" class='field' name="allowed_img_tags" maxlength="30" size='30' value="<? if(isset($settings['allowed_img_tags'])) echo $settings['allowed_img_tags']?>"  /></td></tr>
<tr><td class='fields'>Maximum grootte (kb) <? if(isset($error['max_img_size'])) echo $error['max_img_size'];?></td></tr>
<tr><td class='fields'><input type="text" class='small_field' name="max_img_size" maxlength="10" size='10' value="<? if(isset($settings['max_img_size'])) echo $settings['max_img_size']?>"  /></td></tr>
<tr><td class='fields'>Maximum hoogte (in px): <? if(isset($error['max_img_height'])) echo $error['max_img_height'];?> </td></tr>
<tr><td class='fields'><input type="text" class='small_field' name="max_img_height" maxlength="4" size='4' value="<? if(isset($settings['max_img_height'])) echo $settings['max_img_height']?>"  /></td></tr>
<tr><td class='fields'>Maximum breedte (in px): <? if(isset($error['max_img_width'])) echo $error['max_img_width'];?> </td></tr>
<tr><td class='fields'><input type="text" class='small_field' name="max_img_width" maxlength="4" size='4' value="<? if(isset($settings['max_img_width'])) echo $settings['max_img_width']?>"  /></td></tr>
<tr><td class='fields'>Image path: <? if(isset($error['image_path'])) echo $error['image_path'];?> </td></tr>
<tr><td class='fields'><input type="text" class='small_field' name="image_path" value="<? if(isset($settings['image_path'])) echo $settings['image_path']?>" /></td></tr>
<tr><td class='fields'><input type="submit" class="submit" value="Wijzigen" /></td></tr>
</table>


<p class='header'>Sessie instellingen</p></td></tr>
<table class='hidden_settings'>
<tr><td>
<tr><td class='fields'>Maximum sessietijd (sec): <? if(isset($error['session_timeout'])) echo $error['session_timeout'];?> </td></tr>
<tr><td class='fields'><input type="text" class='small_field' name="session_timeout" maxlength="4" size='4' value="<? if(isset($settings['session_timeout'])) echo $settings['session_timeout']?>" /></td></tr>
<tr><td class='fields'><input type="submit" class="submit" value="Wijzigen" /></td></tr>
</table>

</form>

</div>


    <script type="text/javascript">
 
		var mysetting=new ddtabcontent("setting_tabs") //enter ID of Tab Container
		mysetting.setpersist(true) //toogle persistence of the tabs' state
		mysetting.setselectedClassTarget("link") //"link" or "linkparent"
		mysetting.init()
 
	</script>
</form>
</div>

