<?php
/**
 * Table [page]   
 *
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne   
 * @since 8.1.3
 */

// Prohibit direct script loading
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * Table [page] 
 * 
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne
 * @since 8.1.3
 */
class CSV2POST_Table_View extends CSV2POST_View {

    /**
     * Number of screen columns for post boxes on this screen
     *
     * @since 8.1.3
     *
     * @var int
     */
    protected $screen_columns = 2;
    
    protected $view_name = 'table';
    
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
        
            $this->add_meta_box( 'table-datatable', __( 'Table', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'datatable' ) );      
        
        } else {
            $this->add_meta_box( 'rules-nocurrentproject', __( 'No Current Project', 'csv2post' ), array( $this->UI, 'metabox_nocurrentproject' ), 'normal','default',array( 'formid' => 'nocurrentproject' ) );      
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
    public function postbox_table_datatable( $data, $box ) {    
        global $CSV2POST, $wpdb, $C2P_WP, $c2p_settings, $wpdb;

        if(!isset( $c2p_settings['currentproject'] ) || !is_numeric( $c2p_settings['currentproject'] ) ){
            echo "<p class=\"csv2post_boxes_introtext\">". __( 'You have not created a project or somehow a Current Project has not been set.' ) ."</p>";
            return;
        }

        $sourceid_array = $CSV2POST->get_project_sourcesid( $c2p_settings['currentproject'] );

        $tables_already_displayed = array();

        foreach( $sourceid_array as $key => $source_id){

            // get the source row
            $row = $this->DB->selectrow( $wpdb->c2psources, 'sourceid = "' . $source_id . '"', 'tablename,path' );

            // avoid displaying the same database table twice
            if(in_array( $row->tablename, $tables_already_displayed) ){
                continue;
            }
            $tables_already_displayed[] = $row->tablename;
            
            $importedrows = $this->DB->selectwherearray( $row->tablename);
            
            $projecttable_columns = $this->DB->get_tablecolumns( $row->tablename, true, true);
            $excluded_array = array( 'c2p_rowid', 'c2p_postid', 'c2p_use', 'c2p_updated', 'c2p_applied', 'c2p_categories', 'c2p_changecounter' );
            foreach( $excluded_array as $key => $excluded_column){
                if(in_array( $excluded_column, $projecttable_columns) ){
                    unset( $projecttable_columns[$key] );
                }
            }

            $ReceivingTable = new C2P_ImportTableInformation_Table();
            $ReceivingTable->columnarray = $projecttable_columns;
            $ReceivingTable->prepare_items_further( $importedrows,10);    
            ?>

            <?php $postbox_title = basename( $row->path ) .' to ' . $row->tablename;?>
            <?php $form_id = 'importdatatable'.$key;?>
            <a id="anchor_<?php echo $form_id;?>"></a>
            <h4><?php echo $postbox_title; ?></h4>

            <form id="projecttables<?php echo $key;?>" method="get">
            
                <?php $this->UI->hidden_form_values( $form_id, $postbox_title);?>
                <input type="hidden" name="tablename" value="<?php echo $row->tablename;?>">
                <input type="hidden" name="sourceid" value="<?php echo $source_id;?>">
                            
                <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
                <?php $ReceivingTable->display() ?>
            </form><?php 
        }
    }
}?>