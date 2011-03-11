<?php
##########################################################################
##       INTERFACE FOR PROJECT OPTIONS STAGE ON PROJECT CONFIG          ##
##########################################################################
?>

<?php
// prepare checkbox values
if( isset( $csv['conditions']['switches']['dropposts'] ) && $csv['conditions']['switches']['dropposts'] == true ){ $dpc = 'checked="checked"'; }else{ $dpc = ''; }
?>

<form method="post" name="c2pf_projectoptions_form" action="">   
	<br />
	<strong>Main Design</strong><br /><?php echo eco_maindesignsmenu( $csv ); ?>   <br /><br />

    <strong>Post Publish Date Method</strong><br />
	<select name="c2pf_datemethod" size="1" >
		<option value="default">Default</option>
        <?php
		if( isset( $csv['specials']['col']['dates_col'] ) && isset( $csv['specials']['state']['dates_col'] ) && $csv['specials']['state']['dates_col'] == 'On' )
		{
			echo '<option value="data">CSV File Data</option>';
		}		
		if( !isset( $csv['specials']['col']['dates_col'] ) || !isset( $csv['specials']['state']['dates_col'] ) 
		|| isset( $csv['specials']['state']['dates_col'] ) && $csv['specials']['state']['dates_col'] == 'Off' )
		{
			echo '<option value="increment">CSV File Data (Locked)</option>';
		}
		?>
		<option value="random">Random</option>
		<option value="increment">Increment</option>
	</select><br /><br />

    <strong>Type</strong><br />
    <input name="c2pf_type" type="text" value="<?php if(isset($csv['posttype'])){echo $csv['posttype'];}else{echo 'post';} ?>" size="20" maxlength="20" />(post,page or custom)<br /><br />

    <strong>Publisher ID</strong><br />
    <input name="c2pf_publisher" type="text" value="<?php if(isset($csv['postpublisher'])){echo $csv['postpublisher'];}else{echo 1;} ?>" size="8" maxlength="8" />(admin id is usually 1)<br /><br />

    <strong>Publish Status</strong>
    <table class="widefat post fixed">
      <tr>
        <td width="100">
            <label>
                <input type="radio" name="c2pf_publish" value="publish" id="c2pf_publish_0" 
				<?php if(isset($csv['poststatus'])&&$csv['poststatus']=='publish'){echo 'checked="checked"';}elseif(!isset($csv['poststatus'])){echo 'checked="checked"';} ?> />Publish
            </label>
        </td>
        <td width="100">
            <label>
                <input type="radio" name="c2pf_publish" value="draft" id="c2pf_publish_1" 
				<?php if(isset($csv['poststatus'])&&$csv['poststatus']=='draft'){echo 'checked="checked"';} ?> />Draft
            </label>
        </td>
        <td>
            <label>
              <input type="radio" name="c2pf_publish" value="pending" id="c2pf_publish_1" 
			  <?php if(isset($csv['poststatus'])&&$csv['poststatus']=='pending'){echo 'checked="checked"';} ?> />Pending
            </label>
        </td>
      </tr>
    </table><br />
    
    <strong>Allow Comments</strong>
    <table class="widefat post fixed">
      <tr>
        <td width="100">
            <label>
                <input type="radio" name="c2pf_comments" value="open" id="c2pf_comments_0" 
				<?php if(isset($csv['postcomments'])&&$csv['postcomments']=='open'){echo 'checked="checked"';}elseif(!isset($csv['postcomments'])){echo 'checked="checked"';} ?> />Yes
            </label>
        </td>
        <td>
            <label>
                <input type="radio" name="c2pf_comments" value="closed" id="c2pf_comments_1" 
				<?php if(isset($csv['postcomments'])&&$csv['postcomments']=='closed'){echo 'checked="checked"';} ?> />No
            </label>
        </td>
      </tr>
    </table>    
    <br />

    <strong>Allow Pings</strong>
    <table class="widefat post fixed">
      <tr>
        <td width="100">
            <label>
                <input type="radio" name="c2pf_pings" value="1" id="c2pf_pings_0" 
				<?php if(isset($csv['postpings'])&&$csv['postpings']=='1'){echo 'checked="checked"';}elseif(!isset($csv['postpings'])){echo 'checked="checked"';} ?> />Yes
            </label>
        </td>
        <td>
            <label>
                <input type="radio" name="c2pf_pings" value="0" id="c2pf_pings_1" 
				<?php if(isset($csv['postpings'])&&$csv['postpings']=='0'){echo 'checked="checked"';} ?> />No
            </label>
        </td>
      </tr>
    </table>    
    <br />

    <strong>Adopt Existing Posts</strong>
    <table class="widefat post fixed">
      <tr>
        <td width="100">
            <label>
                <input type="radio" name="c2pf_adopt" value="1" id="c2pf_adopt_0" 
				<?php if(isset($csv['postadopt'])&&$csv['postadopt']=='1'){echo 'checked="checked"';}elseif(!isset($csv['postadopt'])){echo 'checked="checked"';} ?> disabled="disabled" />Yes
            </label>
        </td>
        <td>
            <label>
                <input type="radio" name="c2pf_adopt" value="0" id="c2pf_adopt_1"
                 <?php if(isset($csv['postadopt'])&&$csv['postadopt']=='0'){echo 'checked="checked"';} ?> disabled="disabled" />No
            </label>
        </td>
      </tr>
    </table>
                    
 	<br />
    <input class="button-primary" type="submit" name="c2pf_projectoptions_submit" value="Submit" />
</form> 

<br /><br />