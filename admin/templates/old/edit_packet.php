<?=$this->getCrumblePath();?>

<? if(isset($msg['notice'])) echo $msg['notice']?>
<div class='editform'>


<form method="post" enctype="multipart/form-data" name="packet_form" action="<?=$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']?>" >
<input type="hidden" name="edit_packet" value="new_info" />
				<table style='margin-top:10px; float:left;'>
				<tr><td class='fields'><span>Naam :</span> <? if(isset($error['name'])) echo $error['name']?></td><td></td></tr>
                <tr><td class='fields'><input class='field <? if(isset($error['name'])){?>input_error<?}?>' type="text" name="name" value="<? if(isset($packet['name'])) echo $packet['name']?>"/></td><td></td></tr>
                <tr><td class='fields'><span>Prijs :</span> <? if(isset($error['price'])) echo $error['price']?></td><td></td></tr>
                <tr><td class='fields'><input class='field <? if(isset($error['price'])){?>input_error<?}?>' type="text" name="price" value="<? if(isset($packet['price'])) echo $packet['price']?>"/></td><td></td></tr>
                  <tr><td class='fields'><span>Aantal foto's :</span> <? if(isset($error['photos'])) echo $error['photos']?></td><td></td></tr>
                <tr><td class='fields'><input class='field <? if(isset($error['photos'])){?>input_error<?}?>' type="text" name="photos" value="<? if(isset($packet['photos']))echo $packet['photos']?>"/></td><td></td></tr>
                <tr><td class='fields'><span>Kosten extra foto's per stuk :</span> <? if(isset($error['photos_extra'])) echo $error['photos_extra'];?></td><td></td></tr>
                <tr><td class='fields'><input maxlength="10" class='field_small' size='10' class='small_field' type='text' name='photos_extra' value='<? if(isset($_POST['photos_extra'])) echo $_POST['photos_extra']?>'  /></td></tr>
                <tr><td class='fields'><span>Inhoud pakket :</span></td><td></td></tr>
                <tr><td class='fields'><textarea name="extra"><? if(isset($packet['extra'])) echo $packet["extra"]?></textarea></td><td></td></tr>
				<tr><td class='fields'><input type="submit" class="submit" value="Opslaan" /></td><td></td></tr></table></form></div>
