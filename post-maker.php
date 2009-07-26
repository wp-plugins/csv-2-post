<?php
set_time_limit(900000);

# SELECT A CAMPAIGN AND PROCESS IT
$campaignresult = $wpdb->get_row("SELECT * FROM " .$wpdb->prefix . "csvtopost_campaigns WHERE stage = 100");

# GET FILE LOCATION DEPENDING ON PROCESSING TYPE
$target_path = dirname(__FILE__).'/csv_files/'; // Upload store directory
$filelocation = $target_path.$campaignresult->camfile;

# OPEN FILE
$handle = fopen("$filelocation", "r");
		
if($handle == false)
{
	# FILE FAILED TO BE FOUND OR OPEN
	
}
else
{
	# GET THE POST INJECTION LIMIT
	if($campaignresult->process == 1)
	{$post_limit = 9999999;}// full file processing
	elseif($campaignresult->process == 2)
	{$post_limit = $campaignresult->ratio;}// staggered processing
	
	# GET REQUIRE VARIABLES FOR ENTIRE CAMPAIGN PROCESSING
	$row_counter = 0;
	$posts_injected = 0;
	$filterid = $campaignresult->filtercolumn;
	$camid = $campaignresult->id;
	$rows_processed = 0;// resets per row
	$posts_injected = 0;
	
	# START PROCESSING EACH ROW
	while (($csvrow = fgetcsv($handle, 9999999, ",")) !== FALSE && $posts_injected <= $post_limit)
	{ 
		# AVOID PROCESSING THE TOP ROW
		if($rows_processed != 0)
		{
			# PROCESS EACH COLUMN INDIVIDUALLY TO ESTABLISH ITS EXACT USE
			$column_counter_getdata = 0;
			foreach($csvrow as $data)
			{  
				$data = rtrim($data);	

				# GET MATCHING ROW FROM RELATIONSHIPS TABLE AND ESTABLISH WHAT POST PART COLUMN MATCHES
				$postpart = $wpdb->get_var("SELECT postpart FROM " .$wpdb->prefix . "csvtopost_relationships WHERE csvcolumnid = '$column_counter_getdata' AND camid = '$camid'");


				# CHECK WHAT POST PART COLUMN IS ASSIGNED TO AND TAG DATA TO IT IN ITS OWN VARIABLE
				if($postpart == 'title'){$title = $data;}// used in POST title, usually product name
				elseif($postpart == 'content'){$content = $data;}// main text bulk and description
				elseif($postpart == 'currency'){$currency = $data;}// if curreny symbol required
				elseif($postpart == 'price'){$price = $data;}// if product style display
				elseif($postpart == 'advertiser'){$advertiser = $data;}// optional display of advertiser name
				elseif($postpart == 'imageurl'){$imageurl = $data;}// main image usually at top of post
				elseif($postpart == 'buyurl'){$buyurl = $data;}// url to page for buying item
				elseif($postpart == 'category'){$category = $data;}// any special category product fits in
				elseif($postpart == 'author'){$author = $data;}// usually for books and articles
				elseif($postpart == 'publisher'){$publisher = $data;}// usually for books

				# IF THIS COLUMN IS FILTER COLUMN THEN CHECK ITS VALUE IN THIS ROW AND GET CATEGORY
				if($filterid != 999 && $c == $filterid)
				{ 
					$val = $data;// unique value from csv column
				
					$catid = $wpdb->get_var("SELECT catid FROM " .$wpdb->prefix . "csvtopost_categories WHERE camid = '$camid' AND uniquevalue = '$val'");
				}
				
				$column_counter_getdata++;
			}// end of foreach
		
			# WE HAVE A SINGLE POSTS DATA NOW - MOVE ONTO PROCESSING IT
			
			# IF TITLE MATCHES AN EXISTING TITLE THEN DO NOT CONTINUE
			global $wpdb;	
			$count = 0;
		
			$wpdb->query("SELECT * FROM " .$wpdb->prefix . "posts WHERE post_title = '$title'");
		
		 	$count = $wpdb->num_rows;
					
			if( $count > 0 )
			{
				# DO NOTHING 
			}
			else
			{ 
				# GET REQUIRED POST CONTENT LAYOUT AND STYLING
				// currently not dynamic and default
				require('post_layouts/default.php');
				
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
				
				# COUNT ROWS ACTUALLY USED TO CREATE POSTS
				$posts_injected = $posts_injected + 1;
								
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
	
	
				# UNSET ALL LOCAL VARIABLES THAT ARE UNIQUE PER POST
				unset($post); unset($link); unset($img); unset($text);
				unset($title); unset($buyurl); unset($publisher);
				unset($contact); unset($currency); unset($price);
				unset($advertiser); unset($imageurl);
				unset($category); unset($author);
				
			}// end if title already exists

			$column_counter = $column_counter + 1;
		}// end if first row or not
		
		# ROWS PROCESSED + 1
		$rows_processed++;
		
	}// end fgetcsv while loop
}// end of if file found or not
	
?>