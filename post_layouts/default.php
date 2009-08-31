<?php
if(isset($imageurl))
{ 	
	$imgurl = @$imageurl;
	
	$img = '<p style="text-align: center;">';
	
	if(isset($buyurl))
	{	
		// with link
		$imgurl = @$imageurl;
		$buyurl = @$buyurl;
		$img .= '<a href="'.@$buyurl.'"><img src="'.@$imgurl.'" alt="'.@$title.'"></a>';
	}
	else
	{ 
		// without link
		$img .= '<img src="'.@$imgurl.'" alt="'.@$title.'">';
	}
	
	$img .= '</p>';
}

$text = '<p>'.$content.'</p>';
	
if(!empty($author)){$text .= '<p>Written by '.$author.'</p>';}
if(!empty($publisher)){$text .= '<p>Published by '.$publisher.'</p>';}

if(isset($buyurl))
{
	@$link = '<p><a href="'.@$buyurl.'" title="'.@$title.'">'.@$link.'Read more about '.@$title.'</a></p>';
}

if(isset($img))
{
	$post = @$img; $post .= @$text; // img then text
}
else
{
	@$post .= $text; // text only
}

if(isset($link))
{
	$post .= $link; // link added
}
?>