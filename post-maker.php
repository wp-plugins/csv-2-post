<?php
global $wpdb;	
$campaignresult = $wpdb->get_row("SELECT camfile,process,ratio,filtercolumn,id,poststatus,posts FROM " .$wpdb->prefix . "csvtopost_campaigns WHERE stage = '100'");
$filelocation = csv2post_getcsvfilesdir() . $campaignresult->camfile;
$handle = fopen("$filelocation", "r");
if($handle != false)
{
	if($campaignresult->process == 1)
	{
		$post_limit = 1000;
		set_time_limit(9000);
	}
	elseif($campaignresult->process == 2)
	{
		$post_limit = get_option('csv2post_postsperhit');
		set_time_limit(get_option('csv2post_maxstagtime'));
	}
	$row_counter = 0;
	$posts_injected = 0;
	$filterid = $campaignresult->filtercolumn;
	$camid = $campaignresult->id;
	$previously_made_posts = $campaignresult->posts;
	$rows_processed = 0;
	while (($csvrow = fgetcsv($handle, 9999, ",")) !== FALSE && $posts_injected != $post_limit)
	{ 		
		if($rows_processed != 0 && $rows_processed >= $previously_made_posts)
		{
			$column_counter_getdata = 0;
			foreach($csvrow as $data)
			{  
				$data = rtrim($data);	
				$postpart = $wpdb->get_var("SELECT postpart FROM " .$wpdb->prefix . "csvtopost_relationships WHERE csvcolumnid = '$column_counter_getdata' AND camid = '$camid'");
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
				if($filterid != 999 && $column_counter_getdata == $filterid)
				{ 
					$val = $data;// unique value from csv column
					$catid = $wpdb->get_var("SELECT catid FROM " .$wpdb->prefix . "csvtopost_categories WHERE camid = '$camid' AND uniquevalue = '$val'");
				}
				
				$column_counter_getdata++;
			}// end of foreach
			$temp_postname = sanitize_title( $title );// used to check for duplicates
			$count = 0;
			$wpdb->query("SELECT post_title FROM " .$wpdb->prefix . "posts WHERE post_name = '$temp_postname'");
		 	$count = $wpdb->num_rows;
			if( $count == 0 )
			{
				require('post_layouts/default.php');
				$metadescription = create_meta_description_wtg_csv2post($content, 150);
				$metakeywords = create_meta_keywords_wtg_csv2post($content, 150);
				$my_post = array();
				$my_post['post_title'] = $title;
				$my_post['post_content'] = $post;
				$my_post['post_status'] = $campaignresult->poststatus;
				$my_post['post_author'] = 1;
				if(!empty($catid)){$my_post['post_category'] = array($catid);}elseif(empty($catid)){$my_post['post_category'] = array(1);}
				$my_post['comment_status'] = 'open';
				$my_post['post_excerpt'] = $metadescription;
				$my_post['tags_input'] = $metakeywords;
				$count = 0;
				$wpdb->query("SELECT post_title FROM " .$wpdb->prefix . "posts WHERE post_name = '$temp_postname'");
				$count = $wpdb->num_rows;
				if( $count == 0 )
				{
					if($post_limit != 1000){}
					else{$post_id = wp_insert_post( $my_post );}
					$posts_injected++;
					$sqlQuery = "INSERT INTO " .
					$wpdb->prefix . "csvtopost_posthistory(camid, postid)
					VALUES('$camid', '$post_id')";
					$wpdb->query($sqlQuery);
					add_post_meta($post_id, '_headspace_description', $metadescription, true);
					add_post_meta($post_id, 'head_keywords', $metakeywords, true);
					add_post_meta($post_id, 'csv2post_campaignid', $camid, true);
					$res1 = $wpdb->get_results("SELECT identifier,value FROM " .$wpdb->prefix . "csvtopost_customfields WHERE camid = '$camid' AND type = '0'");
					foreach($res1 as $x)
					{   
						$key = $x->identifier;
						$value = $x->value;
						add_post_meta($post_id, $key, $value, true);
					}
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
	$countertotals = $wpdb->get_row("SELECT posts FROM " .$wpdb->prefix . "csvtopost_campaigns WHERE id = '$camid'");
	$posts = $countertotals->posts;
	$posts = $posts + $posts_injected;
	$sqlQuery = "UPDATE " .	$wpdb->prefix . "csvtopost_campaigns SET posts = '$posts'  WHERE id = '$camid'";
	$wpdb->query($sqlQuery);
	fclose($handle);// close csv file
}// end of if file found or not
	
?>