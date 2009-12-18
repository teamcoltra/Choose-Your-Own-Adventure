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



	include('header.txt');

	function insertRoutes($id, $data){
		$count = 0;
		$room = db_single(mysql_query("SELECT * FROM choose_rooms WHERE id=$id"));
		if ($room[end_here]){
			print $data."<td bgcolor=\"#ffcccc\"><a href=\"room.php?room=$id\">$id</a></td></tr>";
			$count++;
		}else{
			$data .= "<td bgcolor=\"#eeeeee\"><a href=\"room.php?room=$id\">$id</a></td>";
			if ($room[room_1]){
				$count += insertRoutes($room[room_1],$data);
			}else{
				print $data."<td bgcolor=\"#cccccc\">0a</td></tr>";
				$count++;
			}
			if ($room[room_2]){
				$count += insertRoutes($room[room_2],$data);
			}else{
				print $data."<td bgcolor=\"#cccccc\">0b</td></tr>";
				$count++;
			}
		}
		return $count;
	}

?>

There are quite a few routes through the game. Here they are (read left to right). Light gray is a normal room. Dark gray is an uncompleted story line. Red is an ending.<br>
<br>
<br>
<table cellpadding="4" cellspacing="1" border="0">
<?phpphp $count = insertRoutes(1, '<tr>'); ?>
</table>
<br>
There are currently <?phpphp echo $count; ?> routes through the story.

<?phpphp
	include('footer.txt');
?>
