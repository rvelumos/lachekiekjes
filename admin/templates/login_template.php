
<?
			
	echo   "<form method='post' action='".$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']."' name='loginform' id='loginform' onsubmit='login();return false;'><div class='login_container'>
        ";
			echo "<table class='inlogform'>
			<tr><td>";
			if(isset($error['login']))echo $error["login"];
            echo "<input type='hidden' name='admin_login' value='user_loginform' />
            <input type='hidden' name='login' value='login' /></td></tr>
	    <tr><td>";
		if(isset($error['no_exist']))echo $error['no_exist'];
		
		echo "</td></tr>
			<tr><td class='indent'>Gebruikersnaam ";
			if(isset($error['un']))
				echo "*";
			echo "</td></tr>
			<tr><td><input size='20' name='username'  class='field ";
			if(isset($error['un'])){
				echo "input_error";
			}
			echo "'value='".$_POST['username']."'  /></td></tr>";
			echo "<tr><td class='indent'>Wachtwoord ";
			if(isset($error['pw']))
				echo "*";
			echo "</td></tr>
			<tr><td><input size='20' type='password' class='field ";
			if(isset($error['pw'])){
				echo "input_error";
			}
			echo "' name='password'  value=''  /></td></tr>		
			<tr><td><input type='submit' class='submit' onclick='login();return false;' value='Verzenden'/></td></tr>
			</table>
			</div>
			</form>";
?>



