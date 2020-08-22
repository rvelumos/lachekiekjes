<?=$this->getCrumblePath();?>
<div class='editform'>
<? if(isset($msg['info'])) echo $msg['info']?>
<form method="post" enctype="multipart/form-data" name="edit_form" action="<?=$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']?>" >
<input type="hidden" name="upload_pdf" value="new_pdf" />
				<table style='margin-top:10px; float:left;'>
				
                <tr><td class='fields'><span>Bestand :</span></td></tr>
                <tr><td class='fields'><input type="file" class='file' name="pdf" value="" /></td><td><? if(isset($error['pdf'])) echo $error['pdf'];?></td></tr>
				<tr><td class='fields'><input type="submit" class="submit" value="Opslaan" /></td></tr></table></form>
</div>