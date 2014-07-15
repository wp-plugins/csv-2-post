<?php
/**
 * Rules [page]   
 *
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne   
 * @since 8.1.3
 */

// Prohibit direct script loading
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * Rules [page] 
 * 
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne
 * @since 8.1.3
 */
class CSV2POST_Rules_View extends CSV2POST_View {

    /**
     * Number of screen columns for post boxes on this screen
     *
     * @since 8.1.3
     *
     * @var int
     */
    protected $screen_columns = 2;
    
    protected $view_name = 'rules';
    
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
        
        parent::setup( $action, $data );
        
        $this->add_meta_box( 'rules-roundnumberup', __( 'Round Number Up', 'csv2post' ), array( $this, 'postbox_rules_roundnumberup' ), 'normal','default',array( 'formid' => 'roundnumberup' ) );      
        $this->add_meta_box( 'rules-roundnumber', __( 'Round Number', 'csv2post' ), array( $this, 'postbox_rules_roundnumber' ), 'normal','default',array( 'formid' => 'roundnumber' ) );      
        $this->add_meta_box( 'rules-captalizefirstletter', __( 'Capitalize First Letter', 'csv2post' ), array( $this, 'postbox_rules_captalizefirstletter' ), 'normal','default',array( 'formid' => 'captalizefirstletter' ) );      
        $this->add_meta_box( 'rules-lowercaseall', __( 'All Lower Case', 'csv2post' ), array( $this, 'postbox_rules_lowercaseall' ), 'normal','default',array( 'formid' => 'lowercaseall' ) );      
        $this->add_meta_box( 'rules-uppercaseall', __( 'All Upper Case', 'csv2post' ), array( $this, 'postbox_rules_uppercaseall' ), 'normal','default',array( 'formid' => 'uppercaseall' ) );      

    }
    
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_rules_roundnumberup( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        
        global $c2p_settings;
        ?>  

            <table class="form-table">
            <?php
            $this->UI->option_project_headers_checkboxes( $c2p_settings['currentproject'], 'roundnumberupcolumns' );
            ?>
            </table>
        
        <?php 
        $this->UI->postbox_content_footer();
    }
        
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_rules_roundnumber( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        
        global $c2p_settings;
        ?>  

            <table class="form-table">
            <?php
            $this->UI->option_project_headers_checkboxes( $c2p_settings['currentproject'], 'roundnumbercolumns' );
            ?>
            </table>
        
        <?php 
        $this->UI->postbox_content_footer();
    }

    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_rules_captalizefirstletter( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        
        global $c2p_settings;
        ?>  

            <table class="form-table">
            <?php
            $this->UI->option_project_headers_checkboxes( $c2p_settings['currentproject'], 'captalizefirstlettercolumns' );
            ?>
            </table>
        
        <?php 
        $this->UI->postbox_content_footer();
    }

    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_rules_lowercaseall( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        
        global $c2p_settings;
        ?>  

            <table class="form-table">
            <?php
            $this->UI->option_project_headers_checkboxes( $c2p_settings['currentproject'], 'lowercaseallcolumns' );
            ?>
            </table>
        
        <?php 
        $this->UI->postbox_content_footer();
    }

    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_rules_uppercaseall( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        
        global $c2p_settings;
        ?>  
            
            <table class="form-table">
            <?php
            $this->UI->option_project_headers_checkboxes( $c2p_settings['currentproject'], 'uppercaseallcolumns' );
            ?>
            </table>
            
        <?php 
        $this->UI->postbox_content_footer();
    }        
}?>