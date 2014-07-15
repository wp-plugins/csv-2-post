<?php
/**
 * Custom Fields [page]   
 *
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne   
 * @since 8.1.3
 */

// Prohibit direct script loading
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * Custom Fields [page] 
 * 
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne
 * @since 8.1.3
 */
class CSV2POST_Customfields_View extends CSV2POST_View {

    /**
     * Number of screen columns for post boxes on this screen
     *
     * @since 8.1.3
     *
     * @var int
     */
    protected $screen_columns = 2;
    
    protected $view_name = 'customfields';
    
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
        
        $this->add_meta_box( 'meta-newcustomfield', __( 'New Custom Field', 'csv2post' ), array( $this, 'postbox_meta_newcustomfield' ), 'normal','default',array( 'formid' => 'newcustomfield' ) );      
        $this->add_meta_box( 'meta-customfieldstable', __( 'Custom Fields', 'csv2post' ), array( $this, 'postbox_meta_customfieldstable' ), 'normal','default',array( 'formid' => 'customfieldstable' ) );      
   }
 
    /**
    * post box function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_meta_newcustomfield( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        ?>  

            <table class="form-table"> 
                <?php 
                // custom field name
                $this->UI->option_text( 'Name', 'customfieldname', 'customfieldname', '', false, 'csv2post_inputtext', 'Example: mynew_customfield' );
                $this->UI->option_switch( 'Unique', 'customfieldunique', 'customfieldunique', 'enabled', __( 'Yes' ), __( 'No' ) );
                ?>        
            </table>
            
            <div id="poststuff">
                <?php 
                $cfcontent = '';
                if( isset( $_POST['customfielddefaultcontent'] ) ){$cfcontent = $_POST['customfielddefaultcontent'];}?>
                <?php wp_editor( $cfcontent, 'customfielddefaultcontent', array( 'textarea_name' => 'customfielddefaultcontent' ) );?>
            </div>
        
        <?php 
        $this->UI->postbox_content_footer();
    }

    /**
    * post box function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_meta_customfieldstable( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);

        // ensure we have an array
        if(!isset( $this->projectsettings['customfields']['cflist'] ) || !is_array( $this->projectsettings['customfields']['cflist'] ) ){
            $this->projectsettings['customfields']['cflist'] = array();
        }

        $CFTable = new C2P_CustomFields_Table();
        $CFTable->prepare_items( $this->projectsettings['customfields']['cflist'],100);
        ?>
                    
        <form id="movies-filter" method="get">
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <?php $CFTable->display() ?>
        </form>
        
        <?php 
        $this->UI->postbox_content_footer();
    }    
}?>