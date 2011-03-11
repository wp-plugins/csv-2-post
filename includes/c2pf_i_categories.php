<?php
##########################################################################
##         INTERFACE FOR THE CATEGORIES STAGE ON PROJECT CONFIG         ##
##########################################################################
?>

<?php 
if( isset( $csv['singlecategory'] ) && $csv['singlecategory'] == 'NA' || !isset( $csv['singlecategory'] ) )
{
	// only display category column menus if user has not selected category splitter on special functions page
	if( isset( $csv['special']['state']['cats_col'] ) 
	&& $csv['special']['state']['cats_col'] == 'On' )
	{
		echo '<h4>Category Splitter Selected</h4><p>You have selected the Category Splitter option on the Special Functions stage. That will manage your categories
		for you. Change that setting if you wish to setup categories up manually.</p>';
	}
	elseif( isset( $csv['special']['state']['cats_col'] ) 
	&& $csv['specialfunctions']['state']['cats_col'] == 'Off'
	|| !isset( $csv['special']['state']['cats_col'] ) )
	{?>
		<h2>Create Category Groups</h2>
		<form method="post" name="c2pf_categorygroupsave_form" action="">            
		<p>Use this form to create a category group. Create as many as you like, your post may have multiple parent categories.</p>
		<table>
		  <tr><td><b>Category</b></td><td><b>CSV Columns</b></td></tr>
		  <tr><td><b><a href="#" title="">Category 1</a></b></td><td><?php c2pf_csvcolumnmenu( $pro['current'], 'c1' );?></td></tr>
		  <tr><td><b><a href="#" title="">Category 2</a></b></td><td><a href="http://www.webtechglobal.co.uk/contact">Request More Category Levels From WebTechGlobal</a></td></tr>
		  <tr><td><b><a href="#" title="">Category 3</a></b></td><td><a href="http://www.webtechglobal.co.uk/contact">Request More Category Levels From WebTechGlobal</a></td></tr>                   
		</table>
		<input class="button-primary" type="submit" name="c2pf_categorygroupsave_submit" value="Save Category Set" />
		</form><?php
	}
}?>

<br />
<br />

<?php	
// print current category groups here
if( isset( $csv['categories'] ) && !isset( $csv['singlecategory'] ) || 
isset( $csv['singlecategory'] ) && $csv['singlecategory'] == 'NA' )
{
	echo '<h2>Saved Category Groups</h2><table class="widefat post fixed">';

	$i = 0;
	foreach( $csv['categories'] as $set=>$c )
	{	
		echo '<table class="widefat post fixed">';
	
		echo '
		<tr>
			<td colspan="2"><h4>Group Number '. $i .'</h4></td><td><h4><a href="admin.php?page='. $_GET['page'] .'&catdel='. $set .'" class="button-primary">Delete Group '. $i  .'</a><h4></td>
		</tr>';	
		
		echo '
		<tr>
			<td><strong>Column ID</strong></td><td><strong>Column Name</strong></td><td><strong>Level</strong></td>
		</tr>';
		
		echo '
		<tr>
			<td>'. $c['cat1'] .'</td><td>'. @$csv['format']['titles'][$c['cat1']] .'</td><td>Category 1:</td>
		</tr>';			
				
		++$i;
		
		echo '</table><br />';
	}// end foreach categories set
}

?>

<?php 
if( isset( $csv['singlecategory'] ) && $csv['singlecategory'] == 'NA' || !isset( $csv['singlecategory'] ) )
{?>
    <h2>Create Categories Early</h2>
    <p>This function will allow you to create your categories now but it is not required.</p>
    <form method="post" name="c2pf_createcatsnow_form" action="">  
        <input class="button-primary" type="submit" name="c2pf_createcatsnow_submit" value="Create Categories Now" />
    </form><br /><?php 
}
?>

<?php 
if( isset( $csv['singlecategory'] ) && $csv['singlecategory'] == 'NA' || !isset( $csv['singlecategory'] ) )
{
	$status = 'Disabled';
}
elseif( isset( $csv['singlecategory'] ) && $csv['singlecategory'] != 'NA' )
{
	$status = 'Enabled';
}
?>
<h2>Apply Single Default Category - Currently <?php echo $status;?></h2>
<p>Use this to put all posts or pages into a single category. This will over ride all other category options and
as a result will hide the other category options. To display them again later, simply selected "Not Required" and submit..</p>
<?php c2pf_categoriesmenu( $csv );?>