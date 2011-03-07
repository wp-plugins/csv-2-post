<?php c2pf_header(); ?>       

<?php
$spe = get_option('c2pf_spe'); 

// save speed submission - pass array object
if( isset( $_POST['c2pf_updatespeed_submit'] ) )
{
	echo 'Cannot Change Speed Profiles In Free Edition Please Hire WebTechGlobal And Get The Full Support Edition';
}

if( isset( $_POST['c2pf_speedelete_submit'] ) )
{
	c2pf_deletespeed( $_POST['c2pf_speedprofile'] );
}

// get data arrays after processing
$spe = get_option('c2pf_spe'); 
$set = get_option('c2pf_set'); 
?>

<div class="wrap">

	<h2>CSV 2 POST Event Speeds</h2>
		<div id="poststuff" class="meta-box-sortables" style="position: relative; margin-top:10px;">
		
		<?php
		// if $_GET['config'] value passed, display that config for editing
		if( isset( $_POST['c2pf_speedselect_submit'] ) || isset( $_POST['c2pf_updatespeed_submit'] ) )
		{
			$sp = $_POST['c2pf_speedname'];
			
			?>
			<div class="postbox">
				<div class="handlediv" title="Click to toggle"><br /></div>
				<h3>Edit Speed Profile <?php echo $spe[$sp]['label'];?></h3>
				<div class="inside">
                
					<table class="widefat post fixed">
    					<form method="post" name="c2pf_updatespeed_form" action=""> 
                        	<input name="c2pf_speedname" type="hidden" value="<?php echo $sp;?>">
                            <tr>
                                <td width="100">Reduce Time (seconds) (not used in free edition)</td>
                                <td>The value you enter here now, will be deducted from the Next Event time to bring it forward</td>
                                <td><input id="reduce" name="reduce" type="text" value="" size="8" maxlength="8" disabled="disabled"></td>
                            </tr>
                            
                            <tr>
                                <td width="100">Event Delay (not used in free edition)</td>
                                <td>Number of seconds plugin waits before running any scheduled event for this project</td>
                                <td><input id="delay" name="eventdelay" type="text" value="<?php echo $spe[$sp]['eventdelay'];?>" size="8" maxlength="8" disabled="disabled"></td>
                            </tr>
                            
                            <tr>
                                <td>Create #</td>
                                <td>Number of posts/pages to create on the event time</td>
                                <td><input id="create" name="create" type="text" value="<?php echo $spe[$sp]['create'];?>" size="8" maxlength="8"></td>
                            </tr>
                            
                            <tr>
                                <td>Import #</td>
                                <td>Number of csv file rows to import on the event time</td>
                                <td><input id="import" name="import" type="text" value="<?php echo $spe[$sp]['import'];?>" size="8" maxlength="8"></td>
                            </tr>
                            
                            <tr>
                                <td>Update #</td>
                                <td>Number of posts to update on the event time</td>
                                <td><input id="update" name="update" type="text" value="<?php echo $spe[$sp]['update'];?>" size="8" maxlength="8"></td>
                            </tr>                            
 							
                            </table><br />
                            <input class="button-primary" type="submit" name="c2pf_updatespeed_submit" value="Save" />						
                                                        
                        </form>
                    	
                        <h4>Future Events Based On Above Settings</h4>
						<table class="widefat post fixed">
                        	<tr>
                            	<td width="25"></td>
                                <td width="175"><strong>Due Date/Time</strong></td>
                                <td><strong>Priority Action</strong></td>
                            </tr>                        	
                            <tr>
                            	<td></td>
                                <td>No Schedule System In Free Edition</td>
                                <td></td>
                            </tr>
                       </table>
				</div>
			</div><?php 
		}
		?>

		<div class="postbox">
			<div class="handlediv" title="Click to toggle"><br /></div>
			<h3>Speed Profile List</h3>
			<div class="inside">
				<p>				
					<form method="post" name="c2pf_speedselect_form" action=""> 
						<?php c2pf_speedprofilelist(); ?><br />
						<input class = "button-primary" type = "submit" name = "c2pf_speedselect_submit" value = "Open" />
						<input class = "button-primary" type = "submit" name = "c2pf_speedelete_submit" value = "Delete" />
					</form>
				</p>	
			</div>
		</div>
		
	</div>
	
</div>

<?php c2pf_footer(); ?>