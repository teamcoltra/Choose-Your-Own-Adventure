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
