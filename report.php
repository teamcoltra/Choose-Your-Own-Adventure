<?php
	include('config.php');
	include('db.php');
	include('header.txt');


	#
	# save changes?
	#

	if ($_POST['done']){

		if ($settings['enable_recaptcha'] == 1) {
		        require_once('recaptchalib.php');
		        $privatekey = $settings['recaptcha_private_key'];
		        $resp = recaptcha_check_answer ($privatekey,
                        $_SERVER["REMOTE_ADDR"],
                        $_POST["recaptcha_challenge_field"],
                        $_POST["recaptcha_response_field"]);
        		if (!$resp->is_valid) {
        	        echo "The reCAPTCHA wasn't entered correctly. Try again. (".$resp->error.")";
			include('footer.txt');
			exit;
       		 	}	
		}


		$id = intval($_POST['id']);

		$subject = "[zombies] report for room $id";
		$message = "http://www.jeffgeiger.com/zombies/edit.php?id=$id\n\n".$_POST['message'];
		$headers = 'From: '.$config['email']. "\r\n" .
    		'Reply-To: webmaster@example.com' . "\r\n" .
    		'X-Mailer: PHP/' . phpversion();

		mail($config['email'], $subject, $message);


		echo "Thanks! The authorities have been alerted to your plight.";
		include('footer.txt');

		exit;
	}


	#
	# get info for display
	#

	$room_id = intval($_GET['id']);

	$room	= db_single(mysql_query("SELECT * FROM choose_rooms WHERE id=".$room_id));
	$parent	= db_single(mysql_query("SELECT * FROM choose_rooms WHERE room_1=".$room_id." OR room_2=".$room_id));

	if (!$room['id']){
		print "error: room ".$room_id." not found";
		include('footer.txt');
		exit;
	}


?>


	<h1>Report <a href="room.php?room=<?= $room['id']?>">Room <?= $room['id']?></a></h1>
	<br />

	Description:<br />
	<div class="boxy"><?= HtmlSpecialChars($room['blurb'])?></div>
	<br />

	Choice 1:<br />
	<div class="boxy"><?= HtmlSpecialChars($room['text_1'])?></div>
	<br />

	Choice 2:<br />
	<div class="boxy"><?= HtmlSpecialChars($room['text_2'])?></div>
	<br />

<form action="report.php" method="post">
<input type="hidden" name="id" value="<?= $room['id']?>" />
<input type="hidden" name="done" value="1" />

	<br /><p>Complaint:<br /><textarea name="message" cols="50" rows="10"></textarea></p>
<?php
if ($settings['enable_recaptcha'] == 1) {
        echo "Prove you're a human:<br />";
        $recaptcha_theme = " <script type=\"text/javascript\">";
        $recaptcha_theme .= "var RecaptchaOptions = {";
        $recaptcha_theme .= "theme : 'white'";
        $recaptcha_theme .= "};";
        $recaptcha_theme .= " </script>";
        echo $recaptcha_theme;
        echo "<form method=\"post\" action=\"\">";
        require_once('recaptchalib.php');
        $publickey = $settings['recaptcha_public_key'];
        echo recaptcha_get_html($publickey);
}

?>

	<p>
		<input type="submit" value="Send Report" />
	</p>
</form>


<?php
	include('footer.txt');
?>
