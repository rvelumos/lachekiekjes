<?php
require("class.phpmailer.php");

// zie http://phpmailer.sourceforge.net/
// dit is het standaardvoorbeeld voor hoe phpmailer aangeroepen wordt
// ik heb het een klein beetje aangepast en gecomment

$mail = new PHPMailer();

$mail->IsSMTP();                                   // send via SMTP
$mail->Host            = "localhost";              // SMTP server
$mail->SMTPAuth        = false;                     // turn on SMTP authentication
$mail->Username        = "je_smtp_username";       // SMTP username
$mail->Password        = "je_smtp_wachtwoord";     // SMTP password

$mail->From            = "backup_service@ronald-designs.nl";
$mail->FromName        = "backup handler";
$mail->AddAddress("ronald.eijsden@gmail.com","Ronald van Eijsden"); 
$mail->AddReplyTo("no-reply@ronald-designs.nl","no-reply");
// N.B.: weet je je eigen SMTP-gegevens niet of kun je er niet bij? Gebruik dan Gmail zelf
// http://deepakssn.blogspot.com/2006/06/gmail-php-send-email-using-php-with.html


$mail->WordWrap        = 50;                       // set word wrap

// zorg dat de attachmentnaam overeenkomt met de gegenereerde backup (DBNAME) in het shell script!
$mail->AddAttachment("/home/xxxx/domains/ronald-designs.nl/backup/xxxx".date('m-d-Y').".sql.gz"); // /absoluut/pad/naar/attachmentnaam

$mail->IsHTML(true);                               // send as HTML

// neem date op in subject, zodat gmail er aparte 'conversations' van maakt
// je kunt vanuit gmnail er zo ook allerlei filters op los laten
$mail->Subject         =  "Backup database ";
$mail->Body            =  "Backup is succesvol opgeslagen<br /><br />Back-up Service Ronald-Designs ".date('m-d-Y'); // html tekst
$mail->AltBody         =  ""; // kale tekst

if(!$mail->Send())
{
   echo "Mail niet goed verstuurd <p>";
   echo "Mailer Error: " . $mail->ErrorInfo;
   exit;
}

echo "Mail verstuurd";

?>