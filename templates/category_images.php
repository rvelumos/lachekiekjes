<div id="examples_outer">
			<div id="slider_container_1">

				<div id="SliderName">
				<? 
				$i=1;
				while($thumb=$result->fetch_array(MYSQLI_BOTH)){ 					
					?>
                    <table class='portfolio_category'><tr>
                    <?
					if($i % 2 == 0){
					?>
                    <td valign='top'><p><?=$thumb['name']?></p><?=$thumb['info']?></td>
					<?
					}
					?>
                    <td align='center'>
                    	<a href="<?=BASE_URL?>/portfolio/category/<?=$thumb['id']?>">
							<? if($thumb['thumb']!=""){ ?><img src="<?=BASE_URL.$thumb['thumb']?>" title="Portfolio images" /><?}?>
						<!--					<img src="<?$this->makeThumbnails($thumb['image']); ?>" title="Portfolio images" />	-->
						</a>
                    </td>
                    <?
					if($i % 2 != 0){
					?>
                    <td valign='top'><p><?=$thumb['name']?></p><?=$thumb['info']?></td>
					<?
					}
					?>
                    </tr></table>
   					<?             
                $i++;
				}?>
				</div>


			</div>
		</div>
