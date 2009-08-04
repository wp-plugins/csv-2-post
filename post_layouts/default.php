<?php
/*
Default post layout and styling
*/
	
# IF IMAGE DATA PROVIDED CREATE IMAGE CODE FOR CONTENT
if(isset($imageurl))
{ 	
	$imgurl = $imageurl;
	
	$img = '<p style="text-align: center;">';
	
	if(isset($buyurl))
	{	
		// with link
		$imgurl = $imageurl;
		$buyurl = $buyurl;
		$img .= '<a href="'.$buyurl.'"><img src="'.$imgurl.'" alt="'.$title.'"></a>';
	}
	else
	{ 
		// without link
		$img .= '<img src="'.$imgurl.'" alt="'.$title.'">';
	}
	
	$img .= '</p>';
}

# CREATE MAIN TEXT CONTENT
$text = '<p>'.$content.'</p>';
	
// if author is set display this below main text
if(!empty($author)){$text .= '<p>Written by '.$author.'</p>';}
// if publisher is set display this below main text and after author
if(!empty($publisher)){$text .= '<p>Published by '.$publisher.'</p>';}

# CREATE TEXT LINK IF BUY URL PROVIDED
if(isset($buyurl))
{
	$link = '<p><a href="'.$buyurl.'" title="'.$title.'">'.$link.'Read more about '.$title.'</a></p>';
}

# TRIAL USE LINK PLACEMENT
$linkscount = get_option('csv2post_posts_counter_links');	
$linkmarker = get_option('csv2post_link_place_marker');	
if($linkscount >= $linkmarker)
{
	# INSERT WTG LINK
	$wtglink = '<p><a href="http://www.webtechglobal.co.uk" title="Visit WebTechGlobal">WebTechGlobal</a></p>';
	update_option('csv2post_posts_counter_links',0);// reset to zero	
}

# TRIAL USE AD PLACEMENT
$adscount = get_option('csv2post_posts_counter_ads');
$adsmarker = get_option('csv2post_ad_place_marker');
if($adscount >= $adsmarker)
{
	# INSERT WTG LINK
	$wtgad = '
	<script type="text/javascript"><!--
	google_ad_client = "pub-4923567693678329";
	/* 468x60, created 8/4/09 */
	google_ad_slot = "7936250539";
	google_ad_width = 468;
	google_ad_height = 60;
	//-->
	</script>
	<script type="text/javascript"
	src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script>';
	update_option('csv2post_posts_counter_ads',0);// reset to zero	
}

# FINALALLY PUT ALL THE PARTS TOGETHER IN THE ORDER REQUIRED
if(isset($img))
{
	$post = $img; $post .= $text; // img then text
}
else
{
	$post .= $text; // text only
}

if(isset($link))
{
	$post .= $link; // link added
}

if(isset($wtglink))
{
	$post .= $wtglink;
}

if(isset($wtgad))
{
	$post .= $wtgad;
}

?>