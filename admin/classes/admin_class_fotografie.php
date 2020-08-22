<?php

class Admin extends Main{
	
	public function generatePassword(){
		// create random password for clients to access their albums
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    	$pass = array(); 
   		$alphaLength = strlen($alphabet) - 1;
		
		for ($i = 0; $i < 10; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
   	 	return implode($pass); 
  }
 
	
	public function contentOverview(){
		global $prefix;
		
		$error="";
		
		if(isset($_GET['edit_content'])){
			if(isset($_POST['input_info_form'])){
				$info['name'] = mysqli_real_escape_string($this->link, $_POST['name']);	
				$info['content'] =  mysqli_real_escape_string($this->link, $_POST['content']);	
				$info['order'] = $_POST['order'];	
				//$info['img_pos'] = $_POST['img_pos'];	
				
				if($info['name'] != ""){					
					if(isset($_FILES['image'])){
						$afbeelding = $_FILES['image'];
						if($afbeelding['name'] != ""){
							$filename = $afbeelding['name'];
							$filetype = $afbeelding['type'];
							$filesize = $afbeelding['size'];

							$ext = explode(".",$filename);
							$ext = $ext[count($ext)-1];
							$path = "upload/info/";

							list($width, $height) = getimagesize($afbeelding['tmp_name']);

							$image = $path.$filename;

							if(($width < '800') || ($height < 600)){
								if (!copy($afbeelding['tmp_name'], ROOT.$image))
								{
									return $file."----".$afbeelding;

									{
									unlink($afbeelding);
									if(!is_writable($path))
											return "{$afbeelding} Geen rechten:{$afbeelding}";	
									else
										return "{$file} Wel rechten:{$afbeelding}";						
										return "";
									}
								}
								unlink($afbeelding['tmp_name']);
								//$afbeelding = "upload/".$film['naam'].".".$ext;			
								$img_sql = "`image` = '$image',";		
	//die($sql);
							}else{
								echo $this->message("ERROR","Het thumb plaatje mag maximaal 800x600 pixels groot zijn!");
							}								
						}
					}
					
					$p_id=$_GET['edit_content'];
					
					$sql="UPDATE ".$prefix."info SET";
									if(isset($img_sql)) $sql .= $img_sql;
									$sql .= "`name` = '".$info['name']."',
									`order` = '".$info['order']."',
									`content` = '".$info['content']."' 
								WHERE id = '".$p_id."'";
					
					if(!$result = $this->link->query($sql)){
						$this->db_message($sql);
					}else{
						$this->adminLog("Pagina $p_id aangepast");
						$msg["info"]= $this->message("NOTICE","De pagina is succesvol aangepast.");
					}
				}else{
					$msg["info"]= $this->message("ERROR","Geef tenminste de naam van de pagina op.");	
				}
			}
			
			$sql="SELECT * FROM ".$prefix."info WHERE id = '".$_GET['edit_content']."'";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);
			
			if($result->num_rows > 0){
				$info = $result->fetch_array(MYSQLI_BOTH);
				
				$text_inputs = array('name', 'order');
				$img_inputs = array('image');
				$area_inputs = array('content');

				echo $this->getCrumblePath();
	
				if(isset($msg['info'])) 
					echo $msg['info'];
				
				echo $this->create_form(1, "edit", "info_form", $text_inputs, NULL, NULL, $img_inputs, $area_inputs, $error, $info);
			}else{
				echo $this->message("ERROR","Geen info gevonden om te bewerken.");
			}
			
			$result->free();
		}elseif(isset($_GET['delete_info'])){
			$p_id = intval($_GET['delete_info']);
			
			$sql="SELECT * FROM ".$prefix."info WHERE id = '$p_id'";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);
			
			if($result->num_rows>0){
				$sql="DELETE FROM ".$prefix."info WHERE id = '$p_id'";
				if(!$result_rm = $this->link->query($sql))
					$this->db_message($sql);	
				else{
					$this->adminLog("Pagina $p_id verwijderd");
					echo $this->message("NOTICE","De pagina is verwijderd, een moment geduld...");
					echo "<meta http-equiv=\"refresh\" content=\"2;URL=index.php?section=content\" />";			
				}
			}else{
				echo $this->message("ERROR","Je probeert een niet bestaand nummer te verwijderen");
			}
			$result->free();
		}elseif(isset($_GET['cmd']) && $_GET['cmd']=="add_page"){
			$error = "";
			if(isset($_POST['input_info_form'])){
				$info['name'] =  mysqli_real_escape_string($this->link, $_POST['name']);	
				$info['content'] =  mysqli_real_escape_string($this->link, $_POST['content']);	
				$info['order'] = $_POST['order'];
				//$info['img_pos'] = $_POST['img_pos'];
				
				if($info['name'] != ""){
					if(isset($_FILES['image']))$afbeelding = $_FILES['image']['name'];
					$image="";
					if(isset($image) && $image != ""){	
						$filename = $image['name'];
						$filetype = $image['type'];
						$filesize = $image['size'];

						$ext = explode(".",$filename);
						$ext = $ext[count($ext)-1];
						$path = "upload/info/".$info['name'];

						list($width, $height) = getimagesize($image['tmp_name']);

						$image_url = $path.$album_item['name']."_".$hash.".".$ext;

						if(($width < '800') || ($height < 600)){
							if (!copy($image['tmp_name'], ROOT.$image_url))
							{
								return $file."----".$image;
							
								{
								unlink($image);
								if(!is_writable($path))
										return "{$image} Geen rechten:{$image}";	
								else
									return "{$file} Wel rechten:{$image}";						
									return "";
								}
							}
							unlink($image['tmp_name']);
							//$afbeelding = "upload/".$film['naam'].".".$ext;					
//die($sql);
						}else{
							$error['image'] = $this->message("ERROR","Het thumb plaatje mag maximaal 800x600 pixels groot zijn!");
						}		
					}
					
					$sql="SELECT * FROM ".$prefix."info WHERE name = '".$info['name']."'";
					if(!$result = $this->link->query($sql))
						$this->db_message($sql);
						
					if($result->num_rows < 1){
						$result->free();
						
						$sql="INSERT INTO ".$prefix."info (`name`, `content`, `order`, `image`, `img_pos`) VALUES('".$info['name']."','".$info['content']."','".$info['order']."', '$image_url', '1')";
						if(!$result = $this->link->query($sql))
							$this->db_message($sql);
						else{
							$this->adminLog("Webpagina toegevoegd");
							$msg["info"]= $this->message("NOTICE","De pagina is succesvol toegevoegd.");
						}
					}else{
						$error["info"]= $this->message("ERROR","Deze naam bestaat al in de database. Gebruik een andere naam.");	
					}					
				}else{
					$error["name"]= $this->message("FIELD_ERROR","Geef tenminste de naam van de pagina op.");	
				}
			}

			$text_inputs = array('name', 'order');
			$img_inputs = array('image');
			$area_inputs = array('content');

			echo $this->getCrumblePath();

			if(isset($msg['info'])) 
				echo $msg['info'];
			
			echo $this->create_form(1, "add", "info_form", $text_inputs, NULL, NULL, $img_inputs, $area_inputs, $error, NULL);
			
		}else{
			$sql="SELECT * FROM ".$prefix."info ORDER BY `order` ASC";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);
				
			echo "<div class='add'><a href='index.php?section=content&amp;cmd=add_page'><img src='".ROOT."images/plus.png' alt='' /> Pagina toevoegen</a></div>";
			if($result->num_rows > 0){
				echo "<table class='overview'>";
				while($info = $result->fetch_array(MYSQLI_BOTH)){
					echo "<tr><td class='header'>".$info['name']."</td><td>";	
					if (strlen($info['content']) > 100)
  						$info['content'] = substr($info['content'], 0, 100). "....";
					echo htmlspecialchars($info['content']);
					echo "</td><td align='right'><a href='index.php?section=content&amp;edit_content=".$info['id']."'><img src='".ROOT."images/edit.png' alt='' /></a> 
							  <a href='index.php?section=content&amp;delete_info=".$info['id']."'><img src='".ROOT."images/cross.gif' alt='' /></a></td></tr>";
				}
				echo "</table>";
			}else{
				echo $this->message("ERROR","Er zijn nog geen pagina's aangemaakt. Klik op Pagina toevoegen voor een nieuwe pagina.");	
			}
			$result->free();
		}
	}
	
	public function portfolioOverview(){
		global $settings, $prefix;
		
		$error = "";
		$e_id="";
		$d_id="";
		if(isset($_GET['edit_cat']))$e_id=intval($_GET['edit_cat']);
		if(isset($_GET['delete_cat']))$d_id=intval($_GET['delete_cat']);
		
		if($e_id!=""){
			if(isset($_POST['input_cat_form'])){
				$name = mysqli_real_escape_string($this->link, $_POST['name']);
				$status = intval($_POST['status']);
				if($name != ""){
					$sql="UPDATE ".$prefix."portfoliocategories SET name = '$name', status = '$status' WHERE  id = '".$e_id."'";

					if(!$result = $this->link->query($sql))
						$this->db_message($sql);
					else{
						$this->adminLog("Categorie $e_id aangepast");
						$msg['info']=$this->message("NOTICE","De categorie is aangepast");
					}
				}else{
					$msg['info']=$this->message("ERROR","Voer een naam in");
				}		
			}
			
			$sql="SELECT * FROM ".$prefix."portfoliocategories WHERE id = '".$e_id."' ";
			if(!$result2 = $this->link->query($sql))
				$this->db_message($sql);
			$cat = $result2->fetch_array(MYSQLI_BOTH);
			
			$text_inputs = array('name');
			$select_inputs = array('status');
			
			echo $this->getCrumblePath();

			if(isset($msg['info'])) 
				echo $msg['info'];

			echo $this->create_form(1, "edit", "cat_form", $text_inputs, NULL, $select_inputs, NULL, NULL, $error, $cat);
			
			$result2->free();		
		}elseif($d_id!=""){
			$sql="SELECT * FROM ".$prefix."portfolioitems WHERE category = '".$d_id."' ";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);
			
			if($result->num_rows<1){
				$sql="DELETE FROM ".$prefix."portfoliocategories WHERE id = '".$d_id."' ";
				if(!$result_del = $this->link->query($sql))
					$this->db_message($sql);
				else{
					$this->adminLog("Categorie $c_id verwijderd");
					echo $this->message("NOTICE","De categorie is verwijderd...");
					echo "<meta http-equiv=\"refresh\" content=\"2;URL=index.php?section=portfolio\" />";	
				}
			}else{
				echo $this->message("ERROR","Er zijn items gekoppeld aan deze categorie, ontkoppel deze eerst.");	
			}
			$result->free();
			
		}elseif(isset($_GET['edit_image'])){
			$e_id = intval($_GET['edit_image']);
			$size = 250; 
			
			$sql="SELECT id FROM ".$prefix."portfolioitems WHERE id = '$e_id'";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);

			if($result->num_rows>0){			
				if(isset($_POST['edit_image'])){
					$category = $_POST['category'];
					$order = $_POST['order'];
					$show_page="";
					if(isset($_POST['page']))$show_page = $_POST['page'];
					
					if($category != ""){
						$sql="UPDATE ".$prefix."portfolioitems SET show_page = '$show_page', category = '$category', `order` = '$order' WHERE id = '$e_id'";
						if(!$result = $this->link->query($sql))
							$this->db_message($sql);
						else{
							$this->adminLog("Afbeelding $e_id aangepast");
							$msg['image']=$this->message("NOTICE","De afbeelding is aangepast.");
						}
					}
				}
				$sql="SELECT * FROM ".$prefix."portfolioitems WHERE id = '$e_id'";
				if(!$result = $this->link->query($sql))
					$this->db_message($sql);

				$image = $result->fetch_array(MYSQLI_BOTH);
			}else{
				echo $this->message("ERROR","De afbeelding bestaat niet");	
				exit;
			}
			$category = $image['category'];
			require('templates/edit_pf_images.php');
			
			$result->free();
		}else{
			if(isset($_GET['cmd']) && $_GET['cmd']=="add_image"){				
				$this->uploadPortfolioImages();
			}else{
				$sql="SELECT * FROM ".$prefix."portfoliocategories";
				if(!$result_cat = $this->link->query($sql))
					$this->db_message($sql);

				if($result_cat->num_rows > 0){
					echo "<p style='margin-left:25px'><b>Categorie&euml;n</b></p><table class='small_editform'>";
					while($category	= $result_cat->fetch_array(MYSQLI_BOTH)){
						echo "<tr><td><a href='index.php?section=portfolio&amp;category=".$category['id']."'>".$category['name']."</a></td><td style='text-align:right'><a href='index.php?section=portfolio&amp;edit_cat=".$category['id']."'><img src='".ROOT."images/edit.png' alt='' /></a> 
								  <a href='index.php?section=portfolio&amp;delete_cat=".$category['id']."'><img src='".ROOT."images/cross.gif' alt='' /></a></td>";
					}
					echo "</table>";
				}
				
				echo "<div class='add' style='clear:both'><a href='index.php?section=portfolio&amp;cmd=add_image'>Afbeelding toevoegen</a></div>";
				
				if(isset($_GET['delete_image'])){
					$d_id = $_GET['delete_image'];
					
					$sql="SELECT image,thumb FROM ".$prefix."portfolioitems WHERE id = '$d_id'";

					if(!$result = $this->link->query($sql))
						$this->db_message($sql);

					$rs = $result->fetch_array(MYSQLI_BOTH);
					$file = "../".$rs["image"]; //up DIR for portfolio

					if(unlink($file)){
						$sql="DELETE FROM ".$prefix."portfolioitems WHERE id = '$d_id'";
						if(!$result2 = $this->link->query($sql))
							$this->db_message($sql);
						else{
							$this->adminLog("Afbeelding $d_id aangepast");
							$msg['pf_item'] = $this->message("NOTICE", "Afbeelding is verwijderd.");
						}
					}else{
						$msg['pf_item'] = $this->message("ERROR", "Fout bij verwijderen van bestand, bestand is niet gevonden.");	
					}
					$result->free();
				}
				$search="";
				if(isset($_GET['category']))
					$search = " WHERE category = '".$_GET['category']."' ";
				
				$sql="SELECT * FROM ".$prefix."portfolioitems $search";
				if(!$result_pf = $this->link->query($sql))
					$this->db_message($sql);

				if($result_pf->num_rows>0){
					if(isset($msg["pf_item"]))
						echo $msg["pf_item"]."<br />";
					echo "<div class='image_overview'>";
					while($pf_item	= $result_pf->fetch_array(MYSQLI_BOTH)){
						echo "<div class='pf_item'><div class='action'><a href='index.php?section=portfolio&amp;edit_image=".$pf_item['id']."'><img src='".ROOT."images/edit.png' alt='' /></a> 
								  <a href='index.php?section=portfolio&amp;delete_image=".$pf_item['id']."'><img src='".ROOT."images/cross.gif' alt='' /></a></div>
								  <a href='../".$pf_item['image']."' rel='prettyPhoto'><img class='thumb' src='".ROOT."image.php?thumb=../{$pf_item['image']}&amp;size=".$settings['preview_size']."'  alt='' />
								  </a><br />";
							if($pf_item['description']!="")
									echo $pf_item['description'];
						echo "</div>";
					}
					echo "</div>";
				}else{
					echo $this->message("ERROR","Geen afbeeldingen gevonden");	
				}
				$result_pf->free();
			}
		}
			
	}
	
	
	
	public function projectOverview(){
		global $prefix,$settings, $classes, $page;
		
		if(isset($_GET['project_id']))$project_id = $_GET['project_id'];
		$mode="";
		if(isset($_GET['mode']))$mode=$_GET['mode'];
		if($mode=='')$mode="startpage";
		
		if(isset($project_id)){
			switch($mode){
				case "images" : 
					if(isset($_GET['cmd']) && $_GET['cmd']=='upload_images')
						$this->uploadProjectImages($project_id);
					elseif($_GET['delete_image']!=''){
						$image_key = $_GET['delete_image'];
						$this->deleteProjectImage($image_key, $project_id);
					}
				break;
				
				case "contacts":
					if($_GET['cmd']=='edit_contact')
						$this->editContact($project_id);
					elseif($_GET['cmd']=='add_contact')
						$this->addContact($project_id);
					elseif($_GET['cmd']=='delete_contact')
						$this->deleteContact($project_id);
				break;
				
				case "notes":
					if(isset($_GET['edit_note']))$edit_id=$_GET['edit_note'];
					if($_GET['cmd']=='add_note')
						$this->addNote($project_id);
					elseif(isset($_GET['edit_note']))
						$this->editNote($edit_id);
					elseif($_GET['cmd']=='delete_note')
						$this->deleteNote($edit_id);
				break;
				
				case "startpage":
				default:
					if(isset($_GET['view'])){
						$image = $_GET['view'];
						$auth_key="";
						$this->imageDetails($image, $auth_key);
					}else{
						if(isset($_GET['cmd']) && $_GET['cmd']=='delete_project')
							$this->deleteProject($project_id);
						else
							$this->fetchProject($project_id);
					}
				break;
			}
		}elseif(isset($_GET['cmd']) && $_GET['cmd']=='add_project'){
			$this->addProject();
		}else{
			$sql="SELECT * FROM ".$prefix."useralbums WHERE archive = 0 ORDER BY id DESC";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);

			if($result->num_rows > 0){
				$size = $settings['album_thumb_size'];
				
			}else{
				$msg['empty'] = $this->message("EMPTY","Geen projecten gevonden. Klik linksboven op 'Project toevoegen' om een nieuw project aan te maken.");	
			}
			require('templates/album_overview.php');
			$result->free();
		}
		}
		
		public function personalSelection($id){
			global $prefix; $settings;
			
			$sql="SELECT * FROM ".$prefix."userimages WHERE project = '$id' AND selected = '1' ORDER BY add_date";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);
				
			if($result->num_rows>0){
				echo "<div class='header_title' style='float:left; clear:both; color:#666; text-align:left; width:98%'>Gekozen foto's</div>";
				while($rows=$result->fetch_array(MYSQLI_BOTH)){
					echo "<table class='album_image_item' style='margin: 15px;'><tr><td>";
					echo "<a href='{$_SERVER['PHP_SELF']}?".htmlentities($_SERVER['QUERY_STRING'])."&amp;view={$rows['id']}'><img src='".ROOT."image.php?thumb={$rows['image']}&amp;size=150' class='image' alt=''/></a>";
					echo "</td></tr></table>";		
				}
			}
			
		}
		
		public function fetchProject($project_id){
			global $prefix, $settings, $classes, $valid_image, $page;
			
			$error = "";
			$size = $settings['preview_size'];
			
			$sql="SELECT * FROM ".$prefix."useralbums ";
			$sql.="ua LEFT JOIN ".$prefix."contacts c ON ua.id = c.project ";
			$sql.="WHERE ua.id = '$project_id' ";

			if(!$result_name = $this->link->query($sql))
				$this->db_message($sql);
			
				if(isset($_GET['cmd']) && $_GET['cmd']=='edit_project'){
					$project_details = $result_name->fetch_array(MYSQLI_BOTH);
					//print_r($project_details);
					if($result_name->num_rows > 0){
							if(isset($_POST['input_project_form'])){
								//$old_path = $settings['image_path']."albums/{$album_details['naam']}/";
								$save="";
								$project_details['name'] = mysqli_real_escape_string($this->link, $_POST['name']);
								$project_details['description'] = mysqli_real_escape_string($this->link, $_POST['description']);
								$project_details['extra'] = mysqli_real_escape_string($this->link, $_POST['extra']);
								if(isset($_POST['end_date']))$project_details['end_date'] = date("d-m-Y", strtotime($_POST['end_date']));
								if(isset($_POST['start_date']))$project_details['start_date'] = date("d-m-Y", strtotime($_POST['start_date']));
								$project_details['status'] = $_POST['status'];
								$project_details['packet'] = $_POST['packet'];
								if(isset($_POST['photos_extra_qty']))$project_details['photos_extra_qty'] = intval($_POST['photos_extra_qty']);
								if(isset($_FILES['image']))$thumb = $_FILES['image'];
			
								if(isset($thumb['tmp_name'])){
			
									$path = $settings['image_path']."albums/".$album_details['naam']."/thumb/";
									if(!is_dir($path))
										mkdir($path, 0755, true);
									$save = $path.$thumb['name'];

									$this->upload_image($thumb, $save, "album", "thumb", NULL, $project_id);	

									if($_SESSION['valid_image'] == FALSE){
									 	$error['image']=$this->message("ERROR","Het plaatje mag maximaal 350 pixels breed + 350 pixels hoog zijn en maximaal 1,5mb groot zijn!");
										$bad_image = TRUE;
									}
								}
								
								//naam is verplicht
								if($project_details['name'] != ""){
									$sql = "UPDATE ".$prefix."useralbums SET ";
									$sql .= "name = '{$project_details['name']}', ";
									$sql .= "packet = '{$project_details['packet']}', ";
									$sql .= "description = '{$project_details['description']}', ";
									$sql .= "extra = '{$project_details['extra']}', ";
									$sql .= "photos_extra_qty = '{$project_details['photos_extra_qty']}', ";
									$sql .= "end_date = '{$project_details['end_date']}', ";
									$sql .= "start_date = '{$project_details['start_date']}', ";
									$sql .= "status = '{$project_details['status']}', ";
									//$sql .= $naam . $afbeelding;
									$sql .= " edit_date = NOW() ";
									$sql .= "WHERE id = '$project_id'";
									//die($sql);
									if(!$result2 = $this->link->query($sql)){
										$this->db_message($sql);
									}else{
										$this->adminLog("Project $project_id aangepast");
										$msg['info']=$this->message("NOTICE","Het project is aangepast.");
										$project_details['thumb'] = $save;
									}

									unset($_SESSION['valid_image']);
								}else{
									if($project_details['name'] == "")
										$error['name']=$this->message("FIELD_ERROR","Geef een naam op.");
								}
							}
						$text_inputs = array('name', 'description', 'photos_extra_qty','start_date', 'end_date');
						$area_inputs = array('extra');
						$select_inputs = array('status');
						$db_inputs = array('packet');
			
						echo $this->getCrumblePath();

						if(isset($msg['info'])) 
							echo $msg['info'];
			
						echo $this->create_form(1, "edit", "project_form", $text_inputs, $db_inputs, $select_inputs, NULL, $area_inputs, $error, $project_details);
						
						}else{
							echo $this->message("ERROR","Project bestaat niet. Probeer het opnieuw.");				
						}	

			}else{
				if($result_name->num_rows > 0){
					$rs = $result_name->fetch_array(MYSQLI_BOTH);
					
					//pagina's opbouwen
					if (!isset($_GET['pagina'])){ 
						$pagenum = 1; 
					}else{
						$pagenum = intval($_GET['pagina']); 
					}
					$sql="SELECT * FROM ".$prefix."userimages WHERE project = '$project_id'";
					if(!$result_aantal = $this->link->query($sql))
						$this->db_message($sql);
					
					$amount = $result_aantal->num_rows;
					$max = $settings['max_images'];
		
					$paginas = ceil($amount/$max);
					$pagelimit = 'limit ' .($pagenum - 1) * $max .',' .$max;		
					
					//nooit lager dan 1 of hoger dan maximum 
					if ($pagenum < 1) { 
						$pagenum  = 1; 
					}elseif ($pagenum  > $paginas){ 
						$pagenum = $paginas; 
					} 
	
					//$project_naam = $rs['naam'];
					
					$sql="SELECT * FROM ".$prefix."userimages WHERE project = '$project_id' ORDER BY add_date DESC $pagelimit";
					if(!$result = $this->link->query($sql))
						$this->db_message($sql);
					
					if($rs['contact']=="")
						$msg['contact_empty'] = "<p>Nog geen contactpersoon toegevoegd.</p>";
					
					if($result->num_rows < 1){
						$msg['img_empty'] = "<p>Geen afbeeldingen gevonden in dit project.</p>";	
					}
					
					require('templates/album_images.php');
				}else{
					echo "<p class='error'>Ongeldig project. </p>";
				}
			}
		}
		
		public function addContact($project_id){
			global $prefix;
			
			$error = "";
			
			if(isset($_POST['input_contact_form'])){
				$contact['fname']=trim($_POST['fname']);
				$contact['lname']=trim($_POST['lname']);
				$contact['address']=trim($_POST['address']);
				$contact['town']=trim($_POST['town']);
				$contact['postalcode']=trim($_POST['postalcode']);
				$contact['number']=trim($_POST['number']);
				$contact['email']=trim($_POST['email']);
				$contact['tel']=trim($_POST['tel']);
				$contact['mobile']=trim($_POST['mobile']);  
				
				if($contact['fname'] != "" && $contact['lname'] != "" && $this->is_valid($contact['tel'], "tel") && $this->is_valid($contact['mobile'], "mobile") && $this->is_valid($contact['email'], "email")){
					$sql="INSERT INTO ".$prefix."contacts (fname, lname, address, postalcode, town, number, tel, mobile, email, project) VALUES ('".$contact['fname']."', '".$contact['lname']."', '".$contact['address']."', '".$contact['postalcode']."', '".$contact['town']."', '".$contact['number']."', '".$contact['tel']."', '".$contact['mobile']."', '".$contact['email']."', ".$project_id.")";
					if(!$result_ins = $this->link->query($sql)){
						$this->db_message($sql);
			
					}else{
						$this->adminLog("Contact toegevoegd aan project $project_id");
						$msg['notice']= $this->message("NOTICE","Het contact is succesvol toegevoegd.");
					}
				}else{
          $c_tel=$contact['tel'];
					if($contact['fname']=="")
						$error["fname"]=$this->message("FIELD_ERROR","Voornaam is niet ingevuld");
					if($contact['lname']=="")
						$error["lname"]=$this->message("FIELD_ERROR","Achternaam is niet ingevuld");	
					if(!$this->is_valid($c_tel, "tel"))
						$error["tel"]=$this->message("FIELD_ERROR","Telefoonnummer is niet juist");
					if(!$this->is_valid($contact['mobile'], "mobile"))
						$error["mobile"]=$this->message("FIELD_ERROR","Mobiel nummer is niet juist");
					if(!$this->is_valid($contact['email'], "email"))
						$error["email"]=$this->message("FIELD_ERROR","Ongeldig e-mail adres");
				}
			}
			
			if(isset($_POST['old_contact']) && intval($_POST['contact']) > 0){
				$id=intval($_POST['contact']);
				
				$sql="SELECT * FROM ".$prefix."contacts WHERE id = ".$id." ";
				if(!$result = $this->link->query($sql))
					$this->db_message($sql);
				
				$contact=$result->fetch_array(MYSQLI_BOTH);
				
				$sql="INSERT INTO ".$prefix."contacts (project, fname, lname, address, postalcode, town, number, tel, mobile, email) VALUES ('".$project_id."','".$contact['fname']."', '".$contact['lname']."', '".$contact['address']."', '".$contact['postalcode']."', '".$contact['town']."', '".$contact['number']."', '".$contact['tel']."', '".$contact['mobile']."', '".$contact['email']."')";
				if(!$result_ins = $this->link->query($sql)){
					$this->db_message($sql);
				}else{
					$sql="UPDATE ".$prefix."useralbums SET contact='1' WHERE id='".$project_id."'";
					if(!$result_upd = $this->link->query($sql))
							$this->db_message($sql);
					else{
						$this->adminLog("Contact toegevoegd aan project $project_id");	
						$msg['notice']= $this->message("NOTICE","Het contact is succesvol toegevoegd.");
					}
				}
			}
			
			$text_inputs = array('fname','lname','address','postalcode','town','number','tel','mobile','email');

			echo $this->getCrumblePath();

			if(isset($msg['notice'])) 
				echo $msg['notice'];
			
			echo $this->create_form(1, "add", "contact_form", $text_inputs, NULL, NULL, NULL, NULL, $error, NULL);
			
			echo "<div class='header_title'>Bestaand contactpersoon koppelen</div>
				<div class='editform'>";
				if(isset($msg['info'])) 
					echo $msg['info'];
				echo "<form method=\"post\" enctype=\"multipart/form-data\" name=\"old_contact_form\" action=\"".$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']."\"  >
							<input type=\"hidden\" name=\"old_contact\" value=\"new_info\" />
							<table style='margin-top:10px; float:left;'>
								<tr><td class='fields'><span>Kies hieronder een contactpersoon :</span>";
								if(isset($error['old_contact'])) 
									echo $error['old_contact'];
								echo"</td></tr>
                <tr><td class='fields'>".$this->getContacts()."</td></tr>
								<tr><td class='fields'><input type=\"submit\" class=\"submit\" value=\"Opslaan\" /></td></tr></table></form>
				</div>";
		}
		
		
		public function editContact($project_id){
			global $prefix;
			
			$error="";
			
			$sql="SELECT * FROM ".$prefix."contacts WHERE project = ".$project_id." ";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);
			
			$contact=$result->fetch_array(MYSQLI_BOTH);
			
			if(isset($_POST['input_contact_form'])){
				$contact['fname']=trim($_POST['fname']);
				$contact['lname']=trim($_POST['lname']);
				$contact['address']=trim($_POST['address']);
				$contact['town']=trim($_POST['town']);
				$contact['postalcode']=trim($_POST['postalcode']);
				$contact['number']=trim($_POST['number']);
				$contact['email']=trim($_POST['email']);
				$contact['tel']=trim($_POST['tel']);
				$contact['mobile']=trim($_POST['mobile']);
				
				if($contact['fname'] != "" && $contact['fname'] != "" && $this->is_valid($contact['tel'], "tel") && $this->is_valid($contact['mobile'], "mobile") && $this->is_valid($contact['email'], "email")){
					$sql="UPDATE ".$prefix."contacts SET
						fname = '".$contact['fname']."',
						lname = '".$contact['lname']."',
						address = '".$contact['address']."',
						town = '".$contact['town']."',
						postalcode = '".$contact['postalcode']."',
						number = '".$contact['number']."',
						mobile = '".$contact['mobile']."',
						tel = '".$contact['tel']."', 
						email = '".$contact['email']."', 
						fname = '".$contact['fname']."' 
					WHERE id = ".$contact['id']." ";

					if(!$result_ins = $this->link->query($sql))
						$this->db_message($sql);
					else{
						$this->adminLog("Contact van project $project_id aangepast");
						$msg['notice']= $this->message("NOTICE","Het contact is succesvol aangepast.");
					}
				}else{
					if($contact['fname']=="")
						$error["fname"]=$this->message("FIELD_ERROR","Voornaam is niet ingevuld");
					if($contact['lname']=="")
						$error["lname"]=$this->message("FIELD_ERROR","Achternaam is niet ingevuld");
					if(!$this->is_valid($contact['tel'], "tel"))
						$error["tel"]=$this->message("FIELD_ERROR","Telefoonnummer is niet juist");
					if(!$this->is_valid($contact['mobile'], "mobile"))
						$error["mobile"]=$this->message("FIELD_ERROR","Mobiel nummer is niet juist");
					if(!$this->is_valid($contact['email'], "email"))
						$error["email"]=$this->message("FIELD_ERROR","Ongeldig e-mail adres");	
				}
			}
			
			$text_inputs = array('fname','lname','address','postalcode','town','number','tel','mobile','email');

			echo $this->getCrumblePath();

			if(isset($msg['notice'])) 
				echo $msg['notice'];
			
			echo $this->create_form(1, "edit", "contact_form", $text_inputs, NULL, NULL, NULL, NULL, $error, $contact);
			
		}
		
		public function deleteContact($id){
			global $prefix;
			
			$sql="SELECT * FROM ".$prefix."contacts WHERE project = '$id'";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);
			
			if($result->num_rows>0){
				$sql="DELETE FROM ".$prefix."contacts WHERE project = '$id'";
				if(!$result_rm = $this->link->query($sql))
					$this->db_message($sql);	
				else{
					$this->adminLog("Contact van project $id verwijderd");
					echo $this->message("NOTICE","Contact is verwijderd, een moment geduld...");
					echo "<meta http-equiv=\"refresh\" content=\"2;URL=index.php?section=projects&project_id=".$id."\" />";			
				}
			}else{
				echo $this->message("ERROR","Je probeert een niet bestaand contact te verwijderen");
			}
			$result->free();
			
		}
		
		public function getContacts(){
			global $prefix;	
			
			$sql="SELECT * FROM ".$prefix."contacts";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);
					
			if($result->num_rows > 0){
				echo "<select id='contact' name='contact'><option></option>";
				while($rs=$result->fetch_array(MYSQLI_BOTH)){
					echo "<option value='".$rs['id']."'>".$rs['fname'].", ".$rs['lname'].", ".$rs['adress'].", ".$rs['number'].", ".$rs['town']."</option>";
				}
				echo "</select>";
			}else{
				echo $this->message("NOTICE", "Er bestaan nog geen contactpersonen in de database");
			}
		}
		
		public function contactDetails($id){
			global $prefix;
			
			$sql="SELECT * FROM ".$prefix."contacts WHERE project ='".$id."'";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);	
				
			$rs=$result->fetch_array(MYSQLI_BOTH);

			if($rs['address']=="")$rs['address']="<span style='color:red'><b>&lt;niet opgegeven&gt;</b></span>";
			if($rs['postalcode']=="")$rs['postalcode']="<span style='color:red'><b>&lt;niet opgegeven&gt;</b></span>";
			if($rs['town']=="")$rs['town']="<span style='color:red'><b>&lt;niet opgegeven&gt;</b></span>";
			if($rs['tel']=="")$rs['tel']="<span style='color:red'><b>&lt;niet opgegeven&gt;</b></span>";
			if($rs['mobile']=="")$rs['mobile']="<span style='color:red'><b>&lt;niet opgegeven&gt;</b></span>";
			if($rs['email']=="")$rs['email']="<span style='color:red'><b>&lt;niet opgegeven&gt;</b></span>";
			
			echo "<table class='sub_details'><tr><td><b>Naam:</b></td><td> ".$rs["fname"]." ".$rs["lname"]."</td><td><b>Telefoonnummer: </b></td><td>".$rs["tel"]."</td></tr>
			<tr><td><b>Straat/nummer: </b></td><td>".$rs["address"]." ".$rs["number"]."</td><td><b>Mobiel nummer:</b></td><td>".$rs["mobile"]."</td></tr>
			<tr><td><b>Postcode/plaats: </b></td><td>".$rs["postalcode"].", ".$rs["town"]."</td><td><b>E-mail: </b></td><td>".$rs["email"]."</td></tr>
			</table>
			";
		}
		
		public function addNote($project_id){
			global $prefix;
			
			$error = "";

			if(isset($_POST['input_note_form'])){
				$note['type']=$_POST['type'];
				$note['description']=mysqli_real_escape_string($this->link, $_POST['description']);
				
				if($note['type'] != "" && $note['description'] != ""){
					$sql="INSERT INTO ".$prefix."userlog (type, description, date, user, project) VALUES ('".$note['type']."','".$note['description']."','".time()."','".$_SESSION['admin_name']."', '".$project_id."')";
					if(!$result_ins = $this->link->query($sql)){
						$this->db_message($sql);
					}else{		
						$this->adminLog("Notitie toegevoegd aan project $project_id");
						$msg['info']= $this->message("NOTICE","De notitie is succesvol toegevoegd.");
					}
				}else{
					if($note['description']=="")
						$error["description"]=$this->message("FIELD_ERROR","Omschrijving is niet ingevuld");
					if($note['type']=="")
						$error["type"]=$this->message("FIELD_ERROR","Type is niet ingevuld");	
				}
			}
			echo $this->getCrumblePath();
			
			if(isset($msg['info'])) 
				echo $msg['info'];
			
			$db_inputs = array('type');
			$area_inputs = array('description');

			echo $this->create_form(1, "add", "note_form", NULL, $db_inputs, NULL, NULL, $area_inputs, $error, NULL);
		}
		
		public function getNoteTypes(){
			global $prefix;	
			
			$sql="SELECT * FROM ".$prefix."notetypes";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);
					
			if($result->num_rows > 0){
				$contents = "<select id='type' name='type'><option></option>";
				while($rs=$result->fetch_array(MYSQLI_BOTH)){
					$contents .= "<option value='".$rs['id']."'>".$rs['name']."</option>";
				}
				$contents .= "</select>";
			}else{
				$contents = $this->message("ERROR", "Er bestaan nog geen types in de database");
			}
			return $contents;
		}
		
		
		public function addProject(){
			global $prefix;
			
			$error="";
			
			if(isset($_POST['input_project_form'])){

				$project_item['name'] = mysqli_real_escape_string($this->link, trim($_POST['name']));
				$project_item['status'] = $_POST['status'];
				$project_item['extra'] = mysqli_real_escape_string($this->link,$_POST['extra']);
				if(isset($_POST['photos_extra_qty']))$project_item['photos_extra_qty'] = intval($_POST['photos_extra_qty']);
				$project_item['description'] =  mysqli_real_escape_string($this->link,$_POST['description']);
				$project_item['packet'] = $_POST['packet'];
				if(isset($_FILES['thumb']))$afbeelding = $_FILES['thumb'];
				$project_item['start_date'] = $_POST['start_date'];
				if($project_item['start_date']!="")$project_item['start_date'] = date("d-m-Y", strtotime($project_item['start_date']));
				if($_POST['end_date']!="")
						$project_item['end_date'] = date("d-m-Y", strtotime($_POST['end_date']));
				else
						$project_item['end_date'] = date("d-m-Y",strtotime("+30 week"));

				if($project_item['name'] != "" && $project_item['packet'] != "" && $project_item['start_date'] != "" && $project_item['status'] != ""){
					$sql="SELECT name FROM ".$prefix."useralbums WHERE name = '".$project_item['name']."' ";
					if(!$result = $this->link->query($sql))
						$this->db_message($sql);
					
					if($result->num_rows < 1){
						/*$image="";
						if($afbeelding['name'] != ""){
							$filename = $afbeelding['name'];
							$filetype = $afbeelding['type'];
							$filesize = $afbeelding['size'];
	
							$ext = explode(".",$filename);
							$ext = $ext[count($ext)-1];
							$path = "upload/thumbs/";
							//$datetime = NOW();
	
							$hash = substr(md5(date("D-m-Y:h-s")),0,10);
	
							list($width, $height) = getimagesize($afbeelding['tmp_name']);
	
							$image = $path.$project_item['naam']."_".$hash.".".$ext;
	
							if(($width < '800') || ($height < 600)){
								if (!copy($afbeelding['tmp_name'], ROOT.$image))
								{
									return $file."----".$afbeelding;
								
									{
									unlink($afbeelding);
									if(!is_writable($path))
											return "{$afbeelding} Geen rechten:{$afbeelding}";	
									else
										return "{$file} Wel rechten:{$afbeelding}";						
										return "";
									}
								}
								unlink($afbeelding['tmp_name']);
								//$afbeelding = "upload/".$film['naam'].".".$ext;					
	//die($sql);
							}else{
								echo $this->message("ERROR","Het thumb plaatje mag maximaal 800x600 pixels groot zijn!");
							}
						}	*/	
						
						
						$hash=hash_hmac('sha256',date("d-m-Y").$project_item['name'],"project");
						$password=$this->generatePassword();
						
						$sql="INSERT INTO ".$prefix."useralbums (name, password, extra, description, packet, photos_extra_qty, hash, status, start_date, end_date) VALUES ('".$project_item['name']."', '".$password."','".$project_item['extra']."','".$project_item['description']."', '".$project_item['packet']."', '".$project_item['photos_extra_qty']."', '".$hash."','".$project_item['status']."', '".$project_item['start_date']."', '".$project_item['end_date']."') ";

						if(!$result_ins = $this->link->query($sql))
							$this->db_message($sql);
						else{
							$sql="SELECT id FROM ".$prefix."useralbums WHERE hash = '".$hash."'";
								if(!$result_ins = $this->link->query($sql))
									$this->db_message($sql);
							$project = $result_ins->fetch_array(MYSQLI_BOTH);	
							
							if($project_item["extra"]!=""){
								if($result_ins->num_rows > 0){
									$rs=$result_ins->fetch_array(MYSQLI_BOTH);
									$sql="INSERT INTO ".$prefix."userlog (type, description, date, user, project) VALUES ('2','".$project_item['extra']."','NOW()','".$_SESSION['admin_name']."', '".$rs['id']."')";
									if(!$result_ins = $this->link->query($sql)){
										$this->db_message($sql);
									}else{
										$this->adminLog("Contact toegevoegd aan project : ".$project_item['name']." ");	
									}
								}
							}
							$this->adminLog("Project toegevoegd");
							$this->addInvoice($project['id'], $project_item['packet']);
							$msg['info']= $this->message("NOTICE","Het project is succesvol toegevoegd.");
						}
						unset($project_item);
					}else{
						$msg['info'] = $this->message("ERROR",'project naam bestaat al. Probeer een andere naam.');	
					}
					$result->free();
				}else{
					if($project_item['name']=="")
						$error['name']= $this->message("FIELD_ERROR","Geef een naam op.");
					if($project_item['start_date']=="")
						$error['start_date']= $this->message("FIELD_ERROR","De datum van de shoot is niet ingevuld.");
					if($project_item['packet']=="")
						$error['packet']= $this->message("FIELD_ERROR","Kies een pakket.");
					if($project_item['status']=="")
						$error['status']=$this->message("FIELD_ERROR", "Kies een status voor het project.");
					}
			}	
			$text_inputs = array('name', 'description', 'photos_extra_qty','start_date', 'end_date');
			$area_inputs = array('extra');
			$select_inputs = array('status');
			$db_inputs = array('packet');

			echo $this->getCrumblePath();

			if(isset($msg['info'])) 
				echo $msg['info'];

			echo $this->create_form(1, "add", "project_form", $text_inputs, $db_inputs, $select_inputs, NULL, $area_inputs, $error, NULL);
		}
		
		public function packetOverview(){
			global $prefix, $settings;

			
			if(isset($_GET['cmd']) && $_GET['cmd']=='add_packet'){
				$this->addPacket();
			}elseif(isset($_GET['edit_packet'])){
				$this->editPacket($_GET['edit_packet']);
			}elseif(isset($_GET['delete_packet'])){
				$this->deletePacket($_GET['delete_packet']);
			}else{
				$sql="SELECT * FROM ".$prefix."packets";
				if(!$result = $this->link->query($sql))
					$this->db_message($sql);
					
					
					echo "<div class='add'><a href='index.php?section=packets&amp;cmd=add_packet'><img src='".ROOT."images/plus.png' alt='' /> Pakket toevoegen</a></div>";
					
					
					if($result->num_rows > 0){
						while($rs=$result->fetch_array(MYSQLI_BOTH)){
							echo "<p class='header' style='margin:35px 0 0 25px;float:left; clear:both;'>".$rs['name']."</p>";
							echo "<table class='medium_editform' style='color:#808080; '>";
							echo "<tr><td>&nbsp;</td><td align='right'><a href='index.php?section=packets&amp;edit_packet=".$rs['id']."'><img src='".ROOT."images/edit.png' alt='' /></a><a href='index.php?section=packets&amp;delete_packet=".$rs['id']."'> <img src='".ROOT."images/cross.gif' alt='' /></a></td></tr>";
							echo "<tr><td><b>Aantal foto's</b></td><td>".$rs['photos']."</td></tr>";
							echo "<tr><td><b>Kosten extra foto's per stuk</b></td><td>".$rs['photos_extra']."</td></tr>";
							echo "<tr><td><b>Prijs</b></td><td>".$rs['price']."</td></tr>";
							echo "<tr><td><b>Opmerkingen / extra's</b></td><td>".$rs['extra']."</td></tr>";
							echo "</table>";
						}
					}else{
						echo $this->message("NOTICE", "Geen pakketten gevonden");
					}	
			}
		}
		
		public function editPacket($id){
			global $prefix;
			
			$error="";
			
			$sql="SELECT * FROM ".$prefix."packets WHERE id = '".$id."' ";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);
			
			$packet=$result->fetch_array(MYSQLI_BOTH);
			
			if(isset($_POST['input_packet_form'])){
				$packet['name']=trim(mysqli_real_escape_string($this->link, $_POST['name']));
				$packet['price']=intval($_POST['price']);
				$packet['photos_extra']=intval($_POST['photos_extra']);
				$packet['photos']=intval($_POST['photos']);
				$packet['extra']=trim(mysqli_real_escape_string($this->link, $_POST['extra']));
				
				if($packet['name'] != "" && $packet['price'] != "" && $packet['photos'] != "" && $packet['photos_extra'] != "" && $packet['extra'] != ""){
					$sql="UPDATE ".$prefix."packets SET
						name = '".$packet['name']."',
						price = '".$packet['price']."',
						photos = '".$packet['photos']."',
						photos_extra = '".$packet['photos_extra']."',
						extra = '".$packet['extra']."' 
					WHERE id = '$id' ";

					if(!$result_ins = $this->link->query($sql))
						$this->db_message($sql);
					else{
						$this->adminLog("Pakket $id aangepast");
						$msg['info']= $this->message("NOTICE","Het pakket is succesvol aangepast.");
					}
				}else{
					if($packet['name']=="")
						$error["name"]=$this->message("FIELD_ERROR","Naam is niet ingevuld");
					if($packet['photos']=="")
						$error["photos"]=$this->message("FIELD_ERROR","Geef het maximum aantal foto's op");	
					if($packet['photos_extra']=="")
						$error["photos_extra"]=$this->message("FIELD_ERROR","Geef de prijs van de additionele foto's op");	
					if($packet['price']=="")
						$error["price"]=$this->message("FIELD_ERROR","Geef de prijs op");
					if($packet['extra']=="")
						$error["extra"]=$this->message("FIELD_ERROR","Geef een omschrijving");	
				}
			}
			
			$text_inputs = array('name','photos','photos_extra','price');
			$area_inputs = array('extra');
			
			echo $this->getCrumblePath();

			if(isset($msg['info'])) 
				echo $msg['info'];
			
			echo $this->create_form(1, "edit", "packet_form", $text_inputs, NULL, NULL, NULL, $area_inputs, $error, $packet);
		}
		
		public function deletePacket($id){
			global $prefix;
			
			$sql="SELECT * FROM ".$prefix."packets p
				inner join ".$prefix."useralbums ua ON p.id = ua.packet
			WHERE p.id = '".$id."' ";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);
			
			if($result->num_rows > 0){
				echo $this->message("ERROR","Er zijn albums gekoppeld aan dit pakket, verwijder deze eerst");	
			}else{
				$sql="DELETE FROM ".$prefix."packets WHERE id = '".$id."' ";
				
				if(!$result = $this->link->query($sql))
					$this->db_message($sql);
				else
					echo $this->message("NOTICE","Pakket is verwijderd");
			}
		}
		
		public function addPacket(){
			global $prefix;
			
			$error="";
			
			if(isset($_POST['input_packet_form'])){
				$packet['photos']=intval($_POST['photos']);
				$packet['photos_extra']=intval($_POST['photos_extra']);
				$packet['name']=mysqli_real_escape_string($this->link,$_POST['name']);
				$packet['price']=intval($_POST['price']);
				$packet['extra']=mysqli_real_escape_string($this->link,$_POST['extra']);
				
				if($packet['photos'] != "" && $packet['photos_extra'] != "" && $packet['name'] != "" && $packet['price'] != "" && $packet['extra'] != ""){
					$sql="INSERT INTO ".$prefix."packets (name, price, photos, photos_extra, extra) VALUES ('".$packet['name']."','".$packet['price']."','".$packet['photos']."','".$packet['photos_extra']."','".$packet['extra']."')";
					if(!$result_ins = $this->link->query($sql)){
						$this->db_message($sql);
					}else{		
						$this->adminLog("Pakket toegevoegd");
						$msg['notice']= $this->message("NOTICE","Het pakket is succesvol toegevoegd.");
					}
				}else{
					if($packet['name']=="")
						$error["name"]=$this->message("FIELD_ERROR","Naam is niet ingevuld");
					if($packet['photos']=="")
						$error["photos"]=$this->message("FIELD_ERROR","Geef het aantal foto's op");	
					if($packet['photos_extra']=="")
						$error["photos_extra"]=$this->message("FIELD_ERROR","Geef de prijs van de additionele foto's op");	
					if($packet['price']=="")
						$error["price"]=$this->message("FIELD_ERROR","Geef de prijs op");
					if($packet['extra']=="")
						$error["extra"]=$this->message("FIELD_ERROR","Geef een omschrijving van het pakket op");	
				}
			}
			$text_inputs = array('name','photos','photos_extra','price');
			$area_inputs = array('extra');
			echo $this->getCrumblePath();

			if(isset($msg['info'])) 
				echo $msg['info'];
			
			echo $this->create_form(1, "add", "packet_form", $text_inputs, NULL, NULL, NULL, $area_inputs, $error, NULL);
		}
		
		public function getPacketName($id){
			global $prefix,$settings;
			
			$sql="SELECT * FROM ".$prefix."packets where id = '$id'";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);	
			$rs=$result->fetch_array(MYSQLI_BOTH);
			echo $rs['name'];
		}
		
		public function availablePackets($layout, $id=NULL, $value=NULL){
			global $prefix,$settings;
			
			$sql="SELECT * FROM ".$prefix."packets";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);	

			switch($layout){
				case "project":
					if($result->num_rows > 0){
						$contents = "<select id='packet' name='packet'>";
						if($value!=NULL){
							$sql="SELECT * FROM ".$prefix."packets WHERE id = '$value'";
							//if($extra!="")die($sql);
							if(!$result2 = $this->link->query($sql))
								$this->db_message($sql);
							$exist = $result2->fetch_array(MYSQLI_BOTH);			
							if($exist['name']!="")echo "<option selected value='".$exist['id']."'>".$exist['name']."</option>";	
						}
						$contents .= "<option value=''></option>";
						while($rs=$result->fetch_array(MYSQLI_BOTH)){
							$contents .= "<option value='".$rs['id']."'>".$rs['name']."</option>";
						}
						$contents .= "</select>";
					}else{
						$contents .= $this->message("NOTICE", "Geen pakketten gevonden");
					}
				break;
				
				case "settings":
					if(isset($_GET['edit_packet'])){
						$p_id = $_GET["edit_packet"];
						
						$sql="SELECT id FROM ".$prefix."packets WHERE id = '$p_id'";
						if(!$result = $this->link->query($sql))
							$this->db_message($sql);
			
						if($result->num_rows>0){
							if($_POST['edit_packet']!=""){
								$rs["name"] = $_POST["name"]; 
								$rs["price"] = $_POST["price"]; 
								$rs["extra"] = $_POST["extra"];
								
								if($rs["price"]!="" && $rs["name"]!=""){
									$sql="UPDATE ".$prefix."packets SET name = '".$rs['name']."', extra = '".$rs['extra']."', price = '".$rs["price"]."' WHERE id = '$p_id'";
									if(!$result = $this->link->query($sql))
										$this->db_message($sql);
									else{
										$this->adminLog("Pakket $p_id aangepast");
										$msg['notice']=$this->message("NOTICE","Het pakket is aangepast.");
										$contents .= "<meta http-equiv=\"refresh\" content=\"1;URL=index.php?section=settings\" />";
										//exit();
									}
								}else{
									if($rs["name"]!="")
										$error["name"]=$this->message("ERROR", "Naam is niet ingevuld");
									if($rs["price"]!="")
										$error["price"]=$this->message("ERROR", "Prijs is niet ingevuld");	
								}
							}
							$sql="SELECT * FROM ".$prefix."packets WHERE id = '$p_id'";
							if(!$result = $this->link->query($sql))
								$this->db_message($sql);
	
							$rs = $result->fetch_array(MYSQLI_BOTH);
					
							require(ROOT.'templates/edit_packet.php');
						}else{
							$contents .= $this->message("ERROR","Het pakket bestaat niet");	
						}
					}else{
						//echo "<p class='header' style='clear:both;'>Overzicht pakketten</p><table class='editform' style='background-color:white !Important; margin:5px 0px !important'><tr><td><b>Naam</b></td><td><b>Prijs (excl)</b></td><td><b>Inhoud</b></td></tr>";
						while($rs=$result->fetch_array(MYSQLI_BOTH)){
							$price=$rs["price"];
							$contents .= "<tr><td>".$rs['name']."</td><td>".$this->calculateVAT($price)." (".$price.")</td><td>".$extra."</td><td><a href='index.php?section=settings&amp;edit_packet=".$rs['id']."'><img src='".ROOT."images/edit.png' alt='' /></a></td></tr>";
						}
						//echo "</table>";
					}
					
				break;
			}
			return $contents;
		}
		
		/*public function invoiceOverview(){
			global $settings, $prefix;
			
			
			
			$sql="SELECT * FROM ".$prefix."invoice";
			
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);	
				
			require(ROOT.'templates/invoice_overview.php');
		}*/
		
		public function addInvoice($id, $packet){
			global $prefix;
			
			$sql="INSERT INTO ".$prefix."invoice (project_id, packet_id, paid) VALUES ('".$id."', '".$packet."', '') ";
				if(!$result_ins = $this->link->query($sql))
					$this->db_message($sql);
		}
		
		public function invoiceDetails($id){
			global $settings, $prefix;	
			
			$cmd='';
			if(isset($_GET['cmd']))$cmd=$_GET['cmd'];
			
			switch($cmd){
				case "send_invoice":
					$sql="SELECT mail FROM ".$prefix."contacts WHERE project_id ='".$id."'";
					if(!$result = $this->link->query($sql))
						$this->db_message($sql);
					if($result->num_rows > 0){
						$this->send_mail("INVOICE", $id);
					}else{
						echo $this->message("NOTICE","Geen contactgegevens aanwezig in het systeem. Verstuur het bestand handmatig");
					}
				break;
				
				case "payment_ok":
					$date=time();
					$sql="UPDATE ".$prefix."invoice SET paid = '1', paid_date='".$date."' WHERE project_id = '$id'";
					if(!$result = $this->link->query($sql))
						$this->db_message($sql);
					echo $this->message("NOTICE","Status factuur omgezet naar: betaald");
					
					$sql="INSERT INTO ".$prefix."userlog (type, description, date, user, project) VALUES ('1','Betaling van factuur ontvangen','".time()."','".$_SESSION['admin_name']."', '$id')";
					if(!$result_ins = $this->link->query($sql))
						$this->db_message($sql);
				break;
				
				case "payment_bad":
					$date=time();
					$sql="UPDATE ".$prefix."invoice SET paid = '0', paid_date='".$date."' WHERE project_id = '$id'";
					if(!$result = $this->link->query($sql))
						$this->db_message($sql);
					echo $this->message("NOTICE","Status factuur omgezet naar: onbetaald");
					
					$sql="INSERT INTO ".$prefix."userlog (type, description, date, user, project) VALUES ('1','Factuur omgezet naar onbetaald','".time()."','".$_SESSION['admin_name']."', '$id')";
					if(!$result_ins = $this->link->query($sql))
						$this->db_message($sql);
				break;
			}
			
			$sql="SELECT * FROM ".$prefix."invoice WHERE project_id ='".$id."'";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);	
				
			$rs=$result->fetch_array(MYSQLI_BOTH);
			
			echo "<table class='sub_details'><tr><!--<a href='templates/generate_invoice.php?project=".$id."' target='_blank'><nobr>Download factuur</nobr></a><br /><br /></td><td><a href='index.php?section=projects&amp;project_id=".$id."&cmd=send_invoice'><nobr>E-mail factuur naar klant</nobr></a></td>--><td><a href='index.php?section=projects&amp;project_id=".$id."&cmd=upload_pdf'><img src='images/pdf.png' /> Upload PDF bestand</td></tr><tr style='text-align:center;'><td>";
			if(isset($rs['paid']))
      {
        if($rs["paid"]!="1"){
          echo "<div class='payment_bad'><a href='index.php?section=projects&amp;project_id=".$id."&cmd=payment_ok'><img src='images/received.png' style='opacity:0.1' /></a><br /><b><nobr>Betaling niet ontvangen</nobr></b></div></td>";
        }else{
          echo "<div class='payment_ok'><a href='index.php?section=projects&amp;project_id=".$id."&cmd=payment_bad'><img src='images/received.png' /></a><br /><b>Betaling ontvangen</b></div></td><td><div>";
        }
      }
			echo "</div></td></tr>
			</table>
			";
		}
		
		public function calculateVAT($price){
			global $settings, $prefix;
			
			$price = $price * (1 + ($settings['vat'] / 100));
			  
			return($price);	
		}
		
		public function uploadPortfolioImages(){
			global $prefix,$settings;
			
			if(isset($_POST['upload_images'])){
				$category = $_POST['category'];
				$show_page = $_POST['show_page'];
				
				$sql="SELECT * FROM ".$prefix."portfolioitems";
				if(!$result = $this->link->query($sql))
					$this->db_message($sql);
				$i = $result->num_rows;
				$i = $i+1;
				$msg['image']="";
				while(list($key,$value) = each($_FILES['afbeeldingen']['name'])){
					if(!empty($value)){ 
						$file = $value;
						$filename = $_FILES['afbeeldingen']['name'][$key];
						$filetype = $_FILES['afbeeldingen']['type'][$key];
						$filesize = $_FILES['afbeeldingen']['size'][$key];
						$temp = $_FILES['afbeeldingen']['tmp_name'][$key];

						$ext = explode(".",$filename);
						$ext = $ext[count($ext)-1];
						$path = $settings['pf_item_path']."portfolio/";
						if(!is_dir($path)){
							mkdir($path, 0755, true);
						}


						list($width, $height) = getimagesize($temp);
						$afbeelding = $path.$filename;

						$save = "../".$path.$filename; 
						//$thumb = $path."thumb_".$filename.".".$ext;
						//$hash = md5(date("d-m-Y:h-i-s").$temp);
						
						$sql="SELECT * FROM ".$prefix."userimages WHERE name = '$file'";
						if(!$result = $this->link->query($sql))
							$this->db_message($sql);

						if($result->num_rows < 1){
							if($width < 3500 && $height < 3500 && $filesize < 5500000){
								if (!copy($temp, ROOT.$save))
								{
									return $file."----".$afbeelding;
								
									{
									unlink($file);
									if(!is_writable($path))
											return "{$file} Geen rechten:{$afbeelding}";	
									else
										return "{$file} Wel rechten:{$afbeelding}";						
										return "";
									}
								}
								unlink($temp);
								
								$sql="INSERT INTO ".$prefix."portfolioitems (name, image, add_date, category, show_page, status)VALUES('$filename', '$afbeelding', NOW(), '$category', '$show_page', '1')";
								if(!$result = $this->link->query($sql))
									$this->db_message($sql);
								else{
									$this->adminLog("Afbeelding $filename toegevoegd bij categorie $category");
									$msg['image'] .= $this->message("NOTICE","Image $filename is succesvol toegevoegd.<br />");
								}
							}else{
								$msg['image'] .= $this->message("ERROR","Het uploaden van $filename is mislukt. Het plaatje mag maximaal 2500x2500 pixels en maximaal 1mb groot zijn!");
							}
						}else{
							echo $this->message("ERROR","De bestandsnaam bestaat al. Verander de naam.");
						}
					}else{
						$msg['image'] .= $this->message("ERROR", "Uploaden mislukt. Er is geen afbeelding toegevoegd.");	
					}
				}
			}
			require('templates/upload_pf_images.php');		
		}
		
		public function uploadProjectImages($project_id){
			global $prefix,$settings;	

			$sql="SELECT name FROM ".$prefix."useralbums WHERE id = '$project_id' ";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);
	
			$rs = $result->fetch_array(MYSQLI_BOTH);
			$project_naam = $rs['name'];
			$msg['image']="";
			
			if(isset($_POST['upload_images'])){
					while(list($key,$value) = each($_FILES['afbeeldingen']['name'])){
								if(!empty($value)){ 
									$file = $value;
									$filename = $_FILES['afbeeldingen']['name'][$key];
									$filetype = $_FILES['afbeeldingen']['type'][$key];
									$filesize = $_FILES['afbeeldingen']['size'][$key];

									$temp = $_FILES['afbeeldingen']['tmp_name'][$key];
									
			
									$ext = explode(".",$filename);
									$ext = $ext[count($ext)-1];
									$path = $settings['image_path']."$project_naam/";

									if(!is_dir($path)){
										mkdir($path, 0755, true);
									}
	
	
									list($width, $height) = getimagesize($temp);
									$afbeelding = $path.$file;

									$save = $path.$file; 
									//die($save);
									//$thumb = $path."thumb_".$filename.".".$ext;
									//$hash = md5(date("d-m-Y:h-i-s").$temp);
									
									$sql="SELECT * FROM ".$prefix."userimages WHERE name = '$file'";
									if(!$result = $this->link->query($sql))
										$this->db_message($sql);

									if($result->num_rows < 1){
										if($width < 9500 && $height < 9500 && $filesize < 9500000){
											if (!copy($temp, ROOT.$save))
											{
												return $file."----".$afbeelding;
											
												{
												unlink($file);
												if(!is_writable($path))
														return "{$file} Geen rechten:{$afbeelding}";	
												else
													return "{$file} Wel rechten:{$afbeelding}";						
													return "";
												}
											}
											unlink($temp);
											
											$sql="INSERT INTO ".$prefix."userimages (name, image, add_date, project)VALUES('$filename', '$save', NOW(), '$project_id')";
											if(!$result = $this->link->query($sql))
												$this->db_message($sql);
											else{
												$this->adminLog("Afbeelding $filename toegevoegd aan project $project_id");
												$msg['image'] .= $this->message("NOTICE","Image $filename is succesvol toegevoegd.<br />");
											}
										}else{
											$msg['image'] .= $this->message("ERROR","Het uploaden van $filename is mislukt. Het plaatje mag maximaal 2500x2500 pixels en maximaal 1mb groot zijn!");
										}
									}else{
										echo $this->message("ERROR","De bestandsnaam bestaat al. Verander de naam.");
									}
								}else{
									$msg['image'] .= $this->message("ERROR", "Uploaden mislukt. Er is geen afbeelding toegevoegd.");	
								}
					}
			}
			require('templates/uploadimages.php');
		}
		
		public function imageDetails($image_id, $auth_key){
			global $prefix, $settings, $classes, $msg, $page;	
				
				$sql="SELECT * FROM ".$prefix."userimages WHERE id = '$image_id'";
				if(!$result = $this->link->query($sql))
					$this->db_message($sql);
			
				if($result->num_rows > 0){
					$image_details = $result->fetch_array(MYSQLI_BOTH);
					
					$sql="SELECT * FROM ".$prefix."useralbums WHERE id = '{$image_details['project']}' ";
					if(!$result_project = $this->link->query($sql))
						$this->db_message($sql);
				
					$project = $result_project->fetch_array(MYSQLI_BOTH);
					
					if(isset($_GET['mode']) && $_GET['mode']=='edit_image'){
						if($_POST['edit_image']!=""){
							$image_details['omschrijving'] = $_POST['omschrijving'];
							
							//indien de naam is veranderd, check op duplicaten
							if($image_details['name'] !=  $_POST['name']){
								$image_details['name'] = $_POST['name'];
								
								$sql="SELECT name FROM ".$prefix."userimages WHERE name='{$image_details['name']}' ";
								if(!$result_dup = $this->link->query($sql))
									$this->db_message($sql);
						
								if($result_dup->num_rows < 1){
									$new_path = $settings['image_path']."albums/{$album['naam']}/{$image_details['naam']}";
									if(rename("{$image_details['afbeelding']}" ,$new_path)==TRUE){
										$afbeelding = "image = '$new_path',";
										$naam = "name = '{$image_details['name']}',";
									}else{

									}
								}else{
									$error['name']=$this->message("ERROR","De naam bestaat al, verzin een andere.");	
								}
							}
							$new_image = $_FILES['afbeelding'];
							
							if($new_image['tmp_name']!="")							
								$this->upload_image($new_image, $save, "albumfotos", "afbeelding", NULL, "");	
							
							//naam is verplicht
							
							if($image_details['name'] != ""){
								$sql = "UPDATE ".$prefix."userimages SET ";
								$sql .= $naam . $afbeelding;
								$sql .= " datum_aangepast = NOW() ";
								$sql .= "WHERE id = '{$_GET['view']}' ";
								//die($sql);
								if(!$result2 = $this->link->query($sql))
									$this->db_message($sql);
								else{
									$this->adminLog("Afbeelding $image_id aangepast van project ".$image_details['album']);
									$msg['notice'] = $this->message("NOTICE","De afbeelding is aangepast.");
								}
								
							}else{
								if($image_details['name'] == "")
									$error['name']=$this->message("FIELD_ERROR","Geef een naam op.");
							}							
						}						
						require('templates/editimage.php');	
					}else{				
						require('templates/image_details.php');
					}
					$result_project->free();
				}else{
					echo $this->message("ERROR","Ongeldige image. Probeer het opnieuw.");	
				}
				$result->free();
		}
		
		
	public function deleteProjectImage($image_key,$project_id){
		global $prefix, $settings;

			$sql="SELECT * FROM ".$prefix."userimages WHERE id = '$image_key' ";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);

			if($result->num_rows > 0){
				$image = $result->fetch_array(MYSQLI_BOTH);
				
				//verwijder het fysieke plaatje
				if(unlink(ROOT.$image['image'])){
					$sql="DELETE FROM ".$prefix."userimages WHERE id = '$image_key'";
					if(!$result_rm = $this->link->query($sql))
						$this->db_message($sql);
					else{
						$this->adminLog("Foto $image_key is verwijderd van project $project_id");
						echo $this->message("NOTICE","De foto is verwijderd. Een moment geduld...");
						echo "<meta http-equiv=\"refresh\" content=\"1; url={$_SERVER['PHP_SELF']}?section=projects&amp;project_id=$project_id\">";
					}
				}
			}else{
				echo $this->message("ERROR","Je probeert een niet bestaande afbeelding te verwijderen.");	
			}			
			$result->free();
		}
		
		public function deleteProject($project_id){
			global $prefix, $settings;
			
			$sql="SELECT * FROM ".$prefix."useralbums WHERE id = '$project_id' ";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);
			
			if($result->num_rows > 0 ){
				$sql="SELECT * FROM ".$prefix."userimages WHERE project = '$project_id' ";
				if(!$result2 = $this->link->query($sql))
					$this->db_message($sql);

				//verwijder plaatjes
				
				if($result2->num_rows > 0){
					if($settings['allow_deletion_non_empty_project']=='1'){
						$images = $result2->fetch_array(MYSQLI_BOTH);
						foreach($images as $image){
							unlink($image['image']);
						}
						
						$sql="DELETE FROM ".$prefix."userimages WHERE project = '$project_id'";
						if(!$result_rm = $this->link->query($sql))
							$this->db_message($sql);
					}else{
						echo $this->message("ERROR","Er zijn nog plaatjes in dit album. Verwijder deze eerst.");
						exit();
					}
				}
				
				$sql="DELETE FROM ".$prefix."useralbums WHERE id = '$project_id'";
				if(!$result_rm = $this->link->query($sql))
					$this->db_message($sql);				
				else{
					echo $this->message("NOTICE","Het project is verwijderd, een moment geduld...");
					echo "<meta http-equiv=\"refresh\" content=\"2;URL=index.php?section=projects\" />";
					$this->adminLog("Project $project_id verwijderd");
				}
				$result->free();
			}else{
				echo $this->message("ERROR","Project niet gevonden. Verwijderen is mislukt.");	
			}
			
			$result2->free();
		}
		
	public function upload_image($image, $save, $table, $column, $empty, $id){
		global $prefix, $settings;

		$filename = $image['name'];
		$filetype = $image['type'];
		$filesize = $image['size'];
		$temp = ROOT.$image['tmp_name'];
		
		$ext = explode(".",$filename);

		$allowed_ext = array('jpeg', 'jpg', 'bmp', 'png', 'gif');
		
		list($width, $height) = getimagesize($temp);
		
		if($table=="album"){
			$column = "thumb";
			$max_height = 350;
			$max_width = 350;
			$max_file_size = 100000;
		}else{
			$max_height = 3500;
			$max_width = 3500;
			$max_file_size = 2000000;
		}
		
		if($width < $max_width && $height < $max_height && $filesize < $max_file_size){
			if (!copy($temp, ROOT.$save))
			{
				return $file."----".$afbeeldingen;
			
				{
				unlink($file);
				if(!is_writable($path))
						return "{$file} Geen rechten:{$afbeelding}";	
				else
					return "{$file} Wel rechten:{$afbeelding}";						
					return "";
				}
			}
			unlink($temp);
			$blog_id = $_GET['edit_item'];

			if($empty)
				$sql = "INSERT INTO ".$prefix.$table."($column) VALUES('$save')";
			else
				$sql = "UPDATE ".$prefix.$table." SET  $column = '$save' WHERE id = '$id'";

			if(!$result = $this->link->query($sql))
				$this->db_message($sql);

			$_SESSION['valid_image'] = TRUE;
		}else{
			 //$msg['image'] = $this->message("ERROR","Het plaatje mag maximaal $max_width pixels breed + $max_height hoog zijn en maximaal 1,5mb groot zijn!");
			 $_SESSION['valid_image'] = FALSE;
		}
	}
	
	public function findNotes($project_id){
		global $settings, $prefix;
		
		$sql="SELECT * FROM ".$prefix."userlog WHERE project = '$project_id' ";
		if(!$result = $this->link->query($sql))
				$this->db_message($sql);
			
		if($result->num_rows > 0 )
			return TRUE;
		else
			return FALSE;
	}
	
	public function noteDetails($project_id){
		global $settings, $prefix;
		
		$sql="SELECT * FROM ".$prefix."userlog u LEFT JOIN ".$prefix."notetypes n ON u.type = n.id WHERE project = '$project_id' ";
		if(!$result = $this->link->query($sql))
				$this->db_message($sql);
		echo "<div class='header_title'>Notities</div><div class='project_details'><table class='project_details'>";
		while($rs=$result->fetch_array(MYSQLI_BOTH)){
			$date=date("d-m-Y H:i:s", $rs['date']); 
			echo "<tr><td><b>".ucwords($rs['user']). "</b></td><td>".$date."</td><td style='color:green'><i>".$rs["name"]."</i></td><td>".$rs["description"]."</td>";	
		}
		echo "</table></div>";
		
	}
	
	public function logOverview(){
		global $prefix, $settings;

		echo "<div class='interval'><div class='add'><a href='".$_SERVER['PHP_SELF']."?section=log&amp;mode=admin'>Admin log</a></div><div class='add'><a href='".$_SERVER['PHP_SELF']."?section=log&amp;mode=user'>User log</a></div><div class='add'><a href='".$_SERVER['PHP_SELF']."?section=log&amp;mode=mysql'>MySQL log</a></div>";
		echo "</div>";
		//if($settings['search_log']==1&& !isset($_GET['details']) && !isset($_GET['delete']))
		//	echo "<div class='add'><a href='".$_SERVER['PHP_SELF']."?section=log&amp;mode=search'>Geavanceerd zoeken</a></div>";
		echo "<div class='add'><a href='".$_SERVER['PHP_SELF']."?section=log&amp;mode=blacklist'>Blacklist</a></div>";
		
		if(!isset($_GET['mode']))
		   	$mode='user';
		 else
			$mode=$_GET['mode'];
		
		
	
		if($mode=="user" || $mode=="admin" || $mode=="mysql"){
			if(isset($_GET['add_user_ip']))$known_ip=trim($_GET['add_user_ip']);
			if(isset($known_ip)){
				$this->addKnownIP($known_ip);
				exit;
			}
			
			if(isset($_GET['details'])){
				$id = intval($_GET['details']);
				$this->logDetails($id, $mode);
			}else{
				if(isset($_GET['delete'])){
					$id = intval($_GET['delete']);
					$this->deleteLogItem($id, $mode);
				}
				
				if($mode=="user")$this->searchForm();
				
				if(isset($_GET['mode']))
					$type = $_GET['mode'];
				else
					$type="";
					
					$table= 'log';
					
					switch($type){
						case "admin":
							$type = 'admin';
							break;
						case "user":
							$type = 'index';
							break;
						case "mysql":
							$type = 'mysql';
							$table= 'mysql_log';
							break;
						default:
							$type = 'index';
							break;	
					}
				if($type!='mysql')
					$sql="SELECT * FROM ".$prefix.$table." WHERE page='".$type."'";
				else
					$sql="SELECT * FROM ".$prefix.$table."";
				if(!$result = $this->link->query($sql))
					$this->db_message($sql);

				$aantal = $result->num_rows;
				$search="";
				if($aantal > 0){	
					if(isset($_POST['naam']))
						$search = " AND name LIKE '%".mysqli_real_escape_string($this->link,trim($_POST['naam']))."%'";
					if(isset($_POST['date']))
						$search .= " AND date LIKE '%".mysqli_real_escape_string($this->link,trim($_POST['date']))."%'";
					if(isset($_POST['ip']))
						$search .= " AND l.ip LIKE '%".mysqli_real_escape_string($this->link,trim($_POST['ip']))."%'";	
					if(isset($_POST['exclude_ip']) || isset($_GET['exlude_ip']))	
						$search .= "AND l.ip NOT IN ('78.27.63.121', '83.163.18.165') ";
					$page="";
					if($mode=='user') 
						{
						$sql="SELECT * FROM  ".$prefix.$table;
						if($type!="mysql")$page = "WHERE page = '$type'";
						$sql.=" l INNER JOIN ".$prefix."known_hosts k ON l.ip = k.ip $page $search ORDER BY l.id DESC";
						}
					else
						$sql .= " $page $search ORDER BY id DESC";

					if(!$result = $this->link->query($sql))
						$this->db_message($sql);
					$aantal = $result->num_rows;
					
					//resultaten per pagina
					//$page_rows = $settings['max_log_items'];
					$page_rows=30;
					$paginas = ceil($aantal/$page_rows);
						
					if (!isset($_GET['page_num']))
						$pagenum = 1; 
					else
						$pagenum = trim($_GET['page_num']); 
					
					if($type!="mysql")$page = "WHERE page = '$type'";
					$max = 'limit ' .($pagenum - 1) * $page_rows .',' .$page_rows;
	//die("SELECT * FROM  ".$prefix."log WHERE page = '$type' $search ORDER BY id DESC $max");
					$sql="SELECT * FROM  ".$prefix.$table;
					if($mode=='user') 
						$sql.=" l INNER JOIN ".$prefix."known_hosts k ON l.ip = k.ip $page $search ORDER BY l.id DESC $max";
					else
						$sql .= " $page $search ORDER BY id DESC $max";

					if(!$result_log = $this->link->query($sql))
						$this->db_message($sql);								
					
					echo "<table class='editform'><tr><th><b>Datum</b></th><th><b>Gebruiker / IP</b></th>";
					if($type!="mysql")
						echo "<th><b>Aktie</b></th>";
					echo "<th><b>Melding</b></th><th>&nbsp;</th></tr>";

					while($rl = $result_log->fetch_array(MYSQLI_BOTH)){
						if($rl['message']=="BAD LOGIN"){
							$trclass="bad";
						}else{
							$trclass="record";
						}
						$date=date("d-m-Y H:i:s", $rl['date']);
						echo "<tr class='$trclass'>
						<td>".$date."</td>";
						
						if(isset($rl['ip']))$user_ip = $rl['ip'];
						if(isset($rl['name']))$rl["ip"]=$rl["name"];
						
						if($type=='mysql')
							echo "<td class='user'>".$rl['user']."</td>";
						else
							echo "<td class='user'>".$rl['ip']."</td>";
						
						$rl['url_short'] = "";
						if(isset($rl['url']))$rl["url_short"]=$rl["url"];
						if(strlen($rl['url_short']) > 80)
							$rl["url_short"] = substr($rl["url_short"],0,80)."... ";
							
						$rl["message_short"]=$rl["message"];
						if(strlen($rl['message_short']) > 80)
							$rl["message_short"] = substr($rl["message_short"],0,80)."... ";
							
						if($mode!="mysql")
							echo "<td class='url' title='".htmlentities($rl["url"])."'>".htmlentities($rl["url_short"])."</td>";
						echo "<td class='url' title='".htmlentities($rl["message"])."'>".htmlentities($rl["message_short"])."</td><td align='right'>";
						if($mode=="user")echo "<a href='".htmlentities($_SERVER['PHP_SELF'])."?section=log&amp;mode=".$mode."&amp;add_user_ip=".$rl["ip"]."'><img src='".ROOT."images/plus.png' alt='Toevoegen als bekende gebruiker' /></a> ";
						echo "<a href='".htmlentities($_SERVER['PHP_SELF'])."?section=log&amp;mode=".$mode."&amp;details=".$rl["id"]."'><img src='".ROOT."images/view.gif' alt='' /></a> ";
						echo "<a href='".htmlentities($_SERVER['PHP_SELF'])."?section=log&amp;mode=".$mode."&amp;delete=".$rl['id']." '><img src='".ROOT."images/cross.gif' alt='Verwijder log' /></a>";
						echo "</td></tr>";
					}
					echo "</table><div class='nav_bottom'>";
					//op welke pagina nu

					if(($aantal > $max)&&($pagenum < $paginas)){
							$page_next = $pagenum + 1;
							echo "<div class='older'><a href='".$_SERVER['PHP_SELF']."?section=log&amp;mode=$mode&amp;page_num=$page_next";
							if(isset($_POST['exclude_ip']) || isset($_GET['exlude_ip']))	
								echo "&amp;exlude_ip=1";						
							echo "'>&#8592; Ouder</a></div>";
						}
						if($pagenum > 1){
							$page_prev = $pagenum - 1 ;
							echo "<div class='newer'><a href='".$_SERVER['PHP_SELF']."?section=log&amp;mode=$mode&amp;page_num=$page_prev";
							if(isset($_POST['exclude_ip']) || isset($_GET['exlude_ip']))	
								echo "&amp;exlude_ip=1";
							echo "'>Nieuwer &#8594;</a></div>";
					}
	
					echo "</div>";
					}else{
						echo $this->message("NOTICE","Log is leeg");
					}
					$result->free();	
			}
		}elseif($mode=="blacklist"){
			$error = "";
			
			if(isset($_POST['input_blacklist_form'])){
				$ip=trim($_POST['ip']);
				$reason=mysqli_real_escape_string($this->link,trim($_POST['reason']));
				
				if($ip!="" && $reason!=""){
					$sql="SELECT * FROM ".$prefix."blacklist WHERE ip = '".$ip."'";
					if(!$result = $this->link->query($sql))
						$this->db_message($sql);
					
					if($result->num_rows==0){
						//die('ddd');
						$sql="INSERT INTO ".$prefix."blacklist(ip, reason) VALUES('".$ip."','".$reason."')";
						if(!$result = $this->link->query($sql))
							$this->db_message($sql);
						else{
							$msg["notice"]=$this->message("NOTICE","IP is toegevoegd aan blacklist");
							$this->adminLog("IP $ip aan de blacklist toegevoegd ($reason)");
						}
					}else{
						$msg['notice']=$this->message("ERROR","IP adres bestaat al");
					}
				}else{
					if($ip=="")
						$error["ip"]=$this->message("FIELD_ERROR","Geef een ip adres op");
					if($reason=="")
						$error["reason"]=$this->message("FIELD_ERROR","Geef een reden op");
				}
			}elseif(isset($_GET["delete"])){
				$id=$_GET['delete'];
				$this->deleteBlacklistItem($id);
			}

			$text_inputs = array('ip','reason');
			
			if(isset($msg['notice'])) 
				echo $msg['notice'];
			
			echo $this->create_form(1, "add", "blacklist_form", $text_inputs, NULL, NULL, NULL, NULL, $error, NULL);

			$this->blacklistOverview();	
		}
	}
	
	public function deleteBlacklistItem($id){
		global $settings, $prefix;
		
		$sql="SELECT * FROM ".$prefix."blacklist WHERE id = '".$id."'";
		if(!$result = $this->link->query($sql))
			$this->db_message($sql);
		if($result->num_rows>0){
			$rs=($result->fetch_array(MYSQLI_BOTH));
			$ip=$rs['ip'];
			
			$sql="DELETE FROM ".$prefix."blacklist WHERE id = '".$id."'";
				if(!$result = $this->link->query($sql))
					$this->db_message($sql);
				else{
					$this->adminLog("IP $ip verwijderd van blacklist");
					echo $this->message("NOTICE","Ip $ip is verwijderd");
				}
		}else{
			echo $this->message("ERROR","Je probeert een niet bestaand item te verwijderen");
		}
	}
	
	public function hostsOverview(){
		global $settings, $prefix;
				if(isset($_GET['edit_ip'])){
					$sql="SELECT * FROM ".$prefix."known_hosts WHERE id = '".$_GET['edit_ip']."'";
					if(!$result = $this->link->query($sql))
						$this->db_message($sql);
					
					if($result->num_rows>0){
						$rs = $result->fetch_array(MYSQLI_BOTH);
						$result->free();
						
						if(isset($_POST['edit_ip'])){
							$rs['ip'] = trim($_POST['ip']);	
							$rs['naam'] = mysqli_real_escape_string($this->link, trim($_POST['naam']));
							$ip = trim($_POST['ip']);	
							
							if($ip != "" && $this->check_valid_ip($ip)){
								$sql = "UPDATE ".$prefix."known_hosts SET
									ip = '".$rs['ip']."',
									naam = '".$rs['naam']."' 
								WHERE id = '".$_GET['edit_ip']."'";
								if(!$result = $this->link->query($sql))
									$this->db_message($sql);
								else{
									$this->adminLog("IP details id ".$rs['edit_ip']." aangepast");
									$msg['ip'] = $this->message("NOTICE","Succesvol opgeslagen");
								}
							}else{
								$error['ip'] = $this->message("FIELD_ERROR","Ongeldig IP, probeer het opnieuw.");
							}
						}
						require('templates/edit_host.php');
					}else{
						$this->message("ERROR","Fout bij wijzigen, ip is niet in de database gevonden.");
					}
					$result->free();
					
				}else{
					if($_POST['hostform']){
						$rs['ip'] = trim($_POST['ip']);
						$ip = trim($_POST['ip']);
						$rs['naam'] =mysqli_real_escape_string($this->link,trim($_POST['naam']));
						
						$sql="SELECT * FROM ".$prefix."known_hosts WHERE id = '".$rs['id']."'";
						if(!$result = $this->link->query($sql))
							$this->db_message($sql);
						
						if($result->num_rows<1){
							if($rs['ip']!="" && $this->check_valid_ip($ip)){
								$sql="INSERT INTO ".$prefix."known_hosts (ip, naam)VALUES('".$rs['ip']."','".$rs['naam']."')";
								if(!$result = $this->link->query($sql))
									$this->db_message($sql);
								else{
									$this->adminLog("IP ".$rs['ip']." toegevoegd aan knownhosts");
									$msg['ip'] = $this->message("NOTICE","Het ip is toegevoegd op de lijst.");
								}
							}else{
								$error['ip'] = $this->message("ERROR","Geef een juist ip op.");	
							}
						}else{
							$msg['ip'] = $this->message("ERROR","Het ip staat al in de lijst");	
						}
						$result->free();
					}
					
					if(isset($_GET['delete_ip'])){
						$delete_id = $_GET['delete_ip'];
						
						$sql="SELECT * FROM ".$prefix."known_hosts WHERE id = '".$delete_id."'";
						if(!$result = $this->link->query($sql))
							$this->db_message($sql);
					
						if($result->num_rows > 0){
							$sql="DELETE FROM ".$prefix."known_hosts WHERE id = '".$delete_id."'";
							if(!$result = $this->link->query($sql))
								$this->db_message($sql);
							else{
								echo $this->message("NOTICE","Ip is verwijderd, een moment geduld...");
								echo "<meta http-equiv=\"refresh\" content=\"2;URL=index.php?section=logs&mode=hosts\" />";
								die();
							}
						}else{
							echo $this->message("ERROR","Fout bij verwijderen, ip is niet in de database gevonden.");	
						}
						$result->free();
					}
					
					echo "<p style='clear:both'><b>Bekende ip's</p></b><small>IP Filter - Toegevoegde gebruikers</small><table class='log'><tr><th><b>IP</b></th><th><b>Gebruiker</b></th><th>&nbsp;</th></tr>";
					$sql="SELECT * FROM ".$prefix."known_hosts";
					if(!$result = $this->link->query($sql))
						$this->db_message($sql);
				
					while($hosts = $result->fetch_array(MYSQLI_BOTH)){
						echo "<tr><td>".$hosts['ip']."</td><td>".$hosts['naam']."</td><td align='right'>";
						echo "<a href='index.php?section=logs&mode=hosts&edit_ip=".$hosts['id']."'><img src='".ROOT."images/edit.png' /></a>&nbsp;&nbsp;<a href='index.php?section=logs&mode=hosts&delete_ip=".$hosts['id']."'><img src='".ROOT."images/cross.gif' /></a>";
						echo "</td></tr>";
					}
					echo "</table>";
					
					$result->free();
					
					echo $msg["ip"];
					echo "<form method=\"post\" enctype=\"multipart/form-data\" name=\"add_host_form\" action=".$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']." >
<input type=\"hidden\" name=\"hostform\" value=\"add_host\" />
					<table style='margin-top:10px; float:left;clear:both;'>
					<tr><td>".$error['ip']."</td></tr>
					<tr><td class='fields'>Ip toevoegen:</td><td>Naam:</td></tr>
					<tr><td class='fields'><input type='text' name='ip' ";
					if($error['ip'])
						echo "class=\"input_error\"";
					echo "/></td><td><input type='text' name='naam' /><input type=\"submit\" class=\"submit\" value=\"Toevoegen\" src='".ROOT."images/plus.png' /></td></tr></table></form>";
					
					if($_POST['accept']!=""){
						$settings['website_accept_hosts'] = intval($_POST['website_accept_hosts']);
						
							$sql = "UPDATE ".$prefix."settings SET
									website_accept_hosts = '".$settings['website_accept_hosts']."' ";
							if(!$result = $this->link->query($sql))
								$this->db_message($sql);

					}
					
					$sql="SELECT * FROM ".$prefix."settings";
					if(!$result = $this->link->query($sql))
						$this->db_message($sql);
					
					$rs = $result->fetch_array(MYSQLI_BOTH);
					$settings['website_accept_hosts'] = $rs['website_accept_hosts'];
					
					require('templates/hosts_overview.php');
					$result->free();
				}
		
	}
	
	public function addKnownIP($known_ip){
		global $prefix;
		
		$error="";
		
		if(isset($_POST['input_ip_form'])){
	
			$ip = $_POST['ip'];	
			$name = mysqli_real_escape_string($this->link,$_POST['name']);
			
			if($ip != "" && $name !=""){
				$sql="SELECT ip FROM ".$prefix."known_hosts WHERE ip='".$known_ip."'";
				if(!$result = $this->link->query($sql))
						$this->db_message($sql);
				if($result->num_rows==0){
					$sql="INSERT INTO ".$prefix."known_hosts (ip, name) VALUES('".$ip."','".$name."')";
					if(!$result = $this->link->query($sql))
						$this->db_message($sql);
					else{
						$msg['notice']=$this->message("NOTICE","IP is toegevoegd");
						$this->adminLog("IP $ip is gekoppeld aan $naam");
					}
				}else{
					$msg["notice"]=$this->message("ERROR","IP adres is al gekoppeld!");	
				}
			}else{
				if($ip=="")
					$error["ip"]=$this->message("FIELD_ERROR","IP adres is niet ingevuld");
				if($name=="")
					$error["name"]=$this->message("FIELD_ERROR","Naam is niet ingevuld");
			}
		}
			$text_inputs = array('ip', 'name');

			if(isset($msg['info'])) 
				echo $msg['info'];
			
			echo $this->create_form(1, "add", "ip_form", $text_inputs, NULL, NULL, NULL, NULL, $error, NULL);
	}
	
	public function blacklistOverview(){
		global $prefix;
		
		if(isset($_GET['view_ip'])){
			require(ROOT.'templates/blacklist_details.php');
		}else{
			$sql="SELECT * FROM  ".$prefix."blacklist";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);

			if($result->num_rows > 0){
				echo "<table class='editform'><tr><td style='width:150px;'><b>IP</b></td><td><b>Reden</b></td><th>&nbsp;</td></tr>";
				
				while($rl = $result->fetch_array(MYSQLI_BOTH)){
					echo "<tr>";
					echo "<td class='url'>".$rl["ip"]."</td><td class='url'>".htmlentities($rl["reason"])."</td>";
					echo "<td style='text-align:right;'><a href='".htmlentities($_SERVER['PHP_SELF'])."?section=log&amp;mode=blacklist&amp;delete=".$rl['id']." '><img src='".ROOT."images/cross.gif' alt='Verwijder log' /></a>";
					echo "</td></tr>";
				}
				echo "</table>";
			}else{
				echo $this->message("NOTICE","Blacklist is leeg");
			}
		}
	}
	
	public function searchForm(){
		global $prefix, $settings;		
		
		echo "<div class='medium_editform'><form method='POST' action='".htmlentities($_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING'])."'><table class='searchform'><tr class='head'><td colspan='2'><b>Zoeken</b></td></tr>
		<tr><td>Naam</td><td><input type='text' name='naam' class='field_small'/></td></tr>
		<tr><td>Datum</td><td><input type='text' name='date' class='field_small'/></td></tr>
		<tr><td>IP</td><td><input type='text' name='ip' class='field_small'/></td></tr>
		<tr><td><input type='checkbox' name='exclude_ip' value='true'/> Eigen ip negeren</td><td></td></tr>
		<tr><td><input type='submit' class='submit' value='Zoek' /></td><td>&nbsp;</td></tr>
		</table></form></div>";
	}
	
	public function logDetails($id, $type){
		global $settings, $prefix;
		
		$table='log';
		if($type=="mysql")$table="mysql_log";
		
		$sql="SELECT * FROM ".$prefix.$table." WHERE id = '$id'";
		if(!$result = $this->link->query($sql))
			$this->db_message($sql);
		
		if($result->num_rows > 0){
			$detailed_info = $result->fetch_array(MYSQLI_BOTH);
			$date=date("d-m-Y H:i:s", $detailed_info["date"]);
			if($type!="mysql"){
			echo "<table class='details'><tr class='head'><th colspan='1' class='arrow'> <a href='javascript:history.go(-1);'><img src='".ROOT."images/arrow_left.png' alt='' /></a></th><th> Overzicht log entry $id</th><th>"; 
				echo "<a href='".htmlentities($_SERVER['PHP_SELF'])."?section=log&amp;delete=$id'><img src='".ROOT."images/cross.gif' alt='' style='float:right;'/></a>";
				echo "</th></tr>
				<tr><td class='title'>Datum</td><td>".$date."</td><td>&nbsp;</td></tr>
				<tr><td class='title'>Ip</td><td>".$detailed_info["ip"]."</td><td>&nbsp;</td></tr>
				<tr><td class='title'>Webhost</td><td>".$detailed_info["webhost"]."</td><td>&nbsp;</td></tr>";
				if(isset($detailed_info["gebruiker"])) 
					echo "<tr><td class='title'>Gebruiker</td><td>".$detailed_info["gebruiker"]."</td><td>&nbsp;</td></tr>";
				echo "<tr><td class='title'>Browser</td><td>".$detailed_info["browser"]."</td><td>&nbsp;</td></tr>
				<tr><td class='title'>Systeem server</td><td>".$detailed_info["os_server"]."</td><td>&nbsp;</td></tr>
				<tr><td class='title'>Systeem gebruiker</td><td>".$detailed_info["os_user"]."</td><td>&nbsp;</td></tr>
				<tr><td class='title'>Referral</td><td>".wordwrap(htmlentities($detailed_info["referrer"]), 70, "\n", TRUE)."</td><td>&nbsp;</td></tr>
				<tr><td class='title'>Protocol</td><td>".$detailed_info["protocol"]."</td><td>&nbsp;</td></tr>
				<tr><td class='title'>Method</td><td>".$detailed_info["method"]."</td><td>&nbsp;</td></tr>";
				if(isset($detailed_info["melding"]))
					echo "<tr><td class='title'>Melding</td><td>".$detailed_info["melding"]."</td><td>&nbsp;</td></tr>";
				echo "<tr><td class='title'>Data opgestuurd</td><td>".wordwrap($detailed_info["extra"], 70, "\n", true)."</td><td>&nbsp;</td></tr>
				<tr><td class='title'>Query URL</td><td>".wordwrap(htmlentities($detailed_info["url"]), 70, "\n", true)."</td><td>&nbsp;</td></tr></table>";
			}else{
				echo "<table class='details'><tr class='head'><th colspan='1' class='arrow'> <a href='javascript:history.go(-1);'><img src='".ROOT."images/arrow_left.png' alt='' /></a></th><th> Overzicht log entry $id</th><th>"; 
				echo "<a href='".htmlentities($_SERVER['PHP_SELF'])."?section=log&amp;delete=$id'><img src='".ROOT."images/cross.gif' alt='' style='float:right;'/></a>";
				echo "</th></tr>
				<tr><td class='title'>Datum</td><td>".$date."</td><td>&nbsp;</td></tr>
				<tr><td class='title'>Query</td><td>".$detailed_info["message"]."</td><td>&nbsp;</td></tr>
				<tr><td class='title'>Gebruiker</td><td>".$detailed_info["user"]."</td><td>&nbsp;</td></tr>
</tr></table>";
			}
		}else{
			echo $this->message("ERROR","Log item niet gevonden, onjuist id.");	
		}
		$result->free();
	}
	
	public function getUserHost($user_ip){
		global $ip, $prefix;
		
		$sql="SELECT * FROM ".$prefix."known_hosts WHERE ip = '$user_ip'";
		if(!$result = $this->link->query($sql))
			$this->db_message($sql);

		$rs = $result->fetch_array(MYSQLI_BOTH);	
		
		$result->free();
		
		$naam = $rs['naam'];
		return($naam);
	}
	
	public function deleteLogItem($id, $type){
		global $prefix, $settings;
		
		$table="log";
		if($type=="mysql")$table="mysql_log";
		
		$sql="SELECT id FROM ".$prefix.$table." WHERE id='$id' ";
		if(!$result_exist = $this->link->query($sql))
			$this->db_message($sql);

		if($result_exist->num_rows > 0){		
			$sql="DELETE FROM ".$prefix.$table." WHERE id='$id' ";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);
			else{
				//$this->adminLog("Logitem $id uit tabel $table verwijderd");
				echo $this->message("NOTICE","Het logitem is verwijderd");	
				//echo "<meta http-equiv=\"refresh\" content=\"2;URL=index.php?section=log&amp;mode=".$type."\" />";
			}
		}else{
			echo $this->message("ERROR","Logitem bestaat niet en kan dus niet verwijderd worden.");	
		}
		$result_exist->free();
	}
	
	public function check_valid_ip($ip){
		global $settings;
		
		$valid = FALSE;
		
		if(ereg('^([0-9]{1,3}\.){3}[0-9]{1,3}$',$ip))
			$valid = TRUE;
			
		return($valid); 
	}
	
	public function image_camera_data($image){
		global $settings, $prefix;
		
		$exif_ifd0 = @read_exif_data($image,'IFD0' ,0);      
      	$exif_exif = @read_exif_data($image,'EXIF' ,0);
		
		$img_details['make'] = "N/A";
		$img_details['model'] = "N/A";
		$img_details['exposure'] = "N/A";
		$img_details['aperture'] = "N/A";
		$img_details['iso'] = "N/A";
		$img_details['bpa'] = "N/A";
		
		if($exif_ifd0['Make']!="")
			$img_details['make'] = $exif_ifd0['Make']; 	
		if($exif_ifd0['Model']!="")
			$img_details['model'] = $exif_ifd0['Model'];
		if($exif_ifd0['ExposureTime']!="")
			$img_details['exposure'] = $exif_ifd0['ExposureTime'];
		if($exif_ifd0['COMPUTED']['ApertureFNumber'] != "")
			$img_details['aperture'] = $exif_ifd0['COMPUTED']['ApertureFNumber'];
		if($exif_exif['ISOSpeedRatings']!= "")
			$img_details['iso'] = $exif_exif['ISOSpeedRatings'];	
		if($exif_exif['FocalLength']!= "")
			$img_details['bpa'] = $exif_exif['FocalLength'];	
		
		return($img_details);
	}
	
	public function image_quota(){
		global $settings, $prefix;
		
		$sql="SELECT image FROM ".$prefix."userimages";
		if(!$query = $this->link->query($sql))
			$this->db_message($sql);
		
		$quota=0;
		while($image = $query->fetch_array(MYSQLI_BOTH)){
			if(file_exists($image['image']))
        {
        $filesize = filesize($image["image"]);
        $filesize = round($filesize/1024/1024, 2); //mb	
        $quota=$quota+$filesize;
        }
		}
		if($settings['img_quota']<=$quota)
			return FALSE;
		else
			return TRUE;
	}
	
	public function image_quota_status(){
		global $settings, $prefix;
		
		$section = $_GET['section'];
		
		$sql="SELECT image FROM ".$prefix."userimages";
		if(!$result = $this->link->query($sql))
			$this->db_message($sql);

		$quota=0;
		while($image = $result->fetch_array(MYSQLI_BOTH)){
      	if(file_exists($image['image']))
        {
        $filesize = filesize($image["image"]);
        $filesize = round($filesize/1024/1024, 2); //mb	
        $quota=$quota+$filesize;
        }
		}
		$percentage = round(($quota / $settings["img_quota"]) * 100) ."%";
		if($percentage >= 100) {
			$border = "#da3a3a";
			$color = "#fbcaca";
			$width = "100%";
			$message = $this->message("ERROR","Het maximum quota is gehaald. Het is niet mogelijk om nog afbeeldingen te uploaden. Verwijder eerst andere afbeeldingen.");
		}elseif($percentage >= 90) {
			$border = "#cd8351";
			$color = "#f1cfb8";
			$width = $percentage;
			$message = $this->message("ERROR","Let op, maximum quota is bijna gehaald. Verwijder eventueel andere afbeeldingen.");
		}else{
			$border = "#8c9cea";
			$color = "#D8EEFA";
			$width = $percentage;
		}
		echo "<div class='quota_bar'><div class='left' style='float:left;clear:both'><small>Quota afbeeldingen</small></div><div class='bar' style='border: 1px solid $border;'>";
		echo "<div class='line' style='background-color:$color; width:$width; height:20px;'><p>$percentage ($quota van ".$settings["img_quota"]. " mb verbruikt)</p></div></div></div>";
		if(isset($message))echo $message;
	}
	
	public function getSelectfieldItems($id, $column, $table){
			global $prefix;
			
		$sql="SELECT * FROM ".$prefix.$table." ORDER BY name ASC";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);	
			
			if($column=='show_page'){
				$extra = "i LEFT JOIN ".$prefix."info p ON i.show_page = p.id";
				$column= "i.id";
				$table ="portfolioitems";
			}
		
			if($id != ""){
				$sql="SELECT * FROM ".$prefix.$table." $extra WHERE $column = '$id'";
				//if($extra!="")die($sql);
				if(!$result2 = $this->link->query($sql))
					$this->db_message($sql);
				$exist = $result2->fetch_array(MYSQLI_BOTH);			
				if($exist['name']!="")echo "<option value='".$exist['id']."'>".$exist['name']."</option>";	
			}
			
			echo "<option value=''>&nbsp;</option>";
			while($item = $result->fetch_array(MYSQLI_BOTH)){
				echo "<option value='".$item['id']."'>".$item['name']."</option>";	
			}	
	}
	
	public function iconInvoice($id){
		global $settings, $prefix;
			
		$sql="SELECT paid, sent FROM ".$prefix."invoice WHERE project_id = '$id'";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);
		$rs=$result->fetch_array(MYSQLI_BOTH);

		if($rs['paid']=="1")
			$icon="<img src='images/invoices.png' alt='Factuur betaald' />";
		elseif($rs['sent']=="0"&&$rs['paid']=="0")
			$icon="<img src='images/invoices_unsent.png' class='grey' alt='Nog geen factuur verzonden' />";
		else
			$icon="<img src='images/invoices_unpaid.png' alt='Factuur nog niet betaald' />";
		return($icon);
	}
	
	public function iconContact($id){
		global $settings, $prefix;
			
		$sql="SELECT project FROM ".$prefix."contacts WHERE project = '$id'";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);
		$aantal=$result->num_rows;
		
		if($aantal > 0)
			$icon="<img src='images/contact.png' alt='Contactpersoon toegevoegd' />";
		else
			$icon="<img src='images/contact_empty.png' class='grey' alt='Nog geen contactpersoon toegevoegd' />";
		
		
		return($icon);
	}
	
	public function iconPhotos($id){
		global $settings, $prefix;
			
		$sql="SELECT project FROM ".$prefix."userimages WHERE project = '$id'";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);
		$aantal=$result->num_rows;
		
		if($aantal > 0)
			$icon="<img src='images/projects.png' alt='Fotos toegevoegd' />";
		else
			$icon="<img src='images/projects_empty.png' class='grey' alt='Nog geen fotos toegevoegd' />";
		
		
		return($icon);
	}
	
}

?>