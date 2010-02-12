<div class="wrap">
    <h2>CSV 2 POST Demo Edition Only</h2>

    <div id="poststuff" class="metabox-holder">
        <div id="post-body">
            <div id="post-body-content">
                <div class="postbox">
                    <h3 class='hndle'><span>Demo Edition Information - Please Read</span></h3>
                    <p>Some functions have been disabled or removed for security and so this demo edition may not always work as expected. It is meant to be a preview
                    so you can make a better decision on the right solution for your csv import needs.</p>
                </div>                    
            </div>
        </div>
    </div>
  
    <div id="poststuff" class="meta-box-sortables" style="position: relative; margin-top:10px;">
        <div class="postbox closed">
            <div class="handlediv" title="Click to toggle"><br />
            </div>
             <h3>Click Statistics</h3>
                <div class="inside">
                    <?php 
                    global $post;
                    $myposts = get_posts();
                    $total_click_count = 0;
                    foreach($myposts as $post) :
                        setup_postdata($post);
                        $posts_click_count = get_post_meta($post->ID, 'csv2post_cloakedlinkclicks', true);
                        $total_click_count = $total_click_count + $posts_click_count;
                    endforeach; 
                    ?>
                    <p><a href="#" title="Total number of clicks. Click statistics will be gathered when you use URL cloaking on Stage 2 of the New Campaign process.">Total Clicks</a>: <?php echo $total_click_count;?>
                </div>
            </div>
            
            
        <div class="postbox closed">
            <div class="handlediv" title="Click to toggle"><br />
            </div>
             <h3>Support</h3>
                <div class="inside">
                    <ul>
                      <li><a href="http://www.csv2post.com/feed" title="Subscribe to CSV 2 POST RSS Feed" target="_blank">RSS Feed</a> - The feed only sends important notifications of changes in the plugin. </li>
                      <li><a href="mailto:webmaster@webtechglobal.co.uk" title="Email for help on CSV 2 POST" target="_blank">Email</a>&nbsp;-  If you can't find answers on <a href="http://www.csv2post.com/?s=help" title="Get help on the CSV 2 POST website" target="_blank">www.csv2post.com</a> please email me.</li>
                      <li><a href="http://forum.webtechglobal.co.uk/viewforum.php?f=2&amp;sid=62639f7692667366357e6b79bff726b1" title="Go to the WTG forum for support" target="_blank">Forum</a>&nbsp;- Central forum for all WebTechGlobal services and products.</li>
                      <li><a href="http://www.csv2post.com/blog/free-edition/post2" title="Watch CSV 2 POST videos" target="_blank">Videos</a> - You will find various videos, <strong>please request videos if needed</strong>.</li>
                      <li><a href="http://twitter.com/webtechglobal" title="Follow WebTechGlobal on Twitter" target="_blank">Twitter</a> - Get new version notifications for plugins through my tweets.</li>
                    </ul>                
                </div>
            </div>            
    
        <div class="postbox closed">
            <div class="handlediv" title="Click to toggle"><br />
            </div>
             <h3>Quick Start Instructions</h3>
                <div class="inside">
                      <ol>
                          <li>Firstly configure the plugins <a href="admin.php?page=settings_plus">Settings</a> exactly as you need them for your long term campaigns.</li>
                          <li><a href="admin.php?page=uploader_plus">Upload</a> a 2MB or smaller csv file&nbsp;or upload a larger file by ftp to the csv files directory in your &quot;wp-content&quot; folder.</li>
                          <li>Then go to the <a href="admin.php?page=layouts_plus">Layouts</a> page, select your csv file from the list and then click on submit&nbsp;to begin creating your post layout.</li>
                          <li>Go to the <a href="admin.php?page=new_campaign_plus">New Campaign </a>page&nbsp;and complete the 5 Stages to create your campaign.</li>
                          <li>Once your campaign is running you can monitor it later on the <a href="admin.php?page=manage_campaigns_plus">Manage Campaigns</a> page.</li>
                          <li>If your  just getting to know the plugin you can undo anything created on the <a href="admin.php?page=tools_plus">Tools</a> page so you can start fresh again.</li>
                          <li>Should your post style and layout not be as you need, you can re-open your Custom Post Layout on <a href="admin.php?page=layouts_plus">Layouts</a> page and edit it.</li>
                    </ol>
                      <object width="641" height="471"><param name="movie" value="http://www.youtube.com/v/IThvP97pszE&hl=en&fs=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/IThvP97pszE&hl=en&fs=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="641" height="471"></embed></object>
            </div>
            </div>     
            
        <div class="postbox closed">
            <div class="handlediv" title="Click to toggle"><br />
            </div>
             <h3>General Plugin Status</h3>
                <div class="inside">
                    <p>CSV Files Folder: <?php echo csv2post_doesexist_csvfilesfolder(); ?></p>
                    <p>Auto Line Ending (MAC fix): <?php  echo csv2post_autolineendings_status(); ?></p>
                    <p>Server Safe Mode: <?php  echo csv2post_checksafemodestatus(); ?></p>
                    <p>Last Execution Point: <?php echo get_option('csv2post_lastpointofexecution');?></p>
                </div>
            </div>                    
    
        <div class="postbox">
            <div class="handlediv" title="Click to toggle"><br />
            </div>
             <h3>Recommended Services For Using With CSV 2 POST</h3>
                <div class="inside">
					<a href='https://www.e-junkie.com/ecom/gb.php?cl=29717&c=ib&aff=85223'><img src='http://i627.photobucket.com/albums/tt355/classipress/aff/classipress_468x60_02.jpg' border='0' width='468' height='60' alt='Premium WordPress Theme' /></a>
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
    
    </div><!-- end of poststuff div id -->

</div>
    
   