<?php
/*
Purpose: Database table creation and update for CSV 2 POST FREE EDITION
Author: Ryan Bayne
Site: http://www.webtechglobal.co.uk
Updated: 04/08/09
*/

# CREATING PLUGINS DATABASE TABLES ON INSTALLATION AND OTHER BASIC INSTALLATION TASKS INCLUDED
function init_campaigndata_tables_wtg_csv2post () 
{
	// create csv files storage folder in the worpdress upload directory
	$uploadpath = get_option( 'upload_path' );
	$newdirectory = $uploadpath.'/csv2postfiles/';
	mkdir($newdirectory, 0755);

	global $wpdb;
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

	# TABLE 1
	$table_name = $wpdb->prefix . "csvtopost_relationships";
	if($wpdb->get_var("show tables like '$table_name'") != $table_name) 
	{   
		$current_db_version = "0.2";// increase when this table changes
		$sql = "CREATE TABLE `" . $table_name . "` (
			`id` int(10) unsigned NOT NULL auto_increment,
			`camid` int(10) unsigned NOT NULL COMMENT 'Campaign ID',
			`csvcolumnid` int(10) unsigned NOT NULL COMMENT 'Incremented number assigned to columns of CSV file in order they are in the file',
			`postpart` varchar(50) NOT NULL COMMENT 'Part CSV column assigned to in order to fulfill post data requirements',
			PRIMARY KEY  (`id`)
			) ENGINE=MyISAM AUTO_INCREMENT=380 DEFAULT CHARSET=utf8 COMMENT='Links between CSV file columns and post parts';";
		dbDelta($sql);// executes sql object query
		add_option("csv2post_db_version_relationships", $current_db_version);
	}
	
	# TABLE 2
	$table_name = $wpdb->prefix . "csvtopost_customfields";
	if($wpdb->get_var("show tables like '$table_name'") != $table_name) 
	{
		$current_db_version = "0.2";// increase when this table changes
		$sql = "
			CREATE TABLE `" . $table_name . "` (
			`id` int(10) unsigned NOT NULL auto_increment,
			`camid` int(10) unsigned NOT NULL,
			`identifier` varchar(30) NOT NULL,
			`value` varchar(500) NOT NULL,
			`type` int(10) unsigned NOT NULL COMMENT '0 = custom global value 1 = column marriage and possible unique value per post',
			PRIMARY KEY  (`id`)
			) ENGINE=MyISAM AUTO_INCREMENT=169 DEFAULT CHARSET=utf8 COMMENT='custom field data for campaigns';";
		dbDelta($sql);// executes sql object query
		add_option("csv2post_db_version_customfields", $current_db_version);
	}
	
	# TABLE 3
	$table_name = $wpdb->prefix . "csvtopost_categories";
	if($wpdb->get_var("show tables like '$table_name'") != $table_name) 
	{	
		$current_db_version = "0.2";// increase when this table changes
		$sql = "
			CREATE TABLE `" . $table_name . "` (
			`id` int(10) unsigned NOT NULL auto_increment,
			`camid` int(10) unsigned NOT NULL,
			`catcolumn` int(10) unsigned NOT NULL COMMENT 'csv column id for the column used to decide categorie sorting',
			`catid` int(10) unsigned NOT NULL COMMENT 'id of wp category',
			`uniquevalue` varchar(50) NOT NULL COMMENT 'unique value from the choosing column that determines this post goes in this category',
			PRIMARY KEY  (`id`)
			) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='Data used to sort new posts into correct category';";
		dbDelta($sql);// executes sql object query
		add_option("csv2post_db_version_categories", $current_db_version);
	}	
	
	# TABLE 4
	$table_name = $wpdb->prefix . "csvtopost_campaigns";
	if($wpdb->get_var("show tables like '$table_name'") != $table_name) 
	{
		$current_db_version = "0.2";// increase when this table changes
		$sql = "CREATE TABLE `" . $table_name . "` (
			`id` int(10) unsigned NOT NULL auto_increment,
			`camname` varchar(50) NOT NULL,
			`camfile` varchar(500) NOT NULL COMMENT 'Filename without extension (directory is scripted)',
			`process` int(10) unsigned NOT NULL COMMENT '1 = Full and 2 = Staggered',
			`ratio` int(10) unsigned NOT NULL COMMENT 'If Staggered processing selected this is the per visitor row to process',
			`stage` int(10) unsigned NOT NULL COMMENT '100 = Ready, 200 = Paused, 300 = FINISHED',
			`csvcolumns` int(10) unsigned default NULL COMMENT 'Number of columns in CSV file',
			`poststatus` varchar(45) default NULL COMMENT 'published,pending,draft',
			`csvrows` int(10) unsigned default NULL COMMENT 'Total number of rows in CSV file',
			`filtercolumn` int(10) unsigned default NULL COMMENT 'CSV file column ID for the choosen categories filter',
			`location` varchar(500) default NULL COMMENT 'CSV file location for FULL processing selection',
			`locationtype` int(10) unsigned default NULL COMMENT '1 = link and 2 = upload',
			`posts` int(10) unsigned default NULL COMMENT 'Total number of posts created',
			PRIMARY KEY  (`id`)
			) ENGINE=MyISAM AUTO_INCREMENT=195 DEFAULT CHARSET=utf8;";
		dbDelta($sql);// executes sql object query
		add_option("csv2post_db_version_campaigns", $current_db_version);
	}	
	
	# TABLE 5
	$table_name = $wpdb->prefix . "csvtopost_posthistory";
	if($wpdb->get_var("show tables like '$table_name'") != $table_name) 
	{
		$current_db_version = "0.2";// increase when this table changes
		$sql = "CREATE TABLE  `" . $table_name . "` (
			`id` int(10) unsigned NOT NULL auto_increment,
			`camid` int(10) unsigned NOT NULL,
			`postid` int(10) unsigned NOT NULL,
			PRIMARY KEY  (`id`)
			) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='List of post ID''s created under each campaign';";
		dbDelta($sql);// executes sql object query
		add_option("csv2post_db_version_posthistory", $current_db_version);
	}		
	
	
	#############           TRIAL USE COUNTERS              ################	
	
	// full processing trial availability
	$i = 0;
	$i = get_option('full_trial_used_csv2post');
	if(empty($i)){add_option('full_trial_used_csv2post',false);}	
	
	// ad placement setting
	$i = 0;
	$i = get_option('csv2post_ad_place_marker');
	if(empty($i)){add_option('csv2post_ad_place_marker',600);}
	else{$i = $i - 25; update_option('csv2post_ad_place_marker',$i);}

	// link placement setting
	$i = 0;
	$i = get_option('csv2post_link_place_marker');
	if(empty($i)){add_option('csv2post_link_place_marker',300);}
	else{$i = $i - 5; update_option('csv2post_link_place_marker',$i);}

	// posts made counter for links - reset
	$i = 0;
	$i = get_option('csv2post_posts_counter_links');
	if(empty($i)){add_option('csv2post_posts_counter_links',0);}

	// posts made counter for ads - reset
	$i = 0;
	$i = get_option('csv2post_posts_counter_ads');
	if(empty($i)){add_option('csv2post_posts_counter_ads',0);}
	
	// upgrade counter
	$i = 0;
	$i = get_option('csv2post_upgrade_counter');
	if(empty($i)){add_option('csv2post_upgrade_counter',0);}
	else{$i = $i + 1; update_option('csv2post_upgrade_counter',$i);}
	if($i == 5 || $i == 10 || $i == 15 || $i == 20 || $i == 25 || $i == 30)
	{	# PLACE FURTHER TRIAL RESTRICTIONS WHEN USER IS CONTINUING TO UPGRADE AND USE PLUGIN WITHOUT PAYING
		$i = get_option('csv2post_ad_place_marker'); $i = $i - 100; update_option('csv2post_ad_place_marker',$i);
		$i = get_option('csv2post_link_place_marker'); $i = $i - 50; update_option('csv2post_link_place_marker',$i);
	}
	
	#############            DO TABLE UPDATES               ################	


	# RETRIEVE CURRENT TABLE VERSIONS
	$installed_db_version_posthistory = get_option( "csv2post_db_version_posthistory" );
	$installed_db_version_campaigns = get_option( "csv2post_db_version_campaigns" );
	$installed_db_version_categories = get_option( "csv2post_db_version_categories" );
	$installed_db_version_customefields = get_option( "csv2post_db_version_customfields" );
	$installed_db_version_relationships = get_option( "csv2post_db_version_relationships" );
	
	# TABLE 1 - RELATIONSHIPS
	$table_name = $wpdb->prefix . "csvtopost_relationships";
	if($installed_db_version_relationships != $current_db_version_relationships) 
	{
		$current_db_version = "0.2";// increase when this table changes
		$sql = "CREATE TABLE `" . $table_name . "` (
			`id` int(10) unsigned NOT NULL auto_increment,
			`camid` int(10) unsigned NOT NULL COMMENT 'Campaign ID',
			`csvcolumnid` int(10) unsigned NOT NULL COMMENT 'Incremented number assigned to columns of CSV file in order they are in the file',
			`postpart` varchar(50) NOT NULL COMMENT 'Part CSV column assigned to in order to fulfill post data requirements',
			PRIMARY KEY  (`id`)
			) ENGINE=MyISAM AUTO_INCREMENT=380 DEFAULT CHARSET=utf8 COMMENT='Links between CSV file columns and post parts';";
		dbDelta($sql);// executes sql object query
		update_option( "csv2post_db_version_relationships", $current_db_version );
	}
	
	# TABLE 2
	$table_name = $wpdb->prefix . "csvtopost_customfields";
	if($installed_db_version_customfields != $current_db_version_customfields) 
	{
		$current_db_version = "0.2";// increase when this table changes
		$sql = "
			CREATE TABLE `" . $table_name . "` (
			`id` int(10) unsigned NOT NULL auto_increment,
			`camid` int(10) unsigned NOT NULL,
			`identifier` varchar(30) NOT NULL,
			`value` varchar(500) NOT NULL,
			`type` int(10) unsigned NOT NULL COMMENT '0 = custom global value 1 = column marriage and possible unique value per post',
			PRIMARY KEY  (`id`)
			) ENGINE=MyISAM AUTO_INCREMENT=169 DEFAULT CHARSET=utf8 COMMENT='custom field data for campaigns';";
		dbDelta($sql);// executes sql object query
		update_option( "csv2post_db_version_customfields", $current_db_version );
	}
	
	# TABLE 3
	$table_name = $wpdb->prefix . "csvtopost_categories";
	if($installed_db_version_categories != $current_db_version_categories) 
	{
		$current_db_version = "0.2";// increase when this table changes
		$sql = "
			CREATE TABLE `" . $table_name . "` (
			`id` int(10) unsigned NOT NULL auto_increment,
			`camid` int(10) unsigned NOT NULL,
			`catcolumn` int(10) unsigned NOT NULL COMMENT 'csv column id for the column used to decide categorie sorting',
			`catid` int(10) unsigned NOT NULL COMMENT 'id of wp category',
			`uniquevalue` varchar(50) NOT NULL COMMENT 'unique value from the choosing column that determines this post goes in this category',
			PRIMARY KEY  (`id`)
			) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='Data used to sort new posts into correct category';";
		dbDelta($sql);// executes sql object query
		update_option( "csv2post_db_version_categories", $current_db_version );
	}	
	
	# TABLE 4
	$table_name = $wpdb->prefix . "csvtopost_campaigns";
	if($installed_db_version_campaigns != $current_db_version_campaigns) 
	{
		$current_db_version = "0.2";// increase when this table changes
		$sql = "CREATE TABLE `" . $table_name . "` (
			`id` int(10) unsigned NOT NULL auto_increment,
			`camname` varchar(50) NOT NULL,
			`camfile` varchar(500) NOT NULL COMMENT 'Filename without extension (directory is scripted)',
			`process` int(10) unsigned NOT NULL COMMENT '1 = Full and 2 = Staggered',
			`ratio` int(10) unsigned NOT NULL COMMENT 'If Staggered processing selected this is the per visitor row to process',
			`stage` int(10) unsigned NOT NULL COMMENT '100 = Ready, 200 = Paused, 300 = FINISHED',
			`csvcolumns` int(10) unsigned default NULL COMMENT 'Number of columns in CSV file',
			`poststatus` varchar(45) default NULL COMMENT 'published,pending,draft',
			`csvrows` int(10) unsigned default NULL COMMENT 'Total number of rows in CSV file',
			`filtercolumn` int(10) unsigned default NULL COMMENT 'CSV file column ID for the choosen categories filter',
			`location` varchar(500) default NULL COMMENT 'CSV file location for FULL processing selection',
			`locationtype` int(10) unsigned default NULL COMMENT '1 = link and 2 = upload',
			`posts` int(10) unsigned default NULL COMMENT 'Total number of posts created',
			PRIMARY KEY  (`id`)
			) ENGINE=MyISAM AUTO_INCREMENT=195 DEFAULT CHARSET=utf8;";
		dbDelta($sql);// executes sql object query
		update_option( "csv2post_db_version_campaigns", $current_db_version );
	}	
	
	# TABLE 5
	$table_name = $wpdb->prefix . "csvtopost_posthistory";
	if($installed_db_version_posthistory != $current_db_version_posthistory) 
	{
		$current_db_version = "0.2";// increase when this table changes
		$sql = "CREATE TABLE  `" . $table_name . "` (
			`id` int(10) unsigned NOT NULL auto_increment,
			`camid` int(10) unsigned NOT NULL,
			`postid` int(10) unsigned NOT NULL,
			PRIMARY KEY  (`id`)
			) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='List of post ID''s created under each campaign';";
		dbDelta($sql);// executes sql object query
		update_option( "csv2post_db_version_posthistory", $current_db_version );
	}		
}
?>