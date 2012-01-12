<?php
	include('header.txt');
?>
<html><head><title>Installer Script</title></head>
<body>
<p>Please make sure that config.php is set to 666 (or 777) permissions as so this file can read and write to it.</p>
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
$table = "INSERT INTO choose_rooms VALUES (1, '$email', 'First Room', 'Choice 1', 0, 'Choice 2', 0, 0, '')";

// Execute query
mysql_query($sql,$con);
mysql_query($table,$con);

//Set up the settings table

$settings_table = "CREATE TABLE `choose_settings` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(128) default NULL,
  `root_url` varchar(128) default NULL,
  `copyright_text` varchar(64) default NULL,
  `copyright_year` int(11) default NULL,
  `copyright_url` varchar(128) default NULL,
  `main_page_text` text,
  `warn_box_blurb` text,
  `new_room_blurb` text,
  `kill_depth` int(11) default NULL,
  `privacy_policy` text,
  `enable_adsense` binary(1) default NULL,
  `adsense_blurb` text,
  `enable_recaptcha` binary(1) default NULL,
  `recaptcha_public_key` varchar(64) default NULL,
  `recaptcha_private_key` varchar(64) default NULL,
  `enable_analytics` binary(1) default NULL,
  `analytics_blurb` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM";

$settings_sql = "INSERT INTO `choose_settings` VALUES (
1,'An Epic Adventure!','','Your Name',2012,
'https://github.com/jeffgeiger/Choose',
'You have stumbled upon my very own \"Choose your own adventure\" tale.\r\n\r\nIt\'s a work in progress, partly because I don\'t have the time to write a whole story from soup to nuts, but mostly because you have the option of expanding it!\r\n',
'This game is not suitable for children. Some story choices contain language and situations that some adults may find offensive. This story is written by visitors to the site, and is largely unmoderated. Please do not use this in the classroom. ',
'Now it\'s time for you to create your own adventure.',
5,'We only want your email address to distinguish your work from others in the back end of the website.  We won\'t sell it, give it away, spam you, or anything else.  Promise.','1',
'<script type=\"text/javascript\"><!--\r\ngoogle_ad_client = \"ca-pub-9002758983777648\";\r\n/* ZombieScraper */\r\ngoogle_ad_slot = \"8575986931\";\r\ngoogle_ad_width = 160;\r\ngoogle_ad_height = 600;\r\n//-->\r\n</script>\r\n<script type=\"text/javascript\"\r\nsrc=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\">\r\n</script>','0','','','0','');";

mysql_query($settings_table,$con);
mysql_query($settings_sql,$con);


mysql_close($con);

$file_to_write = 'config.php';

$content .="<?php\n";
$content .="\$config['name'] = '$name';\n";
$content .="\$config['password'] = '$password';\n";
$content .="\$config['email'] = '$email';\n";
$content .="\$config['db_user'] = '$db_user';\n";
$content .="\$config['db_pass'] = '$db_pass';\n";
$content .="\$config['db_data'] = '$db_data';\n";
$content .="\$config['db_host'] = '$db_host';\n";
$content .="?>";

$fp = fopen($file_to_write, 'w');
fwrite($fp, $content);
fclose($fp);
echo "Success\n";
echo "$file_to_writen";
echo "Has been written";
}
?>
<br />
<h1>Next Steps:</h1>
Create an .htaccess file in your directory to protect your admin and edit pages.  Example:
<div class="boxy">
	<pre>
php_flag register_globals 0
php_flag magic_quotes_gpc 0
php_flag magic_quotes_runtime 0

&lt;Files edit.php&gt;
	AuthType basic
	AuthName "Edit the adventure!!!!"
	AuthUserFile /path/to/your/.htpasswd
	require valid-user
&lt;/Files&gt;

&lt;Files admin.php&gt;
        AuthType basic
        AuthName "Administer the adventure!!!!"
        AuthUserFile /path/to/your/.htpasswd
        require valid-user
&lt;/Files&gt;

	</pre>
</div>
<br />
You can create an .htpasswd file with something like:
<div class="boxy">
        <pre>
		htpasswd -sc .htpasswd jeff	
	</pre>
</div>
<br />
The details of the .htaccess and .htpasswd are left as an exercise to the reader.  Google will show you the way.
<br /><br />
After you're happy with your install, delete or rename the install.php
<br /><br />
Now go configure your site on the <a href="admin.php">Admin Page</a>.
<?php
	include('footer.txt');
?> 
