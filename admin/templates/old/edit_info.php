<?=$this->getCrumblePath();?>
<? if(isset($msg['info'])) echo $msg['info']?>
<div class='editform'>

<form method="post" enctype="multipart/form-data" name="edit_form" action="<?=$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']?>" >
<input type="hidden" name="edit_info" value="edit_info" />
				<table style='margin-top:10px; float:left;'><tr><td class='header'>Pagina wijzigen:</td></tr>
				<tr><td class='fields'><span>Naam :</span> <? if(isset($error['name'])) echo $error['name']?></td></tr>
                <tr><td class='fields'><input class='field <? if(isset($error['ip'])){?>input_error<?}?>' type="text" name="name" value="<? if(isset($info['name'])) echo $info['name']?>"/></td></tr>
                <tr><td class='fields'><span>Inhoud :</span></td></tr>
                <tr><td class='fields'><textarea class='ta' name="content" rows='20' cols='60' ><? if(isset($info['content'])) echo $info['content']?></textarea></td></tr>
                <tr><td class='fields'><span>Afbeelding :</span></td></tr>
                <tr><td class='fields'><input type="file" class='file' name="afbeeldingen" value="" /></td><td><? if(isset($error['afbeelding'])) echo $error['afbeelding'];?></td></tr>
                <tr><td class='fields'><span>Positie afbeelding :</span></td></tr>
                    <tr><td class='fields'><select name='img_pos'>
                 <?if($_POST['img_pos']==1){?>
                <option value='<?=$_POST['img_pos']; ?>'>Links</option>
                <?}elseif($_POST['img_pos']==2){?>
                <option value='<?=$_POST['img_pos']; ?>'>Rechts</option>
                <?}?>
                <option value='1'>Links</option>
                <option value='2'>Rechts</option>
                </select><? if(isset($error['img_pos'])) echo $error['img_pos'];?></td></tr>
                <tr><td class='fields'><span>Order : </span></td></tr>
                <tr><td class='fields'><input class='field <? if(isset($error['order'])){?>input_error<?}?>' type="text" name="order" value="<? if(isset($info['order'])) echo $info['order']?>"/></td></tr>
				<tr><td class='fields'><input type="submit" class="submit" value="Wijzigen" /></td></tr></table></form>
</div>