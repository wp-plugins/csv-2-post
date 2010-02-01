<?php
function csv2post_masspostdelete()
{
	global $wpdb;
	
	@set_time_limit(21700);// maximum of six hours
	
	$totalpostdeleted = 0;
	
	// delete postmeta (attachment data included)
	$q = "DELETE FROM $wpdb->postmeta WHERE post_id IN (SELECT ID FROM $wpdb->posts WHERE post_type = 'post') ";
	$wpdb->query($q);
	
	// delete term relationships
	$q = "DELETE FROM $wpdb->term_relationships WHERE term_taxonomy_id IN (SELECT term_taxonomy_id FROM $wpdb->term_taxonomy WHERE taxonomy IN ('category', 'post_tag')) ";
	$wpdb->query($q);

	// delete final posts
	$q = "DELETE FROM $wpdb->posts WHERE post_type = 'post' ";
	$wpdb->query($q);
	$publishpostsdeleted = $wpdb->rows_affected;
	
	// delete posts starting with scheduled (status is future)
	$s = "SELECT ID FROM $wpdb->posts WHERE post_status = 'future' ";
	$rows = $wpdb->get_results($s);
	$futurepostsdeleted = 0;// use to count future posts deleted
	foreach($rows as $row) 
	{
		$loop = wp_next_scheduled('publish_future_post', array($row->ID));
		while($loop) 
		{
			wp_unschedule_event($loop, 'publish_future_post', array($row->ID));
			$loop = wp_next_scheduled('publish_future_post', array($row->ID));
			$futurepostsdeleted++;
		}
	}
	
	// now clear the actual schedule for posts as those posts have been deleted
	wp_clear_scheduled_hook('publish_future_post');
	
	// total posts delete and echo
	$totalpostsdeleted = $futurepostsdeleted + $publishpostsdeleted;
	
	messagebox_csv2post('successSmall', 'Success - ' . $totalpostdeleted . ' posts were deleted.');
}

function csv2post_masstagdelete()
{
	global $wpdb;
	
	@set_time_limit(21700);// maximum of six hours
	
	$q = "DELETE FROM $wpdb->term_relationships WHERE oterm_taxonomy_id IN (SELECT term_taxonomy_id FROM $wpdb->term_taxonomy WHERE taxonomy = 'post_tag') ";
	$wpdb->query($q);
	
	$q = "DELETE FROM $wpdb->terms WHERE term_id IN (SELECT term_id FROM $wpdb->term_taxonomy WHERE taxonomy = 'post_tag') ";
	$wpdb->query($q);
	
	$q = "DELETE FROM $wpdb->term_taxonomy WHERE taxonomy = 'post_tag' ";
	$wpdb->query($q);
	
	messagebox_csv2post('successSmall', 'Success - All tags deleted.');
}

function csv2post_masspagedelete()
{
	global $wpdb;
	
	@set_time_limit(21700);// maximum of six hours
	
	$q = "DELETE FROM $wpdb->postmeta WHERE post_id IN (SELECT ID FROM $wpdb->posts WHERE post_type = 'page') ";
	$wpdb->query($q);
	
	$q = "DELETE FROM $wpdb->posts WHERE post_type = 'page' ";
	$wpdb->query($q);
	
	messagebox_csv2post('successSmall', 'Success - ' . $wpdb->rows_affected . ' pages were deleted.');
}

function csv2post_masscategorydelete()
{
	global $wpdb;
	@set_time_limit(21700);// maximum of six hours

	// delete the term taxonomy setup for all category
	$q = "DELETE FROM $wpdb->term_taxonomy WHERE taxonomy = 'category' ";
	$wpdb->query($q);
	
	// delete term relationships
	$q = "DELETE FROM $wpdb->term_relationships WHERE oterm_taxonomy_id IN (SELECT term_taxonomy_id FROM $wpdb->term_taxonomy WHERE taxonomy = 'category') ";
	$wpdb->query($q);
	
	// delete all terms for categories
	$q = "DELETE FROM $wpdb->terms WHERE term_id IN (SELECT term_id FROM $wpdb->term_taxonomy WHERE taxonomy = 'category') ";
	$wpdb->query($q);

	messagebox_csv2post('successSmall', 'Success - All categories have been deleted.');
}

?>