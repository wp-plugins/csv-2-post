<?php
set_time_limit(900000);

# SELECT A CAMPAIGN AND PROCESS IT
$campaignresult = $wpdb->get_row("SELECT * FROM " .$wpdb->prefix . "csvtopost_campaigns WHERE stage = 100");

# GET FILE LOCATION DEPENDING ON PROCESSING TYPE
if($campaignresult->locationtype == 1)
{
	# FULL PROCESSING
	$filelocation = $campaignresult->location;
}
elseif($campaignresult->locationtype == 2)
{
	# STAGGERED PROCESSING
	$target_path = dirname(__FILE__).'/csv_files/'; // Upload store directory (chmod 777)
	$filelocation = $target_path.$campaignresult->camfile;
}

# OPEN FILE
$handle = fopen("$filelocation", "r");
		
if($handle == false)
{
	# FILE FAILED TO OPEN - LOG AN ERROR REPORT
}
else
{
	# GET THE ROW LIMIT
	if($campaignresult->process == 1)
	{
		# FULL PROCESSING
		$post_limit = 9999999;
	}
	elseif($campaignresult->process == 2)
	{
		# STAGGERED RATIO
		$post_limit = $campaignresult->ratio;
	}
	
	$row_counter = 0;
	$posts_made = 0;
	
	$camid = $campaignresult->id;
	
	# START PROCESSING EACH ROW
	while (($csvrow = fgetcsv($handle, 9999999, ",")) !== FALSE && $posts_made != $post_limit)
	{ 
		# AVOID PROCESSING THE TOP ROW
		if($row_counter != 0)
		{ 
			$filterid = $campaignresult->filtercolumn;// csv column id of filter column
			
			$c = 0;
			
			# PROCESS EACH COLUMN INDIVIDUALLY TO ESTABLISH ITS EXACT USE
			foreach($csvrow as $data)
			{  
				$data = rtrim($data);
	
				# GET MATCHING ROW FROM RELATIONSHIPS TABLE AND ESTABLISH WHAT POST PART COLUMN MATCHES
				$postpart = $wpdb->get_var("SELECT postpart FROM " .$wpdb->prefix . "csvtopost_relationships WHERE csvcolumnid = $c AND camid = '$camid'");
	
				# CHECK WHAT POST PART COLUMN IS ASSIGNED TO AND TAG DATA TO IT IN ITS OWN VARIABLE
				if($postpart == 'title'){$title = $data;}
				elseif($postpart == 'content'){$content = $data;}
				elseif($postpart == 'currency'){$currency = $data;}
				elseif($postpart == 'price'){$price = $data;}
				elseif($postpart == 'advertiser'){$advertiser = $data;}
				elseif($postpart == 'imageurl'){$imageurl = $data;}
				elseif($postpart == 'buyurl'){$buyurl = $data;}
	
				# IF THIS COLUMN IS FILTER COLUMN THEN CHECK ITS VALUE IN THIS ROW AND GET CATEGORY
				if($filterid != 999 && $c == $filterid)
				{ 
					$val = $data;// unique value from csv column
				
					$catid = $wpdb->get_var("SELECT catid FROM " .$wpdb->prefix . "csvtopost_categories WHERE camid = '$camid' AND uniquevalue = '$val'");
				}
				
				$c++;
			}
			
			# IF TITLE MATCHES AN EXISTING TITLE THEN DO NOT CONTINUE
			global $wpdb;
			$count = $wpdb->get_var("SELECT COUNT(*) FROM " .$wpdb->prefix . "posts WHERE post_title = '$title'");
		
			if( $count > 0 )
			{
				# DO NOTHING
			}
			else
			{ 
				# CREATE MAIN TEXT CONTENT
				$text = '<p>'; $text .= $content; $text .= '</p>';
					
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
						$img .= '<a href="'; $img .= $buyurl; $img .= '"><img src="'; $img .= $imgurl; $img .= '" alt="'; $img .= $title; $img .= '"></a>';
					}
					else
					{ 
						// without link
						$img .= '<img src="'; $img .= $imgurl; $img .= '" alt="'; $img .= $title; $img .= '">';
					}
					
					$img .= '</p>';
				}
				
				# CREATE TEXT LINK IF BUY URL PROVIDED
				if(isset($buyurl))
				{
					$link = '</br><a href="'; $link .= $buyurl; $link .= '" title="'; $link .= $title; $link .= '">'; $link .= 'Read more about '; $link .= $title; $link .= '</a>';
				}
				
				# BUILD A POST CONTENT USING AVAILABLE DATA
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
											
				# MAKE CUSTOM META DATA
				$metadescription = create_meta_description($content, 150);
				$metakeywords = create_meta_keywords($content, 150);
								
				# CREATE POST OBJECT AND INSERT TO DATABASE
				$my_post = array();
				$my_post['post_title'] = $title;
				$my_post['post_content'] = $post;
				$my_post['post_status'] = $campaignresult->poststatus;
				$my_post['post_author'] = 1;
				$my_post['post_category'] = array($catid);
				$my_post['comment_status'] = 'open';
				$my_post['post_excerpt'] = $metadescription;
		
				$post_id = wp_insert_post( $my_post );
				
				# RECORD NEW POST IN csv2post_posthistory TABLE
				$sqlQuery = "INSERT INTO " .
				$wpdb->prefix . "csvtopost_posthistory(camid, postid)
				VALUES('$camid', '$post_id')";
				$wpdb->query($sqlQuery);
								
				# INSERT SCRIPTS DEFAULT CUSTOM FIELDS AND VALUES
				add_post_meta($post_id, '_headspace_description', $metadescription, true);
				add_post_meta($post_id, 'head_keywords', $metakeywords, true);
				add_post_meta($post_id, 'csv2post_campaignid', $camid, true);
				
				# INSERT CAMPAIGNS CUSTOM FIELDS AND VALUES THAT ARE NOT UNIQUE PER POST
				$res1 = $wpdb->get_results("SELECT * FROM " .$wpdb->prefix . "csvtopost_customfields WHERE camid = '$camid' AND type = '0'");
				
				foreach($res1 as $x)
				{   
					$key = $x->identifier;
					$value = $x->value;
					add_post_meta($post_id, $key, $value, true);
				}
								
				# INSERT CAMPAIGN CUSTOM FIELDS AND VALUES THAT MAY BE UNIQUE VALUES ARE FROM CSV COLUMN DATA
				$res2 = $wpdb->get_results("SELECT * FROM " .$wpdb->prefix . "csvtopost_customfields WHERE camid = '$camid' AND type = '1'");
				
				foreach($res2 as $y)
				{
					$v = $y->value;
					$k = $y->identifier;

					$column_counter = 0;
					
					foreach($csvrow as $data)
					{
						if($column_counter == $v)
						{ 
							add_post_meta($post_id, $k, $data, true);
						}
						
						$column_counter++;
					}
				}

				# COUNT ROWS ACTUALLY USED TO CREATE POSTS
				$posts_made++;

			}// end if title already exists
		}// end if 1st row check
		
		# COUNT ROWS PROCESSED - NOT ENTERED JUST ALL THAT IS PROCESSED IN TOTAL
		$row_counter++;
	}// end of entire processing event
	
	# IF CAMPAIGN IS FULL PROCESSING THEN CHANGE STAGE TO 300 TO INDICATE COMPLETE
	if($campaignresult->process == 1)
	{
		# GET CURRENT NUMBER OF POSTS ALREADY CREATED FOR THIS CAMPAIGN
		$currentposts = $wpdb->get_var("SELECT posts FROM " .$wpdb->prefix . "csvtopost_campaigns WHERE id = '$camid'");
		
		$posts_made = $currentposts + $posts_made;
		
		$sqlQuery = "UPDATE " .
		$wpdb->prefix . "csvtopost_campaigns SET stage = '300', posts = '$posts_made' WHERE id = '$camid'";
		$wpdb->query($sqlQuery);
	}
	
	fclose($handle);
	
}// end of if handle = false
?>