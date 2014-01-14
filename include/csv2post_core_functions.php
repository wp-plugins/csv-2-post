<?php
/** 
 * Core functions for CSV 2 POST plugin 
 * 
 * @package CSV 2 POST
 * 
 * @since 0.0.1
 * 
 * @copyright (c) 2009-2013 webtechglobal.co.uk
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * 
 * @author Ryan Bayne | ryan@webtechglobal.co.uk
 */

class CSV2POST {
    protected
        $filters = array(),
        $actions = array(),    
        // Format: array( event | function in this class(in an array if optional arguments are needed) | loading circumstances)
        $plugin_actions = array(
            //array('widgets_init',             'My_Widget',                                  'all'),    
        ),
                                 
        $plugin_filters = array(
            /*
                Examples - last value are the sections the filter apply to
                    array('plugin_row_meta',                     array('examplefunction1', 10, 2),         'all'),
                    array('page_link',                             array('examplefunction2', 10, 2),             'downloads'),
                    array('admin_footer_text',                     'examplefunction3',                         'monetization'),
                    
            */
        );
         
    private
        $doneInit = false;   
        
    public function __construct() 
    {

    } 
    
    public function wp_init() 
    {
        if($this->has_inited()) {
            return false;
        }
        $this->doneInit = true;
                
        $this->add_actions();
        $this->add_filters();
        unset($this->plugin_actions, $this->plugin_filters);
    }
    
    /**
     * if WP e-Customers already initialised returns true
     * @return bool true if already inited
     */
    public function has_inited() 
    {
        return $this->doneInit;
    }
                        
    protected function add_actions() 
    {          
        foreach($this->plugin_actions as $actionArray) {        
            list($action, $details, $whenToLoad) = $actionArray;
                                   
            if(!$this->filteraction_should_beloaded($whenToLoad)) {      
                continue;
            }
                 
            switch(count($details)) {         
                case 3:
                    add_action($action, array($this, $details[0]), $details[1], $details[2]);     
                break;
                case 2:
                    add_action($action, array($this, $details[0]), $details[1]);   
                break;
                case 1:
                default:
                    add_action($action, array($this, $details));
            }
        }    
    }
    
    protected function add_filters() 
    {
        foreach($this->plugin_filters as $filterArray) {
            list($filter, $details, $whenToLoad) = $filterArray;
                           
            if(!$this->filteraction_should_beloaded($whenToLoad)) {
                continue;
            }
            
            switch(count($details)) {
                case 3:
                    add_filter($filter, array($this, $details[0]), $details[1], $details[2]);
                break;
                case 2:
                    add_filter($filter, array($this, $details[0]), $details[1]);
                break;
                case 1:
                default:
                    add_filter($filter, array($this, $details));
            }
        }    
    }    
    
    /**
    * Should the giving action or filter be loaded?
    * 1. we can add security and check settings per case
    * 2. each case is a section and we use this approach to load action or filter for specific section
    * 3. In early development all sections are loaded, this function is prep for a modular plugin
    * 4. addons will require core functions like this to be updated rather than me writing dynamic functions for any possible addons
    *  
    * @param mixed $whenToLoad
    */
    private function filteraction_should_beloaded($whenToLoad) 
    {
        global $csv2post_sections_array;
                                
        if($whenToLoad != 'all' && !in_array($whenToLoad,$csv2post_sections_array) ) {
            return false;
        }
                      
        switch($whenToLoad) {
            case 'all':    
                return true;
            break;
            case 'specificpageexample1':
                return true;    
            break;
            case 'specificuserexample1':
                return true;
            break;
        }

        return true;
    }     
}

/**
* displays update status (we can improve this widget to offer a button for manual update)
*/
class CSV2POST_Widget_UpdatePost extends WP_Widget {

    public function __construct() 
    {
        parent::__construct(
                'csv2postwidgetupdatepost', // Base ID
                __('CSV 2 POST Update Post', 'text_domain'), // Name
                array( 'description' => __( 'A Widget right here', 'text_domain' ), ) // Args
            );
    }

    public function widget( $args, $instance ) 
    {
        global $current_user;
        
        // process returns reasons 
        if(!isset($GLOBALS['post']->ID)){return;}
        if(!isset($current_user->ID)){return;}
        if(!user_can($current_user->ID,'activate_plugins')){return false;}     
              
        $title = apply_filters( 'widget_title', $instance['title'] );
        echo $args['before_widget'];
        
        if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];
        
        $is_post_outdated = csv2post_is_post_outdated($GLOBALS['post']->ID);
        if($is_post_outdated)
        {
            echo '<p>No updates are required for the current post.</p>';    
        }
        else
        {
            echo '<p>The current post can be updated.</p>';    
        }
        
        echo $args['after_widget'];
    }
}

// php 5.3
/*
add_action( 'widgets_init', function(){
    register_widget( 'CSV2POST_Widget_UpdatePost' );
});
  */
  
// php 5.2
add_action('widgets_init',
     create_function('', 'return register_widget("CSV2POST_Widget_UpdatePost");')
);

/** 
 * Free edition file (applies to paid also) for CSV 2 POST plugin by WebTechGlobal.co.uk
 *
 * @package CSV 2 POST
 * 
 * @author Ryan Bayne | ryan@webtechglobal.co.uk
 */
 
/**
* Imports data from CSV file. This is the basic version of this function that does not perform data updating.
* 
* @param mixed $csvfile_name
* @param mixed $table_name
* @param mixed $target
* @param mixed $jobcode
* @return false
*/
function csv2post_data_import_from_csvfile_basic( $csvfile_name, $table_name, $target = 1, $jobcode ){
    
    global $wpdb,$csv2post_adm_set;

    $file_path = WTG_C2P_CONTENTFOLDER_DIR . $csvfile_name;  

    // get files modification time
    $csvfile_modtime = filemtime($file_path);
    
    // set job statistics
    $inserted = 0;// INSERT to table
    $updated = 0;// UPDATE on a record in table
    $deleted = 0;// DELETE i.e. user does not want old records that are no longer in the CSV file to be kept in table
    $void = 0;// IMPORTED OR UPDATE, but then made void so it cannot be used
    $dropped = 0;// number or rows that have been skipped, possibly through failure or users configuration
    $duplicates = 0;
    // NEW VARIABLES
    $continue = false;// when set to true it indicates that the loop has passed all rows already processed
    $new_rows_processed = 0;// $new_rows_processed is the counter when a record is created in database ready to update row data to    
    $while_start = 0;// counter increased at very beginning of while loop
    $while_end = 0;// counter increased at very end of while loop
        
    // get the data import job array
    $dataimportjob_array = csv2post_get_dataimportjob($jobcode); 
      
    // TEMPORARY VARIABLES TODO: HIGHPRIORITY, set these variables using the job details
    $multiplefile_project = true;
    $duplicate_check = false;
    $default_order = true;
    
    // set configuration array
    $conf = array();
    $conf['sep'] = $dataimportjob_array[$csvfile_name]['separator'];
    $conf['quote'] = $dataimportjob_array[$csvfile_name]['quote'];
    $conf['fields'] = $dataimportjob_array[$csvfile_name]['fields']; 
    
    // get files past progress - this is used to skip CSV file rows until reaching a row not yet processed
    $progress = 0;
    if(isset($dataimportjob_array['stats']['allevents']['progress'])){
        $progress = $dataimportjob_array['stats']['allevents']['progress'];
    }
       
    // point where loop finished last - we loop until at the record after it (this includes the header row)
    $lastrow = 0;
    if(isset($dataimportjob_array['stats'][$csvfile_name]['lastrow'])){
        $lastrow = $dataimportjob_array['stats'][$csvfile_name]['lastrow'];
    }
    
    $handle = fopen($file_path, "r");
    $row = 0;

    while (($data = fgetcsv($handle, 10000, $conf['sep'],$conf['quote'])) !== FALSE) {
        
        ++$while_start;// used to know where we should continue in new events 
  
        // if 2nd row or after
        if($while_start > 1){

            if($while_start > $lastrow ){

                // we insert a null record, this allows us to focus on the update function as the main function for both insert and updating. 
                // Avoids duplicate code on a vital part of the plugin and this is important due to the complexity of features that will be added later
                $record_id = csv2post_WP_SQL_insert_new_record( $table_name, $csvfile_modtime ); 
                ++$new_rows_processed;   
 
                $updaterecord_result = csv2post_WP_SQL_update_record_dataimportjob( $data, $csvfile_name, $conf['fields'], $jobcode,$record_id, $dataimportjob_array[$csvfile_name]['headers'],$dataimportjob_array['filegrouping'] );

                if($updaterecord_result){  
                    ++$inserted;    
                }else{             
                    ++$dropped;
                } 
            }
        } 
        
        // if $new_rows_processed == $target break loop (we met users requested rows)
        if($new_rows_processed == $target){
            break;
        }

        // unset variables
        unset($updaterecord_result);
        unset($record_id);
        
        ++$while_end;        
    }       

    #############################################################################
    #                                                                           #
    #             END OF DATA IMPORT JOB EVENT - STORE STATISTICS               #
    #                                                                           #
    #############################################################################
    // update last event values
    $dataimportjob_array['stats']['lastevent']['loop_count'] = $while_start;    
    $dataimportjob_array['stats']['lastevent']['processed'] = $new_rows_processed;
    $dataimportjob_array['stats']['lastevent']['inserted'] = $inserted;    
    $dataimportjob_array['stats']['lastevent']['updated'] = $updated;    
    $dataimportjob_array['stats']['lastevent']['deleted'] = $deleted;        
    $dataimportjob_array['stats']['lastevent']['void'] = $void;        
    $dataimportjob_array['stats']['lastevent']['dropped'] = $dropped;        
    $dataimportjob_array['stats']['lastevent']['duplicates'] = $duplicates;
    // update all event values
    $dataimportjob_array['stats']['allevents']['progress'] = $while_start + $dataimportjob_array['stats']['allevents']['progress'];
    $dataimportjob_array['stats']['allevents']['inserted'] = $inserted + $dataimportjob_array['stats']['allevents']['inserted'];    
    $dataimportjob_array['stats']['allevents']['updated'] = $updated + $dataimportjob_array['stats']['allevents']['updated'];
    $dataimportjob_array['stats']['allevents']['deleted'] = $deleted + $dataimportjob_array['stats']['allevents']['deleted'];
    $dataimportjob_array['stats']['allevents']['void'] = $void + $dataimportjob_array['stats']['allevents']['void'];    
    $dataimportjob_array['stats']['allevents']['dropped'] = $dropped + $dataimportjob_array['stats']['allevents']['dropped'];    
    $dataimportjob_array['stats']['allevents']['duplicates'] = $duplicates + $dataimportjob_array['stats']['allevents']['duplicates'];    
    // update the current files statistics
    $dataimportjob_array['stats'][$csvfile_name]['lastrow'] = $while_start; 
    $dataimportjob_array['stats'][$csvfile_name]['progress'] = $while_start + $dataimportjob_array['stats'][$csvfile_name]['progress'];
    $dataimportjob_array['stats'][$csvfile_name]['inserted'] = $inserted + $dataimportjob_array['stats'][$csvfile_name]['inserted'];    
    $dataimportjob_array['stats'][$csvfile_name]['updated'] = $updated + $dataimportjob_array['stats'][$csvfile_name]['updated'];
    $dataimportjob_array['stats'][$csvfile_name]['deleted'] = $deleted + $dataimportjob_array['stats'][$csvfile_name]['deleted'];
    $dataimportjob_array['stats'][$csvfile_name]['void'] = $void + $dataimportjob_array['stats'][$csvfile_name]['void'];    
    $dataimportjob_array['stats'][$csvfile_name]['dropped'] = $dropped + $dataimportjob_array['stats'][$csvfile_name]['dropped'];    
    $dataimportjob_array['stats'][$csvfile_name]['duplicates'] = $duplicates + $dataimportjob_array['stats'][$csvfile_name]['duplicates'];
                       
    // save the $function_result_array in the job array
    csv2post_update_dataimportjob($dataimportjob_array,$jobcode);

    return $dataimportjob_array;    
}  

/**
* Loads scripts for plugin not core
* 
* @param string $side, admin, public
* @param mixed $csv2post_script_side_override, makes use of admin lines in front-end of blog 
*/
function csv2post_script_plugin($side = 'admin',$csv2post_script_side_override = false){
    ### if plugin package requires custom script, include a parent script file here which establishes which script to queue
}

/**
* Loads CSS for plugin not core
* 
* @param string $side, admin, public
* @param mixed $csv2post_css_side_override, makes use of admin lines in front-end of blog
*/
function csv2post_css_plugin($side = 'admin',$csv2post_css_side_override = false){        
    ### if plugin requires custom CSS include parent CSS file here
}

/**
 * Checks existing plugins and displays notices with advice or informaton
 * This is not only for code conflicts but operational conflicts also especially automated processes
 *
 * $return $critical_conflict_result true or false (true indicatesd a critical conflict found, prevents installation, this should be very rare)
 * 
 * @todo make this function available to process manually so user can check notices again
 * @todo re-enable warnings for none activated plugins is_plugin_inactive, do so when Notice Boxes have closure button
 */
function csv2post_plugin_conflict_prevention(){
    global $csv2post_plugintitle;
    // track critical conflicts, return the result and use to prevent installation
    // only change $conflict_found to true if the conflict is critical, if it only effects partial use
    // then allow installation but warn user
    $conflict_found = false;

    // Wordpress HTTPS  EXAMPLE
    /*
    $plugin_profiles[1]['switch'] = 1;//used to use or not use this profile, 0 is no and 1 is use
    $plugin_profiles[1]['title'] = 'Wordpress HTTPS';
    $plugin_profiles[1]['slug'] = 'wordpress-https/wordpress-https.php';
    $plugin_profiles[1]['author'] = 'Mvied';
    $plugin_profiles[1]['title_active'] = 'Wordpress HTTPS Conflict';
    $plugin_profiles[1]['message_active'] = __('On 15th August 2012 a critical and persistent conflict was found 
    between Wordpress HTTPS and CSV 2 POST. It breaks the jQuery UI tabs by making all panels/features show on
    one screen rather than on individual tabbed screens. A search on Google found many posts regarding the
    plugin causing JavaScript related conflicts, responded to my the plugins author. So please ensure you
    have the latest version. One of the posts suggested the fault, was exactly as we found to be causing our
    broken interface in CSV 2 POST. URL were being re-written, specifically those passed through jQuery UI functions
    were having a slash removed. It would not just break the interface but submitting some forms would fail
    because the action location URL would be wrong. This sounds like the fault described by a Wordpress HTTPS user,
    before the author responded to it. So not sure what is going on but right now we do not feel we can provide the
    fix. Please still let us know if you are seeing this message, we need to know how popular the conflicting plugin
    is while using CSV 2 POST for auto-blogging.');
    $plugin_profiles[1]['title_inactive'] = 'title inactive';
    $plugin_profiles[1]['message_inactive'] = __('message inactive');
    $plugin_profiles[1]['type'] = 'info';//passed to the message function to apply styling and set type of notice displayed
    $plugin_profiles[1]['criticalconflict'] = true;// true indicates that the conflict will happen if plugin active i.e. not specific settings only, simply being active has an effect
    */
        
    // we create an array of profiles for plugins we want to check
    $plugin_profiles = array();

    // Tweet My Post (javascript conflict and a critical one that breaks entire interface)
    $plugin_profiles[0]['switch'] = 1;//used to use or not use this profile, 0 is no and 1 is use
    $plugin_profiles[0]['title'] = 'Tweet My Post';
    $plugin_profiles[0]['slug'] = 'tweet-my-post/tweet-my-post.php';
    $plugin_profiles[0]['author'] = 'ksg91';
    $plugin_profiles[0]['title_active'] = 'Tweet My Post Conflict';
    $plugin_profiles[0]['message_active'] = __('Please deactivate Twitter plugins before performing mass post creation. 
    This will avoid spamming Twitter and causing more processing while creating posts.');
    $plugin_profiles[0]['title_inactive'] = 'title inactive';
    $plugin_profiles[0]['message_inactive'] = __('message inactive');
    $plugin_profiles[0]['type'] = 'info';//passed to the message function to apply styling and set type of notice displayed
    $plugin_profiles[0]['criticalconflict'] = true;// true indicates that the conflict will happen if plugin active i.e. not specific settings only, simply being active has an effect
                         
    // loop through the profiles now
    if(isset($plugin_profiles) && $plugin_profiles != false){
        foreach($plugin_profiles as $key=>$plugin){   
            if( is_plugin_active( $plugin['slug']) ){ 
               
                // recommend that the user does not use the plugin
                csv2post_notice($plugin['message_active'],'warning','Large',$plugin['title_active'],'','echo');

                // if the conflict is critical, we will prevent installation
                if($plugin['criticalconflict'] == true){
                    $conflict_found = true;// indicates critical conflict found
                }
                
            }elseif(is_plugin_inactive($plugin['slug'])){
                // warn user about potential problems if they active the plugin
                // csv2post_notice($plugin['message_inactive'],'info','Tiny',false);
            }
        }
    }

    return $conflict_found;
} 

/**
* Establishes the key value from ['headers'] array in job_array for giving job code and CSV filename
* 
* @returns array key for giving header within giving filenames ['header'] array else returns false
* @param string $header_name the CSV file column name
* @param string $file_name name of CSV file the header name is for
* @param string $job_code data import job code
*/
function csv2post_get_headers_key($header_name,$csvfile_name,$job_code){
    // get job array
    $job_array = csv2post_get_dataimportjob($job_code);
    // loop through giving files headers
    foreach($job_array[$csvfile_name]['headers'] as $key => $header){
        if($header['original'] == $header_name){
            return $key;
        }
    }    
    
    return false;
} 
                
/**
* Establishes the giving files ID within the giving job
* 
* @param mixed $_POST
* @returns integer $fileid, if a match is found, the ID applies to the giving job and file only. It is appened to table column names
* @returns boolean false if csv file loop does not match a file up to the giving $csvfile_name
*/
function csv2post_get_csvfile_id($csvfile_name,$jobcode){
    $dataimportjob_array = csv2post_get_dataimportjob($jobcode);
    // loop through the jobs files until we reach the giving file name then return its ID
    foreach($dataimportjob_array['files'] as $fileid => $filename ){
        if($filename == $csvfile_name){
            return $fileid;
        }
    }
    return false;
}                        

/**
* Get the post title for the default content template. 
*/
function csv2post_get_default_contenttemplate_name(){
    global $csv2post_currentproject_code;
    $default_template_id = csv2post_get_default_contenttemplate_id( $csv2post_currentproject_code );

    if(!$default_template_id || $default_template_id == '0'){
        return 'No Default Content Template';
    }else{
        // get wtgcsvtemplate post title
        $template_post = get_post($default_template_id); 
        if(!$template_post){
            return 'Default Template Missing';
        }
        return $template_post->post_title;        
    }
}

function csv2post_get_default_excerpttemplate_name(){
    global $csv2post_currentproject_code;
    $default_template_id = csv2post_get_default_excerpttemplate_id( $csv2post_currentproject_code );

    if(!$default_template_id || $default_template_id == '0'){
        return 'No Default Excerpt Template';
    }else{
        // get wtgcsvtemplate post title
        $template_post = get_post($default_template_id);
        if(!$template_post){
            return 'Default Template Missing';
        }         
        return $template_post->post_title;        
    }
}

function csv2post_get_default_titletemplate_name(){
    global $csv2post_currentproject_code;
    $default_template_id = csv2post_get_default_titletemplate_id( $csv2post_currentproject_code );

    if(!$default_template_id || $default_template_id == '0'){
        return 'No Default Title Template';
    }else{
        // get wtgcsvtemplate post title
        $template_post = get_post($default_template_id);
        if(!$template_post){
            return 'Default Template Missing';
        }         
        return $template_post->post_title;        
    }
}

/**
* Gets the content of giving title template ID (also a post id)
* 
* @returns string indicating fault and includes giving ID
* @param mixed $project_array
*/
function csv2post_get_titletemplate_design($title_template_id){
    $template_post = get_post($title_template_id);
    if(!$template_post){
        return 'Fault:title template post not found with ID ' . $title_template_id;
    } 
    return $template_post->post_content;    
}

/**
* Gets the content of giving content template id (also a post id)
* 
* @param mixed $title_template_id
*/
function csv2post_get_template_design($content_template_id){
    $template_post = get_post($content_template_id);
    if(!$template_post){
        return 'Fault:template post not found with ID ' . $content_template_id .', you have possibly deleted it by mistake?';
    } 
    return $template_post->post_content;    
}
         
/**
* Gets the default content template id (post_id for wtgcsvcontent post type) for the giving project
* 
* @param mixed $project_code
* @returns false if no current project or current project has no default template yet
*/
function csv2post_get_default_contenttemplate_id( $project_code ){
    if(!isset($project_code)){
        return false;
    }else{
        $project_array = csv2post_get_project_array($project_code);
        if(isset($project_array['default_contenttemplate_id'])){
            return $project_array['default_contenttemplate_id'];            
        }
    }  
    return false;  
}

function csv2post_get_default_excerpttemplate_id( $project_code ){
    if(!isset($project_code)){
        return false;
    }else{
        $project_array = csv2post_get_project_array($project_code);
        if(isset($project_array['default_excerpttemplate_id'])){
            return $project_array['default_excerpttemplate_id'];            
        }
    }  
    return false;  
}

/**
* Gets the default title template id (post_id for wtgcsvtitle post type) for the giving project
* 
* @param mixed $csv2post_currentproject_code
* @returns false if no current project or current project has no default title template yet
*/
function csv2post_get_default_titletemplate_id( $csv2post_currentproject_code ){
    if(!isset($csv2post_currentproject_code)){
        return false;
    }else{
        $project_array = csv2post_get_project_array($csv2post_currentproject_code);

        if(isset($project_array['default_titletemplate_id'])){
            return $project_array['default_titletemplate_id'];            
        }
    }  
    return false;  
}

/**
* Returns the Wordpress option record value for giving project code
* 
* @uses unserialize before return 
* @param mixed $project_code
* @return mixed, false on fail or no option record exists
* 
* @link http://www.webtechglobal.co.uk/hacking/project-array-csv2post_project_array
*/
function csv2post_get_project_array($project_code){
    $getproject_array = get_option( 'csv2post_' . $project_code );
    $getproject_array_unserialized = maybe_unserialize($getproject_array);
    return $getproject_array_unserialized;
}

/**
* Updates (also adds) new option record for post creation project
* 
* @param string $project_code
* @param array $project_array
*/
function csv2post_update_option_postcreationproject($project_code,$project_array){
    // update project list array to indicate changes have happened
    csv2post_project_changed($project_code);
    // now save the project array
    $project_array_serialized = maybe_serialize($project_array);
    $update_result = update_option('csv2post_' . $project_code,$project_array_serialized);
    return $update_result;    
}

/**
* Returns specified part of array resulting from explode on string.
* Can only be used properly when the number of values in resulting array is known
* and when the returned parts type is known.
* 
* @param mixed $delimeter
* @param mixed $returnpart
* @param mixed $string
*/
function csv2post_explode_tablecolumn_returnnode($delimeter,$returnpart,$string){
    $explode_array = explode($delimeter,$string);
    return $explode_array[$returnpart];    
}

/**
* add new post creation project to data import job array
* @param mixed $project_code
* @param mixed $project_name
* @return bool          
*/
function csv2post_update_option_postcreationproject_list_newproject($project_code,$project_name){
    global $csv2post_projectslist_array;
    if(!is_array($csv2post_projectslist_array)){$csv2post_projectslist_array = array();}
    $csv2post_projectslist_array[$project_code]['name'] = $project_name; 
    return update_option('csv2post_projectslist',serialize($csv2post_projectslist_array));     
}

/**
* Gets the $csv2post_file_profiles array which holds details relating to any entered file. 
* 2012 uses CSV files only, but at some stage we may use this array for other files. 
* The data is used to track changes and apply behaviours using settings.
* 1. Creates the option with a serialized array as value if it does not already exist 
*/
function csv2post_get_option_fileprofiles(){
    $file_profiles_array = get_option('csv2post_file_profiles');
    $val = maybe_unserialize($file_profiles_array);
    if(!is_array($val)){
        update_option('csv2post_file_profiles',maybe_serialize(array()));
        return array();
    }
    return $val;            
}

/**
* Update csv file profile array
* 
* @param mixed $file_profiles_array
*/
function csv2post_update_option_fileprofiles($file_profiles_array){
    return update_option('csv2post_file_profiles',maybe_serialize($file_profiles_array));           
}

/**
* Returns array of all existing projects, used to create a list of projects
* @returns false if no option for csv2post_projectslist exists else returns unserialized array 
*/
function csv2post_get_projectslist(){
    return maybe_unserialize(get_option('csv2post_projectslist'));
}

/**
* Returns last key from giving array. Sorts the array by key also (only works if not mixed numeric alpha).
* Use before adding new entry to array. This approach allows the key to be displayed to user for reference or returned for other use.
* 
* @uses ksort, sorts array key order should the keys be random order
* @uses end, moves internal pointer to end of array
* @uses key, returns the key for giving array element
* @returns mixed, key value could be string or numeric depending on giving array
*/
function csv2post_get_array_lastkey($array){
    ksort($array);
    end($array);
    return key($array);
} 

/**
* Gets array of data import jobs and returns it as it is from Wordpress options record
* @returns false if no array stored or problem accessing options table 
*/
function csv2post_get_option_dataimportjobs_array(){
    $dataimportjobs_array = get_option('csv2post_dataimportjobs');
    $val = maybe_unserialize($dataimportjobs_array);
    if(!is_array($val)){
        return false;    
    }
    return $val;
}

/**
* Gets array of job tables and returns it as it is from Wordpress options record.
* Can use this to check what tables belong to which jobs and for quickly deleting all job tables etc.
* 
* @returns false if no array stored or problem accessing options table 
*/
function csv2post_get_option_jobtable_array(){
    $jobtables_array = get_option('csv2post_jobtables');
    $val = maybe_unserialize($jobtables_array);
    if(!is_array($val)){
        return false;
    }
    return $val;    
}

/**
* Gets the text spin array ($csv2post_textspin_array) if stored in wp_option table 
*/
function csv2post_get_option_textspin_array(){
    $textsspin_array = get_option('csv2post_textspin');
    $val = maybe_unserialize($textsspin_array);
    if(!is_array($val)){
        return false;
    }
    return $val;    
}

/**
* Updates option record for $csv2post_textspin_array
* 
* @param mixed $textspin_array
*/
function csv2post_update_option_textspin($textspin_array){
    $textspin_array_seralized = maybe_serialize($textspin_array);
    $result = update_option('csv2post_textspin',$textspin_array_seralized);
    $wperror_result = csv2post_is_WP_Error($result);
    if($wperror_result){
        return false;
    }else{
        return true;
    }    
}

/**
* Creates or updates existing a job tables array record in wordpress options table
*/
function csv2post_update_option_jobtables_array($csv2post_jobtable_array){
    $jobtables_array_seralized = maybe_serialize($csv2post_jobtable_array);
    $result = update_option('csv2post_jobtables',$jobtables_array_seralized);
    $wperror_result = csv2post_is_WP_Error($result);
    if($wperror_result){
        return false;
    }else{
        return true;
    }
}

/**
* Gets a data import job option record using the giving code
* @return false if get_option does not return an array else the array is returned
*/
function csv2post_get_dataimportjob($jobcode){
    $val = maybe_unserialize(get_option('csv2post_' . $jobcode));// should return an array
    if(!is_array($val)){
        return false;    
    }
    return $val;    
}

/**
* Returns just the headers for a single giving CSV file within a single giving job
*/
function csv2post_get_dataimportjob_headers_singlefile($jobcode,$csvfile_name){
    $dataimportjob_array = csv2post_get_dataimportjob($jobcode);
    return $dataimportjob_array[$csvfile_name]['headers'];    
} 

/**
* Creates or updates existing data import job record in wordpress options table
* 
* @param mixed $jobarray
* @param string $code
* @returns boolean, true if success or false if failed
*/
function csv2post_update_dataimportjob($jobarray,$code){            
    $jobarray_seralized = maybe_serialize($jobarray);
    $result = update_option('csv2post_' . $code,$jobarray_seralized);
    $wperror_result = csv2post_is_WP_Error($result);
    if($wperror_result){
        return false;
    }else{
        // update current job code
        global $csv2post_currentjob_code;
        $csv2post_currentjob_code = $code;
        return true;
    }
} 

/**
* Deletes the option record for giving data import job code
* 
* @param mixed $jobcode
*/
function csv2post_delete_dataimportjob_optionrecord($jobcode){
    return delete_option('csv2post_' . $jobcode);    
}

/**
* Updates data import jobs array
*/
function csv2post_update_option_dataimportjobs($dataimportjob_array){
    $dataimportjob_array_serialized = maybe_serialize($dataimportjob_array);
    update_option('csv2post_dataimportjobs',$dataimportjob_array_serialized);
}

/**
* add new job to data import job array
* 
* @param string $code, acts as an ID for the job but I never called it ID due to so many other ID existing in Wordpress
* @param string $jobname, human identifier of the job
*/
function csv2post_add_dataimportjob_to_list($code,$jobname){
    global $csv2post_dataimportjobs_array;
    if(!$csv2post_dataimportjobs_array || $csv2post_dataimportjobs_array == false){
        $csv2post_dataimportjobs_array = array();    
    }
    $csv2post_dataimportjobs_array[$code]['name'] = $jobname;
    csv2post_update_option_dataimportjobs($csv2post_dataimportjobs_array);    
}

/**
* Uses fget, not PEAR CSV, to get header row of csv file and count number of fields/columns
* @return int
*/
function csv2post_establish_csvfile_fieldnumber($csvfile_name,$separator){
     // get the header row
    if (($handle = fopen(WTG_C2P_CONTENTFOLDER_DIR . $csvfile_name, "r")) !== FALSE) {

        // one row at a time we will count each possible Separator
        while (($header_row_string = fgets($handle, 4096)) !== false) {
            break;                        
        }  

        fclose($handle); 
    }    

    $header_array = explode($separator,$header_row_string);// explode the header row 
    return count( $header_array );// count number of values in array    
}     

/**
* Returns a project table, either the already set [main] table or the first one in the list as default 
*/
function csv2post_get_project_maintable($project_code){
    // get project array
    $project_array = csv2post_get_project_array($project_code);
    if(isset($project_array['maintable'])){
        return $project_array['maintable'];
    }elseif(isset($project_array['tables'][0])){
        return $project_array['tables'][0];
    }else{
        return 'ERROR:csv2post_get_project_maintable could not determine main project table';
    }
} 

/**
* Establishes if giving project has any posts.
* Currently it only does this based on projects tables 
* 
* @param mixed $project_code
*/
function csv2post_does_project_have_posts($project_code){
    
    $project_array = csv2post_get_project_array($project_code);

    $usedrecords = csv2post_WP_SQL_used_records($project_array['maintable'],1);
    
    if($usedrecords){
        return true;
    }else{
        return false;
    }   
}

/**
* Determines if a giving CSV file name is in use (used to prevent delection of a file or using more than once)
* 
* @param mixed $file_is_in_use
* @param mixed $output
*/
function csv2post_is_csvfile_in_use($csv_file_name,$output = true){
    global $csv2post_job_array,$csv2post_dataimportjobs_array;
    // if file is in a data import job (user can delete the data import job and database table stays)
    foreach($csv2post_dataimportjobs_array as $jobid => $job){

        // get the jobs own option record
        $jobrecord = csv2post_get_dataimportjob($jobid);
        if(!$jobrecord && $output == true){
            csv2post_notice('Failed to locate the option table record for data import job named '.$job['name'].'. 
            Is it possible the record was deleted manually?','error','Tiny','','','echo');
        }else{

            foreach($jobrecord['files'] as $key => $csvfile_name){
                if($csv_file_name == $csvfile_name){
                    return true;
                } 
            } 
               
        }
    }
    
    return false;
}

/**
* Checks if the giving value already exists in the giving CSV files ID column. This is really only
* meant for using with the premium edition and in advanced data import functions.
* 
* @param mixed $csvfile_name
* @param mixed $table_name
* @param mixed $jobcode
* @return csv2post_id numeric value else returns false
*/
function csv2post_WP_SQL_query_rowid_exists($sql_adapted, $table_name, $row_id_value){
    global $wpdb;
    
    $r = $wpdb->get_row("SELECT csv2post_id FROM ".$table_name." WHERE ".$sql_adapted." = '".$row_id_value."'");
    
    if ($r != null) {
        return $r->csv2post_id;
    } else {
        return false;
    }
    
    return false;  
}

/**
* All data values read from CSV files goes through this function before being imported to database.
* Use this function to apply any other functions in free edition only. Use csv2post_data_prep_fromcsvfile_advanced() in paid.
* 1. CSV file headers are not put through this function, if that is ever needed we should either create another function or add optional parameter on this one
*/
function csv2post_data_prep_fromcsvfile($value){
           
    // if utf8_encode() wanted
    if(!isset($csv2post_adm_set['encoding']['type']) || isset($csv2post_adm_set['encoding']['type']) && $csv2post_adm_set['encoding']['type'] == 'utf8'){
        $value = utf8_encode($value);    
    }     
          
    return $value;  
} 

/**
* Updates $csv2post_projectslist_array and changes a projects ['modified'] value which is used to
* determine if posts need updating. This is not the only method used for determining if a post is outdated.
* This method allows us to go through the list and extract a recently changed project then check if any
* posts require updating. If no posts require updating, the ['updatecomplete'] value is changed to true, to
* indicate that we cannot locate any posts requiring updating. We can then ignore the modified date even if it 
* is very recent. 
*/
function csv2post_project_changed($project_code){
    global $csv2post_projectslist_array;
    if(isset($csv2post_projectslist_array[$project_code])){
        $csv2post_projectslist_array[$project_code]['modified'] = csv2post_date();
        $csv2post_projectslist_array[$project_code]['updatecomplete'] = false;
        csv2post_update_option_postcreationproject_list($csv2post_projectslist_array); 
    }
}    

/**
* Returns current data import job name 
*/
function csv2post_current_jobname(){
    global $csv2post_currentjob_code,$csv2post_dataimportjobs_array; 
     
    if(!isset($csv2post_dataimportjobs_array[$csv2post_currentjob_code]['name'])){
        false;
    }else{
        return $csv2post_dataimportjobs_array[$csv2post_currentjob_code]['name']; 
    }
            
}

/**
* Establishes categories for post - 2013 method where cat ID are already in records.
* 
*/
function csv2post_post_categories($record_array){
    global $csv2post_project_array;
    
    if(!isset($csv2post_project_array['categories'])){
        return array(0);
    }

    // if a default is set and no levels set we can apply the default now
    if(isset($csv2post_project_array['categories']['default']) && !isset($csv2post_project_array['categories']['level1'])){  
        return array($csv2post_project_array['categories']['default']);                    
    }

    // if applydepth = 1 then we apply the last category only, do not append            
    if(!isset($csv2post_project_array['categories']['applydepth']) || isset($csv2post_project_array['categories']['applydepth']) 
    && $csv2post_project_array['categories']['applydepth'] == 0){
        // all cat ID will be applied
        return array($record_array['csv2post_catid']);  
    }else{
        // value of 1 means one category (the last ID)
        $cat_array = explode(',',$record_array['csv2post_catid']); 
        return array(end($cat_array));
    }
}    
?>