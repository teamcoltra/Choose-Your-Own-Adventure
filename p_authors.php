<?php
	include('config.php');
	include('db.php');

	include('header.txt');

	echo "The following people have added pages to the story:<br><br>";

	$ret = mysql_query("SELECT COUNT(id) AS c,email FROM choose_rooms GROUP BY email ORDER BY c DESC");
	while ($row = mysql_fetch_assoc($ret)) {
	/*foreach ($ret['rows'] as $row){*/
		$row['email'] = HtmlSpecialChars($row['email']);
		echo $row['c']." - ".$row['email']."<br>";
	}

	include('footer.txt');
?>
