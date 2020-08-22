<div class='cat_content'>
<? while($categorie = mysql_fetch_array($result)){ ?>
    	<div class='cat_thumb'><a href='<?=ROOT?>index.php?page=portfolio&amp;category=<?=strtolower($categorie['id'])?>'><img src='<?=ROOT?><?=$categorie['thumb']?>' alt='<?=$categorie['naam']?>'/></a></div>
<? }?>
</div>