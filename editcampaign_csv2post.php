<div class="wrap"> 

    <h2>CSV 2 POST Pro Campaign Management <a href="http://www.csv2post.com/blog/instructions/using-campaign-management-in-csv-2-post" target="_blank"><img src="http://www.csv2post.com/images/question_small.png" width="35" height="35" alt="Get help for Campaign Management" /></a></h2>
    <p>Here you can manage your campaigns. Please be aware that deleting a campaign will cause CSV 2 POST to lose control over posts created in that campaign.</p>
    
    <?php
    
    global $wpdb;
    
    require('functions/manag_functions.php');
    if(isset($_GET['settings']) && isset($_GET['id']))
    {
        if($_GET['settings'] == 'updatesave')
        {
            $camid = $_GET['id'];
            
            $allowupdate = $_POST['allowupdate'];
    
            $sqlQuery = "UPDATE " .	$wpdb->prefix . "csv2post_campaigns SET allowupdate = '$allowupdate' WHERE id = '$camid'";
    
            $r = $wpdb->query( $sqlQuery );
            if( !$r )
            {
				echo '<div id="message" class="updated fade"><p>You did not change any settings and so nothing was saved!</p></div>';
            }
            else
            {
				echo '<div id="message" class="updated fade"><p>Success - Your Campaign Update settings were saved!</p></div>';
            }
        }
    }
    
    if(isset($_GET['action']) && isset($_GET['id']))
    {
        $camid = $_GET['id'];
    
        # PROCESS ACTION
        if($_GET['action'] == 'pause')
        {
            echo csv2post_pausecampaign($camid);
        }
        elseif($_GET['action'] == 'start')
        {
            echo csv2post_startcampaign($camid);		
        }
        elseif($_GET['action'] == 'delete')
        {
            echo csv2post_deletecampaign($camid);
        }	
        elseif($_GET['action'] == 'view')
        { 
            // get all information relating to selected campaign
            $r = $wpdb->get_row("SELECT * FROM " .$wpdb->prefix . "csv2post_campaigns WHERE id = '$camid'");
            if($r)
            {
                // dispay retreived information
                echo '<h3>Campaign Management for ' . $r->camname . '</h3>';?>
                
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
                                        $query = 'meta_key=csv2post_campaignid&meta_value=' . $camid . '&posts_per_page=100';
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
                                    <p><strong><a href="#" title="Automatically generated campaign ID">ID</a>:</strong> <?php echo $r->id;?></p>
                                    <p><strong><a href="#" title="The name you gave your campaign">Name</a>:</strong> <?php echo $r->camname;?></p>
                                    <p><strong><a href="#" title="The CSV file your campaign is importing data from">File</a>:</strong> <?php echo $r->camfile;?></p>
                                    <p><strong><a href="#" title="The number of columns found in your csv file">CSV Columns</a>:</strong> <?php echo $r->csvcolumns;?></p>
                                    <p><strong><a href="#" title="Number of csv rows found in your csv file">CSV Rows</a>:</strong> <?php echo $r->csvrows;?></p>
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
                                    <p><strong><a href="#" title="Indicates if your campaign is running, paused, updating etc">Status</a>:</strong> <?php echo csv2post_camman_stage($r->stage);?></p>
                                    <p><strong><a href="#" title="Number of rows imported and used to create new posts">Posts Created</a>:</strong> <?php echo $r->posts;?></p>
                                    <p><strong><a href="#" title="Number of rows CSV 2 POST found unusable and dropped">Rows Dropped</a>:</strong> <?php echo $r->droppedrows;?></p>
                                    <p><strong><a href="#" title="Number of updates made since the update phase was entered">Updated Posts</a>:</strong> <?php echo $r->updatedposts;?></p>
                                    <p></p>
                                </div>   
                                                  
                            </div>
                        </div>
                    </div>
                </div>    
                
                
                  <div id="poststuff" class="metabox-holder">
                    <div id="post-body">
                        <div id="post-body-content">
                            <div class="postbox closed">
                            
                                <h3 class='hndle'><span>Campaign Updating</span></h3>
                                <div class="inside">
                                     <p>You can switch automatic updating on and off with this control. Having it on puts the plugin in a never ending cycle of updating posts.</p>
                                     <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=manage_campaigns_plus&id=<?php echo $camid; ?>&action=view&settings=updatesave">
                                     <a href="#" title="Allow or Disallow this campaign to enter an automatic update phase once initial data importing is complete. Not recommended if your data will never change.">Update Activation</a>:
    <select name="allowupdate" size="1" <?php if(get_option('csv2post_demomode') == 1){echo 'disabled="disabled"';}?>>
                    <option value="0" <?php if($r->allowupdate == '0'){echo 'selected="selected"';}?>>Disallow Updates</option>
                    <option value="1" <?php if($r->allowupdate == '1'){echo 'selected="selected"';}?>>Allow Updates</option>
                  </select>
                                       <br />
                                        <br />
                                        <input type="submit" class="button-primary" value="Save Update Settings" />
                                    </form>
                                    
                                    <?php
                                        if($r->phase == '0')
                                        {
                                            echo '<p>Campaign Updating is not currently ongoing, this campaign may be on its initial import stage</p>';
                                        }
                                        elseif($r->phase == '1')
                                        {
                                            echo '<p>Campaign Updating is currently being performed on your blog</p>';
                                        }
                                    ?>
                                    <p><strong>Updated Posts:</strong> <?php echo $r->updatedposts;?></p>
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
                                	<p>This are the settings that configure your campaign. Many of these settings can be changed but we must always be careful about what we do.</p>
                                    <p><strong><a href="#" title="Process method currently in use out of Full, Staggered or Scheduled">Process</a>:</strong> <?php echo csv2post_camman_process($r->process);?></p>
                                    <p><strong><a href="#" title="If filtering is required this will be the id of the csv file column used for creating the primary categories.">Category Column (Primary)</a>:</strong> <?php if($r->filtercolumn == 999){echo'Not Used';}else{echo $r->filtercolumn;}?></p>
                                    <p><strong><a href="#" title="The ID of column used as the main child category data">Category Column (Sub 1)</a>:</strong> <?php if($r->filtercolumn2 == 999){echo'Not Used';}else{echo $r->filtercolumn2;}?></p>
                                    <p><strong><a href="#" title="ID of the csv column used for a 2nd child of categories">Category Column (Sub 2)</a>:</strong> <?php if($r->filtercolumn3 == 999){echo'Not Used';}else{echo $r->filtercolumn3;}?></p>
                                    <p><strong><a href="#" title="The Custom Post Layout file being used in this campaign">Layout File</a>:</strong> <?php echo $r->layoutfile;?></p>
                                    <p><strong><a href="#" title="Method being used for creating custom fields for each post">Custom Field Method</a>:</strong> <?php echo $r->customfieldsmethod;?></p>
                                    <p><strong><a href="#" title="ID of the csv file column that has the data being used for automatically generating keywords">Keyword Column</a>:</strong> <?php echo $r->keywordcolumn;?></p>
                                    <p><strong><a href="#" title="ID of the column selected for automatically generating the excerpt.">Excerpt Column</a>:</strong> <?php echo $r->descriptioncolumn;?></p>
                                    <p><strong><a href="#" title="ID of the column selected to be used for automatically generating post tags">Tags Column</a>:</strong> <?php echo $r->tagscolumn;?></p>
                                    <p><strong><a href="#" title="The value entered">Delimiter</a>:</strong> <?php echo $r->delimiter;?></p>
                                    <p><strong><a href="#" title="When on staggered mode this is the number of posts created for every page visit on your blog!">Hits/Posts Ratio</a>:</strong> <?php echo $r->ratio;?></p>
                                    <p><strong><a href="#" title="Status of your post once created i.e. Draft, Publish or Pending">Post Status</a>:</strong> <?php echo $r->poststatus;?></p>
                                    <p><strong><a href="#" title="The ID of a column which has a product ID or if book data use ISBN for example">Unique Column</a>:</strong> <?php echo $r->uniquecolumn;?></p>
                                    <p><strong><a href="#" title="ID for the column selected to cloaked">URL Cloaked Column</a>:</strong> <?php echo $r->primaryurlcloak;?></p>
                                    <p><strong><a href="#" title="The ID for a column of date data to be used as post publish dates instead of the default current date and time">Random Date Option</a>:</strong> <?php echo $r->randomdate;?></p>
                                    <p><strong><a href="#" title="If your using Scheduled processing this will display the number of posts created per hour using CRON">Posts Per Hour (Scheduled Only)</a>:</strong> <?php if($r->schedulednumber == 999 || empty($r->schedulednumber)){echo'Not Used';}else{echo $r->schedulednumber;}?></p>
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
    
    $c = $wpdb->get_results("SELECT id,camname,stage FROM " .$wpdb->prefix . "csv2post_campaigns");
    
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
                            {?>
                    
                            <tr>
                                <td><?php echo $v->id; ?></td>
                                <td><?php echo $v->camname; ?></td>
                                <?php csv2post_campaignview($v->camname,$v->id); ?>
                                <?php csv2post_startpausecancelled($v->stage,$v->camname,$v->id); ?>
                                <?php csv2post_campaigndelete($v->id); ?>
                            </tr>
                            
                       		<?php }?>  
                          
                        </table>
                    </form>
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
</div>