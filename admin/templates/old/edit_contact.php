<?=$this->getCrumblePath();?>
<? if(isset($msg['notice'])) echo $msg['notice']?>
<div class='editform'>

<form method="post" enctype="multipart/form-data" name="contact_form" action="<?=$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']?>" >
<input type="hidden" name="edit_contact" value="new_info" />
				<table style='margin-top:10px; float:left;'>
				<tr><td class='fields'><span>Voornaam :</span> <? if(isset($error['fname'])) echo $error['fname'];?></td><td></td></tr>
                <tr><td class='fields'><input class='field <? if(isset($error['fname'])){?>input_error<?}?>' type="text" name="fname" value="<?=$contact['fname']?>"/></td><td></td></tr>
                <tr><td class='fields'><span>Achternaam :</span> <? if(isset($error['lname'])) echo $error['lname']?></td><td></td></tr>
                <tr><td class='fields'><input class='field <? if(isset($error['lname'])){?>input_error<?}?>' type="text" name="lname" value="<?=$contact['lname']?>"/></td><td></td></tr>
                <tr><td class='fields'><span>Adres :</span> <? if(isset($error['address'])) echo $error['address']?></td><td><span>Huisnummer :</span> <? if(isset($error['number'])) echo $error['number']?></td></tr>
                <tr><td class='fields'><input class='field <? if(isset($error['address'])){?>input_error<?}?>' type="text" name="address" value="<?=$contact['address']?>"/></td><td class='fields'><input class='field_small <? if($error['number']){?>input_error<?}?>' type="text" name="number" value="<?=$contact['number']?>"/></td></tr>
                 <tr><td class='fields'><span>Postcode :</span> <? if(isset($error['postalcode'])) echo $error['postalcode']?></td><td></td></tr>
                <tr><td class='fields'><input class='field <? if(isset($error['postalcode'])){?>input_error<?}?>' type="text" name="postalcode" value="<?=$contact['postalcode']?>"/></td><td></td></tr>
                 <tr><td class='fields'><span>Stad :</span> <? if(isset($error['town'])) echo $error['town']?></td><td></td></tr>
                <tr><td class='fields'><input class='field <? if(isset($error['town'])){?>input_error<?}?>' type="text" name="town" value="<?=$contact['town']?>"/></td><td></td></tr>
                <tr><td class='fields'><span>Telefoonnummer :</span> <? if(isset($error['tel'])) echo $error['tel']?></td><td></td></tr>
                <tr><td class='fields'><input class='field <? if(isset($error['tel'])){?>input_error<?}?>' type="text" name="tel" value="<?=$contact['tel']?>"/></td><td></td></tr>
                <tr><td class='fields'><span>Mobiel :</span> <? if(isset($error['mobile'])) echo $error['mobile']?></td><td></td></tr>
                <tr><td class='fields'><input class='field <? if(isset($error['mobile'])){?>input_error<?}?>' type="text" name="mobile" value="<?=$contact['mobile']?>"/></td><td></td></tr>
                <tr><td class='fields'><span>Email :</span> <? if(isset($error['email'])) echo $error['email']?></td><td></td></tr>
                <tr><td class='fields'><input class='field <? if(isset($error['email'])){?>input_error<?}?>' type="text" name="email" value="<?=$contact['email']?>"/></td><td></td></tr>
                
               
				<tr><td class='fields'><input type="submit" class="submit" value="Opslaan" /></td><td></td></tr></table></form>
</div>
