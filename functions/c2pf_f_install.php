<?php
# Plugin Activation Installation Function - Calls Multiple Individual Functions
function c2pf_install_options()
{
	c2pf_install_paths();
	c2pf_install_projects();
	c2pf_install_designs();
	c2pf_install_settings();
	c2pf_install_questions();
	c2pf_install_notification();
	c2pf_install_speeds();
	c2pf_install_debug();
	c2pf_install_snippets();
}

# Deletes All Option Arrays
function c2pf_deleteoptionarrays()
{
	delete_option('c2pf_pat');
	delete_option('c2pf_pro');
	delete_option('c2pf_des');
	delete_option('c2pf_set');
	delete_option('c2pf_que');
	delete_option('c2pf_not');
	delete_option('c2pf_spe');
	delete_option('c2pf_deb');
}

# Debug Switch Installation - true or false value only, no array
function c2pf_install_debug()
{
	add_option('c2pf_deb','No');	
}

# Settings Installation - general plugin settings, global to all projects
function c2pf_install_settings()
{
	$set = array();
	$set['arraydesc'] = 'General and global plugin options';

	// interface settings
	$set['aboutpanels'] = true;// hide or display about panels
	$set['updating'] = true;// hide or display updating features
	$set['scheduling'] = true;// hide or display scheduling
	$set['allinoneseo'] = true;// hide or display all in one seo	

	// global post settings
	$set['tagschars'] = 200;// tags string total characters length
	$set['tagsnumeric'] = true;// tags string total characters length
	$set['tagsexclude'] = 'what,where,who,when,how';// tags to exclude
	$set['excerptlimit'] = 50;// maximum wordpress excerpt size
		
	// encoding settings
	$set['titleencoding'] = 'None';// false or a type of encoding for post title
	$set['contentencoding'] = 'None';// false or a type of encoding for post content
	$set['categoryencoding'] = 'None';// false or a type of encoding for categories
	$set['permalinkencoding'] = 'None';// false or a type of encoding for categories

	// advanced settings
	$set['postupdating'] = 'Yes';// Global setting Yes or No to update posts as they are being viewed
	$set['querylimit'] = 1000;// limit to sql queries used in tools and admin actions
	$set['acceptabledrop'] = 100;// acceptable auto delete limit
	$set['createtest'] = 1;// number of posts to create in test
	$set['log'] = 'Yes';// log file Yes or No
	$set['allowduplicaterecords'] = 'No';// Yes or No	
	$set['allowduplicateposts'] = 'No';// Yes or No	
	$set['editpostsync'] = 'No';// Yes or No	- updates project table with Edit Post changes

	// post date settings
	$set['rd_yearstart'] = 1995;
	$set['rd_monthstart'] = 11;
	$set['rd_daystart'] = 18;
	$set['rd_yearend'] = 2009;
	$set['rd_monthend'] = 10;
	$set['rd_dayend'] = 23;
	$set['incrementyearstart'] = 1998;
	$set['incrementmonthstart'] = 11;
	$set['incrementdaystart'] = 25;
	$set['incrementstart'] = 1000;
	$set['incrementend'] = 3000;		
		
	add_option('c2pf_set',$set);
}

# Installs Paths To CSV File Directories
function c2pf_install_paths()
{
	$pat = array();
	$pat['default']['name'] = 'Default';
	$pat['default']['path'] = C2PCSVFOLDER;
	add_option('c2pf_pat',$pat);
}

# Projects Installation - holds project data
function c2pf_install_projects()
{
	$pro = array();
	$pro['arraydesc'] = 'Holds project progress data';
	add_option('c2pf_pro',$pro);
}

# Designs Installation - holds WYSIWYG designs
function c2pf_install_designs()
{
	$des = array();
	$des['arraydesc'] = 'Holds wysiwyg created html';
	$des['Default']['id'] = time();
	$des['Default']['updated'] = time();
	$des['Default']['title'] = '';
	$des['Default']['content'] = '';
	$des['Default']['shortcodedesign'] = '';
	$des['Default']['seotitle'] = '';
	$des['Default']['seodescription'] = '';
	add_option('c2pf_des',$des);
}

# Questions Installation - questions system is used to capture users needs
function c2pf_install_questions()
{
	$que = array();
	$que['arraydesc'] = 'Interface configuration questions';
	add_option('c2pf_que',$que);
}

# Notification System Installation - notifications update user on any changes
function c2pf_install_notification()
{
	$not = array();
	$not['arraydesc'] = 'Message system';
	$id = time();
	$not[$id]['project'] = 'Admin';
	$not[$id]['message'] = 'Plugin installed';
	$not[$id]['button'] = 'NA';
	$not[$id]['priority'] = 1;// 1:low 2:high 3:urgent
	add_option('c2pf_not',$not);
}

# Event Speed Installation - settings that control project import etc
function c2pf_install_speeds()
{	
	$spe = array();
	$spe['arraydesc'] = 'Pre-configured operation variables which determine the rate of import and post creation';
		
	// events
	$spe['manualevents']['label'] = 'Manual Events';
	$spe['manualevents']['lastevent'] = time();
	$spe['manualevents']['lastaction'] = 'Import';// Import,Update,Create
	$spe['manualevents']['eventdelay'] = 3600;// time to increase eventtime for reschedule
	$spe['manualevents']['create'] = 50;// number of posts/pages/ads to create per event
	$spe['manualevents']['import'] = 250;// number of records to import per event
	$spe['manualevents']['update'] = 100;// number of records to update per event
	$spe['manualevents']['status'] = false;// use to stop all projects using the speed profile - false is paused
	$spe['manualevents']['type'] = 'manualevents';// determines interface requirements
	$spe['manualevents']['filecheckdelay'] = 3600;// check for file datestamp change		
	
	// events
	$spe['manualevents']['label'] = 'TestingSpeed';
	$spe['manualevents']['lastevent'] = time();
	$spe['manualevents']['lastaction'] = 'Import';// Import,Update,Create
	$spe['manualevents']['eventdelay'] = 3600;// time to increase eventtime for reschedule
	$spe['manualevents']['create'] = 5;// number of posts/pages/ads to create per event
	$spe['manualevents']['import'] = 5;// number of records to import per event
	$spe['manualevents']['update'] = 5;// number of records to update per event
	$spe['manualevents']['status'] = false;// use to stop all projects using the speed profile - false is paused
	$spe['manualevents']['type'] = 'manualevents';// determines interface requirements
	$spe['manualevents']['filecheckdelay'] = 3600;// check for file datestamp change
	
	// save the configuration array
	add_option('c2pf_spe',$spe);
}

# Snippets Installation - used to generate html for copying and pasting
function c2pf_install_snippets()
{
	$sni = array();
	$sni['arraydesc'] = 'HTML code for copying and pasting too WYSIWYG editor';
	
	$sni['imagebutton'] = 'Contact WebTechGlobal For Snippet Support';
	
	$sni['image'] = 'Contact WebTechGlobal For Snippet Support';
	
	$sni['link'] = 'Contact WebTechGlobal For Snippet Support';
	
	add_option('c2pf_sni',$sni);
}
?>