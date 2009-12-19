<?php
/* #####################################################################
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
	include('header.txt');
?>
<html><head><title>Installer Script 0.0.01 BETA</title></head>
<body>
<p>Please make sure that config.php is set to 666 (or 777) permissions as so this file can read and write to it. :) Thank you!</p>
<form action="" method="post" name="write" id="write">
 Name
 <input name="name" type="text" id="name">
 <br>
 Password
 <input name="password" type="text" id="password">
 <br>
 Email
 <input name="email" type="text" id="email">
 <br>
 Database User
 <input name="db_user" type="text" id="db_user">
 <br>
 Database Password
 <input name="db_pass" type="text" id="db_pass">
 <br>
 Database
 <input name="db_data" type="text" id="db_data">
 <br>
 Host
 <input name="db_host" type="text" id="db_host" value="localhost">
 <br>
 <input type="submit" name="Submit" value="Submit">
</form>
</body></html>
<?php
if ($_POST['Submit']) {

extract($_POST);

$con = mysql_connect($db_host,$db_user,$db_pass);
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }


// Create table
mysql_select_db("$db_data", $con);
$sql = "CREATE TABLE choose_rooms (
 id int(11) NOT NULL auto_increment,
 email varchar(255) NOT NULL default '',
 blurb text NOT NULL,
 text_1 varchar(255) NOT NULL default '',
 room_1 int(11) NOT NULL default '0',
 text_2 varchar(255) NOT NULL default '',
 room_2 int(11) NOT NULL default '0',
 end_here tinyint(4) NOT NULL default '0',
 ip varchar(255) NOT NULL default '',
 PRIMARY KEY (id)
) TYPE=MyISAM";

// Insert into Table
mysql_query("INSERT INTO choose_rooms VALUES (1, '$email', 'First Room', 'Choice 1', 0, 'Choice 2', 0, 0, '')",$con);

// Execute query
mysql_query($sql,$con);

mysql_close($con);

$file_to_write = 'config.php';

$content .="<?phpphp\n";
$content .="\$config['name'] = '$name';\n";
$content .="\$config['password'] = '$password';\n";
$content .="\$config['email'] = '$email';\n";
$content .="\$config['db_user'] = '$db_user';\n";
$content .="\$config['db_pass'] = '$db_pass';\n";
$content .="\$config['db_data'] = '$db_data';\n";
$content .="\$config['db_host'] = '$db_host';\n";
$content .="\$con = mysql_connect('$db_host','$db_user','$db_pass');\n";
$content .="if (!\$con)\n";
$content .="{\n";
$content .="die('Could not connect: ' . mysql_error());\n";
$content .="}\n";
$content .="mysql_select_db(\$config['db_data'], $con);\n";
$content .="?>";

$fp = fopen($file_to_write, 'w');
fwrite($fp, $content);
fclose($fp);
echo "Successn";
echo "$file_to_writen";
echo "Has been written";
}
	include('footer.txt');
?> 
