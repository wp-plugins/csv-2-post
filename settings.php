<?php
$v = 1;

function csv2post_checkboxstatus1($v)
{	// echo opposite value to current value
	if($v == 0){echo 1;}else{echo 1;}
}

function csv2post_checkboxstatus2($v)
{	// echo checked or don't
	if($v == 0){}else{echo 'checked';}
}

// array for displaying list of usernames
$usernames = array(
    'orderby'          => 'display_name',
    'order'            => 'ASC',
    'multi'            => 0,
    'show'             => 'display_name',
    'echo'             => 1,
    'name'             => 'csv2post_publisherid');

?>

<div class="wrap">
    <h2>CSV 2 POST Settings (Paid Edition Only)</h2>
    <p>Instructions for the settings page are available on my blog. <a href="http://www.webtechglobal.co.uk/wordpress-articles/csv-2-post-tutorials/csv-2-post-settings-page-4569" title="Settings Page Instructions" target="_blank">Click to view CSV 2 POST settings page instructions</a>.</p>
    
    <form method="post" action="options.php">
        
    <table width="582" class="form-table">
    
        <tr><th width="421" scope="row"><h3>Plugin Setup</h3></th><td width="149"></td></tr>
        
        <tr>
            <th scope="row">Debugging Mode:</th>
            <td>
              <input name="csv2post_debugmode" type="checkbox" value="<?php csv2post_checkboxstatus1($debugmode); ?>" <?php csv2post_checkboxstatus2($debugmode); ?> />
          </td>
        </tr>
        
        <tr><th width="421" scope="row"><h3>Post Settings</h3></th><td width="149"></td></tr>
        
        <tr>
            <th scope="row">Posts Per Hit:</th>
            <td><input type="text" name="csv2post_postsperhit" value="<?php echo $postsperhit; ?>" size="3" maxlength="3" /></td>
        </tr>   

        <tr>
            <th scope="row">Default Publisher ID:</th>
            <td><?php wp_dropdown_users( $usernames );?></td>
        </tr>
                
        <tr><th scope="row"><h3>Processing Configuration</h3></th><td></td></tr>
            
        <tr>
            <th scope="row">Maximum Execution Time In Staggered Mode:</th>
            <td>
            <input type="text" name="csv2post_maxstagtime" value="<?php echo $maxstagtime; ?>" size="8" maxlength="8" />
          </td>
        </tr>

        <tr><th scope="row"><h3>SEO</h3></th><td></td></tr>

        <tr>
            <th scope="row">Allow Automatic Keyword Creation:</th>
            <td>
              <input name="csv2post_autokeywords" type="checkbox" value="<?php csv2post_checkboxstatus1($autokeywords); ?>" <?php csv2post_checkboxstatus2($autokeywords); ?> />
          </td>
        </tr>

        <tr>
            <th scope="row">Allow Automatic Description Creation:</th>
            <td>
              <input name="csv2post_autodescription" type="checkbox" value="<?php csv2post_checkboxstatus1($autodescription); ?>" <?php csv2post_checkboxstatus2($autodescription); ?> />
          </td>
        </tr>

        <tr>
            <th scope="row">Allow Automatic Tag Creation:</th>
            <td>
              <input name="csv2post_autotags" type="checkbox" value="<?php csv2post_checkboxstatus1($autotags); ?>" <?php csv2post_checkboxstatus2($autotags); ?> />
          </td>
        </tr>

        <tr>
            <th scope="row">Post TAG's Maximum Length:</th>
            <td><input type="text" name="csv2post_tagslength" value="<?php echo $tagslength; ?>" size="3" maxlength="3" /></td>
        </tr>

        <tr>
            <th scope="row">Allow Numeric Tags:</th>
            <td>
              <input name="csv2post_numerictags" type="checkbox" value="<?php csv2post_checkboxstatus1($numerictags); ?>" <?php csv2post_checkboxstatus2($numerictags); ?> />
          </td>
        </tr>
                                       
        <tr>
            <th scope="row">Default Category Parent:</th>
            <td>
            <select name="csv2post_defaultcatparent" size="1">
            <option value="0">No Parent Required</option>
            </select>
            </td>
        </tr>

        <tr><th scope="row"><h3>LocalHost BETA</h3></th><td></td></tr>
        <tr><th colspan="2" scope="row"><p>Allows publishing from your desktop installed blogs. Only use in test conditions, this is a BETA and still under construction so test at your own risk.</p></th></tr>
        <tr>
            <th scope="row">Activate LH:</th>
            <td>
              <input name="csv2post_localhostinstalled" type="checkbox" value="<?php csv2post_checkboxstatus1($localhostinstalled); ?>" <?php csv2post_checkboxstatus2($localhostinstalled); ?> />
          </td>
        </tr>

        <tr>
            <th scope="row">Default Host:</th>
            <td>
            <input type="text" name="csv2post_lhhost" value="<?php echo $lhhost; ?>" size="30" maxlength="30" />
          </td>
        </tr>

        <tr>
            <th scope="row">Default Username:</th>
            <td>
            <input type="text" name="csv2post_lhusername" value="<?php echo $lhusername; ?>" size="30" maxlength="30" />
          </td>
        </tr>

        <tr>
            <th scope="row">Default Password:</th>
            <td>
            <input type="text" name="csv2post_lhpassword" value="<?php echo $lhpassword; ?>" size="30" maxlength="30" />
          </td>
        </tr>
        
        <tr>
            <th scope="row">Default Database:</th>
            <td>
            <input type="text" name="csv2post_lhdatabase" value="<?php echo $lhdatabase; ?>" size="30" maxlength="30" />
          </td>
        </tr>

    </table>
    
    <input type="hidden" name="action" value="update" />
    
    <input type="hidden" name="page_options" value="" />
    
    <p class="submit">
        <input type="submit" class="button-primary" value="" disabled />
    </p>
    
    </form>
</div>