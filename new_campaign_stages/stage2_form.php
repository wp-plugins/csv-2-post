<h2> New Campaign Stage 2 - Count Rows<a href="http://www.csv2post.com/blog/instructions/how-to-use-new-campaign-stage-2" target="_blank"><img src="http://www.csv2post.com/images/question_small.png" width="35" height="35" alt="Get help for Stage 2" /></a></h2>

<?php			
$res1 = $wpdb->get_row("SELECT * FROM " .$wpdb->prefix . "csv2post_layouts WHERE csvfile = '$csvfilename' AND name = '$csvfilename'");
$cpl_code = $res1->code;
eval( $cpl_code );// imports functions

# OPEN CSV FILE
$handle = fopen( "$csvfiledirectory", "r" );

$stop_rows = 0;

$csvprofile = csv2post_getcsvprofile( $csvfilename );
								
while (($data = fgetcsv($handle, 5000, $csvprofile['format']['delimiter'])) !== FALSE && $stop_rows != 1)// get first csv row
{	 
	$stop_rows++;// used to limit row parsing to just 1
	?>

	<div id="poststuff" class="metabox-holder">
		<div id="post-body">
			<div id="post-body-content">
				<div class="postbox">
					<h3 class='hndle'><span>Stage 2 - Relationships</span></h3>
					<div class="inside">  
					
						<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" name="new_campaign2">
							<table width="466">
                            
                                <tr>
								   <td><a href="#" title="Tick a box to use the function, untick to not use the function in this campaign. If a box is disabled it is because you have not completed the requirements for that special function in your csv files profile.">ON/OFF</a></td>
								   <td><a href="#" title="List of the special functions in CSV 2 POST">Special Function</a></td>
								</tr>
                                
								<?php
								// count number of columns in csv file
                                $csvfile_columntotal = 0; while(isset($data[$csvfile_columntotal])){	++$csvfile_columntotal;  }
								
								function csv2post_specialfunctionstatus($v,$name,$label,$state)
								{
									if( $v != 'NA')
									{
										if( $state == 'ON' )
										{
											echo '<td><input name="' . $name . '" type="checkbox" value="1" checked /></td><td>' . $label . '</td>';
										}
										elseif( $state == 'OFF' )// user has previously set function off so display unchecked now also
										{
											echo '<td><input name="' . $name . '" type="checkbox" value="1" /></td><td>' . $label . '</td>';
										}
									}
									elseif( $v == 'NA' )
									{
										echo '<td><input name=" ' . $name . '" type="checkbox" value="1" disabled="disabled" /></td><td>' . $label . '</td>';
									}
								}
								
                                // save the profile option for this csv file using submitted values
								$i = 0;
								for ( $counter = 0; $counter <= 6; $counter += 1)		
								{
									echo '<tr>';
										if( $i == 1)
										{
											csv2post_specialfunctionstatus($csvprofile['columns']['excerpt_column'],'excerpt_column','Generate Excerpts',$csvprofile['states']['excerpt_state']);
										}
										elseif( $i == 2)
										{
											csv2post_specialfunctionstatus($csvprofile['columns']['tags_column'],'tags_column','Generate Tags',$csvprofile['states']['tags_state']);
										}
										elseif( $i == 3)
										{
											csv2post_specialfunctionstatus($csvprofile['columns']['uniqueid_column'],'uniqueid_column','Apply Unique ID Column',$csvprofile['states']['uniqueid_state']);
										}
										elseif( $i == 4)
										{
											csv2post_specialfunctionstatus($csvprofile['columns']['urlcloaking_column'],'urlcloaking_column','Apply URL Cloaking',$csvprofile['states']['urlcloaking_state']);
										}
										elseif( $i == 5)
										{
											csv2post_specialfunctionstatus($csvprofile['columns']['permalink_column'],'permalink_column','Apply Custom Permalink',$csvprofile['states']['permalink_state']);
										}
										elseif( $i == 6)
										{
											csv2post_specialfunctionstatus($csvprofile['columns']['dates_column'],'dates_column','Apply Dates Data',$csvprofile['states']['dates_state']);
										}
									echo '</tr>';
									$i++;
								}
                                ?>
                                                                                                
                                <tr>
                                    <td><input name="matchsubmit" class="button-primary" type="submit" value="Submit" /></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                
								<!-- Values submitted in stage 1 are stored here for passing through all stages -->
								<input name="csvfile_columntotal" type="hidden" value="<?php echo $csvfile_columntotal; ?>" />
								<input name="stage" type="hidden" value="2" />
								<input name="page" type="hidden" value="new_campaign" />
								<input name="csvfiledirectory" type="hidden" value="<?php echo $csvfiledirectory; ?>" />
								<input name="camid" type="hidden" value="<?php echo $camid; ?>" />
								<input name="csvfilename" type="hidden" value="<?php echo $csvfilename; ?>" />
							
							</table>
					</form>
					
					</div>  
				</div>
			</div>
		</div>
	</div>        
					
	<p>
	  <?php 

}//end while rows

fclose($handle);
?>
</p>


