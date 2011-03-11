<?php
##########################################################################
##  INTERFACE + INCLUDED SCRIPT FOR THE UPDATE STAGE ON PROJECT CONFIG  ##
##########################################################################
?>
<br />

<div id="dashboard_recent_comments" class="postbox closed" >
    <div class="handlediv" title="Click to toggle"><br /></div>
    <h3 class='hndle'><span>Upload New CSV File For Update</span></h3>
    <div class="inside">
        <form method="post" enctype="multipart/form-data" name="c2pf_uploadnewfile_form" class="form-table">
            <input type="file" name="file" size="70" /><br /><br />
            <input class="button-primary" type="submit" value="Upload CSV File" name="c2pf_uploadnewfile_submit" disabled="disabled" />
        </form>     
    </div>
</div>                    
                    
                    
<div id="dashboard_recent_comments" class="postbox closed" >
    <div class="handlediv" title="Click to toggle"><br /></div>
    <?php if( isset( $csv['updating']['ready'] ) && $csv['updating']['ready'] == true ){$settingsstatus = ' ---- Ready';}
	elseif( !isset( $csv['updating']['ready'] ) || $csv['updating']['ready'] == false ){$settingsstatus = ' ---- Not Ready (required for updating)';}?>
    <h3 class='hndle'><span>Unique Key <?php echo $settingsstatus;?></span></h3>
    <div class="inside">
        <p>You must not use columns that may have different values per record. Your unique key must be
        made up of columns that never change i.e. product id, url.</p>
		<form method="post" name="c2pf_uniquekey_form" action="">            
			<table class="widefat post fixed">                
				<tr><td width="100"><b>Reference</b></td><td><b>CSV Columns</b></td></tr>
				<tr><td><b>Main Key</b></td><td><?php c2pf_csvcolumnmenu_updatekey( $pro['current'], '1' );?></td></tr>
				<tr><td><b>Sub-Key 1</b></td><td><?php c2pf_csvcolumnmenu_updatekey( $pro['current'], '2' );?></td></tr>
				<tr><td><b>Sub-Key 2</b></td><td><?php c2pf_csvcolumnmenu_updatekey( $pro['current'], '3' );?></td></tr>                      	   
			</table>
			<input class="button-primary" type="submit" name="c2pf_uniquekey_submit" value="Save &amp; Test Key" disabled="disabled" />
		</form>   
    </div>
</div>

<div id="dashboard_recent_comments" class="postbox closed">
    <div class="handlediv" title="Click to toggle"><br /></div>
    <h3 class='hndle'><span>Column Exclusions <?php echo c2pf_columnexclusionsstatus( $pro['current']  ); ?></span></h3>
    <div class="inside">
    <br />
       <form method="post" name="c2pf_updateexclusion_form" action="">            
			<table class="widefat post fixed">                
            <tr><td width="175"><b>Column Titles</b></td><td><b>Include/Exclude</b></td></tr>
                <?php	
                $columnid = 0;
                foreach($csv['format']['titles'] as $column)
                {
                    ?><tr>
                            <td><strong><?php echo $column; ?></strong></td>
                            <td><?php echo c2pf_exclusionmenu( $column,$pro['current'] ); ?></td>
                        </tr>
                    <?php 
                    ++$columnid;
                }
                ?>
            </table>
            <input class="button-primary" type="submit" name="c2pf_columnexclusions_submit" value="Save" disabled="disabled" />
        </form> 
        
    </div>
</div>

<div id="dashboard_recent_comments" class="postbox closed" >
    <div class="handlediv" title="Click to toggle"><br /></div>
    <h3 class='hndle'>
        <span>Update Settings
       		<?php if( isset( $csv['updating']['updateposts'] ) && $csv['updating']['updateposts'] == 'Yes' ){ echo ' ---- Post Updating Active';}
       		elseif( !isset( $csv['updating']['updateposts'] ) || $csv['updating']['updateposts'] == 'No' ){ echo ' ---- Post Updating Disabled';}?>
        </span>
    </h3>
    <div class="inside">
		<form method="post" name="c2pf_updatingsettings_form" action="">            
			<table>
				<tr>
					<td><b>Update Posts Automatically</b></td>
					<td>                   
						<select name="c2pf_updateposts" size="1" >
						  <option value="Yes" <?php if(isset($csv['updating']['updateposts'])){c2pf_selected('Yes',$csv['updating']['updateposts']);}?>>Yes</option>
						  <option value="No" <?php if(isset($csv['updating']['updateposts'])){c2pf_selected('No',$csv['updating']['updateposts']);}?>>No</option>
						</select></td>
				</tr>   	   
				<tr>
					<td><b>Process New Files Automatically</b></td>
					<td>                   
						<select name="c2pf_autonewfile" size="1" >
						  <option value="Yes" <?php if(isset($csv['updating']['autonewfile'])){c2pf_selected('Yes',$csv['updating']['autonewfile']);}?>>Yes</option>
						  <option value="No" <?php if(isset($csv['updating']['autonewfile'])){c2pf_selected('No',$csv['updating']['autonewfile']);}?>>No</option>
						</select>
                    </td>
				</tr>				 				 	   
			</table>
			<input class="button-primary" type="submit" name="c2pf_updatingsettings_submit" value="Save" disabled="disabled" />
		</form>   
    </div>
</div>
