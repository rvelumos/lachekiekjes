<div class='text_content'>
<? if($rs['img_pos']=="1"){
	$small = "_small";
 }?>

 <div class='slider'>
    	<div class='left_image' id='slider'>
        	<?
			$this->loadSlideImages($page);
			?>
        </div>
        <script type="text/javascript">
			$( function() {
				$( '#sflider' ).jGallery({mode : 'slider'});
			} );
        </script>
  </div>     
       
  <div class='content'>
    <div class='middle_content<?=$small?>'>
    <span class='sifr'><?=$rs['name']?></span>
    <?=$rs['content']?>
    </div>
     <?if($rs['img_pos']=="2"){?>
    	 <div class='right_image'><img src='lumos/image.php?thumb=<?=$rs['image']?>&amp;size=<?=$size?>' alt='' /></div>
    <?}?>
    </div>
</div>