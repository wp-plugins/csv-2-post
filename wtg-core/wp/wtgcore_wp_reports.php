<?php
/**
* Display log entries for specific log types
* 
* @link http://www.csv2post.com/hacking/log-table
* 
* @todo MEDIUMPRIORITY, use jQuery UI and Ajax table to display results
* 
* @param string $type general|error
* @param integer $display_rows number of rows to display in table
* @param array $display_columns an array holding the column names from csv2post_log table to be displayed
*/
function csv2post_log_display_bytype($type = 'all',$display_rows = 100,$display_columns = 'all'){
    $rows = csv2post_WP_SQL_querylog_bytype($type,$display_rows);
    
    if(!$rows){
        csv2post_n_incontent('No log entries have been made for this.','info','Small','No Log Entries');    
        return;
    }
    
    // reverse the order of the array
    $logrows = array_reverse($rows);
    
    $rowCount = 0;
    
    echo '<table class="widefat post fixed">';

    foreach($logrows as $id => $row){
        
        // if first row do header
        if($rowCount == 0){
            
            echo '<tr>';
            
            foreach($row as $column => $value){

                // if display_columns is default "all" or specific columns passed we only add those
                if($display_columns == 'all' || !is_array($display_columns)){
                    
                    echo '<td><strong>'.$column.'</strong></td>'; 

                }else{
                
                    // only add values in columns passed either by
                    if(in_array($column,$display_columns)){

                        echo '<td><strong>'.$column.'</strong></td>'; 

                    }   
                }
            }
            
            echo '</tr>';
            
        }else{
            
            echo '<tr>';
            
            foreach($row as $column => $value){

                // if display_columns is default "all" or specific columns passed we only add those
                if($display_columns == 'all' || !is_array($display_columns)){
                    
                    if($value == NULL){
                        echo '<td></td>';
                    }else{
                        echo '<td>'.$value.'</td>'; 
                    }
                    
                }else{
                
                    // only add values in columns passed either by
                    if(in_array($column,$display_columns)){
                        
                        if($value == NULL){
                            echo '<td></td>';
                        }else{
                            echo '<td>'.$value.'</td>'; 
                        }   
        
                    }   
                }
            }
            
            echo '</tr>';
        }
        
        ++$rowCount;   
    }
    
    echo '</table>'; 
}

/**
* Used to build a query history file,intention is to display the history
* Type Values: general,sql,admin,user,error
* General History File Filters: install
* 
* @global $wpdb
* @uses extract, shortcode_atts
*
* @todo create other constants like the one setup for sql log entries
* @todo create option to add entries to server error log file
*/
function csv2post_log($atts){     
    global $csv2post_adm_set,$wpdb,$csv2post_currentversion;

    // if ALL logging is off - if ['uselog'] not set then logging for all files is on by default
    if(isset($csv2post_adm_set['reporting']['uselog']) && $csv2post_adm_set['reporting']['uselog'] == 0){return false;}
    
    // if log table does not exist return false
    if(!csv2post_WP_SQL_does_table_exist('csv2post_log')){return false;}
    
    // if a value is false, it will not be added to the insert query, we want the database default to kick in, NULL mainly
    extract( shortcode_atts( array(  
        'outcome' => 1, 
        'line' => false, 
        'file' => false, 
        'function' => false, 
        'sqlresult' => false, 
        'sqlquery' => false, 
        'sqlerror' => false, 
        'wordpresserror' => false, 
        'screenshoturl' => false, 
        'userscomment' => false, 
        'page' => false, 
        'version' => $csv2post_currentversion, 
        'panelid' => false, 
        'panelname' => false, 
        'tabscreenid' => false, 
        'tabscreenname' => false, 
        'dump' => false, 
        'ipaddress' => false, 
        'userid' => false,    
        'noticemessage' => false,      
        'comment' => false,
        'type' => false,
        'category' => false, 
        'action' => false,
        'priority' => false                               
    ), $atts ) );
    
    // start query
    $query = "INSERT INTO `csv2post_log`";
    
    // add columns and values
    $query_columns = '(outcome';
    $query_values = '(1';
    
    if($line){$query_columns .= ',line';$query_values .= ',"'.$line.'"';}
    if($file){$query_columns .= ',file';$query_values .= ',"'.$file.'"';}                                                                           
    if($function){$query_columns .= ',function';$query_values .= ',"'.$function.'"';}  
    if($sqlresult){$query_columns .= ',sqlresult';$query_values .= ',"'.$sqlresult.'"';}     
    if($sqlquery){$query_columns .= ',sqlquery';$query_values .= ',"'.$sqlquery.'"';}     
    if($sqlerror){$query_columns .= ',sqlerror';$query_values .= ',"'.$sqlerror.'"';}    
    if($wordpresserror){$query_columns .= ',wordpresserror';$query_values .= ',"'.$wordpresserror.'"';}     
    if($screenshoturl){$query_columns .= ',screenshoturl';$query_values .= ',"'.$screenshoturl.'"' ;}     
    if($userscomment){$query_columns .= ',userscomment';$query_values .= ',"'.$userscomment.'"';}     
    if($page){$query_columns .= ',page';$query_values .= ',"'.$page.'"';}     
    if($version){$query_columns .= ',version';$query_values .= ',"'.$version.'"';}     
    if($panelid){$query_columns .= ',panelid';$query_values .= ',"'.$panelid.'"';}     
    if($panelname){$query_columns .= ',panelname';$query_values .= ',"'.$panelname.'"';}     
    if($tabscreenid){$query_columns .= ',tabscreenid';$query_values .= ',"'.$tabscreenid.'"';}     
    if($tabscreenname){$query_columns .= ',tabscreenname';$query_values .= ',"'.$tabscreenname.'"';}     
    if($dump){$query_columns .= ',dump';$query_values .= ',"'.$dump.'"';}     
    if($ipaddress){$query_columns .= ',ipaddress';$query_values .= ',"'.$ipaddress.'"';}     
    if($userid){$query_columns .= ',userid';$query_values .= ',"'.$userid.'"';}     
    if($noticemessage){$query_columns .= ',noticemessage';$query_values .= ',"'.$noticemessage.'"';}     
    if($comment){$query_columns .= ',comment';$query_values .= ',"'.$comment.'"';}     
    if($type){$query_columns .= ',type';$query_values .= ',"'.$type.'"';}     
    if($category){$query_columns .= ',category';$query_values .= ',"'.$category.'"';}     
    if($action){$query_columns .= ',action';$query_values .= ',"'.$action.'"';}     
    if($priority){$query_columns .= ',priority';$query_values .= ',"'.$priority.'"';}     

    // end columns and values string
    $query_columns .= ')';
    $query_values .= ')';
    
    // add VALUES
    $query .= $query_columns .' VALUES '. $query_values;
        
    $wpdb->query( $query );     
}

/**
* Log form submissions on admin side
*/
function csv2post_log_adminform($function,$outcome,$action,$comment = 'unknown',$type = 'general',$priority = 'normal',$dump = 'unknown',$wordpresserror = 'none'){    
                           
    $atts = array();             
    $atts['outcome'] = $outcome;
    $atts['function'] = $function; 
    $atts['wordpresserror'] = $wordpresserror;;
    //$atts['tabscreenname'] = $tabscreenname; # not in use 
    $atts['dump'] = $dump;
    $atts['comment'] = $comment;
    $atts['type'] = $type;
    $atts['action'] = $action;
    $atts['priority'] = $priority;          
    
    // default values
    $atts['userid'] = get_current_user_id();       
    $atts['category'] = 'adminform'; 
    $atts['page'] = $_POST['csv2post_hidden_pageid'];
    $atts['panelname'] = $_POST['csv2post_hidden_panel_name'];
    $atts['paneltitle'] = $_POST['csv2post_hidden_panel_title'];
    $atts['tabscreenid'] = $_POST['csv2post_hidden_tabnumber'];                              
            
    csv2post_log($atts);     
}


/**
* This will log sql queries and details of any failures in a way that helps debug. 
*/
function csv2post_log_sql($comment,$function,$file,$line,$recordid = 'NA',$dump = 'NA',$sqlresult = 'NA',$sqlquery = 'NA',$outcome = 'success'){
    $atts = array();             
    $atts['outcome'] = $outcome;// success,failed
    $atts['comment'] = $comment;
    $atts['line'] = $line;
    $atts['file'] = $file;
    $atts['function'] = $function;
    $atts['dump'] = $dump;
    $atts['sqlresult'] = $sqlresult;
    $atts['sqlquery'] = $sqlquery;
    $atts['recordid'] = $recordid;
    // set log type so the log entry is made to the required log file
    $atts['type'] = 'sql';    
    csv2post_log($atts);    
}        

/**
* Admin log is about tracing admin users actions, tracing staffs use.
* Place the csv2post_log_user() function in form processing.
*/
function csv2post_log_users($message,$ipaddress = 'NA',$userid = 'NA',$panelname = 'NA',$paneltitle = 'NA',$page = 'NA'){
    $atts = array();              
    $atts['userid'] = $userid;
    $atts['message'] = $message;
    $atts['panelname'] = $panelname;
    $atts['paneltitle'] = $paneltitle;
    $atts['page'] = $page;
    $atts['ipaddress'] = $ipaddress;
    // set log type so the log entry is made to the required log file
    $atts['type'] = 'users';    
    csv2post_log($atts);  
}

/**
* Log all errors (these are plugin faults where we reach a place in code we should not and need to know about it)
* Do not log users own mistakes here (error is a term used in notices but it is not the same type of error)  
*/
function csv2post_log_error($message,$line,$function,$file,$dump = 'NA'){
    $atts = array();             
    $atts['line'] = $line;
    $atts['function'] = $function;
    $atts['file'] = $file;
    $atts['message'] = $message;
    $atts['dump'] = $dump;
    // set log type so the log entry is made to the required log file
    $atts['type'] = 'error';    
    csv2post_log($atts);     
}

/**
* Make log entry in install log
*/
function csv2post_log_install($action,$message,$userid = 'NA'){
    $atts = array();             
    $atts['action'] = $action;
    $atts['userid'] = $userid;
    $atts['message'] = $message;
    // set log type so the log entry is made to the required log file
    $atts['type'] = 'install';    
    csv2post_log($atts);    
}

/**
* @deprecated use csv2post_n()
* 
* Creates a new notification with a long list of style options available.
* Can return the message for echo or add it to an array, which can also be stored for persistent messages.
* Requires visitor to be logged in and on an admin page, dont need to do prevalidation before calling function
*     
* Dont include a title attribute if you want to use defaults and stick to a standard format
*  
* @param string $message, main message
* @param mixed $type, determines colour styling (question,info,success,warning,error,processing,stop,step)
* @param mixed $size, determines box size (Tiny,Small,Large,Extra)
* @param mixed $title, a simple header
* @param mixed $helpurl, when required can offer link to help content (will be added closer to 2013)
* @param mixed $output_type (echo,return,public) 

* Output Types
* 1. echo - admin side only, adds notification to an array which is output in one place, allowing many notifications to be printed in a list
* 2. return - returns the html for doing as we want, usually we use echo to display notification in specific place
* 3. public - returns the html for use on front-end, bypasses is_admin() which exists as a safety measure to prevent admin information being displayed on front-end in error

* @deprecated, use csv2post_n()
*/
function csv2post_notice($message,$type = 'success',$size = 'Extra',$title = false, $helpurl = 'www.csv2post.com/support', $output_type = 'echo',$persistent = false,$clickable = false,$user_type = false){

    if(is_admin() || $output_type == 'public'){
        
        // change unexpected values into expected values (for flexability and to help avoid fault)
        if($type == 'accepted'){$type == 'success';}
        if($type == 'fault'){$type == 'error';}
        if($type == 'next'){$type == 'step';}
        
        // prevent div being clickable if help url giving (we need to more than one link in the message)
        if($helpurl != false && $helpurl != '' && $helpurl != 'http://www.csv2post.com/support'){$clickable = false;}
                                 
        if($output_type == 'return' || $output_type == 'public'){   
            return csv2post_notice_display($type,$helpurl,$size,$title,$message,$clickable,$persistent);
        }else{
            global $csv2post_notice_array;

            // establish next array key
            $next_key = 0;
            if(isset($csv2post_notice_array['notifications'])){
                $next_key = csv2post_get_array_nextkey($csv2post_notice_array['notifications']);
            }
            
            // add new message to the notifications array
            $csv2post_notice_array['notifications'][$next_key]['message'] = $message;
            $csv2post_notice_array['notifications'][$next_key]['type'] = $type;
            $csv2post_notice_array['notifications'][$next_key]['size'] = $size;
            $csv2post_notice_array['notifications'][$next_key]['title'] = $title;
            $csv2post_notice_array['notifications'][$next_key]['helpurl'] = $helpurl; 
            $csv2post_notice_array['notifications'][$next_key]['clickable'] = $clickable;        
        }
    }
}

/**
* New Notice Function (replacing csv2post_notice())
* 1. None clickable (using a different function for that)
* 2. Not a Step Notice (also using a different function for that)
* 3. Does add link for help url though

* ToDo list brought over from old function
* @todo MEDIUMPRIORITY, allow shorter $size and $type values plus change $size to lowercase in code and in styling, just makes it a bit easier to avoid making mistake
* @todo MEDIUMPRIORITY, allow optional settings array, can we do this and have the existing parameters in place?
* @todo HIGHPRIORITY, change the arrow to a "Help" button and also add "Go To" button, also add local url parameter to display both Help and Go To buttons on a notification. Scrap the Next Step approach, it does not allow for highly custom html once link is applied
* @todo LOWPRIORITY, create options for creating lists of notifications with numbered icons or CSS styled numbers
*/
function csv2post_n($title,$mes,$style,$size,$atts = array()){

    extract( shortcode_atts( array( 
        'url' => false,
        'output' => 'norm',// default normal echos html, return will return html, public also returns it but bypasses is_admin() etc
        'audience' => 'admin',// admin or user (use to display a different message to visitors than to staff)
        'user_mes' => 'No user message giving',// only used when audience is set to user, user_mes replaces $mes
        'side' => 'private',// private,public (use to apply themes styles if customised, do not use for security)      
        'clickable' => false,// boolean
    ), $atts ) );
     
    // do not allow a notice box if $output not stated as public and current visitor is not logged in
    // this forces backend messages which may be more private i.e. account info or key admin details
    if(!is_admin() && $output != 'public'){
        // visitor is on front-end, but the $output set is not for public
        return false; 
    }

    // if return wanted or $side == public (used to bypass is_admin() check)
    // this allows the notice to be printed within content where the function is called rather than within the $csv2post_notice_array loop
    if($output == 'return' || $output == 'public'){
        return csv2post_notice_display($style,$url,$size,$title,$mes,$clickable,$persistent = false);
    }
    
    // arriving here means normal, most common output to the backend of Wordpress
    global $csv2post_notice_array;// this is where notice is stored prior to being output by plugin 
       
    // set next array key value
    $next_key = 0;

    // determine next array key
    if(isset($csv2post_notice_array['notifications'])){
        $next_key = csv2post_get_array_nextkey($csv2post_notice_array['notifications']);
    }    

    // add new message to the notifications array
    // this will be output during the current page loading. The notification will show once unless persistent is set to true
    $csv2post_notice_array['notifications'][$next_key]['message'] = $mes;
    $csv2post_notice_array['notifications'][$next_key]['type'] = $style;
    $csv2post_notice_array['notifications'][$next_key]['size'] = $size;
    $csv2post_notice_array['notifications'][$next_key]['title'] = $title;
    $csv2post_notice_array['notifications'][$next_key]['helpurl'] = $url; 
    $csv2post_notice_array['notifications'][$next_key]['output'] = $output;
    $csv2post_notice_array['notifications'][$next_key]['audience'] = $audience;
    $csv2post_notice_array['notifications'][$next_key]['user_mes'] = $user_mes;
    $csv2post_notice_array['notifications'][$next_key]['side'] = $side;
    $csv2post_notice_array['notifications'][$next_key]['clickable'] = $clickable;
}

/**
* Creates a persistent notice
* 
* @param mixed $title
* @param mixed $message
* @param mixed $type
* @param mixed $size
* @param mixed $atts
*/
function csv2post_notice_persistent($title,$message,$type,$size,$atts){

    extract( shortcode_atts( array( 
        'url' => false,
        'output' => 'norm',// default normal echos html, return will return html, public also returns it but bypasses is_admin() etc
        'audience' => 'admin',// admin or user (use to display a different message to visitors than to staff)
        'user_mes' => 'No user message giving',// only used when audience is set to user, user_mes replaces $mes
        'side' => 'private',// private,public (use to apply themes styles if customised, do not use for security)      
        'clickable' => false,// boolean
        'placement_type' => 'global',// global, page, screen, panel
        'placement_specific' => false,// page slug, screen number, panel id
        'pageid' => false,// used when placement_type is screen
        'id' => rand(100,10000) . time(),// instance id             
    ), $atts ) );

    // get persistent notice array
    global $csv2post_persistent_array;
    $per = csv2post_get_option_persistentnotifications_array();

    // avoid 
    // set next array key value
    $next_key = 0;

    // determine next array key
    if(isset($per['notifications'])){
        $next_key = csv2post_get_array_nextkey($per['notifications']);
    }   
     
    $per['notifications'][$next_key]['message'] = $message;
    $per['notifications'][$next_key]['type'] = $type;
    $per['notifications'][$next_key]['size'] = $size;
    $per['notifications'][$next_key]['title'] = $title;
    $per['notifications'][$next_key]['helpurl'] = $url; 
    $per['notifications'][$next_key]['output'] = $output;
    $per['notifications'][$next_key]['audience'] = $audience;
    $per['notifications'][$next_key]['user_mes'] = $user_mes;
    $per['notifications'][$next_key]['side'] = $side;
    $per['notifications'][$next_key]['clickable'] = $clickable;
    $per['notifications'][$next_key]['placement_type'] = $placement_type;      
    $per['notifications'][$next_key]['placement_specific'] = $placement_specific;  
    $per['notifications'][$next_key]['pageid'] = $pageid;  
                        
    // generate a unique notice ID, no need to validate it if we use time()
    $per['notifications'][$next_key]['id'] = $id;

    // for persistence we save the notifications array
    csv2post_update_option_persistentnotifications_array($per);
}

/**
* Returns notification HTML.
* This function has the html and css to make all notifications standard.

* @param mixed $type
* @param string $helpurl
* @param string $size
* @param string $title
* @param string $message
* @param bool $clickable
* @param mixed $persistent
* @param mixed $id, used for persistent messages which use jQuery UI button, the ID should be the notice ID
*/
function csv2post_notice_display($type,$helpurl,$size,$title,$message,$clickable,$persistent = false,$id = false){
    // begin building output
    $output = '';
                    
    // if clickable (only allowed when no other links being used) - $helpurl will actually be a local url to another plugin or Wordpress page
    if($clickable){
        $output .= '<div class="stepLargeTest"><a href="'.$helpurl.'">';
    }

    // start div
    $output .= '<div class="'.$type.$size.'">';     
   
    // set h4 when required
    if($size != 'Tiny'){$output .= '<h4>'.$title.'</h4>';}

    $output .= '<p>' . $message . '</p>';

    // if is not clickable (entire div) and help url is not null then display a clickable ico
    $thelink = '';
    if($helpurl != '' && $helpurl != false){
        //$output .= '<a class="jquerybutton" href="'.$helpurl.'" target="_blank">Get Help</a>';
    }   
        
    // complete notice with closing div
    $output .= '</div>';
    
    // end wrapping with link and styled div for making div clickable when required
    if($clickable){$output .= '</a></div>';}

    return $output;    
}

function csv2post_persistentnotice_display($type,$helpurl,$size,$title,$message,$persistent = false,$id = false){
    // ID is required to prevent conflict with other persistent notices and for deleting them
    if($id == false){
        return;
    }
    
    global $csv2post_form_action; 

    // start div
    $output = '<div class="'.$type.$size.'">';
        
    // if is not clickable (entire div) and help url is not null then display a clickable icon
    $thelink = '';
    if($helpurl != '' && $helpurl != false){
        ### TODO:HIGHPRIORITY, finish ability to add a help link
        //$thelink = '<a href="'.$helpurl.'" target="_blank">Get Help</a>';
    }   
   
    // set h4 when required
    if($size != 'Tiny'){$output .= '<h4>'.$title.'</h4>';}

    // if persistent message, add link for deleting the message
    $output .= '
    <p>' . $message . '</p>

    <form id="csv2post_notice_delete" method="post" name="csv2post_notice_delete" action="'.$csv2post_form_action.'">
        
        <input type="hidden" id="csv2post_post_processing_required" name="csv2post_post_processing_required" value="true">       
        <input type="hidden" id="csv2post_post_deletenotice_id" name="csv2post_post_deletenotice_id" value="'.$id.'">       
        <input type="hidden" id="csv2post_post_deletenotice" name="csv2post_post_deletenotice" value="true">
        
        <div class="jquerybutton">
        
            <button id="csv2post_notice_delete_'.$id.'">Delete Notice</button>

            '.$thelink.'

        </div>
    </form>';    
    
    // complete notice with closing div
    $output .= '</div>';

    return $output;    
}


/**
* Outputs the contents of $csv2post_notice_array, used in csv2post_header_page.
* Will hold new and none persistent notifications. May also hold persistent. 
*/
function csv2post_notice_output(){
    global $csv2post_notice_array;
    if(isset($csv2post_notice_array['notifications'])){
       
        foreach($csv2post_notice_array['notifications'] as $key => $notice){

            // set default values where any requires are null
            if(!isset($notice['type'])){$notice['type'] = 'info';}
            if(!isset($notice['helpurl'])){$notice['helpurl'] = false;} 
            if(!isset($notice['size'])){$notice['size'] = 'Large';} 
            if(!isset($notice['title'])){$notice['title'] = 'Sorry No Title Was Provided';}
            if(!isset($notice['message'])){$notice['message'] = 'Sorry No Message Was Provided';}
            if(!isset($notice['clickable'])){$notice['clickable'] = false;} 
            if(!isset($notice['persistent'])){$notice['persistent'] = false;}
            if(!isset($notice['id'])){$notice['id'] = false;} 
              
            echo csv2post_notice_display($notice['type'],$notice['helpurl'],$notice['size'],$notice['title'],$notice['message'],$notice['clickable'],$notice['persistent'],$notice['id']);                                               
        }
    }  
}

/**
* Standard notice format to be displayed on submission of a form (Large).
* Change the size if a plugin using core is to have a different format.
* 
* @deprecated use csv2post_n_postresult as of 13th February 2013
*/
function csv2post_notice_postresult($type,$title,$message,$helpurl = false,$user = 'admin'){
    csv2post_notice($message,$type,'Large',$title, $helpurl, 'echo');    
}

/**
* Display a standard notification after form submission.
* This function simply helps to quickly apply a notice to the outcome while using the same
* configuration for all form submissions.
* 
* @param mixed $type
* @param mixed $title
* @param mixed $message
* @param mixed $helpurl
* @param mixed $user
*/
function csv2post_n_postresult($type,$title,$message,$helpurl = false,$user = 'admin'){
    csv2post_notice($message,$type,'Large',$title, $helpurl, 'echo');    
}
     
/**
* Standard notice format to be displayed at the top of a screen (Tiny)
*/
function csv2post_n_screeninfo($title,$message,$helpurl = false,$user = 'admin'){
    echo csv2post_notice($message,'info','Tiny',$title, $helpurl, 'return');    
}

/**
* Standard notice format to be displayed inside a panel as information
*/
function csv2post_n_panelinfo($title,$message,$helpurl = false,$user = 'admin'){
    echo csv2post_notice($message,'info','Small',$title, $helpurl, 'return');    
}

/**
* Standard notice format for displaying notice on public side
*/
function csv2post_n_public($title,$message,$helpurl = false){
    echo csv2post_n($title,$message,'info','Small',array('output' => 'public','url' => $helpurl));    
}

/**
* Notice html is printed where this function is used 
*/
function csv2post_n_incontent($message,$type = 'info',$size = 'Small',$title = '',$helpurl = ''){
    echo csv2post_notice($message,$type,$size,$title, $helpurl, 'return');    
}

/**
* Returns the html for a notice box that can be clicked on and styled as the "Next Step".
* This is easier to use than wtgcsv_notice() for when the next step box is required.
* 
* 1. Do not add links inside the message content as the entire div is linked
* 2. This is only be used to suggest the next step users should take
* 3. This function always returns, it cannot be used to update the notifications array
* 
* @param mixed $type
* @param mixed $helpurl
* @param mixed $size
* @param mixed $title
* @param mixed $message
* @todo MEDIUMPRIORITY, do a check to determine if user is already on the clickable url, if they are then we suggest it on the message
*/
function csv2post_notice_display_step($helpurl,$title,$message){
    $output = '<div class="stepLargeTest"><a href="'.$helpurl.'">    
    <div class="stepLarge"><h4>'.$title.'</h4>'. $message .'</div></a></div>';
    return $output;    
}

/**
* Displays notice if combined CSV file size is more than recommended for the interface to easily handle
* 104857600 = 100 MB 
*/
function csv2post_notice_filesizetotal($mb){
    if($mb > 104857600){
        echo csv2post_notice('Your CSV files combined size is larger than 100MB, it is recommended that you delete any files
        not in use to reduce memory usage and increase plugin interface performance','notice','Tiny','','','return');
    }      
}

/**
* Performs a var_dump with <pre> using the giving value, but only if debug mode active.
* This is good for debugging and not accidently leaving the dump in the code on release 
*/
function csv2post_var_dump($v,$h = false){
    global $csv2post_debug_mode;
    if($csv2post_debug_mode){
        
        // if header wanted
        if($h){
            echo '<h1>'.$h.'</h1>';
        }
        
        echo '<pre>';
        var_dump($v);
        echo '</pre>';
    }
}

/**
* Flags the giving post by adding _csv2post_flagged meta value which is used in the flagging system.
*     
* @param integer $post_ID
* @param integer $priority, 1 = low priority (info style notification), 2 = unsure of priority (warning style notification), 3 = high priority (error style notification)
* @param string $type, keyword to enhance search ability (USED:updatefailure ) 
* @param string $reason, as much information as required for user to take the required action or know they can delete the flag
*/
function csv2post_flag_post($post_ID,$priority,$type,$reason){
    // if a value is missing return
    if(!isset($post_ID) || !isset($priority) || !isset($time) || !isset($reason) || !isset($type)){
        ### LOG THIS
        return false;
    }
    
    $testarray['priority'] = $priority;
    $testarray['time'] = time();
    $testarray['reason'] = $reason;
    $testarray['type'] = 'updatefailure';
    add_post_meta($post_ID,'_csv2post_flagged',$testarray,false);   
}

/**
* CSV 2 POST function for logging project changes.
* The main intention is to aid support. We will use this log to check what the user is doing with their project.
* 
* @param mixed $post_id
* @param mixed $post_title
* @param mixed $action (created,updated,deleted,checked) (check: for updating etc but nothing done, just the check done)
* @param mixed $message
* @param mixed $project_name
*/
function csv2post_log_posts($post_id,$post_title,$action,$message,$project_name){
    $atts = array();   
    $atts['logged'] = csv2post_date();
    $atts['postid'] = $post_id;
    $atts['posttitle'] = $post_title;
    $atts['action'] = $action;
    $atts['message'] = $message; 
    $atts['projectname'] = $project_name;
    // set log type so the log entry is made to the required log file
    $atts['type'] = 'posts';
    csv2post_log($atts);    
}

/**
* Use this to log automated events and track progress in automated scripts.
* Mainly used in schedule function but can be used in any functions called by add_action() or
* other processing that is triggered by user events but not specifically related to what the user is doing.
* 
* @param mixed $outcome
* @param mixed $trigger schedule, hook (action hooks such as text spinning could be considered automation), cron, url, user (i.e. user does something that triggers background processing)
* @param mixed $line
* @param mixed $file
* @param mixed $function
*/
function csv2post_log_schedule($action,$outcome,$trigger = 'schedule',$line = 'NA',$file = 'NA',$function = 'NA'){
    $atts = array();   
    $atts['logged'] = csv2post_date();
    $atts['action'] = $action;
    $atts['outcome'] = $outcome;
    $atts['trigger'] = $trigger;
    $atts['line'] = $line;
    $atts['file'] = $file;
    $atts['function'] = $function;
    // set log type so the log entry is made to the required log file
    $atts['type'] = 'automation';
    csv2post_log($atts);    
}

/**
* Make log entries into the data log file, a log file specific to CSV 2 POST. 
* This function is not to be moved to the wtgcore. 
*/
function csv2post_log_data($comment,$line,$file,$function,$dump = 'NA',$sqlresult = 'NA',$sqlquery = 'NA',$lastrecordedid = 'NA',$jobid = 'NA'){
    $atts = array();   
    $atts['lastrecordedid'] = $lastrecordedid;
    $atts['jobid'] = $jobid;
    $atts['comment'] = $comment;
    $atts['line'] = $line;
    $atts['file'] = $file;
    $atts['function'] = $function;
    $atts['dump'] = $dump;
    $atts['sqlresult'] = $sqlresult;
    $atts['sqlquery'] = $sqlquery;
    // set log type so the log entry is made to the required log file
    $atts['type'] = 'data';    
    csv2post_log($atts);       
}

/**
* Gets notifications array if it exists in Wordpress options table else returns empty array
*/
function csv2post_get_option_persistentnotifications_array(){
    $a = get_option('csv2post_notifications');
    $v = maybe_unserialize($a);
    if(!is_array($v)){
        return array();    
    }
    return $v;    
}
?>
