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
        $this->project_object = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );
        $this->current_project_settings = maybe_unserialize( $this->project_object->projectsettings );
                
        parent::setup( $action, $data );
        
        $this->add_meta_box( 'content-defaulttitletemplate', __( 'Default Title Template', 'csv2post' ), array( $this, 'postbox_content_defaulttitletemplate' ), 'normal','default',array( 'formid' => 'defaulttitletemplate' ) );      
        $this->add_meta_box( 'content-defaultcontenttemplate', __( 'Default Content Template', 'csv2post' ), array( $this, 'postbox_content_defaultcontenttemplate' ), 'normal','default',array( 'formid' => 'defaultcontenttemplate' ) );
        $this->add_meta_box( 'content-multipledesignsrules', __( 'Multiple Design Rules', 'csv2post' ), array( $this, 'postbox_content_multipledesignsrules' ), 'normal','default',array( 'formid' => 'multipledesignsrules' ) );
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
        
    /**
    * post box function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_content_multipledesignsrules( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        
        global $c2p_settings;
        ?>  

            <table class="form-table">
            <?php
            for( $i=1;$i<=3;$i++){
                
                // design rules data
                $designrulecolumn_table = ''; 
                $designrulecolumn_column = '';
                if( isset( $this->projectsettings['content']["designrulecolumn$i"]['table'] ) ){$designrulecolumn_table = $this->projectsettings['content']["designrulecolumn$i"]['table'];}
                if( isset( $this->projectsettings['content']["designrulecolumn$i"]['column'] ) ){$designrulecolumn_column = $this->projectsettings['content']["designrulecolumn$i"]['column'];}             
                $this->UI->option_projectcolumns( __( 'Data' ), $c2p_settings['currentproject'], "designrulecolumn$i", "designrulecolumn$i", $designrulecolumn_table, $designrulecolumn_column, 'notrequired', 'Not Required' );
    
                $designrulecolumn = ''; 
                if( isset( $this->projectsettings['content']["designruletrigger$i"] ) ){$designrulecolumn = $this->projectsettings['content']["designruletrigger$i"];}            
                $this->UI->option_text( "Trigger $i", "designruletrigger$i", "designruletrigger$i", $designrulecolumn, false );
                
                $designtemplate = 'nocurrent123'; 
                if( isset( $this->projectsettings['content']["designtemplate$i"] ) ){$designtemplate = $this->projectsettings['content']["designtemplate$i"];}            
                $this->UI->option_menu_posttemplates( "Design $i", "designtemplate$i", "designtemplate$i", $designtemplate); 
            }
            ?>
            </table>
        
        <?php 
        $this->UI->postbox_content_footer();
    }       
}?>