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



	$ret = mysql_query("SELECT id FROM choose_rooms WHERE end_here=0 AND blurb='' AND room_1=0 AND room_2=0");
	foreach ($ret[rows] as $row){
		$ok = delete_room($row[id]);
		echo $ok?'. ':'x '; flush();
	}

	$ret = mysql_query("SELECT id FROM choose_rooms WHERE end_here=0 AND text_1='' AND room_1=0 AND room_2=0");
	foreach ($ret[rows] as $row){
		$ok = delete_room($row[id]);
		echo $ok?'. ':'x '; flush();
	}

	$ret = mysql_query("SELECT id FROM choose_rooms WHERE end_here=0 AND text_2='' AND room_1=0 AND room_2=0");
	foreach ($ret[rows] as $row){
		$ok = delete_room($row[id]);
		echo $ok?'. ':'x '; flush();
	}

	echo "<br />All done!";



	function delete_room($id){

		$room = db_single(mysql_query("SELECT * FROM choose_rooms WHERE id=$id"));
		$parent	= db_single(mysql_query("SELECT * FROM choose_rooms WHERE room_1=$id OR room_2=$id"));

		if ($room[room_1]) return 0;
		if ($room[room_2]) return 0;

		db_write("DELETE FROM choose_rooms WHERE id=$id");

		if ($parent[id]){
			db_write("UPDATE choose_rooms SET room_1=0 WHERE id=$parent[id] AND room_1=$id");
			db_write("UPDATE choose_rooms SET room_2=0 WHERE id=$parent[id] AND room_2=$id");
		}

		return 1;
	}

?>
