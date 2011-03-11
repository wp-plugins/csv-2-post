<?php
################### THIS FILE INCLUDES GOOGLE ADSENSE WHICH YOU MUST REPLACE WITH YOUR OWN ADSENSE SNIPPET  ######################

// load wysiwyg editor css and js if design page loaded
if( is_admin() && isset( $_GET['page'] ) && $_GET['page'] == 'c2pf_designs' )
{
	add_action('admin_head', 'c2pf_wysiwygeditor');
}

# Processes The Submission Of A Cloaked URL - Forwarding Visitor To Real One
function c2pf_cloakedurlsubmission() 
{
	if( isset( $_GET['viewx'] ) && isset( $_GET['caty'] ) )
	{
		######       this function can be customised to suit your needs by working with your theme or other plugins       #######
		header("HTTP/1.1 302 Found");
		header("Location: http://www.webtechglobal.co.uk/blog/information/url-cloaking-results");// free edition does not provide url cloaking
		header("Connection: close");	
	}	
}				

# Applys Google AdSense To End Of Post Content - Please Customise To Suit Your Needs
function c2pf_appendgoogle( $posts )
{ 
	if( $posts )
	{		
		foreach( $posts as $post )
		{		
			global $wpdb;
			// using current post id get c2pf_poststate - it may not exist if thats the case we do nothing
			$result = get_post_meta($post->ID, 'c2pf_poststate', true );

			// if value returned it is owned by eci - if it is not seperated
			if( isset( $result ) && $result != false && $result != 'seperated' )
			{
				foreach( $posts as $post )
				{
					$my_post = array();
					$my_post['ID'] = $post->ID;
					$category = get_the_category( $post->ID ); 
					$post->post_content = $post->post_content.'<br />
					<script type="text/javascript"><!--
					google_ad_client = "ca-pub-4923567693678329";
					google_ad_slot = "2068446115";
					google_ad_width = 468;
					google_ad_height = 15;
					//-->
					</script>
					<script type="text/javascript"
					src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
					</script>';
					//$updateid = wp_update_post( $my_post ); 
				}
			}
		}
	}	
	return $posts;
}		


add_action('the_posts', 'c2pf_appendgoogle');
				
# Process Cloaked URL Click
add_action('status_header', 'c2pf_cloakedurlsubmission');

# Applys Any Manual Changes Done On Edit Post Screen To The Project Table
function c2pf_editpostsync()
{ 
	// requires you to hire WebTechGlobal for advanced custom features
}

add_action('edit_post', 'c2pf_editpostsync');

# triggers scheduled events - the function decides which speed is due,then which project,then action
add_action('init', 'c2pf_eventtrigger');
function c2pf_eventtrigger()
{
	// there is no schedule system in the free edition
}
?>