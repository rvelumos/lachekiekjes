<?php
class Auth extends Main{
	
  public function sessionTimeout(){
		global $settings;
		
		$max_timeout = $settings['session_timeout'];
		
		$time = time();

		//die("het is ".$time." en het is ".$_SESSION['last_activity']." max ".$max_timeout);
		if(($time - $_SESSION['last_activity']) > $max_timeout)
			return TRUE;
		else
			return FALSE;
		return FALSE;
	}
	
	public function authLogin(){
			global $prefix, $ip;

			if(isset($_POST['admin_login'])){
				$data['username'] = mysqli_real_escape_string($this->link, $_POST['username']);
				$data['password'] = mysqli_real_escape_string($this->link, $_POST['password']);	

				if($data['username'] == '' || $data['password'] == ''){
					if($data['username'] == '')
						$error['un'] = $this->message("FIELD_ERROR","Gebruikersnaam is niet ingevuld");
					if($data['password'] == '')
						$error['pw'] = $this->message("FIELD_ERROR","Wachtwoord is niet ingevuld");

					require('templates/login_template.php');
				}else{
					//$data['password']='rdwdselumos123';
					$data['password'] = hash_hmac('sha512', $data['password'], "lk");	
					//die($data['password']);
					$sql="SELECT * FROM ".$prefix."users WHERE username='".$data['username']."' && password='".$data['password']."' ";

					if(!$result = $this->link->query($sql))
						$this->db_message($sql);
					
					if($result->num_rows == 0){
						$_SESSION['admin_login']=FALSE;
						$error['no_exist'] = $this->message("ERROR","Ongeldige gegevens.");
						require('templates/login_template.php');

						$this->authFail();
						return $error;
					}else{
						$rs = $result->fetch_array(MYSQLI_BOTH);
						$_SESSION['admin_name'] = $data['username'];
						//$_SESSION['admin_status'] = $data['status'];
						$_SESSION['auth_lachekiekjes_login'] = true;
						$_SESSION['last_activity'] = time();
						
						echo "<p class='notify_login'>Welkom terug, je wordt nu doorgestuurd....</p>";
						echo "<meta http-equiv=\"refresh\" content=\"2;URL=index.php\" />";
					}
					$result->free();
				}
			}else{
				require('templates/login_template.php');
			}
	}

	public function authFail(){
		global $ip, $prefix, $page, $browser, $url, $webhost, $server, $server_user, $method, $referer, $protocol;
			
			$page="admin";
			$sql="SELECT * FROM ".$prefix."log WHERE ip = '$ip' AND message= 'BAD_LOGIN'";
			if(!$result = $this->link->query($sql))
				$this->db_message($sql);
			
			$date=time();
			$aantal = $result->num_rows;
			if($aantal <= 5){
				$post = mysqli_real_escape_string($this->link, serialize($_POST));
				
				$sql="INSERT INTO ".$prefix."log (ip, date, page, user, url, browser, webhost, os_server, os_user, referrer, message, protocol, method, extra) VALUES('".$ip."', '".$date."', '$page', '', '".$url."','".$browser."','".$webhost."','".$server."','".$server_user."','".$referer."','BAD LOGIN', '".$protocol.
"','".$method."', '".$post."')";
				if(!$rslt = $this->link->query($sql))
					$this->db_message($sql);		
			}else{
				$this->addToBlacklist($message);
			}
	}

	public function isAdmin(){
		global $settings;
		
		if($_SESSION['admin_rights']=='1')
			return true;
	}
		
	public function addNewCategory($new_cat){
		global $prefix;
		
		$sql="INSERT INTO ".$prefix."categories(naam) VALUES('$new_cat')";
		if(!$result = $this->link->query($sql))
			$this->db_message($sql);
		else
			$this->adminLog("Categorie toegevoegd");
	}                   
}

?>
                         
                         
                        