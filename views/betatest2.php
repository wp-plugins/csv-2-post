<?php
/**
 * Beta Test 2 [page]   
 *
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne   
 * @since 8.1.3
 */

// Prohibit direct script loading
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * Beta Test 2 [class] 
 * 
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne
 * @since 8.1.3
 */
class CSV2POST_Betatest2_View extends CSV2POST_View {

    /**
     * Number of screen columns for post boxes on this screen
     *
     * @since 8.1.3
     *
     * @var int
     */
    protected $screen_columns = 2;
    
    protected $view_name = 'betatest2';
    
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
            
            // introduction to testing
            $this->add_meta_box( 'betatest2-currenttesting', __( 'Test Introduction', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'currenttesting' ) );      
            
            // test boxes
            $this->add_meta_box( 'betatest2-t1', __( 'Test A', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 't1' ) );      
            $this->add_meta_box( 'betatest2-t2', __( 'WP Pointer Test', 'csv2post' ), array( $this, 'parent' ), 'side','default',array( 'formid' => 't2' ) );      
     
            // permanent information applied to all test pages
            $this->add_meta_box( 'betatest2-errors', __( 'Errors', 'csv2post' ), array( $this, 'parent' ), 'side','default',array( 'formid' => 'errors' ) );          

            $pointer = new C2P_Pointers('mypointer3', 'csv2postpointer1', 'My Pointers Title', 'This pointer will not stay hidden. Indicating the Ajax process is not updating user meta with closed pointers.');
            $pointer->add_action();
            
        } else {
            $this->add_meta_box( 'betatest2-nocurrentproject', __( 'No Current Project', 'csv2post' ), array( $this->UI, 'metabox_nocurrentproject' ), 'normal','default',array( 'formid' => 'nocurrentproject' ) );      
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
    public function postbox_betatest2_currenttesting( $data, $box ) {         
        ?>
        <p>Currently testing post-boxes, three column layout option in Screen Options, dynamically generated help content
        which can be found in the Help tab and when clicking on Information icon in post-boxes. Those may not be seen
        on here for sometime. They were in the plugin, you will see them in current videos but they had to be removed
        pending completion of the new help content management tool on WebTechGlobal.</p>
        
        <p>More information and discussion about this test visit the <a href="http://forum.webtechglobal.co.uk/viewtopic.php?f=8&t=33">WebTechGlobal forum.</a></p>                                                                    
        
        <h4>The following work and tests are to be carried out...</h4>
        
        <ol>
            <li>Add a third column, with 3rd option in Screen Options to hide and display it.</li>
            <li>Possibly add the full width box as seen on dashboard.</li>
            <li>Re-add the information and video icons using the new help content management system.</li>
            <li>Ensure help content for the current page is displayed in the WP Help tab.</li>
        </ol>
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
    public function postbox_betatest2_t1( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        ?>  

            <table class="form-table">                  
            <?php 
            
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
    public function postbox_betatest2_t2( $data, $box ) {                                 
        ?>  

        <p>I have written a class called C2P_Pointers. At first it seem to work. I was sure I tested the Dismiss and the
        pointer stayed hidden but it no longer works. I had to finish the class by passing parameters and since then pointers
        will not stay hidden. So the testing here is any changes intended to fix it. You should see a pointer below.</p>
        
        <p>Try this class https://github.com/rawcreative/wp-help-pointers/blob/master/class.wp-help-pointers.php however it is
        2 years old. It appears to do things the core already does i.e. checking user meta for closed pointers.</p>
        
        <p id="mypointer3"></p>
        
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
    public function postbox_betatest1_t3( $data, $box ) {                                
        ?>  
        
        <h4>Test Name</h4>
            
        
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
    public function postbox_betatest1_t4( $data, $box ) {                                
        ?>  
        
        <h4>Test Name</h4>
            
        
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
    public function postbox_betatest1_t5( $data, $box ) {                                
        ?>  
        
        <h4>Test Name</h4>
            
        
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
    public function postbox_betatest1_t6( $data, $box ) {                                
        ?>  
        
        <h4>Test Name</h4>
            
        
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
    public function postbox_betatest1_t7( $data, $box ) {                                
        ?>  
        
        <h4>Test Name</h4>
            
        
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
    public function postbox_betatest1_t8( $data, $box ) {                                
        ?>  
        
        <h4>Test Name</h4>
            
        
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
    public function postbox_betatest1_t9( $data, $box ) {                                
        ?>  
        
        <h4>Test Name</h4>
            
        
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
    public function postbox_betatest1_t10( $data, $box ) {                                
        ?>  
        
        <h4>Test Name</h4>
            
        
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
    public function postbox_betatest2_errors( $data, $box ) {
        ?>
        
        <p>Errors and notices will be experienced in this area. They will show on your servers error log.
        Normally this will happen when you have visited beta testing pages. It does not means the plugin
        is faulty but you may report what you experience. Just keep in mind that some tests are setup for
        my blog and will fail on others unless you edit the PHP i.e. change post or category ID values to 
        match those in your own blog.</p>
        
        <?php 
    }        
}?>