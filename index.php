<?php
	include('config.php');
	include('db.php');
	include('header.txt');

print nl2br(htmlentities(chop($settings['main_page_text'])));
?>

<br /><br />
So what are you waiting for? <a href="room.php" style="font-size: 130%;">Start playing</a>.
<br /><br />
<?php
	include('footer.txt');
?>
