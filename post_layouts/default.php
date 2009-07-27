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
?>