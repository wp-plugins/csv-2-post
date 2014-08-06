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
            
            $this->add_meta_box( 'content-defaulttitletemplate', __( 'Default Title Template', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'defaulttitletemplate' ) );      
            $this->add_meta_box( 'content-defaultcontenttemplate', __( 'Default Content Template', 'csv2post' ), array( $this, 'parent' ), 'normal','default',array( 'formid' => 'defaultcontenttemplate' ) );
        
        } else {
            $this->add_meta_box( 'content-nocurrentproject', __( 'No Current Project', 'csv2post' ), array( $this->UI, 'metabox_nocurrentproject' ), 'normal','default',array( 'formid' => 'nocurrentproject' ) );      
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
    public function postbox_content_defaulttitletemplate( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        ?>  

            <table class="form-table">                  
            <?php 
            $titletemplate = ''; 
            if( isset( $this->projectsettings['titles']['defaulttitletemplate'] ) ){$titletemplate = $this->projectsettings['titles']['defaulttitletemplate'];}        
            $this->UI->option_text( 'Title Template', 'defaulttitletemplate', 'defaulttitletemplate', $titletemplate, false, 'csv2post_inputtext',null,null,null,true );
            $this->UI->option_text( '', 'sampletitle', 'sampletitle', '', true, 'csv2post_inputtext' );
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
    public function postbox_content_defaultcontenttemplate( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        ?>  

            <div id="poststuff">
            
                <?php 
                $wysiwygdefaultcontent = ''; 
                if( isset( $this->projectsettings['content']['wysiwygdefaultcontent'] ) ){$wysiwygdefaultcontent = $this->projectsettings['content']['wysiwygdefaultcontent'];} 
                wp_editor( $wysiwygdefaultcontent, 'wysiwygdefaultcontent', array( 'textarea_name' => 'wysiwygdefaultcontent' ) );
                ?>
            
            </div>
            <table class="form-table">
            <?php
            $this->UI->option_radiogroup('Create New Template','createnewtemplate','createnewtemplate',array('no' => 'No','yes' => 'Yes'),null,'no');
            $this->UI->option_text_simple('Title','contenttemplatetitle','',false);
            ?>
            </table>
        
        <?php 
        $this->UI->postbox_content_footer();
    }    
    
}?>