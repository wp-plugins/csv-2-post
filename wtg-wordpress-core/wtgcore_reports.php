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
function csv2post_log($atts){     
    global $csv2post_adm_set,$csv2post_logfiles_array;

    if(!is_array($csv2post_logfiles_array)){
        return false;# user reported error which indicates this is not always an array
    }
    
    // if ALL logging is off - if ['uselog'] not set then logging for all files is on by default
    if(isset($csv2post_adm_set['reporting']['uselog']) && $csv2post_adm_set['reporting']['uselog'] == 0){
        return false;
    }
    
    // run extraction and shortcode_atts(), $atts overwrites "Unknown" or other defaults such as date if date set in $atts  
    // we loop through logs headers to build extraction array
    $extraction_array = array();
    $extraction_array['date'] = csv2post_date();// set this now and it can be changed later in script
    $extraction_array['type'] = false;// must be changed from false to a log type for rest of function to work
    foreach($csv2post_logfiles_array[$atts['type']]['headers'] as $headerkey => $header){
        $extraction_array[$headerkey] = 'Unknown';
    }
    
    // run extraction and shortcode_atts(), $atts overwrites "Unknown" or other defaults such as date if date set in $atts  
    extract( shortcode_atts( $extraction_array, $atts ) );
                          
    // set default which
    if(!isset($date)){
        $date = csv2post_date();
    }
    
    if(!isset($type)){
        $date = false;// must not happen, this will cause failure
    }
       
    foreach($csv2post_logfiles_array[$atts['type']]['headers'] as $headerkey => $header){
        $extraction_array[$headerkey] = 'Unknown';
    }
                                        
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
    csv2post_logfile_autodelete($type,$log_file_limit);
                      
    // check if file exists, else create it with a header
    if(!csv2post_logfile_exists($type)){
        csv2post_create_logfile($type);
    }
                       
    // if log file still does not exist (failure on creating it)
    if(!csv2post_logfile_exists($type)){
        return false;
    }
        
    // general, sql, admin, user, error (files must be named WTG_C2P_ABB.'log_'.$logtype.'.csv )
    $logfile_path = csv2post_logfilepath($type); 
      
    // build the new csv file row by looping through header names and using eval to set them as variables   
    $write = array();         
    $write[0] = $date;
    foreach($csv2post_logfiles_array[$atts['type']]['headers'] as $headerkey => $header){
        $write[] = $$headerkey;// each header should be a variable by now after extract( shortcode_atts())
    }    
      
    @$fp = fopen( $logfile_path, 'a');
    @fputcsv($fp, $write,',','"');
    @fclose($fp);
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
    // call log function which performs log and uses $csv2post_logfiles_array
    csv2post_log($atts);    
}

/**
* Admin log is about tracing admin users actions, tracing staffs use.
* Place the csv2post_log_user() function in form processing.
*/
function csv2post_log_users($usertype,$side,$message,$ipaddress = 'NA',$userid = 'NA',$username = 'NA',$panelname = 'NA',$paneltitle = 'NA',$page = 'NA'){
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
    // call log function which performs log and uses $csv2post_logfiles_array
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
    // call log function which performs log and uses $csv2post_logfiles_array
    csv2post_log($atts);    
}

/**
* Create giving log file
* 
* @returns boolean, true if file is created or already exists, false otherwise
* 
* @param string $logtype, general,admin,user,sql,error 
*/
function csv2post_create_logfile($logtype){       
    if (csv2post_logfile_exists($logtype)) {
        return true;
    }else{

        // ensure directory exists
        if(!is_dir(WTG_C2P_CONTENTFOLDER_DIR)){
            if (!mkdir(WTG_C2P_CONTENTFOLDER_DIR, 0700, true)) {
                ### @todo log this matter in options (functions to be written)
                return false;
            }
        }

        $logfilepath = csv2post_logfilepath($logtype);
        
        $fp = fopen(csv2post_logfilepath($logtype),'w');
           
        if( !$fp ){    
            ### TODO:LOWPRIORITY, if debug mode on display notice else do a server log of this          
        }else{
           
            global $csv2post_logfiles_array;

            // build header row (start with defaults that apply to all files, mainly date)
            $csv2post_logfile_header = array();
            $csv2post_logfile_header[] = 'date';
            
            if(!is_array($csv2post_logfiles_array)){
                echo '<h1>Error: $csv2post_logfiles_array is not an array please report this!</h1';    
            }
            
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
function csv2post_delete_logfile($logtype){
    return unlink(csv2post_logfilepath($logtype));    
} 

/**
* Disables log entries for giving log file
* 
* @global $csv2post_adm_set
* @param mixed $logtype
* @return returns the response from update_option function
*/
function csv2post_disable_logfile($logtype){
    global $csv2post_adm_set;### TODO:LOWPRIORITY establish the required method here, gloal or get.
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
function csv2post_activate_logfile($logtype){
    global $csv2post_adm_set;
    $csv2post_adm_set['log_'.$logtype.'_active'] = true;
    csv2post_update_option_adminsettings($csv2post_adm_set);
}

/**
 * Checks if history file exists
 * @param string $historytype (general,sql,admin,user,error)
 * @return boolean
 * 
 * @todo adapt to allow log file location to be changed and this function to use the new location not the default   
 */
function csv2post_logfile_exists($logtype){
    return file_exists(csv2post_logfilepath($logtype));
}

/**
* Deletes log file if over specific size 
* Must ensure file exists before calling this function
* 
* @param string $logtype (general,error,sql,admin,user)
* @param integer $sizelimit, state the maximum bytes (307200 = 300kb which is a reasonable size and is default)
*/
function csv2post_logfile_autodelete($logtype,$sizelimit = 307200){
    // does log file actually exist?
    if(file_exists(csv2post_logfilepath($logtype))){
        // check file size - delete if over 300kb as stated on Log page
        if( filesize( csv2post_logfilepath($logtype) ) > $sizelimit ){
            return unlink( csv2post_logfilepath($logtype) );
        }  
    }  
}             
                    
/**
* Returns the full path to giving log file
* 
* @param string $logtype (admin,user,error,sql,general = default)
*/
function csv2post_logfilepath($logtype = 'general'){
    return WTG_C2P_CONTENTFOLDER_DIR.'/csv2post_log_'.$logtype.'.csv'; 
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
*/
function csv2post_notice_postresult($type,$title,$message,$helpurl = false,$user = 'admin'){
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
* Call to display the contents of a giving log file
* @param string $log  (error,user,admin,general,sql) (in CSV 2 POST we have custom data,posts,project logs)
*/
function csv2post_log_display($log,$display_rows = 100){
    global $csv2post_logfiles_array;
    
    csv2post_pearcsv_include();    

    $fileexists_result = csv2post_logfile_exists($log);
     
    // if file does not exist
    if(!$fileexists_result){
        csv2post_n_incontent('You have not installed the '.$log.' file yet.','info','Small');
        return;
    }               
                            
    // count number of rows in log
    $csvfile_rows = csv2post_count_csvfilerows('csv2post_log_'.$log.'.csv');
    
    // if not more than 1 row in file display notice
    if($csvfile_rows < 2){
        csv2post_n_incontent('The '.$log.' log file does not have any entries.','info','Small');
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
    $conf['fields'] = count($csv2post_logfiles_array[$log]['headers']) + 1;   
     
    $i = 0;
    
    // loop through records using PEAR CSV File_CSV::read 
    // Headers: PRIORITY[0],DATE[1],COMMENT[2],LINE[3],FILE[4],FUNCTION[5],DUMP[6],SQLRESULT[7],SQLQUERY[8],TYPE[9]  
    while ( ( $r = File_CSV::read( csv2post_logfilepath($log), $conf ) ) ) {  
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
            foreach($csv2post_logfiles_array[$log]['headers'] as $headerkey2 => $header2){
                echo '<td>'.$row[$row_number].'</td>';
                ++$row_number;
            } 
                                                                                                     
        echo '</tr>';
    }
                        
    echo '</table>';      
}
?>
