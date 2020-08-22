<div class='add'><a href='index.php?section=projects&amp;cmd=add_project'><img src='<?=ROOT?>images/plus.png' alt=''/> Project toevoegen</a></div>
<!--<div class='layout'><div class='left'><b>Toon gegevens als:</b></div> <div class='right'><a href='<?=$_SERVER['PHP_SELF']?>?<?=htmlentities($_SERVER['QUERY_STRING'])?>&layout=gallery'><img src='images/miniature.png' alt='' /></a><a href='<?=$_SERVER['PHP_SELF']?>?<?=htmlentities($_SERVER['QUERY_STRING'])?>&layout=list'><img src='images/list.png' alt='' /></a></div></div>-->
        <div>
            <div class='tekst' style='float:left; clear:both;'>
            <? if(isset($msg['empty'])) echo $msg['empty'];?></div>
            
            <p class='header' style='margin:5px 25px; clear:both;'>Actieve projecten</p>
            
            <table class='projectform'>
					<?
					
                    while($project = $result->fetch_array(MYSQLI_BOTH)){
						$project_id = $project['id'];
                        
            echo "<tr><td><img src='".ROOT."/images/folder.png' alt='' /><a href='{$_SERVER['PHP_SELF']}?section=projects&amp;project_id={$project['id']}'>";                                             
						echo $project['name']. "</a></td><td><span style='font-size:11px; font-weight:400;'>".$project['start_date']."</span></td><td class='icons' align='right'>".$this->iconInvoice($project_id).$this->iconPhotos($project_id).$this->iconContact($project_id)."</td></tr>";         
                        
                    }
			echo "</table></p>";
			
			$sql = "SELECT * FROM ".$prefix."useralbums WHERE archive = 1";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);
			
			$num = $result->num_rows;
			
			if($num > 0){
				echo " <p class='header' style='margin:5px 25px; clear:both;'>Archief</p>";
				echo "<table class='projectform'>";
					
                    while($project = $result->fetch_array(MYSQLI_BOTH)){
						$project_id = $project['id'];
                        
            echo "<tr><td><img src='".ROOT."/images/folder.png' alt='' /><a href='{$_SERVER['PHP_SELF']}?section=projects&amp;project_id={$project['id']}'>";            
						echo $project['name']. "</a></td><td><span style='font-size:11px; font-weight:400;'>".$project['start_date']."</span></td><td class='icons' align='right'>".$this->iconInvoice($project_id).$this->iconPhotos($project_id).$this->iconContact($project_id)."</td></tr>";         
                        
                    }
			echo "</table></p>";	
			}
                ?> 
        </div>

