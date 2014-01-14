<?php
/** 
 * Free edition file (applies to paid also) for CSV 2 POST plugin by WebTechGlobal.co.uk
 * 
 * This file is used in all WebTechGlobal plugins. Changes should apply to all. Use a different file/screen for plugin specific requirements.
 *
 * @package CSV 2 POST
 * 
 * @author Ryan Bayne | ryan@webtechglobal.co.uk
 * 
 * 1. URL search ability
 * 2. Stores last search
 */
 
global $wpdb;

$search_headers_array = csv2post_logscreen_defaultarray();
$search_headers_array = csv2post_logscreen_setcriteria($search_headers_array);
$search_headers_array = csv2post_logscreen_setcolumns($search_headers_array);
$query_results = csv2post_logscreen_query($search_headers_array);

if(!$csv2post_is_free){
    echo '<br>';

    echo csv2post_link_nonced('csv2post','logsearchpostcreation','Search log for post creation related log entries','Scheduled Post Creation','&csv2posttab=12&csv2postlogsearch=normal&categorycriteria=postcreation');

    echo csv2post_link_nonced('csv2post','logsearchpostcreationstrict','Search log for entries where posts were created','Scheduled Post Creation (strict)','&csv2posttab=12&csv2postlogsearch=normal&categorycriteria=postcreation&prioritycriteria=medium');

    echo csv2post_link_nonced('csv2post','logsearchpostcreationstrict','Search log for entries where posts were updated','Scheduled Post Update','&csv2posttab=12&csv2postlogsearch=normal&categorycriteria=postupdate&prioritycriteria=medium');

    echo '<br><br>';
}

++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'logsearchoptions';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Stored Search Criteria');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_state'] = 'closed';
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);               
?>
<?php csv2post_panel_header( $panel_array );?> 

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);?>

    <p>This panel and these options are not affected by URL searches. These options belong to your custom search criteria which this screen defaults to
    when loading.</p>
    
    <h4>Outcomes</h4>
    <label for="csv2post_log_outcomes_success"><input type="checkbox" name="csv2post_log_outcome[]" id="csv2post_log_outcomes_success" value="1" <?php if(isset($csv2post_adm_set['log']['logscreen']['outcomecriteria']['1'])){echo 'checked';} ?>> Success</label>
    <br> 
    <label for="csv2post_log_outcomes_fail"><input type="checkbox" name="csv2post_log_outcome[]" id="csv2post_log_outcomes_fail" value="0" <?php if(isset($csv2post_adm_set['log']['logscreen']['outcomecriteria']['0'])){echo 'checked';} ?>> Fail/Rejected</label>

    <h4>Type</h4>
    <label for="csv2post_log_type_general"><input type="checkbox" name="csv2post_log_type[]" id="csv2post_log_type_general" value="general" <?php if(isset($csv2post_adm_set['log']['logscreen']['typecriteria']['general'])){echo 'checked';} ?>> General</label>
    <br>
    <label for="csv2post_log_type_error"><input type="checkbox" name="csv2post_log_type[]" id="csv2post_log_type_error" value="error" <?php if(isset($csv2post_adm_set['log']['logscreen']['typecriteria']['error'])){echo 'checked';} ?>> Errors</label>
    <br>
    <label for="csv2post_log_type_trace"><input type="checkbox" name="csv2post_log_type[]" id="csv2post_log_type_trace" value="flag" <?php if(isset($csv2post_adm_set['log']['logscreen']['typecriteria']['flag'])){echo 'checked';} ?>> Trace</label>

    <h4>Priority</h4>
    <label for="csv2post_log_priority_low"><input type="checkbox" name="csv2post_log_priority[]" id="csv2post_log_priority_low" value="low" <?php if(isset($csv2post_adm_set['log']['logscreen']['prioritycriteria']['low'])){echo 'checked';} ?>> Low</label>
    <br>
    <label for="csv2post_log_priority_normal"><input type="checkbox" name="csv2post_log_priority[]" id="csv2post_log_priority_normal" value="normal" <?php if(isset($csv2post_adm_set['log']['logscreen']['prioritycriteria']['normal'])){echo 'checked';} ?>> Normal</label>
    <br>
    <label for="csv2post_log_priority_high"><input type="checkbox" name="csv2post_log_priority[]" id="csv2post_log_priority_high" value="high" <?php if(isset($csv2post_adm_set['log']['logscreen']['prioritycriteria']['high'])){echo 'checked';} ?>> High</label>
    
    <h1>Custom Search</h1>
    <p>This search criteria is not currently stored, it will be used on the submission of this form only.</p>
 
    <h4>Page</h4>
    <select name="csv2post_pluginpages_logsearch" id="csv2post_pluginpages_logsearch" >
        <option value="notselected">Do Not Apply</option>
        <?php
        $current = '';
        if(isset($csv2post_adm_set['log']['logscreen']['page']) && $csv2post_adm_set['log']['logscreen']['page'] != 'notselected'){
            $current = $csv2post_adm_set['log']['logscreen']['page'];
        } 
        csv2post_GUI_plugin_page_menuoptions($current);?> 
    </select>
    
    <h4>Action</h4> 
    <select name="csv2pos_logactions_logsearch" id="csv2pos_logactions_logsearch" >
        <option value="notselected">Do Not Apply</option>
        <?php 
        $current = '';
        if(isset($csv2post_adm_set['log']['logscreen']['action']) && $csv2post_adm_set['log']['logscreen']['action'] != 'notselected'){
            $current = $csv2post_adm_set['log']['logscreen']['action'];
        }
        $action_results = csv2post_WP_SQL_log_queryactions($current);
        if($action_results){
            foreach($action_results as $key => $action){
                $selected = '';
                if($action['action'] == $current){
                    $selected = 'selected="selected"';
                }
                echo '<option value="'.$action['action'].'" '.$selected.'>'.$action['action'].'</option>'; 
            }   
        }?> 
    </select>
    
    <h4>Screen Name</h4>
    <select name="csv2post_pluginscreens_logsearch" id="csv2post_pluginscreens_logsearch" >
        <option value="notselected">Do Not Apply</option>
        <?php 
        $current = '';
        if(isset($csv2post_adm_set['log']['logscreen']['screen']) && $csv2post_adm_set['log']['logscreen']['screen'] != 'notselected'){
            $current = $csv2post_adm_set['log']['logscreen']['screen'];
        }
        csv2post_GUI_plugin_screens_menuoptions($current);?> 
    </select>
          
    <h4>PHP Line</h4>
    <input type="text" name="csv2post_logcriteria_phpline" value="<?php if(isset($csv2post_adm_set['log']['logscreen']['line'])){echo $csv2post_adm_set['log']['logscreen']['line'];} ?>">
    
    <h4>PHP File</h4>
    <input type="text" name="csv2post_logcriteria_phpfile" value="<?php if(isset($csv2post_adm_set['log']['logscreen']['file'])){echo $csv2post_adm_set['log']['logscreen']['file'];} ?>">
    
    <h4>PHP Function</h4>
    <input type="text" name="csv2post_logcriteria_phpfunction" value="<?php if(isset($csv2post_adm_set['log']['logscreen']['function'])){echo $csv2post_adm_set['log']['logscreen']['function'];} ?>">
    
    <h4>Panel Name</h4>
    <input type="text" name="csv2post_logcriteria_panelname" value="<?php if(isset($csv2post_adm_set['log']['logscreen']['panelname'])){echo $csv2post_adm_set['log']['logscreen']['panelname'];} ?>">

    <h4>IP Address</h4>
    <input type="text" name="csv2post_logcriteria_ipaddress" value="<?php if(isset($csv2post_adm_set['log']['logscreen']['ipaddress'])){echo $csv2post_adm_set['log']['logscreen']['ipaddress'];} ?>">
   
    <h4>User ID</h4>
    <input type="text" name="csv2post_logcriteria_userid" value="<?php if(isset($csv2post_adm_set['log']['logscreen']['userid'])){echo $csv2post_adm_set['log']['logscreen']['userid'];} ?>">    
  
    <h4>Display Fields</h4>                                                                                                                                        
    <label for="csv2post_logfields_outcome"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_outcome" value="outcome" <?php if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['outcome'])){echo 'checked';} ?>> Outcome</label>
    <br>
    <label for="csv2post_logfields_line"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_line" value="line" <?php if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['line'])){echo 'checked';} ?>> Line</label>
    <br>
    <label for="csv2post_logfields_file"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_file" value="file" <?php if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['file'])){echo 'checked';} ?>> File</label> 
    <br>
    <label for="csv2post_logfields_function"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_function" value="function" <?php if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['function'])){echo 'checked';} ?>> Function</label>
    <br>
    <label for="csv2post_logfields_sqlresult"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_sqlresult" value="sqlresult" <?php if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['sqlresult'])){echo 'checked';} ?>> SQL Result</label>
    <br>
    <label for="csv2post_logfields_sqlquery"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_sqlquery" value="sqlquery" <?php if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['sqlquery'])){echo 'checked';} ?>> SQL Query</label>
    <br>
    <label for="csv2post_logfields_sqlerror"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_sqlerror" value="sqlerror" <?php if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['sqlerror'])){echo 'checked';} ?>> SQL Error</label>
    <br>
    <label for="csv2post_logfields_wordpresserror"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_wordpresserror" value="wordpresserror" <?php if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['wordpresserror'])){echo 'checked';} ?>> Wordpress Error</label>
    <br>
    <label for="csv2post_logfields_screenshoturl"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_screenshoturl" value="screenshoturl" <?php if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['screenshoturl'])){echo 'checked';} ?>> Screenshot URL</label>
    <br>
    <label for="csv2post_logfields_userscomment"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_userscomment" value="userscomment" <?php if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['userscomment'])){echo 'checked';} ?>> Users Comment</label>
    <br>
    <label for="csv2post_logfields_page"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_page" value="page" <?php if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['page'])){echo 'checked';} ?>> Page</label>
    <br>
    <label for="csv2post_logfields_version"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_version" value="version" <?php if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['version'])){echo 'checked';} ?>> Plugin Version</label>
    <br>
    <label for="csv2post_logfields_panelname"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_panelname" value="panelname" <?php if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['panelname'])){echo 'checked';} ?>> Panel Name</label>
    <br>
    <label for="csv2post_logfields_tabscreenname"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_tabscreenname" value="tabscreenname" <?php if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['outcome'])){echo 'checked';} ?>> Screen Name *</label>
    <br>
    <label for="csv2post_logfields_dump"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_dump" value="dump" <?php if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['dump'])){echo 'checked';} ?>> Dump</label>
    <br>
    <label for="csv2post_logfields_ipaddress"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_ipaddress" value="ipaddress" <?php if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['ipaddress'])){echo 'checked';} ?>> IP Address</label>
    <br>
    <label for="csv2post_logfields_userid"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_userid" value="userid" <?php if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['userid'])){echo 'checked';} ?>> User ID</label>
    <br>
    <label for="csv2post_logfields_comment"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_comment" value="comment" <?php if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['comment'])){echo 'checked';} ?>> Developers Comment</label>
    <br>
    <label for="csv2post_logfields_type"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_type" value="type" <?php if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['type'])){echo 'checked';} ?>> Type</label>
    <br>
    <label for="csv2post_logfields_category"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_category" value="category" <?php if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['category'])){echo 'checked';} ?>> Category</label>
    <br>
    <label for="csv2post_logfields_action"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_action" value="action" <?php if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['action'])){echo 'checked';} ?>> Action</label>
    <br>
    <label for="csv2post_logfields_priority"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_priority" value="priority" <?php if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['priority'])){echo 'checked';} ?>> Priority</label> 
    <br>
    <label for="csv2post_logfields_thetrigger"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_thetrigger" value="thetrigger" <?php if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['thetrigger'])){echo 'checked';} ?>> Trigger</label> 
                
    <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>

<?php csv2post_panel_footer();?>

<?php       
if(!$query_results || empty($query_results)){
    echo '<strong>There are no log entries matches your current search criteria.</strong>';
    
}else{
    
    csv2post_GUI_tablestart();
    echo ' 
    <thead>
        <tr>';
        
            echo '<th>rowid</th>'; 
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['outcome']) || isset($_GET['outcomecriteria'])){ echo '<th>outcome</th>'; }
            echo '<th>timestamp</th>';
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['category']) || isset($_GET['categorycriteria'])){ echo '<th>category</th>';}
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['action'])){ echo '<th>action</th>';}        
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['line'])){ echo '<th>line</th>'; }  
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['file'])){ echo '<th>file</th>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['function'])){ echo '<th>function</th>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['sqlresult'])){ echo '<th>sqlresult</th>'; }  
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['sqlquery'])){ echo '<th>sqlquery</th>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['sqlerror'])){ echo '<th>sqlerror</th>'; }  
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['wordpresserror'])){ echo '<th>wordpresserror</th>'; }  
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['screenshoturl'])){ echo '<th>screenshoturl</th>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['userscomment'])){ echo '<th>userscomment</th>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['page'])){ echo '<th>page</th>'; }  
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['version'])){ echo '<th>version</th>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['panelname'])){ echo '<th>panelname</th>'; }  
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['tabscreenid'])){ echo '<th>tabscreenid</th>'; }  
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['tabscreenname'])){ echo '<th>tabscreenname</th>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['dump'])){ echo '<th>dump</th>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['ipaddress'])){ echo '<th>ipaddress</th>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['userid'])){ echo '<th>userid</th>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['comment'])){ echo '<th>comment</th>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['type']) || isset($_GET['typecriteria'])){ echo '<th>type</th>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['priority'])){ echo '<th>priority</th>';}                                    
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['thetrigger'])){ echo '<th>thetrigger</th>';}
            
        echo '</tr>
    </thead>'; 

    echo '
    <tfoot>
        <tr>';
        
            echo '<th>rowid</th>';
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['outcome'])){ echo '<th>outcome</th>'; }
            echo '<th>timestamp</th>';
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['category']) || isset($_GET['categorycriteria'])){ echo '<th>category</th>';}
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['action'])){ echo '<th>action</th>';}        
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['line'])){ echo '<th>line</th>'; }  
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['file'])){ echo '<th>file</th>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['function'])){ echo '<th>function</th>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['sqlresult'])){ echo '<th>sqlresult</th>'; }  
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['sqlquery'])){ echo '<th>sqlquery</th>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['sqlerror'])){ echo '<th>sqlerror</th>'; }  
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['wordpresserror'])){ echo '<th>wordpresserror</th>'; }  
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['screenshoturl'])){ echo '<th>screenshoturl</th>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['userscomment'])){ echo '<th>userscomment</th>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['page'])){ echo '<th>page</th>'; }  
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['version'])){ echo '<th>version</th>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['panelname'])){ echo '<th>panelname</th>'; }  
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['tabscreenid'])){ echo '<th>tabscreenid</th>'; }  
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['tabscreenname'])){ echo '<th>tabscreenname</th>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['dump'])){ echo '<th>dump</th>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['ipaddress'])){ echo '<th>ipaddress</th>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['userid'])){ echo '<th>userid</th>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['comment'])){ echo '<th>comment</th>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['type'])){ echo '<th>type</th>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['priority'])){ echo '<th>priority</th>';}                                                      
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['thetrigger'])){ echo '<th>thetrigger</th>';}
            
        echo '</tr>
    </tfoot>
    <tbody>';

    foreach($query_results as $key => $row){

        echo '<tr>';
        
            echo '<td>'.$row['rowid'].'</td>';
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['outcome'])){ echo '<td>'.$row['outcome'].'</td>'; }
            echo '<td>'.$row['timestamp'].'</td>';
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['category']) || isset($_GET['categorycriteria'])){ echo '<td>'.$row['category'].'</td>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['action'])){ echo '<td>'.$row['action'].'</td>'; }        
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['line'])){ echo '<td>'.$row['line'].'</td>'; }  
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['file'])){ echo '<td>'.$row['file'].'</td>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['function'])){ echo '<td>'.$row['function'].'</td>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['sqlresult'])){ echo '<td>'.$row['sqlresult'].'</td>'; }  
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['sqlquery'])){ echo '<td>'.$row['sqlquery'].'</td>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['sqlerror'])){ echo '<td>'.$row['sqlerror'].'</td>'; }  
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['wordpresserror'])){ echo '<td>'.$row['wordpresserror'].'</td>'; }  
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['screenshoturl'])){ echo '<td>'.$row['screenshoturl'].'</td>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['userscomment'])){ echo '<td>'.$row['userscomment'].'</td>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['page'])){ echo '<td>'.$row['page'].'</td>'; }  
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['version'])){ echo '<td>'.$row['version'].'</td>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['panelname'])){ echo '<td>'.$row['panelname'].'</td>'; }    
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['tabscreenname'])){ echo '<td>'.$row['tabscreenname'].'</td>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['dump'])){ echo '<td>'.$row['dump'].'</td>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['ipaddress'])){ echo '<td>'.$row['ipaddress'].'</td>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['userid'])){ echo '<td>'.$row['userid'].'</td>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['comment'])){ echo '<td>'.$row['comment'].'</td>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['type'])  || isset($_GET['typecriteria'])){ echo '<td>'.$row['type'].'</td>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['priority'])){ echo '<td>'.$row['priority'].'</td>'; }
            if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['thetrigger'])){ echo '<td>'.$row['thetrigger'].'</td>'; }
            
        echo '</tr>';
          
    }

    echo '</tbody></table>';
}
?>