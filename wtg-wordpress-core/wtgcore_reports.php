<?php
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
function wtgcore_log($atts){

    /*
    Default Attributes (custom fields use different attributes)
    $atts = array();             
    $atts['priority'] = 10;// (1-10) 1 high priority, 5 unsure, 10 low priority 
    $atts['date'] = csv2post_date();// csv2post_date() 
    $atts['comment'] = 'None';// comment to help users or developers (recommended 60-80 characters long)
    $atts['line'] = __LINE__; 
    $atts['file'] = __FILE__;
    $atts['function'] = __FUNCTION__;
    $atts['dump'] = 'None';// anything, variable, text, url, html, php
    $atts['sql_result'] = 'NA';// wordpress sql result value
    $atts['sql_query'] = 'NA';// wordpress sql query value
    $atts['type'] = 'general';// general, sql, admin, user, error (can be others but all fit into these categories)
    wtgcore_log($atts);    
    */
       
    /**
    * USED CATEGORIES
    * 1. Data Import Job
    */    
     
    global $csv2post_adm_set,$csv2post_logfiles_array;

    // if ALL logging is off - if ['uselog'] not set then logging for all files is on by default
    if(isset($csv2post_adm_set['reporting']['uselog']) && $csv2post_adm_set['reporting']['uselog'] == 0){
        return false;
    }
    
    // we loop through logs headers to build extraction array
    $extraction_array = array();
    $extraction_array['date'] = csv2post_date();// set this now and it can be changed later in script
    $extraction_array['type'] = false;// must be changed from false to a log type for rest of function to work
    foreach($csv2post_logfiles_array[$atts['type']]['headers'] as $headerkey => $header){
        $extraction_array[$headerkey] = 'Unknown';
    }
    
    // run extraction and shortcode_atts(), $atts overwrites "Unknown" or other defaults such as date if date set in $atts  
    extract( shortcode_atts( $extraction_array, $atts ) );
                          
    // if requested log file not active
    if(!isset($csv2post_adm_set['log_'.$type.'_active']) || $csv2post_adm_set['log_'.$type.'_active'] == false){
        return false;    
    }
                                 
    // establish log file size limit
    $log_file_limit = 307200;
    if(isset($csv2post_adm_set['reporting']['loglimit']) && is_numeric($csv2post_adm_set['reporting']['loglimit'])){
        $log_file_limit = $csv2post_adm_set['reporting']['loglimit'];
    }
                         
    // run auto deletion of log file if file size limit reached
    wtgcore_logfile_autodelete($type,$log_file_limit);
                      
    // check if file exists, else create it with a header
    if(!wtgcore_logfile_exists($type)){
        wtgcore_create_logfile($type);
    }
                       
    // if log file still does not exist (failure on creating it)
    if(!wtgcore_logfile_exists($type)){
        return false;
    }
        
    // general, sql, admin, user, error (files must be named WTG_C2P_ABB.'log_'.$logtype.'.csv )
    $logfile_path = wtgcore_logfilepath($type); 
      
    // build the new csv file row by looping through header names and using eval to set them as variables   
    $write = array();         
    $write[0] = $date;
    foreach($csv2post_logfiles_array[$atts['type']]['headers'] as $headerkey => $header){
        $write[] = $$headerkey;// each header should be a variable by now after extract( shortcode_atts())
    }    
    
    @$fp = fopen( $logfile_path, 'a');
    @fputcsv($fp, $write);
    @fclose($fp);
}


/**
* This will log sql queries and details of any failures in a way that helps debug. 
*/
function wtgcore_log_sql($comment,$function,$file,$line,$recordid = 'NA',$dump = 'NA',$sqlresult = 'NA',$sqlquery = 'NA',$outcome = 'success'){
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
    // call log function which performs log and uses $csv2post_logfiles_array
    wtgcore_log($atts);    
}

/**
* Admin log is about tracing admin users actions, tracing staffs use.
* Place the wtgcore_log_user() function in form processing.
*/
function wtgcore_log_users($usertype,$side,$message,$ipaddress = 'NA',$userid = 'NA',$username = 'NA',$panelname = 'NA',$paneltitle = 'NA',$page = 'NA'){
    $atts = array();              
    $atts['userid'] = $userid;
    $atts['username'] = $username;
    $atts['usertype'] = $usertype;
    $atts['side'] = $side; 
    $atts['message'] = $message;
    $atts['panelname'] = $panelname;
    $atts['paneltitle'] = $paneltitle;
    $atts['page'] = $page;
    $atts['ipaddress'] = $ipaddress;
    // set log type so the log entry is made to the required log file
    $atts['type'] = 'users';    
    // call log function which performs log and uses $csv2post_logfiles_array
    wtgcore_log($atts);  
}

/**
* Log all errors (these are plugin faults where we reach a place in code we should not and need to know about it)
* Do not log users own mistakes here (error is a term used in notices but it is not the same type of error)  
*/
function wtgcore_log_error($message,$line,$function,$file,$dump = 'NA'){
    $atts = array();             
    $atts['line'] = $line;
    $atts['function'] = $function;
    $atts['file'] = $file;
    $atts['message'] = $message;
    $atts['dump'] = $dump;
    // set log type so the log entry is made to the required log file
    $atts['type'] = 'error';    
    // call log function which performs log and uses $csv2post_logfiles_array
    wtgcore_log($atts);     
}

/**
* Make log entry in install log
*/
function wtgcore_log_install($action,$message,$userid = 'NA'){
    $atts = array();             
    $atts['action'] = $action;
    $atts['userid'] = $userid;
    $atts['message'] = $message;
    // set log type so the log entry is made to the required log file
    $atts['type'] = 'install';    
    // call log function which performs log and uses $csv2post_logfiles_array
    wtgcore_log($atts);    
}

/**
* Create giving log file
* 
* @returns boolean, true if file is created or already exists, false otherwise
* 
* @param string $logtype, general,admin,user,sql,error 
*/
function wtgcore_create_logfile($logtype){       
    if (wtgcore_logfile_exists($logtype)) {
        return true;
    }else{
        global $csv2post_logfiles_array;

        // ensure directory exists
        if(!is_dir(WTG_C2P_CONTENTFOLDER_DIR)){
            if (!mkdir(WTG_C2P_CONTENTFOLDER_DIR, 0700, true)) {
                ### @todo log this matter in options (functions to be written)
                return false;
            }
        }

        $logfilepath = wtgcore_logfilepath($logtype);
        
        $fp = fopen(wtgcore_logfilepath($logtype),'w');
           
        if( !$fp ){    
            ### TODO:LOWPRIORITY, if debug mode on display notice else do a server log of this          
        }else{
           
            // build header row (start with defaults that apply to all files, mainly date)
            $csv2post_logfile_header = array();
            $csv2post_logfile_header[] = 'date';
            foreach($csv2post_logfiles_array[$logtype]['headers'] as $headerkey => $header){
                $csv2post_logfile_header[] = $headerkey;
            }              
                    
            $result = fputcsv($fp, $csv2post_logfile_header );//Returns the length of the written string or FALSE on failure.
            fclose($fp);

            return $result;
        }    
    } 
}

/**
* Delete giving log file
* @return boolean
* @param string $logtype (error,user,admin,general,sql)
*/
function wtgcore_delete_logfile($logtype){
    return unlink(wtgcore_logfilepath($logtype));    
} 

/**
* Disables log entries for giving log file
* 
* @global $csv2post_adm_set
* @param mixed $logtype
* @return returns the response from update_option function
*/
function wtgcore_disable_logfile($logtype){
    global $csv2post_adm_set;
    $csv2post_adm_set = csv2post_get_option_adminsettings();
    if($csv2post_adm_set){
        $csv2post_adm_set['log_'.$logtype.'_active'] = false;
        return csv2post_update_option_adminsettings($csv2post_adm_set);
    }
}

/**
* Activate giving log file
* 
* @global $csv2post_adm_set
* @param string $logtype (sql,error,user,admin,general)
* @return bool
*/
function wtgcore_activate_logfile($logtype){
    global $csv2post_adm_set;
    $csv2post_adm_set['log_'.$logtype.'_active'] = true;
    csv2post_update_option_adminsettings($csv2post_adm_set);
}

/**
 * Checks if history file exists
 * @param string $historytype (general,sql,admin,user,error)
 * @return boolean
 * 
 * @todo adapt to allow log file location to be changed and this function too use the new location not the default   
 */
function wtgcore_logfile_exists($logtype){
    return file_exists(wtgcore_logfilepath($logtype));
}

/**
* Deletes log file if over specific size 
* Must ensure file exists before calling this function
* 
* @param string $logtype (general,error,sql,admin,user)
* @param integer $sizelimit, state the maximum bytes (307200 = 300kb which is a reasonable size and is default)
*/
function wtgcore_logfile_autodelete($logtype,$sizelimit = 307200){
    // check file size - delete if over 300kb as stated on Log page
    if( filesize( wtgcore_logfilepath($logtype) ) > $sizelimit ){
        return unlink( wtgcore_logfilepath($logtype) );
    }    
}             
                    
/**
* Returns the full path to giving log file
* 
* @param string $logtype (admin,user,error,sql,general = default)
*/
function wtgcore_logfilepath($logtype = 'general'){
    return WTG_C2P_CONTENTFOLDER_DIR.'/'.WTG_C2P_ABB.'log_'.$logtype.'.csv'; 
}

/**
* @deprecated use wtgcore_n()
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
* @param mixed $helpurl, when required can offer link too help content (will be added closer to 2013)
* @param mixed $output_type (echo,return,public) 
* @param mixed $persistent, boolean (true will mean the message stays until user deletes it manually)
* 
* Output Types
* 1. echo - admin side only, adds notification to an array which is output in one place, allowing many notifications to be printed in a list
* 2. return - returns the html for doing as we want, usually we use echo to display notification in specific place
* 3. public - returns the html for use on front-end, bypasses is_admin() which exists as a safety measure to prevent admin information being displayed on front-end in error
* 
* @todo LOWPRIORITY, change $output_type to array, echo, public (with echo replacing return and array replacing echo)
* @todo MEDIUMPRIORITY, when a notification is to be returned AND is persistent, it needs to be persistent where ever it is displayed, need to check if user has already closed notification by storing its ID in notification array
* @todo LOWPRIORITY, provide permanent closure button, will this be done with a dialogue ID to prevent it opening again 
* @todo LOWPRIORITY, add a paragraphed section of the message for a second $message variable for extra information
* @todo MEDIUMPRIORITY, allow shorter $size and $type values plus change $size to lowercase in code and in styling, just makes it a bit easier to avoid making mistake
* @todo MEDIUMPRIORITY, allow optional settings array, can we do this and have the existing parameters in place?
* @todo HIGHPRIORITY, change the arrow to a "Help" button and also add "Go To" button, also add local url parameter to display both Help and Go To buttons on a notification. Scrap the Next Step approach, it does not allow for highly custom html once link is applied
* @todo LOWPRIORITY, create options for creating lists of notifications with numbered icons or CSS styled numbers
* 
*/
function wtgcore_notice($message,$type = 'success',$size = 'Extra',$title = false, $helpurl = 'www.csv2post.com/support', $output_type = 'echo',$persistent = false,$clickable = false,$user_type = false){

    if(is_admin() || $output_type == 'public'){
        
        // change unexpected values into expected values (for flexability and to help avoid fault)
        if($type == 'accepted'){$type == 'success';}
        if($type == 'fault'){$type == 'error';}
        if($type == 'next'){$type == 'step';}
        
        // prevent div being clickable if help url giving (we need to more than one link in the message)
        if($helpurl != false && $helpurl != '' && $helpurl != 'http://www.csv2post.com/support'){$clickable = false;}
                                 
        if($output_type == 'return' || $output_type == 'public'){   
            return wtgcore_notice_display($type,$helpurl,$size,$title,$message,$clickable,$persistent);
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
            $csv2post_notice_array['notifications'][$next_key]['persistent'] = $persistent;
            
            // if notification is persistent requiring user to delete it (not adding the value otherwise makes the array lighter)
            if($persistent){
                csv2post_update_option_notifications_array($csv2post_notice_array);   
            }          
        }
    }
}

/**
* New Notice Function (replacing wtgcore_notice())
* 1. None clickable (using a different function for that)
* 2. Not a Step Notice (also using a different function for that)
* 3. Does add link for help url though

* ToDo list brought over from old function
* @todo LOWPRIORITY, add a paragraphed section of the message for a second $message variable for extra information
* @todo MEDIUMPRIORITY, allow shorter $size and $type values plus change $size to lowercase in code and in styling, just makes it a bit easier to avoid making mistake
* @todo MEDIUMPRIORITY, allow optional settings array, can we do this and have the existing parameters in place?
* @todo HIGHPRIORITY, change the arrow to a "Help" button and also add "Go To" button, also add local url parameter to display both Help and Go To buttons on a notification. Scrap the Next Step approach, it does not allow for highly custom html once link is applied
* @todo LOWPRIORITY, create options for creating lists of notifications with numbered icons or CSS styled numbers
*/
function wtgcore_n($title,$mes,$style,$size,$atts = array()){

    extract( shortcode_atts( array( 
        'url' => false,
        'output' => 'norm',// default normal echos html, return will return html, public also returns it but bypasses is_admin() etc
        'audience' => 'admin',// admin or user (use to display a different message to visitors than to staff)
        'user_mes' => 'No user message giving',// only used when audience is set to user, user_mes replaces $mes
        'side' => 'private',// private,public (use to apply themes styles if customised, do not use for security)      
        'clickable' => false,// boolean
        'persistent' => false,// true will add message too stored array for displaying constantly
        'persistentpage' => false,// if persistent, indicates a specific page (below title) to show notification on
        'persistentscreen' => false,// if persistent, indicates a specific screen to show notification on
        'persistentpanel' => false,// if persistent, indicates a specific panel to show message in
    ), $atts ) );

    // do not allow a notice box if $output not stated as public and current visitor is not logged in
    // this forces backend messages which may be more private i.e. account info or key admin details
    if(!is_admin() && $output != 'public'){
        // visitor is on front-end, but the $output set is not for public
        return false; 
    }
    
    // if return wanted or $side == public (used to bypass is_admin() check)
    if($output == 'return' || $output == 'public'){
        return wtgcore_notice_display($style,$url,$size,$title,$mes,$clickable,$persistent = false);
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
    $csv2post_notice_array['notifications'][$next_key]['message'] = $mes;
    $csv2post_notice_array['notifications'][$next_key]['type'] = $style;
    $csv2post_notice_array['notifications'][$next_key]['size'] = $size;
    $csv2post_notice_array['notifications'][$next_key]['title'] = $title;
    $csv2post_notice_array['notifications'][$next_key]['helpurl'] = $url; 
    
    // update notifications array if the new message is meant to be persistent
    if($persistent){
        csv2post_update_option_notifications_array($csv2post_notice_array);
    }
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
* 
* @deprecated use wtgcore_n_display()
*/
function wtgcore_notice_display($type,$helpurl,$size,$title,$message,$clickable,$persistent = false){
    // begin building output
    $output = '';
               
    // if clickable (only allowed when no other links being used) - $helpurl will actually be a local url too another plugin or Wordpress page
    if($clickable && !$persistent){
        $output .= '<div class="stepLargeTest"><a href="'.$helpurl.'">';
    }

    // start div
    $output .= '<div class="'.$type.$size.'">';
        
        // if is not clickable (entire div) and help url is not null
        ### TODO:LOWPRIORITY, add the $type to the class ($type.$size.'HelpLink) and create styles for each type plus images to suit the styles. This could be a job to give to someone else.
        if($helpurl != '' && $helpurl != false){
            $output .= '<a href="'.$helpurl.'" target="_blank">
            <img class="'.$size.'HelpLink" src="'.WTG_C2P_IMAGEFOLDER_URL.'link-icon.png" />
            </a>';
        }   
       
        // set h4 when required
        if($size == 'Large' || $size == 'Extra'){$output .= '<h4>'.$title.'</h4>';}
        elseif($size == 'Small'){$output .= $title;}

    // if persistent message, add link for deleting the message
    ### TODO:MEDIUMPRIORITY, complete persistent messages
        
    $output .= $message.'</div>';

    if($clickable && !$persistent){$output .= '</a></div>';}

    return $output;    
}

/**
* Standard notice format to be displayed on submission of a form (Large).
* Change the size if a plugin using core is to have a different format.
*/
function wtgcore_n_postresult($type,$title,$message,$helpurl = false,$user = 'admin'){
    wtgcore_notice($message,$type,'Large',$title, $helpurl, 'echo');    
}

/**
* Standard notice format to be displayed at the top of a screen (Tiny)
*/
function wtgcore_n_screeninfo($title,$message,$helpurl = false,$user = 'admin'){
    echo wtgcore_notice($message,'info','Tiny',$title, $helpurl, 'return');    
}

/**
* Standard notice format to be displayed inside a panel as information
*/
function wtgcore_n_panelinfo($title,$message,$helpurl = false,$user = 'admin'){
    echo wtgcore_notice($message,'info','Small',$title, $helpurl, 'return');    
}

/**
* Standard notice format for displaying notice on public side
*/
function wtgcore_n_public($title,$message,$helpurl = false){
    echo wtgcore_n($title,$message,'info','Small',array('output' => 'public','url' => $helpurl));    
}

/**
* Notice html is printed where this function is used 
*/
function wtgcore_n_incontent($message,$type = 'info',$size = 'Small',$title = '',$helpurl = ''){
    echo wtgcore_notice($message,$type,$size,$title, $helpurl, 'return');    
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
function wtgcore_notice_display_step($helpurl,$title,$message){
    $output = '<div class="stepLargeTest"><a href="'.$helpurl.'">    
    <div class="stepLarge"><h4>'.$title.'</h4>'. $message .'</div></a></div>';
    return $output;    
}

/**
* Displays notice if combined CSV file size is more than recommended for the interface to easily handle
* 104857600 = 100 MB 
*/
function wtgcore_notice_filesizetotal($mb){
    if($mb > 104857600){
        echo wtgcore_notice('Your CSV files combined size is larger than 100MB, it is recommended that you delete any files
        not in use to reduce memory usage and increase plugin interface performance','notice','Tiny','','','return');
    }      
}

/**
* Outputs the contents of $csv2post_notice_array, used in csv2post_header_page.
* Will hold new and none persistent notifications. May also hold persistent. 
*/
function wtgcore_notice_output(){
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
              
            echo wtgcore_notice_display($notice['type'],$notice['helpurl'],$notice['size'],$notice['title'],$notice['message'],$notice['clickable'],$notice['persistent']);                                               
        }
    }  
}

/**
* Call to display the contents of a giving log file
* @param string $log  (error,user,admin,general,sql) (in CSV 2 POST we have custom data,posts,project logs)
*/
function wtgcore_log_display($log,$display_rows = 100){
    global $csv2post_logfiles_array;
    
    csv2post_pearcsv_include();    

    $fileexists_result = wtgcore_logfile_exists($log);
     
    // if file does not exist
    if(!$fileexists_result){
        wtgcore_n_incontent('You have not installed the '.$log.' file yet.','info','Small');
        return;
    }               
                            
    // count number of rows in log
    $csvfile_rows = csv2post_count_csvfilerows('csv2post_log_'.$log.'.csv');
    
    // if not more than 1 row in file display notice
    if($csvfile_rows < 2){
        wtgcore_n_incontent('The '.$log.' log file does not have any entries.','info','Small');
        return;
    }
    
    // establish how many rows we need to skip
    $skip_rows = 0;
    if($csvfile_rows > $display_rows){
        $skip_rows = $csvfile_rows - $displays_rows;
    }
    
    // we will put the rows to be displayed into an array so that we can reverse the order they are displayed in
    $rows_array = array();
    
    $conf = array();
    $conf['sep'] = ',';
    $conf['quote'] = '"';
    $conf['fields'] = '10';   
    
    $i = 0;
    
    // loop through records using PEAR CSV File_CSV::read 
    // Headers: PRIORITY[0],DATE[1],COMMENT[2],LINE[3],FILE[4],FUNCTION[5],DUMP[6],SQLRESULT[7],SQLQUERY[8],TYPE[9]  
    while ( ( $r = File_CSV::read( wtgcore_logfilepath($log), $conf ) ) ) {  
        if($i > 0 && $i >= $skip_rows){
            $rows_array[] = $r;
        }
        
        ++$i;        
    } 
    
    // reverse the order of the array
    $rows_array_reversed = array_reverse($rows_array);
    

    echo '<table class="widefat post fixed">
    <tr class="first">';
        echo '<td><strong>Date/Time</strong></td>';
        
        // get csv files headers
        foreach($csv2post_logfiles_array[$log]['headers'] as $headerkey => $header){
            echo '<td><strong>'.$header['label'].'</strong></td>';
        }    
                                                                                        
    echo '</tr>';  

    foreach($rows_array_reversed as $k => $row){
        echo '<tr>'; 

            $row_number = 0;
            foreach($csv2post_logfiles_array[$log]['headers'] as $headerkey => $header){
                echo '<td>'.$row[$row_number].'</td>';
                ++$row_number;
            } 
 
                                                                                                                  
        echo '</tr>';
    }
                        
    echo '</table>';      
}
?>