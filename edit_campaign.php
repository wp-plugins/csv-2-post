<h2>CSV 2 POST Campaign Management</h2>
<p>Here you can manage your campaigns including pause, start or undo them.</p>

<?php
/*
	CAMPAIGN STATE - Database values for wp_csv2post_campaigns (stage) 
	everything before 100 are numbers related to campaigns still being created.
	
	100 = Ongoing, processing, started
	200 = Stopped, paused, waiting
	300 = Complete, finished, ended
	400 = Cancelled, deleted
*/

# FUNCTION CREATES START, PAUSE or COMPLETE LINK FOR EACH CAMPAIGN
function wtg_csv2post_startpausecancelled($s,$c,$id)
{	// s = stage c = campaign name id = campaign id
	$SPClink = '<td><a href="';
	// First create link
	$SPClink .= $_SERVER['PHP_SELF'];
	if($s == 100)
	{
		$SPClink .= '?page=manage_campaigns&id='.$id.'&action=pause';
	}
	elseif($s == 200)
	{
		$SPClink .= '?page=manage_campaigns&id='.$id.'&action=start';
	}
	elseif($s == 300)
	{
		$SPClink .= '?page=manage_campaigns&id='.$id.'&action=complete';
	}
	
	// Meta title
	$SPClink .= '" title="';
	if($s == 100)
	{
		$SPClink .= 'Click to pause '.$c;
	}
	elseif($s == 200)
	{
		$SPClink .= 'Click to start '.$c;
	}
	elseif($s == 300)
	{
		$SPClink .= 'Campaign '.$c.' is finished.';
	}
	$SPClink .= '">';
	
	// Link text
	if($s == 100)
	{
		$SPClink .= 'Pause';
	}
	elseif($s == 200)
	{
		$SPClink .= 'Start';
	}
	elseif($s == 300)
	{
		$SPClink .= 'Complete';
	}
	
	$SPClink .= '</a></td>';
	
	echo $SPClink;
}

# FUNCTION CREATES UNDO LINK FOR EACH CAMPAIGN
function wtg_csv2post_campaignundo($s,$c,$id)
{	// s = stage c = campaign name id = campaign id
	$UNDOlink = '<td><a href="';
	
	// First part of URL is PHP SELF
	$UNDOlink .= $_SERVER['PHP_SELF'];
	// Use campaign ID and action in rest of URL
	$UNDOlink .= '?page=manage_campaigns&id='.$id.'&action=undo';
	// Start meta title
	$UNDOlink .= '" title="';
	// Meta link title
	$UNDOlink .= 'Click to undo posts created by '.$c;	
	$UNDOlink .= '">';
	// Link title/name
	$UNDOlink .= 'Undo';
	// End a href
	$UNDOlink .= '</a></td>';
	
	echo $UNDOlink;
}

# PROCESS GET ACTIONS AND DISPLAY CORRECT DATA OR MAKE UPDATES
if(isset($_GET['action']) && isset($_GET['id']))
{
	$camid = $_GET['id'];

	# PROCESS ACTION
	if($_GET['action'] == 'pause')
	{
		# PAUSE CAMPAIGN
		global $wpdb;
		$sqlQuery = "UPDATE " .
		$wpdb->prefix . "csvtopost_campaigns SET stage = '200' WHERE id = '$camid'";
		$wpdb->query($sqlQuery);
	}
	elseif($_GET['action'] == 'start')
	{
		# PAUSE CAMPAIGN
		global $wpdb;
		$sqlQuery = "UPDATE " .
		$wpdb->prefix . "csvtopost_campaigns SET stage = '100' WHERE id = '$camid'";
		$wpdb->query($sqlQuery);
	}
	elseif($_GET['action'] == 'complete')
	{
		# TO BE UPDATED
	}
	elseif($_GET['action'] == 'undo')
	{
		# SELECT ALL POSTS WITH CUSTOM FIELD = csv2post_campaignid and campaign ID
		global $wpdb;
		$row = $wpdb->get_results("SELECT postid FROM " .$wpdb->prefix . "csvtopost_posthistory WHERE camid = '$camid'");
		$counter = 0;
		$deleted_count = 0;
		foreach ($row as $post)// currently process each COLUMN i.e. 6 rows caused 66 columns and will be changed later
		{
			$x = wp_delete_post( $post->postid );
			if($x != false){$deleted_count++;}// counts actual deletions only 
		}

		# UPDATE POST COUNTER FOR THIS CAMPAIGN
		$currentposts = $wpdb->get_var("SELECT posts FROM " .$wpdb->prefix . "csvtopost_campaigns WHERE id = '$camid'");
		
		$posts_count = $currentposts - $deleted_count;
		
		$sqlQuery = "UPDATE " .
		$wpdb->prefix . "csvtopost_campaigns SET posts = '$posts_count' WHERE id = '$camid'";
		$wpdb->query($sqlQuery);
		
		echo $deleted_count.' posts have been deleted!';
	}
}

# GET ALL DATA FOR ALL CAMPAIGNS AND LIST THEM
global $wpdb;

$c = $wpdb->get_results("SELECT id,camname,stage FROM " .$wpdb->prefix . "csvtopost_campaigns");

foreach ($c as $v)
{?>
<form>
	<table width="301">
    	<tr><td width="35" height="23"><strong>ID</strong></td>
    	<td width="161"><strong>Campaign Name</strong></td><td width="89"></td></tr>
    	<tr>
        	<td><?php echo $v->id; ?></td>
            <td><?php echo $v->camname; ?></td>
            <?php wtg_csv2post_startpausecancelled($v->stage,$v->camname,$v->id); ?>
            <?php wtg_csv2post_campaignundo($v->stage,$v->camname,$v->id); ?>
        </tr>
    </table>
</form>

<?php }?>

<h3>Sponsors and Recommended Services</h3>
<script type="text/javascript"><!--
google_ad_client = "pub-4923567693678329";
/* 728x90, created 7/18/09 */
google_ad_slot = "1325545528";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>