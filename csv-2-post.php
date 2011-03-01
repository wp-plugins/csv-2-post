<?php
/*
	Plugin Name: CSV 2 POST Free
	Version: 3.6
	Plugin URI:http://www.csv2post.com
	Description: Stay updated using the <a href="http://www.csv2post.co.uk?feed=rss">RSS </a>Feed. <a href="http://www.csv2post.co.uk/wp-login.php?action=register">Register </a> using your Paypal email address for download access. <a href="http://www.csv2post.eu/wp-login.php">Login</a> now to download new versions. Go to the <a href="http://forum.csv2post.co.uk">CSV 2 POST Forum</a>.
	Author: CSV 2 POST
	Author URI: http://www.csv2post.co.uk
*/

// expected folder name - used for making up path too plugin files
if(!defined('ECIFOLDER')){define('ECIFOLDER','/csv-2-post-demo/');}

// complete path too plugin files
if(!defined('ECIPATH')){define('ECIPATH',WP_PLUGIN_DIR.ECIFOLDER);}

# Echos Link For Post Box Header
function c2pd_postboxlink( $url,$title )
{
	echo '<span class="postbox-title-action"><a href="'.$url.'" target="_blank" class="edit-box open-box">'.$title.'</a></span>';
}

# Displays Standard Wordpress Message
function c2pd_mes( $title,$message )
{
	echo '<div id="message" class="updated fade"><strong>'.$title.'</strong><p>'. $message .'</p></div>';
}

function c2pd_toppage(){require_once(ECIPATH.'c2pd_home.php');}
function c2pd_menu() 
{
	add_menu_page('CSV2POST', 'CSV2POST', 0, __FILE__ , 'c2pd_toppage');
}
add_action('admin_menu', 'c2pd_menu');

function c2pd_dashboard_rsswidget_function(){echo '<script src="http://feeds.feedburner.com/csv2post?format=sigpro" type="text/javascript" ></script><noscript><p>Subscribe to RSS headline updates from: <a href="http://feeds.feedburner.com/csv2post"></a><br/>Powered by FeedBurner</p> </noscript>';} 
function c2pd_add_dashboard_rsswidgets() 
{
	wp_add_dashboard_widget('c2pd_rssdashboard_widget', 'CSV 2 POST Updates', 'c2pd_dashboard_rsswidget_function');	
} 
add_action('wp_dashboard_setup', 'c2pd_add_dashboard_rsswidgets' );

# Adds Wordpress Admin Style Sheets And Control Panel Too All Pages
function c2pd_header()
{?>       
	<link rel='stylesheet' href='<?php echo get_bloginfo( 'url' );?>/wp-admin/load-styles.php?c=1&amp;dir=ltr&amp;load=dashboard,plugin-install,global,wp-admin&amp;ver=030f653716b08ff25b8bfcccabe4bdbd' type='text/css' media='all' />
	<link rel='stylesheet' id='thickbox-css'  href='<?php echo get_bloginfo( 'url' );?>/wp-includes/js/thickbox/thickbox.css?ver=20090514' type='text/css' media='all' />
	<link rel='stylesheet' id='colors-css'  href='<?php echo get_bloginfo( 'url' );?>/wp-admin/css/colors-fresh.css?ver=20100610' type='text/css' media='all' />
	<!--[if lte IE 7]>
	<link rel='stylesheet' id='ie-css'  href='<?php echo get_bloginfo( 'url' );?>/wp-admin/css/ie.css?ver=20100610' type='text/css' media='all' />
	<![endif]--><?php
} 
      
# Displays WTG Copyright And Provides Script For Post Boxes
function c2pd_footer()
{?>
   <script type="text/javascript">
        // <![CDATA[
        jQuery('.postbox div.handlediv').click( function() { jQuery(jQuery(this).parent().get(0)).toggleClass('closed'); } );
        jQuery('.postbox h3').click( function() { jQuery(jQuery(this).parent().get(0)).toggleClass('closed'); } );
        jQuery('.postbox.close-me').each(function(){
        jQuery(this).addClass("closed");
        });
        //-->
    </script><?php 
}

?>