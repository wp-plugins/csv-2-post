<?php
/**
 * Data Sources [page]   
 *
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne   
 * @since 8.1.3
 */

// Prohibit direct script loading
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * View class for Data Sources [page] 
 * 
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne
 * @since 8.1.3
 */
class CSV2POST_Datasources_View extends CSV2POST_View {

    /**
     * Number of screen columns for post boxes on this screen
     *
     * @since 8.1.3
     *
     * @var int
     */
    protected $screen_columns = 2;
    
    protected $view_name = 'datasources';
    
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
        
        $this->add_meta_box( 'datasources-changecsvfilepath', __( 'Change CSV File Path', 'csv2post' ), array( $this, 'postbox_datasources_changecsvfilepath' ), 'normal','default',array( 'formid' => 'changecsvfilepath' ) );      
        $this->add_meta_box( 'datasources-datasourcestable', __( 'Data Sources Table', 'csv2post' ), array( $this, 'postbox_datasources_datasourcestable' ), 'normal','default',array( 'formid' => 'datasourcestable' ) );      

    }
 
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_datasources_changecsvfilepath( $data, $box ) {  
        global $CSV2POST, $wpdb, $C2P_DB, $C2P_UI, $C2P_WP;
        $query_results = $C2P_DB->selectwherearray( $wpdb->c2psources, 'sourceid = sourceid', 'sourceid', '*' );
        if(!$query_results){
            $intro = __( 'No sources were found.' );
        }else{
            $intro = __( 'The new .csv file must have identical configuration...' );
        }
          
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $intro, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        ?>  

        <?php if( $query_results){?>
        
            <table class="form-table">
                <?php $C2P_UI->option_text_simple( __( 'New Path' ), 'newpath', '', true);?> 
                <?php $C2P_UI->option_menu_datasources(); ?>
            </table>
        
        <?php }?>
        
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
    public function postbox_datasources_datasourcestable( $data, $box ) { 
        global $wpdb,$C2P_DB;
        $query_results = $C2P_DB->selectwherearray( $wpdb->c2psources, 'sourceid = sourceid', 'sourceid', '*' );      
        $SourcesTable = new C2P_DataSources_Table();
        $SourcesTable->prepare_items( $query_results,10);
        ?>

        <form id="movies-filter" method="get">
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <?php $SourcesTable->display() ?>
        </form>

        <?php 
    } 
}?>