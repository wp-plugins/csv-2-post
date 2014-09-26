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
    
    public $purpose = 'normal';// normal, dashboard

    /**
    * Array of meta boxes, looped through to register them on views and as dashboard widgets
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.33
    * @version 1.0.0
    */
    public function meta_box_array() {
        // array of meta boxes + used to register dashboard widgets (id, title, callback, context, priority, callback arguments (array), dashboard widget (boolean) )   
        return $this->meta_boxes_array = array(
            // array( id, title, callback (usually parent, approach created by Ryan Bayne), context (position), priority, call back arguments array, add to dashboard (boolean), required capability
            array( 'rules-roundnumberup', __( 'Round Number Up', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'roundnumberup' ), true, 'activate_plugins' ),
            array( 'rules-roundnumber', __( 'Round Number', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'roundnumber' ), true, 'activate_plugins' ),
            array( 'rules-captalizefirstletter', __( 'Capitalize First Letter', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'captalizefirstletter' ), true, 'activate_plugins' ),
            array( 'rules-lowercaseall', __( 'All Lower Case', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'lowercaseall' ), true, 'activate_plugins' ),
            array( 'rules-uppercaseall', __( 'All Upper Case', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'uppercaseall' ), true, 'activate_plugins' ),
            array( 'rules-buycustomrules', __( 'Buy Custom Rules From £10/$15', 'csv2post' ), array( $this, 'parent' ), 'side','default',array( 'formid' => 'buycustomrules' ), true, 'activate_plugins' ),
        );    
    }
            
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
                        
        // set current project values
        if( isset( $c2p_settings['currentproject'] ) && $c2p_settings['currentproject'] !== false ) {
            
            $this->project_object = $this->CSV2POST->get_project( $c2p_settings['currentproject'] ); 
            if( !$this->project_object ) {
                $this->current_project_settings = false;
            } else {
                $this->current_project_settings = maybe_unserialize( $this->project_object->projectsettings ); 
            }

            parent::setup( $action, $data );     

            // using array register many meta boxes
            foreach( self::meta_box_array() as $key => $metabox ) {
                // the $metabox array includes required capability to view the meta box
                if( isset( $metabox[7] ) && current_user_can( $metabox[7] ) ) {
                    $this->add_meta_box( $metabox[0], $metabox[1], $metabox[2], $metabox[3], $metabox[4], $metabox[5] );   
                }               
            }        
            
        } else {
            $this->add_meta_box( 'rules-nocurrentproject', __( 'No Current Project', 'csv2post' ), array( $this->UI, 'metabox_nocurrentproject' ), 'normal','default',array( 'formid' => 'nocurrentproject' ) );      
        }
    }

    /**
    * Outputs the meta boxes
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 0.0.3
    * @version 1.0.0
    */
    public function metaboxes() {
        parent::register_metaboxes( self::meta_box_array() );     
    }

    /**
    * This function is called when on WP core dashboard and it adds widgets to the dashboard using
    * the meta box functions in this class. 
    * 
    * @uses dashboard_widgets() in parent class CSV2POST_View which loops through meta boxes and registeres widgets
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 0.0.2
    * @version 1.0.0
    */
    public function dashboard() { 
        parent::dashboard_widgets( self::meta_box_array() );  
    }
    
    /**
    * All add_meta_box() callback to this function to keep the add_meta_box() call simple.
    * 
    * This function also offers a place to apply more security or arguments.
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.32
    * @version 1.0.1
    */
    function parent( $data, $box ) {
        eval( 'self::postbox_' . $this->view_name . '_' . $box['args']['formid'] . '( $data, $box );' );
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
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( 'Replace decimal numbers by rounding them up on one or more columns.', 'csv2post' ), false );        
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
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( '', 'csv2post' ), false );        
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
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( '', 'csv2post' ), false );        
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
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( '', 'csv2post' ), false );        
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
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( 'Transform all letters to uppercase in the selected colums.', 'csv2post' ), false );        
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
    
    public function postbox_rules_buycustomrules( $data, $box ) {    
        echo '<p>';
        
        _e( 'Do you need a custom rule added to this page? I will add it for just £10.00, that is around $15 USD. You can
        even get a 50% discount simply by reviewing the free edition on Wordpress.org! In otherwords for the same amount 
        as a donation, you can hire a developer and get a plugin that is even closer to your needs.', 'csv2post' );
        
        echo '</p>';

        echo '<p>';
        
        echo '<a href="http://wordpress.org/support/view/plugin-reviews/csv-2-post#postform" target="_blank" title="' . __( 'Visit the Wordpress.org site and review CSV 2 POST free edition', 'csv2post' ) . '">' . 
        __( 'Ready to Review? Click here.', 'csv2post' ) . '</a>';
        
        echo '<p>';
        
        echo '<p>';
         
        _e( 'When ready please email csv2post@webtechglobal.co.uk with details about your custom data rule.', 'csv2post' );
    
        echo '</p>';        
        
    }        
}?>