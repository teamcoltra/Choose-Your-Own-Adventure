<?php/* #####################################################################
 * 
 * 	This code was made possible by the following people:
 * -Cal Henderson (http://www.iamcal.com)
 * -Travis "TeamColtra" McCrea (http://www.travismccrea.com)
 * -Club Ubuntu Team (http://www.club-ubuntu.org) #Club-Ubuntu Freenode
 * 
 * While part of the terms we do not REQUIRE you to keep attribution
 * we wouldn't mind it. :) 
 * 
 * Speaking of Licences:
 *   This file is part of Choose Your Own Adventure (Paradox Edition)
 *
 *  Choose is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *   Choose is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  inside the file "LICENCE".
 * ###################################################################*/
	include('config.php');




	#
	# save changes?
	#

	if ($_POST[done]){

		$id = intval($_POST[id]);

		$subject = "[iamcal-choose] report for room $id";
		$message = "http://www.iamcal.com/games/choose/edit.php?id=$id\n\n".$_POST[message];

		mail('cal@tinyspeck.com', $subject, $message);


		include('header.txt');
		echo "Thanks! The authorities have been alerted to your plight.";
		include('footer.txt');

		exit;
	}


	#
	# get info for display
	#

	$room_id = intval($_GET[id]);

	$room	= db_single(mysql_query("SELECT * FROM choose_rooms WHERE id=$room_id"));
	$parent	= db_single(mysql_query("SELECT * FROM choose_rooms WHERE room_1=$room_id OR room_2=$room_id"));

	if (!$room[id]){
		include('header.txt');
		print "error: room $room_id not found";
		include('footer.txt');
		exit;
	}


	include('header.txt');
?>


	<h1>Report <a href="room.php?room=<?php=$room[id]?>">Room <?php=$room[id]?></a></h1>
	<br />

	Description:<br />
	<div class="boxy"><?php=HtmlSpecialChars($room[blurb])?></div>
	<br />

	Choice 1:<br />
	<div class="boxy"><?php=HtmlSpecialChars($room[text_1])?></div>
	<br />

	Choice 2:<br />
	<div class="boxy"><?php=HtmlSpecialChars($room[text_2])?></div>
	<br />

<form action="report.php" method="post">
<input type="hidden" name="id" value="<?php=$room[id]?>" />
<input type="hidden" name="done" value="1" />

	<br /><p>Complaint:<br /><textarea name="message" cols="50" rows="10"></textarea></p>

	<p>
		<input type="submit" value="Send Report" />
	</p>
</form>


<?php
	include('footer.txt');
?>
