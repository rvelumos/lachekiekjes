<div class="crumble_path"><a href='<?=$_SERVER['PHP_SELF']?>?section=projects'>Projecten</a> &raquo; <?=$rs['name']?></div>

<span class='album_details'>
<? if(date("d-m-Y", strtotime($rs['end_date'])) < date("d-m-Y")){
	$this->message("ERROR","Het album is verlopen. Hieronder kan de datum verlengd worden.");
}else{?>
<p style='float:left; width:400px;'>Het album vervalt na <?=date("d-m-Y",strtotime($rs['end_date']))?></p>
<?}?>
</span>


<div class='holder'>
<div class='edit'><a href='index.php?section=projects&amp;project_id=<?=$_GET['project_id']?>&amp;cmd=edit_project'><img src='<?=ROOT?>images/edit.png' alt=''/>Project bewerken</a></div>
<? 
$id=$_GET['project_id'];
?>
<div class='edit'><a href='index.php?section=projects&amp;project_id=<?=$_GET['project_id']?>&amp;mode=notes&amp;cmd=add_note'><img src='<?=ROOT?>images/note.png' alt=''/>Notitie toevoegen</a></div>

<div class='remove'><a href='index.php?section=projects&amp;project_id=<?=$_GET['project_id']?>&amp;cmd=delete_project'><img src='<?=ROOT?>images/cross.gif' alt=''/> Verwijderen</a></div>
</div>

<? if($this->findNotes($id)){
$this->noteDetails($id);
}?>

<? if($rs['packet'] != ""){ ?>
<div class='packet'>Pakket: <? $this->getPacketName($rs['packet'])?></div>
<? }?>

<div class='header_title'>Factuuroverzicht</div>
<div class='project_details'>

<!--
<div class='action'><span>
<a href='index.php?section=projects&amp;project_id=<?=$_GET['project_id']?>&amp;mode=invoices&amp;cmd=edit_invoice'><img src='<?=ROOT?>images/edit.png' alt=''/> Bewerken</a></span><span>
<a href='index.php?section=projects&amp;project_id=<?=$_GET['project_id']?>&amp;mode=invoices&amp;cmd=delete_invoice'><img src='<?=ROOT?>images/cross.gif' alt=''/> Verwijderen</a></span></div>
-->
<? 
$this->invoiceDetails($id);
?>
</div>


<div class='header_title'>Contactpersoon</div>
<div class='project_details'>
<? if($rs['project']==NULL){?>
<div class='action'>
<span><a href='index.php?section=projects&amp;project_id=<?=$_GET['project_id']?>&amp;mode=contacts&amp;cmd=add_contact'><img src='<?=ROOT?>images/plus.png' alt=''/> Contact toevoegen</a></span></div>

<div class='tekst'> <? if(isset($msg['contact_empty']))echo $msg['contact_empty'];?></div>
<? }else{ ?>
<div class='action'><span>
<a href='index.php?section=projects&amp;project_id=<?=$_GET['project_id']?>&amp;mode=contacts&amp;cmd=edit_contact'><img src='<?=ROOT?>images/edit.png' alt=''/> Bewerken</a></span><span>
<a href='index.php?section=projects&amp;project_id=<?=$_GET['project_id']?>&amp;mode=contacts&amp;cmd=delete_contact'><img src='<?=ROOT?>images/cross.gif' alt=''/> Verwijderen</a></span></div>

<? 
$this->contactDetails($id);
}?>
</div>


<div class='header_title'>Foto's</div>
<div class='album_details'>

</span>
<div class='action'>
<span><a href='index.php?section=projects&amp;project_id=<?=$_GET['project_id']?>&amp;mode=images&cmd=upload_images'><img src='<?=ROOT?>images/plus.png' alt=''/> Foto's toevoegen</a></span><span>
<a href='https://www.ronald-designs.nl/development/projects/lachekiekjes/album/<?=$rs['hash'];?>' alt='' target='_blank'><img src='<?=ROOT?>images/link.png' alt=''/>Preview album</a>
</span><span><b>Wachtwoord: <?=$rs["password"]?></b></span></div>

<div class='<?=$classes["class_album"]?>'>
        <div class='tekst'>
        <? if(isset($msg['img_empty'])) echo $msg['img_empty'];?></div>
        


        
		<div class='album_items'>
		<?

		$sectie="projects";
		if($rs["name"] != "" && !isset($msg['empty'])){
			while($images = $result->fetch_array(MYSQLI_BOTH)){
				echo "<table class='album_image_item' style='margin: 15px;'><tr><td>";
				echo "<a href='{$_SERVER['PHP_SELF']}?".htmlentities($_SERVER['QUERY_STRING'])."&amp;view={$images['id']}'><img src='".ROOT."image.php?thumb={$images['image']}&amp;size=$size' class='image' alt=''/></a>";
				echo "</td></tr></table>";	
			}
			//echo "</div><div class='nav_bottom'>";
			
			$this->personalSelection($id);
			
			if($paginas > '1'){
				for($i=1; $i<=$paginas; $i++){
					echo "<span class='page'>";
					if($i != $pagenum){
						echo "<a href='{$_SERVER['PHP_SELF']}?section=projects&amp;project_id={$_GET['project_id']}&pagina=$i'><span class='number'>$i</span></a>";
					}else{
						echo "<span class='number'>$i</span>";
					}
					echo "</span>";
				}
			}
			
			
		}
		?>
        </div>
</div>
</div>


