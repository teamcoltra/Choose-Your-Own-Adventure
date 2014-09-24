CREATE TABLE choose_rooms (
 id int(11) NOT NULL auto_increment,
 email varchar(255) NOT NULL default '',
 blurb text NOT NULL,
 text_1 varchar(255) NOT NULL default '',
 room_1 int(11) NOT NULL default '0',
 text_2 varchar(255) NOT NULL default '',
 room_2 int(11) NOT NULL default '0',
 end_here tinyint(4) NOT NULL default '0',
 ip varchar(255) NOT NULL default '',
 PRIMARY KEY (id),
) TYPE=MyISAM;

INSERT INTO choose_rooms VALUES (1, 'cal@iamcal.com', 'First Room', 'Choice 1', 0, 'Choice 2', 0, 0, '');

CREATE TABLE `choose_settings` (
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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1

INSERT INTO `choose_settings` VALUES (1,'An Epic Adventure!','','Your Name',2012,'https://github.com/jeffgeiger','You have stumbled upon my very own \"Choose your own adventure\" tale.\r\n\r\nIt\'s a work in progress, partly because I don\'t have the time to write a whole story from soup to nuts, but mostly because you have the option of expanding it!\r\n','This game is not suitable for children. Some story choices contain language and situations that some adults may find offensive. This story is written by visitors to the site, and is largely unmoderated. Please do not use this in the classroom. ','Now it\'s time for you to create your own adventure.',5,'We only want your email address to distinguish your work from others in the back end of the website.  We won\'t sell it, give it away, spam you, or anything else.  Promise.','1','<script type=\"text/javascript\"><!--\r\ngoogle_ad_client = \"ca-pub-9002758983777648\";\r\n/* ZombieScraper */\r\ngoogle_ad_slot = \"8575986931\";\r\ngoogle_ad_width = 160;\r\ngoogle_ad_height = 600;\r\n//-->\r\n</script>\r\n<script type=\"text/javascript\"\r\nsrc=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\">\r\n</script>','0','','','0','');

