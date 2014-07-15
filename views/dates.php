<?php
/**
 * Dates [page]   
 *
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne   
 * @since 8.1.3
 */

// Prohibit direct script loading
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * Dates [page] 
 * 
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne
 * @since 8.1.3
 */
class CSV2POST_Dates_View extends CSV2POST_View {

    /**
     * Number of screen columns for post boxes on this screen
     *
     * @since 8.1.3
     *
     * @var int
     */
    protected $screen_columns = 2;
    
    protected $view_name = 'dates';
    
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
        
        $this->add_meta_box( 'dates-defaultpublishdates', __( 'Default Publish Dates', 'csv2post' ), array( $this, 'postbox_dates_defaultpublishdates' ), 'normal','default',array( 'formid' => 'defaultpublishdates' ) );      
   }
 
    /**
    * post box function
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_dates_defaultpublishdates( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        
        global $c2p_settings;
        ?>  

            <table class="form-table">
                <?php
                // date method
                $publishdatemethod = 'nocurrent123';
                if( isset( $this->projectsettings['dates']['publishdatemethod'] ) ){$publishdatemethod = $this->projectsettings['dates']['publishdatemethod'];}         
                $this->UI->option_radiogroup( __( 'Date Method' ), 'publishdatemethod', 'publishdatemethod', array( 'wordpress' => 'Wordpress', 'data' => __( 'Imported Dates' ), 'incremental' => __( 'Incremental' ), 'random' => __( 'Random' ) ), $publishdatemethod, 'random' );
                
                // imported dates
                $datescolumn_table = ''; 
                $datescolumn_column = '';
                if( isset( $this->projectsettings['dates']['datescolumn']['table'] ) ){$datescolumn_table = $this->projectsettings['dates']['datescolumn']['table'];}
                if( isset( $this->projectsettings['dates']['datescolumn']['column'] ) ){$datescolumn_column = $this->projectsettings['dates']['datescolumn']['column'];}             
                $this->UI->option_projectcolumns( __( 'Pre-Made Dates' ), $c2p_settings['currentproject'], 'datescolumn', 'datescolumn', $datescolumn_table, $datescolumn_column, 'notrequired', 'Not Required' );?>
                
                <!-- Option Start -->
                <tr valign="top">
                    <th scope="row"> Format </th>
                    <td>
                    
                        <?php
                        $dateformat = 'nocurrent123'; 
                        if( isset( $this->projectsettings['dates']['dateformat'] ) ){$dateformat = $this->projectsettings['dates']['dateformat'];}
                        ?>
                        <select name="dateformat" id="dateformat">
                            <option value="noformat" <?php if( $dateformat == 'noformat' ){echo 'selected="selected"';} ?>>Do Not Format (use date data as it is)</option>       
                            <option value="uk" <?php if( $dateformat == 'uk' ){echo 'selected="selected"';} ?>>UK (will be formatted to MySQL standard)</option>
                            <option value="us" <?php if( $dateformat == 'us' ){echo 'selected="selected"';} ?>>US (will be formatted to MySQL standard)</option>
                            <option value="mysql" <?php if( $dateformat == 'mysql' ){echo 'selected="selected"';} ?>>MySQL Standard</option>
                            <option value="unsure" <?php if( $dateformat == 'unsure' ){echo 'selected="selected"';} ?>>Unsure</option>                                                                                                                     
                        </select>
                        
                    </td>
                </tr>
                <!-- Option End --><?php  
            
                // incremental                
                $this->UI->option_subline( __( 'Incremental dates configuration...' ) );
                
                $incrementalstartdate = ''; 
                if( isset( $this->projectsettings['dates']['incrementalstartdate'] ) ){$incrementalstartdate = $this->projectsettings['dates']['incrementalstartdate'];}        
                $this->UI->option_text( __( 'Start Date' ), 'incrementalstartdate', 'incrementalstartdate', $incrementalstartdate, false );
                
                $naturalvariationlow = ''; 
                if( isset( $this->projectsettings['dates']['naturalvariationlow'] ) ){$naturalvariationlow = $this->projectsettings['dates']['naturalvariationlow'];}        
                $this->UI->option_text( __( 'Variation Low' ), 'naturalvariationlow', 'naturalvariationlow', $naturalvariationlow, false );
                
                $naturalvariationhigh = ''; 
                if( isset( $this->projectsettings['dates']['naturalvariationhigh'] ) ){$naturalvariationhigh = $this->projectsettings['dates']['naturalvariationhigh'];}        
                $this->UI->option_text( __( 'Variation High' ), 'naturalvariationhigh', 'naturalvariationhigh', $naturalvariationhigh, false );
                            
                // random
                $this->UI->option_subline( __( 'Random dates configuration...' ) );
                
                $randomdateearliest = ''; 
                if( isset( $this->projectsettings['dates']['randomdateearliest'] ) ){$randomdateearliest = $this->projectsettings['dates']['randomdateearliest'];}        
                $this->UI->option_text( __( 'Earliest Date' ), 'randomdateearliest', 'randomdateearliest', $randomdateearliest, false );
               
                $randomdatelatest = ''; 
                if( isset( $this->projectsettings['dates']['randomdatelatest'] ) ){$randomdatelatest = $this->projectsettings['dates']['randomdatelatest'];}         
                $this->UI->option_text( __( 'Latest Date' ), 'randomdatelatest', 'randomdatelatest', $randomdatelatest, false ); 
                ?>
            </table>
        
        <?php 
        $this->UI->postbox_content_footer();
    }
}?>