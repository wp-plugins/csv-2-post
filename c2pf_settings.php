<?php c2pf_header();?>       

<?php
// get data arrays before processing functions
$pro = get_option('c2pf_pro');
$set = get_option('c2pf_set');

// uninstall plugin options data
if( isset( $_POST['c2pf_uninstallcomplete'] ) )
{
	c2pf_deleteoptionarrays();	
	c2pf_mes( 'Plugin Data Arrays Un-Installed','The plugin deleted its arrays of data from the Wordpress
			options table. To finish the removal of the plugin, please delete it on the Wordpress plugin screen.' );
}

// reinstall plugin options data
if( isset( $_POST['c2pf_reinstall'] ) )
{
	c2pf_deleteoptionarrays();	
	c2pf_install_options();
	c2pf_mes( 'Plugin Data Arrays Re-Installed','Your next step should be configuring the plugins settings
			and the interface to your requirements. Then go to the Project Start page to create a project
			as any previous project data will now be deleted.' );
}

// global post settings
if( isset( $_POST['c2pf_postsettings_submit'] ) )
{
	$set['tagschars'] = $_POST['tagschars'];
	$set['tagsnumeric'] = $_POST['tagsnumeric'];
	$set['tagsexclude'] = $_POST['tagsexclude'];
	$set['excerptlimit'] = $_POST['excerptlimit'];
	
	if( update_option('c2pf_set',$set) )
	{
		c2pf_mes( 'Post Settings Saved','Posts or pages you create from here on will be effected by the new settings.' );
	}
	else
	{
		c2pf_err( 'No Changes Saved','You made no changes to your post/page settings.' );
	}
}

// save encoding settings
if( isset( $_POST['c2pf_encoding_submit'] ) )
{
	$set['titleencoding'] = $_POST['c2pf_encoding_title'];
	$set['contentencoding'] = $_POST['c2pf_encoding_content'];
	$set['categoryencoding'] = $_POST['c2pf_encoding_category'];
	$set['permalinkencoding'] = $_POST['c2pf_encoding_permalink'];
	if( update_option('c2pf_set',$set) )
	{
		c2pf_mes( 'Encoding Saved','Your encoding settings have been saved, it is recommended that you test them before building your blog.' );
	}
	else
	{
		c2pf_err( 'No Changes Saved','No settings were changed so Wordpress did not attempt to make a save.' );
	}
}
	
// testing settings
if( isset( $_POST['c2pf_testing_submit'] ) )
{
	$deb = get_option('c2pf_deb');
	$def = $_POST['debug'];
					  
	if( update_option('c2pf_deb',$def) )
	{
		c2pf_mes( 'Testing Settings Saved','You have made changes to testing settings.' );
	}
	else
	{
		c2pf_err( 'No Changes Made','No settings were changed so no save was required.' );
	}
}	
	
// advanced settings
if( isset( $_POST['c2pf_advanced_submit'] ) )
{
	$set['querylimit'] = $_POST['querylimit'];
	$set['acceptabledrop'] = $_POST['acceptabledrop'];
	$set['createtest'] = $_POST['createtest'];
	$set['log'] = $_POST['log'];
	$set['allowduplicaterecords'] = $_POST['allowduplicaterecords'];
	$set['allowduplicateposts'] = $_POST['allowduplicateposts'];
	$set['editpostsync'] = $_POST['editpostsync'];
					  
	if( update_option('c2pf_set',$set) )
	{
		c2pf_mes( 'Advanced Settings Saved','You have made changes to advanced settings.' );
	}
	else
	{
		c2pf_err( 'No Changes Saved','No settings were changed.' );
	}
}			

// save interface settings
if( isset( $_POST['c2pf_interface_submit'] ) )
{	
	c2pf_err( 'Paid Edition Only','If you hire WebTechGlobal we will install the full edition as part of our service' );
}

// save random date settings
if( isset( $_POST['c2pf_randomdatesettings_submit'] ) )
{
	$set = get_option( 'c2pf_set' );
	$set['rd_yearstart'] = $_POST['c2pf_yearstart'];
	$set['rd_monthstart'] = $_POST['c2pf_monthstart'];
	$set['rd_daystart'] = $_POST['c2pf_daystart'];
	$set['rd_yearend'] = $_POST['c2pf_yearend'];
	$set['rd_monthend'] = $_POST['c2pf_monthend'];
	$set['rd_dayend'] = $_POST['c2pf_dayend'];   
	if( update_option( 'c2pf_settings', $c2p ) )
	{
		c2pf_mes('Random Date Settings Saved','Your settings have been updated.');
	}
	else
	{
		c2pf_err('Random Date Settings Failed','Your submitted settings did not save.');
	}	
}
				
// save incremented date settings				
if( isset( $_POST['c2pf_incrementaldate_submit'] ) && is_user_logged_in() )
{
	$c2p = get_option( 'c2pf_settings' );
	$c2p['settings']['incrementyearstart'] = $_POST['c2pf_incrementyearstart'];
	$c2p['settings']['incrementmonthstart'] = $_POST['c2pf_incrementmonthstart'];
	$c2p['settings']['incrementdaystart'] = $_POST['c2pf_incrementdaystart'];
	$c2p['settings']['incrementstart'] = $_POST['c2pf_incrementstart'];
	$c2p['settings']['incrementend'] = $_POST['c2pf_incrementend'];  
	if( update_option( 'c2pf_settings', $c2p ) )
	{
		c2pf_mes('Incremental Date Settings Saved','Your settings have been updated.');
	}
	else
	{
		c2pf_err('Incremental Date Settings Failed','Your submitted settings did not save.');
	}
}
				
// get data array after processing functions
$pro = get_option('c2pf_pro');
$set = get_option('c2pf_set');
$deb = get_option('c2pf_deb');
?>

<div class="wrap">

	<h2>Plugin Settings</h2>
    
	<!-- POST BOXES START -->
	<div id="dashboard-widgets-wrap">
		<div id="dashboard-widgets" class="metabox-holder">

            <div id="dashboard_recent_comments" class="postbox closed" >
                <div class="handlediv" title="Click to toggle"><br /></div>
                <h3 class='hndle'><span>Interface Configuration</span></h3>
				<div class="inside">
                    <p>These settings allow you to disable or enable features on the interface. If your sure there is something you'll never need to use, it might make 
                    the plugin easier to understand by hiding it.</p>
                    <form method="post" name="c2pf_interface_form" action="">
						<?php 
                        if( isset( $set['aboutpanels'] ) && $set['aboutpanels'] == 1 ){ $ic1 = 'checked="checked"'; }else{ $ic1 = ''; }
                        if( isset( $set['updating'] ) && $set['updating'] == 1 ){ $ic2 = 'checked="checked"'; }else{ $ic2 = ''; }
                        if( isset( $set['scheduling'] ) && $set['scheduling'] == 1 ){ $ic3 = 'checked="checked"'; }else{ $ic3 = ''; }
                        if( isset( $set['allinoneseo'] ) && $set['allinoneseo'] == 1 ){ $ic4 = 'checked="checked"'; }else{ $ic4 = ''; }
                        ?>
                        <table class="widefat post fixed">
                            <tr>
                                <td width="125"><strong>Feature</strong></td><td><strong>Description</strong></td><td><strong>Disable/Enable</strong></td>
            				</tr>                    	
                            <tr>
                                <td>About Panels (full edition only)</td><td>Various panels containing help text and video tutorials.</td><td><input type="checkbox" name="aboutpanels" value="1" <?php echo $ic1; ?> id="1" /></td>
                            </tr>
                            <tr>
                                <td>Updating (full edition only)</td><td>You may hide features and options for data plus post updating.</td><td><input type="checkbox" name="updating" value="1" <?php echo $ic2; ?> id="2" /></td>
                            </tr>
                            <tr>
                                <td>Scheduling (full edition only)</td><td>If all importing and post creation is done manually you don't need scheduling.</td><td><input type="checkbox" name="scheduling" value="1" <?php echo $ic3; ?> id="3" /></td>
                            </tr>
                            <tr>
                                <td>All In One SEO (full edition only)</td><td>Various features and options related to the All In One SEO plugin.</td><td><input type="checkbox" name="allinoneseo" value="1" <?php echo $ic4; ?> id="4" /></td>
                            </tr>
                      </table>
                      <input class="button-primary" type="submit" name="c2pf_interface_submit" value="Save" disabled="disabled" /></td>
                  </form>
                </div>
            </div>

            <div id="dashboard_recent_comments" class="postbox closed" >
                <div class="handlediv" title="Click to toggle"><br /></div>
                <h3 class='hndle'><span>Global Post Settings</span></h3>
				<div class="inside">
					<p>These settings override all project settings and should be used to get the results your entire blog needs.</p>
                                        
                    <form method="post" name="c2pf_postsettings_form" action="">            
                        <table class="widefat post fixed">
                            <tr><td width="100"><b>Setting</b></td><td><b>Description</b></td><td></td></tr>
                            <tr>
                                <td>Tags String Length</td>
                                <td>Restrict the total length of all tags for a single post by number of characters. Good for 
                                keeping in with the design of your theme.</td>
                                <td><input name="tagschars" type="text" value="50" size="3" maxlength="3" disabled="disabled" /></td>
                            </tr>
                            <tr>
                                <td>Tags Numeric</td>
                                <td>You can exclude numeric tags,handy if your automatically generating them</td>
                                <td><select name="tagsnumeric" size="1">
                  					<option value="Exclude" <?php c2pf_selected( $set['tagsnumeric'],'Exclude' ); ?>>Exclude</option>
                 					<option value="Include" <?php c2pf_selected( $set['tagsnumeric'],'Include' ); ?>>Include</option>
                					</select>
                                </td>
                            </tr>
                            <tr>
                                <td>Tags Exclude</td>
                                <td>Comma seperated list of key values to be excluded from being used as tags</td>
                                <td><textarea name="tagsexclude" cols="35" rows="10" wrap="hard" disabled="disabled">what,who,where,when,how,at,a,at,in,end,go,see,over,into</textarea></td>
                            </tr>
                            <tr>
                                <td>Excerpt Length Limit</td>
                                <td>Control the character length of your excerpt</td>
                                <td><input name="excerptlimit" type="text" value="150" size="3" maxlength="3" disabled="disabled" /></td>
                            </tr>
                        </table><br />
                        <input class="button-primary" type="submit" name="c2pf_postsettings_submit" value="Save" /></td>
                    </form>                       
                    
                </div>
            </div>

            <div class="postbox closed">
                <div class="handlediv" title="Click to toggle"><br /></div>
                <h3>Random Publish Date Settings</h3>
                <div class="inside">

                    <form method="post" name="c2pf_randomdatesettings_form" action="">            
                        <p>If you want to use a random publish date on your posts set the date range here. If your month or
                        day only has one digit&nbsp;please enter a zero first i.e. 05,09. Your posts will not be displayed 
                        on your blog in the order of them being created using this method. If you make your start date in the future all your posts will be scheduled
                        for future publish. If your start date is in the past and end date is in the future then only some of your posts will be scheduled.</p>
                        Year Start:<input name="c2pf_yearstart" type="text" value="<?php echo $set['rd_yearstart']; ?>" size="4" maxlength="4" />
                        <br />    		
                        Month Start:<input name="c2pf_monthstart" type="text" value="<?php echo $set['rd_monthstart']; ?>" size="2" maxlength="2" />
                        <br />    		
                        Day Start:<input name="c2pf_daystart" type="text" value="<?php echo $set['rd_daystart']; ?>" size="2" maxlength="2" />
                        <br />    		
                        Year End:<input name="c2pf_yearend" type="text" value="<?php echo $set['rd_yearend']; ?>" size="4" maxlength="4" />
                        <br />    		
                        Month End:<input name="c2pf_monthend" type="text" value="<?php echo $set['rd_monthend']; ?>" size="2" maxlength="2" />
                        <br />    		
                        Day End:<input name="c2pf_dayend" type="text" value="<?php echo $set['rd_dayend']; ?>" size="2" maxlength="2" />
                        <br />   
                        <br />           
                        <input class="button-primary" type="submit" name="c2pf_randomdatesettings_submit" value="Save" />
                    </form>	
                </div>
            </div>
            
            <div class="postbox closed">
                <div class="handlediv" title="Click to toggle"><br /></div>
                <h3>Incremental Publish Date Settings</h3>
                <div class="inside">
                    <form method="post" name="c2pf_incrementaldate_form" action="">            
                        
                        <h4>Start Date</h4>
                        Year Start:<input name="c2pf_incrementyearstart" type="text" value="<?php echo $set['incrementyearstart']; ?>" size="4" maxlength="4" />
                        <br />    		
                        Month Start:<input name="c2pf_incrementmonthstart" type="text" value="<?php echo $set['incrementmonthstart']; ?>" size="2" maxlength="2" />
                        <br />    		
                        Day Start:<input name="c2pf_incrementdaystart" type="text" value="<?php echo $set['incrementdaystart']; ?>" size="2" maxlength="2" />
                        <br /><br />
                        <h4>Increment Random Value</h4>
                        Increment Start:<input name="c2pf_incrementstart" type="text" value="<?php echo $set['incrementstart']; ?>" size="6" maxlength="6" /> least allowed seconds
                        <br />    		
                        Increment End:<input name="c2pf_incrementend" type="text" value="<?php echo $set['incrementend']; ?>" size="6" maxlength="6" /> longest allowed seconds
                        <br />   
                        <br />           
                        <input class="button-primary" type="submit" name="c2pf_incrementaldate_submit" value="Save Incremental Date Settings" />
                    </form>      
                    <br />
                   <br />
                    <h4>Seconds  Guide</h4>
                    <ul>
                      <li><strong>
                      1 Hour:</strong> 3600 </li>
                      <li><strong>3 Hours:</strong> 10800</li>
                      <li><strong>10 Hours:</strong> 36000</li>
                      <li><strong>24 Hours:</strong> 86400</li>
                    </ul>     
                    <br />
                    <h4>Projected Dates (examples based on above settings)</h4>
                    <?php echo c2pf_projecteddates_incremental( $set );?>             
                </div>
            </div>

            <div id="dashboard_recent_comments" class="postbox closed" >
                <div class="handlediv" title="Click to toggle"><br /></div>
                <h3 class='hndle'><span>Encoding</span></h3>
                <div class="inside">
                    <p>You may apply encoding to various parts of your post.</p>
                     
                    <form method="post" name="c2pf_encoding_form" action="">            
                        <table class="widefat post fixed">
                			<tr>
                            	<td>Title Encoding</td>
                                <td>Post/page title encoding, applied once title created</td>
                                <td><?php c2pf_encodingmenu( $set,$set['titleencoding'],'title' );?></td>
                            </tr>
                			<tr>
                            	<td>Content Encoding</td>
                                <td>Encoding is applied to post content once content is prepared</td>
                                <td><?php c2pf_encodingmenu( $set,$set['contentencoding'],'content' );?></td>
                            </tr>
                			<tr>
                            	<td>Category Encoding</td>
                                <td>Applies encoding to blog categories</td>
                                <td><?php c2pf_encodingmenu( $set,$set['categoryencoding'],'category' );?></td>
                            </tr>
                			<tr>
                            	<td>Permalink Encoding</td>
                                <td>Applies encoding to a posts permalink before post is created</td>
                                <td><?php c2pf_encodingmenu( $set,$set['permalinkencoding'],'permalink' );?></td>
                            </tr>
                        </table>
                        <br />
                        <input name="c2pf_encoding_submit" type="submit" value="Save" />
                    </form>              
                </div>
            </div>
            
            <div id="dashboard_recent_comments" class="postbox closed" >
                <div class="handlediv" title="Click to toggle"><br /></div>
                <h3 class='hndle'><span>Advanced Options</span></h3>
                <div class="inside">
                    <p>Some of these default settings are set to values that ensure proper operation on most servers
                    and hosting or simply help to make the plugin easy to use for beginners.</p>

                    <form method="post" name="c2pf_advanced_form" action="">            
                        <table class="widefat post fixed">
                			<tr>
                            	<td>Query Limit</td><td>The query limit applys to some administrational
                                operations within the plugin.</td>
                                <td><input name="querylimit" type="text" value="<?php if( isset( $set['querylimit'] ) ){ echo $set['querylimit']; }?>" size="6" maxlength="6" disabled="disabled"  /></td>
                            </tr>
                			<tr>
                            	<td>Acceptable Drop</td><td>When creating product, if the table already exists, the plugin
                                will simply delete it providing it contains no more than the Acceptable Drop amount.</td>
                                <td><input name="acceptabledrop" type="text" value="10" size="6" maxlength="6" disabled="disabled" /></td>
                            </tr>
                			<tr>
                            	<td>Post Creation Test</td><td>The number of posts to create when you initiate a Post Creation Test.</td>
                                <td><input name="createtest" type="text" value="<?php if( isset( $set['createtest'] ) ){ echo $set['createtest']; }?>" size="6" maxlength="6" disabled="disabled"  /></td>
                            </tr>

                            <tr>
                                <td>Use Log File</td>
                                <td>You can save your automated events and scheduling results to a log file</td>
                                <td><select name="log" size="1">
                  					<option value="Yes" <?php c2pf_selected( $set['log'],'Yes' ); ?>>Yes</option>
                 					<option value="No" <?php c2pf_selected( $set['log'],'No' ); ?>>No</option>
                					</select>
                                </td>
                            </tr>   
                            
                            <tr>
                                <td>Allow Duplicate Data Records</td>
                                <td>Tell the plugin to import rows of data even if they match exactly to existing rows in the project table</td>
                                <td><select name="allowduplicaterecords" size="1">
                  					<option value="Yes" <?php c2pf_selected( $set['allowduplicaterecords'],'Yes' ); ?>>Yes</option>
                 					<option value="No" <?php c2pf_selected( $set['allowduplicaterecords'],'No' ); ?>>No</option>
                					</select>
                                </td>
                            </tr>
                            
                            <tr>
                                <td>Allow Duplicate Posts</td>
                                <td>If your blog requires posts with duplicate titles, you will need to set this to Yes</td>
                                <td><select name="allowduplicateposts" size="1">
                  					<option value="Yes" <?php c2pf_selected( $set['allowduplicateposts'],'Yes' ); ?>>Yes</option>
                 					<option value="No" <?php c2pf_selected( $set['allowduplicateposts'],'No' ); ?>>No</option>
                					</select>
                                </td>
                            </tr>
                                                        
                            <tr>
                                <td>Edit Post Sync (beta, full edition only)</td>
                                <td>Selecting yes will make the plugin update the project database table with manual changes you make 
                                to your posts or pages. This feature still requires much testing before being relied on.</td>
                                <td><select name="editpostsync" size="1">
                  					<option value="Yes" <?php c2pf_selected( $set['editpostsync'],'Yes' ); ?>>Yes</option>
                 					<option value="No" <?php c2pf_selected( $set['editpostsync'],'No' ); ?>>No</option>
                					</select>
                                </td>
                            </tr>
                            
                        </table>
                        <br />
                        <input class="button-primary"  name="c2pf_advanced_submit" type="submit" value="Save" />
                    </form>              
                </div>
            </div>
                        
            <div id="dashboard_recent_comments" class="postbox closed" >
                <div class="handlediv" title="Click to toggle"><br /></div>
                <h3 class='hndle'><span>Testing</span></h3>
                <div class="inside">
                    <p>These may be used by WebTechGlobal should you experiance any problems. Some of the options here will cause
                    more information to be displayed on your dashboard and some will even display errors in public errors. Use
                    with caution.</p>

                    <form method="post" name="c2pf_testing_form" action="">            
                        <table class="widefat post fixed">

                            <tr>
                                <td>Display Errors</td>
                                <td>Wordpress hides most errors and most plugins do have an error, this options displays them all</td>
                                <td><select name="debug" size="1"  disabled="disabled" >
                  					<option value="Yes" <?php c2pf_selected( $deb,'Yes' ); ?>>Yes</option>
                 					<option value="No" <?php c2pf_selected( $deb,'No' ); ?>>No</option>
                					</select>
                                </td>
                            </tr>
                            
                        </table>
                        <br />
                        <input class="button-primary"  name="c2pf_testing_submit" type="submit" value="Save" />
                    </form>              
                </div>
            </div>
                        
            <div id="dashboard_recent_comments" class="postbox closed" >
                <div class="handlediv" title="Click to toggle"><br /></div>
                <h3 class='hndle'><span>Install &amp; Uninstall</span></h3>
				<div class="inside">
					<p>WARNING - the actions these tools perform cannot be reversed. Please take your time and 
                    watch support videos or read Settings Page documentation to make sure you understand.</p>
                    
                    <form method="post" name="c2pf_installuninstall_form" action="">            
                        <table class="widefat post fixed">
                            <tr><td><b>Action</b></td><td><b>Description</b></td></tr>
                            <tr>
                                <td><input class="button-primary" type="submit" name="c2pf_reinstall" value="Re-Install" /></td>
                                <td>Using this button will delete all
                                data arrays associated with the plugin. That includes your project configuration and history. The plugin will then install the original
                                values installed when activating the plugin.
                                </td>
                            </tr>
                            <br />
                            <tr>
                                <td><br />
								<input class="button-primary" type="submit" name="c2pf_uninstall" value="Complete Un-Install" /></td>
                                <td><br />
								Delete all data arrays from the Wordpress options table. Use this if you are removing the plugin and want no trace left
                                in the Wordpress options table.
                                </td>
                            </tr>
                        </table>
                    </form>              
                            
                </div>
            </div>
           
    	<div class="clear"></div>
    </div><!-- dashboard-widgets-wrap -->

</div><!-- wrap -->

<?php c2pf_footer(); ?>