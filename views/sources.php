<?php
/**
 * Sources [page]   
 *
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne   
 * @since 8.1.3
 */

// Prohibit direct script loading
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * Sources [page] 
 * 
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne
 * @since 8.1.3
 */
class CSV2POST_Sources_View extends CSV2POST_View {

    /**
     * Number of screen columns for post boxes on this screen
     *
     * @since 8.1.3
     *
     * @var int
     */
    protected $screen_columns = 2;
    
    protected $view_name = 'sources';
    
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
        
        $this->add_meta_box( 'sources-datasources', __( 'Sources Table', 'csv2post' ), array( $this, 'postbox_sources_datasources' ), 'normal','default',array( 'formid' => 'datasources' ) );      
     }
 
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_sources_datasources( $data, $box ) {    
        global $CSV2POST, $wpdb, $C2P_DB, $c2p_settings;

        if(!isset( $c2p_settings['currentproject'] ) || !is_numeric( $c2p_settings['currentproject'] ) ){
            echo "<p class=\"csv2post_boxes_introtext\">". __( 'You have not created a project or somehow a Current Project has not been set.' ) ."</p>";
            return;
        }

        $query_results = $C2P_DB->selectwherearray( $wpdb->c2psources, 'projectid = ' . $c2p_settings['currentproject'], 'sourceid', '*' );
        $SourcesTable = new C2P_ProjectDataSources_Table();
        $SourcesTable->prepare_items( $query_results,10);
        ?>

        <form id="movies-filter" method="get">
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <?php $SourcesTable->display() ?>
        </form>
        
        <?php 
    }
}?>