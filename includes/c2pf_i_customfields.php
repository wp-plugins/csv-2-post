<?php
##########################################################################
##       INTERFACE FOR CUSTOM FIELDS SETUP STAGE ON PROJECT CONFIG      ##
##########################################################################
?>

<br />

<form method="post" name="c2pf_customfields_form" action=""> 
<table>
	<tr>
    	<td><strong>Custom Fields/Meta Keys</strong></td>
        <td><strong>Assigned Data</strong></td>
        <td><strong>Data Functions</strong></td>
    </tr>
<?php
// objectcount is also the column id
global $wpdb;
$set = get_option('c2pf_set');
$pro = get_option( 'c2pf_pro' );
$csv = get_option( 'c2pf_' . $pro['current'] );

// find all possible custom fields
$result = $wpdb->get_results("SELECT DISTINCT meta_key FROM $wpdb->postmeta 
								  WHERE meta_key != '_encloseme' 
								  AND meta_key != '_wp_page_template'
								  AND meta_key != '_edit_last'
								  AND meta_key != '_edit_lock'
								  AND meta_key != '_wp_trash_meta_time'
								  AND meta_key != '_wp_trash_meta_status'
								  AND meta_key != '_wp_old_slug'
								  AND meta_key != '_pingme'
								  AND meta_key != '_thumbnail_id'
								  AND meta_key != '_wp_attachment_image_alt'
								  AND meta_key != '_wp_attachment_metadata'
								  AND meta_key != '_wp_attached_file'");

# UPGRADE TO ALLOW MANUAL UPDATE ON EXCLUDED CUSTOM FIELD KEYS

// put excluded keys in array 		
$exclusions = array('c2pf_filename', 'c2pf_lastupdate', 'c2pf_poststate','c2pf_recordid','c2pf_tablename',
'_edit_last','_edit_lock','_wp_trash_meta_status','_wp_trash_meta_time','c2pf_clicks_url1','c2pf_cloakedurl1');

// start value for building array of found custom meta keys
$foundcf = array();

$cfcount = 0;

// loop through each custom field found
foreach ($result as $customfield) 
{
	// put custom field key into variable
	$cfkey = $customfield->meta_key;

	// add cf key found array
	$foundcf[] = $cfkey;
	
	// key if meta key is in exclusion array
	if( !in_array( $cfkey, $exclusions) )
	{
		// column holding text field for entering custom field key
		$row = '
		<tr>
			<td>
				<input name="cf_'.$cfcount.'" type="text" value="'.$cfkey.'" size="40" maxlength="40"><br />
			</td>';
			
			// column holding csv column menus
			$row .= '<td>';
			$row .= c2pf_csvcolumnmenu_customfields( $csv, $cfcount, $cfkey );
			$row .= '</td>';
			
			// column holding data function menus
			$row .= '<td>';
			$row .= c2pf_datafunctions_customfields( $cfcount );
			$row .= '</td>
		</tr>';			
		
		echo $row;
		
		++$cfcount;
	}	
}

// add users previously saved custom field meta keys - only if not already automatically pulled in i.e after 1st post created
if( isset( $csv['customfields'] ) )
{
	foreach( $csv['customfields'] as $key => $column)
	{
		if( !in_array( $key, $foundcf ) )
		{
			// column holding text field for entering custom field key
			$row = '
			<tr>
				<td>
					<input name="cf_'.$cfcount.'" type="text" value="'.$key.'" size="40" maxlength="40"><br />
				</td>';
				
				// column holding csv column menus
				$row .= '<td>';
				$row .= c2pf_csvcolumnmenu_customfields( $csv, $cfcount, $key );
				$row .= '</td>';
				
				// column holding data function menus
				$row .= '<td>';
				$row .= c2pf_datafunctions_customfields( $cfcount );
				$row .= '</td>
			</tr>';			
			
			// display 
			echo $row;
			
			// increase found and displayed counter
			++$cfcount;		
		}
	}
}

// add blank fields for manual custom field entry - number depending on existing meta keys
if( $cfcount > 20 ){ $total = 23; }
elseif( $cfcount > 15 ){ $total = 20; }
elseif( $cfcount > 10 ){ $total = 20; }
elseif( $cfcount > 5 ){ $total = 20; }
else{ $total = 20; }
// loop number of required fields
while( $cfcount < $total )
{
	// column holding text field for entering custom field key
	$row = '
	<tr>
		<td>
			<input name="cf_'.$cfcount.'" type="text" value="" size="40" maxlength="40"><br />
		</td>';
		
		// column holding csv column menus
		$row .= '<td>';
		$row .= c2pf_csvcolumnmenu_customfields( $csv, $cfcount, '' );
		$row .= '</td>';
		
		// column holding data function menus
		$row .= '<td>';
		$row .= c2pf_datafunctions_customfields( $cfcount );
		$row .= '</td>
	</tr>';		

	++$cfcount;
	echo $row;
}
		
// put the custom field count ( $cfcount ) into hidden field, used for processing loop
echo '<input name="cfcount" type="hidden" value="'.$cfcount.'" />';

?>
</table>

<br>
<input class = "button-primary" type = "submit" name = "c2pf_customfields_submit" value = "Save Changes" />

</form>

<br />
