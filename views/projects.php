<?php
/**
 * Main [section] - Projects [page]
 * 
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne   
 * @since 8.1.3
 */

// Prohibit direct script loading
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * View class for Main [section] - Projects [page]
 * 
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne
 * @since 8.1.3
 */
class CSV2POST_Projects_View extends CSV2POST_View {

    /**
     * Number of screen columns for post boxes on this screen
     *
     * @since 8.1.3
     *
     * @var int
     */
    protected $screen_columns = 2;
    
    protected $view_name = 'projects';
    
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
        if( isset( $c2p_settings['currentproject'] ) ) {
            $this->project_object = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );
            $this->current_project_settings = maybe_unserialize( $this->project_object->projectsettings );
        }
        
        parent::setup( $action, $data );
        
        $this->add_meta_box( 'projects-allprojects', __( 'All Projects Table', 'csv2post' ), array( $this, 'postbox_projects_allprojectstable' ), 'normal','default',array( 'formid' => 'allprojects' ) );      
        $this->add_meta_box( 'projects-newprojectandnewcsvfiles', __( 'New Project & New CSV Files', 'csv2post' ), array( $this, 'postbox_projects_newprojectandnewcsvfiles' ), 'normal','default',array( 'formid' => 'newprojectandnewcsvfiles' ) );      
        $this->add_meta_box( 'projects-deleteproject', __( 'Delete Project', 'csv2post' ), array( $this, 'postbox_projects_deleteproject' ), 'normal','default',array( 'formid' => 'deleteproject' ) );      
    }
 
    /**
    * post box function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_projects_allprojectstable( $data, $box ) {    
        global $CSV2POST;
        
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        

        $query_results = $CSV2POST->query_projects();
        $ProjectsTable = new C2P_Projects_Table();
        $ProjectsTable->prepare_items( $query_results,5);
        ?>

        <form id="movies-filter" method="get">
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
            <?php $ProjectsTable->display() ?>
        </form>
        
        <?php                
    }  
    
    /**
    * post box function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_projects_newprojectandnewcsvfiles( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        ?>  

            <table class="form-table">
             <?php
                $this->UI->option_text_simple( 'CSV File 1', 'csvfile1', '', true);
                $this->UI->option_text( 'CSV File 2', 'csvfile2', 'csvfile1', '' );
                $this->UI->option_text( 'CSV File 3', 'csvfile3', 'csvfile1', '' );
                $this->UI->option_text( 'CSV File 4', 'csvfile4', 'csvfile1', '' );
                $this->UI->option_text( 'CSV File 5', 'csvfile5', 'csvfile1', '' );                
                $this->UI->option_radiogroup( 'Data Treatment', 'datatreatment', 'datatreatment', array( 'single' => 'Single File (default)', 'join' => 'Join Columns', 'append' => 'Append Rows', 'individual' => 'Individual Tables' ) );                                  
                $this->UI->option_text( 'ID Column', 'uniqueidcolumn', 'uniqueidcolumn', '' );
                $this->UI->option_text( 'Project Name', 'newprojectname', 'newprojectname', '' );
                $this->UI->option_switch( 'Apply Defaults', 'applydefaults', 'applydefaults', false, 'Yes', 'No', 'disabled' );
                
                // offer option to delete an existing table if the file matches one, user needs to enter random number
                $this->UI->option_text( 'Delete Existing Table', 'deleteexistingtable', 'deleteexistingtable',rand(100000,999999), true);
                $this->UI->option_text( 'Enter Code', 'deleteexistingtablecode', 'deleteexistingtablecode', '' );
                ?>
            </table>
        
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
    public function postbox_projects_deleteproject( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        ?>  
                   
            <table class="form-table">
            <?php
                $rand = rand(100000,999999);
                $this->UI->option_text( 'Project ID', 'projectid', 'projectid', '' );
                $this->UI->option_text( 'Code', 'randomcode', 'randomcode', $rand, true);
                $this->UI->option_text( 'Confirm Code', 'confirmcode', 'confirmcode', '' );
            ?>
            </table>
        
        <?php 
        $this->UI->postbox_content_footer();               
    }    
    
}?>