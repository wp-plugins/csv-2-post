<?php c2pf_header();
// get data arrays
$pro = get_option( 'c2pf_pro' );
?>
<h2>CSV 2 POST Free Edition</h2>
    
	<div id="dashboard-widgets-wrap">
		<div id="dashboard-widgets" class="metabox-holder">
	
			<div id="dashboard_right_now" class="postbox closed" >
			<div class="handlediv" title="Click to toggle"><br /></div>
			<h3>Engineer Notes</h3>
			<div class="inside">
            <p>This list is used to track suggestions from users and my own ideas. This plugin is aimed at professionals, less interface improvements and more advanced php functions will be
            the priority. Tools aimed at your own clients will also come, such as quickly printed reports of what exactly has been done by the plugin.</p>
            <h4> Priority Upgrades Planned</h4>
            <ol>
              <li>Ensure reset is being done on importing, when file is newer than the original AND no data exists in project table. User may delete project data to restart. It should reset progress counters but they may not use the plugin to do it. We will double check on the main events, the status of current file data, progress and by which file date the progress belongs too. Review this.</li>
              <li>New File Checking: improve new file checking going by the time delay set in speed profile and the switch set on project Updating settings</li>
              <li>Have a 24 hour check for records not use and indicate this on project overview, that posts can still be created</li>
              <li>Ensure all event actions update the projects speed profile action value to track what type of action happened.</li>
              <li>Apply&nbsp;$wpdb-&gt;flush(), establish where it would benifit script speed and clear caches.</li>
              <li>Put date stamp of csv file into data table per record, can be used to search the table for records not updated by new files.</li>
              <li>Count sql insert or update error/fails and prevent looping after 5, allowing some to be shown for debugging but preventing spamming.</li>
              <li>Speed Profiles: we require settings to determine if plugin should allow all action types to happen at once or alternate them</li>
              <li>Posts Created: we need a value for Project Posts Existing and Posts Created, if user deletes any project posts the Posts Created value is not accurate but is required to indicate creation progress.</li>
              <li>If no custom fields were setup at all, don't do any checks for custom&nbsp;fields during post creation or updating.</li>
              <li>Server: apply maximum time limits with options to ignore it, in all major procedures</li>
              <li>Delete Posts Manually: use do_action() to update project table, new column that indicates row not to be used for any reason. This reason being that user delete the post as it is not required. Option for activating this to be provided.</li>
            </ol>           
            
             <h4>Other Upgrades Planned</h4>
             <ol>
               <li>YouTube: add snippet for embed in posts</li>
              <li>New CSV Files: ability to detect new file for same project even if it has different name i.e. incremented.</li>
              <li>Snippets: snippet generate needs column matching with standard parts i.e. image,title,alt,name</li>
              <li>Post Updating: option to switch off Title updating</li>
              <li>Affiliate ID URL: ability to replace giving value with affiliate ID as some providers do not provide the data with it already</li>
              <li>File Modification Date: allow the checking of new dates to be switched off</li>
              <li>Twitter: detect installed twitter plugins and warn user about their activation during post creation etc</li>
              <li>Sitemaps: warn user about using XML sitemap plugins while making constant changes to blog</li>
              <li>Project Table: a page for querying project tables, handy for debugging and testing encoding options etc</li>
              <li>Cloaked URL: provide click statistics on home page</li>
              <li>Provide ability to set a&nbsp;staggered campaigans end date even if not all records are used.</li>
              <li>Categorising: give an idea of the categories that will be created on the category stage and check null value columns</li>
              <li>Delete Project: allow users to configure exactly what is deleted.</li>
              <li>c2pf_populatemypost_specialfunctions: add the function to post updating but require options to update or not update each part especially post-name</li>
              <li>Add ability to trigger post updating when project configuration has been changed in some way that would effect the post.</li>
              <li>Review button text, apply a standard format i.e. Save or Submit.</li>
              <li>Make update completion save the last event date for displaying on interface.</li>
              <li>Provide tool to check for duplicate post titles based on users wysiwyg editor title design.</li>
              <li>Provide setting for switching on duplication checking, off by default, encourage pre-check.</li>
              <li>On project post creation box, display list of indicators such as (duplicate title check done,updating setup etc).</li>
             </ol>
</div>
    </div>
		
        
    
    
<div id="dashboard-widgets" class="metabox-holder">
    <div class='postbox-container' style='width:49%;'>
        <div id="normal-sortables" class="meta-box-sortables">
            <div id="dashboard_right_now" class="postbox" >
            
                <div class="handlediv" title="Click to toggle"><br /></div>
                
                <h3 class='hndle'><span>Current Project Statistics </span></h3>
                <?php
                unset( $pro['current'] );
                
                if( isset( $pro['current'] ) )
                {
                    $postscreated = $pro[ $pro['current'] ]['postscreated'];$postsupdated = $pro[ $pro['current'] ]['postsupdated'];
                    $catscreated = $pro[ $pro['current'] ]['catscreated'];$tagscreated = $pro[ $pro['current'] ]['tagscreated'];
                    $filename = $pro['current'];
                }
                else
                {
                    $postscreated = 0;$postsupdated = 0;$catscreated = 0;$tagscreated = 0;
                    $filename = 'No Current Project';
                }
                ?>
                
                <div class="inside">
                
                    <div class="table table_content">
                        <p class="sub">Generated</p>
                        <table>
                            <tr class="first">
                                <td class="first b b-posts"><a href='edit.php'><?php echo $postscreated; ?></a></td>
                                <td class="t posts"><a href='edit.php'>Posts</a> Created </td>
                            </tr>
                            <tr>
                                <td class="first b b_pages"><a href='edit.php?post_type=page'><?php echo $postsupdated; ?></a></td>
                                <td class="t pages"><a href='edit.php?post_type=page'>Posts</a> Updated</td>
                            </tr>		
                            <tr>
                                <td class="first b b-cats"><a href='edit-tags.php?taxonomy=category'><?php echo $catscreated; ?></a></td>
                                <td class="t cats"><a href='edit-tags.php?taxonomy=category'>Categories Created</a></td>
                            </tr>
                            <tr>
                                <td class="first b b-tags"><a href='edit-tags.php'><?php echo $tagscreated; ?></a></td>
                                <td class="t tags"><a href='edit-tags.php'>Tags Created</a></td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="table table_discussion">
                        <p class="sub">Admin</p>
                        <table>
                            <tr class="first"><td class="b b-comments"><a href="edit-comments.php"><span class="total-count">0</span></a></td>
                            <td class="last t comments"><a href="edit-comments.php">Outdated</a></td>
                            </tr>
                            <tr><td class="b b_approved"><a href='edit-comments.php?comment_status=approved'><span class="approved-count">0</span></a></td>
                            <td class="last t"><a class='approved' href='edit-comments.php?comment_status=approved'>Milestones</a></td>
                            </tr>
                            <tr><td class="b b-waiting"><a href='edit-comments.php?comment_status=moderated'><span class="pending-count">0</span></a></td>
                            <td class="last t"><a class='waiting' href='edit-comments.php?comment_status=moderated'>Duplicates</a></td>
                            </tr>
                            <tr><td class="b b-spam"><a href='edit-comments.php?comment_status=spam'><span class='spam-count'>0</span></a></td>
                            <td class="last t"><a class='spam' href='edit-comments.php?comment_status=spam'>Flagged</a></td>
                            </tr>
                        </table>
                    </div>

                    <div class="versions">
                        <p>Your current project is <span class="b"><a href="#"><?php echo $filename; ?></a></span></p>
                    
                        <br class="clear" />
                    </div>
                </div>
            </div>
                    
            <div id="dashboard_plugins" class="postbox">
                <div class="handlediv" title="Click to toggle"><br /></div>
                <h3 class='hndle'><span>Author</span></h3>
                <div class="inside">
                    <ul>
                      <li><strong>Name:</strong> Ryan Bayne</li>
                      <li><strong>Location:</strong> Scotland</li>
                      <li><strong>Education:</strong> University of Abertay (BSc Web Design)</li>
                      <li> </li>
                  </ul>
              </div>
            </div>
        </div>	
    </div>
        
        <!-- LEFT COLUMN START -->

<div class='postbox-container' style='width:49%;'>
	<div id="side-sortables" class="meta-box-sortables">
	
		<div id="dashboard_quick_press" class="postbox " >
			<div class="handlediv" title="Click to toggle"><br /></div>
			<h3 class='hndle'><span>Plugin News<span class="postbox-title-action"></span></span></h3>
			<div class="inside">
				<script src="http://feeds.feedburner.com/csv2post?format=sigpro" type="text/javascript" ></script><noscript><p>Subscribe to RSS headline updates from: <a href="http://feeds.feedburner.com/csv2post"></a><br/>Powered by FeedBurner</p> </noscript>
			</div>
		</div>

		<div id="dashboard_primary" class="postbox " >
			<div class="handlediv" title="Click to toggle"><br /></div>
			<h3 class='hndle'><span>Support<span class="postbox-title-action"><a href="/wordpress-testing/eci/wp-admin/index.php?edit=dashboard_primary#dashboard_primary" class="edit-box open-box"></a></span></span></h3>
			<div class="inside">
			  <ul>
			    <li><a href="http://forum.webtechglobal.co.uk/viewforum.php?f=2" target="_blank">Forum</a></li>
			    <li><a href="http://twitter.com/csv2post" target="_blank">Twitter</a></li>
			    <li><a href="http://www.csv2post.com/category/blog" target="_blank">Blog</a></li>
			    <li><a href="http://www.webtechglobal.co.uk/blog/wordpress/easy-csv-importer/eci-tutorial-videos" target="_blank">Video Tutorials</a></li>
		      </ul>
		    </div>
		</div>
		
		<div id="dashboard_secondary" class="postbox " >
			<div class="handlediv" title="Click to toggle"><br /></div>
			<h3 class='hndle'><span>Recommended Resources <span class="postbox-title-action"><a href="/wordpress-testing/eci/wp-admin/index.php?edit=dashboard_secondary#dashboard_secondary" class="edit-box open-box"></a></span></span></h3>
			<div class="inside">
			  <ul>
			    <li><a href="http://www.tipsandtricks-hq.com/wordpress-estore-plugin-complete-solution-to-sell-digital-products-from-your-wordpress-blog-securely-1059?ap_id=WebTechGlobal" target="_blank">Shopping Cart</a></li>
			    <li><a href="https://www.e-junkie.com/ecom/gb.php?cl=29717&c=ib&aff=85223" target="_blank">ClassiPress</a></li>
			    <li><a href="http://themeforest.net/?ref=WebTechGlobal" target="_blank">Premium Themes</a></li>
		        <li><a href="http://www.tipsandtricks-hq.com/wordpress-affiliate-platform-plugin-simple-affiliate-program-for-wordpress-blogsite-1474?ap_id=WebTechGlobal" target="_blank">Affiliate Plugin</a>  </li>
			  </ul>
		    </div>
		</div>
				
	</div>	
</div>


<div class='postbox-container' style='display:none;width:49%;'>
<div id="column3-sortables" class="meta-box-sortables"></div>	</div><div class='postbox-container' style='display:none;width:49%;'>

<div id="column4-sortables" class="meta-box-sortables"></div></div></div>


<div class="clear"></div>
</div><!-- dashboard-widgets-wrap -->

</div><!-- wrap -->

<?php c2pf_footer(); ?>

