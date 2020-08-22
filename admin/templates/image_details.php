<?=$this->getCrumblePath();?>

<div class='remove' style='float:left;clear:left;'><a href='index.php?section=projects&amp;project_id=<?=$_GET['project_id']?>&mode=images&amp;delete_image=<?=$image_details['id']?>'><img src='<?=ROOT?>images/cross.gif' alt=''/> Foto verwijderen</a>
</div>

<div class='<?=$classes["class_album"]?>'>
        <div class='tekst'>
        <? if(isset($msg['invalid'])) echo $msg['invalid'];?></div>
		<div class='album_items'>
            <div class='image_content'>
				<div class="image_holder">
                <img src='<?=ROOT.$image_details['image']?>' alt=""/>
                
                </div>      
            
            </div>
            </div>
</div>



