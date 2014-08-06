<?php
/**
 * Beta Test 4 [page]   
 *
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne   
 * @since 8.1.3
 */

// Prohibit direct script loading
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * Beta Test 4 [class] 
 * 
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne
 * @since 8.1.3
 */
class CSV2POST_Betatest4_View extends CSV2POST_View {

    /**
     * Number of screen columns for post boxes on this screen
     *
     * @since 8.1.3
     *
     * @var int
     */
    protected $screen_columns = 2;
    
    protected $view_name = 'betatest4';
    
    /**
    * Set up the view with data and do things that are specific for this view
    *
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.31
    * @version 1.0.0
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
        

        parent::setup( $action, $data );
        
        // introduction to testing
        $this->add_meta_box( 'betatest4-currenttesting', __( 'Test Introduction', 'csv2post' ), array( $this, 'parent' ), 'normal', 'default', array( 'formid' => $this->view_name . 'currenttesting', 'capability' => $this->UI->get_boxes_capability( $this->view_name . 'currenttesting' ) ) );      
        $this->add_meta_box( 'betatest4-guidelines', __( 'Development Guidelines', 'csv2post' ), array( $this, 'parent' ), 'side', 'default', array( 'formid' => $this->view_name . 'guidelines', 'capability' => $this->UI->get_boxes_capability( $this->view_name . 'guidelines' ) ) );      
        $this->add_meta_box( 'betatest4-warning', __( 'Alpha & Beta', 'csv2post' ), array( $this, 'parent' ), 'side', 'default', array( 'formid' => $this->view_name . 'warning', 'capability' => $this->UI->get_boxes_capability( $this->view_name . 'warning' ) ) );      
        
        // test boxes
        $this->add_meta_box( $this->view_name . '-t1', __( 'URL File Import Only - COMPLETE', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => $this->view_name .'t1' ) );      
        $this->add_meta_box( $this->view_name . '-t2', __( 'URL File Import + Create New Data Source - COMPLETE', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => $this->view_name .'t2' ) );      
        $this->add_meta_box( $this->view_name . '-t3', __( 'URL Directory Import (import directory contents)', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => $this->view_name .'t3' ) );      
        $this->add_meta_box( $this->view_name . '-t4', __( 'Form Uploader (basic) - COMPLETE', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => $this->view_name .'t4' ) );      
        $this->add_meta_box( $this->view_name . '-t5', __( 'Form Uploader (optional path) - COMPLETE', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => $this->view_name .'t5' ) );      
        $this->add_meta_box( $this->view_name . '-t6', __( 'New Create Project Form', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => $this->view_name .'t6' ) );      
        //$this->add_meta_box( $this->view_name . '-t7', __( 'Compare Source .csv To New .csv', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => $this->view_name .'t7' ) );      
        $this->add_meta_box( $this->view_name . '-t8', __( 'New Data Source + Monitor Directory Option', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => $this->view_name .'t8' ) );      
        $this->add_meta_box( $this->view_name . '-t9', __( 'New Create Project Form: With Select Template Option', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => $this->view_name .'t9' ) );      
        $this->add_meta_box( $this->view_name . '-t10', __( 'New Create Project Form: Multiple Data Sources', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => $this->view_name .'t10' ) );      
        //$this->add_meta_box( $this->view_name . '-t11', __( 'Create New Data Source + Path Option', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => $this->view_name .'t11' ) );      
        //$this->add_meta_box( $this->view_name . '-t12', __( 'Create New Data Source + Overwrite Option', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => $this->view_name .'t12' ) );      
        //$this->add_meta_box( $this->view_name . '-t13', __( 'Data Source History', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => $this->view_name .'t13' ) );      
        $this->add_meta_box( $this->view_name . '-t14', __( 'Switch To Newer File', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => $this->view_name .'t13' ) );      
        $this->add_meta_box( $this->view_name . '-t15', __( 'Data Source: Multiple Specific .csv File', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => $this->view_name .'t15' ) );      
        $this->add_meta_box( $this->view_name . '-t16', __( 'Data Source: Folder Contents (multiple none specific .csv files)', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => $this->view_name .'t16' ) );      
        //$this->add_meta_box( $this->view_name . '-t17', __( 'Add New .csv File To Directory Type Datasource', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => $this->view_name .'t17' ) );      
        $this->add_meta_box( $this->view_name . '-t18', __( 'Re-Check Source Directory - COMPLETE', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => $this->view_name .'t18' ) );      
        $this->add_meta_box( $this->view_name . '-t19', __( 'URL File Import + Path Field - COMPLETE', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => $this->view_name .'t19' ) );      
        $this->add_meta_box( $this->view_name . '-t20', __( 'URL File Import + Source Selection - COMPLETE', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => $this->view_name .'t20' ) );      
        $this->add_meta_box( $this->view_name . '-t21', __( 'Form Uploader + Select Source - COMPLETE', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => $this->view_name .'t21' ) );      
  
        // permanent information applied to all test pages
        $this->add_meta_box( $this->view_name . '-errors', __( 'Errors', 'csv2post' ), array( $this, 'parent' ), 'side','default',array( 'formid' => $this->view_name . 'errors' ) );            
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
        eval( 'self::postbox_' . $box['args']['formid'] . '( $data, $box );' );
    }
     
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_betatest4currenttesting( $data, $box ) { ?>
        
        <p>Most of the testing here is a variation/improvement of abilities CSV 2 POST already has. A lot of the
        the functionality in CSV 2 POST is hidden. This testing is about creating forms to make use of the functionality
        and making it easier for users to understand.</p>
        
        <p>This page is for testing an improved approach to data sources. I will also need to test the creation of projects
        based on the new approach to creating data sources.</p>
        
        <p>A new class is being created to support file handling. That class will support the coming changes and hold the
        bulk of functions for manage .csv, compressed files and eventualy .xml files.</p>
 
        <?php              
    }

    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_betatest4t1( $data, $box ) {    
        $introduction = __( 'Create and test file transfer from URL i.e. another website, not local.', 'csv2post' );
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title'] );                            
        
        $UI = new C2P_UI();
        
        echo '<table class="form-table">';
        
        $UI->option_text_simple( __( 'URL', 'csv2post' ), 'newdatasourcetheurl','', true, 'URL' );
  
        echo '</table>';
        
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
    public function postbox_betatest4t2( $data, $box ) {                                 
        $introduction = __( 'Using new URL method of importing files, create a new datasource. The plan is for 
        users to create a database before creating a project and put more focus into datasources.', 'csv2post' );
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        
        $UI = new C2P_UI();
        
        echo '<table class="form-table">';
        
            $UI->option_text_simple( __( 'URL', 'csv2post' ), 'newdatasourcetheurl','', true );                
            $this->UI->option_text( __( 'ID Column', 'csv2post' ), 'uniqueidcolumn', 'uniqueidcolumn', '' );
            $this->UI->option_text( __( 'Source Name', 'csv2post' ), 'newprojectname', 'newprojectname', '' );

            // offer option to delete an existing table if the file matches one, user needs to enter random number
            $this->UI->option_text( __( 'Delete Existing Table', 'csv2post' ), 'deleteexistingtable', 'deleteexistingtable',rand(100000,999999), true);
            $this->UI->option_text( __( 'Enter Code', 'csv2post' ), 'deleteexistingtablecode', 'deleteexistingtablecode', '' );
        
        echo '</table>';
        
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
    public function postbox_betatest4t3( $data, $box ) {   
        $introduction = __( 'Import the contents of an external directory, multiple .csv files and put them in a local
        directory. The folder of multiple .csv files will be treated as a datasource but that does not need to be complete
        in this test.', 'csv2post' );
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
                              
        ?>  
        
        <h4>.</h4>
        
        <p>.</p>
 
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
    public function postbox_betatest4t4( $data, $box ) {   
                                 
        $introduction = __( 'Create new single file form upload handler. Do not create datasource at this time. Do not
        offer other options. The file will go into WP default uploader directory in this test.', 'csv2post' );
        
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false, true );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title'] );                            
        
        $UI = new C2P_UI();
        
        echo '<table class="form-table">';
                                                      
        $UI->option_file( __( 'Select .csv File', 'csv2post' ), 'newsourcefileupload', 'newsourcefileupload' );
        
        echo '</table>';
        
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
    public function postbox_betatest4t5( $data, $box ) {                                
        $introduction = __( 'Now test the single file uploader with path field.', 'csv2post' );
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false, true );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title'] );                            
        
        echo '<table class="form-table">';
                                                      
        $this->UI->option_file( __( 'Select .csv File', 'csv2post' ), 'uploadsinglefile', 'uploadsinglefile' );
        $this->UI->option_text_simple( __( 'Path', 'csv2post' ), 'uploadsinglefilepath','', true );
        
        echo '</table>';
        
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
    public function postbox_betatest4t6( $data, $box ) {                                       
        $introduction = 'Create and test a "New Project" form that allows selection of data source.';
         
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        
        $UI = new C2P_UI();
        
        echo '<table class="form-table">';

        $this->UI->option_text( 'Project Name', 'newprojectname', 'newprojectname', '' );
        $this->UI->option_switch( 'Apply Defaults', 'applydefaults', 'applydefaults', false, 'Yes', 'No', 'disabled' );
        $this->UI->option_menu_datasources( 'Data Source', 'newprojectdatasource', 'newprojectdatasource' );
        
        echo '</table>';
        
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
    public function postbox_betatest4t7( $data, $box ) {                                
        $introduction = 'So recently a client replaced an existing .csv file with a new one. Yet despite everything running fine for 
        a couple of weeks. New posts using new rows were blank. This suggests that the new file has changed i.e. a column renamed. Create
        a test which compares old file configuration to the new. Return false on the files not matching. The procedure will be used to prevent
        existing file being replaced and prevent the user screwing things up.';
         
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        
        $UI = new C2P_UI();
        
        echo '<table class="form-table">';

        echo '</table>';
        
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
    public function postbox_betatest4t8( $data, $box ) {                                
        $introduction = 'Create function for monitoring directory and detecting then extracting the contents. This will require
        the folder to be the datasource and all .csv files added to the folder part of that datasource. Do not test handling of new
        file, use another test.';
         
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        
        $UI = new C2P_UI();
        
        echo '<table class="form-table">';

        echo '</table>';
        
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
    public function postbox_betatest4t9( $data, $box ) {                                
        $introduction = 'Add more options to the new Create Project form. Selection of any existing content template, entry of a title template. This
        is a small step to being able to create new projects quickly. Far more is to come on this i.e. using previous project history, theme and 
        installed plugins to automatically configure custom fields.';
         
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        
        $UI = new C2P_UI();
        
        echo '<table class="form-table">';

        echo '</table>';
        
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
    public function postbox_betatest4t10( $data, $box ) {                                
        $introduction = 'Low priority. Allow projects to be created with multiple datasources, pulling data from each of them to 
        create posts. This will allow users to create a database table per .csv file and use them all in a single project.';
         
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        
        $UI = new C2P_UI();
        
        echo '<table class="form-table">';

        echo '</table>';
        
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
    public function postbox_betatest4t11( $data, $box ) {                                
        $introduction = 'Create new datasource with optional path. Local file, URL and file uploader should be on this form. The
        path field allows any of these methods to result in the new .csv file being placed where the user wishes during the creation
        of a new datasource. This should allow a local file to be moved on the server to another location also.';
         
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        
        $UI = new C2P_UI();
        
        echo '<table class="form-table">';

        echo '</table>';
        
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
    public function postbox_betatest4t12( $data, $box ) {                                
        $introduction = 'Create source form with option for replacing an existing file with the same name. Currently auto rename of new file is
        performed. Also add option to rename the existing file instead so that both files can be kept. This procedure should also compare the files
        and warn the user if the replacement files configuration is different. That ability is covered in an earlier test.';
         
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        
        $UI = new C2P_UI();
        
        echo '<table class="form-table">';

        echo '</table>';
        
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
    public function postbox_betatest4t13( $data, $box ) {                                
        $introduction = 'I want to build a datasources history. Record changes in file, why and how the file changed i.e. did the user initiate the
        change using CSV 2 POST. I want to know if users were warned about file configuration being different or not. This may require a new database
        table.';
         
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        
        $UI = new C2P_UI();
        
        echo '<table class="form-table">';

        echo '</table>';
        
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
    public function postbox_betatest4t14( $data, $box ) {                                
        $introduction = 'New data source form with option to tell the plugin to switch to the newest .csv file in a directory, when a directory
        is the datasource (rather than a single file).';
         
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        
        $UI = new C2P_UI();
        
        echo '<table class="form-table">';

        echo '</table>';
        
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
    public function postbox_betatest4t15( $data, $box ) {                                
        $introduction = 'Create form that allows a new datasource to be made with multiple specific .csv files. May need to create 3 forms, one 
        with each file import method.';
         
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        
        $UI = new C2P_UI();
        
        echo '<table class="form-table">';

        echo '</table>';
        
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
    public function postbox_betatest4t16( $data, $box ) {                                
        $introduction = 'Low priority feature but premium. What is more important right now due to client request is switching to the latest
        .csv file within a directory. Create the ability to setup a directory as the datasource main path and every .csv file found within the folder
        is part of the datasource. History for individual files must exist in the datasource history. .';
         
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        
        $UI = new C2P_UI();
        
        echo '<table class="form-table">';

        echo '</table>';
        
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
    public function postbox_betatest4t17( $data, $box ) {                                
        $introduction = 'Create a form for uploading a new .csv file to a directory/folder based datasource. It will probably limit
        the path to those in datasources only. That will be for ease and security. The new .csv file would be placed in the directory
        and triggers initiated to switch to that file. Add option to import any new rows straight away. Add option to create posts
        using new rows straight away. ';
         
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        
        $UI = new C2P_UI();
        
        echo '<table class="form-table">';

        echo '</table>';
        
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
    public function postbox_betatest4t18( $data, $box ) {                                
        $introduction = 'Manual Re-Check of source directory for a newer file. This may not be used but this form
        will at first test the functions involved in detected a newer file, ensuring the newer files configuration is
        the same as the old file and then switching to the new file.';
         
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        
        $UI = new C2P_UI();
        
        echo '<table class="form-table">';

        $this->UI->option_menu_datasources( 'Data Source', 'datasourceidforrecheck', 'datasourceidforrecheck' );
        
        echo '</table>';
        
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
    public function postbox_betatest4t19( $data, $box ) {    
        $introduction = __( 'Create and test file transfer from URL i.e. another website, not local.', 'csv2post' );
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title'] );                            
        
        $UI = new C2P_UI();
        
        echo '<table class="form-table">';
        
        /* notice - this does not create a new datasource, it is the early form for the form that does */
        $UI->option_text_simple( __( 'URL', 'csv2post' ), 'newdatasourcetheurl','', true, 'URL' );
        $UI->option_text_simple( __( 'Path', 'csv2post' ), 'newdatasourcethepath','', true );
        
        echo '</table>';
        
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
    public function postbox_betatest4t20( $data, $box ) {    
        $introduction = __( 'Create and test file transfer from URL i.e. another website, not local.', 'csv2post' );
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title'] );                            
        
        echo '<table class="form-table">';
        
        $this->UI->option_text_simple( __( 'URL', 'csv2post' ), 'newdatasourcetheurl','', true, 'URL' );
        $this->UI->option_menu_datasources( 'Data Source', 'newprojectdatasource', 'newprojectdatasource' );
        
        echo '</table>';
        
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
    public function postbox_betatest4t21( $data, $box ) {                                
        $introduction = __( 'Now test the single file uploader with path field.', 'csv2post' );
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], $introduction, false, true );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title'] );                            
        
        echo '<table class="form-table">';
                                                      
        $this->UI->option_file( __( 'Select .csv File', 'csv2post' ), 'uploadsinglefile', 'uploadsinglefile' );
        $this->UI->option_menu_datasources( 'Data Source', 'datasourcefornewfile', 'datasourcefornewfile' );
        
        echo '</table>';
        
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
    public function postbox_betatest4errors( $data, $box ) {
        ?>
        
        <p>Errors and notices will be experienced in this area. They will show on your servers error log.
        Normally this will happen when you have visited beta testing pages. It does not means the plugin
        is faulty but you may report what you experience. Just keep in mind that some tests are setup for
        my blog and will fail on others unless you edit the PHP i.e. change post or category ID values to 
        match those in your own blog.</p>
        
        <?php 
    }     
    
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */                         
    public function postbox_betatest4guidelines( $data, $box ) {
        ?>
        
        <p>Do not make changes to a metabox already marked with "COMPLETE". We need to keep simplier test as they are for re-testing
        early functions as newer tests use them. Possibly resulting in changes being made and breaking older functionality.
        Please copy and paste the metabox to create a new one then work on that.</p>
        
        <?php 
    }   
     
    
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */                         
    public function postbox_betatest4warning( $data, $box ) {
        ?>
        
        <p>Some tests may be ALPHA and not BETA. The beta term is simply more recognized. In either case
        you should not copy and paste the form or processing function into a live environment. None of the
        code here is considered finished and I myself will work on it again when putting it on the live pages.</p>
        
        <?php 
    }        
}?>