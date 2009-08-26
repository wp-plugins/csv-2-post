<?php

# SELECT A CAMPAIGN AND PROCESS IT
$campaignresult = $wpdb->get_row("SELECT camfile,process,ratio,filtercolumn,id,poststatus,posts FROM " .$wpdb->prefix . "csvtopost_campaigns WHERE stage = '100'");

$uploadpath = get_option( 'upload_path' );
$target_path = $uploadpath.'/csv2postfiles/';
$filelocation = $target_path.$campaignresult->camfile;

# OPEN FILE
$handle = fopen("$filelocation", "r");
		
if($handle != false)
{
	// post limit and script time limit
	if($campaignresult->process == 1)
	{
		$post_limit = 999999;
		set_time_limit(900000);
	}
	elseif($campaignresult->process == 2)
	{
		$post_limit = get_option('csv2post_postsperhit');
		set_time_limit(get_option('csv2post_maxstagtime'));
	}
		
	# GET REQUIRE VARIABLES FOR ENTIRE CAMPAIGN PROCESSING
	$row_counter = 0;
	$posts_injected = 0;
	$filterid = $campaignresult->filtercolumn;
	$camid = $campaignresult->id;
	$previously_made_posts = $campaignresult->posts;
	$rows_processed = 0;
	
	# START PROCESSING EACH ROW
	while (($csvrow = fgetcsv($handle, 9999, ",")) !== FALSE && $posts_injected != $post_limit)
	{ 		
		# AVOID PROCESSING THE TOP ROW
		if($rows_processed != 0 && $rows_processed >= $previously_made_posts)
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
				if($filterid != 999 && $column_counter_getdata == $filterid)
				{ 
					$val = $data;// unique value from csv column
				
					$catid = $wpdb->get_var("SELECT catid FROM " .$wpdb->prefix . "csvtopost_categories WHERE camid = '$camid' AND uniquevalue = '$val'");
				}
				
				$column_counter_getdata++;
			}// end of foreach
		
			# WE HAVE A SINGLE POSTS DATA NOW - MOVE ONTO PROCESSING THE OBJECT

			$temp_postname = sanitize_title( $title );// used to check for duplicates
			
			# IF TITLE MATCHES AN EXISTING TITLE THEN DO NOT CONTINUE - THIS IS THE FIRST DUPLICATION CHECK
			global $wpdb;	
			$count = 0;
			$wpdb->query("SELECT post_title FROM " .$wpdb->prefix . "posts WHERE post_name = '$temp_postname'");
		 	$count = $wpdb->num_rows;
			if( $count == 0 )
			{
				// currently not dynamic and default
				require('post_layouts/default.php');
				
				# MAKE CUSTOM META DATA
				$metadescription = create_meta_description_wtg_csv2post($content, 150);
				$metakeywords = create_meta_keywords_wtg_csv2post($content, 150);
																
				# CREATE POST OBJECT AND INSERT TO DATABASE
				$my_post = array();
				$my_post['post_title'] = $title;
				$my_post['post_content'] = $post;
				$my_post['post_status'] = $campaignresult->poststatus;
				$my_post['post_author'] = 1;
				if(!empty($catid)){$my_post['post_category'] = array($catid);}elseif(empty($catid)){$my_post['post_category'] = array(1);}
				$my_post['comment_status'] = 'open';
				$my_post['post_excerpt'] = $metadescription;
				$my_post['tags_input'] = $metakeywords;

				# IF TITLE MATCHES AN EXISTING TITLE THEN DO NOT CONTINUE - THIS IS THE SECOND DUPLICATION CHECK
				global $wpdb;	
				$count = 0;
				$wpdb->query("SELECT post_title FROM " .$wpdb->prefix . "posts WHERE post_name = '$temp_postname'");
				$count = $wpdb->num_rows;
				if( $count == 0 )
				{
					# NO DUPLICATES FOUND SO INJECT POST
					$post_id = wp_insert_post( $my_post );
					
					# COUNT ROWS ACTUALLY USED TO CREATE POSTS
					$posts_injected++;
									
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
					$res1 = $wpdb->get_results("SELECT identifier,value FROM " .$wpdb->prefix . "csvtopost_customfields WHERE camid = '$camid' AND type = '0'");
					
					foreach($res1 as $x)
					{   
						$key = $x->identifier;
						$value = $x->value;
						add_post_meta($post_id, $key, $value, true);
					}
									
					# INSERT CAMPAIGN CUSTOM FIELDS AND VALUES THAT MAY BE UNIQUE VALUES ARE FROM CSV COLUMN DATA
					$res2 = $wpdb->get_results("SELECT identifier,value FROM " .$wpdb->prefix . "csvtopost_customfields WHERE camid = '$camid' AND type = '1'");
					
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
					
				}// end of second duplication check
				
			}// end of first duplication check

		}// end if first row or not
		
		$rows_processed++;// used to indicate if first row (0) or not
	}// end fgetcsv while loop
	
	
	# UPDATE CAMPAIGN DATA WITH COUNTERS
	$countertotals = $wpdb->get_row("SELECT posts FROM " .$wpdb->prefix . "csvtopost_campaigns WHERE id = '$camid'");

	$posts = $countertotals->posts;
	
	$posts = $posts + $posts_injected;

	$sqlQuery = "UPDATE " .	$wpdb->prefix . "csvtopost_campaigns SET posts = '$posts'  WHERE id = '$camid'";
	$wpdb->query($sqlQuery);
	
	# UPDATE TRIAL VERSION COUNTERS
	update_option('csv2post_posts_counter_links',$posts);
	update_option('csv2post_posts_counter_ads',$posts);	
		
	fclose($handle);// close csv file
		
}// end of if file found or not
	
?>