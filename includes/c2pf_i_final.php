<?php
##########################################################################
# INTERFACE FOR POST CREATION MANUAL OR STARTING,PAUSING POST CREATION   #
##########################################################################
?>

<br />
<table class="widefat post fixed">

    <form method="post" name="c2pf_updatingsettings_form" action="">            
                
        <?php 
		if( $spe[ $pro[ $pro['current'] ]['speed'] ]['import'] == 0 )
		{
			echo '<strong>You must have at least one record imported to your project database table before you can begin Post Creation</strong>';
		}
		elseif( !isset( $csv['maindesign'] ) )
		{
			echo '<strong>You must select and save a Main Design, which will act as a default when conditions or category arguments are not used
			to determine the design. Please go to Stage 7 Project Options and select your Main Design then return here to begin creating posts.';
		}
		else
		{
			// show project pause or start buttons if the project is using a spreadout campaign
			if( $spe[ $pro[ $pro['current'] ]['speed'] ]['type'] == 'spreadout' && $pro[ $pro['current'] ]['status'] == 'Active' )
			{?>
			<tr>
				<td width="200">
					<br /><input class="button-primary" type="submit" name="c2pf_pauseproject_submit" value="Pause Project" /><br /><br />
				</td>
				<td>
					<br />Pause the current project as it is on a Spreadout Speed Profile.
				</td>
			</tr>
			<?php
			}
			elseif( $spe[ $pro[ $pro['current'] ]['speed'] ]['type'] == 'spreadout' && $pro[ $pro['current'] ]['status'] == 'Paused' )
			{?>
			<tr>
				<td>
					<br /><input class="button-primary" type="submit" name="c2pf_startproject_submit" value="Start Project" /><br /><br />
				</td>
				<td>
					 <br />Start your project, will create a single post if no posts have been created for this campaign
				</td>
			</tr><?php }?>
            
			<tr>
				<td width="200">
					<br /><input class="button-primary" type="submit" name="c2pf_testpost_submit" value="Create Test Post" /><br /><br />
				</td>
				<td>
					<br />Test your configuration before creating large amounts of posts
				</td>
			</tr>
			<tr>
				<td>
					<br /><input class="button-primary" type="submit" name="c2pf_postcreation_submit" value="Run Post Creation Event" /><br /><br />
				</td>
				<td>
					<br />Run a post creation event based on your projects speed settings
				</td>
			</tr>
            
            <tr>
                <td>
                    <br /><input class="button-primary" type="submit" name="c2pf_deleteprojectposts_submit" value="Delete All Posts" disabled="disabled" /><br /><br />
                </td>
                <td>
                    <br />Deletes all your project posts and removes their ID from project table plus resets progress counters
                </td>
            </tr> 
                       
            <?php 
		}?>
        

    
    </form>   

</table>