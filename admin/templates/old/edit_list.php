	<tr><td><?=$list_items['id']?></td><td><?=$list_items['naam']?></td><td align='right'>
		<a href='index.php?edit_list=<?=$_GET['edit_list']?>&amp;edit_item=<?=$list_items['id']?>'><img src='<?=ROOT?>images/edit.png' /></a>&nbsp;&nbsp;<a href='index.php?edit_list=<?=$_GET['edit_list']?>&amp;delete_item=<?=$list_items['id']?>'><img src='<?=ROOT?>images/cross.gif' /></a>
</td></tr>
