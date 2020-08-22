<?
class Content{
	public function __construct() {
		$this->link = new MySQLi('localhost', '?', '?', "?");
	}
	
	public function visitorLog($message){
		global $prefix, $ip, $page, $url, $webhost, $server, $server_user, $method, $referer, $protocol, $browser;
		if($page == "")
			$page = "index";
		$date=time();

		$url=mysqli_real_escape_string($this->link, $url);
		$sql="INSERT INTO ".$prefix."log (ip, date, page, user, url, browser, webhost, os_server, os_user, referrer, message, protocol, method) VALUES('".$ip."', '".$date."', '$page', 'user', '".$url."','".$browser."','".$webhost."','".$server."','".$server_user."','".$referer."','".$message."', '".$protocol.
"','".$method."')";

		if(!$result = $this->link->query($sql))
			$this->db_message($sql);
	}
	
	public function getSettings(){
		global $prefix, $settings;

		$sql = "SELECT * FROM ".$prefix."settings";
		if(!$result = $this->link->query($sql))
			$this->db_message($sql);
		else
			$settings = $result->fetch_array(MYSQLI_BOTH);
		
		$result->free();
		
		return($settings);
	}

	function makeThumbnails($path)
	{
    $thumbnail_width = 100;
    $thumbnail_height = 100;
    $thumb_beforeword = "thumb";
    $arr_image_details = getimagesize($path); // pass id to thumb name
    $original_width = $arr_image_details[0];
    $original_height = $arr_image_details[1];
    if ($original_width > $original_height) {
        $new_width = $thumbnail_width;
        $new_height = intval($original_height * $new_width / $original_width);
    } else {
        $new_height = $thumbnail_height;
        $new_width = intval($original_width * $new_height / $original_height);
    }
    $dest_x = intval(($thumbnail_width - $new_width) / 2);
    $dest_y = intval(($thumbnail_height - $new_height) / 2);
    if ($arr_image_details[2] == IMAGETYPE_GIF) {
        $imgt = "ImageGIF";
        $imgcreatefrom = "ImageCreateFromGIF";
    }
    if ($arr_image_details[2] == IMAGETYPE_JPEG) {
        $imgt = "ImageJPEG";
        $imgcreatefrom = "ImageCreateFromJPEG";
    }
    if ($arr_image_details[2] == IMAGETYPE_PNG) {
        $imgt = "ImagePNG";
        $imgcreatefrom = "ImageCreateFromPNG";
    }
    if ($imgt) {
        $old_image = $imgcreatefrom($path);
        $new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
        imagecopyresized($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
				$path_thumb = str_replace("portolio/portfolio", "portfolio/thumb", $path);
        $imgt($new_image, $path_thumb);
    }
	}
	
	
	public function getMenuItems(){
		global $prefix,$menu_items, $ip;
		
		$content="";
		$path_info = $this->parse_path();		
		
		$page = str_replace("/", "", $_SERVER['REQUEST_URI']);
		
		if($page=="")
			$page="home";
		else
			$page=$path_info['call_parts'][0];
			
		$sql = "SELECT * FROM ".$prefix."info ORDER BY `order` asc";
		if(!$result = $this->link->query($sql))
			$this->db_message($sql);
		else{	
			while($menu_item = $result->fetch_array(MYSQLI_BOTH)){
				if(strtolower($menu_item['name'])=='home')continue;
				if(strtolower($menu_item['name'])==strtolower($page))	
					$content .= "<p class='menu_link_selected'><a href='https://www.ronald-designs.nl/development/projects/lachekiekjes/".urlencode(strtolower($menu_item['name']))."' >".$menu_item['name']."</a></p>";	
				else
					$content .= "<p class='menu_link'><a href='https://www.ronald-designs.nl/development/projects/lachekiekjes/".ROOT.urlencode(strtolower($menu_item['name']))."' >".$menu_item['name']."</a></p>";
			}
			//echo "<p class='menu_link'><a href='http://blog.lachekiekjes.nl' target='_blank'>Blog</a></p>";
			$result->free();
		}
		
		return $content;
	}
	
	public function getLeftImage(){
		global $settings;
		
		$content = "<div class='left_image'><img src='".BASE_URL."images/left_image.png' /></div>";	
		
		return $content;
	}
	
	public function loadSlideImages($page){
		global $settings, $prefix;
		
		$content = "";
		$sql = "SELECT * FROM ".$prefix."portfolioitems WHERE show_page = '$page'";
		if(!$result = $this->link->query($sql))
			$this->db_message($sql);
		if($result->num_rows > 0){
			while($image = $result->fetch_array(MYSQLI_BOTH)){
				$content .= "<img src='".BASE_URL.$image["image"]."' />";	
			}
		}
		$result->free();
		return $content;
	}
	
	public function availablePhotos($id){
		global $settings, $prefix;
		
	/*	$sql ="SELECT * FROM useralbums ua
			LEFT JOIN packets p on ua.packet = p.id
			LEFT JOIN userimages ui on ua.id = ui.project 
		WHERE ua.id = '$id' AND ui.selected = '1' AND ua.status = '1' ";*/
		
		//die($sql);
		$sql ="SELECT * FROM ".$prefix."useralbums ua
			LEFT JOIN ".$prefix."packets p on ua.packet = p.id
		WHERE ua.id = '$id'";
		//die($sql);
		if(!$result = $this->link->query($sql))
			$this->db_message($sql);
			
		$amount = $result->num_rows;
		$rs = $result->fetch_array(MYSQLI_BOTH);
		
	//	$left = $rs['photos'];
			
	//	return($left);
	}
	
	public function loadAlbumContent(){
		global $settings, $prefix, $album_hash;
    
    	$content="";
    
		$sql ="SELECT * FROM ".$prefix."useralbums WHERE hash = '$album_hash' AND status = '1' ";
		
		if(!$result = $this->link->query($sql))
			$this->db_message($sql);
		if($result->num_rows > 0){      
			if(isset($_SESSION['login_user'])){
				$album = $result->fetch_array(MYSQLI_BOTH);
				
				$content = "<h1>". $album['name'] ."</h1>";
				$content .= "<p>Hieronder vind je alle beschikbare foto's. Je kunt in totaal ".$this->availablePhotos($album['id'])." foto's kiezen. Indien je meer foto's wilt kiezen, neem dan contact op met mij.</p> <p>Klik op toevoegen om je favoriete foto's  in 'Favorieten' te plaatsen. Je dient de button 'Voorkeur opslaan' te kiezen om de selectie op te slaan en later weer te kunnen bekijken.";
				$today = date("d-m-Y");

				$day = substr($album['end_date'], 0, 2);
				$month = substr($album['end_date'], 3, 2);
				$year = substr($album['end_date'], 6, 4);

				$end_date = mktime(0, 0, 0, $month, $day, $year);

				if($end_date >= $today){
					//pagina's opbouwen
					if (!isset($_GET['pagina'])){ 
						$pagenum = 1; 
					}else{
						$pagenum = intval($_GET['pagina']); 
					}
					$sql = "SELECT * FROM ".$prefix."userimages WHERE project = '{$album['id']}'";
					if(!$result = $this->link->query($sql))
						$this->db_message($sql);

					$aantal = $result->num_rows;
					//$max = $settings['aantal_fotos'];
					$max=1000;

					$paginas = ceil($aantal/$max);
					$pagelimit = 'limit ' .($pagenum - 1) * $max .',' .$max;		

					//nooit lager dan 1 of hoger dan maximum 
					if ($pagenum < 1) { 
						$pagenum  = 1; 
					}elseif ($pagenum  > $paginas){ 
						$pagenum = $paginas; 
					} 

					$sql="SELECT * FROM ".$prefix."userimages WHERE project = '{$album['id']}' $pagelimit";
					if(!$result = $this->link->query($sql))
						$this->db_message($sql);

					$selected_images="";
					while($images=$result->fetch_array(MYSQLI_BOTH)){
						$content .= "<table class='album_item' id='album_item'><tr><td><span id='{$images['id']}' style='cursor:pointer'> <img src='https://www.ronald-designs.nl/development/projects/lachekiekjes/images/plus.png' alt='Toevoegen' /> Toevoegen</span></td></tr><tr><td valign='top' id='img_".$images['id']."'><a href='https://www.ronald-designs.nl/development/projects/lachekiekjes/image.php?view_image=".$images['id']."' rel='prettyPhoto' title='album'><img src='https://www.ronald-designs.nl/development/projects/lachekiekjes/image.php?thumb=admin/{$images['image']}&amp;size=150' id='original_".$images['id']."' alt='' class='img'/></a></td></tr></table>";
						if($images['selected']=='1') $selected_images=TRUE;
					}
					
					$result->free();
					
					if(isset($_POST['selection'])){
						$sql="UPDATE ".$prefix."userimages SET selected = '0' WHERE project = '{$album['id']}'";

						if(!$result = $this->link->query($sql))
							$this->db_message($sql);
	
						while(list($key,$value) = each($_POST['selection'])){
							if(!empty($value)){
								$sql="UPDATE ".$prefix."userimages SET selected = '1' WHERE id='$value' AND project = '{$album['id']}'";

								if(!$result = $this->link->query($sql))
									$this->db_message($sql);
							}
						}
					}
					
					$sql="SELECT * FROM ".$prefix."userimages WHERE project = '{$album['id']}' AND selected = '1'";
					if(!$result = $this->link->query($sql))
						$this->db_message($sql);
					
					$content .= "</div><div class='selected_items'><p class='album_header'>Mijn selectie</p><form enctype=\"multipart/form-data\" name='save_selection' action='' method='POST'><table class='selection_list' id='selected_list'><tr><td>";
					if($result->num_rows>0){						
						while($selection=$result->fetch_array(MYSQLI_BOTH)){
							$content .= "<table id='table_".$selection['id']."'><tr><td><input type='hidden' name='selection[]' value='".$selection['id']."' /> </td></tr></table>";
			  			$content .= "<table class='copy_image' id='copy_image_".$selection['id']."'><tr><td><span id='".$selection['id']."'><img src='https://www.ronald-designs.nl/development/projects/lachekiekjes/images/cross.gif' style='border:none; padding:0px; margin:5px;' alt='Verwijder foto' /></span><br /><img id='copy_".$selection['id']."' src='../../image.php?thumb=admin/{$selection['image']}&amp;size=150' /></td></tr></table>";
						}						
					}
					$content .= "</td></tr></table><table class='submit'><tr><td><input type='submit' value='Voorkeur opslaan'></td></tr></table></form>";
										
					$content .= "</div>";					
					$content .= "<div class='nav_bottom'>";

				//	for($i=1; $i<=$paginas; $i++){
				//		if($i != $pagenum){
					//		echo "<a href='{$_SERVER['PHP_SELF']}?album_session=".$_GET['album_session']."&amp;pagina=$i'><span class='number'>$i</span></a>";
					//	}else{
					//		echo "<span class='number'>$i</span>";
					//	}
				//	}
					$content .= "</div>";
				}else{
					$content .= $this->message("ERROR", "Het album is verlopen...");		
				}
				
			}else{
					if(isset($_POST['login_form'])){
						$password=trim(mysqli_real_escape_string($this->link, $_POST['password']));
						$sql="SELECT * FROM ".$prefix."useralbums WHERE password = '{$password}' AND hash = '$album_hash'";
						if(!$result = $this->link->query($sql))
							$this->db_message($sql);
						if($result->num_rows > 0){
							$_SESSION['login_user']=TRUE;	
							$content .= $this->message("NOTICE","Ingelogd, een moment geduld...");
							$content .= "<meta http-equiv=\"refresh\" content=\"1;URL=http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."\" />";		
							exit();					
						}else{
							$error['password'] = $this->message("LOGIN_ERROR", "Ongeldig wachtwoord.");
						}
					}
					require('templates/user_login.php');
					
		}

		}else{
			$content = $this->message("ERROR", "Album niet gevonden, controleer de URL");	
		}
	return $content;
	}
	
	function parse_path() {
	  $path = array();
	  if (isset($_SERVER['REQUEST_URI'])) {
		$request_path = explode('?', $_SERVER['REQUEST_URI']);
	
		$path['base'] = rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/');
		$path['call_utf8'] = substr(urldecode($request_path[0]), strlen($path['base']) + 1);
		$path['call'] = utf8_decode($path['call_utf8']);
		if ($path['call'] == basename($_SERVER['PHP_SELF'])) {
		  $path['call'] = '';
		}
		
		if ( ! isset($request_path[1])) {
   			$request_path[1] = null;
		}
		
		$path['call_parts'] = explode('/', $path['call']);
	
		$path['query_utf8'] = urldecode($request_path[1]);
		$path['query'] = utf8_decode(urldecode($request_path[1]));
		$vars = explode('&', $path['query']);
		foreach ($vars as $var) {
		  $t = explode('=', $var);
		  if(!isset($t[1]))$t[1]=null;
		  $path['query_vars'][$t[0]] = $t[1];
		}
	  }
	return $path;
	}

	
	public function loadContent(){	
		global $prefix, $page, $settings, $classes, $ip;

		$path_info = $this->parse_path();		
		
		$page = str_replace("/", "", $_SERVER['REQUEST_URI']);
		
		if($page=="")
			$page="home";
		else
			$page=$path_info['call_parts'][0];
			
		if(isset($path_info['call_parts'][1])){
			$sub_level_1 = $path_info['call_parts'][1];
			if($sub_level_1=='category')$category=$path_info['call_parts'][2];
		}
		
		$size = 300; 
		
		$content = "<div class='content_block'>";

		switch($page){
			default:
			case 'home':
			case 'over mij':
			case 'kosten':
			case 'werkwijze':
				$sql = "SELECT name FROM ".$prefix."info";
				if(!$result = $this->link->query($sql))
					$this->db_message($sql);

				while($names=$result->fetch_array(MYSQLI_BOTH)){
					$allowed_names[]=$names['name'];
				}

				$result->free();
			
				if(!in_array(ucfirst(strtolower($page)), $allowed_names))
					$page="home";

				$sql = "SELECT * FROM ".$prefix."info WHERE name='$page' AND status = 1";

				if(!$result = $this->link->query($sql))
					$this->db_message($sql);
				
				if($result->num_rows>0){
					$content .= "<h1>$page</h1>";
					$rs=$result->fetch_array(MYSQLI_BOTH);						
					$content .= $rs['content'];										
				}
				
				$result->free();	
									
			break;
			
			case 'contact':
					if(isset($_POST['send_info'])){
						$name = $_POST['name'];
						$email = $_POST['email'];	
						$message = $_POST['message'];
						
						if($name!="" && $email!="" && $message!=""){
							$this->sendMail($name, $email, $message);							
							die();
						}else{
							if($name=="")
								$error['name'] = $this->message("FIELD_ERROR","Vul je naam in.");
							if($email=="")
								$error['email'] = $this->message("FIELD_ERROR","Vul je email in.");
							if($message=="")
								$error['message'] = $this->message("FIELD_ERROR","Vul een bericht in.");
						}
					}
					require(ROOT.'templates/contactform.php');
					
			break;
		
			case 'portfolio':
						if(isset($sub_level_1)){
							if(isset($sub_level2)){
								$auth_key = $_GET['view'];
								$this->imageDetails($image, $auth_key, $max_);
							}else{
								$this->fetchCategoryImages($category);
							}
						}else{
							$this->fetchCategories();
						}
			break;
		}
		$content .= "</div>";		
		$content .= "<div class='right_social'><div class='facebook'><a href='http://www.facebook.com/lachekiekjes' class='facebookicon' target='_blank' title='Lachekiekjes op Facebook'></a></div>
					<div class='instagram'><a href='http://www.instagram.com/lachekiekjes' class='instagramicon' target='_blank' title='Lachekiekjes op Instagram'></a></div>
					</div>";
		return $content;
	}
	
	public function sendMail($name, $email, $message){
		global $settings, $prefix;
		
		$sql = "SELECT * FROM ".$prefix."mail_template WHERE name = 'contactform_template'";
		if(!$result = $this->link->query($sql))
			$this->db_message($sql);
		$mail_settings = $result->fetch_array(MYSQLI_BOTH);
		
		$mailFrom = $email;
		$mailReceiver = $mail_settings['receiver'];
		$mailSubject = $mail_settings['subject'];
		$mailBody = $mail_settings['body'];
		
		$mailBody = str_replace('%CONTENT%',$message, $mailBody);
		$mailBody = str_replace('%EMAIL%',$email, $mailBody);
		$mailBody = str_replace('%NAME%',$name, $mailBody);
		
		$headers[] = 'MIME-Version: 1.0';
		$headers[] = 'Content-type: text/html; charset=iso-8859-1';
		//$headers[] = 'To: Lachekiekjes <'.$mailReceiver.'>';
		$headers[] = 'From: '.$name.' <'.$email.'>';
		
		if(mail($mailReceiver, $mailSubject, $mailBody, implode("\r\n", $headers)))
			echo $this->message("NOTICE","De gegevens zijn verstuurd.");
		else
			echo $this->message("ERROR","Fout bij verzenden van formulier, neem contact op met de webmaster.");
		
	}
	
	public function countAlbumImages($project_id){
		global $prefix, $settings;
		
		$sql = "SELECT * FROM ".$prefix."albumphotos WHERE album_id = '$project_id' AND STATUS = '1'";
		if(!$result = $this->link->query($sql))
			$this->db_message($sql);
		$amount = $result->num_rows;
		
		$result->free();
		
		return $amount;
	}
	
	public function fetchCategories(){
		global 	$prefix, $settings;
		
		$sql = "SELECT * FROM ".$prefix."portfoliocategories WHERE status='1'";
		if(!$result = $this->link->query($sql))
			$this->db_message($sql);
		
		if($result->num_rows > 0){
			require(ROOT.'templates/category_images.php');
		}else{
			$msg['empty'] = 'Geen categorien';
		}
		$result->free();
	}
		
	public function fetchCategoryImages($category){
		global $prefix, $settings, $ip, $classes;
		
		$size = $settings['portfolio_size'];
		$small_size = 100;
		$max = $settings['max_images'];
		
		$sql = "SELECT * FROM ".$prefix."portfoliocategories where id = '$category'";
		if(!$result = $this->link->query($sql))
			$this->db_message($sql);
		if($result->num_rows > 0){
			$rs = $result->fetch_array(MYSQLI_BOTH);
			
			$sql = "SELECT * FROM ".$prefix."portfolioitems WHERE status = '1' AND category ='$category'";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);
			
			//build pages
			if (!isset($_GET['pagina'])){ 
				$pagenum = 1; 
			}else{
				$pagenum = intval($_GET['pagina']); 
			}
			$aantal = $result->num_rows;
			$result->free();
			
			$max = 15;

			$paginas = ceil($aantal/$max);

			$pagelimit = 'limit ' .($pagenum - 1) * $max .',' .$max;		
						
			if ($pagenum < 1) { 
				$pagenum  = 1; 
			}elseif ($pagenum  > $paginas){ 
				$pagenum = $paginas; 
			}
			
			$category_sql = "AND category = '$category'";
			
			$sql = "SELECT * FROM ".$prefix."portfolioitems WHERE status = '1' $category_sql ORDER BY `order` ASC";
			
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);			
				
			require(ROOT.'templates/portfolio_images.php');
		}else{
			$msg['empty'] = 'Ongeldige categorie. Indien deze boodschap blijft verschijnen, neem dan contact op.';
		}
		$result->free();

	}
	public function imageViewed($viewed){
		global $settings, $prefix;
		
		$sql ="SELECT viewed FROM ".$prefix."albumphotos WHERE auth_key = '$viewed' AND status = '1' ";
		if(!$result = $this->link->query($sql))
			$this->db_message($sql);
		$views = $result->fetch_array(MYSQL_BOTH);
		
		$update_views = $views['viewed'] + 1;
		if($update_views > 0){
			$sql="UPDATE ".$prefix."albumphotos SET viewed = '$update_views' WHERE auth_key = '$viewed'";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);
		}
		
		$result->free();
		
		return $update_views;
	}
	
	public function imageDetails($image_id, $auth_key){
		global $prefix, $settings, $classes;	
		
		$auth_key = mysqli_real_escape_string($this->link, $auth_key);
		$sql ="SELECT * FROM ".$prefix."albumphotos WHERE auth_key = '$auth_key' AND status = '1' ";
		if(!$result = $this->link->query($sql))
			$this->db_message($sql);
		
		if($result->num_rows > 0){
			$image_details = $result->fetch_array(MYSQLI_BOTH);
			
			$sql = "SELECT * FROM ".$prefix."album WHERE id = '{$image_details['album_id']}' ";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);
			$album = $result->fetch_array(MYSQLI_BOTH);			
			
			require(ROOT.'templates/image_details.php');
		}else{
			$content = "Ongeldige image. Probeer het opnieuw.";	
		}
		$result->free();
		
		return $content;
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
	
	public function message($type, $text=FALSE){
		global $settings;
		
		if($text != FALSE){
			switch($type){
				case "ERROR": 
					$messages = "<p class='error'>$text</p>"; 
					$message = "URL";
					$this->visitorLog($message);
				break;
				case "LOGIN_ERROR": 
					$messages = "<p class='login_error'>$text</p>"; 
					$message = "LOGIN";
					$this->visitorLog($message);
				break;
				case "FIELD_ERROR": $messages = "<span class='field_error'>* $text</span>"; break;	
				case "NOTICE": $messages = "<p class='notify'>$text</p>"; break;	
				case "SUCCESS": $messages = "<p class='success'>$text</p>"; break;
				case "EMPTY": $messages = "<p>$text</p>"; break;	
			}
		}else{
			switch($type){
				case "ERROR": $messages = "<p class='error'>Het item kon niet worden gevonden. Probeer het opnieuw.</p>"; break;	
				case "FIELD_ERROR": $messages = "<span class='field_error'>* Gelieve dit veld in te vullen.</span>"; break;
				case "NOTICE": $messages = "<p class='notify'>Het item is succesvol bewerkt.</p>"; break;	
				case "SUCCESS": $messages = "<p class='success'>Het item is succesvol opgeslagen.</p>"; break;
				case "EMPTY": $messages = "<p>Er zijn geen items gevonden op deze pagina.</p>"; break;	
			}
		}
		return($messages);
	}
	
	public function db_message($sql){
		global $prefix;
		
		echo "<div class='db_error'><p>";
		printf("Fout in query: %s\n", $this->link->error);
		echo "</p></div>";	
				
		mysqli_real_escape_string ( $this->link , $sql );
		
		$date=time();
		
		$sql = "INSERT INTO ".$prefix."mysql_log(user, date, message) VALUES('', '".$date."', '".$sql."')";
		if(!$result = $this->link->query($sql))
			die('Fout bij opslaan log in mysql_log, details: '.$sql);
	}
	
}

?>