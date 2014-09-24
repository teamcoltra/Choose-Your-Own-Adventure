<?php
	include('config.php');
	include('db.php');


	$ret = mysql_query("SELECT id FROM choose_rooms WHERE end_here=0 AND blurb='' AND room_1=0 AND room_2=0");
	foreach ($ret['rows'] as $row){
		$ok = delete_room($row['id']);
		echo $ok?'. ':'x '; flush();
	}

	$ret = mysql_query("SELECT id FROM choose_rooms WHERE end_here=0 AND text_1='' AND room_1=0 AND room_2=0");
	foreach ($ret['rows'] as $row){
		$ok = delete_room($row['id']);
		echo $ok?'. ':'x '; flush();
	}

	$ret = mysql_query("SELECT id FROM choose_rooms WHERE end_here=0 AND text_2='' AND room_1=0 AND room_2=0");
	foreach ($ret['rows'] as $row){
		$ok = delete_room($row['id']);
		echo $ok?'. ':'x '; flush();
	}

	echo "<br />All done!";



	function delete_room($id){

		$room = db_single(mysql_query("SELECT * FROM choose_rooms WHERE id=".$id));
		$parent	= db_single(mysql_query("SELECT * FROM choose_rooms WHERE room_1=".$id." OR room_2=".$id));

		if ($room['room_1']) return 0;
		if ($room['room_2']) return 0;

		db_write("DELETE FROM choose_rooms WHERE id=".$id);

		if ($parent['id']){
			db_write("UPDATE choose_rooms SET room_1=0 WHERE id=".$parent['id']." AND room_1=".$id);
			db_write("UPDATE choose_rooms SET room_2=0 WHERE id=".$parent['id']." AND room_2=".$id);
		}

		return 1;
	}

?>
