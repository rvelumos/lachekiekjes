<?php
class Main{
  
  function __construct() {
    $this->link = new MySQLi('localhost', '?', '?', "?");
  }
  
  public function getMenuItems(){
		global $prefix,$menu_items, $ip;
		
		echo "<div class='menu'>";

		$sql="SELECT * FROM ".$prefix."menu WHERE admin = 1 & status = 1";
		if(!$result = $this->link->query($sql))
			$this->db_message($sql);
			
			while($menu_item = $result->fetch_array(MYSQLI_BOTH))
				echo "<img src='".ROOT."images/".strtolower($menu_item['cmd']).".png' alt='' class='icon' /><p class='menu_link'><a href='index.php?section=".strtolower($menu_item['cmd'])."' >".$menu_item['name']."</a></p>";	
			$result->free();
		echo "<div class='uitloggen'><a href='index.php?uitloggen=true'><img src='".ROOT."images/cross.gif' alt='Uitloggen' /> Uitloggen</a></div></div>";
		
		return $menu_items;
	}
	
	public function getSettings(){
		global $prefix;

			$sql="SELECT * FROM ".$prefix."settings";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);
				
			$settings = $result->fetch_array(MYSQLI_BOTH);
			
			$result->free();
			
			return($settings);
	}
	
	public function setSettings(){
		global $prefix, $settings;
			
			if(isset($_POST['settings'])){
				$settings['head_titel'] = mysqli_real_escape_string($this->link,$_POST['head_titel']);
				$settings['website_name'] = $_POST['website_name'];				
				$settings['website_status'] = intval($_POST['website_status']);
				$settings['meta_description'] = mysqli_real_escape_string($this->link,trim($_POST['meta_description']));
				$settings['meta_author'] = trim($_POST['meta_author']);
				$settings['meta_keywords'] = mysqli_real_escape_string($this->link,trim($_POST['meta_keywords']));
				$settings['meta_robots'] = trim($_POST['meta_robots']);
				$settings['meta_copyright'] = trim($_POST['meta_copyright']);
				$settings['preview_size'] = intval($_POST['preview_size']);
				$settings['max_width'] = intval($_POST['max_width']);
				$settings['max_height'] = intval($_POST['max_height']);
				$settings['img_quota'] = $_POST['img_quota'];
				$settings['allowed_img_tags'] = $_POST['allowed_img_tags'];
				$settings['max_img_size'] = intval($_POST['max_img_size']);
				$settings['max_img_height'] = intval($_POST['max_img_height']);
				$settings['max_img_width'] = intval($_POST['max_img_width']);
				$settings['image_path'] = $_POST['image_path'];
				$settings['use_tiny_mce'] = $_POST['use_tiny_mce'];
				$settings['max_images'] = intval($_POST['max_images']);
				$settings['pf_max_images'] = intval($_POST['pf_max_images']);
				$settings['session_timeout'] = intval($_POST['session_timeout']);
				$settings['em_template'] = $_POST['em_template'];
				$settings['em_receiver'] = $_POST['em_receiver'];
				$settings['em_bcc'] = $_POST['em_bcc'];
				$settings['text_send_email'] = $_POST['text_send_email'];

					if($settings['head_titel'] != "" && $settings['website_name'] != ""){
						$sql = " UPDATE ".$prefix."settings SET
									head_titel = '".$settings['head_titel']."', 
									website_name = '".$settings['website_name']."', 
									website_status = '".$settings['website_status']."', 
									preview_size = '".$settings['preview_size']."', 
									rename_photo = '".$settings['rename_photo']."',
									max_height = '".$settings['max_height']."',
									allowed_img_tags = '".$settings['allowed_img_tags']."',
									img_quota = '".$settings['img_quota']."',
									max_img_size = '".$settings['max_img_size']."',
									max_img_height = '".$settings['max_img_height']."',
									max_img_width = '".$settings['max_img_width']."',
									meta_description = '".$settings['meta_description']."',
									meta_keywords = '".$settings['meta_keywords']."',
									meta_copyright = '".$settings['meta_copyright']."',
									meta_author = '".$settings['meta_author']."',
									meta_robots = '".$settings['meta_robots']."',
									session_timeout = '".$settings['session_timeout']."',
									use_tiny_mce = '".$settings['use_tiny_mce']."',
									image_path = '".$settings['image_path']."',
									max_width = '".$settings['max_width']."',
									max_images = '".$settings['max_images']."',
									pf_max_images = '".$settings['pf_max_images']."',
									em_receiver = '".$settings['em_receiver']."', 
									em_bcc = '".$settings['em_bcc']."', 
									text_send_email = '".$settings['text_send_email']."'"; 			
						
						if(!$result = $this->link->query($sql))
							$this->db_message($sql);
						else{
							$this->adminLog("Instellingen aangepast");
							echo $this->message("NOTICE", "Instellingen zijn gewijzigd");
						}
					}else{
						if($settings["head_titel"] == "")
							$error["head_titel"] = $this->message("FIELD_ERROR","Voer een titel in voor de browserbalk");
						if($settings["website_name"] == "")
							$error["website_name"] = $this->message("FIELD_ERROR","Voer een naam in voor de browserbalk");
					}
				}
			require('templates/settings.php');	
	}	
  
  public function create_field($value, $class, $size, $type, $text, $error, $data){
		global $settings, $prefix;

	$id="";
//	echo($error);
	if(isset($_POST[$value]))
		$data[$value]=$_POST[$value];
	
    switch($value){
      case "number":
      case "price":
      case "postalcode":
        $class = "field_small";
        break;
		
	  case "start_date":
	  	$id=" id='calendar'";
	  	break;
		
	  case "end_date":	
	  	$id=" id='calendar2'";
	  	break;
    }
    
		switch($type){
			case "text":
				$field = "<tr><td class='{$class}'><span>".$text[$value]."</span>";
				if(isset($error[$value]))
					$field .= " het is ".$error[$value];
				$field .= "</td><td></td></tr><tr><td class='{$class}'><input type='text' {$id} class='{$class}' name='{$value}' value='"; 
				if(isset($data) && $data !="") 
					$field .= $data[$value];
				$field .= "'  /></td></tr>";
				break;
				
			case "select_db":
					$field = " <tr><td class='fields'><span>".$text[$value]."</span>";
					if(isset($error[$value])) 
						$field .= $error[$value];
					$field .= "</td><td></td></tr><tr><td class='fields'>";
					if($value=="type")$field .= $this->getNoteTypes();
					if($value=="packet")$field .= $this->availablePackets("project");
					$field .= "</td><td></td></tr>"; 
				 	
				break;
				
			case "select":
					$field = " <tr><td class='fields'><span>".$text[$value]."  </span>";
					if(isset($error[$value])) 
						$field .= $error[$value];
					$field .= "</td></tr><tr><td class='fields'><select name='{$value}'>";
 
				 	if(isset($data[$value])){
						if($data[$value]==0){
							$field .= "<option value='".$data[$value]."'>Nee</option>";
						}else{
							$field .= "<option value='".$data[$value]."'>Ja</option>"; 
						}
					}
				$field .= "<option value=' '> &nbsp;</option>
											<option value='0'>Nee</option>
											<option value='1'>Ja</option>
				</select></td><td></td></tr>";
				break;
        
     		 case "image":
               $field = "<tr><td class='fields'><span>{$value}</span></td></tr>
                <tr><td class='fields'><input type=\"file\" class='file' name=\"";
                if($value=='afbeeldingen')
                  $field .= "afbeeldingen[]\"";
                else
                  $field .= "afbeelding\"";
              $field .= " value=\"\" /></td><td>"; 
              if(isset($error[$value])) 
                $field .= $error[$value]."</td></tr>";
				break;
        
			case "area":
					$field = "<tr><td class='fields'><span>{$text[$value]}</span> ";  
					if(isset($error[$value])) 
						$field .= $error[$value];
					$field .=	"</td><td></td></tr><tr><td class='fields'><textarea class='{$class} ";
					if(isset($error[$value]))
						$field .= "input_error";
					$field .= "' name='{$value}'>";
					if(isset($data[$value])) 
						$field .= $data[$value];
					$field .= "</textarea></td><td></td></tr> ";
				break;
		}
		return $field;
	}
	
	public function create_form($format, $mode, $form_name, $text_inputs, $db_inputs, $select_inputs, $img_inputs, $area_inputs, $error, $data){
		global $settings, $prefix;

    /* global texts for forms */
    $text['address']="Adres:";
    $text['afbeelding']="Afbeelding:";
    $text['content']="Inhoud:";
    $text['description']="Omschrijving:";
    $text['email']="E-mail";
	$text['end_date']="Einddatum project:";
    $text['extra']="Extra:";
    $text['fname']="Voornaam:";
    $text['img_pos']="Positie afbeelding:";
    $text['ip']="IP:";
    $text['lname']="Achternaam:";
	$text['name']="Naam:";
    $text['mobile']="Mobiel nummer:";
    $text['number']="Huisnummer:";
    $text['order']="Positie navigatiemenu:";
	$text['packet']="Gekozen pakket:";
    $text['photos']="Aantal foto's:";
    $text['photos_extra']="Kosten extra foto's per stuk :";
	$text['photos_extra_qty']="Extra foto's buiten pakket:";
    $text['postalcode']="Postcode:";
    $text['price']="Prijs:";
    $text['reason']="Reden:";
	$text['start_date']="Shoot datum:";
	$text['status']="Actief:";
    $text['tel']="Telefoonnummer:";
    $text['town']="Stad:";
	$text['type']="Type:";
		
		switch($format){
			case "1":
				$contents = "<div class='editform'>";
				$contents .= "<form method=\"post\" enctype=\"multipart/form-data\" name=\"".$form_name."\" action=\"". $_SERVER['PHP_SELF']. "?" .$_SERVER['QUERY_STRING']. "\">";
				$contents .= "<input type=\"hidden\" name=\"input_".$form_name."\" value=\"".$mode."_form\" />";
				$contents .= "<table style='margin-top:10px; float:left;'>";
				
				if(isset($text_inputs)){
					foreach($text_inputs as $text_key => $t_value){
						$contents .= $this->create_field($t_value,"field","100","text", $text, $error, $data);
					}
				}
				
				if(isset($db_inputs)){
					foreach($db_inputs as $text_key => $db_value){
						$contents .= $this->create_field($db_value,"field","100","select_db", $text, $error, $data);
					}
				}
				
				if(isset($area_inputs)){
					foreach($area_inputs as $text_key => $a_value){
						$contents .= $this->create_field($a_value,"field","100","area", $text, $error, $data);
					}
				}
				
				if(isset($select_inputs)){
					foreach($select_inputs as $text_key => $s_value){
						$contents .= $this->create_field($s_value,"field","100","select", $text, $error, $data);
					}
				}
				
			 	if(isset($img_inputs)){
					foreach($img_inputs as $text_key => $i_value){
						$contents .= $this->create_field($i_value,"field","100","image", $text, $error, $data);
					}
				}

   			$contents .=  "<tr><td class='fields'><input type=\"submit\" class=\"submit\" value=\"";
				if($mode == "add")
					$contents .= "Toevoegen";
				else
					$contents .= "Bewerken";
				$contents .= "\" /></td><td></td></tr></table></form></div>"; 
				break;	
		}
		
		return $contents;
	}
	
	public function getName($section, $column, $id){
		global $prefix;
		
		$sql="SELECT name FROM ".$prefix.$column." WHERE id = '$id'";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);	
		$rs=$result->fetch_array(MYSQLI_BOTH);
		$name=$rs["name"];
		
		return $name;
	}
	
	public function is_valid($value, $type){
		global $prefix, $settings;
		
		switch($type){
			case "tel":
				if(strlen($value)=='10' || $value=="")
					return TRUE;
				else
					return FALSE;
			break;
			
			case "mobile":
				if(strlen($value)=='10' || $value=="")
					return TRUE;
				else
					return FALSE;
			break;
			
			case "email":
				if (filter_var($value, FILTER_VALIDATE_EMAIL) || $value=="")
					return TRUE;
				else
					return FALSE;
			break;
			
		return FALSE;
		}
	}
  
  public function getCrumblePath(){
		global $settings;	
		
		$mode="";
		$cmd="";
		$id="";
		$section="";
		
		if(isset($_GET['mode']))$mode = $_GET['mode'];
		if(isset($_GET['cmd']))$cmd = $_GET['cmd'];
		if(isset($_GET['section']))$section = $_GET['section'];

		switch($section){
			case "projects" : 
				$head = "Projecten";
				$add = "Project toevoegen";
				$column = "useralbums";
				$sub_head = "images";				
				$edit = "Project wijzigen";
				if(isset($_GET['project_id']))$id = $_GET['project_id'];
				if($cmd=="add_project")$mode = "Project toevoegen";
				if($cmd=="edit_project")$mode = "Project wijzigen";
				if($cmd=="add_contact")$mode = "Contactpersoon toevoegen";
				if($cmd=="edit_contact")$mode = "Contactpersoon wijzigen";
				if($cmd=="add_note")$mode = "Notitie toevoegen";
				if($cmd=="upload_images")$mode = "Foto's toevoegen";
				$edit_url = "project_id=". $id."";
			break;
			
			case "packets" : 
				$head = "Pakketten";
				$add = "Pakket toevoegen";
				$column = "packets";
				$sub_head = "images";				
				$edit = "Pakket wijzigen";
				if(isset($_GET['packet_id']))$id = $_GET['packet_id'];
				if($cmd=="add_packet")$mode = "Pakket toevoegen";
				if(isset($_GET['edit_packet']))$mode = "Pakket wijzigen";
				$edit_url = "packet_id=". $id."";
			break;
			
			case "content":
				$head = "Content";
				$add = "Pagina toevoegen";
				$column = "info";
				$sub_head = "images";				
				$edit = "Pagina wijzigen";
				if($cmd=="add_page")$mode = "Pagina toevoegen";
				if(isset($_GET["edit_content"]))$mode = "Pagina wijzigen";
				if(isset($_GET['edit_content']))$id = $_GET['edit_content'];
				$edit_url = "edit_content=". $id."";
			break;
			
			case "portfolio":
				$head = "Portfolio";
				$column = "portfolioitems";
				$add = "Foto toevoegen";
				$sub_head = "images";				
				$mode = "Foto wijzigen";
				if(isset($_GET['edit_image']))$id = $_GET['edit_image'];
				if(isset($_GET['edit_category']))$c_id = $_GET['edit_category'];
				if(isset($id))$edit_url = "edit_image=". $id."";
				if(isset($c_id))$edit_url = "edit_category=". $c_id."";
			break;
			
			default:
				
			break;
		}
		
		$crumble="";
		
		if(isset($section)){
			$crumble = "<div class='crumble_path'><a href='index.php?section=".$section."'>$head</a>";	
			if($id!="")$crumble .= " &raquo; <a href='index.php?section=".$section."&".$edit_url."'>".$this->getName($section, $column, $id)."</a>";
			if(isset($mode))$crumble .= " &raquo; ".$mode;	
			$crumble.="</div>";
		}
		
		return $crumble;
	}
  
  	public function message($type, $text=FALSE){
		global $settings;
		
		if($text != FALSE){
			switch($type){
				case "ERROR": $message = "<p class='error'>$text</p>"; break;
				case "FIELD_ERROR": $message = "<span class='field_error'>* $text</span>"; break;	
				case "NOTICE": $message = "<p class='notify'>$text</p>"; break;	
				case "SUCCESS": $message = "<p class='success'>$text</p>"; break;
				case "EMPTY": $message = "<p>$text</p>"; break;	
			}
		}else{
			switch($type){
				case "ERROR": $message = "<p class='error'>Het item kon niet worden gevonden. Probeer het opnieuw.</p>"; break;	
				case "FIELD_ERROR": $message = "<span class='field_error'>* Gelieve dit veld in te vullen.</span>"; break;
				case "NOTICE": $message = "<p class='notify'>Het item is succesvol bewerkt.</p>"; break;	
				case "SUCCESS": $message = "<p class='success'>Het item is succesvol opgeslagen.</p>"; break;
				case "EMPTY": $message = "<p>Er zijn geen items gevonden op deze pagina.</p>"; break;	
			}
		}
		return($message);
	}
	
	public function adminLog($message){
		global $prefix, $ip, $page, $url, $webhost, $server, $server_user, $method, $referer, $protocol, $browser;
		
		if($page == "")
			$page = "admin";
		$date=time();
		$sql="INSERT INTO ".$prefix."log (ip, date, page, user, url, browser, webhost, os_server, os_user, referrer, message, protocol, method) VALUES('".$ip."', '".$date."', '$page', '".$_SESSION['admin_name']."', '".$url."','".$browser."','".$webhost."','".$server."','".$server_user."','".$referer."','".$message."', '".$protocol.
"','".$method."')";
		if(!$result = $this->link->query($sql))
			$this->db_message($sql);
	}
	
	public function db_message($sql){
		global $prefix;
		
		echo "<div class='db_error'><p>";
		printf("Fout in query: %s\n", $this->link->error);
		echo "</p></div>";	
		
		$sql=str_replace("'", "\'", $sql);
		
		$date=time();
		
		$sql = "INSERT INTO ".$prefix."mysql_log(user, date, message) VALUES('".$_SESSION['admin_name']."', '".$date."', '".$sql."')";
		if(!$result = $this->link->query($sql))
			die('Fout bij opslaan log in mysql_log, details: '.$sql);
	}
  
}
?>