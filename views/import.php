<?php
/**
 * Data Import [page]   
 *
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne   
 * @since 8.1.3
 */

// Prohibit direct script loading
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * View class for Data Import [page] 
 * 
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne
 * @since 8.1.3
 */
class CSV2POST_Import_View extends CSV2POST_View {

    /**
     * Number of screen columns for post boxes on this screen
     *
     * @since 8.1.3
     *
     * @var int
     */
    protected $screen_columns = 2;
    
    protected $view_name = 'import';
    
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
        if( isset( $c2p_settings['currentproject'] ) && $c2p_settings['currentproject'] !== false ) {
            
            $this->project_object = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );
            $this->current_project_settings = maybe_unserialize( $this->project_object->projectsettings );

            parent::setup( $action, $data );
            
            $this->add_meta_box( 'import-importsources', __( 'Import Data', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'importsources' ) );      
            $this->add_meta_box( 'import-deleteduplicaterowsandposts', __( 'Delete Duplicate Rows and Posts', 'csv2post' ), array( $this, 'postbox_import_deleteduplicaterowsandposts' ), 'side','default',array( 'formid' => 'deleteduplicaterowsandposts' ) );      
            
        } else {
            $this->add_meta_box( 'import-nocurrentproject', __( 'No Current Project', 'csv2post' ), array( $this->UI, 'metabox_nocurrentproject' ), 'normal','default',array( 'formid' => 'nocurrentproject' ) );      
        }    
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
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_import_importsources( $data, $box ) {                      
        global $c2p_settings, $wpdb;      

        // get current project
        if( isset( $c2p_settings['currentproject'] ) ) {
            $this->current_project = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );      
            $this->current_project_settings = maybe_unserialize( $this->current_project->projectsettings);        
        }
                        
        if(!isset( $c2p_settings['currentproject'] ) || !is_numeric( $c2p_settings['currentproject'] ) ){
            echo "<p class=\"csv2post_boxes_introtext\">". __( 'You have not created a project or somehow a Current Project has not been set.' ) ."</p>";
            return;
        }

        $sourceid_array = $this->CSV2POST->get_project_sourcesid( $c2p_settings['currentproject'] );
        foreach( $sourceid_array as $key => $source_id){
            // get the source row
            $row = $this->DB->selectrow( $wpdb->c2psources, 'sourceid = "' . $source_id . '"', 'path,tablename,thesep' );?>

            <?php $postbox_title = basename( $row->path) . ' to ' . $row->tablename;?>
            <?php $form_id = 'importdata'.$key;?>
            <a id="anchor_<?php echo $form_id;?>"></a>
            <h4><?php echo $postbox_title; ?></h4>

                <form method="post" name="<?php echo $form_id;?>" action="<?php echo get_admin_url() . 'admin.php?page=' . $_GET['page']; ?>">
                    <?php $this->UI->hidden_form_values( $form_id, $postbox_title);?>

                    <input type="hidden" name="tablename" value="<?php echo $row->tablename;?>">
                    <input type="hidden" name="sourceid" value="<?php echo $source_id;?>">             
                    <table class="form-table">
                    <?php    
                    $this->UI->option_subline( $wpdb->get_var( "SELECT COUNT(*) FROM $row->tablename"), 'Imported' );
                    $this->UI->option_subline( $wpdb->get_var( "SELECT COUNT(*) FROM $row->tablename WHERE c2p_postid != 0"), 'Used' );
                    
                    // to determine how many rows are outdated we need to get the wp_c2psources changecounter value which tells us the total 
                    // number of times the source has been updated, records with a lower changecounter have not been updated yet
                    $changecount = $wpdb->get_var( "SELECT changecounter FROM $wpdb->c2psources");
                    // now query all imported rows that have a lower value than $changecount
                    $outdated = $wpdb->get_var( "SELECT COUNT(*) FROM $row->tablename WHERE c2p_changecounter < $changecount");
                    $this->UI->option_subline( $outdated, 'Outdated' );
                    
                    $this->UI->option_subline(0, 'Expired' );// rows older than user defined expiry date or defined column of expiry dates
                    $this->UI->option_subline(0, 'Void' );// rows made void due to rules or fault or even public reporting a bad post                                                                                          
                    
                    ########################################################
                    #                                                      #
                    #                   DUPLICATE KEYS                     #
                    #                                                      #
                    ########################################################
                    // display the total number of duplicate rows based on unique key column only
                    $duplicate_keys = array();
                    $this->idcolumn = false;
                    if( isset( $this->current_project_settings['idcolumn'] ) ){
                        
                        $this->idcolumn = $this->current_project_settings['idcolumn'];    

                        // get an array of the keys which have duplicates (not every duplicate just an array of keys that have 2 or more)
                        $this->duplicate_keys = $this->DB->get_duplicate_keys( $row->tablename, $this->idcolumn );
                    
                    }
                    $this->UI->option_subline( count( $this->duplicate_keys ), 'Duplicate Keys' );
                    ?>
                    </table>
                    <input class="button" type="submit" value="Submit" />
                </form>                    

        <?php 
        }
    } 

    /**
    * post box function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_import_deleteduplicaterowsandposts( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);

        if( $this->duplicate_keys ){
            echo '<p>' . __( 'You have duplicate key values. You selected column <strong>' . $this->idcolumn . '</strong> as your unique
            value column. Duplicates are not recommended in that column for many operations to work properly. However the plugin does 
            not restrict them without the user requesting it.', 'csv2post' ) . '</p>';
            $this->UI->postbox_content_footer();
        }else{
            echo '<p>' . __( 'You do not have any duplicate keys.','csv2post' ) . '</p>';
        }
    }
}?>