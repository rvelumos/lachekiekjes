<?=$this->getCrumblePath();?>
<? if(isset($msg['notice'])) echo $msg['notice']?>

<!--
<div class='editform'>

<form method="post" enctype="multipart/form-data" name="contact_form" action="<?=$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']?>" >
<input type="hidden" name="add_note" value="new_info" />
				<table style='margin-top:10px; float:left;'>
				<tr><td class='fields'><span>Type :</span> <? if(isset($error['type'])) echo $error['type']?></td><td></td></tr>
                <tr><td class='fields'><?=$this->getNoteTypes();?></td><td></td></tr>
                <tr><td class='fields'><span>Omschrijving :</span> <? if(isset($error['description'])) echo $error['description']?></td><td></td></tr>
                <tr><td class='fields'><textarea class='field <? if(isset($error['description'])){?>input_error<?}?>'name="description"><? if(isset($type['description'])) echo $type['description']?></textarea></td><td></td></tr>        
				<tr><td class='fields'><input type="submit" class="submit" value="Opslaan" /></td><td></td></tr></table></form>
</div>
-->

<?

$db_inputs = array('type');
$area_inputs = array('description');

echo $this->create_form(1, "add", "note_form", NULL, $db_inputs, NULL, NULL, $area_inputs);

?>
