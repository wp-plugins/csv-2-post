<?php c2pf_header();?>       

<?php
// get data arrays before functions are run
$pro = get_option( 'c2pf_pro' );
$spe = get_option( 'c2pf_spe' );
$set = get_option('c2pf_set');
$des = get_option('c2pf_des');

// change current project
if( isset( $_GET['changecurrent'] ) )
{
	$pro['current'] = $_GET['changecurrent'];
	if( update_option( 'c2pf_pro',$pro ) )
	{
		c2pf_mes( 'Current Project Changed','You change the Current Project to '.$pro['current'].', please remember this when working with the plugin.' );
	}
}

// if no current project do not display anything on this page
if( !isset( $pro['current'] ) || isset( $pro['current'] ) && $pro['current'] == 'None Selected' )
{
	c2pf_err( 'No Current Project','You will see errors on this screen after installing the plugin or deleting the "Current Project". 
			The errors are simply because there is no project data created. Please create a project or make an existing project your
			Current Project.' );
	
	$pro['current'] = ' No Current Project ';
}
else
{
	$csv = get_option( 'c2pf_'.$pro['current'] );

	// create folder and save path as csv file directory
	if( isset( $_POST['c2pf_createdirectory_submit'] ) )
	{
		c2pf_createdirectory( $_POST['c2pf_pathname'],$_POST['c2pf_pathdir'] );		
	}

	// creates a single post by default
	if( isset( $_POST['c2pf_testpost_submit'] ) )
	{
		c2pf_createposts( $csv,$pro,$spe,$set,$des,$set['createtest'],true,$pro['current'] );
	}
	
	// runs post creation event based on projects speed profile create integer
	if( isset( $_POST['c2pf_postcreation_submit'] ) )
	{
		c2pf_createposts( $csv,$pro,$spe,$set,$des,$spe[ $pro[$pro['current']]['speed'] ]['create'],true,$pro['current'] );
	}
	
	// pauses a project - only used with projects using spreadout speed profiles
	if( isset( $_POST['c2pf_pauseproject_submit'] ) )
	{
		$pro[ $pro['current'] ]['status'] = 'Paused';
		if( update_option( 'c2pf_pro',$pro ) )
		{
			c2pf_mes( 'Project Paused','Your project will not automatically import data, create posts or update existing posts.' );
		}
		else
		{
			c2pf_err( 'Failed To Pause','Wordpress could not update the options table and pause your project. Please try again then seek support.' );
		}		
	}
	
	// starts/continue a project - only used with projects using spreadout speed profiles
	if( isset( $_POST['c2pf_startproject_submit'] ) )
	{
		// if no records imported, import now otherwise create a post - if a post already created just switch on
		if( $pro[ $pro['current'] ]['rowsinsertsuccess'] == 0 )
		{
			// import data
			c2pf_dataimport( $pro['current'], false, 'import',$set );
			c2pf_mes( 'Project Activating: Data Import','The plugin will begin importing data according to your Speed Profile.' );
		}
		elseif( $pro[ $pro['current'] ]['rowsinsertsuccess'] > 0 && $pro[ $pro['current'] ]['postscreated'] == 0 )
		{
			// create a post
			c2pf_createposts( $csv,$pro,$spe,$set,$des,1,true,$pro['current'] );
			c2pf_mes( 'Project Activating: Post Creation','The plugin created a post, more posts will be created according to your Speed Profile.' );
		}
		
		// changes to $pro happen in the above functions so we must call it again
		$pro = get_option( 'c2pf_pro' );

		$pro[ $pro['current'] ]['status'] = 'Active';
		
		if( update_option( 'c2pf_pro',$pro ) )
		{
			c2pf_mes( 'Project Now Active','The schedule will now run events automatically.' );
		}
		else
		{
			c2pf_err( 'Failed To Start','Wordpress could not update the options table and start your project. Please try again then seek support.' );
		}		
	}
	
	// process data import from csv file to database - 
	if( isset( $_POST['c2pf_datatransfer_submit'] ) )
	{
		// save submitted encoding
		$csv['importencoding'] = $_POST['c2pf_encoding_importencoding'];
		update_option( 'c2pf_' . $pro['current'], $csv );
		
		// change project status to Active
		$pro[ $pro['current'] ]['status'] = 'Active';
		update_option( 'c2pf_pro', $pro );
		
		c2pf_dataimport( $pro['current'],true,'import',$set );
	}
	
	if( isset( $_POST['c2pf_dataupdate_submit'] ) )
	{
		c2pf_dataimport( $pro['current'],true,'update',$set );
	}
	
	// process delete and re-create table request
	if( isset( $_POST['c2pf_deletedata_submit'] ) )
	{
		// delete table
		$result = c2pf_deletetable( $pro['current'] );
		// on delete table success re-create table
		if( $result )
		{
			// create notification as reminder table was deleted
			c2pf_notifications( $pro['current'],'Deleted project table','NA',1 );
			// re-create table
			c2pf_createtable( $pro['current'],$set );
			// reset progress counters
			$pro[$pro['current']]['rowsinsertsuccess'] = 0;
			$pro[$pro['current']]['rowsupdatesuccess'] = 0;
			$pro[$pro['current']]['rowsinsertfail'] = 0;
			$pro[$pro['current']]['rowsupdatefail'] = 0;
			$pro[$pro['current']]['events'] = 0;
			update_option('c2pf_pro',$pro);
		}
	}
	
	// process special functions submit
	if( isset( $_POST['c2pf_specialfunctions_submit'] ) )
	{
		c2pf_savespecials( $pro['current'] );
	}
	
	// processes custom fields form submission
	if( isset( $_POST['c2pf_customfields_submit'] ) )
	{
		c2pf_savecustomfields( $pro['current'] );
	}
	
	// save single category
	if( isset( $_POST['c2pf_singlecategory_submit'] ) )
	{
		c2pf_savesinglecategory( $pro['current'],$_POST['c2pf_category'] );
	}
	
	// save category group
	if( isset( $_POST['c2pf_categorygroupsave_submit'] ) )
	{
		c2pf_savegroupcategory( $pro['current'] );
	}
	
	// create categories outsode of post creation events, all of them
	if( isset( $_POST['c2pf_createcatsnow_submit'] ) )
	{
		c2pf_categoriseearly( $csv,$pro,$spe,$set,$pro['current'],true );
	}

	// process category group delete request - by url only
	if( isset( $_GET['catdel'] ) )
	{
		c2pf_deletecategorygroup( $pro['current'], $_GET['catdel'] );
	}
	
	// saves conditions checkbox form - activates more forms in conditions 
	if( isset( $_POST['c2pf_conditions_submit'] ) )
	{
		c2pf_conditionsswitches( $pro['current'] );
	}
	
	// save value swap condition
	if( isset( $_POST['c2pf_valueswap_submit'] ) )
	{
		c2pf_valueswapsave( $pro['current'],$_POST['c2pf_type'],$_POST['c2pf_oldvalue_submit'],$_POST['c2pf_newvalue_submit'] );
	}
	
	// Save post drop conditions
	if( isset( $_POST['c2pf_postdrop_submit'] ) )
	{
		c2pf_postdropcondition( $pro['current'],$_POST['c2pf_findvalue'],$_POST['c2pf_type'] );
	}  
	
	// save category design conditions
	if( isset( $_POST['c2pf_categorydesign_submit'] ) )
	{
		c2pf_categorydesignsave( $pro['current'] );
	}
	
	// resets update phase so that updates start from first row in csv file
	if( isset( $_POST['c2pf_dataupdatereset_submit'] ) )
	{
		c2pf_setnewupdate( $pro['current'] );
	}
	
	// save update exclusions by individual columns
	if( isset( $_POST['c2pf_columnexclusions_submit'] ) )
	{
		c2pf_columnexclusions( $pro['current'] );
	}
	
	// processes unique key submission
	if( isset( $_POST['c2pf_uniquekey_submit'] ) )
	{				
		c2pf_processuniquekey( $pro['current'], $_POST['c2pf_columnid_1'], $_POST['c2pf_columnid_2'], $_POST['c2pf_columnid_3'] );
	}
	
	// ???
	if( isset( $_POST['c2pf_updatingsettings_submit'] ) )
	{
		c2pf_updatestagesettings( $pro['current'], $_POST['c2pf_updateposts'], $_POST['c2pf_autonewfile'] );
	}
	
	// processes upload of a file meant for overwritting an older version of the file
	if( isset( $_POST['c2pf_uploadnewfile_submit'] ) )
	{
		c2pf_csvuploadupdate( $_FILES['file'] );
	}
			
	// save project options - stage seven
	if( isset( $_POST['c2pf_projectoptions_submit'] ) )
	{
		c2pf_saveprojectoptions( $_POST['c2pf_datemethod'],$_POST['c2pf_type'],$_POST['c2pf_publish'],$_POST['c2pf_comments'],$_POST['c2pf_pings'],$_POST['c2pf_publisher'],$pro['current'],$_POST['c2pf_adopt'],$_POST['c2pf_designmain'] );
	}
	
	// delete all project posts	
	if( isset( $_POST['c2pf_deleteprojectposts_submit'] )  )
	{
		c2pf_deleteprojectposts( $pro,$pro['current'],$csv,$set );
	}
	
	// get data arrays after functions are run
	$pro = get_option('c2pf_pro');
	$spe = get_option('c2pf_spe');
	$csv = get_option( 'c2pf_'.$pro['current'] );
	
	// get projects speed profile type - we need it to offer up or hide features
	$speedtype = $spe[ $pro[ $pro['current'] ]['speed'] ]['type'];
	?>

<div class="wrap">

	<h2>CSV 2 POST Project Configuration For <?php echo $pro['current'];?></h2>
    
	<?php
    c2pf_smallprogresstable( $pro['current'],$pro,$csv,$spe,$set );
    ?>

	<!-- POST BOXES START -->
	<div id="dashboard-widgets-wrap">
		<div id="dashboard-widgets" class="metabox-holder">

			<?php
            // get project progress
            $p = $pro[$pro['current']]['rowsinsertfail'] + $pro[$pro['current']]['rowsinsertsuccess'];// progress includes failed inserts
            $r = c2pf_counttablerecords( $pro['current'] );// get actual records in table
            ?>                  

			<!-- DATA TRANSFER START -->
            <div id="dashboard_recent_comments" class="postbox closed" >
                <div class="handlediv" title="Click to toggle"><br /></div>
                <h3 class='hndle'><span>1. First Data Import ---- CSV Rows: <?php if( isset($csv['format']['rows']) ){ echo $csv['format']['rows']; }?> ---- Progress: <?php echo $p;?> ---- Table Records: <?php echo $r; c2pf_postboxlink( 'http://www.webtechglobal.co.uk/blog/help/eci-tutorial-first-data-import-2','Get Help' );?></span></h3>
				<div class="inside">
                	<?php require_once('includes/c2pf_i_import.php');?>
                </div>
            </div>
			<!-- DATA TRANSFER END -->
            
            <!-- SPECIAL FUNCTIONS START -->
            <?php if( $speedtype != 'blog2blog' ){?>
            <div id="dashboard_recent_comments" class="postbox closed" >
                <div class="handlediv" title="Click to toggle"><br /></div>
                <h3 class='hndle'><span>2. Data Functions ---- Used: <?php echo c2pf_countspecials($pro['current']);?></span></h3>
                <div class="inside">
					<?php 
					if( isset( $pro[$pro['current']]['rowsinsertsuccess'] ) && $pro[$pro['current']]['rowsinsertsuccess'] >= 1 )
					{
						require_once('includes/c2pf_i_specials.php');
					}
					else
					{
						echo '<p><strong>The plugin requires one record to be imported before displaying the Special Functions form. The data will be used to test your
						configuration and generate prevews. Please open part one and import csv rows.</strong></p>';
					}
					?>
                </div>
            </div>
            <?php } ?>
            <!-- SPECIAL FUNCTIONS END -->
            
            <!-- CUSTOM FIELDS START -->
            <?php if( $speedtype != 'blog2blog' ){?>
            <div id="dashboard_recent_comments" class="postbox closed" >
                <div class="handlediv" title="Click to toggle"><br /></div>
                <h3 class='hndle'><span>3. Custom Fields ---- Used: <?php echo c2pf_customfieldsinuse( $pro['current'] );?> <?php c2pf_postboxlink( 'http://www.webtechglobal.co.uk/blog/help/eci-tutorial-custom-fields','Get Help' );?></span></h3>
                <div class="inside">        
                	<?php require_once('includes/c2pf_i_customfields.php');?>
                </div>
            </div>	
            <?php } ?>			
            <!-- CUSTOM FIELDS END -->
                       
			<!-- CATEGORIES START -->  
            <?php if( $speedtype != 'blog2blog' ){?>
            <div id="dashboard_recent_comments" class="postbox closed" >
                <div class="handlediv" title="Click to toggle"><br /></div>
                <h3 class='hndle'><span>4. Categories <?php c2pf_categoriesstatus();?><?php c2pf_postboxlink( 'http://www.webtechglobal.co.uk/blog/help/eci-tutorial-categories','Get Help' );?></span></h3>
                <div class="inside">
                	<?php require_once('includes/c2pf_i_categories.php');?>
                </div>
            </div>
            <?php } ?>
			<!-- CATEGORIES END -->

			<!-- CONDITIONS START -->                       
            <div id="dashboard_recent_comments" class="postbox closed" >
                <div class="handlediv" title="Click to toggle"><br /></div>
                <h3 class='hndle'><span>5. Conditions <?php c2pf_postboxlink( 'http://www.webtechglobal.co.uk/blog/help/eci-tutorial-conditions','Get Help' );?></span></h3>
                <div class="inside">
                	Conditions are provided and customised for you when you hire WebTechGlobal and receive the full edition customised for your needs.
                </div>
            </div>
			<!-- CONDITIONS END --> 
                                  
			<!-- UPDATING START -->    
            <div id="dashboard_recent_comments" class="postbox closed" >
                <div class="handlediv" title="Click to toggle"><br /></div>
                <h3 class='hndle'><span>6. Updating</span></h3>
                <div class="inside">
                Updating are provided and customised for you when you hire WebTechGlobal and receive the full edition customised for your needs.
                </div>
            </div>            
			<!-- UPDATING END -->                       

			<!-- PROJECT OPTIONS START -->
            <div id="dashboard_recent_comments" class="postbox closed" >
                <div class="handlediv" title="Click to toggle"><br /></div>
                <h3 class='hndle'><span>7. Project Options <?php c2pf_postboxlink( 'http://www.webtechglobal.co.uk/blog/help/eci-tutorial-project-options','Get Help' );?></span></h3>
                <div class="inside">
                	<?php require_once('includes/c2pf_i_projectopts.php');?>                    
                </div>
            </div>
			<!-- PROJECT OPTIONS CREATION -->			
            
            <!-- FINAL POST CREATION START -->
            <div id="dashboard_recent_comments" class="postbox closed" >
                <div class="handlediv" title="Click to toggle"><br /></div>
                <h3 class='hndle'><span>8. Post Creation <?php c2pf_postboxlink( 'http://www.webtechglobal.co.uk/blog/help/eci-tutorial-creating-posts','Get Help' );?></span></h3>
                <div class="inside">
                	<?php require_once('includes/c2pf_i_final.php');?>                    
                </div>
            </div>
			<!-- FINAL POST CREATION -->
            
<div class="clear"></div>
</div><!-- dashboard-widgets-wrap -->

</div><!-- wrap -->
<?php
}// end if current project set
?>

<?php c2pf_footer(); ?>