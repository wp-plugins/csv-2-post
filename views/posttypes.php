<?php
/**
 * Post Types [page]   
 *
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne   
 * @since 8.1.3
 */

// Prohibit direct script loading
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * Post Types [page] 
 * 
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne
 * @since 8.1.3
 */
class CSV2POST_Posttypes_View extends CSV2POST_View {

    /**
     * Number of screen columns for post boxes on this screen
     *
     * @since 8.1.3
     *
     * @var int
     */
    protected $screen_columns = 2;
    
    protected $view_name = 'posttypes';
    
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
        
        $this->add_meta_box( 'posttypes-defaultposttyperules', __( 'Post Type Rules', 'csv2post' ), array( $this, 'postbox_posttypes_defaultposttyperules' ), 'normal','default',array( 'formid' => 'defaultposttyperules' ) );      
   }
 
    /**
    * post box function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_posttypes_defaultposttyperules( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        
        global $c2p_settings;
        ?>  

            <table class="form-table">
            <?php
            for( $i=1;$i<=3;$i++){
                
                $posttyperule_table = ''; 
                $posttyperule_column = '';
                if( isset( $this->projectsettings['posttypes']["posttyperule$i"]['table'] ) ){$posttyperule_table = $this->projectsettings['posttypes']["posttyperule$i"]['table'];}
                if( isset( $this->projectsettings['posttypes']["posttyperule$i"]['column'] ) ){$posttyperule_column = $this->projectsettings['posttypes']["posttyperule$i"]['column'];}             
                $this->UI->option_projectcolumns( __( "Column $i"), $c2p_settings['currentproject'], "posttyperule$i", "posttyperule$i", $posttyperule_table, $posttyperule_column, 'notrequired', 'Not Required' );

                $posttyperuletrigger = '';
                if( isset( $this->projectsettings['posttypes']["posttyperuletrigger$i"] ) ){$posttyperuletrigger = $this->projectsettings['posttypes']["posttyperuletrigger$i"];}            
                $this->UI->option_text( __( "Trigger $i"), "posttyperuletrigger$i", "posttyperuletrigger$i", $posttyperuletrigger, false );
                
                $posttyperuleposttype = '';
                if( isset( $this->projectsettings['posttypes']["posttyperuleposttype$i"] ) ){$posttyperuleposttype = $this->projectsettings['posttypes']["posttyperuleposttype$i"];}            
                $this->UI->option_radiogroup_posttypes( __( "Post Type $i"), "posttyperuleposttype$i", "posttyperuleposttype$i", $posttyperuleposttype);
            }
            ?>
            </table>
        
        <?php 
        $this->UI->postbox_content_footer();
    }
}?>