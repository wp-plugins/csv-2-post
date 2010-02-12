<?php
global $wpdb;

if(get_option('csv2post_debugmode') == 1)
{

}

# GET OPTIONS
$auto_keywords = get_option('csv2post_autokeywords');
$auto_description = get_option('csv2post_autodescription');
$auto_tags = get_option('csv2post_autotags');

// passes post to variables from stage to stage, returning errors where required
require('new_campaign_stages/stage_postto_stage.php');

// prepare opendir for listing layout files
$php_extension = 'php';
$csv_extension = 'csv';

$csvfiles_dir = csv2post_getcsvfilesdir();
$csvfiles_diropen = opendir($csvfiles_dir);

# STAGE 1: SUBMISSION OR FIRST TIME VISIT FOR CAPTURING INITIAL CAMPAIGN SETTINGS
if(!isset($_POST['stage']) || $_POST['stage'] == 1)
{
	if(!empty($_POST['campaignsubmit']))// is stage 1 form submission made?
	{
		require( 'new_campaign_stages/stage1_process.php' );
	}	
	
	if(!isset($stage1complete) || $stage1complete != true)
	{
		require( 'new_campaign_stages/stage1_form.php' );
	}	
}

# STAGE 2: RELATIONSHIPS
if((isset($_POST['stage']) && $_POST['stage'] == 2) || (isset($stage1complete) && $stage1complete == true))
{ 
	// echos errors if stage to stage variables are not set
	require('new_campaign_stages/stage_varto_stage.php');
	
	if(!empty($_POST['matchsubmit']))
	{	
		require( 'new_campaign_stages/stage2_process.php' );
	}
	
	if(!isset($stage2complete) || $stage2complete != true)
	{
		require( 'new_campaign_stages/stage2_form.php' );
	}
}

# STAGE 3 POST STATUS - DISPLAY IF STAGE 2 IS COMPLETE OR STAGE 3 FORM ALREADY SUBMITTED
if((isset($_POST['stage']) && $_POST['stage'] == 3) || (isset($stage2complete) && $stage2complete == true))
{ 
	// echos errors if stage to stage variables are not set
	require( 'new_campaign_stages/stage_varto_stage.php' );

	if(!empty($_POST['statussubmit']))
	{	
		require( 'new_campaign_stages/stage3_process.php' );
	}	
	
	if(!isset($stage3complete) || $stage3complete != true)
	{
		require( 'new_campaign_stages/stage3_form.php' );
	}
}


# STAGE 4 CUSTOM FIELDS - DISPLAY IF STAGE 3 IS COMPLETE OR STAGE 4 FORM ALREADY SUBMITTED
if((isset($_POST['stage']) && $_POST['stage'] == 4) || (isset($stage3complete) && $stage3complete == true))
{ 
	// echos errors if stage to stage variables are not set
	require( 'new_campaign_stages/stage_varto_stage.php' );

	if(!empty($_POST['customfieldssubmit']))
	{		
		require( 'new_campaign_stages/stage4_process.php' );
	}
	
	if(!isset($stage4complete) || $stage4complete != true)
	{
		require( 'new_campaign_stages/stage4_form.php' );
	}
}


# STAGE 5 CATEGORY FILTERING - DISPLAY IF STAGE 4 IS COMPLETE OR STAGE 5 FORM ALREADY SUBMITTED - STAGE 5 IS CATEGORY COLUMN SELECTION
if((isset($_POST['stage']) && $_POST['stage'] == 5) || (isset($stage4complete) && $stage4complete == true))
{ 
	// echos errors if stage to stage variables are not set
	require( 'new_campaign_stages/stage_varto_stage.php' );

	if(!empty($_POST['categoryfiltervalues']))// checks form submission
	{
		require( 'new_campaign_stages/stage5_process.php' );
	}

	if(!isset($stage5complete) || $stage5complete != true)
	{
		require( 'new_campaign_stages/stage5_form.php' );
	}
}

# STAGE 6 - DISPLAY IF STAGE 5 IS COMPLETE OR STAGE 5 FORM ALREADY SUBMITTED
if((isset($_POST['stage']) && $_POST['stage'] == 6) || (isset($stage5complete) && $stage5complete == true))
{ 
	// echos errors if stage to stage variables are not set
	require( 'new_campaign_stages/stage_varto_stage.php' );

	echo '<h2>New Campaign Stage 6 - Campaign Complete!</h2>';
	
	if( $_SESSION['csv2post_edition'] == 'pro' )
	{
		echo '<div id="message" class="updated fade"><p>Success - Your campaign has been created and already started.</p></div>';
	}
	elseif( $_SESSION['csv2post_edition'] == 'free' )
	{
		echo '<div id="message" class="updated fade"><p>Success - Your campaign has been created but this is as far as you can go in the demo edition, please try the full online demo or purchase at www.csv2post.com, thank you for trying CSV 2 POST</p></div>';
	}
	elseif( $_SESSION['csv2post_edition'] == 'demo' )
	{
		echo '<div id="message" class="updated fade"><p>Success - Your campaign has been created and should begin straight away however please ensure other demo users campaign are not running first.</p></div>';
	}
	
	$campaignarray = get_option( $_POST['camid_option'] );
	$campaignarray['settings']['stage'] = 100;
	update_option( $_POST['camid_option'], $campaignarray );
}

$debugmode = get_option('csv2post_debugmode');
if( $debugmode == 1 ){ $wpdb->hide_errors(); }
?>