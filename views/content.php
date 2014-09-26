<?php
/**
 * Content [page]   
 *
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne   
 * @since 8.1.3
 */

// Prohibit direct script loading
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * Content [page] 
 * 
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne
 * @since 8.1.3
 */
class CSV2POST_Content_View extends CSV2POST_View {

    /**
     * Number of screen columns for post boxes on this screen
     *
     * @since 8.1.3
     *
     * @var int
     */
    protected $screen_columns = 2;
    
    protected $view_name = 'content';
    
    public $purpose = 'normal';// normal, dashboard

    /**
    * Array of meta boxes, looped through to register them on views and as dashboard widgets
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.33
    * @version 1.0.0
    */
    public function meta_box_array() {
        // array of meta boxes + used to register dashboard widgets (id, title, callback, context, priority, callback arguments (array), dashboard widget (boolean) )   
        return $this->meta_boxes_array = array(
            // array( id, title, callback (usually parent, approach created by Ryan Bayne), context (position), priority, call back arguments array, add to dashboard (boolean), required capability
            array( $this->view_name . '-defaulttitletemplate', __( 'Default Title Template', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'defaulttitletemplate' ), true, 'activate_plugins' ),
            array( $this->view_name . '-defaultcontenttemplate', __( 'Default Content Template', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'defaultcontenttemplate' ), true, 'activate_plugins' ),
            array( $this->view_name . '-2000freehours', __( '2000 Free Hours', 'csv2post' ), array( $this, 'parent' ), 'side','default',array( 'formid' => '2000freehours' ), true, 'activate_plugins' ),
        );    
    }
        
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
            if( !$this->project_object ) {
                $this->current_project_settings = false;
            } else {
                $this->current_project_settings = maybe_unserialize( $this->project_object->projectsettings ); 
            }
       
            parent::setup( $action, $data );
            
            // using array register many meta boxes
            foreach( self::meta_box_array() as $key => $metabox ) {
                // the $metabox array includes required capability to view the meta box
                if( isset( $metabox[7] ) && current_user_can( $metabox[7] ) ) {
                    $this->add_meta_box( $metabox[0], $metabox[1], $metabox[2], $metabox[3], $metabox[4], $metabox[5] );   
                }               
            }
                    
        } else {
            $this->add_meta_box( 'content-nocurrentproject', __( 'No Current Project', 'csv2post' ), array( $this->UI, 'metabox_nocurrentproject' ), 'normal','default',array( 'formid' => 'nocurrentproject' ) );      
        }    
    }

    /**
    * Outputs the meta boxes
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.33
    * @version 1.0.0
    */
    public function metaboxes() {
        parent::register_metaboxes( self::meta_box_array() );     
    }

    /**
    * This function is called when on WP core dashboard and it adds widgets to the dashboard using
    * the meta box functions in this class. 
    * 
    * @uses dashboard_widgets() in parent class CSV2POST_View which loops through meta boxes and registeres widgets
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.33
    * @version 1.0.0
    */
    public function dashboard() { 
        parent::dashboard_widgets( self::meta_box_array() );  
    }
     
    /**
    * All add_meta_box() callback to this function to keep the add_meta_box() call simple.
    * 
    * This function also offers a place to apply more security or arguments.
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.32
    * @version 1.0.1
    */
    function parent( $data, $box ) {
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
    public function postbox_content_defaulttitletemplate( $data, $box ) {    
        global $wpdb,$c2p_settings;
        
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( 'Enter Column Replacement Tokens to create a template. On submission an example will be created providing you have imported some of your .csv files rows.', 'csv2post' ), false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        ?>  
                       
            <table class="form-table">                  
            <?php 
            // set the default value and generate a sample title using a random row of imported data
            $titletemplate = ''; 
            $generated_title = '';
            if( isset( $this->current_project_settings['titles']['defaulttitletemplate'] ) ){
                $titletemplate = $this->current_project_settings['titles']['defaulttitletemplate'];
                $generated_title = $titletemplate;
                
                // build example title - need to get projects source ID's
                $sourceid_array = $this->CSV2POST->get_project_sourcesid( $c2p_settings['currentproject'] );

                // for multiple table sources, track which tables have been queried
                $tables_already_used = array();

                // loop through source ID's
                foreach( $sourceid_array as $key => $source_id ){

                    // get the source row for the current ID
                    $row = $this->DB->selectrow( $wpdb->c2psources, 'sourceid = "' . $source_id . '"', 'tablename' );

                    // avoid using same database table twice
                    if( in_array( $row->tablename, $tables_already_used ) ){
                        continue;
                    }
                    
                    $tables_already_used[] = $row->tablename;
                                   
                    $result = $this->DB->selectorderby( $row->tablename, null, 'c2p_rowid', '*', 20, ARRAY_A );
                }
                
                $rand_max = count( $result ) - 1;
                
                $projectcolumns = $this->CSV2POST->get_project_columns_from_db( $c2p_settings['currentproject'] );
                
                foreach( $result[ rand( 1, $rand_max ) ] as $a_column => $imported_data_value ){  
                    foreach( $projectcolumns as $table_name => $columnfromdb ){            
                        $generated_title = str_replace( '#'. $a_column . '#', $imported_data_value, $generated_title );
                    }    
                }    
            }

            $this->UI->option_text( __( 'Title Template', 'csv2post' ), 'defaulttitletemplate', 'defaulttitletemplate', $titletemplate, false, 'csv2post_inputtext',null,null,null,true );
            $this->UI->option_text( __( 'Title Sample', 'csv2post' ), 'sampletitle', 'sampletitle', $generated_title, true, 'csv2post_inputtext' );
            ?>
            </table>
        
        <?php 
        $this->UI->postbox_content_footer();
    }    
    
    /**
    * Form for creating the default content template, the design stored in project settings not just as a post type.
    * This is for users who do not want the post type for content templates to be registered in the blog.
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_content_defaultcontenttemplate( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( 'This is the first editor you should used. If you do not plan to create multiple templates in a more advanced project, this is the only editor you need to use.', 'csv2post' ), false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        ?>  
            <div id="poststuff">
            
                <?php 
                $wysiwygdefaultcontent = ''; 
                if( isset( $this->current_project_settings['content']['wysiwygdefaultcontent'] ) ){
                    $wysiwygdefaultcontent = $this->current_project_settings['content']['wysiwygdefaultcontent'];
                } 
                wp_editor( $wysiwygdefaultcontent, 'wysiwygdefaultcontent', array( 'textarea_name' => 'wysiwygdefaultcontent' ) );
                ?>
            
            </div>
            
            <br>
            
        <?php 
        $this->UI->postbox_content_footer();
    }   
    
    /**
    * 2000 Free Hours side box
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.33
    * @version 1.0.0
    */
    public function postbox_content_2000freehours() {
        echo '<p>' . __( 'Over 2000 unpaid hours have gone into providing a free edition and 
        providing free support. This is how a Wordpress developer like Ryan Bayne gives something 
        back to the Wordpress community. However it needs your support in return. Everything from a Facebook
        like to a short review will help this project.', 'csv2post' ) . '</p>';
    }      
}?>