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

        // set current project values
        if( isset( $c2p_settings['currentproject'] ) && $c2p_settings['currentproject'] !== false ) {
            $this->project_object = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );
            $this->current_project_settings = maybe_unserialize( $this->project_object->projectsettings );
        }
        
        parent::setup( $action, $data );
    
        // normal
        $this->add_meta_box( 'datasources-createuploadcsvdatasource', __( 'Create New Data Source', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'createuploadcsvdatasource' ) );            
        $this->add_meta_box( 'datasources-createurlcsvdatasource', __( 'Create New Data Source (URL Method)', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'createurlcsvdatasource' ) );            
        $this->add_meta_box( 'datasources-datasourcestable', __( 'Data Sources Table', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'datasourcestable' ) );            
        
        // side
        $this->add_meta_box( 'datasources-emptyspace', __( 'Why So Much Space?', 'csv2post' ), array( $this, 'parent' ), 'side','default',array( 'formid' => 'emptyspace' ) );            
    }

    /**
    * All add_meta_box() callback to this function, values in $box are used to then call
    * the intended box to render a unique form or information. 
    * 
    * The purpose of this box is to apply security to all boxes but it could also be used
    * to dynamically call different functions based on arguments
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.32
    * @version 1.0.0
    */
    function parent( $data, $box ) {
        
        // if $box['args']['capability'] is not set with over-riding capability added to add_meta_box() arguments then set it
        if( !isset( $box['args']['capability'] ) || !is_string( $box['args']['capability'] ) ) {
            $box['args']['capability'] = $this->UI->get_boxes_capability( $box['args']['formid'] );
        }
        
        // call method in CSV2POST - this is done because it is harder to put this parent() function there as it includes "self::"
        // any other approach can get messy I think but I'd welcome suggestions on this 
        if( isset( $box['args']['capability'] ) && !current_user_can( $box['args']['capability'] ) ) { 
            echo '<p>' . __( 'You do not have permission to access the controls and information in this box.', 'csv2post' ) . '</p>';
            return false;    
        }        
        
        // call the intended function 
        eval( 'self::postbox_' . $this->view_name . '_' . $box['args']['formid'] . '( $data, $box );' );
    }
    
    /**
    * upload a new file via form to an existing data source directory
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_datasources_createuploadcsvdatasource( $data, $box ) { 
        $intro = __( 'Upload a .csv file. This also creates a Data Source based on your files configuration. If your data is sensitive please
        import the content to the database now. Then delete the .csv file from your server.', 'csv2post' );
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $intro, false, true );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title'] );
        ?>  

            <table class="form-table">

            <?php
            $this->UI->option_file( __( 'Select .csv File', 'csv2post' ), 'uploadsinglefile1', 'uploadsinglefile1' );
            $wp_upload_dir_array = wp_upload_dir();
            $this->UI->option_text_simple( __( 'Path', 'csv2post' ), 'newdatasourcethepath1',$wp_upload_dir_array['path'], true );                
            $this->UI->option_text( __( 'ID Column', 'csv2post' ), 'uniqueidcolumn1', 'uniqueidcolumn1', '' );
            $this->UI->option_text( __( 'Source Name', 'csv2post' ), 'newprojectname1', 'newprojectname1', '' );

            // offer option to delete an existing table if the file matches one, user needs to enter random number
            $this->UI->option_text( __( 'Delete Existing Table', 'csv2post' ), 'deleteexistingtable1', 'deleteexistingtable1',rand(100000,999999), true);
            $this->UI->option_text( __( 'Enter Code', 'csv2post' ), 'deleteexistingtablecode1', 'deleteexistingtablecode1', '' );
            ?>
            
            </table>

        <?php 
        $this->UI->postbox_content_footer();
    } 
         
    /**
    * upload a new file via form to an existing data source directory
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_datasources_createurlcsvdatasource( $data, $box ) { 
        $intro = __( 'Transfer your .csv file to your server using a URL. This also creates a Data Source which holds your .csv files configuration. Try my test file http://www.webtechglobal.co.uk/public/wordpress/csv2post/ComputersMain.csv', 'csv2post' );
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $intro, false, true );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        ?>  

            <table class="form-table">

            <?php                     
            $this->UI->option_text_simple( __( 'URL', 'csv2post' ), 'newdatasourcetheurl2','', true, 'URL' );
            $wp_upload_dir_array = wp_upload_dir();                
            $this->UI->option_text_simple( __( 'Path', 'csv2post' ), 'newdatasourcethepath2',$wp_upload_dir_array['path'], true );                
            $this->UI->option_text( __( 'ID Column', 'csv2post' ), 'uniqueidcolumn2', 'uniqueidcolumn2', '' );
            $this->UI->option_text( __( 'Source Name', 'csv2post' ), 'newprojectname2', 'newprojectname2', '' );

            // offer option to delete an existing table if the file matches one, user needs to enter random number
            $this->UI->option_text( __( 'Delete Existing Table', 'csv2post' ), 'deleteexistingtable2', 'deleteexistingtable2',rand(100000,999999), true);
            $this->UI->option_text( __( 'Enter Code', 'csv2post' ), 'deleteexistingtablecode2', 'deleteexistingtablecode2', '' );
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
    public function postbox_datasources_changecsvfilepath( $data, $box ) {  
        global $CSV2POST, $wpdb, $C2P_WP;
        $query_results = $this->DB->selectwherearray( $wpdb->c2psources, 'sourceid = sourceid', 'sourceid', '*' );
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
                <?php $this->UI->option_text_simple( __( 'New Path' ), 'newpath', '', true);?> 
                <?php $this->UI->option_menu_datasources(); ?>
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
        global $wpdb;
        $query_results = $this->DB->selectwherearray( $wpdb->c2psources, 'sourceid = sourceid', 'sourceid', '*' );      
        $SourcesTable = new C2P_DataSources_Table();
        $SourcesTable->prepare_items_further( $query_results,10);
        ?>

        <form id="movies-filter" method="get">
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <?php $SourcesTable->display() ?>
        </form>

        <?php 
    }   
        
    /**
    * details about why there is so much space in the plugin and the sandbox approach
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_datasources_emptyspace( $data, $box ) { 
        _e( 'The short story is that the plugin has an intended sandbox design. I want users to 
        position the meta boxes (accordians) they use at the top and the rest to the bottom. The
        sidebars are intended for information rather than forms or quick tools where a single button
        is required. The plugin was re-developed beginning 2014 and a lot of features are still to be added.
        The sandbox approach will really come into effect then as the interface will be packed. The first thing
        users will do is hide all the boxes they never use. It will almost be like creating a custom plugin and 
        progress is being made to deliver that experience.', 'csv2post' );
    }    
}?>