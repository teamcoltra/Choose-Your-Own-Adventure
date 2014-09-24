<?php
	include('config.php');
	include('db.php');


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
<?php
$count = insertRoutes(1, '<tr>'); ?>
</table>
<br>
There are currently <?php echo $count; ?> routes through the story.

<?php
	include('footer.txt');
?>
