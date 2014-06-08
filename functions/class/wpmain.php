<?php  
/** 
* The core WTG plugin class and other main class functions for CSV 2 POST Wordpress plugin 
* 
* @package CSV 2 POST
* 
* @since 8.0.0
* 
* @author Ryan Bayne 
*/

/** 
* Main class - add methods that will likely be used in all WTG plugins, use wpmain.php for those specific to the build
* 
* @since 8.0.0
* 
* @author Ryan Bayne 
*/                                                 
class CSV2POST {
    protected
        $filters = array(),
        $actions = array(),    
       
        // Format: array( event | function in this class(in an array if optional arguments are needed) | loading circumstances)
        // Other class requiring Wordpress hooks start here also, with a method in this main class that calls one or more methods in one or many classes
        // create a method in this class for each hook required plugin wide
        $plugin_actions = array( 
            array('admin_menu',                     'admin_menu',                                             'all'),
            array('admin_init',                     'process_POST_GET',                                       'all'), 
            array('wp_dashboard_setup',             'add_dashboard_widgets',                                  'all'),
            array('wp_insert_post',                 'hook_insert_post',                                       'all'),
            array('admin_head',                     'custom_admin_css',                                       'all'),
            array('admin_footer',                   'pluginmediabutton_popup',                                'adminpages'),
            array('media_buttons_context',          'pluginmediabutton_button',                               'adminpages'),            
            //array('set-screen-option',              array('save_screen_option',10,3),                         'all'),
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
        
    /**
    * This class is being introduced gradually, we will move various lines and config functions from the main file to load here eventually
    */
    public function __construct() {
        // straight away we need to indicate if phpBB is loaded or not
        $this->_loaded = false;
        if(defined('IN_PHPBB')) { 
            $this->_loaded = true;
        }
    }
    /**
     * if CSV 2 POST already initialised returns true
     * @return bool true if already inited
     */
    public function has_inited() {
        return $this->doneInit;
    }   
    /**
     * Initialises the plugin from WordPress
     * @return void
     */
    public function wp_init() {
        if($this->has_inited()) {
            return false;
        }
        $this->doneInit = true;
        $this->add_actions();
        $this->add_filters();
        unset($this->plugin_actions, $this->plugin_filters);
    }
    protected function add_actions() {          
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
    protected function add_filters() {
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
    private function filteraction_should_beloaded($whenToLoad) {
        global $c2p_sections_array;
       
        switch($whenToLoad) {
            case 'all':    
                return true;
            break;
            case 'projects':
                return true;    
            break;
            case 'adminpages':
                if(is_admin()){return true;}
                return false;    
            break;            
        }

        return true;
    }      
    /**
    * When request will display maximum php errors including Wordpress errors 
    */
    public function debugmode(){
        global $c2p_debug_mode;
        if($c2p_debug_mode){
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
    function custom_admin_css() {
        echo '<style type="text/css">';
        echo '.column-c2pbanner { width:40% }';
        echo '</style>';
    }    
    /**
    * if any class needs to use the wp_insert_post hook simply add a method to this method 
    */
    public function hook_insert_post($post_id){
        /*
        // establish correct procedure for the post type that was inserted
        $post_type = get_post_type($post_id);
      
        switch ($post_type) {
            case 'exampleone':
                
                break;
            case 'c2pnotinuseyet':
                
                break;
        } 
        */
    }
    /**
    * Gets option value for csv2post _adminset or defaults to the file version of the array if option returns invalid.
    * 1. Called in the main csv2post.php file.
    * 2. Installs the admin settings option record if it is currently missing due to the settings being required by all screens, this is to begin applying and configuring settings straighta away for a per user experience 
    */
    public function adminsettings(){
        $result = $this->option('csv2post_settings','get');
        $result = maybe_unserialize($result); 
        if(is_array($result)){
            return $result; 
        }else{     
            return $this->install_admin_settings();
        }  
    }
    /**
    * Control Wordpress option functions using this single function.
    * This function will give us the opportunity to easily log changes and some others ideas we have.
    * 
    * @param mixed $option
    * @param mixed $action add, get, wtgget (own query function) update, delete
    * @param mixed $value
    * @param mixed $autoload used by add_option only
    */
    public function option($option,$action,$value = 'No Value',$autoload = 'yes'){
        if($action == 'add'){  
            return add_option($option,$value,'',$autoload);            
        }elseif($action == 'get'){
            return get_option($option);    
        }elseif($action == 'update'){        
            return update_option($option,$value);
        }elseif($action == 'delete'){
            return delete_option($option);        
        }
    }                  
    /**
     * Add a widget to the dashboard.
     *
     * This function is hooked into the 'wp_dashboard_setup' action below.
     */
    public function add_dashboard_widgets() {
        global $c2p_settings;
        /*  example widget  
        // affiliates section
        if(isset($c2p_settings['affiliatessection']['dashboardwidget']['switch']) && $c2p_settings['affiliatessection']['dashboardwidget']['switch'] == 'enabled')
        {
            wp_add_dashboard_widget(
                 'affiliatessectiondashboard',// Widget slug.
                 __('Affiliates Section','csv2post'),// Title.
                 array($this,'affiliates_dashboard_widget')// Display function.
            ); 
        }      
          */              
    }
    /**
    * Popup and content for media button displayed just above the WYSIWYG editor 
    */
    public function pluginmediabutton_popup() {
        global $c2p_settings,$C2P_WP;
        ?>
        <div id="csv2post_popup_container" style="display:none;">
            <h2>Column Replacement Tokens</h2>
            <?php 
            if(!isset($c2p_settings['currentproject']) || !is_numeric($c2p_settings['currentproject'])){
                echo '<p>' . __('') . '</p>';
            }else{
                $projectcolumns = $C2P_WP->get_project_columns_from_db($c2p_settings['currentproject'],true);
                unset($projectcolumns['arrayinfo']);
                   
                $tokens = '';
                foreach($projectcolumns as $table_name => $columnfromdb){
                    foreach($columnfromdb as $key => $acol){
                        $tokens .= "#$acol#&#13;&#10;";
                    }  
                }     
                
                echo '<textarea rows="40" cols="70">' . $tokens . ' </textarea>';
            }
            ?>
        </div><?php
    } 
    /**
    * HTML for a media button that displays above the WYSIWYG editor
    * 
    * @param mixed $context
    */
    public function pluginmediabutton_button($context) {
        //append the icon
        $context .= "<a class='button thickbox' title='CSV 2 POST Column Replacement Tokens (CTRL + C then CTRL + V)'
        href='#TB_inline?width=400&inlineId=csv2post_popup_container'>CSV 2 POST</a>";
        return $context;
    }                 
    public function is_installed(){
        global $c2p_options_array;
           
        if(!isset($c2p_options_array) || !is_array($c2p_options_array)){
            return false;
        }
                 
        // currently this value is returned, if changed to false
        $returnresult = true;
        $failcause = 'Not Known';// only used for debugging to determine what causes indication of not fully installed
        
        // function only returns boolean but if required we will add results array to the log
        $is_installed_result = array();
        $is_installed_result['finalresult'] = false;
        $is_installed_result['options'] = null;
                    
        foreach($c2p_options_array as $id => $optionrecord){
                
            if($optionrecord['required'] == true){
                        
                $currentresult = get_option($id);    
                
                $is_installed_result['options'][$id]['result'] = $currentresult;
                            
                // change return switch to false if option not found
                if($currentresult == false || $currentresult == null){ 
                  
                    $returnresult = false;
                    $failcause = __('Option RecordMissing:','csv2post') . $id;    
                }
            } 
        }                       
          
        return $returnresult;        
    }           
    /**
    * $_POST and $_GET request processing procedure.
    * 
    * Checks nonce from any form or URL, then includes functions that processing submission, then includes the
    * file that determines which function to use to process the submission.
    *
    * @package CSV 2 POST
    * @since 8.0.0  
    */
    public function process_POST_GET(){  
        global $C2P_WP,$C2P_REQ;
             
        if(!isset($_POST['csv2post_post_requested']) && !isset($_GET['c2pprocess']))
        {
            return;
        }          
               
        // $_POST request
        if(isset($_POST['csv2post_post_requested']) && $_POST['csv2post_post_requested'] == true){        
            if(isset($_POST['csv2post_admin_referer'])){        
                // a few forms have the csv2post_admin_referer where the default hidden values are not in use
                check_admin_referer( $_POST['csv2post_admin_referer'] ); 
                $function_name = $_POST['c2pprocess'];        
            }else{                                       
                // 99% of forms will use this method
                check_admin_referer( $_POST['csv2post_form_name'] );
                $function_name = $_POST['csv2post_form_name'];
            }        
        }
                          
        // $_GET request
        if(isset($_GET['c2pprocess'])){      
            check_admin_referer( $_GET['c2pprocess'] );        
            $function_name = $_GET['c2pprocess'];
        }     
                   
        // arriving here means check_admin_referer() security is positive       
        global $c2p_debug_mode,$cont,$c2p_is_free;

        $C2P_WP->var_dump($_POST,'<h1>$_POST</h1>');           
        $C2P_WP->var_dump($_GET,'<h1>$_GET</h1>');    
        
        // include the class that processes form submissions and nonce links
        require_once(WTG_CSV2POST_PATH . 'functions/class/requests.php');
        $C2P_REQ = new C2P_requests();
        
        // ensure class and method exist
        if(!method_exists('C2P_requests', $function_name))
        {
            wp_die(sprintf(__("The method for processing your request was not found. This can usually be resolved
            quickly. Please report method %s does not exist. <a href='https://www.youtube.com/watch?v=vAImGQJdO_k' target='_blank'>Watch a video</a> explaining this problem.",'csv2post'),$function_name));    
        }
        
        if(isset($function_name) && is_string($function_name))
        {
            eval('$C2P_REQ->' . $function_name .'();');
        }
    }                           
                    
    // Wordpress admin page callbacks
    static function page_toppage(){require_once( WTG_CSV2POST_PATH . 'views/main/main.php' );}

    public function screen_options() {
        global $pippin_sample_page,$C2P_UI,$C2P_WP;
        $screen = get_current_screen();

        // toplevel_page_csv2post (main page)
        if($screen->id == 'toplevel_page_csv2post'){
            $args = array(
                'label' => __('Members per page', 'pippin'),
                'default' => 1,
                'option' => 'csv2post_testoption'
            );
            add_screen_option( 'per_page', $args );
        }     
    }

    public function save_screen_option($status, $option, $value) {
        if ( 'csv2post_testoption' == $option ) return $value;
    }
      
    /**
    * if help content added to menu array it will be displayed in Wordress own help tab 
    */
    public function help_tab () {
        global $my_admin_page,$c2p_sections_array,$c2p_mpt_arr,$CSV2POST,$C2P_WP;
        $screen = get_current_screen();

        // establish section slug, it is contained within Wordpress screen id
        // example screen ID: csv-2-post_page_csv2post_affiliates and would return affiliates
        $tabname = $C2P_WP->get_string_after_last_character($screen->id,'_');
        
        // if main the $tabname will be csv2post so we will change $tabname to main as that is what is used in the menus array
        if($tabname == 'csv2post'){$tabname = 'main';}
           
        // loop through the sections screens ['tabs']
        foreach($c2p_mpt_arr[$tabname]['tabs'] as $tabnumber => $tabarray){
                                               
            // does the tab screen have any help?
            if(isset($tabarray['help'])){                                     
              
                $help_content = '';
                foreach($tabarray['help'] as $help_entry){
                    
                    $help_content .= '<p>';
                    
                    if(!empty($help_entry[0]) && $help_entry[0] !== false && !empty($help_entry[1])){
                        $help_content .= '<strong>' . $help_entry[0] . '</strong> - ';
                    }elseif(!empty($help_entry[0]) && $help_entry[0] !== false && empty($help_entry[1])){
                        $help_content .= '<h3>' . $help_entry[0] . '</h3>';
                    }
                    
                    $help_content .= $help_entry[1];
                    
                    // add read more link
                    if(isset($help_entry[2]) && $help_entry[2] !== false){
                        $help_content .= ' <a href="'.$help_entry[2].'" target="_blank">Read More</a>';
                    }

                    $help_content .= '</p>';
                    
                    if(isset($help_entry[3]) && $help_entry[3] !== false){
                        $help_content .= '<iframe width="80%" height="80%" src="//www.youtube.com/embed/'.$help_entry[3].'" frameborder="0" allowfullscreen></iframe>';
                    }                    
                }
   
                // Add my_help_tab if current screen is My Admin Page
                $screen->add_help_tab( array(
                    'id'    => $c2p_mpt_arr[$tabname]['tabs'][$tabnumber]['slug'],
                    'title'    => $c2p_mpt_arr[$tabname]['tabs'][$tabnumber]['label'],
                    'content'    => $help_content,
                ) );
            }
        }
    }  
      
    public function admin_menu(){ 
        global $CSV2POST,$c2p_currentversion,$c2p_mpt_arr,$c2p_is_installed,$c2p_is_free,$C2P_WP,$c2p_is_beta,$C2P_UI,$c2p_settings,$c2p_is_dev;
                                   
        $n = 'csv2post';

        // if file version is newer than install we display the main page only but re-label it as an update screen
        // the main page itself will also change to offer plugin update details. This approach prevent the problem with 
        // visiting a page without permission between installation
        $installed_version = $C2P_WP->get_installed_version();                
            
        // installation is not done on activation, we display an installation screen if not fully installed
        if(!$c2p_is_installed && !isset($_POST['csv2post_plugin_install_now'])){   
           
            // if URL user is attempting to visit any screen other than page=csv2post then redirect to it
            if(isset($_GET['page']) && strstr($_GET['page'],'csv2post_')){
                wp_redirect( get_bloginfo('url') . '/wp-admin/admin.php?page=csv2post' );           
                exit;    
            }
            
            // if plugin not installed
            add_menu_page(__('Install',$n.'install'), __('CSV 2 POST 8.0.0. Install','home'), 'administrator', 'csv2post', array($this,'page_toppage') );
            
        }elseif(isset($c2p_currentversion) 
        && isset($installed_version) 
        && $installed_version != false
        && $c2p_currentversion > $installed_version){
            
            // if URL user is attempting to visit any screen other than page=csv2post then redirect to it
            if(isset($_GET['page']) && strstr($_GET['page'],'csv2post_')){
                wp_redirect( get_bloginfo('url') . '/wp-admin/admin.php?page=csv2post' );
                exit;    
            }
                    
            // if $installed_version = false it indicates no installation so we should not be displaying an update screen
            // update screen will be displayed after installation submission if this is not in place
            
            // main is always set in menu, even in extensions main must exist
            add_menu_page(__('Update',$n.'update'), __('CSV 2 POST 8.0.0 Update','home'), 'administrator', 'csv2post',  array($this,'page_toppage') );
            
        }else{

            // main is always set in menu, even in extensions main must exist
            add_management_page($c2p_mpt_arr['main']['title'], $c2p_mpt_arr['main']['menu'], $C2P_WP->get_page_capability('main'), $n,  array($this,'page_toppage') ); 

            // help tab                                                 
            add_action('load-toplevel_page_csv2post', array($this,'help_tab') );
        }
    }
    /**
    * Used in admin page headers to constantly check the plugins status while administrator logged in 
    */
    public function diagnostics_constant(){
        global $C2P_WP;
        if(is_admin() && current_user_can( 'manage_options' )){
            
            // avoid diagnostic if a $_POST, $_GET or Ajax request made (it is installation state diagnostic but active debugging)                                          
            if($C2P_WP->request_made()){
                return;
            }
                                 
            ###########################################################################################
            #                                PEFORM CORE DIAGNOSTICS                                  #
            ###########################################################################################                    
            // core database tables
            global $c2p_tables_array;# core tables
        }
    }
    /**
    * Uses database table arrays to check if any installed tables have not been updated yet 
    * 
    * @todo I have deleted everything in this function, a new approach using later methods is required 
    */
    public function diagnostics_databasecomparison_alertonly($expected_tables_array){

    } 
    /**
    * DO NOT CALL DURING FULL PLUGIN INSTALL
    * This function uses update. Do not call it during full install because user may be re-installing but
    * wishing to keep some existing option records.
    * 
    * Use this function when installing admin settings during use of the plugin. 
    */
    public function install_admin_settings(){
        require_once(WTG_CSV2POST_PATH . 'arrays/settings_array.php');
        return $this->option('csv2post_settings','update',$c2p_settings);# update creates record if it does not exist   
    }
    /**
    * returns tab menu array
    */
    public function tabmenu(){
        require_once(WTG_CSV2POST_PATH . 'views/menu_array.php');
        return $c2p_mpt_arr;                    
    }   
    public function custom_post_types(){ 
    }
 
    /**
    * Admin Triggered Automation
    */
    public function admin_triggered_automation(){
        global $C2P_WP;
        // clear out log table (48 hour log)
        $C2P_WP->log_cleanup();
    }

    /**
    * Returns array holding the headers of the giving filename
    * It also prepares the array to hold other formats of the column headers in prepartion for the plugins various uses
    */
    public function get_headers_formatted($filename,$separator = ',',$quote = '"',$fields = 0){
        global $C2P_WP;
        
        $header_array = array();
        
        // read and loop through the first row in the csv file  
        $handle = fopen($filename, "r");
        while (($row = fgetcsv($handle, 10000, $separator,$quote)) !== FALSE) {
       
            for ( $i = 0; $i < $fields; $i++ ){
                $header_array[$i]['original'] = $row[$i];
                $header_array[$i]['sql'] = $C2P_WP->clean_sqlcolumnname($row[$i]);// none adapted/original sql version of headers, could have duplicates with multi-file jobs             
            }           
            break;
        }
                            
        return $header_array;    
    }

    /**
    * Counts separator characters per row, compares total over all rows counted to determine probably Separator
    * 
    * @param mixed $filename
    * @param mixed $output
    */
    public function established_separator($filename){
        global $C2P_WP;
        $probable_separator = ','; 
        if (($handle = fopen($filename, "r")) !== FALSE) {

            // count Separators
            $comma_count = 0;
            $pipe_count = 0;
            $semicolon_count = 0;
            $colon_count = 0;          

            // one row at a time we will count each possible Separator
            while (($rowstring = fgets($handle, 4096)) !== false) {
                
                $comma_count = $comma_count + substr_count ( $rowstring , ',' );
                $pipe_count = $pipe_count + substr_count ( $rowstring , '|' );                    
                $semicolon_count = $semicolon_count + substr_count ( $rowstring , ';' );
                $colon_count = $colon_count + substr_count ( $rowstring , ':' ); 
                            
            }  
            
            if (!feof($handle)) {
                wp_die('Please take a screenshot of this message. The PHP function feof() returned false for
                some reason and I would really like to know about it.','Something Went Wrong');
            }
            fclose($handle);                

            // compare count results - comma
            if($comma_count > $pipe_count && $comma_count > $semicolon_count && $comma_count > $colon_count)
            {       
                $probable_separator = ',';
            }
            
            // pipe
            if($pipe_count > $comma_count && $pipe_count > $semicolon_count && $pipe_count > $colon_count)
            {        
                $probable_separator = '|';       
            }
            
            // semicolon
            if($semicolon_count > $comma_count && $semicolon_count > $pipe_count && $semicolon_count > $colon_count)
            {    
                $probable_separator = ';';        
            }
            
            // colon
            if($colon_count > $comma_count && $colon_count > $pipe_count && $colon_count > $semicolon_count)
            {
                $probable_separator = ':';      
            }
            
        }// if handle open for giving file
        
        return $probable_separator; 
    } 
    public function insert_data_source($path,$parentfile_id,$tablename,$type = 'localcsv',$csvconfig_array = array()){
        global $C2P_DB,$wpdb;
        return $C2P_DB->insert($wpdb->c2psources,
            array(
                'path' => $path,
                'sourcetype' => $type,
                'parentfileid' => $parentfile_id,
                'tablename' => $tablename,
                'thesep' => $csvconfig_array['sep'],
                'theconfig' => maybe_serialize($csvconfig_array)
            ));
    } 
    public function insert_project($project_name,$sourceid_array){
        global $C2P_DB,$wpdb;
        
        $fields_array = array('projectname' => $project_name);
        
        $fields_array = array_merge($fields_array,$sourceid_array);
                
        return $C2P_DB->insert($wpdb->c2pprojects,$fields_array);
    }
    /**
    * deletes a project in c2pprojects table  
    */
    public function deleteproject($projectid){
        global $C2P_DB,$wpdb;
        return $C2P_DB->delete($wpdb->c2pprojects,"projectid = '$projectid'");    
    }  
    public function query_projects(){
        global $C2P_DB,$wpdb;
        return $C2P_DB->selectwherearray($wpdb->c2pprojects,'projectid = projectid','timestamp','*');
    }
    public function create_project_table($table_name,$columns_array){
        global $wpdb;
 
        $query = "CREATE TABLE `{$table_name}` (
        `c2p_rowid` int(10) unsigned NOT NULL auto_increment,
        `c2p_postid` int(10) unsigned default 0,
        `c2p_use` tinyint(1) unsigned default 1,
        `c2p_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 
        `c2p_applied` datetime NOT NULL,
        `c2p_changecounter` int(8) unsigned default 0, 
        ";                               
            
        // loop through jobs files
        foreach($columns_array as $key => $column){
            $query .= "`" . $key . "` text default NULL,";                                                                                                              
        }
      
        $query .= "PRIMARY KEY  (`c2p_rowid`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Table created by CSV 2 POST';";
        
        $createresult1 = $wpdb->query( $query );
    }
    public function apply_project_defaults($project_id){
        global $c2p_settings,$C2P_WP;
        $C2P_WP->update_project($project_id, array('projectsettings' => maybe_serialize($c2p_settings['projectdefaults'])));
    }  
}// end CSV2POST class 

if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
        
/**
* Lists tickets post type using standard Wordpress list table
*/
class C2P_Log_Table extends WP_List_Table {
    
    /** ************************************************************************
     * REQUIRED. Set up a constructor that references the parent constructor. We 
     * use the parent reference to set some default configs.
     ***************************************************************************/
    function __construct(){
        global $status, $page;
             
        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'movie',     //singular name of the listed records
            'plural'    => 'movies',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );
        
    }
    
    /** ************************************************************************
     * Recommended. This method is called when the parent class can't find a method
     * specifically build for a given column. Generally, it's recommended to include
     * one method for each column you want to render, keeping your package class
     * neat and organized. For example, if the class needs to process a column
     * named 'title', it would first see if a method named $this->column_title() 
     * exists - if it does, that method will be used. If it doesn't, this one will
     * be used. Generally, you should try to use custom column methods as much as 
     * possible. 
     * 
     * Since we have defined a column_title() method later on, this method doesn't
     * need to concern itself with any column with a name of 'title'. Instead, it
     * needs to handle everything else.
     * 
     * For more detailed insight into how columns are handled, take a look at 
     * WP_List_Table::single_row_columns()
     * 
     * @param array $item A singular item (one full row's worth of data)
     * @param array $column_name The name/slug of the column to be processed
     * @return string Text or HTML to be placed inside the column <td>
     **************************************************************************/
    function column_default($item, $column_name){
             
        $attributes = "class=\"$column_name column-$column_name\"";
                
        switch($column_name){
            case 'row_id':
                return $item['row_id'];    
                break;
            case 'timestamp':
                return $item['timestamp'];    
                break;                
            case 'outcome':
                return $item['outcome'];
                break;
            case 'category':
                echo $item['category'];  
                break;
            case 'action':
                echo $item['action'];  
                break;  
            case 'line':
                echo $item['line'];  
                break;                 
            case 'file':
                echo $item['file'];  
                break;                  
            case 'function':
                echo $item['function'];  
                break;                  
            case 'sqlresult':
                echo $item['sqlresult'];  
                break;       
            case 'sqlquery':
                echo $item['sqlquery'];  
                break; 
            case 'sqlerror':
                echo $item['sqlerror'];  
                break;       
            case 'wordpresserror':
                echo $item['wordpresserror'];  
                break;       
            case 'screenshoturl':
                echo $item['screenshoturl'];  
                break;       
            case 'userscomment':
                echo $item['userscomment'];  
                break;  
            case 'page':
                echo $item['page'];  
                break;
            case 'version':
                echo $item['version'];  
                break;
            case 'panelname':
                echo $item['panelname'];  
                break; 
            case 'tabscreenname':
                echo $item['tabscreenname'];  
                break;
            case 'dump':
                echo $item['dump'];  
                break; 
            case 'ipaddress':
                echo $item['ipaddress'];  
                break; 
            case 'userid':
                echo $item['userid'];  
                break; 
            case 'comment':
                echo $item['comment'];  
                break;
            case 'type':
                echo $item['type'];  
                break; 
            case 'priority':
                echo $item['priority'];  
                break;  
            case 'thetrigger':
                echo $item['thetrigger'];  
                break; 
                                        
            default:
                return 'No column function or default setup in switch statement';
        }
    }
                    
    /** ************************************************************************
    * Recommended. This is a custom column method and is responsible for what
    * is rendered in any column with a name/slug of 'title'. Every time the class
    * needs to render a column, it first looks for a method named 
    * column_{$column_title} - if it exists, that method is run. If it doesn't
    * exist, column_default() is called instead.
    * 
    * This example also illustrates how to implement rollover actions. Actions
    * should be an associative array formatted as 'slug'=>'link html' - and you
    * will need to generate the URLs yourself. You could even ensure the links
    * 
    * 
    * @see WP_List_Table::::single_row_columns()
    * @param array $item A singular item (one full row's worth of data)
    * @return string Text to be placed inside the column <td> (movie title only)
    **************************************************************************/
    /*
    function column_title($item){

    } */
    
    /** ************************************************************************
     * REQUIRED! This method dictates the table's columns and titles. This should
     * return an array where the key is the column slug (and class) and the value 
     * is the column's title text. If you need a checkbox for bulk actions, refer
     * to the $columns array below.
     * 
     * The 'cb' column is treated differently than the rest. If including a checkbox
     * column in your table you must create a column_cb() method. If you don't need
     * bulk actions or checkboxes, simply leave the 'cb' entry out of your array.
     * 
     * @see WP_List_Table::::single_row_columns()
     * @return array An associative array containing column information: 'slugs'=>'Visible Titles'
     **************************************************************************/
    function get_columns(){
        $columns = array(
            'row_id' => 'Row ID',
            'timestamp' => 'Timestamp',
            'category'     => 'Category'
        );
        
        if(isset($this->action)){
            $columns['action'] = 'Action';
        }                                       
           
        if(isset($this->line)){
            $columns['line'] = 'Line';
        } 
                     
        if(isset($this->file)){
            $columns['file'] = 'File';
        }
                
        if(isset($this->function)){
            $columns['function'] = 'Function';
        }        
  
        if(isset($this->sqlresult)){
            $columns['sqlresult'] = 'SQL Result';
        }

        if(isset($this->sqlquery)){
            $columns['sqlquery'] = 'SQL Query';
        }
 
        if(isset($this->sqlerror)){
            $columns['sqlerror'] = 'SQL Error';
        }
          
        if(isset($this->wordpresserror)){
            $columns['wordpresserror'] = 'WP Error';
        }

        if(isset($this->screenshoturl)){
            $columns['screenshoturl'] = 'Screenshot';
        }
        
        if(isset($this->userscomment)){
            $columns['userscomment'] = 'Users Comment';
        }
 
        if(isset($this->columns_array->page)){
            $columns['page'] = 'Page';
        }

        if(isset($this->version)){
            $columns['version'] = 'Version';
        }
 
        if(isset($this->panelname)){
            $columns['panelname'] = 'Panel Name';
        }
  
        if(isset($this->tabscreenid)){
            $columns['tabscreenid'] = 'Screen ID';
        }

        if(isset($this->tabscreenname)){
            $columns['tabscreenname'] = 'Screen Name';
        }

        if(isset($this->dump)){
            $columns['dump'] = 'Dump';
        }

        if(isset($this->ipaddress)){
            $columns['ipaddress'] = 'IP Address';
        }

        if(isset($this->userid)){
            $columns['userid'] = 'User ID';
        }

        if(isset($this->comment)){
            $columns['comment'] = 'Comment';
        }

        if(isset($this->type)){
            $columns['type'] = 'Type';
        }
                                    
        if(isset($this->priority)){
            $columns['priority'] = 'Priority';
        }
       
        if(isset($this->thetrigger)){
            $columns['thetrigger'] = 'Trigger';
        }

        return $columns;
    }
    
    /** ************************************************************************
     * Optional. If you want one or more columns to be sortable (ASC/DESC toggle), 
     * you will need to register it here. This should return an array where the 
     * key is the column that needs to be sortable, and the value is db column to 
     * sort by. Often, the key and value will be the same, but this is not always
     * the case (as the value is a column name from the database, not the list table).
     * 
     * This method merely defines which columns should be sortable and makes them
     * clickable - it does not handle the actual sorting. You still need to detect
     * the ORDERBY and ORDER querystring variables within prepare_items() and sort
     * your data accordingly (usually by modifying your query).
     * 
     * @return array An associative array containing all the columns that should be sortable: 'slugs'=>array('data_values',bool)
     **************************************************************************/
    function get_sortable_columns() {
        $sortable_columns = array(
            //'post_title'     => array('post_title',false),     //true means it's already sorted
        );
        return $sortable_columns;
    }
    
    /** ************************************************************************
     * Optional. If you need to include bulk actions in your list table, this is
     * the place to define them. Bulk actions are an associative array in the format
     * 'slug'=>'Visible Title'
     * 
     * If this method returns an empty value, no bulk action will be rendered. If
     * you specify any bulk actions, the bulk actions box will be rendered with
     * the table automatically on display().
     * 
     * Also note that list tables are not automatically wrapped in <form> elements,
     * so you will need to create those manually in order for bulk actions to function.
     * 
     * @return array An associative array containing all the bulk actions: 'slugs'=>'Visible Titles'
     **************************************************************************/
    function get_bulk_actions() {
        $actions = array(

        );
        return $actions;
    }
    
    /** ************************************************************************
     * Optional. You can handle your bulk actions anywhere or anyhow you prefer.
     * For this example package, we will handle it in the class to keep things
     * clean and organized.
     * 
     * @see $this->prepare_items()
     **************************************************************************/
    function process_bulk_action() {
        
        //Detect when a bulk action is being triggered...
        if( 'delete'===$this->current_action() ) {
            wp_die('Items deleted (or they would be if we had items to delete)!');
        }
        
    }
    
    /** ************************************************************************
     * REQUIRED! This is where you prepare your data for display. This method will
     * usually be used to query the database, sort and filter the data, and generally
     * get it ready to be displayed. At a minimum, we should set $this->items and
     * $this->set_pagination_args(), although the following properties and methods
     * are frequently interacted with here...
     * 
     * @global WPDB $wpdb
     * @uses $this->_column_headers
     * @uses $this->items
     * @uses $this->get_columns()
     * @uses $this->get_sortable_columns()
     * @uses $this->get_pagenum()
     * @uses $this->set_pagination_args()
     **************************************************************************/
    function prepare_items($data,$per_page = 5) {
        global $wpdb; //This is used only if making any database queries        
        
        /**
         * REQUIRED. Now we need to define our column headers. This includes a complete
         * array of columns to be displayed (slugs & titles), a list of columns
         * to keep hidden, and a list of columns that are sortable. Each of these
         * can be defined in another method (as we've done here) before being
         * used to build the value for our _column_headers property.
         */
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        
        /**
         * REQUIRED. Finally, we build an array to be used by the class for column 
         * headers. The $this->_column_headers property takes an array which contains
         * 3 other arrays. One for all columns, one for hidden columns, and one
         * for sortable columns.
         */
        $this->_column_headers = array($columns, $hidden, $sortable);
        
        /**
         * Optional. You can handle your bulk actions however you see fit. In this
         * case, we'll handle them within our package just to keep things clean.
         */
        $this->process_bulk_action();
      
        /**
         * REQUIRED for pagination. Let's figure out what page the user is currently 
         * looking at. We'll need this later, so you should always include it in 
         * your own package classes.
         */
        $current_page = $this->get_pagenum();
        
        /**
         * REQUIRED for pagination. Let's check how many items are in our data array. 
         * In real-world use, this would be the total number of items in your database, 
         * without filtering. We'll need this later, so you should always include it 
         * in your own package classes.
         */
        $total_items = count($data);

        /**
         * The WP_List_Table class does not handle pagination for us, so we need
         * to ensure that the data is trimmed to only the current page. We can use
         * array_slice() to 
         */
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);
 
        /**
         * REQUIRED. Now we can add our *sorted* data to the items property, where 
         * it can be used by the rest of the class.
         */
        $this->items = $data;
  
        /**
         * REQUIRED. We also have to register our pagination options & calculations.
         */
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }
}

class C2P_Projects_Table extends WP_List_Table {

    function __construct(){
        global $status, $page;
             
        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'movie',     //singular name of the listed records
            'plural'    => 'movies',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );
        
    }

    function column_default($item, $column_name){
             
        $attributes = "class=\"$column_name column-$column_name\"";
                
        switch($column_name){
            case 'projectid':
                return $item['projectid'];    
                break;
            case 'projectname':
                return $item['projectname'];    
                break;
            case 'timestamp':
                return $item['timestamp'];    
                break;                                                        
            case 'source1':
                return $item['source1'];    
                break;                                                        
            case 'source2':
                return $item['source2'];    
                break;                                                        
            case 'source3':
                return $item['source3'];    
                break;                                                        
            default:
                return 'No column function or default setup in switch statement';
        }
    }

    /*
    function column_title($item){

    } */

    function get_columns(){
        $columns = array(
            'projectid' => 'Project ID',
            'projectname' => 'Project Name',
            'timestamp' => 'Timestamp',
            'source1' => 'Source 1',
            'source2' => 'Source 2',
            'source3' => 'Source 3'
        );

        return $columns;
    }

    function get_sortable_columns() {
        $sortable_columns = array(
            //'post_title'     => array('post_title',false),     //true means it's already sorted
        );
        return $sortable_columns;
    }

    function get_bulk_actions() {
        $actions = array(

        );
        return $actions;
    }

    function process_bulk_action() {
        
        //Detect when a bulk action is being triggered...
        if( 'delete'===$this->current_action() ) {
            wp_die('Items deleted (or they would be if we had items to delete)!');
        }
        
    }

    function prepare_items($data,$per_page = 5) {
        global $wpdb; //This is used only if making any database queries        

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);

        $this->process_bulk_action();

        $current_page = $this->get_pagenum();

        $total_items = count($data);

        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);

        $this->items = $data;

        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }
}

class C2P_DataSources_Table extends WP_List_Table {

    function __construct(){
        global $status, $page;
             
        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'movie',     //singular name of the listed records
            'plural'    => 'movies',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );
        
    }

    function column_default($item, $column_name){
             
        $attributes = "class=\"$column_name column-$column_name\"";
                
        switch($column_name){
            case 'sourceid':
                return $item['sourceid'];    
                break;            
            case 'projectid':
                if($item['projectid'] == 0){return 'Unknown';}
                return $item['projectid'];    
                break;
            case 'sourcetype':
                return $item['sourcetype'];    
                break;
            case 'path':
                return $item['path'];    
                break;            
            case 'timestamp':
                return $item['timestamp'];    
                break;                                                        
            default:
                return 'No column function or default setup in switch statement';
        }
    }

    /*
    function column_title($item){

    } */

    function get_columns(){
        $columns = array(
            'sourceid' => 'Source ID',
            'projectid' => 'projectid',
            'sourcetype' => 'Type',
            'path' => 'Path',
            'timestamp' => 'Timestamp'
        );

        return $columns;
    }

    function get_sortable_columns() {
        $sortable_columns = array(
            //'post_title'     => array('post_title',false),     //true means it's already sorted
        );
        return $sortable_columns;
    }

    function get_bulk_actions() {
        $actions = array(

        );
        return $actions;
    }

    function process_bulk_action() {
        
        //Detect when a bulk action is being triggered...
        if( 'delete'===$this->current_action() ) {
            wp_die('Items deleted (or they would be if we had items to delete)!');
        }
        
    }

    function prepare_items($data,$per_page = 5) {
        global $wpdb; //This is used only if making any database queries        

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);

        $this->process_bulk_action();

        $current_page = $this->get_pagenum();

        $total_items = count($data);

        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);

        $this->items = $data;

        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }
}

class C2P_ImportTableInformation_Table extends WP_List_Table {

    function __construct(){
        global $status, $page;
             
        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'movie',     //singular name of the listed records
            'plural'    => 'movies',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );
        
    }

    function column_default($item, $column_name){
 
        $attributes = "class=\"$column_name column-$column_name\"";
        
        return $item[$column_name];
    }

    /*
    function column_title($item){

    } */

    function get_columns(){
        
        $columns = array();
        
        foreach($this->columnarray as $key => $column){
            $columns[$column] = $column;
        }

        return $columns;
    }

    function get_sortable_columns() {
        $sortable_columns = array(
            //'post_title'     => array('post_title',false),     //true means it's already sorted
        );
        return $sortable_columns;
    }

    function get_bulk_actions() {
        $actions = array(

        );
        return $actions;
    }

    function process_bulk_action() {
        
        //Detect when a bulk action is being triggered...
        if( 'delete'===$this->current_action() ) {
            wp_die('Items deleted (or they would be if we had items to delete)!');
        }
        
    }

    function prepare_items($data,$per_page = 5) {
        global $wpdb; //This is used only if making any database queries        

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);

        $this->process_bulk_action();

        $current_page = $this->get_pagenum();

        $total_items = count($data);

        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);

        $this->items = $data;

        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }
}

class C2P_ProjectDataSources_Table extends WP_List_Table {

    function __construct(){
        global $status, $page;
             
        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'movie',     //singular name of the listed records
            'plural'    => 'movies',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );
        
    }

    function column_default($item, $column_name){
             
        $attributes = "class=\"$column_name column-$column_name\"";
                
        switch($column_name){
            case 'sourceid':
                return $item['sourceid'];    
                break;            
            case 'projectid':
                if($item['projectid'] == 0){return 'Unknown';}
                return $item['projectid'];    
                break;
            case 'sourcetype':
                return $item['sourcetype'];    
                break;
            case 'path':
                return $item['path'];    
                break;            
            case 'timestamp':
                return $item['timestamp'];    
                break;                                                        
            default:
                return 'No column function or default setup in switch statement';
        }
    }

    /*
    function column_title($item){

    } */

    function get_columns(){
        $columns = array(
            'sourceid' => 'Source ID',
            'projectid' => 'projectid',
            'sourcetype' => 'Type',
            'path' => 'Path',
            'timestamp' => 'Timestamp'
        );

        return $columns;
    }

    function get_sortable_columns() {
        $sortable_columns = array(
            //'post_title'     => array('post_title',false),     //true means it's already sorted
        );
        return $sortable_columns;
    }

    function get_bulk_actions() {
        $actions = array(

        );
        return $actions;
    }

    function process_bulk_action() {
        
        //Detect when a bulk action is being triggered...
        if( 'delete'===$this->current_action() ) {
            wp_die('Items deleted (or they would be if we had items to delete)!');
        }
        
    }

    function prepare_items($data,$per_page = 5) {
        global $wpdb; //This is used only if making any database queries        

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);

        $this->process_bulk_action();

        $current_page = $this->get_pagenum();

        $total_items = count($data);

        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);

        $this->items = $data;

        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }
}

class C2P_CategoryProjection_Table extends WP_List_Table {

    function __construct(){
        global $status, $page;
             
        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'movie',     //singular name of the listed records
            'plural'    => 'movies',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );
        
    }

    function column_default($item, $column_name){
        global $C2P_WP;

        foreach($item as $table_name => $column_array){

            foreach($column_array as $category_column => $projection_array){
                
                foreach($projection_array as $catterm => $item_array){
                    if($column_name == 'term'){
                        return $catterm;    
                    }    
                 
                }

                return $item_array[ $column_name ];
            }
        }
        
        return 'Nothing';
    }

    /*
    function column_title($item){

    } */

    function get_columns(){
        return array(
                'term' => 'Term',
                'mapped' => 'Mapped ID',
                'catslug' => 'Slug',
                'level' => 'Level',
                'parentterm' => 'Parent Term',
                'parentid' => 'Parent ID'
             ); 
    }

    function get_sortable_columns() {
        $sortable_columns = array(
            //'post_title'     => array('post_title',false),     //true means it's already sorted
        );
        return $sortable_columns;
    }

    function get_bulk_actions() {
        $actions = array(

        );
        return $actions;
    }

    function process_bulk_action() {
        
        //Detect when a bulk action is being triggered...
        if( 'delete'===$this->current_action() ) {
            wp_die('Items deleted (or they would be if we had items to delete)!');
        }
        
    }

    function prepare_items($data,$per_page = 5) {
        global $wpdb; //This is used only if making any database queries        

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);

        $this->process_bulk_action();

        $current_page = $this->get_pagenum();

        $total_items = count($data);

        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);

        $this->items = $data;

        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }
}

class C2P_CustomFields_Table extends WP_List_Table {

    function __construct(){
        global $status, $page;
             
        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'movie',     //singular name of the listed records
            'plural'    => 'movies',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );
    }

    function column_default($item, $column_name){
        switch($column_name){
            case 'delete':
                global $C2P_WP;
                return $C2P_WP->linkaction($C2P_WP->tabnumber(),$_GET['page'],'deletecustomfieldrule',__('Delete this custom field rule'),'Delete','&cfid='.$item['id']);    
                break;                                                                   
            default:
                return $item[$column_name];
        }        
    }

    /*
    function column_title($item){

    } */

    function get_columns(){
        return array(
                'name' => 'Name/Key',
                'unique' => 'Unique',
                'updating' => 'Updating',
                'value' => 'Template',
                'delete' => 'Delete'
             ); 
    }

    function get_sortable_columns() {
        $sortable_columns = array(
            //'post_title'     => array('post_title',false),     //true means it's already sorted
        );
        return $sortable_columns;
    }

    function get_bulk_actions() {
        $actions = array(

        );
        return $actions;
    }

    function process_bulk_action() {
        
        //Detect when a bulk action is being triggered...
        if( 'delete'===$this->current_action() ) {
            wp_die('Items deleted (or they would be if we had items to delete)!');
        }
    }

    function prepare_items($data,$per_page = 5) {
        global $wpdb; //This is used only if making any database queries        

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);

        $this->process_bulk_action();

        $current_page = $this->get_pagenum();

        $total_items = count($data);

        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);

        $this->items = $data;

        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }
}
?>