<div class="login_holder">

<?
if(isset($error['password'])){
	echo $error['password'];
};
			echo   "<form method='post' action='' name='loginform' id='loginform' onsubmit='login();return false;'><div class='login_container'>
        ";
			echo "<table class='inlogform'>
			<tr><td>";
			echo "<td></tr>
			<tr><td>Voer wachtwoord in:</td></tr>
            <input type='hidden' name='login_form' value='user_loginform' />
			<tr><td><input size='20' type='password' class='field ";
			if(isset($error['password'])){
				echo "input_error";
			}
			echo "' name='password'  value=''  /></td><td><input type='submit' class='submit' onclick='login();return false;' value=''/></td></tr>
			</table>
			</div>
			</form>";
            
?>

</div>