<small style='float:left'><b><a href='index.php'>Index</a> > <a href='index.php?edit_list=<?=$_GET['edit_list']?>'>Overzicht lijst <?=$_GET['edit_list']?></a> > Item <u><?=$item['naam']?></u> bewerken</b></small>
<?=$msg['item']?>
<form method="post" enctype="multipart/form-data" name="edit_listitem_form" action="<?=htmlentities($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'])?>" >
<input type="hidden" name="update_item" value="edit_item" />
<table class='log'>
<tr><td class='fields'>Naam:<?if($error['naam']){?><?=$error['naam'];?><?}?> <input type='text' name="naam" class='field <?if($error['naam']){?>input_error<?}?>' value="<?=$list_item['naam']?>" /> </td></tr>
<tr><td class='fields'>Status: <select name='status'>
 <?if($list_item['status']==0){?>
<option value='<?=$list_item['status']; ?>'>Niet actief</option>
<?}else{?>
<option value='<?=$list_item['status']; ?>'>Actief</option>
<?}?>
<option value=' '> </option>
<option value='0'>Niet actief</option>
<option value='1'>Actief</option>
</select><?=$error['status'];?></td></tr>
</table>
<p style='float:left;clear:both'>
<input type="submit" class="submit" value="Opslaan" />
</p>
</form>



