<?php
function csv2post_optionsinstallation($state)
{
	// demo mode setting - manually edited by WebTechGlobal for demo blogs only, please ignore
	add_option('csv2post_demomode',0);// 0 = off 1 = on

	// put larger default value into variable first
	$exclusions = "'does','work','description','save','$ave','month!','year!','hundreds','dollars','per','month','year',
	'and','or','but','at','in','on','to','from','is','a','an','am','for','of','the','are','home','much','more',
	'&','every','this','has','been','with','selecting','set','other','thingy','maybe',
	'thats','not','too','them','must-have','youre','can','these','where','will','our','end','all','using','use','your','get',
	'getting','away','you','who','help','helps','any','plus','new','offer','fees','thinking','consider','going','into','where',
	'interested','you'll','that's','fee's','year's','were','had','through','have','made','that','how','his','her','its','&amp;','&','&ndash;','&pos;'";
	
	if($state == 1)// delete options before attempted re-adding them
	{
		delete_option('csv2post_debugmode');// 0 = off 1 = on
		delete_option('csv2post_processingtrigger','shutdown');
		delete_option('csv2post_tagslength');// usually 50-150
		delete_option('csv2post_postsperhit_global');// usually 5-20
		delete_option('csv2post_publisherid');// any number
		delete_option('csv2post_defaultcatparent');// any number
		delete_option('csv2post_maxstagtime');// usually 20-50
		delete_option('csv2post_lastfilename');
		delete_option('csv2post_currentprocess');// indicates processing is ongoing or not	
		delete_option('csv2post_defaultposttype');// post or page
		delete_option('csv2post_defaultping');// post ping on or off
		delete_option('csv2post_defaultcomment');// allow comments or not setting
		delete_option('csv2post_defaultphase');// 0 = auto update start not allow, manual start only and 1 = auto start allowed
		delete_option('csv2post_maxexecutiontime');
		delete_option('csv2post_lastprocessingtime');
		delete_option('csv2post_processingdelay');// length of time forced between processing events
		delete_option('csv2post_stage4fieldscolumns');// number of rows on stage 4 for pairing columns to custom fields
		delete_option('csv2post_lastpointofexecution');// indicates the last known point application reached during processing attempts
		delete_option('csv2post_randomdate_yearstart');// year for random date start
		delete_option('csv2post_randomdate_monthstart');// month for random date start
		delete_option('csv2post_randomdate_daystart');// day for random date start
		delete_option('csv2post_randomdate_yearend');// year for random date end
		delete_option('csv2post_randomdate_monthend');// month for random date end
		delete_option('csv2post_randomdate_dayend');// day for random date end
		delete_option('csv2post_defaultdelimiter');// default deimiter
	}
	
	add_option('csv2post_debugmode',0);// 0 = off 1 = on
	add_option('csv2post_processingtrigger','shutdown');
	add_option('csv2post_tagslength',50);// usually 50-150
	add_option('csv2post_postsperhit_global',3);// usually 5-20
	add_option('csv2post_publisherid',1);// any number
	add_option('csv2post_defaultcatparent','NA');// any number
	add_option('csv2post_maxstagtime',20);// usually 20-50
	add_option('csv2post_lastfilename','None Submitted Yet');
	add_option('csv2post_currentprocess',0);// indicates processing is ongoing or not
	add_option('csv2post_defaultposttype','post');// post or page
	add_option('csv2post_defaultping', 1);// post ping on or off
	add_option('csv2post_defaultcomment', 'open');// post ping on or off
	add_option('csv2post_defaultphase', 1);// 0 = initial import and 1 is update phase
	add_option('csv2post_maxexecutiontime', 20);// the number is in seconds
	add_option('csv2post_lastprocessingtime', time());// used to prevent processing happening too soon
	add_option('csv2post_processingdelay',5);// length of time forced between processing events
	add_option('csv2post_exclusions',$exclusions);// keyword and tag default exclusions
	add_option('csv2post_stage4fieldscolumns',10);// number of rows on stage 4 for pairing columns to custom fields
	add_option('csv2post_lastpointofexecution',0);// indicates the last known point application reached during processing attempts
	add_option('csv2post_randomdate_yearstart',2005);// year for random date start
	add_option('csv2post_randomdate_monthstart',09);// month for random date start
	add_option('csv2post_randomdate_daystart',12);// day for random date start
	add_option('csv2post_randomdate_yearend',2009);// year for random date end
	add_option('csv2post_randomdate_monthend',12);// month for random date end
	add_option('csv2post_randomdate_dayend',10);// day for random date end
	add_option('csv2post_characterencoding','utf8');// indicates what encoding type to use for imported post title and content
	add_option('csv2post_demo',0);// 1 will put demo mode on and 0 is off
	add_option('csv2post_defaultdelimiter',',');// default deimiter
	
	echo '<h3>Options and Settings Installed Successfully<h3>';
}

function csv2post_databaseinstallation($state)
{
	global $wpdb;

	if($state == 1)// delete existing tables before re-adding them
	{
		$result = false;
		
		$table_name = $wpdb->prefix . "csv2post_relationships";
		$sql = "DROP TABLE ". $table_name;
		$result = $wpdb->query($sql);
		
		$table_name = $wpdb->prefix . "csv2post_customfields";
		$sql = "DROP TABLE ". $table_name;
		$result = $wpdb->query($sql);
		
		$table_name = $wpdb->prefix . "csv2post_categories";
		$sql = "DROP TABLE ". $table_name;
		$result = $wpdb->query($sql);

		$table_name = $wpdb->prefix . "csv2post_campaigns";
		$sql = "DROP TABLE ". $table_name;
		$result = $wpdb->query($sql);

		$table_name = $wpdb->prefix . "csv2post_posthistory";
		$sql = "DROP TABLE ". $table_name;
		$result = $wpdb->query($sql);

		$table_name = $wpdb->prefix . "csv2post_layouts";
		$sql = "DROP TABLE ". $table_name;
		$result = $wpdb->query($sql);

		$table_name = $wpdb->prefix . "csv2post_reports";
		$sql = "DROP TABLE ". $table_name;
		$result = $wpdb->query($sql);
	}
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	
	# TABLE 1
	$table_name = $wpdb->prefix . "csv2post_relationships";
	$table1 = "CREATE TABLE `" . $table_name . "` (
		`id` int(10) unsigned NOT NULL auto_increment,
		`camid` int(10) unsigned NOT NULL COMMENT 'Campaign ID',
		`csvcolumnid` int(10) unsigned NOT NULL COMMENT 'Incremented number assigned to columns of CSV file in order they are in the file',
		`postpart` varchar(50) NOT NULL COMMENT 'Part CSV column assigned to in order to fulfill post data requirements',
		PRIMARY KEY  (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Links between CSV file columns and post parts';";		
		
	# TABLE 2
	$table_name = $wpdb->prefix . "csv2post_customfields";
	$table2 = "CREATE TABLE `" . $table_name . "` (
		`id` int(10) unsigned NOT NULL auto_increment,
		`camid` int(10) unsigned NOT NULL,
		`identifier` varchar(30) NOT NULL,
		`value` varchar(500) NOT NULL,
		`type` int(10) unsigned NOT NULL COMMENT '0 = custom global value 1 = column marriage and possible unique value per post',
		PRIMARY KEY  (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='custom field data for campaigns';";
	
	# TABLE 3
	$table_name = $wpdb->prefix . "csv2post_categories";
	$table3 = "CREATE TABLE `" . $table_name . "` (
		`id` int(10) unsigned NOT NULL auto_increment,
		`camid` int(10) unsigned NOT NULL,
		`catcolumn` int(10) unsigned NOT NULL COMMENT 'csv column id for the column used to decide categorie sorting',
		`catid` int(10) unsigned NOT NULL COMMENT 'id of wp category',
		`uniquevalue` varchar(50) NOT NULL COMMENT 'unique value from the choosing column that determines this post goes in this category',
		PRIMARY KEY  (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Data used to sort new posts into correct category';";
	
	# TABLE 4
	$table_name = $wpdb->prefix . "csv2post_campaigns";
	$table4 = "CREATE TABLE `" . $table_name . "` (
		  `id` int(10) unsigned NOT NULL auto_increment,
		  `camname` varchar(50) NOT NULL,
		  `camfile` varchar(500) NOT NULL COMMENT 'Filename without extension (directory is scripted)',
		  `process` int(10) unsigned NOT NULL COMMENT '1 = Full and 2 = Staggered',
		  `ratio` int(10) unsigned NOT NULL default '1' COMMENT 'If Staggered processing selected this is the per visitor row to process',
		  `stage` int(10) unsigned NOT NULL COMMENT '100 = Ready, 200 = Paused, 300 = FINISHED',
		  `csvcolumns` int(10) unsigned default NULL COMMENT 'Number of columns in CSV file',
		  `poststatus` varchar(45) default NULL COMMENT 'published,pending,draft',
		  `filtercolumn` int(10) unsigned default NULL COMMENT 'CSV file column ID for the choosen categories filter',
		  `tagscolumn` int(10) unsigned default '999' COMMENT 'Column ID assigned for making tags with.',
		  `location` varchar(500) default NULL COMMENT 'CSV file location for FULL processing selection',
		  `locationtype` int(10) unsigned default NULL COMMENT '1 = link and 2 = upload',
		  `posts` int(10) unsigned default '0' COMMENT 'Total number of posts created',
		  `layoutfile` varchar(100) default NULL COMMENT 'Layout and post content styling file selected for this campaign',
		  `customfieldsmethod` varchar(50) default NULL COMMENT 'Used during post injection - auto, manual or mixed',
		  `filtermethod` varchar(50) default NULL COMMENT 'Used during category filtering',
		  `keywordcolumn` int(10) unsigned default '999' COMMENT 'Column ID of csv file that will be used to create keywords',
		  `descriptioncolumn` int(10) unsigned default '999' COMMENT 'Column ID of csv file that will be used to create meta description',
		  `delimiter` varchar(3) default NULL,
		  `filtercolumn2` int(10) unsigned default NULL COMMENT 'stage 5 child category option',
		  `filtercolumn3` int(10) unsigned default NULL COMMENT 'stage 5 child of child category option',
		  `defaultcat` int(10) unsigned default NULL,
		  `schedulednumber` int(10) unsigned default '999' COMMENT 'if processing = 3 (scheduled) then this number is the number of posts to be created per day',
		  `csvrows` int(10) unsigned default NULL COMMENT 'number of rows in csv file',
		  `allowupdate` int(10) unsigned default '0' COMMENT '1 = yes and 0 = no',
		  `phase` int(10) unsigned default '1',
		  `randomdate` int(10) unsigned default '0' COMMENT '1 = random date will be applied',
		  `updatedposts` int(10) unsigned default '0' COMMENT 'Number of posts updated in this campaign since the campaign started',
		  `processcounter` int(10) unsigned default '0' COMMENT 'records position and progress of processing on main processing or updating, is reset during phases',
		  `droppedrows` int(10) unsigned default '0' COMMENT 'rows dropped during phase 1',
		  `uniquecolumn` int(10) unsigned default '999',
		  `primaryurlcloak` int(10) unsigned default '0' COMMENT 'Primary url cloak, select on stage 2',
		  `postslugurl` int(10) unsigned default '999' COMMENT 'Indicates column to be used for a custom url aka slug aka post name',
		  `postpublishdate` int(10) unsigned default '999' COMMENT 'Indicates column to use for custom set date',
  		  `camid_option` varchar(45) default NULL COMMENT 'name of the wordpress option holding main campaign data',
		  PRIMARY KEY  (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

	# TABLE 5
	$table_name = $wpdb->prefix . "csv2post_posthistory";
	$table5 = "CREATE TABLE  `" . $table_name . "` (
		`id` int(10) unsigned NOT NULL auto_increment,
		`camid` int(10) unsigned NOT NULL,
		`postid` int(10) unsigned NOT NULL,
		PRIMARY KEY  (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='List of post ID''s created under each campaign';";

	# TABLE 6
	$table_name = $wpdb->prefix . "csv2post_layouts";
	$table6 = "CREATE TABLE  `" . $table_name . "` (
		`id` int(10) unsigned NOT NULL auto_increment,
		`name` varchar(45) default NULL,
		`csvfile` varchar(45) default NULL,
		`code` text COMMENT 'code dump',
		`inuse` int(10) unsigned default NULL COMMENT '0 = no and 1 = yes to being in use by a campaign',
		`wysiwyg_content` text COMMENT 'original worpdress wysiwyg editor content before creating post custom layout',
		`wysiwyg_title` text,
		`type` int(10) unsigned default NULL COMMENT '0 = WYSIWYG Edited 1 = PHP Dump and No WYSIWYG support',
 		`posttitle` varchar(500) default NULL COMMENT 'session code for post title',
  		`updated` datetime default NULL COMMENT 'last update time and date',
		PRIMARY KEY  (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Custom post layouts are stored in database in this table';";

	# TABLE 7
	$table_name = $wpdb->prefix . "csv2post_reports";
	$table7 = "CREATE TABLE  `" . $table_name . "` (
		`id` int(10) unsigned NOT NULL auto_increment,
		`wp_error` varchar(500) default NULL,
		`php_error` varchar(500) default NULL,
		`my_error` varchar(500) default NULL,
		`file` varchar(100) default NULL,
		`line` int(10) unsigned default NULL,
		`query` varchar(5000) default NULL,
		`cam_id` int(10) unsigned default NULL COMMENT 'Campaign ID if it is campaign related, usually is',
		`date` datetime default '0000-00-00 00:00:00',
		`datadump` varchar(5000) default NULL COMMENT 'a dump of any data available that was being used during the time of the error',
		PRIMARY KEY  (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='General campaign and plugin error or status reporting';";

	$result = $wpdb->query($table1);
	$result = $wpdb->query($table2);
	$result = $wpdb->query($table3);
	$result = $wpdb->query($table4);
	$result = $wpdb->query($table5);
	$result = $wpdb->query($table6);
	$result = $wpdb->query($table7);

	// execute update attempt for all tables
	dbDelta($table1);
	dbDelta($table2);
	dbDelta($table3);
	dbDelta($table4);
	dbDelta($table5);
	dbDelta($table6);
	dbDelta($table7);
}
?>



