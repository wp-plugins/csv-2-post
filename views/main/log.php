<?php
/** 
 * Free edition file (applies to paid also) for CSV 2 POST plugin by WebTechGlobal.co.uk
 * 
 * This file is used in all WebTechGlobal plugins. Changes should apply to all. Use a different file/screen for plugin specific requirements.
 *
 * @package CSV 2 POST
 * 
 * @author Ryan Bayne 
 * 
 * 1. URL search ability
 * 2. Stores last search
 */
 
global $wpdb,$c2p_settings,$C2P_DB,$C2P_UI;

// default log screen array
$search_headers_array = array();
//rowid (treated different from others)
$search_headers_array['row_id']['title'] = 'Row ID';
$search_headers_array['row_id']['select'] = true;// add to SELECT part of query
$search_headers_array['row_id']['display'] = true;// display in table
// outcome
$search_headers_array['outcome']['title'] = 'Outcome';
$search_headers_array['outcome']['select'] = false;
$search_headers_array['outcome']['display'] = false;
$search_headers_array['outcome']['searchoptions'] = false;// 0|1
// type
$search_headers_array['type']['title'] = 'Type';
$search_headers_array['type']['select'] = false;
$search_headers_array['type']['display'] = false;
$search_headers_array['type']['searchoptions'] = false;// general|error|trace
// priority
$search_headers_array['priority']['title'] = 'Priority';
$search_headers_array['priority']['select'] = false;
$search_headers_array['priority']['display'] = false;
$search_headers_array['priority']['searchoptions'] = false;// low|high|medium
// timestamp
$search_headers_array['timestamp']['title'] = 'Date + Time';
$search_headers_array['timestamp']['select'] = false;
$search_headers_array['timestamp']['display'] = false;
$search_headers_array['timestamp']['searchoptions'] = false;// onehour|oneday|oneweek 
// line
$search_headers_array['line']['title'] = 'Line';
$search_headers_array['line']['select'] = false;
$search_headers_array['line']['display'] = false;
$search_headers_array['line']['searchoptions'] = false;
// file
$search_headers_array['file']['title'] = 'File';
$search_headers_array['file']['select'] = false;
$search_headers_array['file']['display'] = false;
$search_headers_array['file']['searchoptions'] = false;    
// function
$search_headers_array['function']['title'] = 'Function';
$search_headers_array['function']['select'] = false;
$search_headers_array['function']['display'] = false;
$search_headers_array['function']['searchoptions'] = false;
// sqlresult
$search_headers_array['sqlresult']['title'] = 'SQL Result';
$search_headers_array['sqlresult']['select'] = false;
$search_headers_array['sqlresult']['display'] = false;
$search_headers_array['sqlresult']['searchoptions'] = false;
// sqlquery
$search_headers_array['sqlquery']['title'] = 'SQL Query';
$search_headers_array['sqlquery']['select'] = false;
$search_headers_array['sqlquery']['display'] = false;
$search_headers_array['sqlquery']['searchoptions'] = false;
// sqlerror
$search_headers_array['sqlerror']['title'] = 'SQL Error';
$search_headers_array['sqlerror']['select'] = false;
$search_headers_array['sqlerror']['display'] = false;
$search_headers_array['sqlerror']['searchoptions'] = false;
// wordpresserror
$search_headers_array['wordpresserror']['title'] = 'WP Error';
$search_headers_array['wordpresserror']['select'] = false;
$search_headers_array['wordpresserror']['display'] = false;
$search_headers_array['wordpresserror']['searchoptions'] = false;
// screenshoturl
$search_headers_array['screenshoturl']['title'] = 'Screenshot URL';
$search_headers_array['screenshoturl']['select'] = false;
$search_headers_array['screenshoturl']['display'] = false;
$search_headers_array['screenshoturl']['searchoptions'] = false;
// userscomment
$search_headers_array['userscomment']['title'] = 'Users Comment';
$search_headers_array['userscomment']['select'] = false;
$search_headers_array['userscomment']['display'] = false;
$search_headers_array['userscomment']['searchoptions'] = false;
// page
$search_headers_array['page']['title'] = 'Page';
$search_headers_array['page']['select'] = false;
$search_headers_array['page']['display'] = false;
$search_headers_array['page']['searchoptions'] = false;
// version
$search_headers_array['version']['title'] = 'Plugin Version';
$search_headers_array['version']['select'] = false;
$search_headers_array['version']['display'] = false;
$search_headers_array['version']['searchoptions'] = false;
// panelname
$search_headers_array['panelname']['title'] = 'Panel Name';
$search_headers_array['panelname']['select'] = false;
$search_headers_array['panelname']['display'] = false;
$search_headers_array['panelname']['searchoptions'] = false;
// tabscreenid
$search_headers_array['tabscreenid']['title'] = 'Screen ID';
$search_headers_array['tabscreenid']['select'] = false;
$search_headers_array['tabscreenid']['display'] = false;
$search_headers_array['tabscreenid']['searchoptions'] = false;
// tabscreenname
$search_headers_array['tabscreenname']['title'] = 'Screen Name';
$search_headers_array['tabscreenname']['select'] = false;
$search_headers_array['tabscreenname']['display'] = false;
$search_headers_array['tabscreenname']['searchoptions'] = false;
// dump
$search_headers_array['dump']['title'] = 'Dump';
$search_headers_array['dump']['select'] = false;
$search_headers_array['dump']['display'] = false;
$search_headers_array['dump']['searchoptions'] = false;
// ipaddress
$search_headers_array['ipaddress']['title'] = 'IP Address';
$search_headers_array['ipaddress']['select'] = false;
$search_headers_array['ipaddress']['display'] = false;
$search_headers_array['ipaddress']['searchoptions'] = false;
// userid
$search_headers_array['userid']['title'] = 'User ID';
$search_headers_array['userid']['select'] = false;
$search_headers_array['userid']['display'] = false;
$search_headers_array['userid']['searchoptions'] = false;
// comment
$search_headers_array['comment']['title'] = 'Comment';
$search_headers_array['comment']['select'] = false;
$search_headers_array['comment']['display'] = false;
$search_headers_array['comment']['searchoptions'] = false;       
// category
$search_headers_array['category']['title'] = 'Category';
$search_headers_array['category']['select'] = false;
$search_headers_array['category']['display'] = false;
$search_headers_array['category']['searchoptions'] = false;
// action
$search_headers_array['action']['title'] = 'Action';
$search_headers_array['action']['select'] = false;
$search_headers_array['action']['display'] = false;
$search_headers_array['action']['searchoptions'] = false;         
// thetrigger
$search_headers_array['thetrigger']['title'] = 'Trigger';
$search_headers_array['thetrigger']['select'] = false;
$search_headers_array['thetrigger']['display'] = false; 
$search_headers_array['thetrigger']['searchoptions'] = false;   
    
// set criteria
if(isset($_GET['c2plogsearch'])){
    foreach($search_headers_array as $key => $header){
        if(isset($_GET[$key . 'criteria'])){

            $search_headers_array[$key]['searchoptions'] = $_GET[$key . 'criteria'];// changes from false to indicate we want to use the preset criteria value
            $search_headers_array[$key]['select'] = true;
            $search_headers_array[$key]['display'] = true;

        }            
    } 
}elseif(!isset($_GET['c2plogsearch'])){
    foreach($search_headers_array as $key => $header){
        if(isset($c2p_settings['logsettings']['logscreen'][$key . 'criteria'])){

            $search_headers_array[$key]['searchoptions'] = $c2p_settings['logsettings']['logscreen'][$key . 'criteria'];// changes from false to indicate we want to use the preset criteria value
            $search_headers_array[$key]['select'] = true;
            $search_headers_array[$key]['display'] = true;

        }               
    }
}

// establish columns    
foreach($search_headers_array as $key => $header){
    if(isset($c2p_settings['logsettings']['logscreen']['displayedcolumns'][$key]) && $c2p_settings['logsettings']['logscreen']['displayedcolumns'][$key] == true){
        $search_headers_array[$key]['select'] = true;
        $search_headers_array[$key]['display'] = true;
    }            
} 

// build and query
if(!$C2P_DB->database_table_exist($wpdb->prefix . 'c2plog')){return false;}
      
$type = 'all';

$select = 'row_id,timestamp';
foreach($search_headers_array as $column => $column_array){
    if($search_headers_array[$column]['select'] == true){
        $select .= ',' . $column;    
    }
}    

// where
$where = 'row_id IS NOT NULL ';
foreach($search_headers_array as $column => $column_array){
    
    if(isset($search_headers_array[$column]['searchoptions']) && !empty($search_headers_array[$column]['searchoptions'])){
       
        $where .= '
        AND (';
        
        if(is_array($search_headers_array[$column]['searchoptions']))
        {
            $array = $search_headers_array[$column]['searchoptions'];    
        }
        else
        {
            $array = explode(',',$search_headers_array[$column]['searchoptions']);
        }
        
        $total_strings = count($array);
        
        $added = 0;
        foreach($array as $key => $string){
            
            ++$added;
            
            $where .= $column . ' = "' . $string .'"';
            
            if($total_strings > 0 && $added != $total_strings){
                $where .= ' OR ';
            } 
        }  
        
        $where .= ')';
    }
    
} 
                      
$query = "SELECT ".$select." 
FROM $wpdb->c2plog 
WHERE ".$where."
ORDER BY timestamp DESC
LIMIT 200";
                     
// get_results
$query_results = $wpdb->get_results($query,ARRAY_A);
?>

<div class="csv2post_boxes_twohalfs">

    <?php $myforms_title = __('Log Settings');?>
    <?php $myforms_name = 'logsettings';?>
    <div class="csv2post_boxes_content">
        <?php $C2P_UI->panel_header($myforms_title,$myforms_name,false,false,false,__('Options that apply to all all sections and procedures.'));?>

        <form method="post" name="operationsettings" action="<?php $C2P_UI->form_action(); ?>">
        
            <?php $C2P_WP->hidden_form_values('logsettings',__('Log Settings','csv2post'));?>     

            <table class="form-table">
            
                <!-- Option Start -->
                <tr valign="top">
                    <th scope="row">Log</th>
                    <td>
                        <?php 
                        // if is not set ['admintriggers']['newcsvfiles']['status'] then it is enabled by default
                        if(!isset($c2p_settings['globalsettings']['uselog'])){
                            $radio1_uselog_enabled = 'checked'; 
                            $radio2_uselog_disabled = '';                    
                        }else{
                            if($c2p_settings['globalsettings']['uselog'] == 1){
                                $radio1_uselog_enabled = 'checked'; 
                                $radio2_uselog_disabled = '';    
                            }elseif($c2p_settings['globalsettings']['uselog'] == 0){
                                $radio1_uselog_enabled = ''; 
                                $radio2_uselog_disabled = 'checked';    
                            }
                        }?>
                        <fieldset><legend class="screen-reader-text"><span>Log</span></legend>
                            <input type="radio" id="logstatus_enabled" name="csv2post_radiogroup_logstatus" value="1" <?php echo $radio1_uselog_enabled;?> />
                            <label for="logstatus_enabled"> <?php _e('Enable','csv2post'); ?></label>
                            <br />
                            <input type="radio" id="logstatus_disabled" name="csv2post_radiogroup_logstatus" value="0" <?php echo $radio2_uselog_disabled;?> />
                            <label for="logstatus_disabled"> <?php _e('Disable','csv2post'); ?></label>
                        </fieldset>
                    </td>
                </tr>
                <!-- Option End -->
      
                <?php       
                // log rows limit
                if(!isset($c2p_settings['globalsettings']['loglimit']) || !is_numeric($c2p_settings['globalsettings']['loglimit'])){$c2p_settings['globalsettings']['loglimit'] = 1000;}
                $C2P_UI->option_text('Log Entries Limit','csv2post_loglimit','loglimit',$c2p_settings['globalsettings']['loglimit']);
                ?>

            </table>
         
            <input class="button" type="submit" value="Submit" />

        </form> 
                                                   
    </div>

</div> 

<form method="post" name="log" action="<?php $C2P_UI->form_action(); ?>">

    <?php $C2P_WP->hidden_form_values('log',__('Log','csv2post'));?>

    <p>This panel and these options are not affected by URL searches. These options belong to your custom search criteria which this screen defaults to
    when loading.</p>
    
    <h4>Outcomes</h4>
    <label for="csv2post_log_outcomes_success"><input type="checkbox" name="csv2post_log_outcome[]" id="csv2post_log_outcomes_success" value="1" <?php if(isset($c2p_settings['logsettings']['logscreen']['outcomecriteria']['1'])){echo 'checked';} ?>> Success</label>
    <br> 
    <label for="csv2post_log_outcomes_fail"><input type="checkbox" name="csv2post_log_outcome[]" id="csv2post_log_outcomes_fail" value="0" <?php if(isset($c2p_settings['logsettings']['logscreen']['outcomecriteria']['0'])){echo 'checked';} ?>> Fail/Rejected</label>

    <h4>Type</h4>
    <label for="csv2post_log_type_general"><input type="checkbox" name="csv2post_log_type[]" id="csv2post_log_type_general" value="general" <?php if(isset($c2p_settings['logsettings']['logscreen']['typecriteria']['general'])){echo 'checked';} ?>> General</label>
    <br>
    <label for="csv2post_log_type_error"><input type="checkbox" name="csv2post_log_type[]" id="csv2post_log_type_error" value="error" <?php if(isset($c2p_settings['logsettings']['logscreen']['typecriteria']['error'])){echo 'checked';} ?>> Errors</label>
    <br>
    <label for="csv2post_log_type_trace"><input type="checkbox" name="csv2post_log_type[]" id="csv2post_log_type_trace" value="flag" <?php if(isset($c2p_settings['logsettings']['logscreen']['typecriteria']['flag'])){echo 'checked';} ?>> Trace</label>

    <h4>Priority</h4>
    <label for="csv2post_log_priority_low"><input type="checkbox" name="csv2post_log_priority[]" id="csv2post_log_priority_low" value="low" <?php if(isset($c2p_settings['logsettings']['logscreen']['prioritycriteria']['low'])){echo 'checked';} ?>> Low</label>
    <br>
    <label for="csv2post_log_priority_normal"><input type="checkbox" name="csv2post_log_priority[]" id="csv2post_log_priority_normal" value="normal" <?php if(isset($c2p_settings['logsettings']['logscreen']['prioritycriteria']['normal'])){echo 'checked';} ?>> Normal</label>
    <br>
    <label for="csv2post_log_priority_high"><input type="checkbox" name="csv2post_log_priority[]" id="csv2post_log_priority_high" value="high" <?php if(isset($c2p_settings['logsettings']['logscreen']['prioritycriteria']['high'])){echo 'checked';} ?>> High</label>
    
    <h1>Custom Search</h1>
    <p>This search criteria is not currently stored, it will be used on the submission of this form only.</p>
 
    <h4>Page</h4>
    <select name="csv2post_pluginpages_logsearch" id="csv2post_pluginpages_logsearch" >
        <option value="notselected">Do Not Apply</option>
        <?php
        $current = '';
        if(isset($c2p_settings['logsettings']['logscreen']['page']) && $c2p_settings['logsettings']['logscreen']['page'] != 'notselected'){
            $current = $c2p_settings['logsettings']['logscreen']['page'];
        } 
        $C2P_WP->page_menuoptions($current);?> 
    </select>
    
    <h4>Action</h4> 
    <select name="csv2pos_logactions_logsearch" id="csv2pos_logactions_logsearch" >
        <option value="notselected">Do Not Apply</option>
        <?php 
        $current = '';
        if(isset($c2p_settings['logsettings']['logscreen']['action']) && $c2p_settings['logsettings']['logscreen']['action'] != 'notselected'){
            $current = $c2p_settings['logsettings']['logscreen']['action'];
        }
        $action_results = C2P_WPDB::log_queryactions($current);
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
        if(isset($c2p_settings['logsettings']['logscreen']['screen']) && $c2p_settings['logsettings']['logscreen']['screen'] != 'notselected'){
            $current = $c2p_settings['logsettings']['logscreen']['screen'];
        }
        $C2P_WP->screens_menuoptions($current);?> 
    </select>
          
    <h4>PHP Line</h4>
    <input type="text" name="csv2post_logcriteria_phpline" value="<?php if(isset($c2p_settings['logsettings']['logscreen']['line'])){echo $c2p_settings['logsettings']['logscreen']['line'];} ?>">
    
    <h4>PHP File</h4>
    <input type="text" name="csv2post_logcriteria_phpfile" value="<?php if(isset($c2p_settings['logsettings']['logscreen']['file'])){echo $c2p_settings['logsettings']['logscreen']['file'];} ?>">
    
    <h4>PHP Function</h4>
    <input type="text" name="csv2post_logcriteria_phpfunction" value="<?php if(isset($c2p_settings['logsettings']['logscreen']['function'])){echo $c2p_settings['logsettings']['logscreen']['function'];} ?>">
    
    <h4>Panel Name</h4>
    <input type="text" name="csv2post_logcriteria_panelname" value="<?php if(isset($c2p_settings['logsettings']['logscreen']['panelname'])){echo $c2p_settings['logsettings']['logscreen']['panelname'];} ?>">

    <h4>IP Address</h4>
    <input type="text" name="csv2post_logcriteria_ipaddress" value="<?php if(isset($c2p_settings['logsettings']['logscreen']['ipaddress'])){echo $c2p_settings['logsettings']['logscreen']['ipaddress'];} ?>">
   
    <h4>User ID</h4>
    <input type="text" name="csv2post_logcriteria_userid" value="<?php if(isset($c2p_settings['logsettings']['logscreen']['userid'])){echo $c2p_settings['logsettings']['logscreen']['userid'];} ?>">    
  
    <h4>Display Fields</h4>                                                                                                                                        
    <label for="csv2post_logfields_outcome"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_outcome" value="outcome" <?php if(isset($c2p_settings['logsettings']['logscreen']['displayedcolumns']['outcome'])){echo 'checked';} ?>> <?php _e('Outcome','csv2post');?></label>
    <br>
    <label for="csv2post_logfields_line"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_line" value="line" <?php if(isset($c2p_settings['logsettings']['logscreen']['displayedcolumns']['line'])){echo 'checked';} ?>> <?php _e('Line','csv2post');?></label>
    <br>
    <label for="csv2post_logfields_file"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_file" value="file" <?php if(isset($c2p_settings['logsettings']['logscreen']['displayedcolumns']['file'])){echo 'checked';} ?>> <?php _e('File','csv2post');?></label> 
    <br>
    <label for="csv2post_logfields_function"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_function" value="function" <?php if(isset($c2p_settings['logsettings']['logscreen']['displayedcolumns']['function'])){echo 'checked';} ?>> <?php _e('Function','csv2post');?></label>
    <br>
    <label for="csv2post_logfields_sqlresult"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_sqlresult" value="sqlresult" <?php if(isset($c2p_settings['logsettings']['logscreen']['displayedcolumns']['sqlresult'])){echo 'checked';} ?>> <?php _e('SQL Result','csv2post');?></label>
    <br>
    <label for="csv2post_logfields_sqlquery"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_sqlquery" value="sqlquery" <?php if(isset($c2p_settings['logsettings']['logscreen']['displayedcolumns']['sqlquery'])){echo 'checked';} ?>> <?php _e('SQL Query','csv2post');?></label>
    <br>
    <label for="csv2post_logfields_sqlerror"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_sqlerror" value="sqlerror" <?php if(isset($c2p_settings['logsettings']['logscreen']['displayedcolumns']['sqlerror'])){echo 'checked';} ?>> <?php _e('SQL Error','csv2post');?></label>
    <br>
    <label for="csv2post_logfields_wordpresserror"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_wordpresserror" value="wordpresserror" <?php if(isset($c2p_settings['logsettings']['logscreen']['displayedcolumns']['wordpresserror'])){echo 'checked';} ?>> <?php _e('Wordpress Erro','csv2post');?>r</label>
    <br>
    <label for="csv2post_logfields_screenshoturl"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_screenshoturl" value="screenshoturl" <?php if(isset($c2p_settings['logsettings']['logscreen']['displayedcolumns']['screenshoturl'])){echo 'checked';} ?>> <?php _e('Screenshot URL','csv2post');?></label>
    <br>
    <label for="csv2post_logfields_userscomment"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_userscomment" value="userscomment" <?php if(isset($c2p_settings['logsettings']['logscreen']['displayedcolumns']['userscomment'])){echo 'checked';} ?>> <?php _e('Users Comment','csv2post');?></label>
    <br>
    <label for="csv2post_logfields_page"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_page" value="page" <?php if(isset($c2p_settings['logsettings']['logscreen']['displayedcolumns']['page'])){echo 'checked';} ?>> <?php _e('Page','csv2post');?></label>
    <br>
    <label for="csv2post_logfields_version"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_version" value="version" <?php if(isset($c2p_settings['logsettings']['logscreen']['displayedcolumns']['version'])){echo 'checked';} ?>> <?php _e('Plugin Version','csv2post');?></label>
    <br>
    <label for="csv2post_logfields_panelname"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_panelname" value="panelname" <?php if(isset($c2p_settings['logsettings']['logscreen']['displayedcolumns']['panelname'])){echo 'checked';} ?>> <?php _e('Panel Name','csv2post');?></label>
    <br>
    <label for="csv2post_logfields_tabscreenname"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_tabscreenname" value="tabscreenname" <?php if(isset($c2p_settings['logsettings']['logscreen']['displayedcolumns']['outcome'])){echo 'checked';} ?>> <?php _e('Screen Name *','csv2post');?></label>
    <br>
    <label for="csv2post_logfields_dump"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_dump" value="dump" <?php if(isset($c2p_settings['logsettings']['logscreen']['displayedcolumns']['dump'])){echo 'checked';} ?>> <?php _e('Dump','csv2post');?></label>
    <br>
    <label for="csv2post_logfields_ipaddress"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_ipaddress" value="ipaddress" <?php if(isset($c2p_settings['logsettings']['logscreen']['displayedcolumns']['ipaddress'])){echo 'checked';} ?>> <?php _e('IP Address','csv2post');?></label>
    <br>
    <label for="csv2post_logfields_userid"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_userid" value="userid" <?php if(isset($c2p_settings['logsettings']['logscreen']['displayedcolumns']['userid'])){echo 'checked';} ?>> <?php _e('User ID','csv2post');?></label>
    <br>
    <label for="csv2post_logfields_comment"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_comment" value="comment" <?php if(isset($c2p_settings['logsettings']['logscreen']['displayedcolumns']['comment'])){echo 'checked';} ?>> <?php _e('Developers Comment','csv2post');?></label>
    <br>
    <label for="csv2post_logfields_type"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_type" value="type" <?php if(isset($c2p_settings['logsettings']['logscreen']['displayedcolumns']['type'])){echo 'checked';} ?>> <?php _e('Entry Type','csv2post');?></label>
    <br>
    <label for="csv2post_logfields_category"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_category" value="category" <?php if(isset($c2p_settings['logsettings']['logscreen']['displayedcolumns']['category'])){echo 'checked';} ?>> <?php _e('Category','csv2post');?></label>
    <br>
    <label for="csv2post_logfields_action"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_action" value="action" <?php if(isset($c2p_settings['logsettings']['logscreen']['displayedcolumns']['action'])){echo 'checked';} ?>> <?php _e('Action','csv2post');?></label>
    <br>
    <label for="csv2post_logfields_priority"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_priority" value="priority" <?php if(isset($c2p_settings['logsettings']['logscreen']['displayedcolumns']['priority'])){echo 'checked';} ?>> <?php _e('Priority','csv2post');?></label> 
    <br>
    <label for="csv2post_logfields_thetrigger"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_thetrigger" value="thetrigger" <?php if(isset($c2p_settings['logsettings']['logscreen']['displayedcolumns']['thetrigger'])){echo 'checked';} ?>> <?php _e('Trigger','csv2post');?></label> 
    <br>           
    <input class="button" type="submit" value="Submit" />

</form>  

<?php    
if(!$C2P_DB->database_table_exist($wpdb->prefix . 'c2plog')){
    echo '<p>'. __('The database table for storing log entries has not been installed. You can install it on the Install screen.','csv2post') .'</p>';
}elseif(!$query_results || empty($query_results)){
    echo '<strong>'. __('There are no log entries matches your current search criteria.','csv2post') .'</strong>';
}else{   

    //Create an instance of our package class...
    if(isset($_GET['categorycriteria'])){$c2p_settings['logsettings']['logscreen']['displayedcolumns']['category'] = true;}
    if(isset($_GET['typecriteria'])){$c2p_settings['logsettings']['logscreen']['displayedcolumns']['type'] = true;}    

    $LogTable = new C2P_Log_Table();
               
    foreach($c2p_settings['logsettings']['logscreen']['displayedcolumns'] as $category => $value){
        $LogTable->$category = true;
    }
  
    $LogTable->prepare_items($query_results,5);
    ?>

    <form id="movies-filter" method="get">
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
        <?php $LogTable->display() ?>
    </form>

<?php }?>