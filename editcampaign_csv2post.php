<div class="wrap"> 

    <h2>CSV 2 POST Pro Campaign Management <a href="http://www.csv2post.com/blog/instructions/using-campaign-management-in-csv-2-post" target="_blank"><img src="http://www.csv2post.com/images/question_small.png" width="35" height="35" alt="Get help for Campaign Management" /></a></h2>
    <p>Here you can manage your campaigns. Please be aware that deleting a campaign will cause CSV 2 POST to lose control over posts created in that campaign.</p>
    
    <?php
	global $wpdb;

	function csv2post_checkboxstatus1($v)
	{	// echo opposite value to current value
		if($v == 0){echo 1;}else{echo 1;}
	}
	
	function csv2post_checkboxstatus2($v)
	{	// echo checked or don't
		if($v == 0){}else{echo 'checked';}
	}
	
    require('functions/manag_functions.php');
    
    if( isset( $_GET['action'] ) && isset( $_GET['viewcampaign'] ) )
    {
        if($_GET['action'] == 'update')
        {
			if( !isset( $_GET['camid_option'] ) )
			{
				echo '<div id="message" class="updated fade"><p>Failed - Sorry changes could not be saved, please contact info@webtechglobal.co.uk and explain what has happened.</p></div>';
			}
			elseif( isset( $_GET['camid_option'] ) )
			{
				$cam = get_option($_GET['camid_option']);
				$cam['settings']['catparent'];
				$cam['settings']['catchild1'];
				$cam['settings']['catchild2'];
				$cam['settings']['staggeredratio'];
				$cam['settings']['poststatus'];
				$cam['settings']['scheduledhour'];
				$cam['settings']['staggeredratio'];
				$cam['settings']['updatesetting'];
				update_option( $_GET['camid_option'], $cam );				

				echo '<div id="message" class="updated fade"><p>Success - Your campaign category settings have been updated.</p></div>';
			}
		}        
		elseif($_GET['action'] == 'pause')
        {
            $res = csv2post_pausecampaign($_GET['viewcampaign']);
			if(!$res)
			{
				echo '<div id="message" class="updated fade"><p>Failed - Campaign could not be paused, it may be because the import script was busy, please try again.</p></div>';
			}
			else
			{
				echo '<div id="message" class="updated fade"><p>Success - Campaign is now paused.</p></div>';
			}
        }        
		elseif($_GET['action'] == 'reset')
        {			
			$camid = $_GET['viewcampaign'];

			// get all post id's created in the campaign from the post history table
			$postidresults = $wpdb->get_results("SELECT postid FROM " .$wpdb->prefix . "csv2post_posthistory WHERE camid = '$camid'");
			foreach($postidresults as $postid)// loop results and delete them
			{   
				wp_delete_post( $postid->postid, $force_delete = true );// force delete true will not put posts into the trash
			}				
			
			// reset counters stored in campaign options array
			$campaignarray = get_option( $_GET['camid_option'] );	
			$campaignarray['settings']['imported'] = 0;// resets the imported counter to ensure next processing some rows are not skipped
			$campaignarray['settings']['dropped'] = 0;// resets the dropped counter to ensure next processing some rows are not skipped				
			$campaignarray['settings']['phase'] = '1';// ensure not left on update mode, import mode now
			update_option( $_GET['camid_option'], $campaignarray );
			
			echo '<div id="message" class="updated fade"><p>Success - Your campaign has been reset and all posts for the campaign deleted</p></div>';
        }        
        elseif($_GET['action'] == 'start')
        {
            $res = csv2post_startcampaign($_GET['viewcampaign']);		
			if(!$res)
			{
				echo '<div id="message" class="updated fade"><p>Failed - Campaign could not be started at this time, please try again.</p></div>';
			}
			else
			{
				echo '<div id="message" class="updated fade"><p>Success - Campaign has now started</p></div>';
			}
        }        
        elseif($_GET['action'] == 'delete')
        {
            $res = csv2post_deletecampaign($_GET['deleteid']);
			if(!$res)
			{
				echo '<div id="message" class="updated fade"><p>Failed - Campaign could not be deleted at this time please try again.</p></div>';
			}
			else
			{
				echo '<div id="message" class="updated fade"><p>Success - Campaign was deleted.</p></div>';
			}
        }        
      
		if( isset( $_GET['viewcampaign'] ) && is_numeric( $_GET['viewcampaign'] ) && !isset( $_GET['deleteid'] ) )
        { 
            // get all information relating to selected campaign
			$campaignid = $_GET['viewcampaign'];
            $r = $wpdb->get_row("SELECT * FROM " .$wpdb->prefix . "csv2post_campaigns WHERE id = '$campaignid'");
            if($r)
            {
				// get campaign data stored in wp option
				$cam = get_option($r->camid_option);
				$csvprofile = csv2post_getcsvprofile( $cam['settings']['file'] );		
				 
                // dispay retreived information
                echo '<h3>Campaign Management for ' . $cam['settings']['name'] . '</h3>';?>
                
                <?php if (have_posts()) : ?>
				<?php 
					function wtg_extractstrings($start, $end, $original) 
					{
						$original = stristr($original, $start);
						$trimmed = stristr($original, $end);
						return substr($original, strlen($start), -strlen($trimmed));
					}
						
					while (have_posts()) : the_post();?>
            
					<?php 					
                    $imgloc = wtg_extractstrings('src="','" ',$post->post_content)
                    ?> 

					</div>      
                      
            		<div class="galleryimages_wtg">
                        <div class="preview ">
                        <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><img src="<?php echo $imgloc; ?>" alt="<?php the_title(); ?>" class="borderimg" width="150" height="150" /></a>
                        <br />
                        <a href="<?php the_permalink() ?>" class="button" title="<?php the_title(); ?>"><?php the_title(); ?></a> 
                    </div>
				<?php endwhile ?>
                
                	</div>
				</div><!--end:portfolio post-->    
				<div class="navigation">
					<span class="leftalign"><?php next_posts_link('&laquo; Older Entries') ?></span>
					<span class="rightalign"><?php previous_posts_link('Newer Entries &raquo;') ?></span>
				</div>
				<?php endif; ?> 
    			
                <div id="poststuff" class="meta-box-sortables" style="position: relative; margin-top:10px;">
                    <div class="postbox closed">
                        <div class="handlediv" title="Click to toggle"><br /></div>
                            <h3>Main Actions</h3>
            
                                <div class="inside">
                                
                                    <p>
                                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=managecampaigns_csv2post&action=pause&camid_option=<?php echo $cam['settings']['camid_option']; ?>&viewcampaign=<?php echo $_GET['viewcampaign']; ?>" class="form-table">
                                            <input type="hidden" name="action" value="pause" />    
                                            <p class="submit"><input type="submit" class="button-primary" value="Pause Campaign" /></p>
                                        </form>
                                    </p>
                                
                                    <p>
                                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=managecampaigns_csv2post&action=start&camid_option=<?php echo $cam['settings']['camid_option']; ?>&viewcampaign=<?php echo $_GET['viewcampaign']; ?>" class="form-table">
                                            <input type="hidden" name="action" value="start" />    
                                            <p class="submit"><input type="submit" class="button-primary" value="Start Campaign" /></p>
                                        </form>
                                    </p>
                                    
                                    <p>
                                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=managecampaigns_csv2post&action=delete&camid_option=<?php echo $cam['settings']['camid_option']; ?>&viewcampaign=<?php echo $_GET['viewcampaign']; ?>&deleteid=<?php echo $_GET['viewcampaign']; ?>" class="form-table">
                                            <input type="hidden" name="action" value="delete" />    
                                            <p class="submit"><input type="submit" class="button-primary" value="Delete Campaign - Posts Created Are Not Deleted" /></p>
                                        </form>
                                    </p>                                    
                                    
                                    <p>
                                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=managecampaigns_csv2post&action=reset&camid_option=<?php echo $cam['settings']['camid_option']; ?>&viewcampaign=<?php echo $_GET['viewcampaign']; ?>&deleteid=<?php echo $_GET['viewcampaign']; ?>" class="form-table">
                                            <input type="hidden" name="action" value="reset" />    
                                            <p class="submit"><input type="submit" class="button-primary" value="Reset Campaign - Posts Do Not Go To Trash" /></p>
                                        </form>
                                    </p>                                    
                                    
                                </div>
                            </div>    
                        </div>    
                

                
                <div id="poststuff" class="metabox-holder">
                    <div id="post-body">
                        <div id="post-body-content">
                            <div class="postbox closed">
                                <h3 class='hndle'><span>Last 100 Posts Created</span></h3>
                                <div class="inside">
                                <table class="inside">
                                    <p>Campaign Posts displays details about the posts created with the current viewed campaign.</p>
                                    <?php
                                    // get all posts that have this campaign id in their meta data
                                    $query = 'meta_key=csv2post_campaignid&meta_value=' . $_GET['viewcampaign'] . '&posts_per_page=100';
                                    query_posts( $query );
                                    
                                        //The Loop
                                        if ( have_posts() ) : while ( have_posts() ) : the_post();
                    
											$url = get_settings('siteurl');
											$editurl = $url . '/wp-admin/post.php?action=edit&post=' . get_the_ID();
                                            ?>
                                            
                                            <tr>
                                                <td><?php the_ID();?> - </td>
                                                <td><?php  the_title(); ?></td>
                                                <td><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" target="_blank" class="button">View Post</a><br /><br /></td>
                                                <td><a href="<?php echo $editurl; ?>" title="<?php the_title(); ?>" target="_blank" class="button">Edit Post</a><br /><br /></td>
                                            </td>					<?php 
                                            
                                        endwhile; 
                                        else:
                                    endif;
                                    ?>
                                    </table>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
                
                <div id="poststuff" class="metabox-holder">
                    <div id="post-body">
                        <div id="post-body-content">
                            <div class="postbox closed">
                            
                                <h3 class='hndle'><span>Campaign Idenfification</span></h3>
                                <div class="inside">
                                	<p>These are the profile details for the csv file used in this campaign. They cannot be changed unless the csv file changes.</p>
                                    <p><strong><a href="#" title="Automatically generated campaign ID">Plugin Database ID</a>:</strong> <?php echo $r->id;?></p>
                                    <p><strong><a href="#" title="Automatically generated campaign ID">WP Options ID</a>:</strong> <?php echo $cam['settings']['camid_option'];?></p>
                                    <p><strong><a href="#" title="The name you gave your campaign">Name</a>:</strong> <?php echo $cam['settings']['name'];?></p>
                                    <p><strong><a href="#" title="The CSV file your campaign is importing data from">File</a>:</strong> <?php echo $cam['settings']['file'];?></p>
                                    <p><strong><a href="#" title="The number of columns found in your csv file">CSV Columns</a>:</strong> <?php echo $r->csvcolumns;?></p>
                                    <p><strong><a href="#" title="Number of csv rows found in your csv file">CSV Rows</a>:</strong> <?php echo $csvprofile['format']['rows'];?></p>
                                </div>   
                                                  
                            </div>
                        </div>
                    </div>
                </div>

                  <div id="poststuff" class="metabox-holder">
                    <div id="post-body">
                        <div id="post-body-content">
                            <div class="postbox closed">
                            
                                <h3 class='hndle'><span>Campaign Status &amp; Statistics</span></h3>
                                <div class="inside">
                                	<p>This is the campaign information that changes over time and helps you keep track of what the campaign is doing.</p>
                                    <p><strong><a href="#" title="Indicates if your campaign is running, paused, updating etc">Status</a>:</strong> <?php echo csv2post_camman_stage($cam['settings']['stage']);?></p>
                                    <p><strong><a href="#" title="Number of rows imported and used to create new posts">Posts Created</a>:</strong> <?php echo $cam['settings']['imported'];?></p>
                                    <p><strong><a href="#" title="Number of rows CSV 2 POST found unusable and dropped">Rows Dropped</a>:</strong> <?php echo $cam['settings']['dropped'];?></p>
                                    <p><strong><a href="#" title="Number of updates made since the update phase was entered">Updated Posts</a>:</strong> <?php echo $cam['settings']['updated']; ?></p>
                                </div>   
                                                  
                            </div>
                        </div>
                    </div>
                </div>    
                            
                <div id="poststuff" class="metabox-holder">
                    <div id="post-body">
                        <div id="post-body-content">
                            <div class="postbox closed">
                            
                                <h3 class='hndle'><span>Campaign Settings</span></h3>
                                <div class="inside">
                                
                                     <p>Settings to configure your campaign. You can change all but the most technical settings. Settings that cannot be changed will be upgraded soon.</p>
                                     <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=managecampaigns_csv2post&viewcampaign=<?php echo $_GET['viewcampaign']; ?>&action=update">
                                    <table width="653">
                                        <tr>
                                            <td width="161"><strong>Setting Name</strong></td><td width="122"><strong>Info</strong></td><td width="354"><strong>Options</strong></td>
                                        </tr>                                        
                                        <tr>
                                            <td width="161"><a href="#" title="Select column with main category data">Primary Category</a>:</td><td width="122"><?php if($cam['settings']['catparent'] == 999){echo'Not Used';}else{echo $cam['settings']['catparent'];}?></td><td width="354"><?php csv2post_csvcolumnmenu($csvprofile,$cam,$cam['settings']['catparent'],'catparent'); ?></td>
                                        </tr>
                                        <tr>
                                            <td width="161"><a href="#" title="The ID of column used as the main child category data">Sub-Category 1st</a>:</td><td width="122"><?php if($cam['settings']['catchild1'] == 999){echo'Not Used';}else{echo $cam['settings']['catchild1'];}?></td><td width="354"><?php csv2post_csvcolumnmenu($csvprofile,$cam,$cam['settings']['catchild1'],'catchild1'); ?></td>
                                        </tr>
                                        <tr>
                                            <td width="161"><a href="#" title="ID of the csv column used for a 2nd child of categories">Sub-Category 2nd</a>:</td><td width="122"><?php if($cam['settings']['catchild2'] == 999){echo'Not Used';}else{echo $cam['settings']['catchild2'];}?></td><td width="354"><?php csv2post_csvcolumnmenu($csvprofile,$cam,$cam['settings']['catchild2'],'catchild2'); ?></td>
                                        </tr>                                        
                                        <tr>
                                            <td width="161"><a href="#" title="Process method currently in use out of Full, Staggered or Scheduled">Process</a>:</td><td width="122"><?php echo csv2post_camman_process($cam['settings']['process']);?></td><td width="354">Cannot Be Changed</td>
                                        </tr>
                                        <tr>
                                            <td width="161"><a href="#" title="Method being used for creating custom fields for each post">Custom Field Method</a>:</td><td width="122"><?php echo $cam['settings']['customfield'];?></td><td width="354">Cannot Be Changed</td>
                                        </tr>
                                        <tr>
                                            <td width="161"><a href="#" title="When on staggered mode this is the number of posts created for every page visit on your blog!">Hits/Posts Ratio</a>:</td><td width="122">Current:<?php echo $cam['settings']['staggeredratio'];?></td><td width="354"><input name="staggeredratio" value="<?php echo $cam['settings']['staggeredratio'];?>" type="text" size="6" maxlength="6" /></td>
                                        </tr>
                                        <tr>
                                            <td width="161"><a href="#" title="Status of your post once created i.e. Draft, Publish or Pending">Post Status</a>:</td><td width="122">Current:<?php echo $cam['settings']['poststatus'];?></td><td width="354"><?php csv2post_poststatus($cam['settings']['poststatus']); ?></td>
                                        </tr>
                                        <tr>
                                            <td width="161"><a href="#" title="If your using Scheduled processing this will display the number of posts created per hour using CRON">Posts Per Hour (Scheduled Only)</a>:</td><td width="122"><?php if($cam['settings']['scheduledhour'] == 999 || empty($cam['settings']['scheduledhour'])){echo'Not Used';}else{echo $cam['settings']['scheduledhour'];}?></td><td width="354"><input name="scheduledhour" value="<?php echo $cam['settings']['scheduledhour'];?>" type="text" size="6" maxlength="6" /></td>
                                        </tr>
                                        <tr>
                                            <td width="161"><a href="#" title="Allow or Disallow this campaign to enter an automatic update phase once initial data importing is complete.">Update Activation</a>:</td><td width="122"></td><td width="354"> 
                                            <select name="updatesetting" size="1" <?php if(get_option('csv2post_demomode') == 1){echo 'disabled="disabled"';}?>>
                                            <option value="0" <?php if($r->allowupdate == '0'){echo 'selected="selected"';}?>>Disallow Updates</option>
                                            <option value="1" <?php if($r->allowupdate == '1'){echo 'selected="selected"';}?>>Allow Updates</option>
                                          </select></td>
                                        </tr>
                                        <tr>
                                            <td width="161"></td><td width="122"></td><td width="354"></td>
                                        </tr>
                           			
                                    </table>	    
                                    <input type="submit" class="button-primary" value="Save Settings" />
									</form>
                              </div>   
                                                  
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php 
            }
            else
            {
				echo '<div id="message" class="updated fade"><p>Failed To Retrieve Campaign Details!</p></div>';
            }	
        }
    }
    
    $c = $wpdb->get_results("SELECT id,camid_option FROM " .$wpdb->prefix . "csv2post_campaigns");
    
    ?>
    
    <div id="poststuff" class="metabox-holder">
    
        <div id="post-body">
            <div id="post-body-content">
                <div class="postbox">
                
                    <h3 class='hndle'><span>Campaign List</span></h3>
                    <div class="inside">
                    <p>This is a list of all your campaigns. Click on the Manage link to open a campaign.</p>
                    <form>
                        <table width="667">
                            <tr>
                            <td width="56" height="23"><strong>ID</strong></td>
                            <td width="167"><strong>Campaign Name</strong></td>
                            <td width="164"></td>
                            <td width="94"></td>
                            <td width="101"></td>
                            <td width="104"></td>
                            </tr>
                            
							<?php
                            foreach ($c as $v)
                            {
								$cam = get_option($v->camid_option);?>
                   
                            <tr>
                                <td><?php echo $v->id; ?></td>
                                <td><?php echo $cam['settings']['name']; ?></td>
                                <?php csv2post_campaignview_link($v->id,$cam['settings']['name'],$cam['settings']['camid_option']); ?>
                            </tr>
                            
                       		<?php }?>  
                          
                        </table>
                    </form>
                     </div>   
                                      
                </div>
            </div>
        </div>
    </div>
    
</div>        
         
<script type="text/javascript">
// <![CDATA[
jQuery('.postbox div.handlediv').click( function() { jQuery(jQuery(this).parent().get(0)).toggleClass('closed'); } );
jQuery('.postbox h3').click( function() { jQuery(jQuery(this).parent().get(0)).toggleClass('closed'); } );
jQuery('.postbox.close-me').each(function(){
jQuery(this).addClass("closed");
});
//-->
</script>
