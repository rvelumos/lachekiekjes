<?=$this->getCrumblePath();?>
<? if(isset($msg['notice'])) echo $msg['notice']?>
<div class='editform'>

<form method="post" enctype="multipart/form-data" name="packet_form" action="<?=$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']?>" >
<input type="hidden" name="add_packet" value="new_info" />
				<table style='margin-top:10px; float:left;'>
				<tr><td class='fields'><span>Naam :</span> <? if(isset($error['name'])) echo $error['name'];?></td><td></td></tr>
                <tr><td class='fields'><input type='text' class='field' name='name' value='<? if(isset($_POST['name'])) echo $_POST['name']?>'  /></td></tr>
                <tr><td class='fields'><span>Aantal foto's :</span> <? if(isset($error['photos'])) echo $error['photos'];?></td><td></td></tr>
                <tr><td class='fields'><input maxlength="10" class='field_small' size='10' class='small_field' type='text' name='photos' value='<? if(isset($_POST['photos'])) echo $_POST['photos']?>'  /></td></tr>
                 <tr><td class='fields'><span>Kosten extra foto's per stuk :</span> <? if(isset($error['photos_extra'])) echo $error['photos_extra'];?></td><td></td></tr>
                <tr><td class='fields'><input maxlength="10" class='field_small' size='10' class='small_field' type='text' name='photos_extra' value='<? if(isset($_POST['photos_extra'])) echo $_POST['photos_extra']?>'  /></td></tr>
                <tr><td class='fields'><span>Prijs :</span> <? if(isset($error['price'])) echo $error['price'];?></td><td></td></tr>
                <tr><td class='fields'><input maxlength="6" class='field_small' size='6' class='small_field' type='text' name='price' value='<? if(isset($_POST['price'])) echo $_POST['price']?>'  /></td></tr>
				

                <tr><td class='fields'><span>Omschrijving :</span> <?if(isset($error['extra'])) echo $error['extra'];?></td><td></td></tr>
                <tr><td class='fields'><textarea class='field' name="extra"><? if(isset($_POST['extra'])) echo $_POST['extra'];?></textarea></td><td></td></tr>        
				<tr><td class='fields'><input type="submit" class="submit" value="Opslaan" /></td><td></td></tr></table></form>
</div>