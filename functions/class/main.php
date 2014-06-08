<?php
/** 
* Wordpress main functions library for plugin and theme development
* 
* @package CSV 2 POST
* 
* @version 0.0.1
* 
* @since 8.0.0
* 
* @author Ryan Bayne 
*/

/**
* Used by Wordpress email filter - 
* 
* @todo need to move this to a class and test
* 
* Example: add_filter( 'wp_mail_content_type', 'csv2post_set_html_content_type' )
*/
function csv2post_set_html_content_type() {
    return 'text/html';
}

class C2P_WP extends C2P_WPDB {
    /**
     * Checks existing plugins and displays notices with advice or informaton
     * This is not only for code conflicts but operational conflicts also especially automated processes
     *
     * $return $critical_conflict_result true or false (true indicatesd a critical conflict found, prevents installation, this should be very rare)
     */
    function conflict_prevention($outputnoneactive = false){
        // track critical conflicts, return the result and use to prevent installation
        // only change $conflict_found to true if the conflict is critical, if it only effects partial use
        // then allow installation but warn user
        $conflict_found = false;
            
        // we create an array of profiles for plugins we want to check
        $plugin_profiles = array();

        // Tweet My Post (javascript conflict and a critical one that breaks entire interface)
        $plugin_profiles[0]['switch'] = 1;//used to use or not use this profile, 0 is no and 1 is use
        $plugin_profiles[0]['title'] = __('Tweet My Post','csv2post');
        $plugin_profiles[0]['slug'] = 'tweet-my-post/tweet-my-post.php';
        $plugin_profiles[0]['author'] = 'ksg91';
        $plugin_profiles[0]['title_active'] = __('Tweet My Post Conflict','csv2post');
        $plugin_profiles[0]['message_active'] = __('Please deactivate Twitter plugins before performing mass post creation. This will avoid spamming Twitter and causing more processing while creating posts.','csv2post');
        $plugin_profiles[0]['message_inactive'] = __('If you activate this or any Twitter plugin please ensure the plugins options are not setup to perform mass tweets during post creation.','csv2post');
        $plugin_profiles[0]['type'] = 'info';//passed to the message function to apply styling and set type of notice displayed
        $plugin_profiles[0]['criticalconflict'] = true;// true indicates that the conflict will happen if plugin active i.e. not specific settings only, simply being active has an effect
                             
        // loop through the profiles now
        if(isset($plugin_profiles) && $plugin_profiles != false){
            foreach($plugin_profiles as $key=>$plugin){   
                if( is_plugin_active( $plugin['slug']) ){ 
                   
                    // recommend that the user does not use the plugin
                    $this->notice_depreciated($plugin['message_active'],'warning','Small',$plugin['title_active'],'','echo');

                    // if the conflict is critical, we will prevent installation
                    if($plugin['criticalconflict'] == true){
                        $conflict_found = true;// indicates critical conflict found
                    }
                    
                }elseif(is_plugin_inactive($plugin['slug'])){
                    
                    if($outputnoneactive)
                    {   
                        $this->n_incontent_depreciated($plugin['message_inactive'],'warning','Small',$plugin['title'] . ' Plugin Found');
                    }
        
                }
            }
        }

        return $conflict_found;
    }     
    /**
    * Determines if process request of any sort has been requested
    * 1. used to avoid triggering automatic processing during proccess requests
    * 
    * @returns true if processing already requested else false
    */
    public function request_made(){
        // ajax
        if(defined('DOING_AJAX') && DOING_AJAX){
            return true;    
        } 
        
        // form submissions - if $_POST is set that is fine, providing it is an empty array
        if(isset($_POST) && !empty($_POST)){
            return true;
        }
        
        // CSV 2 POST own special processing triggers
        if(isset($_GET['c2pprocsub']) || isset($_GET['c2pprocess']) || isset($_GET['nonceaction'])){
            return true;
        }
        
        return false;
    }    
    /**
    * Gets notifications array if it exists in Wordpress options table else returns empty array
    */
    public function persistentnotifications_array(){
        $a = get_option('csv2post_notifications');
        $v = maybe_unserialize($a);
        if(!is_array($v)){
            return array();    
        }
        return $v;    
    }    
    /**
    * Used to build history, flag items
    *
    * @global $wpdb
    * @uses extract, shortcode_atts
    * 
    * @link http://www.csv2post.com/hacking/log-table
    */
    public function newlog($atts){     
        global $c2p_settings,$wpdb,$c2p_currentversion,$C2P_WP;

        $table_name = $wpdb->prefix . 'c2plog';
        
        // if ALL logging is off - if ['uselog'] not set then logging for all files is on by default
        if(isset($c2p_settings['globalsettings']['uselog']) && $c2p_settings['globalsettings']['uselog'] == 0){return false;}
        
        // if log table does not exist return false
        if(!C2P_WPDB::does_table_exist($table_name)){return false;}
             
        // if a value is false, it will not be added to the insert query, we want the database default to kick in, NULL mainly
        extract( shortcode_atts( array(  
            'outcome' => 1,# 0|1 (overall outcome in boolean) 
            'line' => false,# __LINE__ 
            'function' => false,# __FUNCTION__
            'file' => false,# __FILE__ 
            'sqlresult' => false,# dump of sql query result 
            'sqlquery' => false,# dump of sql query 
            'sqlerror' => false,# dump of sql error if any 
            'wordpresserror' => false,# dump of a wp error 
            'screenshoturl' => false,# screenshot URL to aid debugging 
            'userscomment' => false,# beta testers comment to aid debugging (may double as other types of comments if log for other purposes) 
            'page' => false,# related page 
            'version' => $c2p_currentversion, 
            'panelid' => false,# id of submitted panel
            'panelname' => false,# name of submitted panel 
            'tabscreenid' => false,# id of the menu tab  
            'tabscreenname' => false,# name of the menu tab 
            'dump' => false,# dump anything here 
            'ipaddress' => false,# users ip 
            'userid' => false,# user id if any    
            'noticemessage' => false,# when using log to create a notice OR if logging a notice already displayed      
            'comment' => false,# dev comment to help with troubleshooting
            'type' => false,# general|error|trace 
            'category' => false,# createposts|importdata|uploadfile|deleteuser|edituser 
            'action' => false,# 3 posts created|22 posts updated (the actuall action performed)
            'priority' => false,# low|normal|high (use high for errors or things that should be investigated, use low for logs created mid procedure for tracing progress)                        
            'triga' => false# autoschedule|cronschedule|wpload|manualrequest
        ), $atts ) );
        
        // start query
        $query = "INSERT INTO $table_name";
        
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
        if($triga){$query_columns .= ',triga';$query_values .= ',"'.$triga.'"';}
        
        $query_columns .= ')';
        $query_values .= ')';
        $query .= $query_columns .' VALUES '. $query_values;  
        $wpdb->query( $query );     
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
    public function log_schedule($comment,$action,$outcome,$category = 'scheduledeventaction',$trigger = 'autoschedule',$line = 'NA',$file = 'NA',$function = 'NA'){
        global $C2P_WP;
        $atts = array();   
        $atts['logged'] = $C2P_WP->datewp();
        $atts['comment'] = $comment;
        $atts['action'] = $action;
        $atts['outcome'] = $outcome;
        $atts['category'] = $category;
        $atts['line'] = $line;
        $atts['file'] = $file;
        $atts['function'] = $function;
        $atts['trigger'] = $function;
        // set log type so the log entry is made to the required log file
        $atts['type'] = 'automation';
        $C2P_WP->newlog($atts);    
    }       
    /**
    * Cleanup log table - currently keeps 2 days of logs
    */
    public function log_cleanup(){
        global $C2P_DB,$wpdb;     
        if($C2P_DB->database_table_exist($wpdb->c2plog)){
            global $wpdb;
            $twodays_time = strtotime('2 days ago midnight');
            $twodays = date("Y-m-d H:i:s",$twodays_time);
            $wpdb->query( 
                "
                    DELETE FROM $wpdb->c2plog
                    WHERE timestamp < '".$twodays."'
                "
            );
        }
    }
    public function send_email($recipients,$subject,$content,$content_type = 'html'){     
                           
        if($content_type == 'html')
        {
            add_filter( 'wp_mail_content_type', 'csv2post_set_html_content_type' );
        }
        
        $result = wp_mail( $recipients, $subject, $content );

        if($content_type == 'html')
        {    
            remove_filter( 'wp_mail_content_type', 'csv2post_set_html_content_type' );  
        }   
        
        return $result;
    }    
    /**
    * Creates url to an admin page
    *  
    * @param mixed $page, registered page slug i.e. csv2post_install which results in wp-admin/admin.php?page=csv2post_install   
    * @param mixed $values, pass a string beginning with & followed by url values
    */
    public function url_toadmin($page,$values = ''){                                  
        return get_admin_url() . 'admin.php?page=' . $page . $values;
    }
    /**
    * Adds <button> with jquerybutton class and </form>, for using after a function that outputs a form
    * Add all parameteres or add none for defaults
    * @param string $buttontitle
    * @param string $buttonid
    */
    public function formend_standard($buttontitle = 'Submit',$buttonid = 'notrequired'){
            if($buttonid == 'notrequired'){
                $buttonid = 'csv2post_notrequired'.rand(1000,1000000);# added during debug
            }else{
                $buttonid = $buttonid.'_formbutton';
            }?>

            <p class="submit">
                <input type="submit" name="csv2post_wpsubmit" id="<?php echo $buttonid;?>" class="button button-primary" value="<?php echo $buttontitle;?>">
            </p>

        </form><?php
    }
    /**
     * Echos the html beginning of a form and beginning of widefat post fixed table
     * 
     * @param string $name (a unique value to identify the form)
     * @param string $method (optional, default is post, post or get)
     * @param string $action (optional, default is null for self submission - can give url)
     * @param string $enctype (pass enctype="multipart/form-data" to create a file upload form)
     */
    public function formstart_standard($name,$id = 'none', $method = 'post',$class,$action = '',$enctype = ''){
        if($class){
            $class = 'class="'.$class.'"';
        }else{
            $class = '';         
        }
        echo '<form '.$class.' '.$enctype.' id="'.$id.'" method="'.$method.'" name="csv2post_request_'.$name.'" action="'.$action.'">
        <input type="hidden" id="csv2post_post_requested" name="csv2post_post_requested" value="true">';
    } 
    public function get_project_name($project_id){
        global $C2P_DB,$wpdb;
        $row = $C2P_DB->selectrow($wpdb->c2pprojects,'projectid = ' . $project_id,'projectname');
        if(!isset($row->projectname)){return 'No Current Project';}
        return $row->projectname;
    }   
    /**
    * Adds Script Start and Stylesheets to the beginning of pages
    */
    public function pageheader($pagetitle,$layout){
        global $CSV2POST,$current_user,$c2p_mpt_arr,$c2p_settings,$c2p_pub_set,$c2p_is_free,$C2P_WP,$C2P_UI;

        // get admin settings again, all submissions and processing should update settings
        // if the interface does not show expected changes, it means there is a problem updating settings before this line
        $c2p_settings = $CSV2POST->adminsettings(); 

        get_currentuserinfo();?>
                    
        <div class="wrap">
            <?php $CSV2POST->diagnostics_constant();?>
        
            <div id="icon-options-general" class="icon32"><br /></div>
            
            <h2><?php echo $pagetitle;?> 8.0.0</h2>

            <?php 
            $C2P_UI->display_current_project();
                 
            // run specific admin triggered automation tasks, this way an output can be created for admin to see
            $CSV2POST->admin_triggered_automation();  

            // check existing plugins and give advice or warnings
            $C2P_WP->conflict_prevention();
                     
            // display form submission result notices
            $C2P_WP->output_depreciated();// now using display_all();
            $C2P_WP->display_all();              
          
            // process global security and any other types of checks here such such check systems requirements, also checks installation status
            $c2p_requirements_missing = $C2P_WP->check_requirements(true);?>

            <div class="postbox-container" style="width:99%">
                <div class="metabox-holder">
                    <div class="meta-box-sortables"><?php
    }    
    /**
    * Displays author and adds some required scripts
    */
    public function footer(){?>
                    </div><!-- end of post boxes -->
                </div><!-- end of post boxes -->
            </div><!-- end of post boxes -->
        </div><!-- end of wrap - started in header -->

        <script type="text/javascript">
            // <![CDATA[
            jQuery('.postbox div.handlediv').click( function() { jQuery(jQuery(this).parent().get(0)).toggleClass('closed'); } );
            jQuery('.postbox h3').click( function() { jQuery(jQuery(this).parent().get(0)).toggleClass('closed'); } );
            jQuery('.postbox.close-me').each(function(){
            jQuery(this).addClass("closed");
            });
            //-->
         </script><?php
    }        
    /**
    * <table class="widefat">
    * Allows control over all table
    * 
    */
    public function tablestart($class = false){
        if(!$class){$class = 'widefat';}
        echo '<table class="'.$class.'">';    
    }   
    /**
    * List of notification boxes displaying folders created by CSV 2 POST.
    */
    public function list_folders(){
        global $C2P_WP;
        
        if(file_exists('exampleonly/put/filename/here')){?>
            <script language="JavaScript">
            function csv2post_deletefolders_checkboxtoggle(source) {
              checkboxes = document.getElementsByName('csv2post_deletefolders_array[]');
              for(var i in checkboxes)
                checkboxes[i].checked = source.checked;
            }
            </script>
            <input type="checkbox" onClick="csv2post_deletefolders_checkboxtoggle(this)" /> Select All Folders<br/>
            <?php echo $C2P_WP->notice_depreciated('<input type="checkbox" name="csv2post_deletefolders_array[]" value="csv2postcontent" /> 1. csv2postcontent','success','Tiny','','','return');                    
        }
    }
    /**
    * List of notification boxes displaying core plugin tables
    */
    public function list_plugintables(){
        global $c2p_tables_array,$C2P_WP;?>

        <script language="JavaScript">
        function csv2post_deletecoretables_checkboxtoggle(source) {
          checkboxes = document.getElementsByName('csv2post_deletecoretables_array[]');
          for(var i in checkboxes)
            checkboxes[i].checked = source.checked;
        }
        </script>

        <input type="checkbox" onClick="csv2post_deletecoretables_checkboxtoggle(this)" /> Select All Tables<br/>

        <?php 
        $count = 0;
        foreach($c2p_tables_array['tables'] as $key => $table){
            if(C2P_WPDB::does_table_exist($table['name'])){
                ++$count;
                echo $C2P_WP->notice_depreciated('<input type="checkbox" name="csv2post_deletecoretables_array[]" value="'.$table['name'].'" /> ' . $count . '. ' . $table['name'],'success','Tiny','','','return');               
            }
        }
        
        if($count == 0){echo '<p>'. __('There are no core tables installed right now','csv2post') .'</p>';}
    }     
    /**
    * Displays a table of csv2post_option records with ability to view their value or delete them
    * @param boolean $form true adds checkbox object to each option record (currently used on uninstall panel) 
    */
    public function list_optionrecordtrace($form = false,$size = 'Small',$optiontype = 'all'){ 
        global $C2P_WP;
           
        // first get all records that begin with csv2post_
        $csv2postrecords_result = C2P_WPDB::options_beginning_with('csv2post_');
        $counter = 1;?>
            
            <script language="JavaScript">
            function csv2post_deleteoptions_checkboxtoggle(source) {
              checkboxes = document.getElementsByName('csv2post_deleteoptions_array[]');
              for(var i in checkboxes)
                checkboxes[i].checked = source.checked;
            }
            </script>

        <?php   

        if($form){
            echo '<input type="checkbox" onClick="csv2post_deleteoptions_checkboxtoggle(this)" /> '. __('Select All Options','csv2post') .'<br/>';
        }
        
        $html = '';
                        
        foreach($csv2postrecords_result as $key => $option ){
            
            if($form){
                $html = '<input type="checkbox" name="csv2post_deleteoptions_array[]" value="'.$option.'" />';
            }
            
            echo $C2P_WP->notice_depreciated($html . ' ' . $counter . '. ' . $option,'success',$size,'','','return');
            
            ++$counter;
        }
    } 
    public function screens_menuoptions($current){
        global $c2p_mpt_arr;
        foreach($c2p_mpt_arr as $page_slug => $page_array){ 
            foreach($c2p_mpt_arr[$page_slug]['tabs'] as $whichvalue => $screen_array){
                $selected = '';
                if($screen_array['slug'] == $current){
                    $selected = 'selected="selected"';    
                }             
                echo '<option value="'.$screen_array['slug'].'" '.$selected.'>'.$screen_array['label'].'</option>'; 
            }
        }    
    }
    public function page_menuoptions($current){
        global $c2p_mpt_arr;
        foreach($c2p_mpt_arr as $page_slug => $page_array){ 
            $selected = '';
            if($page_slug == $current){
                $selected = 'selected="selected"';    
            } 
            echo '<option value="'.$page_slug.'" '.$selected.'>'.$c2p_mpt_arr[$page_slug]['title'].'</option>';
        }    
    }
    public function screenintro($c2p_page_name,$text,$progress_array){
        global $c2p_settings,$c2p_is_beta,$C2P_UI;
        
        echo '
        <div class="csv2post_screenintro_container">
            <div class="welcome-panel">
            
                <h3>'. ucfirst($c2p_page_name) . ' ' . __('Development Insight','csv2post') .'</h3>
                
                <div class="welcome-panel-content">
                    <p class="about-description">'. ucfirst($text) .'...</p>
                    
                    <h4>Section Development Progress</h4>
 
                    '.        $C2P_UI->info_area('','                    
                    Free Edition: <progress max="100" value="'.$progress_array['free'].'"></progress> <br>
                    Premium Edition: <progress max="100" value="'.$progress_array['paid'].'"></progress> <br>
                    Support Content: <progress max="100" value="'.$progress_array['support'].'"></progress> <br>
                    Translation: <progress max="100" value="'.$progress_array['translation'].'"></progress>') .'
                    <p>'.__('Pledge £9.99 to the CSV 2 POST project for 50% discount on the premium edition.').'</p>                                                     
                </div>

            </div> 
        </div>';  
    }
    /**
    * Add hidden form fields, to help with processing and debugging
    * Adds the _form_processing_required value, required to call the form validation file
    *
    * @param integer $pageid (the id used in page menu array)
    * @param slug $panel_name (panel name form is in)
    * @param string $panel_title (panel title form is in)
    * @param integer $panel_number (the panel number form is in),(tab number passed instead when this function called for support button row)
    * @param integer $step (1 = confirm form, 2 = process request, 3+ alternative processing)
    */
    public function hidden_form_values($form_name,$form_title){
        global $c2p_page_name,$c2p_tab_number;
        $form_name = lcfirst($form_name);
        wp_nonce_field($form_name); 
        echo '<input type="hidden" name="csv2post_post_requested" value="true">';
        echo '<input type="hidden" name="csv2post_hidden_tabnumber" value="'.$c2p_tab_number.'">';
        echo '<input type="hidden" name="csv2post_hidden_pagename" value="'.$c2p_page_name.'">';
        echo '<input type="hidden" name="csv2post_form_name" value="'.$form_name.'">';
        echo '<input type="hidden" name="csv2post_form_title" value="'.$form_title.'">';
    }                  
    /**
    * Checks if the cores minimum requirements are met and displays notices if not
    * Checks: Internet Connection (required for jQuery), PHP version, Soap Extension
    */
    public function check_requirements($display){
        global $C2P_WP;
        
        // variable indicates message being displayed, we will only show 1 message at a time
        $requirement_missing = false;

        // php version
        if(defined(WTG_CSV2POST_PHPVERSIONMINIMUM)){
            if(WTG_CSV2POST_PHPVERSIONMINIMUM > phpversion()){
                $requirement_missing = true;
                if($display == true){
                    $C2P_WP->notice_depreciated(sprintf(__('The plugin detected an older PHP version than the minimum requirement which 
                    is %s. You can requests an upgrade for free from your hosting, use .htaccess to switch
                    between PHP versions per WP installation or sometimes hosting allows customers to switch using their control panel.','csv2post'),WTG_CSV2POST_PHPVERSIONMINIMUM)
                    ,'warning','Large',__('CSV 2 POST Requires PHP ','csv2post') . WTG_CSV2POST_PHPVERSIONMINIMUM);                
                }
            }
        }
        
        return $requirement_missing;
    }
    /**
    * Returns a value for Tab Number, if $_GET[WTG_##_ABB . 'tabnumber'] not set returns 0 
    */
    public function tabnumber(){                 
        if(isset($_POST['csv2post_hidden_tabnumber']))
        {                    
            return $_POST['csv2post_hidden_tabnumber'];    
        }                   
        elseif(isset($_GET['c2ptab']) && is_numeric($_GET['c2ptab']))
        {                  
            return $_GET['c2ptab'];
        }
        else
        {              
            return '0';                   
        }                                                      
    } 
    /**
    * Loads CSS for plugin not core
    * 
    * @param string $side, admin, public
    * @param mixed $c2p_css_side_override, makes use of admin lines in front-end of blog
    */
    public function css_core($side = 'admin',$c2p_css_side_override = false){        
        include_once(WTG_CSV2POST_PATH . '/css/wtgcore_css_parent.php');
    }                
    /**       
     * Generates a username using a single value by incrementing an appended number until a none used value is found
     * @param string $username_base
     * @return string username, should only fail if the value passed to the function causes so
     * 
     * @todo log entry functions need to be added, store the string, resulting username
     */
    public function create_username($username_base){
        $attempt = 0;
        $limit = 500;// maximum trys - would we ever get so many of the same username with appended number incremented?
        $exists = true;// we need to change this to false before we can return a value

        // clean the string
        $username_base = preg_replace('/([^@]*).*/', '$1', $username_base );

        // ensure giving string does not already exist as a username else we can just use it
        $exists = username_exists( $username_base );
        if( $exists == false )
        {
            return $username_base;
        }
        else
        {
            // if $suitable is true then the username already exists, increment it until we find a suitable one
            while( $exists != false )
            {
                ++$attempt;
                $username = $username_base.$attempt;

                // username_exists returns id of existing user so we want a false return before continuing
                $exists = username_exists( $username );

                // break look when hit limit or found suitable username
                if($attempt > $limit || $exists == false ){
                    break;
                }
            }

            // we should have our login/username by now
            if ( $exists == false ) 
            {
                return $username;
            }
        }
    }
    /**
    * Wrapper, uses csv2post_url_toadmin to create local admin url
    * 
    * @param mixed $page
    * @param mixed $values 
    */
    public function create_adminurl($page,$values = ''){
        global $C2P_WP;
        return $C2P_WP->url_toadmin($page,$values);    
    }
    /**
    * Returns the plugins standard date (MySQL Date Time Formatted) with common format used in Wordpress.
    * Optional $time parameter, if false will return the current time().
    * 
    * @param integer $timeaddition, number of seconds to add to the current time to create a future date and time
    * @param integer $time optional parameter, by default causes current time() to be used
    */
    public function datewp($timeaddition = 0,$time = false,$format = false){
        $thetime = time();
        if($time != false){$thetime = $time;}
        if($format == 'gm'){return gmdate('Y-m-d H:i:s',$thetime + $timeaddition);}
        return date('Y-m-d H:i:s',$thetime + $timeaddition);    
    }    
    /**
    * Decides a tab screens required capability in order for dashboard visitor to view it
    * 
    * @param mixed $c2p_page_name the array key for pages
    * @param mixed $tab_key the array key for tabs within a page
    */
    public function get_tab_capability($c2p_page_name,$tab_key,$default = false){
        global $c2p_mpt_arr;
        $codedefault = 'activate_plugins';
        if(isset($c2p_mpt_arr[$c2p_page_name]['tabs'][$tab_key]['permissions']['capability'])){
            return $c2p_mpt_arr[$c2p_page_name]['tabs'][$tab_key]['permissions']['capability'];    
        }else{
            return $codedefault;    
        }    
    }
    public function get_page_capability($c2p_page_name,$default = false){
        global $c2p_mpt_arr;
        $thisdefault = 'update_core';// script default for all outcomes

        // there is no capability (setup by users settings), so we check for the defaultcapability we have already hard coded as most suitable
        if(!isset($c2p_mpt_arr[$c2p_page_name]['permissions']['capability'])){
            return $thisdefault;    
        }else{
            return $c2p_mpt_arr[$c2p_page_name]['permissions']['capability'];// our decided default    
        }

        return $thisdefault;   
    }
    public function get_installed_version(){
        return get_option('csv2post_installedversion');    
    }  
    /**
    * Use to start a new result array which is returned at the end of a function. It gives us a common set of values to work with.

    * @uses $C2P_WP->arrayinfo_set()
    * @param mixed $description use to explain what array is used for
    * @param mixed $line __LINE__
    * @param mixed $function __FUNCTION__
    * @param mixed $file __FILE__
    * @param mixed $reason use to explain why the array was updated (rather than what the array is used for)
    * @return string
    */                                   
    public function result_array($description,$line,$function,$file){
        global $C2P_WP;
        $array = $C2P_WP->arrayinfo_set(array(),$line,$function,$file);
        $array['description'] = $description;
        $array['outcome'] = true;// boolean
        $array['failreason'] = false;// string - our own typed reason for the failure
        $array['error'] = false;// string - add php mysql wordpress error 
        $array['parameters'] = array();// an array of the parameters passed to the function using result_array, really only required if there is a fault
        $array['result'] = array();// the result values, if result is too large not needed do not use
        return $array;
    }         
    /**
    * Get arrays next key (only works with numeric key)
    * 
    * @version 0.2 - return 0 if not array, used to return 1 but no longer a reason to do that
    * @author Ryan Bayne
    */
    public function get_array_nextkey($array){
        if(!is_array($array) || empty($array)){
            return 0;   
        }
        
        ksort($array);
        end($array);
        return key($array) + 1;
    }
    /**
    * Builds text link, also validates it to ensure it still exists else reports it as broken
    * 
    * The idea of this function is to ensure links used throughout the plugins interface
    * are not broken. Over time links may no longer point to a page that exists, we want to 
    * know about this quickly then replace the url.
    * 
    * @return $link, return or echo using $response parameter
    * 
    * @param mixed $text
    * @param mixed $url
    * @param mixed $htmlentities, optional (string of url passed variables)
    * @param string $target, _blank _self etc
    * @param string $class, css class name (common: button)
    * @param strong $response [echo][return]
    */
    public function link($text,$url,$htmlentities = '',$target = '_blank',$class = '',$response = 'echo',$title = ''){
        global $C2P_WP;
        
        // add ? to $middle if there is no proper join after the domain
        $middle = '';
                                 
        // decide class
        if($class != ''){$class = 'class="'.$class.'"';}
        
        // build final url
        $finalurl = $url.$middle.htmlentities($htmlentities);
        
        // check the final result is valid else use a default fault page
        $valid_result = $C2P_WP->validate_url($finalurl);
        
        if($valid_result){
            $link = '<a href="'.$finalurl.'" '.$class.' target="'.$target.'" title="'.$title.'">'.$text.'</a>';
        }else{
            $linktext = __('Invalid Link, Click To Report');
            $link = '<a href="http://www.webtechglobal.co.uk/wtg-blog/invalid-application-link/" target="_blank">'.$linktext.'</a>';        
        }
        
        if($response == 'echo'){
            echo $link;
        }else{
            return $link;
        }     
    }     
    public function update_settings($c2p_settings){
        $admin_settings_array_serialized = maybe_serialize($c2p_settings);
        return update_option('csv2post_settings',$admin_settings_array_serialized);    
    }
    /**
    * Returns Wordpress version in short
    * 1. Default returned example by get_bloginfo('version') is 3.6-beta1-24041
    * 2. We remove everything after the first hyphen
    */
    public function get_wp_version(){
        $longversion = get_bloginfo('version');
        return strstr( $longversion , '-', true );
    }
    /**
    * Determines if the giving value is a CSV 2 POST page or not
    */
    public function is_plugin_page($page){
        return strstr($page,'csv2post');  
    }
    /**
     * Tabs menu loader - calls function for css only menu or jquery tabs menu
     * 
     * @param string $thepagekey this is the screen being visited
     */
    public function createmenu($c2p_page_name){           
        global $c2p_mpt_arr,$C2P_WP;
        
        echo '<h2 class="nav-tab-wrapper">';
            
        foreach($c2p_mpt_arr[$c2p_page_name]['tabs'] as $tab=>$values)
        {
            $tabslug = $c2p_mpt_arr[$c2p_page_name]['tabs'][$tab]['slug'];
            $tablabel = $c2p_mpt_arr[$c2p_page_name]['tabs'][$tab]['label'];  

            if($C2P_WP->should_tab_be_displayed($c2p_page_name,$tab))
            {
                if(!isset($_GET['c2ptab']) && $tab == 0)
                {
                    $activeclass = 'class="nav-tab nav-tab-active"';
                }
                else
                {
                    $activeclass = 'class="nav-tab"';
                }                            
                
                if(isset($_GET['c2ptab']) && $_GET['c2ptab'] == $tab){$activeclass = 'class="nav-tab nav-tab-active"';}
                echo '<a href="'. $C2P_WP->create_adminurl($c2p_mpt_arr[$c2p_page_name]['slug']).'&c2ptab='.$tab.'" '.$activeclass.'>' . $tablabel . '</a>';       
            }
        }      
        
        echo '</h2>';
    }    
    /**
    * Determines if giving tab for the giving page should be displayed or not based on current user.
    * 
    * Checks for reasons not to display and returns false. If no reason found to hide the tab then true is default.
    * 
    * @param mixed $page
    * @param mixed $tab
    * 
    * @return boolean
    */
    public function should_tab_be_displayed($page,$tab){
        global $c2p_mpt_arr,$c2p_is_free,$c2p_is_beta;

        if(isset($c2p_mpt_arr[$page]['tabs'][$tab]['permissions']['capability'])){
            $boolean = current_user_can( $c2p_mpt_arr[$page]['tabs'][$tab]['permissions']['capability'] );
            if($boolean ==  false){
                return false;
            }
        }

        // if screen not active
        if(isset($c2p_mpt_arr[$page]['tabs'][$tab]['active']) && $c2p_mpt_arr[$page]['tabs'][$tab]['active'] == false){
            return false;
        }    
        
        // if screen is not active at all (used to disable a screen in all packages and configurations)
        if(isset($c2p_mpt_arr[$page]['tabs'][$tab]['active']) && $c2p_mpt_arr[$page]['tabs'][$tab]['active'] == false){
            return false;
        }
                   
        // display screen if the package not set, just to be safe as the package value should also be set if menu array installed properly
        if(isset($c2p_mpt_arr[$page]['tabs'][$tab]['package'])){      
            
            if($c2p_is_free && $c2p_mpt_arr[$page]['tabs'][$tab]['package'] == 'paid'){   
                return false;
            } 
        } 
                     
        return true;      
    } 
    /**
    * includes the default screen file for the current user, either admin or subscriber/user
    */
    public function include_default_screen($c2p_page_name){
        global $c2p_mpt_arr;
        if(current_user_can( 'activate_plugins' ))                                                                                                                                                                                                                                                                           
        { 
            foreach($c2p_mpt_arr[$c2p_page_name]['tabs'] as $tab_number => $tab_array)
            {       
                if(isset($tab_array['admindefault']) && $tab_array['admindefault'] == true)
                {   
                    include($c2p_mpt_arr[$c2p_page_name]['tabs'][$tab_number]['path']);    
                }    
            }       
        }
        else
        {   
            foreach($c2p_mpt_arr[$c2p_page_name]['tabs'] as $tab_number => $tab_array)
            {
                if(isset($tab_array['userdefault']) && $tab_array['userdefault'] == true)
                {
                    include($c2p_mpt_arr[$c2p_page_name]['tabs'][$tab_number]['path']);    
                }    
            }
                    
        }
    }
    /**
    * Builds a nonced admin link styled as button by Wordpress
    *
    * @package CSV 2 POST
    * @since 8.0.0
    *
    * @return string html a href link nonced by Wordpress  
    * 
    * @param mixed $tab - $C2P_WP->tabnumber()
    * @param mixed $page - $_GET['page']
    * @param mixed $action - examplenonceaction
    * @param mixed $title - Any text for a title
    * @param mixed $text - link text
    * @param mixed $values - begin with & followed by values
    */
    public function linkaction($tab,$page,$action,$title = 'CSV 2 POST admin link',$text = 'Click Here',$values = ''){
        return '<a href="'. wp_nonce_url( admin_url() . 'admin.php?page=' . $page . '&c2pprocess='.$action.'&c2ptab=' . $tab . $values, $action ) . '" title="'.$title.'" class="button c2pbutton">'.$text.'</a>';
    }
    /**
    * Get POST ID using post_name (slug)
    * 
    * @param string $name
    * @return string|null
    */
    public function get_post_ID_by_postname($name){
        global $wpdb;
        // get page id using custom query
        return $wpdb->get_var("SELECT ID 
        FROM $wpdb->posts 
        WHERE post_name = '".$name."' 
        AND post_type='page' ");
    }       
    /**
    * Returns all the columns in giving database table that hold data of the giving data type.
    * The type will be determined with PHP not based on MySQL column data types. 
    * 1. Table must have one or more records
    * 2. 1 record will be queried 
    * 3. Each columns values will be tested by PHP to determine data type
    * 4. Array returned with column names that match the giving type
    * 5. If $dt is false, all columns will be returned with their type however that is not the main purpose of this function
    * 6. Types can be custom, using regex etc. The idea is to establish if a value is of the pattern suitable for intended use.
    * 
    * @param string $tableName table name
    * @param string $dataType data type URL|IMG|NUMERIC|STRING|ARRAY
    * 
    * @returns false if no record could be found
    */
    public function cols_by_datatype($tableName,$dataType = false){
        global $wpdb,$C2P_WP;
        
        $ra = array();// returned array - our array of columns matching data type
        $matchCount = 0;// matches
        $ra['arrayinfo']['matchcount'] = $matchCount;

        $rec = $wpdb->get_results( 'SELECT * FROM '. $tableName .'  LIMIT 1',ARRAY_A);
        if(!$rec){return false;}
        
        $knownTypes = array();
        foreach($rec as $id => $value_array){
            foreach($value_array as $column => $value){     
                             
                $isURL = $C2P_WP->is_url($value);
                if($isURL){++$matchCount;$ra['matches'][] = $column;}
           
            }       
        }
        
        $ra['arrayinfo']['matchcount'] = $matchCount;
        return $ra;
    }  
    public function querylog_bytype($type = 'all',$limit = 100){
        global $wpdb;

        // where
        $where = '';
        if($type != 'all'){
          $where = 'WHERE type = "'.$type.'"';
        }

        // limit
        $limit = 'LIMIT ' . $limit;
        
        // get_results
        $rows = $wpdb->get_results( 
        "
        SELECT * 
        FROM csv2post_log
        ".$where."
        ".$limit."

        ",ARRAY_A);

        if(!$rows){
            return false;
        }else{
            return $rows;
        }
    }  
    /**
    * Determines if all tables in a giving array exist or not
    * @returns boolean true if all table exist else false if even one does not
    */
    public function tables_exist($tables_array){
        if($tables_array && is_array($tables_array)){         
            // foreach table in array, if one does not exist return false
            foreach($tables_array as $key => $table_name){
                $table_exists = C2P_WPDB::does_table_exist($table_name);  
                if(!$table_exists){          
                    return false;
                }
            }        
        }
        return true;    
    } 
    /**
    * Uses wp-admin/includes/image.php to store an image in Wordpress files and database.
    * 
    * @uses wp_insert_attachment()
    * @param mixed $imageurl
    * @param mixed $postid
    * @return boolean false on fail else $thumbid which is stored in post meta _thumbnail_id
    */
    public function create_localmedia( $url, $postid ){
        $photo = new WP_Http();
        $photo = $photo->request( $url );
        
        if(is_wp_error($photo))
        {  
            C2P_Flags::flagpost($postid,1,'thumbnail',sprintf(__('The URL giving to create a thumbnail for post with ID %s caused a Wordpress error. Please setup this posts thumbnail manually. Seek help from WebTechGlobal if this happens with too many posts.','csv2post'),$postid));
            return false;
        }
              
        $attachment = wp_upload_bits( basename( $url ), null, $photo['body'], date("Y-m", strtotime( $photo['headers']['last-modified'] ) ) );
               
        $file = $attachment['file'];
                
        // get filetype
        $type = wp_check_filetype( $file, null );
                
        // build attachment object
        $att = array(
            'post_mime_type' => $type['type'],
            'post_content' => '',
            'guid' => $url,
            'post_parent' => null,
            'post_title' => preg_replace('/\.[^.]+$/', '', basename( $attachment['file'] )),
        );
        
        // action insert attachment now
        $attach_id = wp_insert_attachment($att, $file, $postid);
        $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
        wp_update_attachment_metadata( $attach_id,  $attach_data );

        return $attach_id;
    }
    /**
    * First function to adding a post thumbnail 

    * @param mixed $overwrite_existing, if post already has a thumbnail do we want to overwrite it or leave it
    */
    public function create_post_thumbnail($post_id,$image_url,$overwrite_existing = false){
        global $wpdb,$C2P_WP;

        if(!file_is_valid_image($image_url)){  
            C2P_Flags::flagpost($post_id,1,'thumbnail',__('The URL giving to create this posts thumbnail caused a Wordpress error. Please setup this posts thumbnail manually. If this happens to many posts please troubleshoot on the WebTechGlobal website.','csv2post'));    
            return false;
        }
             
        // if post has existing thumbnail
        if($overwrite_existing == false){
            if ( get_post_meta( $post_id, '_thumbnail_id', true) || get_post_meta( $post_id, 'skip_post_thumb', true ) ) {
                return false;
            }
        }
        
        // call action function to create the thumbnail in wordpress gallery 
        $thumbid = $C2P_WP->create_localmedia( $image_url, $post_id );

        // update post meta with new thumbnail
        if ( is_numeric($thumbid) ) {
            update_post_meta( $post_id, '_thumbnail_id', $thumbid );
        }else{
            return false;
        }
    }
    /**
    * builds a url for form action, allows us to force the submission to specific tabs
    */
    public function form_action(){
        global $C2P_WP;
        $get_values = '';
        
        // apply tab
        if(isset($_GET['c2ptab'])){$get_values .= '&c2ptab='.$_GET['c2ptab'];}
        
        // apply passed values
        if(is_array($values_array)){
            foreach($values_array as $varname => $value){
                $get_values .= '&'.$varname.'='.$value;
            }
        }
        
        echo $C2P_WP->url_toadmin($_GET['page'],$get_values);    
    }
    /**
    * count the number of posts in the giving month for the giving post type
    * 
    * @param mixed $month
    * @param mixed $year
    * @param mixed $post_type
    */
    public function count_months_posts($month,$year,$post_type){                    
        $countposts = get_posts("year=$year&monthnum=$month&post_type=$post_type");
        return count($countposts);    
    }     
    /**
    * adds project id to sources for that project 
    */
    public function update_sources_withprojects($project_id,$sourcesid_array){
        global $wpdb,$C2P_DB;
        foreach($sourcesid_array as $key => $soid){
            $C2P_DB->update($wpdb->c2psources,'sourceid = ' . $soid,array('projectid' => $project_id));
        }    
    }
    public function get_project($project_id){
        global $wpdb;
        return $this->selectrow($wpdb->c2pprojects,"projectid = $project_id",'*');    
    }
    /**
    * update specific columns in project table
    * 
    * @param mixed $project_id
    * @param mixed $fields an array of columns and new value i.e. array('categories' => maybe_serialize($categories_array))
    */
    public function update_project($project_id,$fields){
        global $wpdb;
        return $this->update($wpdb->c2pprojects,"projectid = $project_id",$fields);   
    }
    /**
    * queries the projects datasources and puts all column names into an array with the table being the key
    * so that multi table projects can be used, however right now some of the plugin requires unique column names
    * 
    * @param mixed $project_id
    * @param mixed $from
    * @param boolean $apply_exclusions removes c2p columns in db method
    */
    public function get_project_columns_from_db($project_id,$apply_exclusions = true){
        if(!is_numeric($project_id)){return false;}
                     
        global $C2P_DB,$wpdb;
                    
        $sourceid_array = array();// source id's from project table into an array for looping
        $final_columns_array = array();// array of all columns with table names as keys
        $queried_already = array();// track        
        
        // get project source id's and data treatment from the project table to apply that treatment to all sources 
        $project_row = $C2P_DB->selectrow($wpdb->c2pprojects,"projectid = $project_id",'datatreatment,source1,source2,source3,source4,source5');
        
        // return the data treatment with columns to avoid having to query it again
        $final_columns_array['arrayinfo']['datatreatment'] = $project_row->datatreatment;
                       
        // put source id's into array because the rest of the function was already written before adding this approach
        $sourceid_array[] = $project_row->source1;
        if(!empty($project_row->source2)){$sourceid_array[] = $project_row->source2;}
        if(!empty($project_row->source3)){$sourceid_array[] = $project_row->source3;}
        if(!empty($project_row->source4)){$sourceid_array[] = $project_row->source4;}
        if(!empty($project_row->source5)){$sourceid_array[] = $project_row->source5;}
        
        // loop through source ID's
        foreach($sourceid_array as $key => $source_id){
            
            // get the source row
            $row = $C2P_DB->selectrow($wpdb->c2psources,'sourceid = "' . $source_id . '"','path,tablename,thesep');
            
            // avoid querying the same table twice to prevent a single table project being queried equal to number of sources
            if(!in_array($row->tablename,$queried_already)){
                $queried_already[] = $row->tablename;
                $final_columns_array[$row->tablename] = $C2P_DB->get_tablecolumns($row->tablename,true,true);
                $final_columns_array['arrayinfo']['sources'][$row->tablename] = $source_id;
            }
        }
        
        if($apply_exclusions){
            $excluded_array = array('c2p_changecounter','c2p_rowid','c2p_postid','c2p_use','c2p_updated','c2p_applied','c2p_categories','c2p_changecounter');
            foreach($final_columns_array as $table_name => $columns_array){
                foreach($excluded_array as $key => $excluded_column){
                    if(in_array($excluded_column,$columns_array)){
                        unset($final_columns_array[$table_name][$key]);
                    }
                }
            }
        }       
            
        return $final_columns_array;
    }      
    /**
    * returns array of source ID for the giving project 
    */
    public function get_project_sourcesid($project_id){
        global $C2P_DB,$wpdb;
        $result = $C2P_DB->selectwherearray($wpdb->c2pprojects,'projectid = ' . $project_id,'projectid','source1,source2,source3,source4,source5');
        $id_array = array();
        for($i=0;$i<=5;$i++){
            if(!empty($result[0]["source$i"]) && $result[0]["source$i"] !== '0'){
                $id_array[] = $result[0]["source$i"];    
            }
        }        
        return $id_array;
    }  
    public function get_rules_array($project_id){
        global $wpdb,$C2P_DB;
        $query_results = $C2P_DB->selectwherearray($wpdb->c2psources,'projectid = ' . $project_id,'sourceid','rules');
        var_dump($query_results);
        return array();
        $unser = maybe_unserialize($query_results['rules']);
        if(!is_array($unser)){
            return array();
        }else{
            return $unser;
        }
    }    
    /**
    * adds a new rule to the rules array in giving sources row in c2psources table
    * 
    * @param mixed $source_id
    * @param mixed $rule_type datatype,uppercaseall,lowercaseall,roundnumberup,roundnumberdown,captalizefirstletter
    * @param mixed $rule may be a single value i.e. a data type for the "datatype" $ruletype or it may be an array for a more complex rule
    */
    public function add_new_data_rule($source_id,$rule_type,$rule,$column){
        global $wpdb,$C2P_DB;
        $rules_array = $this->get_data_rules_source($source_id);
        
        // add rule to array                                                          
        $rules_array[$rule_type][$column] = $rule;   
        
        // serialize 
        $rules_array = maybe_serialize($rules_array);
                                               
        $C2P_DB->update($wpdb->c2psources,"sourceid = $source_id", array('rules' => $rules_array));
    }
    public function delete_data_rule($source_id,$rule_type,$column){
        global $wpdb,$C2P_DB;
        $rules_array = $this->get_data_rules_source($source_id);
        unset($rules_array[$rule_type][$column]);
        // serialize 
        $rules_array = maybe_serialize($rules_array);
                                               
        $C2P_DB->update($wpdb->c2psources,"sourceid = $source_id", array('rules' => $rules_array));            
    }   
    /**
    * returns an array of rules if any, can return empty array
    * 
    * @param numeric $source_id
    */
    public function get_data_rules_source($source_id){
        global $C2P_DB,$wpdb;
        $row = $C2P_DB->selectrow($wpdb->c2psources,"sourceid = $source_id",'rules');
        
        // initiate the rules array
        if(is_null($row->rules)){
            return array();
        }else{
            return maybe_unserialize($row->rules);
        }                      
    }    
    /**
    * gets the rules column value (null or array) for the parent source
    * 
    * use for join and append projects that have multiple sources going into one database table.
    * This is because the rule forms will submit only one table. In procedures where we loop through the 2nd and 3rd rules
    * we must compare columns to the rules array in the parent source.
    * 
    * @param mixed $project_id
    */
    public function get_parent_rulesarray($project_id){
        global $wpdb;                                                                                       
        $rules_array = $this->get_value('rules',$wpdb->c2psources,"projectid = $project_id AND parentfileid = 0");
        return maybe_unserialize($rules_array);
    }
    public function get_data_treatment($project_id){
        global $wpdb;
        return $this->get_value('datatreatment',$wpdb->c2psources,"projectid = $project_id AND parentfileid = 0");    
    }
    /**
    * import data from a single csv file
    * 
    * @param mixed $table_name
    * @param mixed $source_id
    * @param mixed $project_id
    */         
    public function import_from_csv_file($source_id,$project_id,$event_type = 'import',$inserted_limit = 9999999){
        global $wpdb,$C2P_WP,$C2P_DB;
        // get source
        $source_row = $this->get_source($project_id,$source_id);
        
        // if $event_type == update then we reset progress
        if($event_type == 'update'){
            $source_row->progress = 0;
        } 
        
        // get rules array - if multiple source project + sources were joined then we must use 
        // the main source rules array, no matter how many files are added to multi-file project, 
        // we store rules in the main source unless individual tables are in use
        $rules_array = array();
        $datatreatment = $this->get_data_treatment($project_id);
        if($datatreatment == 'join' || $datatreatment == 'append'){   
            $rules_array = $this->get_parent_rulesarray($project_id);// one rules array applied to many sources
        }else{
            $rules_array = maybe_unserialize($source_row->rules);// rule array per source (individual tables, also the default for single table users which is most common)    
        }

        //$source_object = $C2P_DB->selectrow($table_name,')
        $file = new SplFileObject(ABSPATH . $source_row->path);
        
        // put headers into array, we will use the key while processing each row, by doing it this way 
        // it should be possible for users to change their database and not interfere this procedure
        $original_headers_array = array();
        
        $rows_looped = 0;
        $inserted = 0;
        $updated = 0;
        $voidbaddata = 0;
        $voidduplicate = 0;
               
        while (!$file->eof()) {
            $insertready_array = array();
            $currentcsv_row = $file->fgetcsv($source_row->thesep,'"');
            
            // set an array of headers for keeps, we need it to build insert query and rules checking
            if($rows_looped == 0){
                $original_headers_array = $currentcsv_row;
                // create array of mysql ready headers
                $cleaned_headers_array = array();
                foreach($original_headers_array as $key => $origheader){
                    $cleaned_headers_array[] = $C2P_WP->clean_sqlcolumnname($origheader);    
                }                
                ++$rows_looped;
                continue;
            }
            
            // skip rows until $rows_looped == progress
            if($rows_looped < $source_row->progress){
                continue;
            }
            
            // build insert part of query - loop through values, build a new array with columns as the key
            foreach($currentcsv_row as $key => $value){
                $insertready_array[$cleaned_headers_array[$key]] = $value;
            }

            // insert the row
            $row_id = $C2P_DB->insert($source_row->tablename,$insertready_array);
            ++$inserted;     
   
            // apply rules
            if(!empty($rules_array)){      
                $currentcsv_row = $this->apply_rules($insertready_array,$rules_array,$row_id);
            }else{                          
                $currentcsv_row = $insertready_array;
            }

            // update row
            $C2P_DB->update($source_row->tablename,"c2p_rowid = $row_id",$currentcsv_row);

            ++$rows_looped;   
            
            if($inserted >= $inserted_limit){
                break;
            }                   
        }      
        
        // update the source with progress
        $total_progress = $source_row->progress + $inserted + $updated;// update request resets progress and so updates still count towards progress 
     
        $C2P_DB->update($wpdb->c2psources,"sourceid = $source_id",array('progress' => $total_progress));
        
        if($source_row->progress == $total_progress){
            $C2P_WP->create_notice(__("It appears all rows have been imported according to the progress counter. You could use an Update button to reset your source
            progress and make the plugin start from the first row again."),'success','Small',__('Source Fully Imported'));            
        }else{    
            if($event_type == 'import'){    
                $C2P_WP->create_notice("A total of $rows_looped .csv file rows were processed (including header). $inserted rows were inserted
                to $source_row->tablename and $updated were updated. This event may not import every row depending on your settings. Click
                import again to ensure all rows are imported.",'success','Small',__('Data Import Event Finished'));
            }elseif($event_type == 'update'){
                $C2P_WP->create_notice("A total of <strong>$rows_looped</strong> .csv file rows were processed (including header). <strong>$inserted</strong> rows were inserted
                to <strong>$source_row->tablename</strong> and <strong>$updated</strong> were updated. This event processes the entire source, all rows should now be
                in your projects database table.",'success','Small',__('Data Update Event Finished'));            
            }
        }
    }
    /**
    * applies data rules to a single array imported from csv file
    * 1. data source is used to get row from csv file, so we know we are working with the rules for that file + table
    * 2. rules array is for a single data source and a single data source is for a single file
    * 
    * @param mixed $insertready_array
    * @param mixed $rules_array
    */
    public function apply_rules($insertready_array,$rules_array,$row_id){
        global $wpdb,$C2P_WP,$C2P_DB;    

        foreach($insertready_array as $column => $value){

            if(isset($rules_array['splitter'])
            && isset($rules_array['splitter']['datasplitertable']) 
            && $rules_array['splitter']['datasplitercolumn'] == $column){
                
                $table = $rules_array['splitter']['datasplitertable'];
                
                $exploded = explode($rules_array['splitter']['separator'],$value,5);
                
                for($i=1;$i<=count($exploded);$i++){
                    $receiving_column = $rules_array['splitter']["receivingcolumn$i"];
                    $x = $i - 1;
                    $category_array[$receiving_column] = $exploded[$x];
                }              

                $C2P_DB->update($table,"c2p_rowid = $row_id",$category_array);
            } 
                        
            // round number up (roundnumberupcolumns)
            if(isset($rules_array['roundnumberupcolumns']) && isset($rules_array['roundnumberupcolumns'][$column])){
                if(is_numeric($value)){
                    $value = ceil($value); 
                }    
            }
            
            // round number (roundnumbercolumns)
            if(isset($rules_array['roundnumbercolumns']) && isset($rules_array['roundnumbercolumns'][$column])){
                if(is_numeric($value)){
                    $value = round($value); 
                }                
            }
                        
            // make first character uppercase (captalizefirstlettercolumns) 
            if(isset($rules_array['captalizefirstlettercolumns']) && isset($rules_array['captalizefirstlettercolumns'][$column])){
                $value = ucwords($value);    
            }
                    
            // make entire string lower case (lowercaseallcolumns)
            if(isset($rules_array['lowercaseallcolumns']) && isset($rules_array['lowercaseallcolumns'][$column])){
                $value = strtolower($value);    
            }
                        
            // make entire string upper case (uppercaseallcolumns)
            if(isset($rules_array['lowercaseallcolumns']) && isset($rules_array['lowercaseallcolumns'][$column])){
                $value = strtoupper($value);        
            }
            
            if(isset($rules_array['pluralizecolumns']) && isset($rules_array['pluralizecolumns'][$column])){
                $value = $C2P_WP->pluralize(2,$value,false);            
            }
           
            // update the main array
            $insertready_array[$column] = $value;
        }
       
        return $insertready_array;
    }
    /**
    * gets a single row from c2psources table, returns query result
    * 
    * @uses $C2P_DB->selectrow()
    * 
    * @param mixed $project_id
    * @param mixed $source_id
    */
    public function get_source($project_id,$source_id){
        global $C2P_DB,$wpdb;
        return $C2P_DB->selectrow($wpdb->c2psources,"projectid = $project_id AND sourceid = $source_id",'*');
    }

    public function get_parentsource_id($project_id){
        global $wpdb;                                                                                       
        return $this->get_value('sourceid',$wpdb->c2psources,"projectid = $project_id AND parentfileid = 0");
    }    
    public function get_project_main_table($project_id){
        global $wpdb;                                                                                       
        return $this->get_value('tablename',$wpdb->c2psources,"projectid = $project_id AND parentfileid = 0");    
    }    
    /**
    * gets imported rows not used to create posts, uses method to select data from multiple tables based on an ID field
    * 
    * @param mixed $project_id
    */
    public function get_unused_rows($project_id,$total = 1){
        global $CSV2POST,$C2P_WP,$c2p_settings,$wpdb,$C2P_DB;
        
        // get projects data source ID's
        $sourceid_array = $C2P_WP->get_project_sourcesid($c2p_settings['currentproject']);
        
        // create an array for storing table names
        $tables_added = array();
        
        // set the ID column using the first source row
        $idcolumn = false;
        
        // loop through source ID's and get tablename from source row
        foreach($sourceid_array as $key => $source_id){
        
            $row = $C2P_DB->selectrow($wpdb->c2psources,'sourceid = "' . $source_id . '"','tablename');
                     
            // avoid using the same table twice
            if(in_array($row->tablename,$tables_added)){
                continue;
            }
            
            $tables_added[] = $row->tablename;
        }             
        
        return $C2P_WP->query_multipletables($tables_added,'c2p_postid = 0',$total);
    }
    public function get_updated_rows($project_id,$total = 1){
        global $CSV2POST,$C2P_WP,$c2p_settings,$wpdb,$C2P_DB;
        
        // get projects data source ID's
        $sourceid_array = $C2P_WP->get_project_sourcesid($c2p_settings['currentproject']);
        
        // create an array for storing table names
        $tables_added = array();
        
        // set the ID column using the first source row
        $idcolumn = false;
        
        // loop through source ID's and get tablename from source row
        foreach($sourceid_array as $key => $source_id){

            $row = $C2P_DB->selectrow($wpdb->c2psources,'sourceid = "' . $source_id . '"','tablename,idcolumn');

            // avoid using the same table twice
            if(in_array($row->tablename,$tables_added)){
                continue;
            }
 
            if($key === 0){
                $idcolumn == $row->idcolumn;
            }
            
            $tables_added[] = $row->tablename;
        }             
        
        return $C2P_WP->query_multipletables($tables_added,$idcolumn,'c2p_postid != 0 AND c2p_updated > c2p_applied',$total);
    }
    public function create_posts($project_id,$total = 1){
        global $c2p_settings,$C2P_WP;
       
        $autoblog = new CSV2POST_InsertPost();
        $autoblog->settings = $c2p_settings;
        $autoblog->currentproject = $c2p_settings['currentproject'];
        $autoblog->project = $this->get_project($project_id);// gets project row, includes sources and settings
        $autoblog->projectid = $project_id;
        $autoblog->maintable = $C2P_WP->get_project_main_table($project_id);// main table holds post_id and progress statistics
        $autoblog->projectsettings = maybe_unserialize($autoblog->project->projectsettings);// unserialize settings
        $autoblog->projectcolumns = $this->get_project_columns_from_db($project_id);
        $autoblog->requestmethod = 'manual';
        $sourceid_array = $C2P_WP->get_project_sourcesid($project_id);
        $autoblog->mainsourceid = $sourceid_array[0];// update the main source database table per post with new post ID
        unset($autoblog->project->projectsettings);// just simplifying the project object by removing the project settings
           
        // get rows not used to create posts
        $unused_rows = $this->get_unused_rows($project_id,$total);
        
        if(!$unused_rows){
            $C2P_WP->create_notice(__('You have used all imported rows to create posts. Please
            ensure you have imported all of your data if you expected more posts than CSV 2 POST
            has already created.'),'info','Small','No Rows Available');
            return;
        }
                
        // we will control how and when we end the operation
        $autoblog->finished = false;// when true, output will be complete and foreach below will discontinue, this can be happen if maximum execution time is reached
             
        $foreach_done = 0;
        foreach($unused_rows as $key => $row){
            ++$foreach_done;
              
            // to get the output at the end, tell the class we are on the final post, only required in "manual" requestmethod
            if($foreach_done == $total){
                $autoblog->finished = true;
            }
              
            // pass row to $autob
            $autoblog->row = $row;    
            // create a post - start method is the beginning of many nested functions
            $autoblog->start();
        }
    }
    /**
    * determines if the giving term already exists within the giving level
    * 
    * this is done first by checking if the term exists in the blog anywhere at all, if not then it is an instant returned false.
    * if a match term name is found, then we investigate its use i.e. does it have a parent and does that parent have a parent. 
    * we count the number of levels and determine the existing terms level
    * 
    * if term exists in level then that terms ID is returned so that we can make use of it
    * 
    * @param mixed $term_name
    * @param mixed $level
    */
    public function term_exists_in_level($term_name = 'No Term Giving',$level = 0){
                                 
        global $wpdb,$C2P_WP;
        $all_terms_array = $C2P_WP->selectwherearray($wpdb->terms,"name = '$term_name'",'term_id','term_id');
        if(!$all_terms_array){return false;}
             
              /* at this point we might already have the future match in an array but we need to confirm its level is correct */
              
        $match_found = false;
                
        foreach($all_terms_array as $key => $term_array){
                     
            $term = get_term($term_array['term_id'],'category',ARRAY_A);

            // if level giving is zero and the current term does not have a parent then it is a match
            // we return the id to indicate that the term exists in the level
            if($level == 0 && $term['parent'] === 0){      
                return $term['term_id'];
            }

            /*  arriving here indicates the giving level is 1,2,3 or 4 (0 is the top making 5 maximum in CSV 2 POST)
                and now we need to determine how many levels deep the current term is */
             
            // get the current terms parent and the parent of that parent
            // keep going until we reach level one
            $toplevel = false;
            $looped = 0;    
            $levels_counted = 0;
            $parent_termid = $term['parent'];
            while(!$toplevel){    
                                
                // we get the parent of the current term
                $category = get_category($parent_termid);  
  
                if($category->category_parent === 0){
                    $toplevel = true;
                }else{     
                    $parent_termid = $category->category_parent;
                }
                      
                ++$looped;
                if($looped == 20){break;}
                
                ++$levels_counted;
            }  
            
            // so after the while we have a count of the number of levels above the "current term"
            // if that count + 1 matches the level required for the giving term term then we have a match, return current term_id
            $levels_counted = $levels_counted;
            if($levels_counted == $level){
                return $term['term_id'];
            }       
        }
                  
        // arriving here means no match found, either create the term or troubleshoot if there really is meant to be a match
        return false;
    }    
}
// end class C2P_WP

/**
* Use to insert a new post, class systematically calls all methods one after the other building the $my_post object
* 1. methods are in alphabetical order
* 2. each method calls the next one in the list
* 3. eventually a method creates the post using the $my_post object built along the way
* 4. $my_post is then used to add custom fields, thumbnail/featured image and other attachments or meta
* 5. many methods check for their target value to exist in $my_post already and instead alter it (meaning we can re-call the class on an object)
* 6. some methods check for values in the $my_post object and perform procedures based on the values found or not found
*/
class CSV2POST_InsertPost{
    public $my_post = array('post_title' => 'No Post Title Setup','post_content' => 'No Post Content Setup');
    public $report_array = array();// will include any problems detected, can be emailed to user    
    public function replace_tokens($subject){
        unset($this->projectcolumns['arrayinfo']);
        foreach($this->row as $columnfromquery => $usersdata){ 
            foreach($this->projectcolumns as $table_name => $columnfromdb){  
                $subject = str_replace('#'. $columnfromquery . '#', $usersdata,$subject);
            }    
        }
        return $subject;
    } 
    public function start(){
        $this->my_post = array(); 
        $this->author();
    }
    /**
    * decide author (from data or a default author)
    */
    public function author(){    
        $author_set = false;
        
        // check projects author settings for author data          
        if(isset($this->projectsettings['authors']['email']['column']) && !empty($this->projectsettings['authors']['email']['column'])
        && isset($this->projectsettings['authors']['username']['column']) && !empty($this->projectsettings['authors']['username']['column'])){
            // check data $row for a numeric value
            if(isset($this->row[ $this->projectsettings['authors']['email']['column'] ]) && is_numeric($this->row[ $this->projectsettings['authors']['email']['column'] ])){
                $this->my_post['author'] = $this->row[ $this->projectsettings['authors']['email']['column'] ];
                $author_set = true;
            }
        }
        
        // if not $author_set check for a project default author
        if(!$author_set && isset($this->projectsettings['basicsettings']['defaultauthor']) && is_numeric($this->projectsettings['basicsettings']['defaultauthor'])){
            $this->my_post['author'] = $this->projectsettings['basicsettings']['defaultauthor']; 
        }
        
        // call next method
        $this->categories();
    }    
    public function categories(){    
        global $C2P_WP;
        if(isset($this->projectsettings['categories'])){ 
            if(isset($this->projectsettings['categories']['data'])){ 
                $projection_array = array();
                $group_array = array();// we will store each cat ID in this array (use to apply parent and store in project table)
                $level = 0;// in theory this should increment, so that is a good check to do when debugging
                
                // loop through all values in $row
                unset($this->projectcolumns['arrayinfo']);
                // loop through all columns/values in the row of data
                foreach($this->row as $columnfromquery => $my_term){ 
                    // loop through all project columns
                    foreach($this->projectcolumns as $table_name => $columnfromdb){
               
                        // determine if $columnfromquery and $table_name are selected category data columns
                        // also establish the level by using array of category column data 
                        foreach($this->projectsettings['categories']['data'] as $thelevel => $catarray){
                            if($catarray['table'] == $table_name && $catarray['column'] == $columnfromquery){
                                $level = $thelevel;
                    
                                // is post manually mapped to this table + column + term
                                if(isset($categories_array['categories']['mapping'][$table_name][$columnfromdb][ $my_term ])){
                                    // we apply $level here, this is important in this procedure because the order we encounter category terms
                                    // within data may not be in the level order, possibly!
                                    $group_array[$level] = $categories_array['categories']['mapping'][$table_name][$columnfromdb][ $my_term ];
                                
                                }else{
                                    
                                    // does term exist within the current level? 
                                    $existing_term_id = $C2P_WP->term_exists_in_level($my_term,$level);                                                
                                    if(is_numeric($existing_term_id)){
                                        $group_array[$level] = $existing_term_id;
                                    }else{
                                        
                                        // set parent id, by deducting one from the current $level and getting the previous category from $group_array
                                        $parent_id = 0;
                                        if($level > 0){
                                            $parent_keyin_group = $level - 1;
                                            $parent_id = $group_array[$parent_keyin_group];   
                                        }
                                        
                                        // create a new category term with a parent (if first category it parent is 0)
                                        $new_cat_id = wp_create_category( $my_term, $parent_id );
                                          
                                        if(isset($new_cat_id) && is_numeric($new_cat_id)){
                                            $group_array[$level] = $new_cat_id;    
                                        }
                                    }
                                }                             
                            }
                        }
                    }    
                }
            }
            
            if(isset($group_array) && is_array($group_array)){
                $this->my_post['post_category'] = $group_array;
            }             
        }  
         
        // call next method
        $this->commentstatus();
    }    
    public function commentstatus(){      
        
        if(isset($this->projectsettings['basicsettings']['commentstatus']) && is_numeric($this->projectsettings['basicsettings']['commentstatus'])){
            $this->my_post['comment_status'] = $this->projectsettings['basicsettings']['commentstatus']; 
        }
                
        // call next method
        $this->content();        
    }    
    public function content(){     
        
        if(isset($this->projectsettings['content']['wysiwygdefaultcontent'])){
            $this->my_post['post_content'] = $this->replace_tokens($this->projectsettings['content']['wysiwygdefaultcontent']);    
        }    
        
        if(!isset($this->my_post['post_content']) || empty($this->my_post['post_content'])){
            $this->my_post['post_content'] = __('No Post Content Setup');    
        }
           
        // call next method
        $this->customfields();        
    }    
    /**
    * does not create meta data, only establishes what meta data is to be created and it is created later
    * it is done this way so that rules can take meta into consideration and meta can be adjusted prior to post creation 
    */
    public function customfields(){    
        $this->my_post['newcustomfields'] = array();// we will add keys and values to this, the custom fields are created later    
        $i = 0;// count number of custom fields, use it as array key
        
        // seo title meta
        if(isset($this->projectsettings['customfields']['seotitletemplate']) && !empty($this->projectsettings['customfields']['seotitletemplate'])
        && isset($this->projectsettings['customfields']['seotitlekey']) && !empty($this->projectsettings['customfields']['seotitlekey'])){
            $this->my_post['newcustomfields'][$i]['value'] = $this->replace_tokens($this->projectsettings['customfields']['seotitletemplate']);
            $this->my_post['newcustomfields'][$i]['name'] = $this->projectsettings['customfields']['seotitlekey']; 
            ++$i; 
        }
        
        // seo description meta
        if(isset($this->projectsettings['customfields']['seodescriptiontemplate']) && !empty($this->projectsettings['customfields']['seodescriptiontemplate'])
        && isset($this->projectsettings['customfields']['seodescriptionkey']) && !empty($this->projectsettings['customfields']['seodescriptionkey'])){
            $this->my_post['newcustomfields'][$i]['value'] = $this->replace_tokens($this->projectsettings['customfields']['seodescriptiontemplate']);
            $this->my_post['newcustomfields'][$i]['name'] = $this->projectsettings['customfields']['seodescriptionkey'];  
            ++$i; 
        }
                
        // seo keywords meta
        if(isset($this->projectsettings['customfields']['seokeywordstemplate']) && !empty($this->projectsettings['customfields']['seokeywordstemplate'])
        && isset($this->projectsettings['customfields']['seokeywordskey']) && !empty($this->projectsettings['customfields']['seokeywordskey'])){
            $this->my_post['newcustomfields'][$i]['value'] = $this->replace_tokens($this->projectsettings['customfields']['seokeywordstemplate']);
            $this->my_post['newcustomfields'][$i]['name'] = $this->projectsettings['customfields']['seokeywordskey']; 
            ++$i;       
        }       
        
        // now add all other custom fields
        if(isset($this->projectsettings['customfields']['cflist'])){
            foreach($this->projectsettings['customfields']['cflist'] as $key => $cf){
                $this->my_post['newcustomfields'][$i]['value'] = $this->replace_tokens($cf['value']);
                $this->my_post['newcustomfields'][$i]['name'] = $cf['name'];                
                ++$i;     
            }
        }

        // call next method
        $this->excerpt();        
    }
    public function excerpt(){        
        
        // call next method
        $this->pingstatus();         
    }    
    public function pingstatus(){       
        
        if(isset($this->projectsettings['basicsettings']['pingstatus'])){
            $this->my_post['ping_status'] = $this->projectsettings['basicsettings']['pingstatus']; 
        }
        
        // call next method
        $this->posttype();        
    }  
    public function posttype(){      
        if(isset($this->projectsettings['dates']['publishdatemethod']) && is_string($this->projectsettings['dates']['publishdatemethod'])){
            switch ($this->projectsettings['dates']['publishdatemethod']) {
               case 'data':
                    if(isset($this->projectsettings['dates']['column']) && is_string($this->projectsettings['dates']['column'])){
                        $strtotime = strtotime($this->row[$this->projectsettings['dates']['column']]);
                        $this->my_post['post_date'] = date("Y-m-d H:i:s", $strtotime);
                    }
                 break;  
               case 'incremental':
            
                // establish minutes increment
                $increment = rand( $this->projectsettings['dates']['naturalvariationlow'], $this->projectsettings['dates']['naturalvariationhigh'] );    

                // get start date/time - this is updated per post so that the next post increments properly
                $start_time = strtotime($this->projectsettings['dates']['incrementalstartdate']);
       
                // add increment to start time to establish publish time
                $publish_seconds = $start_time + $increment; 
        
                $this->my_post['post_date'] =  date("Y-m-d H:i:s", $publish_seconds );
                $this->my_post['post_date_gmt'] = gmdate("Y-m-d H:i:s", $publish_seconds ); 
                
                // update project array with latest date
                $this->projectsettings['dates']['incrementalstartdate'] = date('Y-m-d H:i:s',$publish_seconds);               

                 break;
               case 'random':
                    
                    // establish start time and end time
                    $start_time = strtotime($this->projectsettings['dates']['randomdateearliest']);
                    $end_time = strtotime($this->projectsettings['dates']['randomdatelatest']);            
                    
                    // make random time between our start and end
                    $publish_time = rand( $start_time, $end_time );
                    
                    $this->my_post['post_date'] =  date("Y-m-d H:i:s", $publish_time );
                    $this->my_post['post_date_gmt'] = gmdate("Y-m-d H:i:s", $publish_time );
              
                 break;
            }        
        }                

        // call next method
        $this->spinner();        
    }    
    public function spinner(){        
        if(isset($this->projectsettings['tags']) && is_array($this->projectsettings['tags'])){
            // set excluded tags array
            if(isset($this->projectsettings['tags']['excludedtags'])){
                if(is_array($this->projectsettings['tags']['excludedtags'])){
                    $excluded_tags = $this->projectsettings['tags']['excludedtags'];
                }else{
                    $excluded_tags = explode(',',$this->projectsettings['tags']['excludedtags']);
                }
            }
            
            $final_tags_array = array();
            // get tags data, break down into array using comma
            if($this->projectsettings['tags']['column']){
                $exploded_tags = explode(',',$this->row[$this->projectsettings['tags']['column']]);
                $final_tags_array = array_merge($final_tags_array,$exploded_tags);
            }
            // generate tags from text data
            if(isset($this->projectsettings['tags']['textdata']['column']) && !is_string($this->projectsettings['tags']['textdata']['column'])){
                // remove multiple spaces, returns, tabs, etc.
                $text = preg_replace("/[\n\r\t\s ]+/i", " ", $this->row[$this->projectsettings['tags']['textdata']['column']]);                
                // replace full stops and spaces with a comma (command required in explode)
                $text = str_replace(array("   ","  "," ",".",'"'),",", $text );
                $exploded_tags = explode(',',$text);
                $final_tags_array = array_merge($final_tags_array,$exploded_tags);                        
            }
            // cleanup tags
            foreach($final_tags_array as $key => $tag){
                // remove numeric values
                if(isset($this->projectsettings['tags']['defaultnumerics']) 
                && $this->projectsettings['tags']['defaultnumerics'] == 'disallow'
                && is_numeric($tag)){
                    unset($final_tags_array[$key]);
                }
                // remove exclusions
                if(in_array($tag,$excluded_tags)){
                    unset($final_tags_array[$key]);
                }   
            }
            // remove extra tags  
            if(isset($this->projectsettings['tags']['maximumtags']) && is_numeric($this->projectsettings['tags']['maximumtags'])){
                $final_tags_array = array_slice($final_tags_array, 0, $this->projectsettings['tags']['maximumtags']);
            }
            
            $this->my_post['tags_input'] = implode(",", $final_tags_array);                        
        }
        
        // call next method
        $this->title();        
    }       
    public function title(){          

        if(isset($this->projectsettings['titles']['defaulttitletemplate'])){
            $this->my_post['post_title'] = $this->replace_tokens($this->projectsettings['titles']['defaulttitletemplate']);    
        }       
        
        if(!isset($this->my_post['post_title']) || empty($this->my_post['post_title'])){
            $this->my_post['post_title'] = __('No Post Title Setup');    
        }
                
        // call next method
        $this->wpautop();         
    }
    /**
    * change double line breaks into paragraphs
    * 
    * @link https://codex.wordpress.org/Function_Reference/wpautop
    */
    public function wpautop(){           
        
        /*  need a setting to apply this or not, it changes double line breaks into <p>
        if(isset($this->my_post['post_content'])){
            $this->my_post['post_content'] = wpautop($this->my_post['post_content']);
        }
        */

        // call next method
        $this->insert_post();        
    }
    public function insert_post(){            
    
        $this->my_post['ID'] = wp_insert_post( $this->my_post );
       
        // call next method
        $this->insert_customfields();        
    }
    /**
    * insert users custom fields, the values are determined before this method
    */
    public function insert_customfields(){      
        if(isset($this->my_post['ID']) && is_numeric($this->my_post['ID'])){
            foreach($this->my_post['newcustomfields'] as $key => $cf){
                add_post_meta($this->my_post['ID'],$cf['name'],$cf['value']);
            }
        }
        
        // call next method
        $this->insert_plugins_customfields();    
    }    
    /**
    * insert plugins custom fields, used to track and mass manage posts
    */
    public function insert_plugins_customfields(){      
        global $C2P_WP;
        
        // add data source ID for querying source
        add_post_meta($this->my_post['ID'],'c2p_datasource', $this->mainsourceid);
                                                   
        // add meta to hold the data row ID for querying row that was used to create post
        add_post_meta($this->my_post['ID'],'c2p_rowid',$this->row['c2p_rowid']);

        // call next method
        $this->update_project();    
    }
    /**
    * update project statistics
    * 1. save the last post created for reference
    * 2. store the entire $my_post object for debugging
    * 3. update the projectsettings value itself (incremental publish date is one example value that needs tracked per post)    
    */
    public function update_project(){           
        global $C2P_WP;
        $C2P_WP->update_project($this->projectid, array('projectsettings' => maybe_serialize($this->projectsettings) ));
        
        // call next method
        $this->update_row();        
    }
    /**
    * updates the users data row, add post ID to create a relationship between imported row and the new post 
    */
    public function update_row(){          
        global $C2P_DB;      
        $row_id = $this->row['c2p_rowid'];
        $C2P_DB->update($this->maintable,"c2p_rowid = $row_id",array('c2p_postid' => $this->my_post['ID']));
        // call next method
        $this->output();        
    }
    /**
    * output results, method is used for manual post creation request only
    */
    public function output(){
        global $C2P_WP;
        // $autoblog->finished == true indicates procedure just done the final post or the time limit is reached
        if($this->requestmethod == 'manual' && $this->finished === true){
            $C2P_WP->create_notice(__('The post creation procedure has finished.'),'success','Small','Posts Created');
        }
    }
}
?>