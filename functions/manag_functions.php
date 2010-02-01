<?php
function csv2post_poststatus($currentsetting)
{?>
    <select name="<?php echo $name; ?>" size="1">
  	  <option value="publish" <?php if($currentsetting == 'publish'){echo 'selected="selected"';}?>>Publish</option>
  	  <option value="draft" <?php if($currentsetting == 'draft'){echo 'selected="selected"';}?>>Draft</option>
  	  <option value="pending" <?php if($currentsetting == 'pending'){echo 'selected="selected"';}?>>Pending</option>
    </select><?php 
}

function csv2post_campaignview_link($id,$name,$camid_option)
{
	echo '<td><a href="' . $_SERVER['PHP_SELF'] . '?page=managecampaigns_csv2post&viewcampaign=' . $id . '&camid_option='. $camid_option .'&action=view" title="Manage campaign '. $name .'">Manage '. $name .' </a></td>';
}

function csv2post_pausecampaign($camid)
{
	global $wpdb;
	$sqlQuery = "UPDATE " .	$wpdb->prefix . "csv2post_campaigns SET stage = '200' WHERE id = '$camid'";
	return $wpdb->query($sqlQuery);
}

function csv2post_startcampaign($camid)
{
	global $wpdb;
	$sqlQuery = "UPDATE " .	$wpdb->prefix . "csv2post_campaigns SET stage = '100' WHERE id = '$camid'";
	return $wpdb->query($sqlQuery);
}

function csv2post_deletecampaign($camid)
{
	global $wpdb;
	$sqlQuery = " DELETE FROM " . $wpdb->prefix . "csv2post_campaigns WHERE id = '$camid'";
	return $wpdb->query($sqlQuery);
}

function csv2post_camman_process($v)
{
	if($v == 1)
	{
		return 'Full (entire file)';
	}
	elseif($v == 2)
	{
		return 'Staggered (per blog hit)';
	}	
	elseif($v == 3)
	{
		return 'Scheduled (spread over 24 hours)';
	}
}

function csv2post_camman_stage($v)
{
	if($v < 100)
	{
		return 'Campaign Not Setup - Finished Creating At Stage ' . $v . '';
	}
	elseif($v == 100)
	{
		return 'Campaign Running!';
	}
	elseif($v == 200)
	{
		return 'Campaign Paused!';
	}
	elseif($v == 300)
	{
		return 'Campaign Finished!';
	}
	elseif($v == 400)
	{
		return 'Cancelled!';
	}
	elseif($v == 999)
	{
		return 'Not Used';
	}
}
?>