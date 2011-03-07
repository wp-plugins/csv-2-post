<?php c2pf_header();?> 

<?php
// get options data before processing
$pro = get_option('c2pf_pro');
$set = get_option('c2pf_set');

// activate log file
if( isset( $_POST['activatelog'] ) )
{
	$set['log'] = 'Yes';
	if(update_option( 'c2pf_set',$set )){c2pf_mes( 'Log File Activated','The plugin will make entries to the log file for all major procedures.' );}
}

// disable log file
if( isset( $_POST['disablelog'] ) )
{
	$set['log'] = 'No';
	if(update_option( 'c2pf_set',$set )){c2pf_mes( 'Log File Disabled','The plugin no longer add new entries to the log file.' );}
}

// delete log file
if( isset( $_POST['deletelog'] ) )
{
	if( unlink( C2PPATH.'log.csv' ) )
	{
		c2pf_mes( 'Log File Deleted','The log file will be created again automatically unless
				logging has been turned off.' );
	}
	else
	{
		c2pf_err( 'Failed To Delete Log File','The log file could not be deleted, it could
				possibly be in use. Please try again then seek support after confirming
				the file is actually on your server inside this plugins folder.' );
	}
}

// get options data after processing
$pro = get_option('c2pf_pro');
$set = get_option('c2pf_set');?>

    <div class="handlediv" title="Click to toggle"><br /></div>
    <h3 class='hndle'><span>Log File</span></h3>
    <div class="inside">
        <p>Your log file will automatically be deleted when it reaches a size of 300kb, this can be adjusted on request.</p>
        
        <form method="post" name="c2pf_log_form" action="">            
            <table class="widefat post fixed">
               
                <tr><td><b>Action</b></td><td><b>Description</b></td></tr>
                <tr>
                    <td><input class="button-primary" type="submit" name="activatelog" value="Activate Log File" /></td>
                    <td>Use this to being creating a log of everything the plugin does, it will help you confirm automated procedures happen.<br /></td>
                </tr>                 
                <tr>
                    <td><input class="button-primary" type="submit" name="deletelog" value="Delete Log File" /></td>
                    <td>Delete log file. It will automatically be created if you have not turned logging off on the Advanced Options panel.<br /></td>
                </tr>                   
                
            </table>
        </form>              
                
    </div>
                
<?php
if( !isset( $set['log'] ) || $set['log'] != 'Yes' )
{
	echo '<strong>You have not actived the Log yet.</strong>';?>

	<?php 
}
elseif( isset( $set['log'] ) || $set['log'] == 'Yes' )
{
	if ( !file_exists( C2PPATH.'log.csv' ) ) 
	{
		// do not display this message if user has just deleted the log
		if( !isset( $_POST['deletelog'] ) )
		{
			c2pf_mes( 'Log File Not Created','No log file exists because it has either been deleted or no log entries have been made yet.' );
		}
	}
	else
	{
		c2pf_pearcsv_include();
	
		// csv file row counter
		$rows = 0;
	
		// use pear to read csv file
		$conf = File_CSV::discoverFormat(  C2PPATH.'log.csv'  );
		
		// apply seperator
		$conf['sep'] = ',';	
		
	    echo '<table class="widefat post fixed">
		<tr>
			<td width="35"></td>
			<td width="80">Date</td>
			<td width="80">Action</td>
			<td>Description</td>
			<td width="125">Project</td>
			<td>Priority</td>
		</tr>';
		
		$entry = 1;

		$grey = 0;
		$white = 1;

		// loop through records until speed profiles limit is reached then do exit
		while ( ( $r = File_CSV::read(  C2PPATH.'log.csv' , $conf ) ) ) 
		{	
			if( $rows != 0 )
			{
				// syle rotator
				if( $r[4] == 'Critical' )
				{
					echo '<tr style="background-color:#F75D59;border:17px solid #aaaaaa;padding:1em;">';
				}
				elseif( isset( $lasttime ) && $lasttime == $r[0] )
				{
					echo '<tr style="background-color:'.$lastcol.';border:17px solid #aaaaaa;padding:1em;">';
				}
				else
				{
					if( $grey == 1 )
					{					
						echo '<tr style="background-color:#D3D3D3;border:17px solid #aaaaaa;padding:1em;">';
						$grey = 0;
						$white = 1;
						$lastcol = '#D3D3D3';
					}
					elseif( $white == 1 )
					{
						echo '<tr>';
						$grey = 1;$white = 0;
						$lastcol = '#FFFFFF';
					}
				}
				
				echo '<td>'.$entry.'</td>';
				echo '<td>'.$r[0].'</td>';
				echo '<td>'.$r[1].'</td>';
				echo '<td>'.$r[2].'</td>';
				echo '<td>'.$r[3].'</td>';
				echo '<td>'.$r[4].'</td>';
				echo '</tr>';
				
				// put last time value into variable for comparing to the next
				$lasttime = $r[0];
				
				++$entry;
			}
			
			++$rows;
		}
		
		echo '</table>';
	}
}
?>

<?php c2pf_footer(); ?>
