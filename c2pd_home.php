<?php c2pd_header();

// get data arrays
$pro = get_option( 'c2pd_pro' );
?>
<h2>CSV 2 POST Free Edition</h2>
    
	<div id="dashboard-widgets-wrap">
		<div id="dashboard-widgets" class="metabox-holder">
	
			<div id="dashboard_right_now" class="postbox closed" >
			<div class="handlediv" title="Click to toggle"><br /></div>
			<h3>Engineer Notes</h3>
			<div class="inside">
            <p>I put this list together to ensure that I do not forget a single idea that users or myself have come up with.
            If a request is made I always add it to this list. When I'm working on the plugin I make a decision on what
            is priority based on the current status of the plugin and each upgrades level of demand.</p>
            
            <h4>2011 Planned Upgrades</h4>
            <ol>
              <li>Interface Configuration: enhance use of questions and answers system before far more advanced features added</li>
              <li>Ensure reset is being done on importing, when file is newer than the original AND no data exists in project table. User may delete project data to restart. It should reset progress counters but they may not use the plugin to do it. We will double check on the main events, the status of current file data, progress and by which file date the progress belongs too. Review this.</li>
              <li>New File Checking: improve new file checking going by the time delay set in speed profile and the switch set on project Updating settings</li>
              <li>Post Test: provide a button in the test results to visit the post tested and a button to reset the project (delete the post)</li>
              <li>Images: ability to import images to the Wordpress library during importing or as a sub-process to reduce workload</li>
              <li>Tokens &amp; Custom Fields: ability to use a design of tokens for a single meta value</li>
              <li>Publish Date: option for it to be updated during update events, currentlt most users do not want this</li>
              <li>Duplicates: option to delete posts if they are a match and in the trash, will happen during testing</li>
              <li>Options Arrays: use array functions to check for individual values not yet installed, do this during activation</li>
              <li>Have a 24 hour check for records not use and indicate this on project overview, that posts can still be created</li>
              <li>Old Data: option to delete or private posts when their data record is not changed after an update, indicating it is no longer in the csv file. In some cases this indicates that a product is no longer available.</li>
              <li>Ensure all event actions update the projects speed profile action value to track what type of action happened.</li>
              <li>Apply&nbsp;$wpdb-&gt;flush(), establish where it would benifit script speed and clear caches.</li>
              <li>Put date stamp of csv file into data table per record, can be used to search the table for records not updated by new files.</li>
              <li>Count sql insert or update error/fails and prevent looping after 5, allowing some to be shown for debugging but preventing spamming.</li>
              <li>Speed Profiles: we require settings to determine if plugin should allow all action types to happen at once or alternate them</li>
              <li>Posts Created: we need a value for Project Posts Existing and Posts Created, if user deletes any project posts the Posts Created value is not accurate but is required to indicate creation progress.</li>
              <li>If no custom fields were setup at all, don't do any checks for custom&nbsp;fields during post creation or updating.</li>
              <li>Categorising: categorise using condition of giving values within selected column, any column.</li>
              <li>Server: apply maximum time limits with options to ignore it, in all major procedures</li>
              <li>Delete Posts Manually: use do_action() to update project table, new column that indicates row not to be used for any reason. This reason being that user delete the post as it is not required. Option for activating this to be provided.</li>
              <li>Data Functions: more options to generate or import keywords,tags and excerpt for all in one seo etc</li>
            </ol>           
            
             <h4>2011 Considered Upgrades</h4>
             <ol>
               <li>Product Comparison: shortcodes for product comparison table using data from tables (multiple tables if required)</li>
               <li>Create Project: improve the indication of missing directory so that it actually shows which directory is sought</li>
               <li>YouTube: add snippet for embed in posts</li>
               <li>YouTube: provide widget that only requires url data to be imported to table for mass display of YouTubes</li>
              <li>New CSV Files: ability to detect new file for same project even if it has different name i.e. incremented.</li>
              <li>Notifications: option to switch them off</li>
              <li>Snippets: snippet generate needs column matching with standard parts i.e. image,title,alt,name</li>
              <li>Spreadout Speed Profiles: option to delay the start of the campaign</li>
              <li>Error Display: create a url which can disabled error display, not one that can activate it though for security reasons.</li>
              <li>Error Display: create admin message to remind it is active, provide button to hide message and button to disablle error display</li>
              <li>Post Adoption: used if plugin installed on an auto-blog that it never created</li>
              <li>Post Updating: option to switch off Title updating</li>
              <li>Affiliate ID URL: ability to replace giving value with affiliate ID as some providers do not provide the data with it already</li>
              <li>Designs: ability to randomise but the conditions features need hours of work done on them anyway</li>
              <li>File Modification Date: allow the checking of new dates to be switched off</li>
              <li>PEAR: provide option not to use it, one of the possibly more complex changes that helps with some csv files</li>
              <li>Twitter: detect installed twitter plugins and warn user about their activation during post creation etc</li>
              <li>Twitter: tweet new posts, back log them to avoid spamming and automate the tweets on schedule</li>
              <li>Sitemaps: warn user about using XML sitemap plugins while making constant changes to blog</li>
              <li>Ajax Tabs: use ajax tabs for the configuration page</li>
              <li>Project Table: a page for querying project tables, handy for debugging and testing encoding options etc</li>
              <li>Cloaked URL: provide click statistics on home page</li>
              <li>Blog2Blog Plugin Mode: full blog2blog mode will copy the online blogs database so that that the offline blog matches it, can then upload the offline database</li>
              <li>Allow user to change token prepend and appended characters in the event of some sort of conflict.</li>
              <li>Provide ability to set a&nbsp;staggered campaigans end date even if not all records are used.</li>
              <li>Categorising: give an idea of the categories that will be created on the category stage </li>
              <li>Delete Project: allow users to configure exactly what is deleted.</li>
              <li>c2pd_populatemypost_specialfunctions: add the function to post updating but require options to update or not update each part especially post-name</li>
              <li>Categories: allow multiple category groups per post, multiple parents this creates</li>
              <li>Review All In One SEO Function for Post Updating, is it required and how is it best done</li>
              <li>Add ability to trigger post updating when project configuration has been changed in some way that would effect the post.</li>
              <li>Conditions: add mail list feature,ability to notify about new posts fitting specific criteria.</li>
              <li>Disabled Update Services: plugin will automatically disabled or warn user about twitter plugins or update service.</li>
              <li>Shortcode method will build post content before display, based on project settings</li>
              <li>Layout Per Category: layout is decided depending on parent category.</li>
              <li>Open last used stage on project configuration page.</li>
              <li>Review button text, apply a standard format i.e. Save or Submit.</li>
              <li>Make update completion save the last event date for displaying on interface.</li>
              <li>Provide tool to check for duplicate post titles based on users wysiwyg editor title design.</li>
              <li>Provide setting for switching on duplication checking, off by default, encourage pre-check.</li>
              <li>On project post creation box, display list of indicators such as (duplicate title check done,updating setup etc).</li>
            </li>
            </ol>
            <h4>Requested Upgrades</h4>
            <ol>
              <li>
                Allow user to configure what the delete project (c2pd_deleteproject) action does.
              </li>
              <li>eStore: Added eStore product import functionallity, not added at all in 2.0 yet.</li>
              <li>Allow updating csv files to have column changes</li>
              </ol>
            </div>
    </div>
		
   <div id="dashboard-widgets-wrap">
		<div id="dashboard-widgets" class="metabox-holder">
			<div id="dashboard_right_now" class="postbox closed" >
			<div class="handlediv" title="Click to toggle"><br /></div>
			<h3>CSV 2 POST Tutorials</h3>
			<div class="inside">
       			 <object width="600" height="480"><param name="movie" value="http://www.youtube.com/p/9DB47C36EE4D8797?hl=en_GB&fs=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/p/9DB47C36EE4D8797?hl=en_GB&fs=1" type="application/x-shockwave-flash"  width="600" height="480" allowscriptaccess="always" allowfullscreen="true"></embed></object>
            </div>
    </div>

	<div id="dashboard-widgets" class="metabox-holder">
		<div class='postbox-container' style='width:49%;'>
			<div id="normal-sortables" class="meta-box-sortables">
				
                <div id="dashboard_right_now" class="postbox closed" >
					<div class="handlediv" title="Click to toggle"><br /></div>
					<h3 class='hndle'><span>CSV 2 POST Free Edition</span></h3>
					<div class="inside">
                    This free edition has been created to help you locate all the places where you will find information about CSV 2 POST. I plan to add a page for tutorials
                    with the ability to change the size of the video to suit your needs. This plugin can be activated at the same time as the full version allowing users to have
                    the tutorials at hand.
					</div>
				</div>
						
				<div id="dashboard_plugins" class="postbox closed">
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
                
                <div id="dashboard_plugins" class="postbox closed">
					<div class="handlediv" title="Click to toggle"><br /></div>
					<h3 class='hndle'><span>Receive Updates</span></h3>
					<div class="inside">
					The csv2post.com website has an RSS feed that you can subscribe to by <a href="http://www.csv2post.com/feed=rss">clicking here</a>. You can also signup to the sites email newsletter provided by feedburner. Simply enter your email address in this the page <a href="http://feedburner.google.com/fb/a/mailverify?uri=csv2post&amp;loc=en_US">located here</a>.
                    If there is another method you would like to be added here or simply want to suggest one please let me know.
				  	</div>
				</div>
                
			</div>	
		</div>
			
            
			<!-- LEFT COLUMN START -->

<div class='postbox-container' style='width:49%;'>
	<div id="side-sortables" class="meta-box-sortables">
	
		<div id="dashboard_quick_press" class="postbox closed" >
			<div class="handlediv" title="Click to toggle"><br /></div>
			<h3 class='hndle'><span>Test Blogs<span class="postbox-title-action"></span></span></h3>
			<div class="inside">
            	<p>Many test blogs are available and more can be created on request. A standard theme is setup on many but I can set them up with your theme so you can
                do all the testing you need to before buying CSV 2 POST.</p><br />
				<a href="http://www.importcsv.eu/testblog<?php echo rand ( 1,3 );?>/wp-login.php?action=register" title="Visit CSV 2 POST Test Blog">Visit and register on test blog now</a>   
			</div>
		</div>    
    
		<div id="dashboard_quick_press" class="postbox closed" >
			<div class="handlediv" title="Click to toggle"><br /></div>
			<h3 class='hndle'><span>Plugin Website<span class="postbox-title-action"></span></span></h3>
			<div class="inside">
            You can get more information about the plugin by browsing the <a href="http://www.csv2post.com/category/plugin-features">Features List </a>and you can begin the purchase process on the <a href="http://www.csv2post.com">Home Page</a>. </div>
		</div>

		<div id="dashboard_primary" class="postbox closed" >
			<div class="handlediv" title="Click to toggle"><br /></div>
			<h3 class='hndle'><span>Support<span class="postbox-title-action"><a href="/wordpress-testing/eci/wp-admin/index.php?edit=dashboard_primary#dashboard_primary" class="edit-box open-box"></a></span></span></h3>
			<div class="inside">
			  <ul>
			    <li><a href="http://feedburner.google.com/fb/a/mailverify?uri=csv2post&amp;loc=en_US">Subscribe to CSV 2 POST by Email</a></li>
			    <li><a href="http://www.youtube.com/user/csv2post" target="_blank">YouTube Tutorials</a></li>
			    <li><a href="http://forum.csv2post.co.uk/" target="_blank">Forum</a></li>
			    <li><a href="http://twitter.com/csv2post" target="_blank">Twitter</a></li>
			    <li><a href="#">Premium Tutorials</a></li>
			    <li><a href="http://www.csv2post.eu" target="_blank">Blog</a></li>
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


<?php c2pd_footer(); ?>

