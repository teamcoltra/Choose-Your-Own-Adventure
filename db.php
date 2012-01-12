<?php

$db = mysql_connect($config['db_host'],$config['db_user'],$config['db_pass']);
if (!$db)
{
die('Could not connect: ' . mysql_error(). "\n\nHave you run the install.php script yet?");
}
mysql_select_db($config['db_data'], $db);

//DEBUGGIN
//error_reporting(E_ALL);

function db_single($ret){
  //return $ret['ok'] && count($ret['rows']) ? $ret['rows'][0] : FALSE;
  $row = mysql_fetch_array($ret);
  return $row;
}

function db_query($sql){

	$result = mysql_query($sql);

	if (!$result){
		echo "<hr /><pre>";
		echo "ERROR: ".HtmlSpecialChars(mysql_error())."\n";
		echo "SQL  : ".HtmlSpecialChars($sql)."\n";
		echo "STACK: ".HtmlSpecialChars(db_trace())."\n";
		echo "</pre><hr />\n";
	}

	return $result;
}

function db_update($table, $hash, $where){

	$bits = array();
	foreach(array_keys($hash) as $k){
		$bits[] = "`$k`='$hash[$k]'";
	}

	$result = db_query("UPDATE `$table` SET ".implode(', ',$bits)." WHERE $where");

	return $result;
	}

function db_write($sql){

        $result = mysql_query($sql);

        if (!$result){
                echo "<hr /><pre>";
                echo "ERROR: ".HtmlSpecialChars(mysql_error())."\n";
                echo "SQL  : ".HtmlSpecialChars($sql)."\n";
                echo "STACK: ".HtmlSpecialChars(db_trace())."\n";
                echo "</pre><hr />\n";
        }

        return $result;
}

	function db_insert($table, $hash){

		$fields = array_keys($hash);

		$sql = "INSERT INTO `$table` (`".implode('`,`',$fields)."`) VALUES ('".implode("','",$hash)."')";

		$result = db_query($sql);

		return mysql_insert_id();
	}

?>

