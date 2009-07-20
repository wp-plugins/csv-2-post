<h2>CSV 2 POST Campaign Management</h2>
<p>Here you can edit, pause, delete or even restart campaigns and update previously made posts with new campaign settings!</p>
<h3>Some of these abilities have been suspended while further updates are made, thank you for your patience</h3>

<?php
# PROCESS GET ACTIONS
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
}

# GET ALL DATA FOR ALL CAMPAIGNS
global $wpdb;

$c = $wpdb->get_results("SELECT id,camname,stage FROM " .$wpdb->prefix . "csvtopost_campaigns");

foreach ($c as $v)
{?>
<form>
	<table width="362">
    	<tr><td width="35" height="23"><strong>ID</strong></td><td width="257"><strong>Name</strong></td><td></td></tr>
    	<tr>
        	<td><?php echo $v->id; ?></td>
            <td><?php echo $v->camname; ?></td>
            <td><a href="<?php $_SERVER['PHP_SELF']; if($v->stage == 100){echo'?page=manage_campaigns&id='.$v->id.'&action=pause';}elseif($v->stage == 200){echo'?page=manage_campaigns&id='.$v->id.'&action=start';}?>"><?php if($v->stage == 100){echo'Pause';}elseif($v->stage == 200){echo'Start';}?></a></td>
        </tr>
    </table>
</form>
<?php }?>