<?php
/**
 * Post Creation Tools [page]   
 *
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne   
 * @since 8.1.3
 */

// Prohibit direct script loading
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * Post Creation Tools [page] 
 * 
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne
 * @since 8.1.3
 */
class CSV2POST_Tools_View extends CSV2POST_View {

    /**
     * Number of screen columns for post boxes on this screen
     *
     * @since 8.1.3
     *
     * @var int
     */
    protected $screen_columns = 2;
    
    protected $view_name = 'tools';
    
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
            array( 'tools-createpostsbasic', __( 'Create Posts', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'createpostsbasic' ), true, 'activate_plugins' ),
            array( 'tools-updatespecificpost', __( 'Update Specific Post', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'updatespecificpost' ), true, 'activate_plugins' ),
            array( 'tools-queryduplicateposts', __( 'Delete Duplicate Posts', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'queryduplicateposts' ), true, 'activate_plugins' ),
            array( 'tools-undoprojectposts', __( 'Undo Projects Posts', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'undoprojectposts' ), true, 'activate_plugins' ),
            array( 'tools-resetimportedrows', __( 'Reset Imported Rows', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'resetimportedrows' ), true, 'activate_plugins' ),
            array( 'tools-proeditionupdating', __( 'Pro Edition Update Power', 'csv2post' ), array( $this, 'parent' ), 'side','default',array( 'formid' => 'proeditionupdating' ), true, 'activate_plugins' ),
            array( 'tools-recreatemissingposts', __( 'Re-Create Missing Posts', 'csv2post' ), array( $this, 'parent' ), 'side','default',array( 'formid' => 'recreatemissingposts' ), true, 'activate_plugins' )
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

            // only output meta boxes
            if( $this->purpose == 'normal' ) {
                self::metaboxes();
            } elseif( $this->purpose == 'dashboard' ) {
                //self::dashboard();
            } elseif( $this->purpose == 'customdashboard' ) {
                return self::meta_box_array();
            } else {
                // do nothing - can call metaboxes() manually and place them 
            }        
              
       } else {
            $this->add_meta_box( 'tools-nocurrentproject', __( 'No Current Project', 'csv2post' ), array( $this->UI, 'metabox_nocurrentproject' ), 'normal','default',array( 'formid' => 'nocurrentproject' ) );      
       }
    }
     
    /**
    * Outputs the meta boxes
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 0.0.3
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
    * @since 0.0.2
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
    * post box function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_tools_createpostsbasic( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( 'Import your data, create a title template, a content template and your ready to use this form. Enter the number of posts you would like to create. Start with small numbers to test your project settings.', 'csv2post' ), false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        ?>  

            <table class="form-table">
            <?php $this->UI->option_text( __( 'Total Posts' ), 'totalposts', 'totalposts', '1' )?>
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
    public function postbox_tools_updatepostsbasic( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( 'Update posts where applicable. This will only update posts if a change of settings or data has occurred.', 'csv2post' ), false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        ?>  

            <table class="form-table">
            <?php $this->UI->option_text( __( 'Total Posts' ), 'totalposts', 'totalposts', '1' )?>
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
    public function postbox_tools_updatepostsbasicnewdataonly( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( 'Update posts created by the current project if the imported record used to create them has been updated.', 'csv2post' ), false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        ?>  

            <table class="form-table">
            <?php $this->UI->option_text( __( 'Total Posts' ), 'totalposts', 'totalposts', '1' )?>
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
    public function postbox_tools_updatepostsbasicprojectchangesonly( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( 'Update posts that have not been updated since the current projects settings were changed.', 'csv2post' ), false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        ?>  

            <table class="form-table">
            <?php $this->UI->option_text( __( 'Total Posts' ), 'totalposts', 'totalposts', '1' )?>
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
    public function postbox_tools_updatespecificpost( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( 'Enter the ID of a post created by CSV 2 POST to initiate an update. This is a great way to test your updating configuration.', 'csv2post' ), false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        ?>  

            <table class="form-table">
            <?php $this->UI->option_text( __( 'Post ID' ), 'updatespecificpostid', 'updatespecificpostid', '1' );?>
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
    public function postbox_tools_queryduplicateposts( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( 'If you suspect your .csv file contains duplicate rows you can use this to find the resulting duplicate posts then delete one of them.', 'csv2post' ), false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        ?>  

            <table class="form-table">
            
            <tr valign="top">
                <th scope="row">Force Delete (do not use trash)</th>
                <td><?php $this->UI->option_checkbox_single( 'forcedelete', 'Yes', 'forcedelete', true);?></td>
            </tr>
            
            <?php $this->UI->option_subline( __( 'Post Title' ) );?>
            <?php $this->UI->option_text( __( 'Safety Code' ), 'deletetduplicatebytitlecode', 'deletetduplicatebytitlecode',rand(99,9999), true);?>
            <?php $this->UI->option_text( __( 'Confirm Code' ), 'deletetduplicatebytitleconfirm', 'deletetduplicatebytitleconfirm', '' );?>            
            
            <?php $this->UI->option_subline( __( 'One Post Per Row' ) );?>
            <?php $this->UI->option_text( __( 'Safety Code' ), 'deleteduplicatepostssafetycode', 'deleteduplicatepostssafetycode',rand(99,9999), true);?>
            <?php $this->UI->option_text( __( 'Confirm Code' ), 'safetycodeconfirmed', 'safetycodeconfirmed', '' );?>
            
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
    public function postbox_tools_refreshallposts( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( 'If your using Systematic Post Updating you can force an update on all posts for the current active project you are working on by submitting this form.', 'csv2post' ), false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
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
    public function postbox_tools_undoprojectposts( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( 'Delete posts created by the current project. Currently has a restriction to be safe but it can easily inreased by editing source or the tools.php view file.', 'csv2post' ), false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        ?>  

            <table class="form-table">
            <tr valign="top">
                <th scope="row">Force Delete (do not use trash)</th>
                <td><?php $this->UI->option_checkbox_single( 'forcedelete', 'Yes', 'forcedelete', true);?></td>
            </tr>            
            <?php $this->UI->option_text( __( 'Limit' ), 'undopostslimit', 'undopostslimit', 50, true);?>
            <?php $this->UI->option_text( __( 'Safety Code' ), 'undoallpostssafecode', 'undoallpostssafecode',rand(9999,99999), true);?>
            <?php $this->UI->option_text_simple( __( 'Confirm Code' ), 'undoallpostsconfirm', '', __( 'Please enter the random number shown above this field.' ) );?>
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
    public function postbox_tools_resetimportedrows( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( 'Delete 100% of the data imported for the current projects data source/s. Please use with care.', 'csv2post' ), false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']); 
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
    public function postbox_tools_proeditionupdating( $data, $box ) {    
        echo '<p>';
        
        _e( 'In 2014 I added the plugins first post update feature to the free edition. This is because the pro
        edition updating ability continues to improve. I always promised that the free edition will be improved
        as the pro edition grows. This is my policy to ensure WebTechGlobal continues to give back to the Wordpress
        community.', 'csv2post' );
        
        echo '</p>';
        
        echo '<p>' . __( 'Visit the', 'csv2post' ) . ' <a href="" target="_blank" title="' . __( 'Go to the WebTechGlobal website and browse the CSV 2 POST portal.', 'csv2post' ) . '">' . __( 'CSV 2 POST Portal', 'csv2post' ) . '</a> to read more or buy.</p>';
        
        echo '<p>';
        
        _e( ' The pro edition has a systematic update
        ability meaning when someone visits a post on your blog. The post will be updated if out of date compared to
        your imported data. The visitor will see the new version of the post, neat huh. This means updating hundreds of
        thousands of posts in a single blog becomes an easier task especially on low cost hosting which do not allow
        more than a few hundred posts to be updated at once.', 'csv2post' );
        
        echo '</p>';
    } 
    
    /**
    * Locates imported rows that are meant to have a post but the post cannot be found.
    * 1. Re-creating the posts is optional
    * 2. Total missing posts is confirmed after subsmission
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.33
    * @version 1.0.0
    */
    public function postbox_tools_recreatemissingposts( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], __( 'If admin accidently deletes posts created by CSV 2 POST you will need to go through the correct repair process. Tools like this are to help avoid it being a complex and time consuming task. This processes will query the database one or more times per record imported. This may only work with 200 or less missing posts. Contact WebTechGlobal for consultation if you are dealing with a far greater number of accidently deleted posts.', 'csv2post' ), false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']); 
        ?>  

            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php _e( 'Re-Create Posts', 'csv2post' ); ?></th>
                    <td><?php $this->UI->option_checkbox_single( 'recreatemissingposts', __( 'Yes', 'csv2post' ), 'recreatemissingpostsyes', 'off', 1 );?></td>
                </tr>            
            </table>
        
        <?php       
        $this->UI->postbox_content_footer();
    } 
}?>