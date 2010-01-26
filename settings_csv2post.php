<?php
// get current option values
$debugmode = get_option('csv2post_debugmode');
$processingtrigger = get_option('csv2post_processingtrigger');
$tagslength = get_option('csv2post_tagslength');
$numerictags = get_option('csv2post_numerictags');
$publisherid = get_option('csv2post_publisherid');
$categoryparent = get_option('csv2post_defaultcatparent');
$maxstagtime = get_option('csv2post_maxstagtime');
$defaultposttype = get_option('csv2post_defaultposttype');
$defaultping = get_option('csv2post_defaultping');
$commentstatus = get_option('csv2post_defaultcomment');
$defaultphase =	get_option('csv2post_defaultphase');
$tooltips = get_option('csv2post_tooltipsonoff');
$csv2post_maxexecutiontime = get_option('csv2post_maxexecutiontime');

function csv2post_checkboxstatus1($v)
{	// echo opposite value to current value
	if($v == 0){echo 1;}else{echo 1;}
}

function csv2post_checkboxstatus2($v)
{	// echo checked or don't
	if($v == 0){}else{echo 'checked';}
}

// array for displaying list of usernames
$usernames = array(
    'orderby'          => 'display_name',
    'order'            => 'ASC',
    'multi'            => 0,
    'show'             => 'display_name',
    'echo'             => 1,
    'name'             => 'csv2post_publisherid');

?>


<div class="wrap">
    <h2>CSV 2 POST Settings <?php if(get_option('csv2post_demomode') == 1){echo 'Disabled In Demo Mode';}?> <a href="http://www.csv2post.com/blog/instructions/using-csv-2-post-settings-page" target="_blank"><img src="http://www.csv2post.com/images/question_small.png" width="35" height="35" alt="Get help for Settings page" /></a></h2>
 
    <form method="post" action="options.php" class="form-table">
    
    <?php wp_nonce_field('update-options'); ?>
   
    <div id="poststuff" class="meta-box-sortables" style="position: relative; margin-top:10px;">
        <div class="postbox closed">
            <div class="handlediv" title="Click to toggle"><br /></div>
             <h3>Plugin Setup Options</h3>
                <div class="inside">
                    <p>
                        <a href="#" title="Activating debugging mode will make wordpress display all errors and write processing information to text file when running campaigns">Debugging Mode</a>:
                        <input name="csv2post_debugmode" type="checkbox" value="<?php csv2post_checkboxstatus1($debugmode); ?>" 
                        <?php csv2post_checkboxstatus2($debugmode); ?> />- Will cause the display of errors from other plugins!
                    </p>
                    <p>
                    	<a href="#" title="Cannot be undone using this interface! It will disable functions in CSV 2 POST for using the plugin on a public demo, perfect for affiliates.">Activate Demo Mode</a>:
                    	<input name="csv2post_demomode" type="checkbox" value="<?php csv2post_checkboxstatus1(get_option('csv2post_demomode')); ?>" <?php csv2post_checkboxstatus2(get_option('csv2post_demomode')); ?>  />
                    </p>
                    <p>
                    	<a href="#" title="This indicates the number of custom fields you need to use in your campaign on stage 4. You will need to use this for themes like ShopperPress or ClassiPress">Stage 4 Column Menus</a>:
                    	<input type="text" name="csv2post_stage4fieldscolumns" value="<?php echo get_option('csv2post_stage4fieldscolumns'); ?>" size="2" maxlength="2" />
                    </p>
                    <p>
                        <a href="#" title="To apply different character encoding to your post content and title during importing please select your requirement here">Character Encoding</a>:
                        <select name="csv2post_characterencoding" size="1">
                            <option value="default" <?php if(get_option('csv2post_characterencoding') == 'none'){echo 'selected="selected"';}?>>None</option>
                            <option value="utf8" <?php if(get_option('csv2post_characterencoding') == 'utf8'){echo 'selected="selected"';}?>>UTF-8</option>
                        </select>
                    </p>   
                  	<p>
                    	<a href="#" title="If you upload csv files by ftp they will get the delimiter you enter here or if you forget to enter it when uploading files will still get the default delimiter in their profile.">Default Delimiter</a>:
                    	<input type="text" name="csv2post_defaultdelimiter" value="<?php echo get_option('csv2post_defaultdelimiter'); ?>" size="1" maxlength="1" />
                    </p>                                 
                </div>
            </div>    
            
        <div class="postbox closed">
            <div class="handlediv" title="Click to toggle"><br />
            </div>
             <h3>New Post Options</h3>
                <div class="inside">
                    <p><a href="#" title="Staggered processing only. This number is the amount of records that will be imported to make posts for every page visit on your blog.">Posts Per Hit</a>:
                    <input type="text" name="csv2post_postsperhit_global" value="<?php echo get_option('csv2post_postsperhit_global'); ?>" size="3" maxlength="3"  /> 
                    </p>
                    <p><a href="#" title="User account to be applied to new posts as the publisher">Default Publisher</a>:
                    <?php wp_dropdown_users( $usernames );?>
                    </p>
                    <p><a href="#" title="If you use category creation on stage 5 this setting will assign the parent on stage 5 as a child to the selected category here so that all categories and all posts come under this category. This setting is hardly ever needed.">Default Category Parent</a>:
                    <select name="csv2post_defaultcatparent" size="1">
                    <option value="NA">No Parent Required</option>
                    <?php get_categories_fordropdownmenu_csv2post();?>
                    </select>
                    </p>
                    <p><a href="#" title="Make import data blog posts or standard pages.">Default Post Type</a>:
                    <select name="csv2post_defaultposttype" size="1" >
                    <option value="post" <?php if($defaultposttype == 'post'){echo 'selected="selected"';}?>>Post</option>
                    <option value="page" <?php if($defaultposttype == 'page'){echo 'selected="selected"';}?>>Page</option>
                    </select>
                    </p>
                    <p><a href="#" title="Will allow or disallow pinging on newly created posts or pages">Default Ping Status</a>:
                      <select name="csv2post_defaultping" size="1">
                    <option value="1" <?php if($defaultping == '1'){echo 'selected="selected"';}?>>On</option>
                    <option value="0" <?php if($defaultping == '0'){echo 'selected="selected"';}?>>Off</option>
                    </select>
                    </p>
                    <p>
                        <a href="#" title="Switch commenting on or off for new posts">Default Comments Status</a>:
                        <select name="csv2post_defaultcomment" size="1">
                        <option value="open" <?php if($commentstatus == 'open'){echo 'selected="selected"';}?>>Open</option>
                        <option value="closed" <?php if($commentstatus == 'closed'){echo 'selected="selected"';}?>>Closed</option>
                        </select>
                    </p>                        
                    <p>
                        <a href="#" title="If using randomised publishing date on stage 3. The dates applied will be between the start and end date set here.">Random Date Range</a><br />
                        <?php csv2post_datepicker_nonejavascript(); ?>           
                    </p>           
                 </div>
            </div>
            
        <div class="postbox closed">
            <div class="handlediv" title="Click to toggle"><br />
            </div>
             <h3>Processing Configuration Options</h3>
                <div class="inside">
                    <p>
                    	<a href="#" title="If your server is very sensitive you will need to enforce  a maximum processing time however 30 seconds is normally enough for importing and will not effect most servers.">Maximum Execution Time In None Full Modes</a>:
                    	<input type="text" name="csv2post_maxstagtime" value="<?php echo $maxstagtime; ?>" size="8" maxlength="8" />seconds
                    </p>
                    <p>
                    	<a href="#" title="Will delay processing events and force the plugin to only import data once the timer has ended. The number entered here is in seconds">Processing Event Delay</a>:
                    	<input type="text" name="csv2post_processingdelay" value="<?php echo get_option('csv2post_processingdelay'); ?>" size="8" maxlength="8" />seconds
                    </p>
                    <p>
                        <a href="#" title="This is a special function built into Wordpress. The options are points in which plugins can action events while Wordpress loads. Different triggers here may have different effects depending on your setup">Processing Trigger</a>:
                        <select name="csv2post_processingtrigger" size="1" >
                            <option value="get_footer" <?php if($processingtrigger == 'get_footer'){echo 'selected="selected"';}?>>get_footer</option>
                            <option value="get_header" <?php if($processingtrigger == 'get_header'){echo 'selected="selected"';}?>>get_header</option>
                            <option value="wp_footer" <?php if($processingtrigger == 'wp_footer'){echo 'selected="selected"';}?>>wp_footer</option>
                            <option value="wp_head" <?php if($processingtrigger == 'wp_head'){echo 'selected="selected"';}?>>wp_head</option>
                            <option value="init" <?php if($processingtrigger == 'init'){echo 'selected="selected"';}?>>init</option>
                            <option value="send_headers" <?php if($processingtrigger == 'send_headers'){echo 'selected="selected"';}?>>send_headers</option>
                            <option value="shutdown" <?php if($processingtrigger == 'shutdown'){echo 'selected="selected"';}?>>shutdown</option>
                            <option value="wp" <?php if($processingtrigger == 'wp'){echo 'selected="selected"';}?>>wp</option>
                        </select>
                    </p>
                    <p>
                        <a href="#" title="If set to manual you will need to start the update phase yourself using the campaign manager. If you set it to automatic then updating will proceed once the campaign has imported all data. Updating will loop forever constantly applying the csv file data to existing posts.">Default Update State</a>:
                        <select name="csv2post_defaultphase" size="1" >
                        <option value="0" <?php if($defaultphase == '0'){echo 'selected="selected"';}?>>Manual Update Activation</option>
                        <option value="1" <?php if($defaultphase == '1'){echo 'selected="selected"';}?>>Auto Update Activation</option>
                        </select>
                    </p>  
                </div>
            </div>


        <div class="postbox closed">
            <div class="handlediv" title="Click to toggle"><br />
            </div>
             <h3>SEO Options</h3>
                <div class="inside">
                    <p><a href="#" title="This is the total length of your tags string for each post. 50 will proceed 5-8 tags usually. This is ideal to keep your theme looking well laid out.">Post TAGs Maximum Length</a>:
                    <input type="text" name="csv2post_tagslength" value="<?php echo $tagslength; ?>" size="3" maxlength="3" /> 
                    characters</p>
                    <p><a href="#" title="You can stop numbers being used as tags by ticking this box.">Allow Numeric Tags</a>:
                    <input name="csv2post_numerictags" type="checkbox" value="<?php csv2post_checkboxstatus1($numerictags); ?>" <?php csv2post_checkboxstatus2($numerictags); ?> /> 
                    </p>
                    <textarea name="csv2post_exclusions" cols="100" rows="10"><?php echo get_option('csv2post_exclusions');?></textarea>                    
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

    <input type="hidden" name="action" value="update" />    
    <input type="hidden" name="page_options" value="
    csv2post_debugmode,
    csv2post_processingtrigger,
    csv2post_postsperhit_global,
    csv2post_publisherid,
    csv2post_maxstagtime,
    csv2post_tagslength,
    csv2post_numerictags,
    csv2post_defaultcatparent,
	csv2post_defaultposttype,
    csv2post_defaultping,
    csv2post_defaultcomment,
	csv2post_defaultphase,
    csv2post_tooltipsonoff,
  	csv2post_processingdelay,
	csv2post_exclusions,
    csv2post_demomode,
	csv2post_stage4fieldscolumns,
    csv2post_randomdate_monthstart,
    csv2post_randomdate_daystart,
    csv2post_randomdate_yearstart,
    csv2post_randomdate_monthend,
    csv2post_randomdate_dayend,
    csv2post_randomdate_yearend,
	csv2post_characterencoding,
    csv2post_defaultdelimiter
    " />
    
    <p class="submit"><input type="submit" class="button-primary" value="Save Changes" <?php if(get_option('csv2post_demomode') == 1){echo 'disabled="disabled"';}?>/></p>
    
    </form>
    
    <h2>Settings Tutorial</h2>
    <object width="592" height="445"><param name="movie" value="http://www.youtube.com/v/l9rk4dFdjc0&hl=en_GB&fs=1&"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/l9rk4dFdjc0&hl=en_GB&fs=1&" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="425" height="344"></embed></object>
    
</div>