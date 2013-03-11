<?php
/**
* When request will display maximum php errors including Wordpress errors 
*/
function csv2post_debugmode(){
    global $csv2post_debug_mode;
    if($csv2post_debug_mode){
        global $wpdb;
        ini_set('display_errors',1);
        error_reporting(E_ALL);      
        if(!defined("WP_DEBUG_DISPLAY")){define("WP_DEBUG_DISPLAY",true);}
        if(!defined("WP_DEBUG_LOG")){define("WP_DEBUG_LOG",true);}
        //add_action( 'all', create_function( '', 'var_dump( current_filter() );' ) );
        //define( 'SAVEQUERIES', true );
        //define( 'SCRIPT_DEBUG', true );
        $wpdb->show_errors();
        $wpdb->print_error();
        
    }
}

/**
* Used to determine if a screen is meant to be displayed or not, based on package and settings 
*/
function csv2post_menu_should_tab_be_displayed($page,$tab){
    global $csv2post_mpt_arr,$csv2post_is_free;

    // if screen not active
    if(isset($csv2post_mpt_arr['menu'][$page]['tabs'][$tab]['active']) && $csv2post_mpt_arr['menu'][$page]['tabs'][$tab]['active'] == false){
        return false;
    }    

    // if user does not want screen displays
    if(isset($csv2post_mpt_arr['menu'][$page]['tabs'][ $tab ]['display']) && $csv2post_mpt_arr['menu'][$page]['tabs'][ $tab ]['display'] == false){  
        return false;    
    }
                 
    // if package is not set return true and display page. This will only effect users who upgrade but do not re-install menu
    // the ['package'] value was added 5th January 2013, we will be forcing a re-install of the menu in version 6.7.4
    if(!isset($csv2post_mpt_arr['menu'][$page]['tabs'][$tab]['package'])){      
        return true;
    }
                 
    // if package is free and screen is free OR if package is not free and screen is not free = return false
    if($csv2post_is_free && $csv2post_mpt_arr['menu'][$page]['tabs'][$tab]['package'] == 'free'  
    || !$csv2post_is_free && $csv2post_mpt_arr['menu'][$page]['tabs'][$tab]['package'] == 'paid'){   
        return true;
    }

    // if package is not free and screen is free = return true
    if(!$csv2post_is_free && $csv2post_mpt_arr['menu'][$page]['tabs'][$tab]['package'] == 'free'){   
        return true;
    }   
                 
    return false;      
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
    
    // we create an array of profiles for plugins we want to check
    $plugin_profiles = array();

    // Tweet My Post (javascript conflict and a critical one that breaks entire interface)
    $plugin_profiles[0]['switch'] = 1;//used to use or not use this profile, 0 is no and 1 is use
    $plugin_profiles[0]['title'] = 'Tweet My Post';
    $plugin_profiles[0]['slug'] = 'tweet-my-post/tweet-my-post.php';
    $plugin_profiles[0]['author'] = 'ksg91';
    $plugin_profiles[0]['title_active'] = 'Tweet My Post Conflict';
    $plugin_profiles[0]['message_active'] = __('On 16th August 2012 a critical and persistent conflict was found 
    between Tweet My Post 
    and '.$csv2post_plugintitle.'. It breaks the plugins dialog boxes (jQuery UI Dialogue) while the plugin is active,
    you may not be able to install '.$csv2post_plugintitle.' due to this. After some searching we found many others to be having
    JavaScript related conflicts with this plugin, which the author responded too. Please ensure you have the latest
    version installed.
    The closest cause I found in terms of code was line 40 where a .js file (jquery-latest) is registered. This
    file is not used in '.$csv2post_plugintitle.' so at this time we are not sure why the conflict happens. Please let us know
    if your urgently need this conflict fixed. We will investigate but due to the type of plugin, it is not urgent.
    Auto-tweeting is not recommended during auto blogging due to the risk of spamming Twitter. If you know the plugin
    well you can avoid spamming however and so let us know if this conflict is a problem for you.');
    $plugin_profiles[0]['title_inactive'] = 'title inactive';
    $plugin_profiles[0]['message_inactive'] = __('message inactive');
    $plugin_profiles[0]['type'] = 'info';//passed to the message function to apply styling and set type of notice displayed
    $plugin_profiles[0]['criticalconflict'] = true;// true indicates that the conflict will happen if plugin active i.e. not specific settings only, simply being active has an effect
    
    // Wordpress HTTPS
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
    
    /*******  type values =  success,warning,error,question,processing,stop    *****/
                                  
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
* Get random values from giving array
* 
* @param mixed $array
* @param mixed $number number of random values to get
*/
function csv2post_ARRAYS_random_value($array,$number = 1){
    $rand_key = array_rand( $array,$number );
    return $array[ $rand_key ];      
}

/**
* Gets the following value that comes after the giving value.
* Requires a current value for which its key will be established. 
* Using the key we can establish the next value.
* 
* 1. Array keys must be numeric and incremented. If doubt establish another solution.
* 2. Returns random value instead of generating a false return where any issues are found 
* 
* @returns false on failure to establish the next value
*/
function csv2post_ARRAYS_get_next_value($array,$current_value){

    if(!is_array($array)){return $current_value;}
    
    // get the key for the current value
    $current_value_key = array_search ( $current_value , $array , true );
    
    // if we cannot find the value in the array (user may have edited it, then return a random value)
    if(!$current_value_key || !is_numeric($current_value_key)){
        return csv2post_ARRAYS_random_value($array);
    }
    
    $next_key = $current_value_key + 1;

    if(!isset($array[$next_key])){
        return csv2post_ARRAYS_random_value($array);// key is missing so return a random value instead    
    }
    
    return $current_value_key;
}

/**
* Returns value for displaying or hiding a page based on edition (free or full).
* These is no point bypassing this. The pages hidden require PHP that is only provided with
* the full edition. You may be able to use the forms, but the data saved won't do anything or might
* cause problems.
* 
* @param mixed $package_allowed, 0=free 1=full/paid 2=dont ever display
* @returns boolean true if screen is to be shown else false
* 
* @deprecated
*/
function csv2post_page_show_hide($package_allowed = 0){
    global $csv2post_is_free;
    
    if($package_allowed == 2){
        return false;// do not display in any package   
    }elseif($csv2post_is_free && $package_allowed == 0){
        return true;     
    }elseif($csv2post_is_free && $package_allowed == 1){
        return false;// paid edition page only, not be displayed in free edition
    }
    return true;
}

/**
* Gets option value for csv2post_adminset or defaults to the file version of the array if option returns invalid.
* 1. Called in the main csv2post.php file.
* 2. Installs the admin settings option record if it is currently missing due to the settings being required by all screens, this is to begin applying and configuring settings straighta away for a per user experience 
*/
function csv2post_get_option_adminsettings(){
    $result = csv2post_option('csv2post_adminset','get');
    $result = maybe_unserialize($result); 
    if(is_array($result)){
        return $result; 
    }else{     
        return csv2post_INSTALL_admin_settings();
    }  
}     
    
/**
* Gets tab menu array
* 
* @todo LOWPRIORITY, rename function, it gets array from file not just option record. Possible csv2post_WP_SETTINGS_tabmenu()
*   
*/
function csv2post_get_option_tabmenu(){
    global $csv2post_adm_set;# this is coming from the loaded array file
    // if load method not set and global is an array return the global
    if(isset($csv2post_adm_set['tabmenu']['loadmethod']) && $csv2post_adm_set['tabmenu']['loadmethod'] == 'file'){

        require_once(WTG_C2P_DIR.'pages/csv2post_variables_tabmenu_array.php');
        return $csv2post_adm_set;
                      
    }else{

        // load from option array but only return value if its a valid array else we install the admin settings array now        
        $result = csv2post_option('csv2post_tabmenu','get');
        if(is_array($result) && isset($result['menu'])){# if the new ['menu'] is not in array we re-install
            return $result;
        }else{
            // users wants menu to load from stored option value but it returned an invald value
            return csv2post_INSTALL_tabmenu_settings();# returns the tabmenu array
        }
    }        
}        

/**
* Formats number into currency, default is en_GB and no GBP i.e. not GBP145.50 just 145.50 is returned
* 
* @param mixed $s
*/
function csv2post_format_money($s){
    setlocale(LC_MONETARY, 'en_GB');
    return money_format('%!2n',$s) . "\n";        
}

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
    
    global $wpdb;
    
    csv2post_pearcsv_include();    

    // get files modification time
    $csvfile_modtime = filemtime(WTG_C2P_CONTENTFOLDER_DIR .'/'. $csvfile_name);
    
    // set job statistics
    $inserted = 0;// INSERT to table
    $updated = 0;// UPDATE on a record in table
    $deleted = 0;// DELETE record when CSV file does not appear to still include it
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

    // loop through records using PEAR CSV File_CSV::read   
    while ( ( $record = File_CSV::read( WTG_C2P_CONTENTFOLDER_DIR .'/'. $csvfile_name, $conf ) ) ) {        
        ++$while_start;// used to know where we should continue in new events 
            
        // if 2nd row or after
        if($while_start > 1){

            if($while_start > $lastrow ){

                $record_id = csv2post_WP_SQL_insert_new_record( $table_name, $csvfile_modtime ); 
                ++$new_rows_processed;   

                $updaterecord_result = csv2post_WP_SQL_update_record_dataimportjob( $record, $csvfile_name, $conf['fields'], $jobcode,$record_id, $dataimportjob_array[$csvfile_name]['headers'],$dataimportjob_array['filegrouping'] );

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
    csv2post_save_dataimportjob($dataimportjob_array,$jobcode);

    return $dataimportjob_array;    
} 

/**
* Determine if post exists using any giving method
*/
function csv2post_does_post_exist($method,$value) {
    
    if($method == 'id'){
        return csv2post_WP_SQL_does_post_exist_byid($value);
    }
    return false;
}  

/**
* CSV file test - uses the configuration established through fget function and over-rides the configuration
* established using PEAR CSV. This is to test File_CSV::read works when giving correct config. 
*/
function csv2post_test_csvfile_countfields_fgetpriority( $csvfile_name, $separator, $quote ){
    
    global $wpdb;
    
    csv2post_pearcsv_include();  
    
    ################################################################################################
    #                                                                                              #
    #           FGET FIRST - USE COLUMN COUNT IN PEAR CSV TO DETERMINE IF THE RESULT IS EQUAL      #
    #                                                                                              #
    ################################################################################################
    
    // get the header row
    if (($handle = fopen(WTG_C2P_CONTENTFOLDER_DIR . '/' . $csvfile_name, "r")) !== FALSE) {

        // one row at a time we will count each possible Separator
        while (($header_row_string = fgets($handle, 4096)) !== false) {
            break;                        
        }  

        fclose($handle); 
    }    

    // if PEAR CSV somehow could not get header row we end the test here
    if(!$header_row_string){
        csv2post_notice('The plugin could not retrieve the header row from your CSV file while running a test. Please ensure you select the correct separator then try again and seek support if you continue to experience problems.','error','Large','Test 4: Count CSV File Column Headers Using fget','','echo');
        return;
    } 

    $header_array = explode($separator,$header_row_string);// explode the header row 
    $fgetcsv_header_count = count( $header_array );// count number of values in array 
    
    ###############################################################################################
    #                                                                                             #
    #        PEAR CSV NOW - DO NOT USE File_CSV::discoverFormat WE WILL SET $conf ourselves       #
    #                                                                                             #
    ###############################################################################################
    
    // use pear to read csv file
    $conf = File_CSV::discoverFormat( WTG_C2P_CONTENTFOLDER_DIR .'/'. $csvfile_name );
    $conf['fields'] = $fgetcsv_header_count;
    
    // apply auto determined or user defined separator and quote values
    if(isset($dataimportjob_array[$csvfile_name]['separator'])){
        $conf['sep'] = $separator;        
    }
    
    if(isset($dataimportjob_array[$csvfile_name]['quote'])){
        $conf['quote'] = $quote;        
    }    

    // loop through records   
    while ( ( $record = File_CSV::read( WTG_C2P_CONTENTFOLDER_DIR .'/'. $csvfile_name, $conf ) ) ) {        
        $PEARCSV_count = count($record);
    }

    if(!isset($PEARCSV_count)){
        csv2post_notice('Could not establish CSV file column header number using PEAR CSV, possibly due to the 
        wrong separator being used. Please ensure the correct separator is in use then run more tests or 
        seek support.','warning','Large','Test 4: Count CSV File Column Headers Using PEAR CSV','','echo');    
        return;
    }else{
        
        // compare both counts
        if($PEARCSV_count != $fgetcsv_header_count){
            csv2post_notice('Two methods of counting your CSV files returned different results. This is not a fault,
            it happens with certain formats of CSV file i.e. no quotes or tab instead of comma. This test is to 
            establish the best method to read your CSV file '.$csvfile_name.'.
            Below are the returned counts.<br /><br />
             <ul>
             <li><strong>PEAR CSV: '.$conf['fields'].'</strong></li>
             <li><strong>fgetcsv: '.$fgetcsv_header_count.'</strong></li>             
             </ul><br /><br />You must use the method that has counted the correct number of columns or alter your
             CSV file so that both methods works. PEAR CSV is the plugins default.','warning','Large','Test 4: Count CSV File Column Headers Using All Methods (fget is priority)','','echo');
            return;
        }     
        csv2post_notice('I counted '.$conf['fields'].' fields/columns in '.$csvfile_name.'. If this happens to be incorrect it must be investigated. This test
        establishes your files configuration using fget and over-rides the PEAR CSV method.','success','Large','Test 4: Count CSV File Column Headers Using All Methods (fget is priority)','','echo');
    }  
}   

/**
* CSV file test - this test will show a fail if the config from PEAR CSV File_CSV::discoverFormat
* does not match the fget result. This will usually indicate user needs to use fget method.
*/
function csv2post_test_csvfile_countfields_pearcsvpriority( $csvfile_name, $separator, $quote ){
    
    global $wpdb;
    
    csv2post_pearcsv_include();  
    
    ################################################################################################
    #                                                                                              #
    #           FGET FIRST - USE COLUMN COUNT IN PEAR CSV TO DETERMINE IF THE RESULT IS EQUAL      #
    #                                                                                              #
    ################################################################################################
    
    // get the header row
    if (($handle = fopen(WTG_C2P_CONTENTFOLDER_DIR . '/' . $csvfile_name, "r")) !== FALSE) {

        // one row at a time we will count each possible Separator
        while (($header_row_string = fgets($handle, 4096)) !== false) {
            break;                        
        }  

        fclose($handle); 
    }    

    // if PEAR CSV somehow could not get header row we end the test here
    if(!$header_row_string){
        csv2post_notice('The plugin could not retrieve the header row from your CSV file while running a test. Please ensure you select the correct separator then try again and seek support if you continue to experience problems.','error','Large','Test 5: Count CSV File Column Headers Using fget','','echo');
        return;
    } 

    $header_array = explode($separator,$header_row_string);// explode the header row 
    $fgetcsv_header_count = count( $header_array );// count number of values in array 
    
    ###############################################################################################
    #                                                                                             #
    #        PEAR CSV NOW - DO NOT USE File_CSV::discoverFormat WE WILL SET $conf ourselves       #
    #                                                                                             #
    ###############################################################################################
    
    // use pear to read csv file
    $conf = File_CSV::discoverFormat( WTG_C2P_CONTENTFOLDER_DIR .'/'. $csvfile_name );

    // apply auto determined or user defined separator and quote values
    if(isset($dataimportjob_array[$csvfile_name]['separator'])){
        $conf['sep'] = $separator;        
    }
    
    if(isset($dataimportjob_array[$csvfile_name]['quote'])){
        $conf['quote'] = $quote;        
    }    

    // loop through records   
    while ( ( $record = File_CSV::read( WTG_C2P_CONTENTFOLDER_DIR .'/'. $csvfile_name, $conf ) ) ) {        
        $PEARCSV_count = count($record);
    }

    if(!isset($PEARCSV_count) || $PEARCSV_count == 1){
        csv2post_notice('Could not establish CSV file column headers number using PEAR CSV. If you are sure that
        all quotes and separators are in the correct place. You should use the fget method for reading your CSV file
        rather then PEAR CSV.','warning','Large','Test 5: Count CSV File Column Headers Using PEAR CSV','','echo');    
        return;
    }else{
        
        // compare both counts
        if($PEARCSV_count != $fgetcsv_header_count){
            csv2post_notice('Two methods of counting your CSV files returned different results. This is not a fault,
            it happens with certain formats of CSV file i.e. no quotes or tab instead of comma. This test is to 
            establish the best method to read your CSV file '.$csvfile_name.'.
            Below are the returned counts.<br /><br />
             <ul>
             <li><strong>PEAR CSV: '.$conf['fields'].'</strong></li>
             <li><strong>fgetcsv: '.$fgetcsv_header_count.'</strong></li>             
             </ul><br /><br />You must use the method that has counted the correct number of columns or alter your
             CSV file so that both methods works. PEAR CSV is the plugins default.','warning','Large','Test 5: Count CSV File Column Headers Using All Methods','','echo');
            return;
        }     
        csv2post_notice('I counted '.$conf['fields'].' fields/columns in '.$csvfile_name.'. If this happens to be incorrect it must be investigated. This test
        establishes your files configuration using fget and also does it using PEAR CSV. Comparison of field/column count is made
        to help establish what method of reading CSV files is suitable for '.$csvfile_name.'.','success','Large','Test 5: Count CSV File Column Headers Using All Methods','','echo');
    }  
}

/**
* Updates empty premade record in data job table using CSV file row.
* Reports errors to server log.
* 
* @returns boolean, true if an update was done with success else returns false
* 
* @param mixed $record
* @param mixed $csvfile_name
* @param mixed $fields
* @param mixed $jobcode
* @param mixed $record_id
* @param mixed $headers_array
*/
function csv2post_WP_SQL_update_record_dataimportjob( $record, $csvfile_name, $fields, $jobcode,$record_id, $headers_array,$filegrouping ){
    global $csv2post_plugintitle;
    // using new record id - update the record
    $updaterecord_result = csv2post_WP_SQL_update_record( $record, $csvfile_name, $fields, $jobcode,$record_id, $headers_array, $filegrouping );

    // increase $inserted counter if the update was a success, the full process counts as a new inserted record            
    if($updaterecord_result === false){
        
        return false;
        csv2post_error_log($csv2post_plugintitle . ': csv2post_WP_SQL_update_record() returned FALSE for JOB:'.$jobcode.' FILE:'.$csvfile_name.'. Please investigate.');                
    
    }elseif($updaterecord_result === 1){ 
        
        return true; 
          
    }elseif($updaterecord_result === 0){
        
        csv2post_error_log($csv2post_plugintitle . ': csv2post_WP_SQL_update_record() returned 0 for JOB:'.$jobcode.' FILE:'.$csvfile_name.'. Please investigate.');
        return false;
    }  
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
 * Standard HTTP forwarding
 * @param array $attributes_array
 * @property string status (standard http code i.e. 301 Moved Permanently)
 * @property url location (must begin with http)#
 * 
 * @todo add log recording and possibly statistical storing
 * @todo validate passed url before forwarding, provide option to not apply validation also
 * @todo ensure url validation includes forward slash at end
 * @todo validate status to expected values
 */
function csv2post_header_forward($atts){
    extract( shortcode_atts( array(
            'status' => '301 Moved Permanently',
            'location' => 'http://www.webtechglobal.co.uk',
    ), $atts ) );

    // clear cache then return result
    $wpdb->flush();
    
    // TODO: LOWPRIORITY, confirm this is the best way to do this in Wordpress (is there possibly a Wordpress method)
    header("HTTP/1.1 ".$status."");
    header("Status: ".$status."");
    header("Location: ".$location."");
    header("Connection: close");
    exit(0); // Optional, prevents any accidental output
}

/**
 * Establishes if an arrays element count is odd or even (currently divided by 2)
 * For using when balancing tables
 * @param array $array
 * 
 * @todo divide by any giving number, validate the number, the function that builds the table will need to handle that
 */
function csv2post_oddeven_arrayelements($array){
    $oddoreven_array = array();

    // store total number of items in totalelements key
    $oddoreven_array['totalelements'] = count($array);

    // store the calculation result from division before rounding up or down, usually up
    $oddoreven_array['divisionbeforerounded'] = $oddoreven_array['totalelements'] / 2;

    // round divisionbeforerounded using ceil and store the answer in columnlimitceil, this is the first columns maximum number of items
    $oddoreven_array['columnlimitceil'] = ceil($oddoreven_array['divisionbeforerounded']);

    // compare our maths answer with the ceil value - if they are not equal then the total is odd
    // if the total is oddd we then know the last column must have one less item, a blank row in the table
    if($oddoreven_array['divisionbeforerounded'] == $oddoreven_array['columnlimitceil']){
        $oddoreven_array['balance'] = 'even';
    }else{
        $oddoreven_array['balance'] = 'odd';
    }

    return $oddoreven_array;
}

/**
 * Starts A Timer - Used To Time Scripts
 * @return the current time in micro
 * 
 * @todo microtime function has caused problems with some users, research alternatives if any
 * @todo put error reporting in this to handle problems better
 */
function csv2post_microtimer_start(){
    list($utime, $time) = explode(" ", microtime());
    return ((float)$utime + (float)$time);
}

/**
 * Validate a url (http https ftp)
 * @return true if valid false if not a valid url
 * @param url $url
 */
function csv2post_validate_url($url){
	if (!preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i',$url)){
            return false;
	} else {
            return true;
	}
}

/**
 * Checks if value is valid a url (http https ftp)
 * 1. Does not check if url is active (not broken)
 * 
 * @return true if valid false if not a valid url
 * @param url $url
 */
function csv2post_is_url($url){
    if (!preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i',$url)){
            return false;
    } else {
            return true;
    }
}

/**
 * Checks if a database table exist
 * @param string $table_name (possible database table name)
 *
 * @todo SHOW TABLES can cause problems, invistagate another approach such as querying the table, ignoring the error if it does not exist
 */
function csv2post_database_table_exist( $table_name ){
	global $wpdb;
	
	// check if table name exists in wordpress database
	if( $wpdb->get_var("SHOW TABLES LIKE `".$table_name."`") != $table_name) {
            return false;
	}else{
            return true;
	}
}

/**
 * Generates a username using a single value by incrementing an appended number until a none used value is found
 * @param string $username_base
 * @return string username, should only fail if the value passed to the function causes so
 * 
 * @todo log entry functions need to be added, store the string, resulting username
 */
function csv2post_create_username($username_base){
    $attempt = 0;
    $limit = 500;// maximum trys - would we ever get so many of the same username with appended number incremented?
    $exists = true;// we need to change this to false before we can return a value

    // clean the string
    $username_base = preg_replace('/([^@]*).*/', '$1', $username_base );

    // ensure giving string does not already exist as a username else we can just use it
    $exists = username_exists( $username_base );
    if( $exists == false ){
        return $username_base;
    }else{
        // if $suitable is true then the username already exists, increment it until we find a suitable one
        while( $exists != false ){
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
        if ( $exists == false ) {
            return $username;
        }
    }
}


/**
 * Includes PEAR CSV
 */
function csv2post_pearcsv_include(){
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'){
        ini_set('include_path',rtrim(ini_get('include_path'),';').';'.dirname(__FILE__).'/pear/');
    }else{
        ini_set('include_path',rtrim(ini_get('include_path'),':').':'.dirname(__FILE__).'/pear/');
    }
    require_once 'File/CSV.php';
}

/**
 * Checks if the giving history file (by label not filename) is active
 * @return false
 * @deprecated 16th October 2012 by Zara Walsh (log related functions now in wtgcore_reports.php and this function is not required)
 */
function csv2post_ishistory_active($historyfile = false){
    return false;
}

/**
 * Returns the current url as viewed with all variables etc
 * @return string current url with all GET variables
 */
function csv2post_currenturl() {
    $pageURL = 'http';
    if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
    
        $pageURL .= "://";
        
    if (isset($_SERVER["SERVER_PORT"]) && $_SERVER["SERVER_PORT"] != "80" && isset($_SERVER["SERVER_NAME"]) && isset($_SERVER["REQUEST_URI"])) {

        $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];

    }elseif(isset($_SERVER["SERVER_NAME"]) && isset($_SERVER["REQUEST_URI"])){
        
        $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        
    }else{
        
        return 'Error Unexpected State In Current URL Function';
        
    }
    return $pageURL;
}                        

/**
* Checks if a domain exists by ensuring a site is online
* 
* @return boolean, false if domain does not exist or site is not online, true otherwise
* 
* @param string $domain
*/
function csv2post_domain_online($domain){
    // @todo look into these 2 lines, benefits they have when used in Wordpress if any
   //ini_set("default_socket_timeout","05");
   //set_time_limit(5);
   $f = @fopen($domain,"r");
   if($f == false){
       return false;
   }else{
       $r=fread($f,1000);
       fclose($f);
       if(strlen($r)>1) {
           return true;
       }
       else {
           return false;
       }      
   }  
}

/**
* Returns a value for Tab Number, if $_GET[WTG_##_ABB . 'tabnumber'] not set returns 0 
*/
function csv2post_get_tabnumber(){                      
    if(!isset($_GET['csv2posttabnumber'])){
        return 0;
    }else{
        return $_GET['csv2posttabnumber'];                   
    }                                                      
}     

/**
* Called when plugin is being activated in Wordpress.
* I am avoiding anything actually being installed during this process. * 
*/
function csv2post_register_activation_hook(){
    global $csv2post_isbeingactivated;
    $csv2post_isbeingactivated = true;// used to avoid loading files not required during activation (minimise errors during activation related to none activation related)
}

/**
* Wrapper, uses csv2post_link_toadmin to create local admin url
* 
* @param mixed $page
* @param mixed $values 
*/
function csv2post_create_adminurl($page,$values = ''){
    return csv2post_link_toadmin($page,$values);    
}

/**
* Returns the admin theme 
*/
function csv2post_get_theme(){
    return get_option(WTG_C2P_ABB.'theme');
}

/**
* Update admin theme
* 
* @param mixed $theme_name
*/
function csv2post_update_theme($theme_name){
    update_option(WTG_C2P_ABB.'theme',$theme_name);  
}

 /**
 * Delets plugin main navigation 
 */
function csv2post_delete_tabmenu(){
    return delete_option(WTG_C2P_ABB . 'tabmenu');
}
                  
/**
 * Template used to create new functions, uses utility functions and common globals etc
 * Copy and paste this function
 */
function csv2post_templatefunction(){

    // standard option update with standard result output - only if your updating option else remove
    csv2post_option_array_update( $option_key, $option_value, $line = __LINE__, $file = __FILE__, $function = __FUNCTION__ );

    // general result
    if($function_result_success){
        return true;
    }else{
        return false;
    }
}

/**
 * Displays a simple and standard wordpress formatted message, this is not the WTG Notice Boxes function
 * Should only be used in processing functions, not header functions i.e. hooks
 */
function csv2post_mes($title,$content,$type,$button_array = false){
    // only output anything if user logged and is on admin page
    if(is_user_logged_in() && is_admin()){
        // does user want buttons for actions in footer of the notice? this will add a table of buttons to end of notice
        if($button_array){
                $content .= csv2post_form_buttons_table_return($button_array);}

        // build final notice (only if admin logged in)
        if($type==0){$id='message';$class='updated';}elseif($type==1){$id='error';$class='$error';}
        echo '<div id="'.$id.'" class="'.$class.'"><strong>'.$title.'</strong><p>'. $content .'</p></div>';
    }
}

/**
 * Updates option array, records history to aid debugging
 * @return true on success or false on failure
 * @param string $option_key (wordpress options table key value)
 * @param mixed $option_value (can be string or array)
 * @param integer $line (line number passed by __LINE__)
 * @param string $file (file name passed by __FILE__)
 * @param string $function (function name passed by __FUNCTION__)
 * 
 * @todo check if including the php constants in the attributes applyes where this function is or where it is used
 * @todo what is the best way to determine if update actually failed or there was no difference in array ?
 * @todo complete logging (no output that will be handled where function called)
 */
function csv2post_option_array_update( $option_key, $option_value, $line = __LINE__, $file = __FILE__, $function = __FUNCTION__ ){
    // store an array of values indicating the update time and where it occured
    $change = array();
    $change['date'] = date("Y-m-d H:i:s");
    $change['time'] = time();
    $change['line'] = $line;
    $change['file'] = $file;

    $option_value['arrayhistory'] = $change;

    $option_update_result = update_option($option_key,$option_value);

    if($option_update_result){
            // log result
    }else{
            // log result
    }

    return $change;
}

/**
 * Exit on error or use misconfiguration but offer help information, links etc
 * The information will be based on keywords related to the area of the plugin that the user is experiencing problems with
 * @param array $keywords (an array of keywords that will be used to determine extra help content)
 * @param url $url (link from a big button to the related page for the feature the exit is used in connection with)
 * 
 * @todo display notice box that will hold the help button
 * @todo design or have designed a suitable help button
 * @todo display further possible help options crawled on the plugins site
 * @todo display Google AdWords search lastly
 */
function csv2post_exit($url,$keywords){
    // call a function here that displays a notice box of helpful information including links and a humerous image
    // in relation to any sort of problem

    // we'll use the keywords to retrieve the information using RSS or API, not 100% sure at this time
    exit;
}

        
/**
* Returns the plugins standard date (MySQL Date Time Formatted) with common format used in Wordpress.
* Optional $time parameter, if false will return the current time().
* 
* @param integer $timeaddition, number of seconds to add to the current time to create a future date and time
* @param integer $time optional parameter, by default causes current time() to be used
* @todo adapt this to return various date formats to suit interface
*/
function csv2post_date($timeaddition = 0,$time = false){
    $thetime = time();
    if($time != false){$thetime = $time;}
    return date('Y-m-d H:i:s',$thetime + $timeaddition);    
} 

/**
* Determines if giving varaible is WP_Error or not
* Logs error if boolean true result determined
* 
* @uses class WP_Error($code, $message, $data)
* @uses is_wp_error(),$wpval->get_error_data(),$wpval->get_error_message() 
* @param mixed $v is the value being checked as possible Wordpress error
* @param boolean $returnv, default is false, true causes $v to be returned instead of boolean when value is NOT an error
* @returns boolean true if giving value is WP_Error and false if not
*/
function csv2post_is_WP_Error($wpval,$returnv = false){
    if(is_wp_error($wpval)){

        $atts = array();
        $atts['projectname'] = 'NA';// TODO:LOWPRIORITY, get current project name from global
        //$atts['date'] = csv2post_date();// csv2post_date()   
        $atts['logtype'] = 'error';
        $atts['dump'] = 'Data Value: ' . $wpval->get_error_data();
        $atts['comment'] = 'Created by csv2post_is_WP_Error, Wordpress message is: ' . $wpval->get_error_message();
        $atts['style'] = 'error';

        csv2post_log($atts);  
        
        $result = true;   
    }else{
        $result = false;
    }

    if($result == false && $returnv == true){
        // not an error and value to be returned
        return $wpval;
    } elseif($result == true){
        // is an error or request needs boolean returned
        return true;
    }elseif($result == false && $returnv == false){
        // not an error but request wants boolean returned, false to indicate not WP_Error
        return false;
    }
}

/**
* Uses error_log to record an error to servers main error log.
*  
* @param string $m, the message to be recorded
*/
function csv2post_error_log($m){ 
   error_log($m);
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
* @link http://www.csv2post.com/hacking/project-array-csv2post_project_array
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
* Use to start a new array.
* 1. Adds our standard ['arrayinfo'] which helps us to determine how much an array has changed since being created
* 2. Adds description also
* 
* @uses csv2post_ARRAY_arrayinfo_set()
* @param mixed $description use to explain what array is used for
* @param mixed $line __LINE__
* @param mixed $function __FUNCTION__
* @param mixed $file __FILE__
* @param mixed $reason use to explain why the array was updated (rather than what the array is used for)
* @return string
*/
function csv2post_ARRAY_init($description,$line,$function,$file,$reason,$result_array = false){
    global $csv2post_currentversion;
    $array = array();
    $array['arrayinfo'] = csv2post_ARRAY_arrayinfo_set($line,$function,$file,$reason,$csv2post_currentversion);
    $array['arrayinfo']['description'] = $description;
    
    if($result_array){
        // array is being used for a result_array meaning it has a short life, is not stored unless for debugging and the returned array values are used to build a report
        $array['outcome'] = true;// boolean
        $array['failreason'] = false;// string - our own typed reason for the failure
        $array['error'] = false;// string - add php mysql wordpress error 
        $array['parameters'] = array();// an array of the parameters passed to the function using result_array, really only required if there is a fault
        $array['result'] = array();// the result values, if result is too large not needed do not use
    }
    return $array;
}

/**
* Get arrays next key (only works with numeric key)
*/
function csv2post_get_array_nextkey($array){
    if(!is_array($array)){
        ### TODO:CRITICAL,log this issue so we know when a none array value is giving
        return 1;   
    }
    
    ksort($array);
    end($array);
    return key($array) + 1;
} 

/**
* Gets the schedule array from wordpress option table.
* Array [times] holds permitted days and hours.
* Array [limits] holds the maximum post creation numbers 
*/
function csv2post_get_option_schedule_array(){
    $csv2post_schedule_array = get_option( 'csv2post_schedule');
    return maybe_unserialize($csv2post_schedule_array);    
}

/**
* Updates the schedule array from wordpress option table.
* Array [times] holds permitted days and hours.
* Array [limits] holds the maximum post creation numbers 
*/
function csv2post_update_option_schedule_array($schedule_array){
    $schedule_array_serialized = maybe_serialize($schedule_array);
    return update_option('csv2post_schedule',$schedule_array_serialized);    
}

/**
* Updates notifications array in Wordpress options table
* 
* @param array $notifications_array
* @return bool
*/
function csv2post_update_option_persistentnotifications_array($notifications_array){
    return update_option('csv2post_notifications',maybe_serialize($notifications_array));    
}

function csv2post_update_option_adminsettings($csv2post_adm_set){
    $admin_settings_array_serialized = maybe_serialize($csv2post_adm_set);
    return update_option('csv2post_adminset',$admin_settings_array_serialized);    
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
function csv2post_save_dataimportjob($jobarray,$code){            
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
* Uses csv2post_save_dataimportjob which uses update_option and serialize on the $jobarray
* 
* @param mixed $jobarray
* @param mixed $code
* @return boolean,
* @todo rename function to csv2post_update_option_dataimportjob() and replace then remove csv2post_save_dataimportjob($jobarray,$code)
*/
function csv2post_update_dataimportjob($jobarray,$code){
    return csv2post_save_dataimportjob($jobarray,$code);
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

# truncate string to a specific length

/**
* truncate string to a specific length 
* 
* @param string $string, string to be shortened if too long
* @param integer $max_length, maximum length the string is allowed to be
* @return string, possibly shortened if longer than
*/
function csv2post_truncatestring( $string, $max_length ){
    if (strlen($string) > $max_length) {
        $split = preg_split("/\n/", wordwrap($string, $max_length));
        return ($split[0]);
    }
    return ( $string );
}

/**
* Checks if DOING_AJAX is set, indicating header is loaded for ajax request only
* @link http://www.csv2post.com/troubleshooting-tips/no-scheduled-events-during-ajax-requests
* @return boolean true if Ajax request ongoing else false        
*/
function csv2post_DOING_AJAX(){
    if(defined('DOING_AJAX')){
        return true;
    }
    return false;    
}

/**
* Uses fget, not PEAR CSV, to get header row of csv file and count number of fields/columns
* @return int
*/
function csv2post_establish_csvfile_fieldnumber($csvfile_name,$separator){
     // get the header row
    if (($handle = fopen(WTG_C2P_CONTENTFOLDER_DIR . '/' . $csvfile_name, "r")) !== FALSE) {

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
            csv2post_notice('Failed to locate the option table record for data import job named '.$job['name'].'. Is it possible the record was deleted manually?','error','Tiny','','','echo');
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
* Determines if the giving value is a CSV 2 POST page or not
*/
function csv2post_is_plugin_page($page){
    
    // we have two approaches to use. We could loop through page array and check slug values.
    // instead we will just check for "csv2post" within the string, that should be suitable and faster
    return strstr($page,'csv2post');  
}

/**
* Stores _apiauthmethod in Wordpress options table using update_option   (uses update_option not add_option)         
*/
function csv2post_add_is_emailauthorised($authmethod){
    return update_option(WTG_C2P_ABB.'isemailauthorised',$authmethod);          
}

/**
* Returns result from get_option(_apiauthmethod)
* 
* @todo MEDIUMPRIORITY, add these option records to the options array as none public option records
*/
function csv2post_get_is_emailauthorised(){
    return get_option(WTG_C2P_ABB.'isemailauthorised');   
}

/**
* Returns result from get_option(_activationkey)
*/
function csv2post_get_activationcode(){
    return get_option(WTG_C2P_ABB.'activationcode');   
}

/**
* Updates activation code
* @todo MEDIUMPRIORITY, add these option records to the options array as none public option records
*/
function csv2post_update_activationcode($activationcode){
    return update_option(WTG_C2P_ABB.'activationcode',$activationcode);  
}

/**
* Adds activation code (uses update_option not add_option)
*/
function csv2post_add_activationcode($activationcode){
    return update_option(WTG_C2P_ABB.'activationcode',$activationcode);  
}  

/**
* Loads scripts
* 
* @param string $side, admin, public
* @param mixed $csv2post_script_side_override, makes use of admin lines in front-end of blog 
* 
* @todo LOWPRIORITY, do we really need to have the csv2post_script_parent.php file? I think we can put its contents in this function
*/
function csv2post_script($side = 'admin',$csv2post_script_side_override = false){
    global $csv2post_mpt_arr;### TODO: LOWPRIORITY, is this variable used in this function/files included in function?
    include_once(WTG_C2P_DIR.'script/csv2post_script_parent.php');
}

/**
* Loads CSS
* 
* @param string $side, admin, public
* @param mixed $csv2post_css_side_override, makes use of admin lines in front-end of blog
* 
* Do csv2post_css('admin',true); to run the admin lines but also trigger use of them on public side
* Do csv2post_css('public',true); to use both public and admin lines, must ensure there is no double uses
* 
* @todo LOWPRIORITY, do we really need to have the csv2post_css_parent.php file? I think we can put its contents in this function
*/
function csv2post_css($side = 'admin',$csv2post_css_side_override = false){        
    include_once(WTG_C2P_DIR.'css/csv2post_css_parent.php');
}
    
/**
 * jQuery script for styling button with roll over effect
 * @see function csv2post_header_page()
 * 
 * @todo rename this function to csv2post_JQUERY_javascript_button() and move it to applicable file which also needs to be created
 */
function csv2post_jquery_button(){?>
    <script>
        $(function() {
            $( "button, input:submit, a", ".jquerybutton" ).button();
            $( "a", ".jquerybutton" ).click(function() { return false; });
        });
    </script><?php
}

/**
 * Adds <button> with jquerybutton class and </form>, for using after a function that outputs a form
 * Add all parameteres or add none for defaults
 * @param string $buttontitle
 * @param string $buttonid
 */
function csv2post_formend_standard($buttontitle = 'Submit',$buttonid = 'notrequired'){
    global $csv2post_guitheme;
        
        if($buttonid == 'notrequired'){
            $buttonid = 'csv2post_notrequired'.rand(1000,1000000);# added during debug
        }else{
            $buttonid = $buttonid.'_formbutton';
        }?>

        <br />
        
        <?php if($csv2post_guitheme == 'jquery'){?>
        
            <div class="jquerybutton">
                <button id="<?php echo $buttonid;?>"><?php echo $buttontitle;?></button>
            </div>
            
        <?php }else{ ?>

            <input type="submit" name="csv2post_wpsubmit" id="<?php echo $buttonid;?>" class="button button-primary" value="<?php echo $buttontitle;?>">
            
        <?php }?>
        
    </form><?php
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
 * Adds a jquery effect submit button, for using in form
 * 
 * @param string $panel_name (original use for in panels,panel name acts as an identifier)
 * @uses csvip_helpbutton function uses jquery script required by this button to have any jquery effect
 */
function csv2post_formsubmitbutton_jquery($form_name){?>
    <div class="jquerybutton">
        <input type="submit" name="<?php echo WTG_C2P_ABB;?><?php echo $form_name;?>_submit" value="Submit"/>
    </div><?php
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

/**
 * Echos the html beginning of a form and beginning of widefat post fixed table
 * 
 * @param string $name (a unique value to identify the form)
 * @param string $method (optional, default is post, post or get)
 * @param string $action (optional, default is null for self submission - can give url)
 * @param string $enctype (pass enctype="multipart/form-data" to create a file upload form)
 */
function csv2post_formstart_standard($name,$id = 'none', $method = 'post',$class,$action = '',$enctype = ''){
    if($class){
        $class = 'class="'.$class.'"';
    }else{
        $class = '';         
    }
    echo '<form '.$class.' '.$enctype.' id="'.$id.'" method="'.$method.'" name="'.$name.'" action="'.$action.'">
    <input type="hidden" id="csv2post_post_processing_required" name="csv2post_post_processing_required" value="true">';
}
    
?>