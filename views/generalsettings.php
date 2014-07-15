<?php
/**
 * Testers [page]   
 *
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne   
 * @since 8.1.3
 */

// Prohibit direct script loading
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * View class for Beta Testing [page] 
 * 
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne
 * @since 8.1.3
 */
class CSV2POST_Generalsettings_View extends CSV2POST_View {

    /**
     * Number of screen columns for post boxes on this screen
     *
     * @since 8.1.3
     *
     * @var int
     */
    protected $screen_columns = 2;
    
    protected $view_name = 'generalsettings';
    
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
        
        // get schedule array 
        $this->schedule = CSV2POST::get_option_schedule_array();
                
        parent::setup( $action, $data );
        
        $this->add_meta_box( 'generalsettings-globaldatasettings', __( 'Global Data Settings', 'csv2post' ), array( $this, 'postbox_generalsettings_globaldatasettings' ), 'normal','default',array( 'formid' => 'globaldatasettings' ) );      
        $this->add_meta_box( 'generalsettings-logsettings', __( 'Log Settings', 'csv2post' ), array( $this, 'postbox_generalsettings_logsettings' ), 'normal','default',array( 'formid' => 'logsettings' ) );      

    }

        /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_generalsettings_globaldatasettings( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        
        global $c2p_settings;
        ?>  

            <table class="form-table">
            <?php
            $this->UI->option_text( 'Import/Insert Limit', 'importlimit', 'importlimit', $c2p_settings['datasettings']['insertlimit'], false );
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
    public function postbox_generalsettings_logsettings( $data, $box ) {    
        $this->UI->postbox_content_header( $box['title'], $box['args']['formid'], false, false );        
        $this->UI->hidden_form_values( $box['args']['formid'], $box['title']);
        
        global $c2p_settings;
        ?>  

            <table class="form-table">
                <!-- Option Start -->
                <tr valign="top">
                    <th scope="row">Log</th>
                    <td>
                        <?php 
                        // if is not set ['admintriggers']['newcsvfiles']['status'] then it is enabled by default
                        if(!isset( $c2p_settings['globalsettings']['uselog'] ) ){
                            $radio1_uselog_enabled = 'checked'; 
                            $radio2_uselog_disabled = '';                    
                        }else{
                            if( $c2p_settings['globalsettings']['uselog'] == 1){
                                $radio1_uselog_enabled = 'checked'; 
                                $radio2_uselog_disabled = '';    
                            }elseif( $c2p_settings['globalsettings']['uselog'] == 0){
                                $radio1_uselog_enabled = ''; 
                                $radio2_uselog_disabled = 'checked';    
                            }
                        }?>
                        <fieldset><legend class="screen-reader-text"><span>Log</span></legend>
                            <input type="radio" id="logstatus_enabled" name="csv2post_radiogroup_logstatus" value="1" <?php echo $radio1_uselog_enabled;?> />
                            <label for="logstatus_enabled"> <?php _e( 'Enable', 'csv2post' ); ?></label>
                            <br />
                            <input type="radio" id="logstatus_disabled" name="csv2post_radiogroup_logstatus" value="0" <?php echo $radio2_uselog_disabled;?> />
                            <label for="logstatus_disabled"> <?php _e( 'Disable', 'csv2post' ); ?></label>
                        </fieldset>
                    </td>
                </tr>
                <!-- Option End -->
      
                <?php       
                // log rows limit
                if(!isset( $c2p_settings['globalsettings']['loglimit'] ) || !is_numeric( $c2p_settings['globalsettings']['loglimit'] ) ){$c2p_settings['globalsettings']['loglimit'] = 1000;}
                $this->UI->option_text( 'Log Entries Limit', 'csv2post_loglimit', 'loglimit', $c2p_settings['globalsettings']['loglimit'] );
                ?>
            </table> 
            
                    
            <h4>Outcomes</h4>
            <label for="csv2post_log_outcomes_success"><input type="checkbox" name="csv2post_log_outcome[]" id="csv2post_log_outcomes_success" value="1" <?php if( isset( $c2p_settings['logsettings']['logscreen']['outcomecriteria']['1'] ) ){echo 'checked';} ?>> Success</label>
            <br> 
            <label for="csv2post_log_outcomes_fail"><input type="checkbox" name="csv2post_log_outcome[]" id="csv2post_log_outcomes_fail" value="0" <?php if( isset( $c2p_settings['logsettings']['logscreen']['outcomecriteria']['0'] ) ){echo 'checked';} ?>> Fail/Rejected</label>

            <h4>Type</h4>
            <label for="csv2post_log_type_general"><input type="checkbox" name="csv2post_log_type[]" id="csv2post_log_type_general" value="general" <?php if( isset( $c2p_settings['logsettings']['logscreen']['typecriteria']['general'] ) ){echo 'checked';} ?>> General</label>
            <br>
            <label for="csv2post_log_type_error"><input type="checkbox" name="csv2post_log_type[]" id="csv2post_log_type_error" value="error" <?php if( isset( $c2p_settings['logsettings']['logscreen']['typecriteria']['error'] ) ){echo 'checked';} ?>> Errors</label>
            <br>
            <label for="csv2post_log_type_trace"><input type="checkbox" name="csv2post_log_type[]" id="csv2post_log_type_trace" value="flag" <?php if( isset( $c2p_settings['logsettings']['logscreen']['typecriteria']['flag'] ) ){echo 'checked';} ?>> Trace</label>

            <h4>Priority</h4>
            <label for="csv2post_log_priority_low"><input type="checkbox" name="csv2post_log_priority[]" id="csv2post_log_priority_low" value="low" <?php if( isset( $c2p_settings['logsettings']['logscreen']['prioritycriteria']['low'] ) ){echo 'checked';} ?>> Low</label>
            <br>
            <label for="csv2post_log_priority_normal"><input type="checkbox" name="csv2post_log_priority[]" id="csv2post_log_priority_normal" value="normal" <?php if( isset( $c2p_settings['logsettings']['logscreen']['prioritycriteria']['normal'] ) ){echo 'checked';} ?>> Normal</label>
            <br>
            <label for="csv2post_log_priority_high"><input type="checkbox" name="csv2post_log_priority[]" id="csv2post_log_priority_high" value="high" <?php if( isset( $c2p_settings['logsettings']['logscreen']['prioritycriteria']['high'] ) ){echo 'checked';} ?>> High</label>
            
            <h1>Custom Search</h1>
            <p>This search criteria is not currently stored, it will be used on the submission of this form only.</p>
         
            <h4>Page</h4>
            <select name="csv2post_pluginpages_logsearch" id="csv2post_pluginpages_logsearch" >
                <option value="notselected">Do Not Apply</option>
                <?php
                $current = '';
                if( isset( $c2p_settings['logsettings']['logscreen']['page'] ) && $c2p_settings['logsettings']['logscreen']['page'] != 'notselected' ){
                    $current = $c2p_settings['logsettings']['logscreen']['page'];
                } 
                $this->UI->page_menuoptions( $current);?> 
            </select>
            
            <h4>Action</h4> 
            <select name="csv2pos_logactions_logsearch" id="csv2pos_logactions_logsearch" >
                <option value="notselected">Do Not Apply</option>
                <?php 
                $current = '';
                if( isset( $c2p_settings['logsettings']['logscreen']['action'] ) && $c2p_settings['logsettings']['logscreen']['action'] != 'notselected' ){
                    $current = $c2p_settings['logsettings']['logscreen']['action'];
                }
                $action_results = C2P_DB::log_queryactions( $current);
                if( $action_results){
                    foreach( $action_results as $key => $action){
                        $selected = '';
                        if( $action['action'] == $current){
                            $selected = 'selected="selected"';
                        }
                        echo '<option value="'.$action['action'].'" '.$selected.'>'.$action['action'].'</option>'; 
                    }   
                }?> 
            </select>
            
            <h4>Screen Name</h4>
            <select name="csv2post_pluginscreens_logsearch" id="csv2post_pluginscreens_logsearch" >
                <option value="notselected">Do Not Apply</option>
                <?php 
                $current = '';
                if( isset( $c2p_settings['logsettings']['logscreen']['screen'] ) && $c2p_settings['logsettings']['logscreen']['screen'] != 'notselected' ){
                    $current = $c2p_settings['logsettings']['logscreen']['screen'];
                }
                $this->UI->screens_menuoptions( $current);?> 
            </select>
                  
            <h4>PHP Line</h4>
            <input type="text" name="csv2post_logcriteria_phpline" value="<?php if( isset( $c2p_settings['logsettings']['logscreen']['line'] ) ){echo $c2p_settings['logsettings']['logscreen']['line'];} ?>">
            
            <h4>PHP File</h4>
            <input type="text" name="csv2post_logcriteria_phpfile" value="<?php if( isset( $c2p_settings['logsettings']['logscreen']['file'] ) ){echo $c2p_settings['logsettings']['logscreen']['file'];} ?>">
            
            <h4>PHP Function</h4>
            <input type="text" name="csv2post_logcriteria_phpfunction" value="<?php if( isset( $c2p_settings['logsettings']['logscreen']['function'] ) ){echo $c2p_settings['logsettings']['logscreen']['function'];} ?>">
            
            <h4>Panel Name</h4>
            <input type="text" name="csv2post_logcriteria_panelname" value="<?php if( isset( $c2p_settings['logsettings']['logscreen']['panelname'] ) ){echo $c2p_settings['logsettings']['logscreen']['panelname'];} ?>">

            <h4>IP Address</h4>
            <input type="text" name="csv2post_logcriteria_ipaddress" value="<?php if( isset( $c2p_settings['logsettings']['logscreen']['ipaddress'] ) ){echo $c2p_settings['logsettings']['logscreen']['ipaddress'];} ?>">
           
            <h4>User ID</h4>
            <input type="text" name="csv2post_logcriteria_userid" value="<?php if( isset( $c2p_settings['logsettings']['logscreen']['userid'] ) ){echo $c2p_settings['logsettings']['logscreen']['userid'];} ?>">    
          
            <h4>Display Fields</h4>                                                                                                                                        
            <label for="csv2post_logfields_outcome"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_outcome" value="outcome" <?php if( isset( $c2p_settings['logsettings']['logscreen']['displayedcolumns']['outcome'] ) ){echo 'checked';} ?>> <?php _e( 'Outcome', 'csv2post' );?></label>
            <br>
            <label for="csv2post_logfields_line"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_line" value="line" <?php if( isset( $c2p_settings['logsettings']['logscreen']['displayedcolumns']['line'] ) ){echo 'checked';} ?>> <?php _e( 'Line', 'csv2post' );?></label>
            <br>
            <label for="csv2post_logfields_file"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_file" value="file" <?php if( isset( $c2p_settings['logsettings']['logscreen']['displayedcolumns']['file'] ) ){echo 'checked';} ?>> <?php _e( 'File', 'csv2post' );?></label> 
            <br>
            <label for="csv2post_logfields_function"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_function" value="function" <?php if( isset( $c2p_settings['logsettings']['logscreen']['displayedcolumns']['function'] ) ){echo 'checked';} ?>> <?php _e( 'Function', 'csv2post' );?></label>
            <br>
            <label for="csv2post_logfields_sqlresult"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_sqlresult" value="sqlresult" <?php if( isset( $c2p_settings['logsettings']['logscreen']['displayedcolumns']['sqlresult'] ) ){echo 'checked';} ?>> <?php _e( 'SQL Result', 'csv2post' );?></label>
            <br>
            <label for="csv2post_logfields_sqlquery"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_sqlquery" value="sqlquery" <?php if( isset( $c2p_settings['logsettings']['logscreen']['displayedcolumns']['sqlquery'] ) ){echo 'checked';} ?>> <?php _e( 'SQL Query', 'csv2post' );?></label>
            <br>
            <label for="csv2post_logfields_sqlerror"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_sqlerror" value="sqlerror" <?php if( isset( $c2p_settings['logsettings']['logscreen']['displayedcolumns']['sqlerror'] ) ){echo 'checked';} ?>> <?php _e( 'SQL Error', 'csv2post' );?></label>
            <br>
            <label for="csv2post_logfields_wordpresserror"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_wordpresserror" value="wordpresserror" <?php if( isset( $c2p_settings['logsettings']['logscreen']['displayedcolumns']['wordpresserror'] ) ){echo 'checked';} ?>> <?php _e( 'Wordpress Erro', 'csv2post' );?>r</label>
            <br>
            <label for="csv2post_logfields_screenshoturl"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_screenshoturl" value="screenshoturl" <?php if( isset( $c2p_settings['logsettings']['logscreen']['displayedcolumns']['screenshoturl'] ) ){echo 'checked';} ?>> <?php _e( 'Screenshot URL', 'csv2post' );?></label>
            <br>
            <label for="csv2post_logfields_userscomment"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_userscomment" value="userscomment" <?php if( isset( $c2p_settings['logsettings']['logscreen']['displayedcolumns']['userscomment'] ) ){echo 'checked';} ?>> <?php _e( 'Users Comment', 'csv2post' );?></label>
            <br>
            <label for="csv2post_logfields_page"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_page" value="page" <?php if( isset( $c2p_settings['logsettings']['logscreen']['displayedcolumns']['page'] ) ){echo 'checked';} ?>> <?php _e( 'Page', 'csv2post' );?></label>
            <br>
            <label for="csv2post_logfields_version"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_version" value="version" <?php if( isset( $c2p_settings['logsettings']['logscreen']['displayedcolumns']['version'] ) ){echo 'checked';} ?>> <?php _e( 'Plugin Version', 'csv2post' );?></label>
            <br>
            <label for="csv2post_logfields_panelname"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_panelname" value="panelname" <?php if( isset( $c2p_settings['logsettings']['logscreen']['displayedcolumns']['panelname'] ) ){echo 'checked';} ?>> <?php _e( 'Panel Name', 'csv2post' );?></label>
            <br>
            <label for="csv2post_logfields_tabscreenname"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_tabscreenname" value="tabscreenname" <?php if( isset( $c2p_settings['logsettings']['logscreen']['displayedcolumns']['outcome'] ) ){echo 'checked';} ?>> <?php _e( 'Screen Name *', 'csv2post' );?></label>
            <br>
            <label for="csv2post_logfields_dump"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_dump" value="dump" <?php if( isset( $c2p_settings['logsettings']['logscreen']['displayedcolumns']['dump'] ) ){echo 'checked';} ?>> <?php _e( 'Dump', 'csv2post' );?></label>
            <br>
            <label for="csv2post_logfields_ipaddress"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_ipaddress" value="ipaddress" <?php if( isset( $c2p_settings['logsettings']['logscreen']['displayedcolumns']['ipaddress'] ) ){echo 'checked';} ?>> <?php _e( 'IP Address', 'csv2post' );?></label>
            <br>
            <label for="csv2post_logfields_userid"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_userid" value="userid" <?php if( isset( $c2p_settings['logsettings']['logscreen']['displayedcolumns']['userid'] ) ){echo 'checked';} ?>> <?php _e( 'User ID', 'csv2post' );?></label>
            <br>
            <label for="csv2post_logfields_comment"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_comment" value="comment" <?php if( isset( $c2p_settings['logsettings']['logscreen']['displayedcolumns']['comment'] ) ){echo 'checked';} ?>> <?php _e( 'Developers Comment', 'csv2post' );?></label>
            <br>
            <label for="csv2post_logfields_type"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_type" value="type" <?php if( isset( $c2p_settings['logsettings']['logscreen']['displayedcolumns']['type'] ) ){echo 'checked';} ?>> <?php _e( 'Entry Type', 'csv2post' );?></label>
            <br>
            <label for="csv2post_logfields_category"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_category" value="category" <?php if( isset( $c2p_settings['logsettings']['logscreen']['displayedcolumns']['category'] ) ){echo 'checked';} ?>> <?php _e( 'Category', 'csv2post' );?></label>
            <br>
            <label for="csv2post_logfields_action"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_action" value="action" <?php if( isset( $c2p_settings['logsettings']['logscreen']['displayedcolumns']['action'] ) ){echo 'checked';} ?>> <?php _e( 'Action', 'csv2post' );?></label>
            <br>
            <label for="csv2post_logfields_priority"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_priority" value="priority" <?php if( isset( $c2p_settings['logsettings']['logscreen']['displayedcolumns']['priority'] ) ){echo 'checked';} ?>> <?php _e( 'Priority', 'csv2post' );?></label> 
            <br>
            <label for="csv2post_logfields_thetrigger"><input type="checkbox" name="csv2post_logfields[]" id="csv2post_logfields_thetrigger" value="thetrigger" <?php if( isset( $c2p_settings['logsettings']['logscreen']['displayedcolumns']['thetrigger'] ) ){echo 'checked';} ?>> <?php _e( 'Trigger', 'csv2post' );?></label> 

    
        <?php 
        $this->UI->postbox_content_footer();
    }    
}?>