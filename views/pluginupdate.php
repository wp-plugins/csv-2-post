<?php
/**
 * Plugin Update [page] 
 * 
 * This page displays when the plugin requires updating. The idea is to layout all changes
 * and warn the user importing changes that might need to be tested.  
 *
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne   
 * @since 8.1.3
 */

// Prohibit direct script loading
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * Update the plugin [page] 
 * 
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne
 * @since 8.1.3
 */
class CSV2POST_Pluginupdate_View extends CSV2POST_View {

    /**
     * Number of screen columns for post boxes on this screen
     *
     * @since 8.1.3
     *
     * @var int
     */
    protected $screen_columns = 2;
    
    protected $view_name = 'pluginupdate';
    
    /**
     * Set up the view with data and do things that are specific for this view
     *
     * @since 8.1.3
     *
     * @param string $action Action for this view
     * @param array $data Data for this view
     */
    public function setup( $action, array $data ) {
        global $c2p_settings;
        
        // create constant for view name
        if(!defined( "WTG_CSV2POST_VIEWNAME") ){define( "WTG_CSV2POST_VIEWNAME", $this->view_name );}
        
        // create class objects
        $this->CSV2POST = CSV2POST::load_class( 'CSV2POST', 'class-csv2post.php', 'classes' );
        $this->UI = CSV2POST::load_class( 'C2P_UI', 'class-ui.php', 'classes' ); 
        $this->DB = CSV2POST::load_class( 'C2P_DB', 'class-wpdb.php', 'classes' );
        $this->PHP = CSV2POST::load_class( 'C2P_PHP', 'class-phplibrary.php', 'classes' );
                        
        // load the current project row and settings from that row
        $this->project_object = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );
        $this->current_project_settings = maybe_unserialize( $this->project_object->projectsettings );
        
        // get schedule array 
        $this->schedule = CSV2POST::get_option_schedule_array();
                
        parent::setup( $action, $data );
        
        $this->add_meta_box( 'pluginupdate-changes', __( 'Changes', 'csv2post' ), array( $this, 'postbox_pluginupdate_changes' ), 'normal','default',array( 'formid' => 'changes' ) );      
        $this->add_meta_box( 'pluginupdate-instructions', __( 'Update Instructions', 'csv2post' ), array( $this, 'postbox_pluginupdate_instructions' ), 'normal','default',array( 'formid' => 'instructions' ) );      
        $this->add_meta_box( 'pluginupdate-beginpluginupdate', __( 'Begin Plugin Update', 'csv2post' ), array( $this, 'postbox_pluginupdate_beginpluginupdate' ), 'side','default',array( 'formid' => 'beginpluginupdate' ) );      

    }
 
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_pluginupdate_changes( $data, $box ) {    
        echo '<p>' . __( 'Sorry there is no information at this time. This update page is new and awaiting completion of
        a system designed to manage all documentation. Just remember to backup your files and data.', 'csv2post' ) . '</p>';
    }
    
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_pluginupdate_instructions( $data, $box ) {    
        echo '<p>' . __( 'There are no special update instructions for this update','csv2post' ) . '</p>';    
    } 
    
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_pluginupdate_beginpluginupdate( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        
        echo '<p>' . __( "Have you backed everything up? It is highly recommended due to the nature
        of the plugin and the mass changes it can make in a short time. When you are ready click Submit
        to initiate the update process.", 'csv2post' ) . '</p>';
         
        $this->UI->postbox_content_footer();
    }       
}
?>