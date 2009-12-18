<?php
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

		db_update('choose_rooms', array(
			'blurb'		=> AddSlashes($_POST[blurb]),
			'text_1'	=> AddSlashes($_POST[text_1]),
			'text_2'	=> AddSlashes($_POST[text_2]),
		), "id=$id");

		header("location: edit.php?id=$id&done=1");
		exit;
	}


	#
	# delete room?
	#

	if ($_POST[delete]){

		$id = intval($_POST[id]);

		$room = db_single(mysql_query("SELECT * FROM choose_rooms WHERE id=$id"));
		$parent	= db_single(mysql_query("SELECT * FROM choose_rooms WHERE room_1=$id OR room_2=$id"));

		db_write("DELETE FROM choose_rooms WHERE id=$id");
		db_write("UPDATE choose_rooms SET room_1=0 WHERE room_1=$id");
		db_write("UPDATE choose_rooms SET room_2=0 WHERE room_2=$id");

		header("location: edit.php?id=$parent[id]");
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


<h1>Edit <a href="room.php?room=<?php

<?php
	<p>Parent room: <a href="edit.php?id=<?php
<?php

<?php
	<div style="border: 1px solid #000000; padding: 10px; background-color: #eeeeee;">Your changes have been saved.</div>
<?php

<form action="edit.php" method="post">
<input type="hidden" name="id" value="<?php
<input type="hidden" name="done" value="1" />

	<br /><p>Description:<br /><textarea name="blurb" cols="50" rows="10"><?php

<?php

	<p>(stort ends here)</p>

	<input type="hidden" name="text_1" value="" />
	<input type="hidden" name="text_2" value="" />

<?php

	<p>	Choice 1:
<?php
		(to <a href="edit.php?id=<?php
<?php
		(no story written)
<?php
		<br /><input type="text" name="text_1" size="50" value="<?php
	</p>

	<p>	Choice 2:
<?php
		(to <a href="edit.php?id=<?php
<?php
		(no story written)
<?php
		<br /><input type="text" name="text_2" size="50" value="<?php
	</p>

<?php

	<p>
		<input type="submit" value="Save Changes" />
	</p>
</form>

<?php
	if ($room[room_1] || $room[room_2]){
?>

<p>This room can't be deleted - it has children.</p>

<?php
	}else{
?>

<form action="edit.php" method="post">
<input type="hidden" name="id" value="<?php
<input type="hidden" name="delete" value="1" />

	<p>
		<br />
		<br />
		<br />
		<br />
		<input type="submit" value="Delete This Room" style="background-color: red; color: white; font-weight: bold;" />
	</p>
</form>

<?php
	}
?>


<?php
	include('footer.txt');
?>