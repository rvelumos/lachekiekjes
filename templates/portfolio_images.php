<div id="examples_outer">
			<div id="slider_container_1">

				<div id="SliderName">
                <div id="gallery">
									<? 
									$i=1;
									while($thumb=$result->fetch_array(MYSQLI_BOTH)){ 					
									?><div class='image_holder'>
										 <div class='category_image'>		
														<a href="../../<?=$thumb['image']?>" data-lightbox="foto_category">
                                                                    <img src="http://www.lachekiekjes.nl/thumb_image.php?thumb=<?=$thumb['image']?>&amp;size=150" alt='foto' title="Portfolio images" />
														</a>
											</div>
                                            </div>
											<?
											$i++;
									}?>
            </div>
				</div>
			</div>
		</div>
<!--
<script type="text/javascript">
$( function() {
    $( '#gallery' ).jGallery();
} );
</script>

-->