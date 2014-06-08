<?php
/** 
* Install, uninstall, repair
* 
* The section array can be used to prevent installation of per section elements before activation of the plugin.
* Once activation has been done, section switches can be used to change future activation. This is early stuff
* so not sure if it will be of use.
* 
* @since 8.0.0
* 
* @author Ryan Bayne 
*/

class C2P_Install{
    
    /**
    * Install __construct persistently registers database tables and is the
    * first point to monitoring installation state 
    */
    public function __construct() {
        global $c2p_sections_array;
        
        // we need section load states (in-line settings to prevent the plugin expecting a section to exist and be installed)
        require_once(WTG_CSV2POST_PATH.'arrays/sections_array.php');
  
        // on activation run install_plugin() method which then runs more methods i.e. create_tables();
        register_activation_hook( WTG_CSV2POST_PATH . 'csv-2-post.php', array($this,'install_plugin') ); 

        // register c2plog table
        add_action( 'init', array($this,'register_c2plog_table') );
        add_action( 'switch_blog', array($this,'register_c2plog_table') );
        $this->register_c2plog_table(); // register tables manually as the hook may have been missed  
        
        // register c2pprojects tables
        add_action( 'init', array($this,'register_c2pprojects_table') );
        add_action( 'switch_blog', array($this,'register_c2pprojects_table') );
        $this->register_c2pprojects_table(); // register tables manually as the hook may have been missed  

        add_action( 'init', array($this,'register_c2psources_table') );
        add_action( 'switch_blog', array($this,'register_c2psources_table') );
        $this->register_c2psources_table(); // register tables manually as the hook may have been missed              
    }

    function register_c2plog_table() {
        global $wpdb;
        $wpdb->c2plog = "{$wpdb->prefix}c2plog";
    }    
    
    function register_c2pprojects_table() {
        global $wpdb;
        $wpdb->c2pprojects = "{$wpdb->prefix}c2pprojects";
    }
 
    function register_c2psources_table() {
        global $wpdb;
        $wpdb->c2psources = "{$wpdb->prefix}c2psources";
    }
     
    /**
    * runs all CREATE queries for main and sections                
    */
    function create_tables() {       
        global $charset_collate,$wpdb,$c2p_sections_array,$CSV2POST;
        
        require( ABSPATH . 'wp-admin/includes/upgrade.php' );
          
        // c2plog - log everything in this table and use the data for multiple purposes
        $sql_create_table = "CREATE TABLE {$wpdb->c2plog} (
                row_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                outcome tinyint(1) unsigned NOT NULL DEFAULT 1,
                timestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                line int(11) unsigned DEFAULT NULL,
                file varchar(250) DEFAULT NULL,
                function varchar(250) DEFAULT NULL,
                sqlresult blob,
                sqlquery varchar(45) DEFAULT NULL,
                sqlerror mediumtext,
                wordpresserror mediumtext,
                screenshoturl varchar(500) DEFAULT NULL,
                userscomment mediumtext,
                page varchar(45) DEFAULT NULL,
                version varchar(45) DEFAULT NULL,
                panelid varchar(45) DEFAULT NULL,
                panelname varchar(45) DEFAULT NULL,
                tabscreenid varchar(45) DEFAULT NULL,
                tabscreenname varchar(45) DEFAULT NULL, 
                dump longblob,
                ipaddress varchar(45) DEFAULT NULL,
                userid int(11) unsigned DEFAULT NULL,
                comment mediumtext,
                type varchar(45) DEFAULT NULL,
                category varchar(45) DEFAULT NULL,
                action varchar(45) DEFAULT NULL,
                priority varchar(45) DEFAULT NULL,
                triga varchar(45) DEFAULT NULL,        
                PRIMARY KEY row_id (row_id)   
             ) $charset_collate; ";
        dbDelta( $sql_create_table );   
        // row_id
        // outcome - set a positive (1) or negative (0) outcome
        // timestamp
        // line - __LINE__
        // file - __FILE__
        // function - __FUNCTION__
        // sqlresult - return from the query (dont go mad with this and store large or sensitive data where possible)
        // sqlquery - the query as executed
        // sqlerror - if failed MySQL error in here
        // wordpresserror - if failed store WP error
        // screenshoturl - if screenshot taking and uploaded
        // userscomment - if user is testing they can submit a comment with error i.e. what they done to cause it
        // page - plugin page ID i.e. c2pdownloads
        // version - version of the plugin (plugin may store many logs over many versions)
        // panelid - (will be changed to formid i.e. savebasicsettings)
        // panelname - (will be changed to formname i.e Save Basic Settings)
        // tabscreenid - the tab number i.e. 0 or 1 or 5
        // tabscreenname - the on screen name of the tab in question, if any i.e. Downloads Overview
        // dump - anything the developer thinks will help with debugging or training
        // ipaddress - security side of things, record who is using the site
        // userid - if user logged into Wordpress
        // comment - developers comment in-code i.e. recommendation on responding to the log entry
        // type - general|error|trace
        // category - any term that suits the section or system
        // action - what was being attempted, if known 
        // priority - low|medium|high (low should be default, medium if the log might help improve the plugin or user experience or minor PHP errors, high for critical errors especially security related
        // triga - (trigger but that word is taking) not sure we need this       
        
        // c2pprojects
        $sql_create_table = "CREATE TABLE {$wpdb->c2pprojects} (
                projectid bigint(5) unsigned NOT NULL AUTO_INCREMENT,
                projectname varchar(45) DEFAULT NULL,
                timestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                source1 int(5) unsigned DEFAULT 0,
                source2 int(5) unsigned DEFAULT 0,
                source3 int(5) unsigned DEFAULT 0,
                source4 int(5) unsigned DEFAULT 0,
                source5 int(5) unsigned DEFAULT 0,
                lockcontent tinyint(1) unsigned DEFAULT 0,
                lockmeta tinyint(1) unsigned DEFAULT 0,
                datatreatment varchar(50) DEFAULT 'single',
                projectsettings longtext DEFAULT NULL,
                settingschange DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
                PRIMARY KEY projectid (projectid)   
             ) $charset_collate; ";
        dbDelta( $sql_create_table );   
        // projectid - users will see this and use it to identify their project
        // projectname - optional and not initially requested to make things simple
        // timestamp
        // sourceone/sourcefive - these are the sourceid from the c2psources table
        // lockcontent (0|1) - true(1) will prevent the content being changed during updating
        // lockmeta (0|1) - true(1) will prevent ALL custom field values being changed during updating
        // datatreatment (single | append | join | individual)
        // projectsettings (serialized array) - tags, post type, post status, dates and more
        // categories (serialized array) - an array of category columns and settings
        // customfields (serialized array) - array of custom fields and related settings
        // taxonomies (serialized array) - array of project taxonomy settings, including custom taxonomy and meta for taxonomies
        // postcontent (serialized array) - array of content designs linked to project and applicable settings/rules per design

        // c2psources
        $sql_create_table = "CREATE TABLE {$wpdb->c2psources} (
                sourceid bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                projectid int(5) unsigned DEFAULT 0,
                sourcetype varchar(45) DEFAULT NULL,
                progress int(12) DEFAULT 0,
                timestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                path varchar(500) DEFAULT NULL, 
                monitorchange tinyint(1) unsigned DEFAULT 1,
                changecounter int(8) unsigned DEFAULT 0,
                datatreatment varchar (50) NOT NULL DEFAULT 'single',
                parentfileid int(5) unsigned DEFAULT 0,
                tablename varchar (50) NOT NULL DEFAULT '0',
                rules longtext DEFAULT NULL,
                thesep varchar(1) DEFAULT NULL,
                theconfig longtext DEFAULT NULL,
                PRIMARY KEY sourceid (sourceid)   
             ) $charset_collate; ";
        dbDelta( $sql_create_table );   
        // sourceid
        // projectid - may not always be populated by populating it will help avoid querying project table just to display project id
        // sourcetype (localcsv)
        // progress - number of rows previously processed, we will reset this when a new file is detected
        // timestamp
        // path - path to file
        // monitorchange (0|1) - true(1) will make the plugin monitor changes i.e. new .csv file, then re-import in response
        // changecounter (numeric) - each time plugin detects newer source file, changecounter is increased telling us how many times source has been update but this is also used in each row to indicate the update status
        // datatreatment (single | append | join | individual) - single means a one file project, all others are multi-file project treatments
        // parentfileid - 0 indicates the source is a parent (may not be part of a group), otherwise a value indicates source is part of a group (not always merged into one table)                                       
        // tablename - database table the source is to be imported into (could be a table name based on parent source)
        // rules - serialized array of rules that are applied to each row before it is inserted to the database
        // thesep - although this will be stored in theconfig array it will be easier for hackers by putting it in a column of its own
        // theconfig - this is a serialized array, it should not be relied on where we can easily use the source files or re-establish the information
        // rules - array of rules to prepare the data
    }
                                       
    /**
    * reinstall all database tables in one go 
    */
    public function reinstalldatabasetables(){
        global $C2P_WP,$c2p_tables_array,$C2P_DB;
        
        if(is_array($c2p_tables_array)){
            foreach($c2p_tables_array['tables'] as $key => $table){
                if($C2P_DB->does_table_exist($table['name'])){         
                    $wpdb->query( 'DROP TABLE '. $table['name'] );
                }                                                             
            }
        } 
        
        return $this->create_tables();
    } 
    
    function install_options(){
        // installation state values
        update_option('csv2post_installedversion',$this->current_version);# will only be updated when user prompted to upgrade rather than activation
        update_option('csv2post_installeddate',time());# update the installed date, this includes the installed date of new versions

        // notifications array (persistent notice feature)
        add_option('csv2post_notifications',serialize(array())); 
    }
    
    function install_plugin(){
                        
        $this->create_tables();
        $this->install_options();
        
        // if this gets installed we know we arrived here in the installation procedure
        update_option('csv2post_is_installed',true);
    } 
   
    /**
    * 
    * 
    * @todo add a function per section for test data installation, testdata() procedure should avoid calling 
    * methods for sections not active
    * 
    * 
    */
    public function testdata(){
        /* KEEP THIS FUNCTION UNTIL NEEDED */            
    }                 
}
  
?>
