<?php
	//ini_set('display_errors', 1); //This is handy for debugging PHP errors.
	include('config.php');
	include('db.php');

	#
	# save changes?
	#

	if ($_POST['done']){

		db_update('choose_settings', array(
			'title'		=> AddSlashes($_POST['title']),
			'root_url'	=> AddSlashes($_POST['root_url']),
			'copyright_text'	=> AddSlashes($_POST['copyright_text']),
                        'copyright_year'         => AddSlashes($_POST['copyright_year']),
                        'copyright_url'         => AddSlashes($_POST['copyright_url']),
                        'main_page_text'         => AddSlashes($_POST['main_page_text']),
                        'warn_box_blurb'         => AddSlashes($_POST['warn_box_blurb']),
                        'new_room_blurb'         => AddSlashes($_POST['new_room_blurb']),
                        'kill_depth'         => AddSlashes($_POST['kill_depth']),
                        'privacy_policy'         => AddSlashes($_POST['privacy_policy']),
                        'enable_adsense'         => AddSlashes($_POST['enable_adsense']),
                        'adsense_blurb'         => AddSlashes($_POST['adsense_blurb']),
                        'enable_recaptcha'         => AddSlashes($_POST['enable_recaptcha']),
                        'recaptcha_public_key'         => AddSlashes($_POST['recaptcha_public_key']),
                        'recaptcha_private_key'         => AddSlashes($_POST['recaptcha_private_key']),
                        'enable_analytics'         => AddSlashes($_POST['enable_analytics']),
                        'analytics_blurb'         => AddSlashes($_POST['analytics_blurb']),
		), "id=1");

		header("location: admin.php?done=1");
		exit;
	}


	#
	# get info for display
	#

	include('header.txt');
?>


<h1>Site Admin</h1>

<div class="godbox">
	<a href="p_routes.php">Story Routes</a> | <a href="p_authors.php">Authors</a> | <a href="purge.php">Purge Problem Rooms</a>
</div>

<?php if ($_GET['done']){ ?>
	<div style="border: 1px solid #000000; padding: 10px; background-color: #eeeeee;">Your changes have been saved.</div>
<?php } ?>


<form action="admin.php" method="post">
<input type="hidden" name="done" value="1" />
	<p>Site Title:<br /><input name="title" type="text" size="50" value="<?= HtmlSpecialChars($settings['title']) ?>"/></p><br />
	<p>Root URL:<br /><input name="root_url" type="text" size="50" value="<?= $settings['root_url'] ?>"/></p><br />
	<p>Copyright Name:<br /><input name="copyright_text" type="text" size="50" value="<?= HtmlSpecialChars($settings['copyright_text']) ?>"/><br />
	<small>This is the <em>Your Name</em> in <strong>&copy; 2012 Your Name</strong> at the bottom of each page.</small></p><br />
	<p>Copyright Year:<br /><input name="copyright_year" type="text" size="50" value="<?= $settings['copyright_year'] ?>"/></p><br />
	<p>Copyright URL:<br /><input name="copyright_url" type="text" size="50" value="<?= $settings['copyright_url'] ?>"/><br />
	<small>This is the URL for the link in the copyright at the bottom of each page.</small></p><br />
	<p>Main Page Text:<br /><textarea name="main_page_text" cols="50" rows="10"><?= $settings['main_page_text'] ?></textarea></p><br />
	<p>Content Warning Text:<br /><textarea name="warn_box_blurb" cols="50" rows="10"><?= $settings['warn_box_blurb'] ?></textarea><br />
	<small>This is the content warning that will display when the user opens the first "room".</small></p><br />
	<p>New Room Text:<br /><textarea name="new_room_blurb" cols="50" rows="10"><?= $settings['new_room_blurb'] ?></textarea><br />
	<small>This is the text at the top of a page when the user reaches the end of an unfinished branch and can add content.</small></p><br />
	<p>Depth Before End:<br /><input name="kill_depth" type="text" size="50" value="<?= HtmlSpecialChars($settings['kill_depth']) ?>"/><br />
	<small>How many levels deep does the story have to go before the option to end the story branch is available?</small></p><br />
	<p>Privacy Policy:<br /><textarea name="privacy_policy" cols="50" rows="10"><?= $settings['privacy_policy'] ?></textarea></p><br />
	<p>Google Adsense:<br /><input name="enable_adsense" type="radio" value="1" checked="checked" /> Enable    <input name="enable_adsense" type="radio" value="0" /> Disable</p><br />
	<p>Adsense Code:<br /><textarea name="adsense_blurb" cols="50" rows="10"><?= $settings['adsense_blurb'] ?></textarea></p><br />
	<p>ReCaptcha:<br /><input name="enable_recaptcha" type="radio" value="1" /> Enable    <input name="enable_recaptcha" type="radio" value="0" checked="checked" /> Disable</p><br />
	<p>ReCaptcha Public Key:<br /><input name="recaptcha_public_key" type="text" size="50" value="<?= HtmlSpecialChars($settings['recaptcha_public_key']) ?>"/></p><br />
	<p>ReCaptcha Private Key:<br /><input name="recaptcha_private_key" type="text" size="50" value="<?= HtmlSpecialChars($settings['recaptcha_private_key'])     ?>"/></p><br />
	<p>Google Analytics:<br /><input name="enable_analytics" type="radio" value="1" /> Enable    <input name="enable_analytics" type="radio" value="0" checked="checked" /> Disable</p><br />
	<p>Analytics Code:<br /><textarea name="analytics_blurb" cols="50" rows="10"><?= $settings['analytics_blurb'] ?></textarea></p><br />
	<p><input type="submit" value="Save Changes" /></p>
</form>

<?php
	include('footer.txt');
?>
