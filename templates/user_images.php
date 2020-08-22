
<div class='<?=$classes["class_album"]?>'>
        <div class='tekst'>
        <?=$msg['empty'];?></div>
		<div class='album_items'>
<?if(mysql_num_rows($result)>1){?>        
        <div class='left_menu'></div>
<?}?>
		<?


		echo "
		<!-- this element contains the panels -->
<div id=\"fader1\">

  <!-- this is the first panel -->
  <img src=\"lumos/upload/gallerij/babyfotografie/1.png\" alt=\"\">

  <!-- this is the second panel -->
  <div>
    <!-- arbitrary content -->
	<img src=\"lumos/upload/gallerij/babyfotografie/2.png\" alt=\"\">
  </div>

</div>

		";
		if($album_naam != "" && $msg['empty']==""){
			while($images = mysql_fetch_array($result)){
						echo "<div class='album_item' style='margin: 15px;'><div class='ieshadow1'><div class='protectfromblur'>";
						echo "<a href='{$_SERVER['PHP_SELF']}?".htmlentities($_SERVER['QUERY_STRING'])."&amp;view={$images['auth_key']}'><img src='image.php?thumb={$images['afbeelding']}&amp;size=$size' alt=''/></a>";
					
						echo "</div></div></div>";	
			}
			echo "</div><div class='nav_bottom'>";
			$max_page_numbs = 3; //daarna krijg je ...
			
			for($i=1; $i<=$paginas; $i++){
				if($i != $pagenum){
					echo "<a href='{$_SERVER['PHP_SELF']}?section=projects&amp;project_id={$_GET['project_id']}&pagina=$i'><span class='number'>$i</span></a>";
				}else{
					echo "<span class='number'>$i</span>";
				}
			}
			
			
		}
		?>
        </div>
</div>



