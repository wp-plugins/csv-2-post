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
        $this->project_object = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );
        $this->current_project_settings = maybe_unserialize( $this->project_object->projectsettings );
                
        parent::setup( $action, $data );
        
        $this->add_meta_box( 'table-datatable', __( 'Table', 'csv2post' ), array( $this, 'postbox_table_datatable' ), 'normal','default',array( 'formid' => 'datatable' ) );      
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
        global $CSV2POST, $wpdb, $C2P_WP, $c2p_settings, $C2P_DB, $wpdb, $C2P_UI;

        if(!isset( $c2p_settings['currentproject'] ) || !is_numeric( $c2p_settings['currentproject'] ) ){
            echo "<p class=\"csv2post_boxes_introtext\">". __( 'You have not created a project or somehow a Current Project has not been set.' ) ."</p>";
            return;
        }

        $sourceid_array = $CSV2POST->get_project_sourcesid( $c2p_settings['currentproject'] );

        $tables_already_displayed = array();

        foreach( $sourceid_array as $key => $source_id){

            // get the source row
            $row = $C2P_DB->selectrow( $wpdb->c2psources, 'sourceid = "' . $source_id . '"', 'tablename,path' );

            // avoid displaying the same database table twice
            if(in_array( $row->tablename, $tables_already_displayed) ){
                continue;
            }
            $tables_already_displayed[] = $row->tablename;
            
            $importedrows = $C2P_DB->selectwherearray( $row->tablename);
            
            $projecttable_columns = $C2P_DB->get_tablecolumns( $row->tablename, true, true);
            $excluded_array = array( 'c2p_rowid', 'c2p_postid', 'c2p_use', 'c2p_updated', 'c2p_applied', 'c2p_categories', 'c2p_changecounter' );
            foreach( $excluded_array as $key => $excluded_column){
                if(in_array( $excluded_column, $projecttable_columns) ){
                    unset( $projecttable_columns[$key] );
                }
            }

            $ReceivingTable = new C2P_ImportTableInformation_Table();
            $ReceivingTable->columnarray = $projecttable_columns;
            $ReceivingTable->prepare_items( $importedrows,10);    
            ?>

            <?php $postbox_title = basename( $row->path) .' to ' . $row->tablename;?>
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