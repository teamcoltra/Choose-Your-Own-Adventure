<?
	include('config.php');




	if ($_POST[email]){
		setcookie('email_cookie', $_POST[email], time()+(60*60*24*365));
	}

	include('header.txt');


	#
	# get the number of rooms
	#

	list($rooms) = mysql_num_rows(mysql_query("SELECT * FROM choose_rooms",$db)); 
	$insert = "<br /><br /><b>Rooms:</b> ".number_format($rooms);


	#
	# utility function
	#

	function get_room_depth($room_id){

		if ($room_id == 1){return 1;}

		list($parent_room_id) = mysql_num_rows(mysql_query("SELECT id FROM choose_rooms WHERE room_1=$room_id OR room_2=$room_id"));

		if ($parent_room_id){
			return 1 + get_room_depth($parent_room_id);
		}

		return 1;
	}


	#
	# add a new room?
	#

	$problems = array();

	if ($_POST[addroom]){

		if (!strlen(trim($_POST[email]))) $problems[] = "Please enter your email address";
		if (!strlen(trim($_POST[blurb]))) $problems[] = "Please enter your part of the story";

		if (!$_POST[end_here]){
			if (!strlen(trim($_POST[choice1]))) $problems[] = "Please enter the first choice";
			if (!strlen(trim($_POST[choice2]))) $problems[] = "Please enter the second choice";
		}

		if (!count($problems)){

			$ret = db_insert('choose_rooms', array(
				'email'		=> AddSlashes($_POST[email]),
				'blurb'		=> AddSlashes($_POST[blurb]),
				'text_1'	=> AddSlashes($_POST[choice1]),
				'room_1'	=> 0,
				'text_2'	=> AddSlashes($_POST[choice2]),
				'room_2'	=> 0,
				'end_here'	=> AddSlashes($_POST[end_here]),
				'ip'		=> AddSlashes($_SERVER[REMOTE_ADDR]),
			));

			$room_id = $ret[insert_id];

			$opt	= intval($_POST[opt]);
			$from	= intval($_POST[from]);

			db_update('choose_rooms', array(

				"room_$opt" => $room_id,

			), "id=$from AND room_$opt=0");

			print "Your room has been added. <a href=\"room.php\">Click here</a> to start again.";
			include('footer.txt');
			exit;
		}
	}


	#
	# is this a null (insert a link here) room?
	#

	if ($_REQUEST[from] && !$_GET[room]){

		$from_id = intval($_REQUEST[from]);
		$from_room = db_single(mysql_query("SELECT * FROM choose_rooms WHERE id=$from_id"));

		$depth = get_room_depth($from_id);

		$opt = intval($_REQUEST[opt]);

		$email_cookie = HtmlSpecialChars($_COOKIE[email_cookie]);


		if (count($problems)){

			echo "<div class=\"problems\">\n";
			foreach ($problems as $p){
				echo "&raquo; $p<br />\n";
			}
			echo "</div>\n";
			echo "<br />\n";
		}


		print "<!-- $depth -->";
		print "Now it's time for you to create your own adventure :)<br><br>";
		print "What happens when someone chooses &quot;".HtmlSpecialChars($from_room["text_$opt"])."&quot;?<br/>";
		echo "<br />";
		print "<form method=\"post\">";
		print "<input type=\"hidden\" name=\"addroom\" value=\"1\">";
		print "<input type=\"hidden\" name=\"from\" value=\"$from_id\">";
		print "<input type=\"hidden\" name=\"opt\" value=\"$opt\">";
		print "Your email address: (it wont be shown on the site)<br><input type=\"text\" name=\"email\" size=\"50\" value=\"$email_cookie\"><br><br>";
		print "Story description:<br><textarea name=\"blurb\" cols=\"50\" rows=\"10\"></textarea><br><br>";
		if ($depth>19){
			print "<select name=\"end_here\"><option value=\"0\">The adventure continues...</option><option value=\"1\">The adventure ends here</option></select><br><br>";
		}else{
			print "<input type=\"hidden\" name=\"end_here\" value=\"0\">";
		}
		print "Choice 1:<br><input type=\"text\" name=\"choice1\" size=\"50\"><br><br>";
		print "Choice 2:<br><input type=\"text\" name=\"choice2\" size=\"50\"><br><br>";
		print "<input type=\"submit\" value=\"Add My Room!\">";
		include('footer.txt');
		exit;
	}


	#
	# just a regular old choice room
	#

	$room_id = max(intval($_GET[room]), 1);
	$room = db_single(mysql_query("SELECT * FROM choose_rooms WHERE id=$room_id"));

	if (!$room[id]){
		print "error: room $room_id not found";
		include('footer.txt');
		exit;
	}

	$depth = get_room_depth($room_id);


	echo "<!-- depth: $depth -->\n";

	if ($room[id] == 1){
		echo "<div class=\"warnbox\">\n";
		echo "<b>Warning:</b> This game is not suitable for children. Some story choices contain language and situations that some adults may find offensive. ";
		echo "This story is written by visitors to the site, and is largely unmoderated. Please do not use this in the classroom. ";
		echo "</div>\n";
	}

	if ($room[end_here]){
		print nl2br(htmlentities(chop($room[blurb])));
		print "<br><br><b>It's all over.</b> Why not <a href=\"room.php\">start again</a>.";
	}else{
		print defaulty(nl2br(htmlentities(trim($room[blurb]))))."<br />\n";
		echo "<br />\n";
		echo "<b>What will you do?</b><br />\n";
		echo "<div class=\"choices\">\n";
		print "[1] <a href=\"room.php?room=$room[room_1]&from=$room_id&opt=1\">".defaulty(htmlentities($room[text_1]))."</a><br />\n";
		print "[2] <a href=\"room.php?room=$room[room_2]&from=$room_id&opt=2\">".defaulty(htmlentities($room[text_2]))."</a><br />\n";
		echo "</div>\n";
	}
	print "<br><br><br><br>";
	echo "Something wrong with this entry? Bad spelling/grammar? Empty? Makes no sense? Then <a href=\"report.php?id=$room[id]\">report it</a>.<br />";

	if ($_SERVER[PHP_AUTH_USER]){
		echo "<br />";
		echo "<div class=\"godbox\">You're logged in as an admin!";
		echo "[<a href=\"edit.php?id=$room[id]\">edit</a>]";
		echo "</div>";
	}


	function defaulty($x){
		return strlen($x) ? $x : '<i>Blank</i>';
	}

	include('footer.txt');
?>
