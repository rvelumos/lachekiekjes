<?=$this->getCrumblePath();?>
<!--<div class='header_title'>Contactpersoon toevoegen</div>-->
<? if(isset($msg['notice'])) echo $msg['notice']?>
<div class='editform'>

<form method="post" enctype="multipart/form-data" name="contact_form" action="<?=$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']?>" >
<input type="hidden" name="add_contact" value="new_info" />
				<table style='margin-top:10px; float:left;'>
				<tr><td class='fields'><span>Voornaam :</span> <? if(isset($error['fname'])) echo $error['fname'];?></td><td></td></tr>
                <tr><td class='fields'><input class='field <? if(isset($error['fname'])){?>input_error<?}?>' type="text" name="fname" value="<? if(isset($contact['fname'])) echo $contact['fname'];?>"/></td><td></td></tr>
                <tr><td class='fields'><span>Achternaam :</span> <? if(isset($error['lname'])) echo $error['lname']?></td><td></td></tr>
                <tr><td class='fields'><input class='field <? if(isset($error['lname'])){?>input_error<?}?>' type="text" name="lname" value="<? if(isset($contact['lname'])) echo $contact['lname']?>"/></td><td></td></tr>
                <tr><td class='fields'><span>Adres :</span> <? if(isset($error['address'])) echo $error['address']?></td><td><span>Huisnummer :</span> <? if(isset($error['number'])) echo $error['number']?></td></tr>
                <tr><td class='fields'><input class='field <? if(isset($error['address'])){?>input_error<?}?>' type="text" name="address" value="<? if(isset($contact['address'])) echo $contact['address']?>"/></td><td class='fields'><input class='field_small <? if($error['number']){?>input_error<?}?>' type="text" name="number" value="<? if(isset($contact['number'])) echo $contact['number']?>"/></td></tr>
                 <tr><td class='fields'><span>Postcode :</span> <? if(isset($error['postalcode'])) echo $error['postalcode']?></td><td></td></tr>
                <tr><td class='fields'><input class='field <? if(isset($error['postalcode'])){?>input_error<?}?>' type="text" name="postalcode" value="<? if(isset($contact['postalcode'])) echo $contact['postalcode']?>"/></td><td></td></tr>
                 <tr><td class='fields'><span>Stad :</span> <? if(isset($error['town'])) echo $error['town']?></td><td></td></tr>
                <tr><td class='fields'><input class='field <? if(isset($error['town'])){?>input_error<?}?>' type="text" name="town" value="<? if(isset($contact['town'])) echo $contact['town']?>"/></td><td></td></tr>
                <tr><td class='fields'><span>Telefoonnummer :</span> <? if(isset($error['tel'])) echo $error['tel']?></td><td></td></tr>
                <tr><td class='fields'><input class='field <? if(isset($error['tel'])){?>input_error<?}?>' type="text" name="tel" value="<? if(isset($contact['tel'])) echo $contact['tel']?>"/></td><td></td></tr>
                <tr><td class='fields'><span>Mobiel :</span> <? if(isset($error['mobile'])) echo $error['mobile']?></td><td></td></tr>
                <tr><td class='fields'><input class='field <? if(isset($error['mobile'])){?>input_error<?}?>' type="text" name="mobile" value="<? if(isset($contact['mobile'])) echo $contact['mobile']?>"/></td><td></td></tr>
                <tr><td class='fields'><span>Email :</span> <? if(isset($error['email'])) echo $error['email']?></td><td></td></tr>
                <tr><td class='fields'><input class='field <? if(isset($error['email'])){?>input_error<?}?>' type="text" name="email" value="<? if(isset($contact['email'])) echo $contact['email']?>"/></td><td></td></tr>
                
               
				<tr><td class='fields'><input type="submit" class="submit" value="Opslaan" /></td><td></td></tr></table></form>
</div>

<div class='header_title'>Bestaand contactpersoon koppelen</div>
<div class='editform'>
<? if(isset($msg['info'])) echo $msg['info']?>
<form method="post" enctype="multipart/form-data" name="old_contact_form" action="<?=$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']?>" >
<input type="hidden" name="old_contact" value="new_info" />
				<table style='margin-top:10px; float:left;'>
				<tr><td class='fields'><span>Kies hieronder een contactpersoon :</span> <? if(isset($error['old_contact'])) echo $error['old_contact']?></td></tr>
                <tr><td class='fields'><?=$this->getContacts()?></td></tr>
     
				<tr><td class='fields'><input type="submit" class="submit" value="Opslaan" /></td></tr></table></form>
</div>