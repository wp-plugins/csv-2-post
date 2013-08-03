<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'logsearchoptions';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Log Search Options');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_state'] = 'closed';
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);               
$jsform_set['dialogbox_title'] = 'Perform Advanced Data Search';
$jsform_set['noticebox_content'] = 'Please be aware that the number of records you have in your data will determine how long the search will take. Would you like to continue?';?>
<?php csv2post_panel_header( $panel_array );?> 

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);?>

    <h1>Search Criteria</h1>
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

    <h4>Category</h4>
    <label for="csv2post_log_category_schedule"><input type="checkbox" name="csv2post_log_category[]" id="csv2post_log_category_schedule" value="schedule" <?php if(isset($csv2post_adm_set['log']['logscreen']['categorycriteria']['schedule'])){echo 'checked';} ?>> Schedule Related</label>
    <br>
    <label for="csv2post_log_category_posts"><input type="checkbox" name="csv2post_log_category[]" id="csv2post_log_category_posts" value="posts" <?php if(isset($csv2post_adm_set['log']['logscreen']['categorycriteria']['posts'])){echo 'checked';} ?>> Post Create/Update</label>
    <br>
    <label for="csv2post_log_category_data"><input type="checkbox" name="csv2post_log_category[]" id="csv2post_log_category_data" value="data" <?php if(isset($csv2post_adm_set['log']['logscreen']['categorycriteria']['data'])){echo 'checked';} ?>> Data</label>
    <br>
    <label for="csv2post_log_category_project"><input type="checkbox" name="csv2post_log_category[]" id="csv2post_log_category_project" value="project" <?php if(isset($csv2post_adm_set['log']['logscreen']['categorycriteria']['project'])){echo 'checked';} ?>> Project Changes</label>
    <br>
    <label for="csv2post_log_category_forms"><input type="checkbox" name="csv2post_log_category[]" id="csv2post_log_category_forms" value="forms" <?php if(isset($csv2post_adm_set['log']['logscreen']['categorycriteria']['forms'])){echo 'checked';} ?>> Form Submissions</label>
    <br>
    <label for="csv2post_log_category_useractions"><input type="checkbox" name="csv2post_log_category[]" id="csv2post_log_category_useractions" value="useractions" <?php if(isset($csv2post_adm_set['log']['logscreen']['categorycriteria']['useractions'])){echo 'checked';} ?>> User Actions</label>
    <br>
    <label for="csv2post_log_category_automation"><input type="checkbox" name="csv2post_log_category[]" id="csv2post_log_category_automation" value="automation" <?php if(isset($csv2post_adm_set['log']['logscreen']['categorycriteria']['automation'])){echo 'checked';} ?>> Automation</label>
          
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
    <label for="csv2post_logfields_timestamp"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_timestamp" value="timestamp" <?php if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['timestamp'])){echo 'checked';} ?>> Timestamp</label>
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
        
    <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>

<?php csv2post_panel_footer();?>

<?php
global $wpdb;

// array of table headers
$th_array = array(
    'rowid',
    'outcome',
    'timestamp',
    'line',
    'file',
    'function',
    'sqlresult',
    'sqlquery',
    'sqlerror',
    'wordpresserror',
    'screenshoturl',
    'userscomment',
    'page',
    'version',
    'panelname',
    'tabscreenid',
    'tabscreenname',
    'dump',
    'ipaddress',
    'userid',
    'comment',
    'type',
    'category',
    'action',
    'priority');  
        
        
$type = 'all';
$limit = '50';
$where = '';

// select
$select = 'rowid';# start with a column so comma can be added with each additional column
if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns'])){
    foreach($csv2post_adm_set['log']['logscreen']['displayedcolumns'] as $column => $ignorethis){
        if($column != 'rowid'){$select .= ',' . $column;};
    }    
}
if($select == ''){$select = '*';}

// where
$where = ' 
rowid IS NOT NULL ';

    // add outcomes
    if(isset($csv2post_adm_set['log']['logscreen']['outcomecriteria'])){
        
        $where .= '
        AND ';
        
        // count number of values, one indicates AND and more than one requires OR
        $total = count($csv2post_adm_set['log']['logscreen']['outcomecriteria']);
        
        if($total > 1){
            $where .= '(';
        }
        
        $addedcolumn_count = 0;
        
        foreach($csv2post_adm_set['log']['logscreen']['outcomecriteria'] as $outcome => $booleanvalue){
            
            if($addedcolumn_count > 0){
                if($total == 1){
                    $where .= ' 
                    AND';
                }else{
                    $where .= ' 
                    OR';
                }             
            }

            $where .= ' outcome = "'.$outcome.'"';
            
            ++$addedcolumn_count;
        }
        
        if($total > 1){
            $where .= ')';
        }
    }

    // add type (s)
    if(isset($csv2post_adm_set['log']['logscreen']['typecriteria'])){
        
        $where .= '
        AND ';
        
        // count number of values, one indicates AND and more than one requires OR
        $total = count($csv2post_adm_set['log']['logscreen']['typecriteria']);

        if($total > 1){
            $where .= '(';
        }
        
        $addedcolumn_count = 0;
        
        foreach($csv2post_adm_set['log']['logscreen']['typecriteria'] as $type => $booleanvalue){
            
            if($addedcolumn_count > 0){
                if($total == 1){
                    $where .= ' 
                    AND';
                }else{
                    $where .= ' 
                    OR';
                }             
            }

            $where .= ' outcome = "'.$type.'"';
            
            ++$addedcolumn_count;
        }
        
        if($total > 1){
            $where .= ')';
        }
    }
    
    // add category
    if(isset($csv2post_adm_set['log']['logscreen']['categorycriteria'])){
        
        $where .= '
        AND ';
        
        // count number of values, one indicates AND and more than one requires OR
        $total = count($csv2post_adm_set['log']['logscreen']['categorycriteria']);

        if($total > 1){
            $where .= '(';
        }
        
        $addedcolumn_count = 0;
        
        foreach($csv2post_adm_set['log']['logscreen']['categorycriteria'] as $category => $booleanvalue){
            
            if($addedcolumn_count > 0){
                if($total == 1){
                    $where .= ' 
                    AND';
                }else{
                    $where .= ' 
                    OR';
                }             
            }

            $where .= ' outcome = "'.$category.'"';
            
            ++$addedcolumn_count;
        }
        
        if($total > 1){
            $where .= ')';
        }
    }

    // add category
    if(isset($csv2post_adm_set['log']['logscreen']['categorycriteria'])){
        
        $where .= '
        AND ';
        
        // count number of values, one indicates AND and more than one requires OR
        $total = count($csv2post_adm_set['log']['logscreen']['categorycriteria']);

        if($total > 1){
            $where .= '(';
        }
        
        $addedcolumn_count = 0;
        
        foreach($csv2post_adm_set['log']['logscreen']['categorycriteria'] as $category => $booleanvalue){
            
            if($addedcolumn_count > 0){
                if($total == 1){
                    $where .= ' 
                    AND';
                }else{
                    $where .= ' 
                    OR';
                }             
            }

            $where .= ' outcome = "'.$category.'"';
            
            ++$addedcolumn_count;
        }
        
        if($total > 1){
            $where .= ')';
        }
    }
    
    // page
    if(isset($csv2post_adm_set['log']['logscreen']['page']) && $csv2post_adm_set['log']['logscreen']['page'] != ''){
        $where .= '
        AND page = "'.$csv2post_adm_set['log']['logscreen']['page'].'"';
    }   
    
    // action
    if(isset($csv2post_adm_set['log']['logscreen']['action']) && $csv2post_adm_set['log']['logscreen']['action'] != ''){
        $where .= '
        AND action = "'.$csv2post_adm_set['log']['logscreen']['action'].'"';
    }    
   
    // screen
    if(isset($csv2post_adm_set['log']['logscreen']['screen']) && $csv2post_adm_set['log']['logscreen']['screen'] != ''){
        $where .= '
        AND tabscreenname = "'.$csv2post_adm_set['log']['logscreen']['screen'].'"';
    }
    
    // line
    if(isset($csv2post_adm_set['log']['logscreen']['line']) && $csv2post_adm_set['log']['logscreen']['line'] != ''){
        $where .= '
        AND line = "'.$csv2post_adm_set['log']['logscreen']['line'].'"';
    }    
    
    // file
    if(isset($csv2post_adm_set['log']['logscreen']['file']) && $csv2post_adm_set['log']['logscreen']['file'] != ''){
        $where .= '
        AND file = "'.$csv2post_adm_set['log']['logscreen']['file'].'"';
    }
    
    // function
    if(isset($csv2post_adm_set['log']['logscreen']['function']) && $csv2post_adm_set['log']['logscreen']['function'] != ''){
        $where .= '
        AND function = "'.$csv2post_adm_set['log']['logscreen']['function'].'"';
    }     
    
    // panelname
    if(isset($csv2post_adm_set['log']['logscreen']['panelname']) && $csv2post_adm_set['log']['logscreen']['panelname'] != ''){
        $where .= '
        AND panelname = "'.$csv2post_adm_set['log']['logscreen']['panelname'].'"';
    }     
     
    // IP address
    if(isset($csv2post_adm_set['log']['logscreen']['ipaddress']) && $csv2post_adm_set['log']['logscreen']['ipaddress'] != ''){
        $where .= '
        AND ipaddress = "'.$csv2post_adm_set['log']['logscreen']['ipaddress'].'"';
    }      
         
    // userid
    if(isset($csv2post_adm_set['log']['logscreen']['userid']) && $csv2post_adm_set['log']['logscreen']['userid'] != ''){
        $where .= '
        AND userid = "'.$csv2post_adm_set['log']['logscreen']['userid'].'"';
    } 

// limit
$limit = ' 
LIMIT ' . $limit;

$query = "SELECT ".$select." 
FROM csv2post_log 
WHERE ".$where."
".$limit."";

// get_results
$logrows = $wpdb->get_results($query,ARRAY_A);
     
csv2post_GUI_tablestart();
echo ' 
<thead>
    <tr>';
    
        echo '<th>rowid</th>'; 
        if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['outcome'])){ echo '<th>outcome</th>'; }
        if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['timestamp'])){ echo '<th>timestamp</th>'; }
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
        if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['category'])){ echo '<th>category</th>';}
        if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['action'])){ echo '<th>action</th>';}
        if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['priority'])){ echo '<th>priority</th>';}                                    
    
    echo '</tr>
</thead>'; 

echo '
<tfoot>
    <tr>';
    
        echo '<th>rowid</th>';
        if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['outcome'])){ echo '<th>outcome</th>'; }
        if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['timestamp'])){ echo '<th>timestamp</th>'; }
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
        if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['category'])){ echo '<th>category</th>';}
        if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['action'])){ echo '<th>action</th>';}
        if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['priority'])){ echo '<th>priority</th>';}                                                      
    
    echo '</tr>
</tfoot>
<tbody>';

foreach($logrows as $key => $row){

    echo '<tr>';
    
        echo '<td>'.$row['rowid'].'</td>';
        if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['outcome'])){ echo '<td>'.$row['outcome'].'</td>'; }
        if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['timestamp'])){ echo '<td>'.$row['timestamp'].'</td>'; }
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
        if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['type'])){ echo '<td>'.$row['type'].'</td>'; }
        if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['category'])){ echo '<td>'.$row['category'].'</td>'; }
        if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['action'])){ echo '<td>'.$row['action'].'</td>'; }
        if(isset($csv2post_adm_set['log']['logscreen']['displayedcolumns']['priority'])){ echo '<td>'.$row['priority'].'</td>'; }
    
    echo '</tr>';
      
}

echo '</tbody></table>';
?>