<?
//$naam_ontvanger = $_POST['naar_naam']; 
$settings['em_receiver'] = "ronald.eijsden@gmail.com";
$email_ontvanger = $settings['em_receiver']; 

$naam_verzender = "Contactformulier"; 
$email_verzender = "contact@lachekiekjes.nl";
$email_bcc = "ronald.eijsden@gmail.com"; 

$onderwerp = "Contact via formulier Lachekiekjes"; 
//$bericht_verzender = $_POST['bericht_verzender']; 


$headers = "From: ".$naam_verzender." <".$email_verzender.">\r\n"; 
$headers .= "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
$headers .= "Return-Path: Mail-Error <error@mijnsite.nl>\r\n"; 
$headers .= "Reply-To: ".$naam_verzender." <".$email_verzender.">\r\n"; 
$headers .= "Bcc: ".$settings['em_bcc']."\r\n"; 

$bericht_body = htmlspecialchars($_POST['message']);

//$bericht = nl2br($bericht); 
//$bericht =  htmlspecialchars(wordwrap($bericht, 40, "<br />\n"));
//die($bericht);
$bericht = str_replace("#MESSAGE#", $bericht_body, $settings["em_template"]);
$bericht = str_replace("#NAME#", $naam_verzender, $bericht);
$bericht = str_replace("#EMAIL#", $email_verzender, $bericht);
$bericht = str_replace("#ip#", $ip, $bericht);

if(mail($email_ontvanger, $onderwerp, $bericht, $headers))
	echo $this->message("NOTICE",$settings['text_send_email']);
else
	echo $this->message("ËRROR","Fout bij versturen e-mail");
?>