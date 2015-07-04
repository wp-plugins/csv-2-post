<?php
/** 
 * Class for interface functions, those that output HTML.
 * Can include Ajax and Javascript related functions. 
 * 
 * @package CSV 2 POST
 * @author Ryan Bayne   
 * @since 8.0.0
 */

// load in WordPress only
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
* User Interface functions for WebTechGlobal plugins
* 
* @author Ryan R. Bayne
* @package CSV 2 POST
* @since 7.0.0
* @version 1.0 
*/
class CSV2POST_UI extends CSV2POST {     
    
    public function __construct() {
        
        // load class used at all times
        $this->DB = self::load_class( 'CSV2POST_DB', 'class-wpdb.php', 'classes' );
        $this->PHP = self::load_class( 'CSV2POST_PHP', 'class-phplibrary.php', 'classes' );
        $this->WPCore = self::load_class( 'CSV2POST_WPCore', 'class-wpcore.php', 'classes' );  
    }  
          
    /**
    * Called by main CSV2POST() class using proper hook
    * 
    * @uses wp_add_dashboard_widget()
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.32
    * @version 1.1
    */
    public function add_dashboard_widgets() {
        global $csv2post_settings;
                     
        // if dashboard widgets switch not enabled or does not exist return now and avoid registering widgets
        if( !isset( $csv2post_settings['widgetsettings']['dashboardwidgetsswitch'] ) || $csv2post_settings['widgetsettings']['dashboardwidgetsswitch'] !== 'enabled' ) {
            return;    
        }
                
        ########################
        #                      #
        #    BASIC WIDGETS     #
        #                      #
        ########################
        /*
        wp_add_dashboard_widget(
             'affiliatessectiondashboard1',// Widget slug.
             __( 'Test Widget', 'csv2post' ),// Title.
             array( $this, 'test1' )// Display function.
        ); 
         */
                     
        ########################
        #                      #
        #   ADVANCED WIDGETS   #
        #                      #
        ########################
        $CSV2POST_TabMenu = CSV2POST::load_class( 'C2P_TabMenu', 'class-pluginmenu.php', 'classes' );
        $menu_array = $CSV2POST_TabMenu->menu_array();
        foreach( $menu_array as $key => $section_array ) {
            
            // has the current view been activated for dashboard widgets, if not continue to the next view
            if( !isset( $csv2post_settings['widgetsettings'][ $section_array['name'] . 'dashboardwidgetsswitch'] ) ) {       
                continue;    
            } elseif( $csv2post_settings['widgetsettings'][ $section_array['name'] . 'dashboardwidgetsswitch'] !== 'enabled' ) {    
                continue;    
            }
            
            // does current user have the wp capability (permission) to access any forms on the current admin page? 
            // this is not per page/view capability checking which is for accessing the view itself, this only applies to
            // the group of meta boxes on THIS current page
            if( !isset( $csv2post_settings['widgetsettings'][ $section_array['name'] . 'widgetscapability'] ) ) {      
                continue;
            } elseif( !current_user_can( $csv2post_settings['widgetsettings'][ $section_array['name'] . 'widgetscapability'] ) ) {    
                continue;// user does not have required capability
            }
            
            // load the current view class then call the dashboard method which uses an array of data to build dashboard widgets
            // note that there is further security with capabilities existing on a per widget basis
            require_once( WTG_CSV2POST_ABSPATH . 'classes/class-view.php' );
            $view_object = CSV2POST::load_class( 'CSV2POST_' . ucfirst( $section_array['name'] ) . '_View', $section_array['name'] . '.php', 'views' );
            if( method_exists( $view_object, 'dashboard_widgets' ) ) {
                $view_object->purpose = 'dashboard';// allows the view class to run in a different way
                $view_object->dashboard();
            }
        }            
    }
              
    /**
    * <table class="widefat">
    * Allows control over all table
    * 
    */
    public function tablestart( $class = false ){
        if(!$class){$class = 'widefat';}
        echo '<table class="'.$class.'">';    
    }    
    
    /**
    * Displays a table of csv2post_option records with ability to view their value or delete them
    * @param boolean $form true adds checkbox object to each option record (currently used on uninstall panel) 
    */
    public function list_optionrecordtrace( $form = false, $size = 'Small', $optiontype = 'all' ){ 
        // first get all records that begin with csv2post_
        $csv2postrecords_result = $this->DB->options_beginning_with( 'csv2post_' );
        $counter = 1;?>
            
            <script language="JavaScript">
            function csv2post_deleteoptions_checkboxtoggle(source) {
              checkboxes = document.getElementsByName( 'csv2post_deleteoptions_array[]' );
              for(var i in checkboxes)
                checkboxes[i].checked = source.checked;
            }
            </script>

        <?php   

        if( $form){
            echo '<input type="checkbox" onClick="csv2post_deleteoptions_checkboxtoggle(this)" /> '. __( 'Select All Options', 'csv2post' ) .'<br/>';
        }
        
        $html = '';
                        
        foreach( $csv2postrecords_result as $key => $option ){
            
            if( $form){
                $html = '<input type="checkbox" name="csv2post_deleteoptions_array[]" value="'.$option.'" />';
            }
            
            echo self::notice_depreciated( $html . ' ' . $counter . '. ' . $option, 'success', $size, '', '', 'return' );
            
            ++$counter;
        }
    } 

    public function screens_menuoptions( $current){
        global $c2pm;
        foreach( $c2pm as $page_slug => $page_array ){ 
            foreach( $c2pm[$page_slug]['tabs'] as $whichvalue => $screen_array ){
                $selected = '';
                if( $screen_array['slug'] == $current){
                    $selected = 'selected="selected"';    
                }             
                echo '<option value="'.$screen_array['slug'].'" '.$selected.'>'.$screen_array['label'].'</option>'; 
            }
        }    
    }
    
    public function page_menuoptions( $current, $return = false ){
        global $c2pm;
        foreach( $c2pm as $page_slug => $page_array ){ 
            $selected = '';
            if( $page_slug == $current){
                $selected = 'selected="selected"';    
            }
            
            if( $return){
                return '<option value="'.$page_slug.'" '.$selected.'>'.$c2pm[$page_slug]['title'].'</option>';
            }else{ 
                echo '<option value="'.$page_slug.'" '.$selected.'>'.$c2pm[$page_slug]['title'].'</option>';
            }
        }    
    }
    
    public function screenintro( $c2p_page_name, $text, $progress_array ){
        global $csv2post_settings;
        
        echo '
        <div class="csv2post_screenintro_container">
            <div class="welcome-panel">
            
                <h3>'. ucfirst( $c2p_page_name) . ' ' . __( 'Development Insight', 'csv2post' ) .'</h3>
                
                <div class="welcome-panel-content">
                    <p class="about-description">'. ucfirst( $text) .'...</p>
                    
                    <h4>Section Development Progress</h4>
 
                    '.        self::info_area( '', '                    
                    Support Content: <progress max="100" value="'.$progress_array['support'].'"></progress> <br>
                    Translation: <progress max="100" value="'.$progress_array['translation'].'"></progress>' ) .'
                    <p>'.__( 'Please donate to help progress.' ).'</p>                                                     
                </div>

            </div> 
        </div>';  
    }  
    
    /**
    * table row with two choice radio group styled by WordPress and used for switch type settings
    * 
    * $current_value should be enabled or disabled, use another method and do not change this if you need other values
    *     
    * @param mixed $title
    * @param mixed $name
    * @param mixed $id
    * @param mixed $current_value
    * @param string $default pass enabled or disabled depending on the softwares default state
    * 
    * @deprecated use class-forms.php
    */
    public function option_switch( $title, $name, $id, $current_value = 'nocurrent123', $onlabel = 'Enabled', $offlabel = 'Disabled', $default = 'enabled' ){
        if( $default != 'enabled' && $default != 'disabled' ){
            $default = 'disabled';
        }
             
        // only enabled and disabled is allowed for the switch, do not change this, create a new method for a different approach
        if( $current_value != 'enabled' && $current_value != 'disabled' ){
            $current_value = $default;
        }
        
        $firstlabel = __( 'Enabled' );
        $secondlabel = __( 'Disabled' );
        
        if( $onlabel !== 'Enabled' ){$firstlabel = $onlabel;}
        if( $onlabel !== 'Disabled' ){$secondlabel = $offlabel;}        
        ?>
    
        <!-- Option Start -->
        <tr valign="top">
            <th scope="row"><?php _e( $title, 'csv2post' ); ?></th>
            <td>
                <fieldset><legend class="screen-reader-text"><span><?php echo $title; ?></span></legend>
                    <input type="radio" id="<?php echo $name;?>_enabled" name="<?php echo $name;?>" value="enabled" <?php echo $this->is_checked( $current_value, 'enabled', 'return' );?> />
                    <label for="<?php echo $name;?>_enabled"> <?php echo $firstlabel; ?></label>
                    <br />
                    <input type="radio" id="<?php echo $name;?>_disabled" name="<?php echo $name;?>" value="disabled" <?php echo $this->is_checked( $current_value, 'disabled', 'return' );?> />
                    <label for="<?php echo $name;?>_disabled"> <?php echo $secondlabel; ?></label>
                </fieldset>
            </td>
        </tr>
        <!-- Option End -->
                            
    <?php  
    }     
     
    /**
    * returns "checked" for us in html form radio groups
    * 
    * @param mixed $actual_value
    * @param mixed $item_value
    * @param mixed $output
    * @return mixed
    */
    public function is_checked( $actual_value, $item_value, $output = 'return' ){
        if( $actual_value === $item_value){
            if( $output == 'return' ){
                return ' checked';
            }else{
                echo ' checked';
            }
        }else{
            if( $output == 'return' ){
                return '';
            }else{
                echo '';
            }
        }
    } 
        
    /**
    * add text input to WordPress style form which is tabled and has optional HTML5 support
    * 
    * 1. the $capability value is set systematically, by default it is 'active_plugins' so minimum use is fine, it
    * is also not required if forms are being hidden from users who shouldnt see them. The security is there as a 
    * precation from hack (hacker manages to access page form is on) or developer mistake (they open up the page or form
    * to the wrong users in another method, hopefully this catches the user at submission point)
    * 
    * @param string $title
    * @param string $name - html name
    * @param string $id - html id
    * @param string|numeric $current_value
    * @param boolean $readonly 
    * @param string $class
    * @param string $append_text
    * @param boolean $left_field
    * @param string $right_field_content
    * @param boolean $required
    * @param string $validation - appends 'input_validation_' to call a function that validates, so any function and validation method can be setup 
    * 
    * @deprecated use class-forms.php      
    */
    public function option_text( $title, $name, $id, $current_value = '', $readonly = false, $class = 'csv2post_inputtext', $append_text = '', $left_field = false, $right_field_content = '', $required = false, $validation = false ){
        self::register_input_validation( $title, $name, $id, $validation );// stored data is used to apply correct validation during processing
        ?>
        
        <!-- Option Start -->        
        <tr valign="top">
            <th scope="row"><?php echo $title; ?>
            
                <?php 
                // if required add asterix ( "required" also added to input to make use of HTML5 control")
                if( $required){
                    echo '<abbr class="req" title="required">*</abbr>';
                }
                 
                // if $left_field is true the input put in the first field and not second
                if(!$left_field){ echo '</th><td>'; }?>
   
                <input type="text" name="<?php echo $name;?>" id="<?php echo $id;?>" value="<?php echo $current_value;?>"<?php if(is_string( $required) && $required !== true){echo ' title="'.$required.'" ';}?>class="<?php echo $class;?>" <?php if( $readonly ){echo ' readonly';}?><?php if( $required){echo 'required';}?>> 
                <?php echo $append_text;?>

                <?php 
                // if $left_field is true we start the second (right side) field here
                if( $left_field){ echo '</th><td>' . $right_field_content; }
                ?>            
                
            </td>
        </tr>
        <!-- Option End --><?php 
    }
    
    /**
    * uses option_text() to add input, this version requires the most common required attributes only
    * 
    * @deprecated use class-forms.php
    */
    public function option_text_simple( $title, $nameandid, $current_value = '', $required = false, $validation = false ){
        $this->option_text( $title, $nameandid, $nameandid, $current_value, false, 'csv2post_inputtext', '', false, '', $required, $validation );
    }
    
    /**
    * use in options table to add a line of text like a separator 
    * 
    * @param mixed $secondfield
    * @param mixed $firstfield
    * 
    * @deprecated use class-forms.php
    */
    public function option_subline( $secondfield, $firstfield = '' ){?>
        <!-- Option Start -->        
        <tr valign="top">
            <th scope="row"><?php echo $firstfield;?></th>
            <td><?php echo $secondfield;?></td>
        </tr>
        <!-- Option End --><?php     
    }
    
    /**
    * @deprecated use class-forms.php
    * 
    * @param mixed $title
    * @param mixed $id
    * @param mixed $name
    * @param mixed $radio_array
    * @param mixed $current
    * @param mixed $default
    * @param mixed $validation
    * 
    * @deprecated use class-forms.php 
    */
    public function option_radiogroup( $title, $id, $name, $radio_array, $current = 'nocurrent123', $default = 'nodefaultset123', $validation = false ){
        self::register_input_validation( $title, $name, $id, $validation );// stored data is used to apply correct validation during processing
        
        echo '
        <!-- Option Start -->        
        <tr valign="top">
            <th scope="row">'.$title.'</th>
            <td><fieldset>';
            
            echo '<legend class="screen-reader-text"><span>'.$title.'</span></legend>';
            
            $default_set = false;

            $items = count( $radio_array );
            $itemsapplied = 0;
            foreach( $radio_array as $key => $option){
                ++$itemsapplied;
                    
                // determine if this option is the currently stored one
                $checked = '';
                if( $current === $key ){
                    $default_set = true;
                    $checked = 'checked';
                }elseif( $current == 'nocurrent123' && $default_set == false ){
                    $default_set = true;
                    $checked = 'checked';
                }
                
                // set the current to that just submitted
                if( isset( $_POST[$name] ) && $_POST[$name] == $key ){
                    $default_set = true;
                    $checked = 'checked';                
                }
                
                // check current item is no current giving or current = '' 
                if( is_null( $current ) || $current == 'nocurrent123' ){
                    if( $default == $key ){
                        $default_set = true;
                        $checked = 'checked';                
                    } 
                }
                
                // if on last option and no current set then check last item
                if( $default_set == false && $items == $itemsapplied){
                    $default_set = true;
                    $checked = 'checked';                
                }                
                
                // create an object id                 
                $itemid = $id . $this->PHP->clean_string( $option);
 
                $value = $key;
                      
                echo '<input type="radio" id="'.$itemid.'" name="'.$name.'" value="'.$value.'" '.$checked.'/>
                <label for="">' . $option .'</label>
                <br />';
            }
            
        echo '</fieldset>
            </td>
        </tr>
        <!-- Option End -->';                 
    }
    
    /**
    * @deprecated use class-forms.php
    * 
    * @param mixed $title
    * @param mixed $id
    * @param mixed $name
    * @param mixed $rows
    * @param mixed $cols
    * @param mixed $current_value
    * @param mixed $required
    * @param mixed $validation
    * 
    * @deprecated use class-forms.php
    */
    public function option_textarea( $title, $id, $name, $rows = 4, $cols = 50, $current_value, $required = false, $validation = false ){
        self::register_input_validation( $title, $name, $id, $validation );// stored data is used to apply correct validation during processing
        ?>
        <!-- Option Start -->        
        <tr valign="top">
            <th scope="row">
                <?php echo $title; 
                // if required add asterix ( "required" also added to input to make use of HTML5 control")
                if( $required){
                    echo '<abbr class="req" title="required">*</abbr>';
                }?>
                </th>
            <td>
                <textarea id="<?php echo $id;?>" name="<?php echo $name;?>" rows="<?php echo $rows;?>" cols="<?php echo $cols;?>"<?php if( $required){echo ' required';}?>><?php echo $current_value;?></textarea>
            </td>
        </tr>
        <!-- Option End --><?php     
    }
    
    /**
    * @deprecated use class-forms.php
    * 
    * @param mixed $title
    * @param mixed $id
    * @param mixed $name
    * @param mixed $array
    * @param mixed $current
    * @param mixed $defaultvalue
    * @param mixed $defaulttitle
    * @param mixed $validation
    * 
    * @deprecated use class-forms.php
    */
    public function option_menu( $title, $id, $name, $array, $current = 'nocurrentvalue123', $defaultvalue = 'nodefaultrequired123', $defaulttitle = 'nodefaultrequired123', $validation = false ){
        self::register_input_validation( $title, $name, $id, $validation );// stored data is used to apply correct validation during processing
        ?>
        <!-- Option Start -->        
        <tr valign="top">
            <th scope="row"><label for="<?php echo $id; ?>"><?php echo $title; ?>
            </label></th>
            <td>            
                <select name="<?php echo $name;?>" id="<?php echo $id;?>">
                    <?php
                    if( $defaultvalue != 'nodefaultrequired123' && $defaulttitle != 'nodefaultrequired123' ){
                        echo '<option selected="selected" value="notrequired">Not Required</option>';
                    }                    
                    
                    $selected = '';            
                    foreach( $array as $key => $title){
                        if( $key == $current){
                            $selected = 'selected="selected"';
                        } 
                        echo '<option '.$selected.' value="'.$key.'">'.$title.'</option>';    
                    }
                    ?>
                </select>                  
            </td>
        </tr>
        <!-- Option End --><?php          
    }
    
    /**
    * Form menu wrapped in WP admin styled table row
    * 
    * values are numeric, items are numeric
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.1
    * 
    * @param mixed $title
    * @param mixed $name
    * @param mixed $id
    * @param mixed $current
    * @param mixed $validation
    */
    public function option_menu_datasources( $title = 'Data Source', $name = 'datasource', $id = 'datasource', $current = false, $parent_sources_only = false ){
        self::register_input_validation( $title, $name, $id, 'numeric' );// stored data is used to apply correct validation during processing
        
        global $wpdb;
        $query_results = $this->DB->selectwherearray( $wpdb->c2psources, 'sourceid = sourceid', 'sourceid', '*' );?>
        <!-- Option Start -->        
        <tr valign="top">
            <th scope="row"><label for="<?php echo $id; ?>"><?php echo $title; ?></label></th>
            <td>            
                <select name="<?php echo $name;?>" id="<?php echo $id;?>">
                    <?php                  
                    $selected = '';            
                    foreach( $query_results as $key => $source_array ){            
                        // avoid displaying child files of a multfile project 
                        if( $parent_sources_only === false || $parent_sources_only === true && $source_array['parentfileid'] == '0' ) {
                            if( $source_array['sourceid'] == $current){
                                $selected = 'selected="selected"';
                            } 
                            
                            // create item name
                            $item_name = $source_array['sourceid'];
                            if( isset( $source_array['name'] ) ) {
                                $item_name . ' - ' . $source_array['name'];
                            } 
                            
                            echo '<option '.$selected.' value="'.$source_array['sourceid'].'">' . $item_name . '</option>';
                        }    
                    }
                    ?>
                </select>  
                
                <?php if( $parent_sources_only ) { echo '(parent sources only)'; }?>
                                
            </td>
        </tr>
        <!-- Option End --><?php         
    }    
    
    /**
    * outputs a single html checkbox with label
    * 
    * wrap in <fieldset><legend class="screen-reader-text"><span>Membership</span></legend></fieldset>
    * 
    * @param mixed $label
    * 
    * @deprecated use class-forms.php
    */
    public function option_checkbox_single( $name, $label, $id, $check = 'off', $value = false, $validation = false ){
        self::register_input_validation( $label, $name, $id, $validation );// stored data is used to apply correct validation during processing
        
        $selected = '';
        
        if( $check == 'on' ) {
            $selected = 'checked';
        }
        
        if( $value !== false ) {
            $thevalue = ' value="' . $value . '" ';
        } else { 
            $thevalue = '';
        }
        
        echo '<label for="'.$id.'"><input name="'.$name.'" type="checkbox" id="'.$id.'"'.$thevalue.''.$selected.'>' . $label . '</label>';
    }

    /**
    * Displays a mid grey area for pres
    * 
    * @param mixed $title
    * @param mixed $message
    * 
    * @deprecated use class-forms.php
    */
    public function info_area( $title, $message, $admin_only = true){ 
        if( $admin_only == true && current_user_can( 'manage_options' ) || $admin_only !== true){
            return '
            <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
                <h4>'.$title.'</h4>
                <p>'.$message.'</p>
            </div>';          
        }
    }
     
    /**
    * a standard menu of users wrapped in <td> 
    * 
    * @deprecated use class-forms.php
    */
    public function option_menu_users( $title, $name, $id, $current_value = 'nocurrentvalue123', $validation = false ){
        self::register_input_validation( $title, $name, $id, $validation );// stored data is used to apply correct validation during processing
                 
        $blogusers = get_users( 'blog_id=1&orderby=nicename' );?>

        <!-- Option Start -->
        <tr valign="top">
            <th scope="row"><?php echo $title;?></th>
            <td>                                     
                <select name="<?php echo $name;?>" id="<?php echo $id;?>">
            
                    <?php        
                    $selected = '';                    
                    ?>
                    
                    <option value="notselected" <?php echo $selected;?>>None Selected</option> 
                                                    
                    <?php         
                    foreach ( $blogusers as $user){ 

                        // apply selected value to current save
                        $selected = '';
                        if( $current_value == $user->ID ) {
                            $selected = 'selected="selected"';
                        }

                        echo '<option value="'.$user->ID.'" '.$selected.'>'. $user->ID . ' - ' . $user->display_name .'</option>'; 
                    }?>
                                                                                                                                                                 
                </select>  
            </td>
        </tr>
        <!-- Option End --><?php 
    } 
    
    /**
    * a standard menu of categories wrapped in <td> 
    * 
    * @deprecated use class-forms.php
    */
    public function option_menu_categories( $title, $name, $id, $current_value = 'nocurrentvalue123', $validation = false ){ 
        self::register_input_validation( $title, $name, $id, $validation );// stored data is used to apply correct validation during processing
                         
        $cats = get_categories( 'hide_empty=0&echo=0&show_option_none=&style=none&title_li=' );?>

        <!-- Option Start -->
        <tr valign="top">
            <th scope="row"> <?php echo $title;?> </th>
            <td>                                     
                <select name="<?php echo $name;?>" id="<?php echo $id;?>">
            
                    <?php        
                    $selected = '';                    
                    ?>
                    
                    <option value="notselected" <?php echo $selected;?>>None Selected</option> 

                    <?php         
                    foreach( $cats as $c ){ 
                        
                        // apply selected value to current save
                        $selected = '';
                        if( $current_value == $c->term_id ) {
                            $selected = 'selected="selected"';
                        }
                        
                        echo '<option value="'.$c->term_id.'" '.$selected.'>'. $c->term_id . ' - ' . $c->name .'</option>'; 
                    }?>
                                                                                                                                                                 
                </select>  
            </td>
        </tr>
        <!-- Option End --><?php 
    } 
    
    /**
    * radio group of post types wrapped in <tr>
    * 
    * @param string $title
    * @param string $name
    * @param string $id
    * @param string $current_value
    * 
    * @deprecated use class-forms.php
    */
    public function option_radiogroup_posttypes( $title, $name, $id, $current_value = 'nocurrent123', $validation = false ){  
        self::register_input_validation( $title, $name, $id, $validation );// stored data is used to apply correct validation during processing
           
        echo '
        <!-- Option Start -->        
        <tr valign="top">
            <th scope="row">'.$title.'</th>
            <td><fieldset>';
            
            echo '<legend class="screen-reader-text"><span>'.$title.'</span></legend>';
            
            $post_types = get_post_types( '', 'names' );
            $current_applied = false;        
            $i = 0; 
            foreach( $post_types as $post_type ){
                
                // dont add "post" as it is added last so that it can be displayed as current default when required
                if( $post_type != 'post' ){
                    $checked = '';
                    
                    if( $post_type == $current_value){
                        $checked = 'checked="checked"';
                        $current_applied = true;    
                    }elseif( $current_value == 'nocurrent123' && $current_applied == false ){
                        $checked = 'checked="checked"';
                        $current_applied = true;                        
                    }
                    
                    echo '<input type="radio" name="'.$name.'" id="'.$id.$i.'" value="'.$post_type.'" '.$checked.' />
                    <label for="'.$id.$i.'"> '.$post_type.'</label><br>';
    
                    ++$i;
                }
            }
            
            // add post last, if none of the previous post types are the default, then we display this as default as it would be in WordPress
            $post_default = '';
            if(!$current_applied){
                $post_default = 'checked="checked"';            
            }
            echo '<input type="radio" name="'.$name.'" id="'.$id.$i.'" value="post" '.$post_default.' />
            <label for="'.$id.$i.'">post</label>';
                    
        echo '</fieldset>
            </td>
        </tr>
        <!-- Option End -->';
    } 
    
    /**
    * @deprecated use class-forms.php
    * 
    * @param mixed $title
    * @param mixed $name
    * @param mixed $id
    * @param mixed $current_value
    * @param mixed $validation
    * 
    * @deprecated use class-forms.php
    */
    public function option_radiogroup_postformats( $title, $name, $id, $current_value = 'nocurrent123', $validation = false ){      
        self::register_input_validation( $title, $name, $id, $validation );// stored data is used to apply correct validation during processing
       
        echo '
        <!-- Option Start -->        
        <tr valign="top">
            <th scope="row">'.$title.'</th>
            <td><fieldset>';
            
            echo '<legend class="screen-reader-text"><span>'.$title.'</span></legend>';
      
            $optionchecked = false;     
            $post_formats = get_theme_support( 'post-formats' );
            if ( is_array( $post_formats[0] ) ) {
                
                $i = 0;
                
                foreach( $post_formats[0] as $key => $format){
                    
                    $statuschecked = '';
                    if( $current_value === $format){
                        $optionchecked = true;
                        $statuschecked = ' checked="checked" ';    
                    }
                                   
                    echo '<input type="radio" id="'.$id.$i.'" name="'.$name.'" value="'.$format.'"'.$statuschecked.'/>
                    <label for="'.$id.$i.'">'.$format.'</label><br>';
                    ++$i; 
                }
                
                if(!$optionchecked){$statuschecked = ' checked="checked" ';}
                
                echo '<input type="radio" id="'.$id.$i.'" name="'.$name.'" value="standard"'.$statuschecked.'/>
                <label for="'.$id.$i.'">standard (default)</label>';               
                    
            }            
                    
        echo '</fieldset>
            </td>
        </tr>
        <!-- Option End -->';
    }   

    /**
    * menu of post templates wrapped in <tr>
    * 
    * @param mixed $title
    * @param mixed $name
    * @param mixed $id
    * @param mixed $current_value
    * @param mixed $validation
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.2
    */
    public function option_menu_posttemplates( $title, $name, $id, $current_value = 'nocurrentvalue123', $validation = false ){    
        self::register_input_validation( $title, $name, $id, $validation );// stored data is used to apply correct validation during processing
        ?>

        <!-- Option Start -->
        <tr valign="top">
            <th scope="row"> <?php echo $title;?> </th>
            <td>                                     
                <select name="<?php echo $name;?>" id="<?php echo $id;?>">
            
                    <?php        
                    $selected = '';                    
                    ?>
                    
                    <option value="notselected" <?php echo $selected;?>>None Selected</option> 

                    <?php         
                    $args = array(
                        'post_type' => 'wtgcsvcontent',
                        'posts_per_page'  => 999,
                    );
                                                 
                    global $post;
                    $myposts = get_posts( $args );
                    foreach( $myposts as $post ){ 
                        $selected = '';
                        if( $current_value == $post->ID){
                            $selected = 'selected="selected"';
                        }
                        echo '<option value="'.$post->ID.'" '.$selected.'>'.$post->post_title.'</option>'; 
                    }; ?>
                                                                                                                                                                 
                </select>  
            </td>
        </tr>
        <!-- Option End --><?php 
    }
    
    /**
    * lists a projects headers with checkboxes in WordPress options table styling
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.32
    * @version 1.1
    * 
    * @param mixed $project_id
    * @param mixed $name
    * @param mixed $validation
    */
    public function option_project_headers_checkboxes( $project_id, $name, $validation = false ){

        // get all project columns, function gets columns from all tables if more than one
        $project_columns_array = CSV2POST::get_project_columns_from_db( $project_id, true);
        
        // get the data treatment then remove it to make the loops simple
        if( isset( $project_columns_array['arrayinfo']['datatreatment'] ) ) {
            $treatment = $project_columns_array['arrayinfo']['datatreatment'];
            unset( $project_columns_array['arrayinfo']['datatreatment'] );
        }
   
        // build array data types
        $datatypes_array = array();
        $datatypes_array['notrequired'] = 'Not Required';
        $datatypes_array['alphanumeric'] = 'Alphanumeric';
        $datatypes_array['numeric'] = 'Numeric';
        $datatypes_array['linkurl'] = 'Link URL';
        $datatypes_array['imageurl'] = 'Not Required';
        $datatypes_array['boolean'] = 'Boolean';
      
        // loop through query result, the initial keys are table names
        foreach( $project_columns_array as $table_name => $columns_array ){
            // the array should have a key named arrayinfo which we skip
            if( $table_name != 'arrayinfo' ){
                // loop through the current tables columns
                foreach( $columns_array as $key => $acolumn){

                    // we tidy the interface for roundnumber up and down by hiding columns that have a set datatype which is not numerical
                    if( $name == 'roundnumberupcolumns' || $name == 'roundnumbercolumns' ){
                        $rules_array = CSV2POST::get_data_rules_source( $project_columns_array['arrayinfo']['sources'][$table_name] );
                        if(!empty( $rules_array ) ){
                            if( isset( $rules_array['datatypes'][$acolumn] ) && $rules_array['datatypes'][$acolumn] != 'numeric' ){
                                continue;
                            }
                        }
                    }
                    
                    $checked = '';
                    
                    // update form from previous submission
                    if( isset( $_POST["$name#$table_name#$acolumn"] ) ){
                        $checked = 'checked';
                    }
                                       
                    $rules_array = CSV2POST::get_data_rules_source( $project_columns_array['arrayinfo']['sources'][$table_name] );
                    if(!empty( $rules_array ) ){
                        if( isset( $rules_array[$name][$acolumn] ) ){
                            $checked = 'checked';       
                        }
                    }          
                    ?>  
                
                
                    <?php 
                    if( $treatment == 'individual' ){$label = $acolumn . '<br><span style="color:grey;">'.$table_name . '</span>';}else{$label = $acolumn;}
                    ?>
                                        
                    <tr valign="top">                    
                        <th scope="row"><?php echo $label;?></th>
                        <td>
                           <input type="hidden" name="sourceid_<?php echo $table_name . $acolumn;?>" value="<?php echo $project_columns_array['arrayinfo']['sources'][$table_name];?>"> 
                            <fieldset><legend class="screen-reader-text"><span><?php echo $label;?></span></legend>                                     
                                <input name="<?php echo $name.'#'.$table_name.'#'.$acolumn;?>" type="checkbox" id="<?php echo $key.$acolumn;?>" <?php echo $checked;?>> 
                            </fieldset>
                                            
                        </td>
                    </tr><?php
                }
            }
        }        
    } 
    
    /**
    * @deprecated use class-forms.php
    * 
    * @param mixed $title
    * @param mixed $project_id
    * @param mixed $name
    * @param mixed $id
    * @param mixed $current_table
    * @param mixed $current_column
    * @param mixed $default_value
    * @param mixed $default_label
    * @param mixed $validation
    */
    public function option_projectcolumns( $title, $project_id, $name, $id, $current_table = 'nocurrentvalue123', $current_column = 'nocurrentvalue123', $default_value = false, $default_label = false, $validation = false ){
        self::register_input_validation( $title, $name, $id, $validation );// stored data is used to apply correct validation during processing
        
        $project_columns_array = CSV2POST::get_project_columns_from_db( $project_id, true);
        $datatreatment = $project_columns_array['arrayinfo']['datatreatment'];
        unset( $project_columns_array['arrayinfo'] );
        ?>         
        <tr valign="top">
            <th scope="row"><?php echo $title;?></th>
            <td>
                <select name="<?php echo $name;?>" id="<?php echo $id;?>">
                
                    <?php 
                    if( $default_value && $default_label){
                        echo '<option value="'.$default_value.'">'.$default_label.'</option>';
                    }

                    foreach( $project_columns_array as $table_name => $columns_array ){

                        foreach( $columns_array as $key => $acolumn){
                         
                            $selected = '';
                            if( $current_table == $table_name && $current_column == $acolumn){
                                $selected = ' selected="selected"'; 
                            }

                            if( $datatreatment == 'single' ){
                                $label = $acolumn;
                            }else{
                                $label = $table_name . ' - '. $acolumn;
                            }
                            
                            echo '<option value="'.$table_name . '#' . $acolumn.'"'.$selected.'>'.$label.'</option>';    
                        }  
                    }
                    ?>
                    
                </select> 
                 
            </td>
        </tr><?php 
    } 
    
    /**
    * @param mixed $title
    * @param mixed $project_id
    * @param mixed $name
    * @param mixed $id
    * @param mixed $current
    * @param mixed $default_value
    * @param mixed $default_label
    * @param mixed $validation
    */
    public function option_projectcolumns_splittermenu( $title, $project_id, $name, $id, $current = 'nocurrentvalue123', $default_value = false, $default_label = false, $validation = false ){
        self::register_input_validation( $title, $name, $id, $validation );// stored data is used to apply correct validation during processing
        
        $project_columns_array = CSV2POST::get_project_columns_from_db( $project_id, true);
        $datatreatment = $project_columns_array['arrayinfo']['datatreatment'];
        unset( $project_columns_array['arrayinfo'] );
        ?>         
        <tr valign="top">
            <th scope="row"><?php echo $title;?></th>
            <td>
                <select name="<?php echo $name;?>" id="<?php echo $id;?>">
                
                    <?php 
                    if( $default_value && $default_label){
                        echo '<option value="'.$default_value.'">'.$default_label.'</option>';
                    }

                    foreach( $project_columns_array as $table_name => $columns_array ){

                        foreach( $columns_array as $key => $acolumn){
                         
                            $selected = '';
                            
                            // ensure we have rules
                            if( $current == $acolumn){
                                $selected = ' selected="selected"'; 
                            }

                            if( $datatreatment == 'single' ){
                                $label = $acolumn;
                            }else{
                                $label = $table_name . ' - '. $acolumn;
                            }

                            echo '<option value="'.$table_name . '#' . $acolumn.'"'.$selected.'>'.$label.'</option>';    
                        }  
                    }
                    ?>
                    
                </select> 
                 
            </td>
        </tr><?php 
    }
    
    /**
    * @param mixed $title
    * @param mixed $project_id
    * @param mixed $name
    * @param mixed $id
    * @param mixed $current_table
    * @param mixed $current_column
    * @param mixed $default_value
    * @param mixed $default_label
    * @param mixed $validation
    */
    public function option_projectcolumns_categoriesmenu( $title, $project_id, $name, $id, $current_table = 'nocurrentvalue123', $current_column = 'nocurrentvalue123', $default_value = false, $default_label = false, $validation = false ){
        self::register_input_validation( $title, $name, $id, $validation );// stored data is used to apply correct validation during processing
        
        $project_columns_array = CSV2POST::get_project_columns_from_db( $project_id, true);
        $datatreatment = $project_columns_array['arrayinfo']['datatreatment'];
        unset( $project_columns_array['arrayinfo'] );
        ?>         
        <tr valign="top">
            <th scope="row"><?php echo $title;?></th>
            <td>
                <select name="<?php echo $name;?>" id="<?php echo $id;?>">
                
                    <?php 
                    if( $default_value && $default_label){
                        echo '<option value="'.$default_value.'">'.$default_label.'</option>';
                    }

                    foreach( $project_columns_array as $table_name => $columns_array ){

                        foreach( $columns_array as $key => $acolumn){
                         
                            $selected = '';
                            if( $current_table == $table_name && $current_column == $acolumn){
                                $selected = ' selected="selected"'; 
                            }

                            if( $datatreatment == 'single' ){
                                $label = $acolumn;
                            }else{
                                $label = $table_name . ' - '. $acolumn;
                            }

                            echo '<option value="'.$table_name . '#' . $acolumn.'"'.$selected.'>'.$label.'</option>';    
                        }  
                    }
                    ?>
                    
                </select> 
                 
            </td>
        </tr><?php 
    }  

    /**
    * Add a file uploader to a form
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.33
    * @version 1.1
    * 
    * @param string $title
    * @param string $name
    * @param string $id
    * @param string $validation - pass name of a custom validation function 
    * 
    * @deprecated use class-forms.php
    */
    public function option_file( $title, $name, $id, $validation = false ){
        self::register_input_validation( $title, $name, $id, $validation );// stored data is used to apply correct validation during processing
        ?>         
        <tr valign="top">
            <th scope="row"><?php echo $title;?></th>
            <td>
                <input type="file" name="<?php echo $name;?>" id="<?php echo $id;?>" /> 
            </td>
        </tr><?php 
    }      
    
    /**
    * menu of project columns with a menu for each used to select that columns data type
    * 
    * @param mixed $project_id
    * @param mixed $name
    * @param mixed $id
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.33
    * @version 1.0.1
    */
    public function option_column_datatypes( $project_id, $name, $id, $validation = false ){
        if(!is_numeric( $project_id) ){
            return false;
        }

        $project_columns_array = CSV2POST::get_project_columns_from_db( $project_id, true);
                
        // get the data treatment then remove it to make the loops simple
        $treatment = $project_columns_array['arrayinfo']['datatreatment'];
        
        if( isset( $project_columns_array['arrayinfo']['datatreatment'] ) ){
            unset( $project_columns_array['arrayinfo']['datatreatment'] );
        }
          
        $current_value = 'notrequired';
                                
        $datatypes_array = array();
        $datatypes_array['notrequired'] = 'Not Required';
        $datatypes_array['alpha'] = 'Letters Only';        
        $datatypes_array['alphanumeric'] = 'Letters & Numbers';
        $datatypes_array['numeric'] = 'Numbers Only';
        $datatypes_array['linkurl'] = 'Link URL';
        $datatypes_array['imageurl'] = 'Image URL';
        $datatypes_array['boolean'] = 'Boolean';
                           
        foreach( $project_columns_array as $table_name => $columns_array ){     
            if( $table_name != 'arrayinfo' ){   
                foreach( $columns_array as $key => $acolumn){
                    $rules_array = CSV2POST::get_data_rules_source( $project_columns_array['arrayinfo']['sources'][$table_name] );
                    if(!empty( $rules_array ) ){
                        if( isset( $rules_array['datatypes'][$acolumn] ) ){
                            $current_value = $rules_array['datatypes'][$acolumn];       
                        }
                    }
                            
                    // update form from previous submission
                    if( isset( $_POST["$name#$table_name#$acolumn"] ) ){
                        $current_value = $_POST["$name#$table_name#$acolumn"];
                    }
                    ?>  
                
                    <?php 
                    if( $treatment == 'individual' ){$label = $acolumn . '<br><span style="color:grey;">'.$table_name . '</span>';}else{$label = $acolumn;}
                    ?>
                                        
                    <tr valign="top">                    
                        <th scope="row"><?php echo $label;?></th>
                        <td>
                            <input type="hidden" name="sourceid_<?php echo $table_name . $acolumn;?>" value="<?php echo $project_columns_array['arrayinfo']['sources'][$table_name];?>">
                            <select name="<?php echo "$name#$table_name#$acolumn";?>" id="<?php echo "$name$table_name$acolumn";?>">
                                <?php    
                                foreach( $datatypes_array as $key => $data_type){
                                    $selected = ''; 
                                    if( $current_value == $key ){$selected = ' selected="selected"';}
                                
                                    echo '<option value="'.$key.'"'.$selected.'>'.$data_type.'</option>';
                                }
                                ?>
                            </select>
                        </td>
                    </tr><?php
                }
            }
        }
    } 
       
    /**
    * displays the current project and a row of quick action buttons (actually links) 
    */
    public function display_current_project() {
        global $csv2post_settings, $CSV2POST, $wpdb;
        
        // set default values
        $current = 'No Projects'; 
        $projectid = 'N/A';              
        
        if( isset( $csv2post_settings['currentproject'] ) && is_numeric( $csv2post_settings['currentproject'] ) ){
        
            $current = $CSV2POST->get_project_name( $csv2post_settings['currentproject'] );
        
            $projectid = $csv2post_settings['currentproject'];    
        
        }else{
            
            $row = $this->DB->selectrow( $wpdb->c2pprojects, 'projectid = projectid', 'projectname' );  
            
            if( $row == NULL){
                
                $current = __( 'No Projects Created', 'csv2post' ) . '<p>More pages will become available once a project has been created.</p>';
            
            }else{  
               
                // set the found project as the current one
                if( isset( $row->projectid ) && is_numeric( $row->projectid ) ){
                    $csv2post_settings['currentproject'] = $row->projectid;
                    $projectid = $row->projectid;
                    $CSV2POST->update_settings( $csv2post_settings );
                } 

                $current = $row->projectname;
            }
        }

        // build a row of button styled links for quick actions - avoid displaying on main/about view so that
        // focus goes on the news and encourges social activity
        $quick_actions = '';
        if( is_numeric( $projectid ) ){
            
            $source_array = $CSV2POST->get_project_sourcesid( $projectid);
            if(!$source_array || !isset( $source_array[0] ) ){
                $source_array[0] = 'No Source';    
            }
             
            // add required messages to $project_message
            $project_message = '';
            if( !$CSV2POST->does_project_table_exist( $projectid ) ){
                
                $project_message = self::notice_return( 'error', 'Tiny', __( 'Project Table Not Found' ), __( 'Your current 
                active project no longer has a main database table, could you have deleted it manually? 
                This problem needs resolved before you can continue this project. If you cannot restore the project table
                you should either disable all automation for this project or delete the project. This is to prevent attempted
                queries on the database that will fail.' ) );
            }            
            
            $quick_actions .= $project_message;
            
            $quick_actions .= $CSV2POST->linkaction( $_GET['page'], 'createpostscurrentproject', __( 'Create posts using the current project' ), __( 'Create Posts' ), '' ); 
            
            $quick_actions .= $CSV2POST->linkaction( $_GET['page'], 'updatepostscurrentproject', __( 'Update posts originally created by the current project' ), __( 'Update Posts' ), '' );
            
            $quick_actions .= $CSV2POST->linkaction( $_GET['page'], 'importdatecurrentproject', __( 'Import data for the current project' ), __( 'Import Data' ), '' );
            
            $quick_actions .= $CSV2POST->linkaction( $_GET['page'], 'updatedatacurrentproject', __( 'Update the current projects data' ), __( 'Update Data' ), '' ); 
            
            $quick_actions .= $CSV2POST->linkaction( $_GET['page'], 'displayprojectsummary', __( 'Display the current projects summary' ), 'Project ID: ' . $projectid, '' );      
            
            $quick_actions .= $CSV2POST->linkaction( $_GET['page'], 'displaysourcesummary', __( 'Display information about the projects sources' ), 'Source ID: ' . $source_array[0], '' );       
            
            $quick_actions .= $CSV2POST->linkaction( $_GET['page'], 'currentprojectprevious', __( 'Open the previous project and make it the curren active project', 'csv2post' ), __( 'Previous Project', 'csv2post' ), '' );
            
            $quick_actions .= $CSV2POST->linkaction( $_GET['page'], 'currentprojectnext', __( 'Open the next project and make it the current active one', 'csv2post' ), __( 'Next Project', 'csv2post' ), '' );
        

            if( $_GET['page'] == 'csv2post_projectchecklist' ){

                $quick_actions .= $CSV2POST->linkaction( $_GET['page'], 'columnreplacementtokens', __( 'View a list of the current projects column replacement tokens', 'csv2post' ), __( 'Column Replacement Tokens', 'csv2post' ), '' );

            }
            
        }
        
        echo self::info_area( 'Current Project: ' . $current, $quick_actions );
    }

    /**
    * removes plugins name from $_GET['page'] and returns the rest, else returns main to indicate parent
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.1
    */
    public function get_admin_page_name() {
        if( !isset( $_GET['page'] ) ){
            return 'main';
        }
        $exloded = explode( '_', $_GET['page'] );
        return end( $exloded );        
    }
    
    /**
    * Add hidden form fields, to help with processing and debugging
    * Adds the _form_processing_required value, required to call the form validation file
    *
    * @param integer $pageid (the id used in page menu array )
    * @param slug $panel_name (panel name form is in)
    * @param string $panel_title (panel title form is in)
    * @param integer $panel_number (the panel number form is in),(tab number passed instead when this function called for support button row)
    * @param integer $step (1 = confirm form, 2 = process request, 3+ alternative processing)
    * 
    * @deprecated use form_start() in class-forms.php
    */               
    public function hidden_form_values( $form_name, $form_title, $return = false ){
        global $c2p_page_name;
        $form_name = strtolower( $form_name );          
        if( $return ){
            $form = '';
            $form .= wp_nonce_field( $form_name );// form name is used during processing to complete the security 
            $form .= '<input type="hidden" name="csv2post_admin_action" value="true">';
            $form .= '<input type="hidden" name="csv2post_hidden_pagename" value="' . $c2p_page_name . '">';
            $form .= '<input type="hidden" name="csv2post_form_name" value="' . $form_name . '">';
            $form .= '<input type="hidden" name="csv2post_form_title" value="' . $form_title . '">'; 
            $form .= '<input type="hidden" name="csv2post_form_formid" value="' . $form_name . '">'; 
            return $form;           
        } else {
            wp_nonce_field( $form_name );// form name is used during processing to complete the security  
            echo '<input type="hidden" name="csv2post_admin_action" value="true">';
            echo '<input type="hidden" name="csv2post_hidden_pagename" value="' . $c2p_page_name . '">';
            echo '<input type="hidden" name="csv2post_form_name" value="' . $form_name . '">';
            echo '<input type="hidden" name="csv2post_form_title" value="' . $form_title . '">';
            echo '<input type="hidden" name="csv2post_form_formid" value="' . $form_name . '">';
            
        }
    }
        
    /**
    * displays a vertical list of optional icons, for use inside panels
    * 
    * the icons can be setup by passing values to this function or add the values to the help array (class-help.php)
    * 
    * @param string $form_name required to create id
    * @param boolean $trash reset the form, usually found on large forms
    * @param string $youtube pass the video id and nothing else
    * @param integer $information pass the array key for ['help'] in the menu array for the feature icon is for
    */
    public function metabox_icons( $form_id, $trash_icon = false ){
        // do not show metabox icons on dashboard
        if( CSV2POST::is_dashboard() ) {
            return false;    
        }
        
        global $c2pm, $c2p_page_name, $c2p_tab_number;
        
        // load help array
        $CSV2POST_Help = CSV2POST::load_class( 'C2P_Help', 'class-help.php', 'classes' );
                    
        $help_array = $CSV2POST_Help->get_help_array();

        $total_icons = 0; 

        $page_name = self::get_admin_page_name();
                
        // display video icon with link to a YouTube video
        if( isset( $help_array[ $page_name ][ WTG_CSV2POST_VIEWNAME ][ 'forms' ][ $form_id ][ 'formvideoid' ] ) ){
            self::panel_video_icon( $help_array[ $page_name ][ WTG_CSV2POST_VIEWNAME ][ 'forms' ][ $form_id ][ 'formvideoid' ] );
            ++$total_icons;        
        } 

        // do we have all required values to build help content and display form_information_icon()
        if( isset( $help_array[ $page_name ][ WTG_CSV2POST_VIEWNAME ][ 'forms' ][ $form_id ][ 'formtitle' ] )
            && isset( $help_array[ $page_name ][ WTG_CSV2POST_VIEWNAME ][ 'forms' ][ $form_id ][ 'formabout' ] ) ){  
                           
            // display the icon that will show information about the box when clicked
            self::box_information_icon( $page_name, WTG_CSV2POST_VIEWNAME, $form_id );
        }
        
        // display a trash icon which allows box to be quickly hidden
        if( $trash_icon ){
            $this->panel_trash_icon( $form_id );
            ++$total_icons;
        }        
    }
    
    public function panel_trash_icon( $form_name ){?>
        <a href="<?php echo $form_name;?>"><img src="<?php echo WTG_CSV2POST_IMAGES_URL . 'trash-icon.gif';?>" alt="<?php _e( 'Reset form' );?>" title="<?php _e( 'Reset form' );?>"></a><?php 
    }
    
    public function panel_video_icon( $youtubeid ){
        if( $youtubeid){
            echo '<a href="https://www.youtube.com/watch?v=' . $youtubeid . '" target="_blank"><img src="' . WTG_CSV2POST_IMAGES_URL . 'video-icon.gif" alt="' . __( 'View video on YouTube' ) . '" title="' . __( 'View video on YouTube' ) . '"></a>';
        }
    }
    
    /**
    * help icon always takes user to an external page, usually post or page on WP blog.
    * another discuss icon will be used to take user to applicable forum or chat or Google circle etc
    * 
    * @param mixed $url
    */
    public function helpicon( $url){
        return '<a href="'.$url.'" title="'. __( 'View help for this on the plugins website.' ) .'" target="_blank"><img src="'. WTG_CSV2POST_IMAGES_URL . 'help-icon.png" alt="'. __( 'View help for this on the plugins website' ) .'"></a>';
    }    
    public function videoicon( $url){
        return '<a href="'.$url.'" title="'. __( 'View a video about this feature.' ) .'" target="_blank"><img src="'. WTG_CSV2POST_IMAGES_URL . 'video-icon.png" alt="'. __( 'Video icon, click to open a video' ) .'"></a>';
    }     
    public function trashicon( $url){
        return '<a href="'.$url.'" title="'. __( 'Delete or hide the current feature.' ) .'" target="_blank"><img src="'. WTG_CSV2POST_IMAGES_URL . 'trash-icon.png" alt="'. __( 'Trash icon, click to delete or hide the current item' ) .'"></a>';
    }    
    public function discussicon( $url){
        return '<a href="'.$url.'" title="'. __( 'Discuss this feature on the WebTechGlobal forum.' ) .'" target="_blank"><img src="'. WTG_CSV2POST_IMAGES_URL . 'chat-icon.png" alt="'. __( 'Chat icon which you can click to discuss this feature on the WebTechGlobal forum.' ) .'"></a>';
    }  
    
    /**
    * header for post boxes
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.1
    */
    public function postbox_content_header( $form_title, $form_id, $introduction = false, $trash_icon = false, $uploader = false ) {?>
        <p>
            <!-- meta box icons start (a WTG thing, icons offer services) -->
            <table width="100%">
                <tr>
                    <td width="50%">
                        
                    </td>
                    <td width="50%" align="right">
                        <?php self::metabox_icons( $form_id, $trash_icon );?>
                    </td>
                </tr>
            </table>
            <!-- meta box icons end -->
            
            <?php if( $introduction !== false && !empty( $introduction) ){echo "<p class=\"csv2post_boxes_introtext\">". $introduction ."</p>";}?>
            
            <?php
            $enctype = '';
            if( $uploader ) {
                $enctype = 'enctype="multipart/form-data"';
            }
            ?>
            
            <form <?php echo $enctype;?>method="post" name="<?php echo $form_id;?>" action="<?php echo $this->PHP->currenturl(); ?>">
            
        <?php 
    }
    
    public function postbox_content_footer() {
                echo '<input class="button button-primary" type="submit" value="Submit" /> 
            </form>
        </p>';    
    }
            
    /**
    * Outputs the icon and hidden div for a popup
    * 
    * three methods of building content are available: all, numeric value from help array or ID
    * 
    * All: will output all help entries for the page, rarely used
    * Numeric: array key within the ['help'] array for the current page, use this method to point to specific help entry
    * ID: use this to display multiple help entries, the ID is usually a form ID nad must be applied to each help entry 
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.1
    * @version 1.0.1
    */          
    public function box_information_icon( $page_name, $view_name, $form_id ) {
        global $c2pm, $c2p_page_name, $c2p_tab_number;
        add_thickbox();
        
        $CSV2POST_Help = CSV2POST::load_class( 'C2P_Help', 'class-help.php', 'classes' );

        $help_array = $CSV2POST_Help->get_help_array();
        
        // start the hidden div
        $all_help_content = '<div id="infothickbox' . $form_id . '" style="display:none;">';   
        
        // the first content is like a short introduction to what the box/form is to be used for
        $all_help_content .= '<p>' . $help_array[ $page_name ][ $view_name ][ 'forms' ][ $form_id ][ 'formabout' ] . '</p>';

        // add a link encouraging user to visit site and read more OR visit YouTube video
        if( isset( $help_array[ $page_name ][ $view_name ][ 'forms' ][ $form_id ][ 'formreadmoreurl' ] ) ){
            $all_help_content .= '<p>';
            $all_help_content .= __( 'You are welcome to visit the', 'csv2post' ) . ' ';
            $all_help_content .= '<a href="' . $help_array[ $page_name ][ $view_name ][ 'forms' ][ $form_id ][ 'formreadmoreurl' ] . '"';
            $all_help_content .= 'title="' . __( 'Visit the CSV 2 POST website and read more about', 'csv2post' ) . ' ' . $help_array[ $page_name ][ $view_name ][ 'forms' ][ $form_id ][ 'formtitle' ] . '"';
            $all_help_content .= 'target="_blank"';
            $all_help_content .= '>';
            $all_help_content .= __( 'CSV 2 POST Website', 'csv2post' ) . '</a> ' . __( 'to read more about', 'csv2post' ) . ' ' . $help_array[ $page_name ][ $view_name ][ 'forms' ][ $form_id ][ 'formtitle' ];           
            $all_help_content .= '.</p>';
        }  
        
        // add a link to a Youtube
        if( isset( $help_array[ $page_name ][ $view_name ][ 'forms' ][ $form_id ][ 'formvideourl' ] ) ){
            $all_help_content .= '<p>';
            $all_help_content .= __( 'There is a', 'csv2post' ) . ' ';
            $all_help_content .= '<a href="' . $help_array[ $page_name ][ $view_name ][ 'forms' ][ $form_id ][ 'formvideourl' ] . '"';
            $all_help_content .= 'title="' . __( 'Go to YouTube and watch a video about', 'csv2post' ) . ' ' . $help_array[ $page_name ][ $view_name ][ 'forms' ][ $form_id ][ 'formtitle' ] . '"';
            $all_help_content .= 'target="_blank"';
            $all_help_content .= '>';            
            $all_help_content .= __( 'YouTube Video', 'csv2post' ) . '</a> ' . __( 'about', 'csv2post' ) . ' ' . $help_array[ $page_name ][ $view_name ][ 'forms' ][ $form_id ][ 'formtitle' ];           
            $all_help_content .= '.</p>';
        }

        // add a link to a Youtube
        if( isset( $help_array[ $page_name ][ $view_name ][ 'forms' ][ $form_id ][ 'formdiscussurl' ] ) ){
            $all_help_content .= '<p>';
            $all_help_content .= __( 'We invite you to take discuss', 'csv2post' ) . ' ';
            $all_help_content .= '<a href="' . $help_array[ $page_name ][ $view_name ][ 'forms' ][ $form_id ][ 'formdiscussurl' ] . '"';
            $all_help_content .= 'title="' . __( 'Visit the WebTechGlobal forum to discuss', 'csv2post' ) . ' ' . $help_array[ $page_name ][ $view_name ][ 'forms' ][ $form_id ][ 'formtitle' ] . '"';
            $all_help_content .= 'target="_blank"';
            $all_help_content .= '>';            
            $all_help_content .= $help_array[ $page_name ][ $view_name ][ 'forms' ][ $form_id ][ 'formtitle' ] . '</a> ' . __( 'on the WebTechGlobal Forum', 'csv2post' );           
            $all_help_content .= '.</p>';
        }        
        
        // list information for each option 
        if( isset( $help_array[ $page_name ][ $view_name ][ 'forms' ][ $form_id ][ 'options' ] ) ){
            foreach( $help_array[ $page_name ][ $view_name ][ 'forms' ][ $form_id ][ 'options' ] as $option_id => $option_array ){
                
                // start paragraph for the option
                $all_help_content .= '<h3>' . $option_array['optiontitle'] . '</h3>';
                $all_help_content .= '<p>';
                
                $all_help_content .= $option_array['optiontext'];
                
                if( isset( $option_array['optionurl'] ) ){
                    $all_help_content .= ' <a href="' . $option_array['optionurl'] . '"';
                    $all_help_content .= ' title="' . __( 'Read More about', 'csv2post' )  . ' ' . $option_array['optiontitle'] . '"';
                    $all_help_content .= ' target="_blank">';
                    $all_help_content .= __( 'Read More', 'csv2post' ) . '</a>';      
                }
      
                if( isset( $option_array['optionvideourl'] ) ){
                    $all_help_content .= ' - <a href="' . $option_array['optionvideourl'] . '"';
                    $all_help_content .= ' title="' . __( 'Watch a video about', 'csv2post' )  . ' ' . $option_array['optiontitle'] . '"';
                    $all_help_content .= ' target="_blank">';
                    $all_help_content .= __( 'Video', 'csv2post' ) . '</a>';      
                }
                
                $all_help_content .= '</p>';
            }
        }
               
        // close the hidden div                 
        $all_help_content .= '</div>';
        
        // build linked image
        $all_help_content .= '<a href="#TB_inline?width=600&height=550&inlineId=infothickbox' . $form_id . '" class="thickbox" title="';
        $all_help_content .= __( 'Help for ', 'csv2post' ) . $help_array[ $page_name ][ $view_name ][ 'forms' ][ $form_id ][ 'formtitle' ] . '">';
        $all_help_content .= '<img src="' . WTG_CSV2POST_IMAGES_URL . 'info-icon.gif" alt="';
        $all_help_content .= __( 'Click icon to view help for ', 'csv2post' ) . $help_array[ $page_name ][ $view_name ][ 'forms' ][ $form_id ][ 'formtitle' ] . '"></a>';
      
        echo $all_help_content;
    }
                                
    public function get_notice_array() {
        $a = get_option( 'csv2post_notifications' );
       
        $c2p_notice_array = maybe_unserialize( $a);
        if(!is_array( $c2p_notice_array ) ){
            return array();    
        }
        
        // delete some expired admin notices
        if( isset( $c2p_notice_array['admin'] ) )
        {
            foreach( $c2p_notice_array['admin'] as $key => $notice){
                
                if( isset( $notice['created'] ) )
                {
                    $projected = $notice['created'] + 60;
                    
                    if( $projected < time() )
                    {
                        unset( $c2p_notice_array['admin'][$key] );    
                    }                                               
                }
                else
                {       
                    unset( $c2p_notice_array['admin'][$key] );
                }
            }
        }
      
        // delete some expired user notices
        if( isset( $c2p_notice_array['users'] ) ){
 
            foreach( $c2p_notice_array['users'] as $owner_id => $owners_notices){
                
                foreach( $owners_notices as $key => $notice)
                {
                    if( isset( $notice['created'] ) )
                    {
                        $projected = $notice['created'] + 60;
                        
                        if( $projected < time() )
                        {
                            unset( $c2p_notice_array['users'][$key] );    
                        }                                               
                    }
                    else
                    {
                        unset( $c2p_notice_array['users'][$key] );
                    }
                }
            }   
        }     
           
        // any notices unset due to expiry will be reflected in update during display procedure        
        return $c2p_notice_array;    
    }
    
    public function update_notice_array() {
        global $c2p_notice_array;      
        return update_option( 'csv2post_notifications',maybe_serialize( $c2p_notice_array ) );    
    }    
     
    /**
    * use to create an in-content notice i.e. the notice is built and echoed straight away it is not
    * stored within an array for output at a later point in the plugin or WordPress loading 
    */
    
    /**
    * Used to build the HTML for a notice which can be stored or displayed instantly.
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 6.0.0
    * @version 1.1.3
    * 
    * @returns HTML notice
    * 
    * @param mixed $type updated, warning, error, success, info
    * @param mixed $size
    * @param mixed $title
    * @param mixed $message
    * @param mixed $helpurl
    */
    public function notice_return( $type, $size, $title = false, $message = 'no message has been set', $helpurl = false, $forcewtgstyle = false ){
        global $csv2post_settings;
        
        // Is WordPress core style to be returned? 
        if( $forcewtgstyle === false ) {
            if( isset( $csv2post_settings['noticesettings']['wpcorestyle'] ) && $csv2post_settings['noticesettings']['wpcorestyle'] == 'enabled' ) {
       
                // force style to updated if $type is not a wp style (WTG styles are passed to $type)
                $wp_notice_classes = array( 'updated', 'error', 'update-nag' );
                if( !in_array( $type, $wp_notice_classes ) ) { 
                    $type = 'updated';
                }
                 
                // this class causes the notice to appear at the top of screen so is not suitable for use deep inside content
                $output = '<div class="' . $type . '">
                    <h4>' . $title . '</h4>
                    <p>' . $message . '</p>
                </div>'; 
                
                return $output;
            } 
        }
                        
        // arriving here means user has activated WTG Notice Boxes style
        $output = '<div class="'.$type.$size.'">';
        
        // add help link
        $helplink = '';
        if( $helpurl){
            $helplink = '<a href="'.$helpurl.'" title="Get more help at WebTechGlobal.co.uk" target="_blank">?</a>';
        }
        
        if( $size != 'Tiny' && $title !== false ){$output .= '<h4>'.$title. ' ' .$helplink.'</h4>';}       
        $output .= '<p>' . ucfirst( $message) . '</p>';    
        $output .= '</div>';
        return $output;        
    }
    
    /**
    * A notice is meant to be instant and for the current user only. This stores the notice
    * in the $notice_array it does not output.   
    * 
    * a) use create_prompt() to get an action from the current user based on conditions i.e. configuration issue
    * b) use create_message() to create a notice for another user for when they login 
    * 
    * @param mixed $message
    * @param mixed $type
    * @param mixed $size
    * @param mixed $title
    * @param mixed $sensitive
    */
    public function create_notice( $message, $type = 'info', $size = 'Small', $title = false, $sensitive = false, $helpurl = false ){
        global $c2p_notice_array, $current_user;
                
        // requires user to be logged in as the first security step
        // return if no current user, this allows us to use create_notice() in functions which are used in both manual and automated procedures                             
        if(!isset( $current_user->ID) || !is_numeric( $current_user->ID) ){return false;}
                                                 
        $key = time() . rand(10000,99999);

        // another security step is to add the notice to the notice array with user ID which is checked before displaying
        if( $sensitive === false ) {   
            
            $c2p_notice_array['notices'][$current_user->ID][$key]['sensitive'] = false;
            $c2p_notice_array['notices'][$current_user->ID][$key]['message'] = $message;
            $c2p_notice_array['notices'][$current_user->ID][$key]['type'] = $type;
            $c2p_notice_array['notices'][$current_user->ID][$key]['size'] = $size;
            $c2p_notice_array['notices'][$current_user->ID][$key]['title'] = $title; 
            $c2p_notice_array['notices'][$current_user->ID][$key]['created'] = time();
            $c2p_notice_array['notices'][$current_user->ID][$key]['helpurl'] = $helpurl;

                    
        } elseif( $sensitive === true) {
            
            // another security measure which is optional is to make a sensitive notice which is stored in the 
            // applicable users meta rather than making it part of an array which is printed on-screen
            // then we can display the notice anywhere
            $c2p_notice_array['users'][$current_user->ID][$key]['sensitive'] = false;
            
            # to be complete, this procedure will store the notice in user meta with the $key being used in meta_key
            # even when we start using a database table to store all notices, we will do this to avoid that table
            # holding sensitive data. Instead we will try to group subscriber/customer data where some already exists.                         
        }

        return $this->update_notice_array( $c2p_notice_array );
    }
    
    /**
    * Displays a no permission notice
    * 
    * Call the method and follow it up with a return. Use it before a procedure within a method. Only step into the procedure
    * if user has the required WordPress capability. So this method is called within the if statement. 
    */
    public function adminonly() {
        $this->create_notice( 'You do not have permission to complete that action.', 'warning', 'Small', 'No Permission' );
    }
    
    /**
    * 
    */
    public function invaliduserid() {
        $this->create_notice( 'You did not enter a valid WordPress user ID which are always numeric and do not have any special characters.', 'warning', 'Small', 'Invalid User ID' );
    }
    
    /**
    * Prompts are sticky by default, requiring a users action, they will only be deleted when too many exist
    * or there is an expiry. 
    */
    public function create_prompt() {
        ## $c2p_notice_array['prompts'][$owner][$key]['message'] = $message;    
    }
    
    /**
    * Send a message in the form of a notice, to a specific user. May evolve into part of a messaging system/class.
    * 
    * a) admin actions can cause a message to be created so subscribers are notified the moment they login
    * b) client actions within their account i.e. invoice request, can create a message for the lead developer of clients project 
    */
    public function create_message() {
        ## $c2p_notice_array['messages'][$owner][$key]['message'] = $message;    
    }
    
    public function display_all() {
        $this->display_users_notices();    
    }
    
    public function display_users_notices() {
        global $c2p_notice_array, $current_user, $csv2post_settings;
        
        $c2p_notice_array = $this->get_notice_array();
        
        if(!isset( $c2p_notice_array['notices'][$current_user->ID] ) ){return;}
 
        foreach( $c2p_notice_array['notices'][$current_user->ID] as $key => $owners_notices){

            if( isset( $owners_notices['sensitive'] ) && $owners_notices['sensitive'] === true) {
                # to be complete - this will be used for sensitive information 
                # this method will retrieve data from user meta, storage procedure to be complete    
            } else {

                $helpurl = false;
                if( isset( $owners_notices['helpurl'] ) ){$helpurl = $owners_notices['helpurl'];}
                echo self::notice_return( $owners_notices['type'], $owners_notices['size'], $owners_notices['title'], $owners_notices['message'], $helpurl);    
  
            }   

            // users notices have been displayed, unset to prevent second display
            unset( $c2p_notice_array['notices'][$current_user->ID] );
        }
                                       
        $this->update_notice_array( $c2p_notice_array );            
    }
        
    /**
    * Returns notification HTML.
    * This function has the html and css to make all notifications standard.
    * 
    * @deprecated please use alternative functions in the notice class
    * 
    * @param mixed $type
    * @param string $helpurl
    * @param string $size
    * @param string $title
    * @param string $message
    * @param bool $clickable
    * @param mixed $persistent
    * @param mixed $id, used for persistent messages which use jQuery UI button, the ID should be the notice ID
    */
    public function notice_display_depreciated( $type, $helpurl, $size, $title, $message, $clickable, $persistent = false, $id = false ){
        // begin building output
        $output = '';
                        
        // if clickable (only allowed when no other links being used) - $helpurl will actually be a local url to another plugin or WordPress page
        if( $clickable){
            $output .= '<div class="stepLargeTest"><a href="'.$helpurl.'">';
        }

        // start div
        $output .= '<div class="'.$type.$size.'">';     
       
        // set h4 when required
        if( $size != 'Tiny' ){$output .= '<h4>'.$title.'</h4>';}

        $output .= '<p>' . $message . '</p>';

        // if is not clickable (entire div) and help url is not null then display a clickable ico
        $thelink = '';
        if( $helpurl != '' && $helpurl != false ){
            //$output .= '<a class="jquerybutton" href="'.$helpurl.'" target="_blank">Get Help</a>';
        }   
            
        // complete notice with closing div
        $output .= '</div>';
        
        // end wrapping with link and styled div for making div clickable when required
        if( $clickable){$output .= '</a></div>';}

        return $output;    
    }
    
    /**
    * Notice html is printed where this function is used 
    */
    public function n_incontent_depreciated( $message, $type = 'info', $size = 'Small', $title = '', $helpurl = '' ){
        echo $this->notice_depreciated( $message, $type, $size, $title, $helpurl, 'return' );    
    }
    
    /**
    * Standard notice format to be displayed on submission of a form (Large).
    * Change the size if a plugin using core is to have a different format.
    * 
    * @deprecated use csv2post_n_postresult as of 13th February 2013
    */
    public function notice_postresult_depreciated( $type, $title, $message, $helpurl = false, $user = 'admin' ){
        $this->notice_depreciated( $message, $type, 'Large', $title, $helpurl, 'echo' );    
    } 
    
    /**
    * New Notice Function (replacing C2P_Notice::notice_depreciated() )
    * 1. None clickable (using a different function for that)
    * 2. Not a Step Notice (also using a different function for that)
    * 3. Does add link for help url though
    * 
    * @deprecated please use other functions in the Notice class
    */
    public function n_depreciated( $title, $mes, $style, $size, $atts = array() ){
        global $c2p_notice_array;
                    
        extract( shortcode_atts( array( 
            'url' => false,
            'output' => 'norm',// default normal echos html, return will return html, public also returns it but bypasses is_admin() etc
            'audience' => 'administrator',// admin or user (use to display a different message to visitors than to staff)
            'user_mes' => 'No user message giving',// only used when audience is set to user, user_mes replaces $mes
            'side' => 'private',// private,public (use to apply themes styles if customised, do not use for security )      
            'clickable' => false,// boolean
        ), $atts ) );
                  
        // do not allow a notice box if $output not stated as public and current visitor is not logged in
        // this forces backend messages which may be more private i.e. account info or key admin details
        if(!is_admin() && $output != 'public' ){
            // visitor is on front-end, but the $output set is not for public
            return false; 
        }
                       
        // if return wanted or $side == public (used to bypass is_admin() check)
        // this allows the notice to be printed within content where the function is called rather than within the $c2p_notice_array loop
        if( $output == 'return' || $output == 'public' ){
            return $this->notice_display_depreciated( $style, $url, $size, $title, $mes, $clickable, $persistent = false );
        }
                       
        // if user is not an administrator and notice is for administrators only do not display
        if ( $audience == 'administrator' && !current_user_can( 'manage_options' ) ) {
            return false;
        }
                
        // arriving here means normal, most common output to the backend of WordPress
        $c2p_notice_array = $this->persistentnotifications_array();
        
        // set next array key value
        $next_key = 0;

        // determine next array key
        if( isset( $c2p_notice_array['notifications'] ) ){    
            $next_key = CSV2POST::get_array_nextkey( $c2p_notice_array['notifications'] );
        }    
                       
        // add new message to the notifications array
        // this will be output during the current page loading. The notification will show once unless persistent is set to true
        $c2p_notice_array['notifications'][$next_key]['message'] = $mes;
        $c2p_notice_array['notifications'][$next_key]['type'] = $style;
        $c2p_notice_array['notifications'][$next_key]['size'] = $size;
        $c2p_notice_array['notifications'][$next_key]['title'] = $title;
        $c2p_notice_array['notifications'][$next_key]['helpurl'] = $url; 
        $c2p_notice_array['notifications'][$next_key]['output'] = $output;
        $c2p_notice_array['notifications'][$next_key]['audience'] = $audience;
        $c2p_notice_array['notifications'][$next_key]['user_mes'] = $user_mes;
        $c2p_notice_array['notifications'][$next_key]['side'] = $side;
        $c2p_notice_array['notifications'][$next_key]['clickable'] = $clickable;
                          
        $this->update_persistentnotifications_array( $c2p_notice_array );
    } 
    
    /**
    * Display a standard notification after form submission.
    * This function simply helps to quickly apply a notice to the outcome while using the same
    * configuration for all form submissions.
    * 
    * @param mixed $type
    * @param mixed $title
    * @param mixed $message
    * @param mixed $helpurl
    * @param mixed $user
    */
    public function n_postresult_depreciated( $type, $title, $message, $helpurl = false, $user = 'admin' ){ 
        $this->n_depreciated( $title, $message, $type, 'Large' );  
    }
    
    /**
    * Updates notifications array in WordPress options table
    * 
    * @param array $notifications_array
    * @return bool
    */
    public function update_persistentnotifications_array( $notifications_array ){
        return update_option( 'csv2post_notifications',maybe_serialize( $notifications_array ) );    
    }
    
    /**
    * Creates a new notification with a long list of style options available.
    * 
    * @deprecated do not use this function
    */
    public function notice_depreciated( $message, $type = 'success', $size = 'Extra', $title = false, $helpurl = 'www.webtechglobal.co.uk', $output_type = 'echo', $persistent = false, $clickable = false, $user_type = false ){
        global $c2p_notice_array;
        if( is_admin() || $output_type == 'public' ){
            
            // change unexpected values into expected values (for flexability and to help avoid fault)
            if( $type == 'accepted' ){$type == 'success';}
            if( $type == 'fault' ){$type == 'error';}
            if( $type == 'next' ){$type == 'step';}
            
            // prevent div being clickable if help url giving (we need to more than one link in the message)
            if( $helpurl != false && $helpurl != '' && $helpurl != 'http://www.csv2post.com/support' ){$clickable = false;}
                                     
            if( $output_type == 'return' || $output_type == 'public' ){   
                return $this->notice_display_depreciated( $type, $helpurl, $size, $title, $message, $clickable, $persistent);
            }else{
                // establish next array key
                $next_key = 0;
                if( isset( $c2p_notice_array['notifications'] ) ){
                    $next_key = CSV2POST::get_array_nextkey( $c2p_notice_array['notifications'] );
                }
                
                // add new message to the notifications array
                $c2p_notice_array['notifications'][$next_key]['message'] = $message;
                $c2p_notice_array['notifications'][$next_key]['type'] = $type;
                $c2p_notice_array['notifications'][$next_key]['size'] = $size;
                $c2p_notice_array['notifications'][$next_key]['title'] = $title;
                $c2p_notice_array['notifications'][$next_key]['helpurl'] = $helpurl; 
                $c2p_notice_array['notifications'][$next_key]['clickable'] = $clickable; 
                          
                $this->update_persistentnotifications_array( $c2p_notice_array );       
            }
        } 
    }    
    
    /**                                              
    * Outputs the contents of $c2p_notice_array, used in CSV2POST::pageheader().
    * Will hold new and none persistent notifications. May also hold persistent. 
    */
    public function output_depreciated() {
        $c2p_notice_array = self::persistentnotifications_array();    
        if( isset( $c2p_notice_array['notifications'] ) ){
                                                        
            foreach( $c2p_notice_array['notifications'] as $key => $notice){
                                
                // persistent notices are handled by another function as the output is different
                if(!isset( $notice['persistent'] ) || $notice['persistent'] != false ){
            
                    // set default values where any requires are null
                    if(!isset( $notice['type'] ) ){$notice['type'] = 'info';}
                    if(!isset( $notice['helpurl'] ) ){$notice['helpurl'] = false;} 
                    if(!isset( $notice['size'] ) ){$notice['size'] = 'Large';} 
                    if(!isset( $notice['title'] ) ){$notice['title'] = 'Sorry No Title Was Provided';}
                    if(!isset( $notice['message'] ) ){$notice['message'] = 'Sorry No Message Was Provided';}
                    if(!isset( $notice['clickable'] ) ){$notice['clickable'] = false;} 
                    if(!isset( $notice['persistent'] ) ){$notice['persistent'] = false;}
                    if(!isset( $notice['id'] ) ){$notice['id'] = false;} 
                      
                    echo $this->notice_display_depreciated( $notice['type'], $notice['helpurl'], $notice['size'], $notice['title'], $notice['message'], $notice['clickable'], $notice['persistent'], $notice['id'] );                                               
                
                    // notice has been displayed so we now removed it
                    unset( $c2p_notice_array['notifications'][$key] );
                }
            }
                               
            $this->update_persistentnotifications_array( $c2p_notice_array );
        }  
    }
    
    /**
    * Gets notifications array if it exists in WordPress options table else returns empty array
    */
    public function persistentnotifications_array() {
        $a = get_option( 'csv2post_notifications' );
        $v = maybe_unserialize( $a);
        if(!is_array( $v) ){
            return array();    
        }
        return $v;    
    }  

    /**
     * Register a filter hook on the admin footer
     *
     * @since 8.1.3 
     */
    public function add_admin_footer_text() {
        // show admin footer message (only on pages of CSV 2 POST)
        add_filter( 'admin_footer_text', array( $this, '_admin_footer_text' ) );
    }
    
    /**
     * Add a CSV 2 POST "Thank You" message to the admin footer content
     *
     * @since 8.1.3
     *
     * @param string $content Current admin footer content
     * @return string New admin footer content
     */
    public function _admin_footer_text( $content ) {
        global $c2p_is_free;
        $content .= ' &bull; ' . __( 'Thank you for using <a href="http://webtechglobal.co.uk/csv-2-post/">CSV 2 POST</a>.', 'csv2post' );
        // FREE EDITIONS ONLY $content .= ' ' . sprintf( __( 'Support the plugin with your <a href="%s">donation</a>!', 'csv2post' ), 'http://webtechglobal.co.uk/donate/' );
        return $content;
    } 
    
    /**
    * Builds a nonced admin link styled as button by WordPress
    *
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.1
    *
    * @return string html a href link nonced by WordPress  
    * 
    * @param mixed $page - $_GET['page']
    * @param mixed $action - examplenonceaction
    * @param mixed $title - Any text for a title
    * @param mixed $text - link text
    * @param mixed $values - begin with & followed by values
    */
    public function action_url( $file = 'admin.php', $page = false, $action = false, $values = false ){
        
        // build url
        $value_added = false;
        $url = '';

        $url .= admin_url() . $file; 
        
        if( $action || $values ){
            $url .= '?';
        }
        
        if( $page !== false ){ 
            
            $url .= 'page=' . $page; 
            $value_added = true;
        
        }
        
        if( $action !== false ){ 
            
            if( $value_added ){
                $url .= '&';
            }
            
            $url .= 'action=' . $action; 
            $value_added = true;}
        
        if( $values !== false ){ 
            
            if( $value_added ){
                $url .= '&';
            }
                        
            $url .= $values; 
            $value_added = true;
        
        }
        
        return wp_nonce_url( $url );
    }     
    
    /**
    * Stores the giving form ID, the inputs ID and the validation that should be applied to any entry.
    * This information is re-called during processing to validate and ensure the form has not been tampered 
    * with after being rendered. 
    * 
    * This is done on a per user basis, data being stored in user meta table.
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.32
    * @version 1.1
    */
    public function register_input_validation( $input_title, $input_name, $input_id, $input_validation ) {
                           
        // array of validation types - the string is part of function name i.e. input_validation_alphanumeric()
        $validation_types = array( 'unset', 'alphanumeric', 'URL' );// add more along with validation functionality
        // unset - used during development to force removal of registered input
                   
        // ensure passed $input_validation is expected else do not register, this prevents problems during processing
        if( !in_array( $input_validation, $validation_types ) ) {
            return false;    
        }
                   
        // get the form validation array
        $form_validation_array = get_option( 'csv2post_formvalidation' );
        
        // if unset requested and the current input is registered then removal that registration
        if( $input_validation === 'unset' && isset( $form_validation_array[ $input_name ] ) ) {
            unset( $form_validation_array[ $input_name ] );
            return;    
        }
        
        // if false then initiate array
        if( !$form_validation_array ) {
            $form_validation_array = array();
        }
            
        // we use the $input_id (an actual HTML ID) to apply the correct validation at the point of $_POST or $_GET processing
        $form_validation_array[ $input_name ]['title'] = $input_title;// used to make user readable notice on invalid entry
        $form_validation_array[ $input_name ]['id'] = $input_id;// used for confirming the submitted $_POST value
        $form_validation_array[ $input_name ]['validation'] = $input_validation;
           
        update_option( 'csv2post_formvalidation', $form_validation_array );
    }
    
    /**
    * Returns what validation is to be used on form input value
    * 
    * @returns optional array (human rea
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.32
    * @version 1.1
    */
    public function get_input_validation_methods( $name, $return = 'validation' ) {
        
        // get the form validation array
        $form_validation_array = get_option( 'csv2post_formvalidation' );  
        
        // for now I do not want to assume the input ID will exist, when confident in the system this could be
        // removed and the security enforced further.
        if( isset( $form_validation_array[ $name ] ) ) {
            
            if( $return === 'validation' ) {
                return $form_validation_array[ $name ]['validation']; 
            } elseif( $return === 'array' ) {
                return $form_validation_array[ $name ]; 
            } else {
                return $form_validation_array[ $name ]['validation'];
            } 
        }
        
        return false;   
    }    
    
    /**
    * Displayed on all views when no current project is set.
    * Rather than hiding pages and hiding what the plugin has to offer on initial installation.
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.32
    * @version 1.1
    */
    public function metabox_nocurrentproject() {
        echo '<p>';
        _e( 'You do not have a "Current Project" set and so the features on this page have been hidden. 
        The Current Project is the one you are working on. Most of the plugins
        pages only display information and options for that project. You have not created your first project or delete
        the one that was active.', 'csv2post' );
        echo '</p>';
    }

    /**
    * A table row with menu of all WordPress capabilities
    * 
    * @param mixed $title
    * @param mixed $id
    * @param mixed $name
    * @param mixed $current
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.33
    * @version 1.1
    * 
    * @deprecated use class-forms.php
    */
    public function option_menu_capabilities( $title, $id, $name, $current = 'nocurrentvalue123' ){

        // create array of capabilities without roles
        global $wp_roles; 
        $capabilities_array = $this->WPCore->capabilities();
        
        // put into alphabetical order as it is a long list 
        ksort( $capabilities_array );
        ?>
        <!-- Option Start -->        
        <tr valign="top">
            <th scope="row"><label for="<?php echo $id; ?>"><?php echo $title; ?></label></th>
            <td>            
                <select name="<?php echo $name;?>" id="<?php echo $id;?>">
                    <?php            
                    foreach( $capabilities_array as $key => $cap ){
                        $selected = '';
                        if( $key == $current){
                            $selected = 'selected="selected"';
                        } 
                        echo '<option value="'.$key.'" '.$selected.'>' . $key . '</option>';    
                    }
                    ?>
                </select>                  
            </td>
        </tr>
        <!-- Option End --><?php          
    }

    /**
    * Menu of CRON repeat methods.
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.33
    * @version 1.1
    * 
    * @deprecated use class-forms.php
    */
    public function option_menu_cronrepeat( $title, $id, $name, $current = 'nocurrentvalue123' ) {
        ?>
        <!-- Option Start -->        
        <tr valign="top">
            <th scope="row"><label for="<?php echo $id; ?>"><?php echo $title; ?></label></th>
            <td>            
                <select name="<?php echo $name;?>" id="<?php echo $id;?>">
                    <option value="hourly" <?php if( $current == 'hourly' ){ echo $selected; }?>>Hourly</option>
                    <option value="twicedaily" <?php if( $current == 'twicedaily' ){ echo $selected; }?>>Twice Daily</option>
                    <option value="daily" <?php if( $current == 'daily' ){ echo $selected; }?>>Daily</option>
                </select>                  
            </td>
        </tr>
        <!-- Option End --><?php     
    }
    
    /**
    * Menu of permitted CRON hooks.
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.33
    * @version 1.1
    * 
    * @deprecated use class-forms.php
    */
    public function option_menu_cronhooks( $title, $id, $name, $current = 'nocurrentvalue123' ) {
        $selected = 'selected="selected"';
        ?>
        <!-- Option Start -->        
        <tr valign="top">
            <th scope="row"><label for="<?php echo $id; ?>"><?php echo $title; ?></label></th>
            <td>            
                <select name="<?php echo $name;?>" id="<?php echo $id;?>">
                    <option value="eventcheckwpcron" <?php if( $current == 'eventcheckwpcron' ){ echo $selected; }?>>eventcheckwpcron</option>
                </select>                  
            </td>
        </tr>
        <!-- Option End --><?php     
    }
    
    /**
    * Day, Month, Year, Hour and Minute inputs on a single row (taking from Edit Post screen)
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.33
    * @version 1.1
    * 
    * @deprecated use class-forms.php
    */
    public function option_date_time( $title, $name, $id, $current_value, $required = false, $validation = false ) {
        self::register_input_validation( $title, $name, $id, $validation );// stored data is used to apply correct validation during processing
        
        global $wp_locale;

        $time_adj = current_time('timestamp');

        $jj = gmdate( 'd', $time_adj );
        $mm = gmdate( 'm', $time_adj );
        $aa = gmdate( 'Y', $time_adj );
        $hh = gmdate( 'H', $time_adj );
        $mn = gmdate( 'i', $time_adj );
        $ss = gmdate( 's', $time_adj );

        $month = '<select name="mm"';
        
        for ( $i = 1; $i < 13; $i = $i +1 ) {
            $monthnum = zeroise($i, 2);
            $month .= "\t\t\t" . '<option value="' . $monthnum . '" ' . selected( $monthnum, $mm, false ) . '>';
            /* translators: 1: month number (01, 02, etc.), 2: month abbreviation */
            $month .= sprintf( __( '%1$s-%2$s' ), $monthnum, $wp_locale->get_month_abbrev( $wp_locale->get_month( $i ) ) ) . "</option>\n";
        }
        $month .= '</select>';

        $day = '<input type="text" id="jj" name="jj" value="' . $jj . '" size="2" maxlength="2" autocomplete="off" />';
        $year = '<input type="text" ="aa" name="aa" value="' . $aa . '" size="4" maxlength="4" autocomplete="off" />';
        $hour = '<input type="text" id="hh" name="hh" value="' . $hh . '" size="2" maxlength="2" autocomplete="off" />';
        $minute = '<input type="text" id="mn" name="mn" value="' . $mn . '" size="2" maxlength="2" autocomplete="off" />';

        ?>
        <!-- Option Start -->        
        <tr valign="top">
            <th scope="row"><label for="<?php echo $id; ?>"><?php echo $title; ?>
            </label></th>
            <td>            
                <?php  
                /* translators: 1: month, 2: day, 3: year, 4: hour, 5: minute */
                printf( __( '%1$s %2$s, %3$s @ %4$s : %5$s' ), $month, $day, $year, $hour, $minute );
                ?>                 
            </td>
        </tr>
        <!-- Option End --><?php              
    }

    /**
    * Collapse giving box on the giving page for the giving user
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.33
    * @version 1.1
    */
    public function collapse_box_for_user( $userid, $page, $boxid ) {
        $optionName = "closedpostboxes_$page";
        $close = get_user_option( $optionname, $userid );
        $clodeids = explode( ',', $close );
        $clodeids[] = $boxId;
        $clodeids = array_unique( $clodeids ); // remove duplicate Ids
        $close = implode( ',', $clodeids);
        update_user_option( $userid, $optionname, $close );
    }    
           
}// class CSV2POST_UI 
  
/**
* Adds a WordPress pointer
* 
* @author Ryan R. Bayne
* @package CSV 2 POST
* @since 8.1.3
* @version 1.1
*/
class C2P_Pointers {
    public function __construct( $htmlid1, $pointerid1, $title1, $description1  ) {
        $this->htmlid = $htmlid1;
        $this->pointerid = $pointerid1;
        $this->title = $title1;
        $this->description = $description1; 
    }   
                                                                                                          
    public function add_action() {                                                                       
        add_action( 'admin_print_footer_scripts', array( $this, 'custom_admin_pointers_footer_script' ) );         
    }
    
    public function custom_admin_pointers_footer_script() {

        $pointercontent = '<h3>' . $this->title . '</h3>'; 
        $pointercontent .= '<p>' . $this->description . '</p>';
        
        // In JavaScript below:
        // * "position" -- we use a different method, indicating:
        // ** What spot on the targeted element do we hang on to?
        // ** What spot on our pointer do we want hanging on to the targeted element?
        // Here we take the top left corner of our pointer and hang it by the bottom left corner of the entry field box.
        ?>
        <script type="text/javascript">// <![CDATA[
        jQuery(document).ready(function($) {
            /* make sure pointers will actually work and have content */
            if(typeof(jQuery().pointer) != 'undefined') {
                $('#<?php echo $this->htmlid; ?>').pointer({
                    content: '<?php echo $pointercontent; ?>',
                    position: {
                        at: 'left bottom',
                        my: 'left top'
                    },
                    close: function() {
                        $.post( ajaxurl, {
                            pointer: '<?php echo $this->pointerid; ?>',
                            action: 'dismiss-wp-pointer'
                        });
                    }
                }).pointer('open');
            }
        });
        // ]]></script>
        <?php
    }
}

/**
* Lists tickets post type using standard WordPress list table
*/
class C2P_Log_Table extends WP_List_Table {
    
    /** ************************************************************************
     * REQUIRED. Set up a constructor that references the parent constructor. We 
     * use the parent reference to set some default configs.
     ***************************************************************************/
    function __construct() {
        global $status, $page;
             
        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'movie',     //singular name of the listed records
            'plural'    => 'movies',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );
        
    }
    
    /** ************************************************************************
     * Recommended. This method is called when the parent class can't find a method
     * specifically build for a given column. Generally, it's recommended to include
     * one method for each column you want to render, keeping your package class
     * neat and organized. For example, if the class needs to process a column
     * named 'title', it would first see if a method named $this->column_title() 
     * exists - if it does, that method will be used. If it doesn't, this one will
     * be used. Generally, you should try to use custom column methods as much as 
     * possible. 
     * 
     * Since we have defined a column_title() method later on, this method doesn't
     * need to concern itself with any column with a name of 'title'. Instead, it
     * needs to handle everything else.
     * 
     * For more detailed insight into how columns are handled, take a look at 
     * WP_List_Table::single_row_columns()
     * 
     * @param array $item A singular item (one full row's worth of data)
     * @param array $column_name The name/slug of the column to be processed
     * @return string Text or HTML to be placed inside the column <td>
     **************************************************************************/
    function column_default( $item, $column_name){
             
        $attributes = "class=\"$column_name column-$column_name\"";
                
        switch( $column_name){
            case 'row_id':
                return $item['row_id'];    
                break;
            case 'timestamp':
                return $item['timestamp'];    
                break;                
            case 'outcome':
                return $item['outcome'];
                break;
            case 'category':
                echo $item['category'];  
                break;
            case 'action':
                echo $item['action'];  
                break;  
            case 'line':
                echo $item['line'];  
                break;                 
            case 'file':
                echo $item['file'];  
                break;                  
            case 'function':
                echo $item['function'];  
                break;                  
            case 'sqlresult':
                echo $item['sqlresult'];  
                break;       
            case 'sqlquery':
                echo $item['sqlquery'];  
                break; 
            case 'sqlerror':
                echo $item['sqlerror'];  
                break;       
            case 'wordpresserror':
                echo $item['wordpresserror'];  
                break;       
            case 'screenshoturl':
                echo $item['screenshoturl'];  
                break;       
            case 'userscomment':
                echo $item['userscomment'];  
                break;  
            case 'page':
                echo $item['page'];  
                break;
            case 'version':
                echo $item['version'];  
                break;
            case 'panelname':
                echo $item['panelname'];  
                break; 
            case 'tabscreenname':
                echo $item['tabscreenname'];  
                break;
            case 'dump':
                echo $item['dump'];  
                break; 
            case 'ipaddress':
                echo $item['ipaddress'];  
                break; 
            case 'userid':
                echo $item['userid'];  
                break; 
            case 'comment':
                echo $item['comment'];  
                break;
            case 'type':
                echo $item['type'];  
                break; 
            case 'priority':
                echo $item['priority'];  
                break;  
            case 'thetrigger':
                echo $item['thetrigger'];  
                break; 
                                        
            default:
                return 'No column function or default setup in switch statement';
        }
    }
                    
    /** ************************************************************************
    * Recommended. This is a custom column method and is responsible for what
    * is rendered in any column with a name/slug of 'title'. Every time the class
    * needs to render a column, it first looks for a method named 
    * column_{$column_title} - if it exists, that method is run. If it doesn't
    * exist, column_default() is called instead.
    * 
    * This example also illustrates how to implement rollover actions. Actions
    * should be an associative array formatted as 'slug'=>'link html' - and you
    * will need to generate the URLs yourself. You could even ensure the links
    * 
    * 
    * @see WP_List_Table::::single_row_columns()
    * @param array $item A singular item (one full row's worth of data)
    * @return string Text to be placed inside the column <td> (movie title only )
    **************************************************************************/
    /*
    function column_title( $item){

    } */
    
    /** ************************************************************************
     * REQUIRED! This method dictates the table's columns and titles. This should
     * return an array where the key is the column slug (and class) and the value 
     * is the column's title text. If you need a checkbox for bulk actions, refer
     * to the $columns array below.
     * 
     * The 'cb' column is treated differently than the rest. If including a checkbox
     * column in your table you must create a column_cb() method. If you don't need
     * bulk actions or checkboxes, simply leave the 'cb' entry out of your array.
     * 
     * @see WP_List_Table::::single_row_columns()
     * @return array An associative array containing column information: 'slugs'=>'Visible Titles'
     **************************************************************************/
    function get_columns() {
        $columns = array(
            'row_id' => 'Row ID',
            'timestamp' => 'Timestamp',
            'category'     => 'Category'
        );
        
        if( isset( $this->action ) ){
            $columns['action'] = 'Action';
        }                                       
           
        if( isset( $this->line ) ){
            $columns['line'] = 'Line';
        } 
                     
        if( isset( $this->file ) ){
            $columns['file'] = 'File';
        }
                
        if( isset( $this->function ) ){
            $columns['function'] = 'Function';
        }        
  
        if( isset( $this->sqlresult ) ){
            $columns['sqlresult'] = 'SQL Result';
        }

        if( isset( $this->sqlquery ) ){
            $columns['sqlquery'] = 'SQL Query';
        }
 
        if( isset( $this->sqlerror ) ){
            $columns['sqlerror'] = 'SQL Error';
        }
          
        if( isset( $this->wordpresserror ) ){
            $columns['wordpresserror'] = 'WP Error';
        }

        if( isset( $this->screenshoturl ) ){
            $columns['screenshoturl'] = 'Screenshot';
        }
        
        if( isset( $this->userscomment ) ){
            $columns['userscomment'] = 'Users Comment';
        }
 
        if( isset( $this->columns_array->page ) ){
            $columns['page'] = 'Page';
        }

        if( isset( $this->version ) ){
            $columns['version'] = 'Version';
        }
 
        if( isset( $this->panelname ) ){
            $columns['panelname'] = 'Panel Name';
        }
  
        if( isset( $this->tabscreenid ) ){
            $columns['tabscreenid'] = 'Screen ID';
        }

        if( isset( $this->tabscreenname ) ){
            $columns['tabscreenname'] = 'Screen Name';
        }

        if( isset( $this->dump ) ){
            $columns['dump'] = 'Dump';
        }

        if( isset( $this->ipaddress) ){
            $columns['ipaddress'] = 'IP Address';
        }

        if( isset( $this->userid ) ){
            $columns['userid'] = 'User ID';
        }

        if( isset( $this->comment ) ){
            $columns['comment'] = 'Comment';
        }

        if( isset( $this->type ) ){
            $columns['type'] = 'Type';
        }
                                    
        if( isset( $this->priority ) ){
            $columns['priority'] = 'Priority';
        }
       
        if( isset( $this->thetrigger ) ){
            $columns['thetrigger'] = 'Trigger';
        }

        return $columns;
    }
    
    /** ************************************************************************
     * Optional. If you want one or more columns to be sortable (ASC/DESC toggle), 
     * you will need to register it here. This should return an array where the 
     * key is the column that needs to be sortable, and the value is db column to 
     * sort by. Often, the key and value will be the same, but this is not always
     * the case (as the value is a column name from the database, not the list table).
     * 
     * This method merely defines which columns should be sortable and makes them
     * clickable - it does not handle the actual sorting. You still need to detect
     * the ORDERBY and ORDER querystring variables within prepare_items_further() and sort
     * your data accordingly (usually by modifying your query ).
     * 
     * @return array An associative array containing all the columns that should be sortable: 'slugs'=>array( 'data_values',bool)
     **************************************************************************/
    function get_sortable_columns() {
        $sortable_columns = array(
            //'post_title'     => array( 'post_title', false ),     //true means it's already sorted
        );
        return $sortable_columns;
    }
    
    /** ************************************************************************
     * Optional. If you need to include bulk actions in your list table, this is
     * the place to define them. Bulk actions are an associative array in the format
     * 'slug'=>'Visible Title'
     * 
     * If this method returns an empty value, no bulk action will be rendered. If
     * you specify any bulk actions, the bulk actions box will be rendered with
     * the table automatically on display().
     * 
     * Also note that list tables are not automatically wrapped in <form> elements,
     * so you will need to create those manually in order for bulk actions to function.
     * 
     * @return array An associative array containing all the bulk actions: 'slugs'=>'Visible Titles'
     **************************************************************************/
    function get_bulk_actions() {
        $actions = array(

        );
        return $actions;
    }
    
    /** ************************************************************************
     * Optional. You can handle your bulk actions anywhere or anyhow you prefer.
     * For this example package, we will handle it in the class to keep things
     * clean and organized.
     * 
     * @see $this->prepare_items_further()
     **************************************************************************/
    function process_bulk_action() {
        
        //Detect when a bulk action is being triggered...
        if( 'delete'===$this->current_action() ) {
            wp_die( 'Items deleted (or they would be if we had items to delete)!' );
        }
        
    }
    
    /** ************************************************************************
     * REQUIRED! This is where you prepare your data for display. This method will
     * usually be used to query the database, sort and filter the data, and generally
     * get it ready to be displayed. At a minimum, we should set $this->items and
     * $this->set_pagination_args(), although the following properties and methods
     * are frequently interacted with here...
     * 
     * @global WPDB $wpdb
     * @uses $this->_column_headers
     * @uses $this->items
     * @uses $this->get_columns()
     * @uses $this->get_sortable_columns()
     * @uses $this->get_pagenum()
     * @uses $this->set_pagination_args()
     **************************************************************************/
    function prepare_items_further( $data, $per_page = 5) {
        global $wpdb; //This is used only if making any database queries        
        
        /**
         * REQUIRED. Now we need to define our column headers. This includes a complete
         * array of columns to be displayed (slugs & titles), a list of columns
         * to keep hidden, and a list of columns that are sortable. Each of these
         * can be defined in another method (as we've done here) before being
         * used to build the value for our _column_headers property.
         */
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        
        /**
         * REQUIRED. Finally, we build an array to be used by the class for column 
         * headers. The $this->_column_headers property takes an array which contains
         * 3 other arrays. One for all columns, one for hidden columns, and one
         * for sortable columns.
         */
        $this->_column_headers = array( $columns, $hidden, $sortable);
        
        /**
         * Optional. You can handle your bulk actions however you see fit. In this
         * case, we'll handle them within our package just to keep things clean.
         */
        $this->process_bulk_action();
      
        /**
         * REQUIRED for pagination. Let's figure out what page the user is currently 
         * looking at. We'll need this later, so you should always include it in 
         * your own package classes.
         */
        $current_page = $this->get_pagenum();
        
        /**
         * REQUIRED for pagination. Let's check how many items are in our data array. 
         * In real-world use, this would be the total number of items in your database, 
         * without filtering. We'll need this later, so you should always include it 
         * in your own package classes.
         */
        $total_items = count( $data);

        /**
         * The WP_List_Table class does not handle pagination for us, so we need
         * to ensure that the data is trimmed to only the current page. We can use
         * array_slice() to 
         */
        $data = array_slice( $data,(( $current_page-1)*$per_page), $per_page);
 
        /**
         * REQUIRED. Now we can add our *sorted* data to the items property, where 
         * it can be used by the rest of the class.
         */
        $this->items = $data;
  
        /**
         * REQUIRED. We also have to register our pagination options & calculations.
         */
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil( $total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }
}

class C2P_Projects_Table extends WP_List_Table {

    function __construct() {
        global $status, $page;
             
        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'movie',     //singular name of the listed records
            'plural'    => 'movies',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );
        
    }

    function column_default( $item, $column_name){
             
        $attributes = "class=\"$column_name column-$column_name\"";
                
        switch( $column_name){
            case 'projectid':
                return $item['projectid'];    
                break;
            case 'projectname':
                return $item['projectname'];    
                break;
            case 'timestamp':
                return $item['timestamp'];    
                break;                                                        
            case 'source1':
                return $item['source1'];    
                break;                                                        
            case 'source2':
                return $item['source2'];    
                break;                                                        
            case 'source3':
                return $item['source3'];    
                break;                                                        
            default:
                return 'No column function or default setup in switch statement';
        }
    }

    /*
    function column_title( $item){

    } */

    function get_columns() {
        $columns = array(
            'projectid' => 'Project ID',
            'projectname' => 'Project Name',
            'timestamp' => 'Timestamp',
            'source1' => 'Source 1',
            'source2' => 'Source 2',
            'source3' => 'Source 3'
        );

        return $columns;
    }

    function get_sortable_columns() {
        $sortable_columns = array(
            //'post_title'     => array( 'post_title', false ),     //true means it's already sorted
        );
        return $sortable_columns;
    }

    function get_bulk_actions() {
        $actions = array(

        );
        return $actions;
    }

    function process_bulk_action() {
        
        //Detect when a bulk action is being triggered...
        if( 'delete'===$this->current_action() ) {
            wp_die( 'Items deleted (or they would be if we had items to delete)!' );
        }
        
    }

    function prepare_items_further( $data, $per_page = 5) {
        global $wpdb; //This is used only if making any database queries        

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array( $columns, $hidden, $sortable);

        $this->process_bulk_action();

        $current_page = $this->get_pagenum();

        $total_items = count( $data);

        $data = array_slice( $data,(( $current_page-1)*$per_page), $per_page);

        $this->items = $data;

        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil( $total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }
}

class C2P_ProjectDataSources_Table extends WP_List_Table {

    function __construct() {
        global $status, $page;
             
        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'movie',     //singular name of the listed records
            'plural'    => 'movies',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );
        
    }

    function column_default( $item, $column_name){
             
        $attributes = "class=\"$column_name column-$column_name\"";
                
        switch( $column_name){
            case 'sourceid':
                return $item['sourceid'];    
                break;            
            case 'projectid':
                if( $item['projectid'] == 0){return 'Unknown';}
                return $item['projectid'];    
                break;
            case 'sourcetype':
                return $item['sourcetype'];    
                break;
            case 'path':
                return $item['path'];    
                break;            
            case 'timestamp':
                return $item['timestamp'];    
                break;                                                        
            default:
                return 'No column function or default setup in switch statement';
        }
    }

    /*
    function column_title( $item){

    } */

    function get_columns() {
        $columns = array(
            'sourceid' => 'Source ID',
            'projectid' => 'projectid',
            'sourcetype' => 'Type',
            'path' => 'Path',
            'timestamp' => 'Timestamp'
        );

        return $columns;
    }

    function get_sortable_columns() {
        $sortable_columns = array(
            //'post_title'     => array( 'post_title', false ),     //true means it's already sorted
        );
        return $sortable_columns;
    }

    function get_bulk_actions() {
        $actions = array(

        );
        return $actions;
    }

    function process_bulk_action() {
        
        //Detect when a bulk action is being triggered...
        if( 'delete'===$this->current_action() ) {
            wp_die( 'Items deleted (or they would be if we had items to delete)!' );
        }
        
    }

    function prepare_items_further( $data, $per_page = 5) {
        global $wpdb; //This is used only if making any database queries        

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array( $columns, $hidden, $sortable);

        $this->process_bulk_action();

        $current_page = $this->get_pagenum();

        $total_items = count( $data);

        $data = array_slice( $data,(( $current_page-1)*$per_page), $per_page);

        $this->items = $data;

        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil( $total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }
}

class C2P_CategoryProjection_Table extends WP_List_Table {

    function __construct() {
        global $status, $page;
             
        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'movie',     //singular name of the listed records
            'plural'    => 'movies',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );
        
    }

    function column_default( $item, $column_name ){
        foreach( $item as $table_name => $column_array ){

            foreach( $column_array as $category_column => $projection_array ){
                
                foreach( $projection_array as $catterm => $item_array ){
                    if( $column_name == 'term' ){
                        return $catterm;    
                    }    
                 
                }

                return $item_array[ $column_name ];
            }
        }
        
        return 'Nothing';
    }

    /*
    function column_title( $item){

    } */

    function get_columns() {
        return array(
                'term' => 'Term',
                'mapped' => 'Mapped ID',
                'catslug' => 'Slug',
                'level' => 'Level',
                'parentterm' => 'Parent Term',
                'parentid' => 'Parent ID'
             ); 
    }

    function get_sortable_columns() {
        $sortable_columns = array(
            //'post_title'     => array( 'post_title', false ),     //true means it's already sorted
        );
        return $sortable_columns;
    }

    function get_bulk_actions() {
        $actions = array(

        );
        return $actions;
    }

    function process_bulk_action() {
        
        //Detect when a bulk action is being triggered...
        if( 'delete'===$this->current_action() ) {
            wp_die( 'Items deleted (or they would be if we had items to delete)!' );
        }
        
    }

    function prepare_items_further( $data, $per_page = 5) {
        global $wpdb; //This is used only if making any database queries        

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array( $columns, $hidden, $sortable);

        $this->process_bulk_action();

        $current_page = $this->get_pagenum();

        $total_items = count( $data);

        $data = array_slice( $data,(( $current_page-1)*$per_page), $per_page);

        $this->items = $data;

        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil( $total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }
}

class C2P_ReplaceValueRules_Table extends WP_List_Table {

    function __construct() {
        global $status, $page;
             
        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'movie',     //singular name of the listed records
            'plural'    => 'movies',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );
    }

    /**
    * use to apply a default value to any column
    * 
    * @param mixed $item
    * @param mixed $column_name
    */
    function column_default( $item, $column_name){
        switch( $column_name){
            case 'delete':
                return self::linkaction( $_GET['page'], 'deletereplacevaluerule', __( 'Delete this replacement value rule' ), 'Delete', '&cfid='.$item['id'] );    
                break;                                                                   
            default:
                return $item[$column_name];
        }        
    }

    /*
    function column_title( $item){

    } */

    function get_columns() {
        return array(
                'table' => 'Data Table',
                'column' => 'Data Column',
                'vrvdatavalue' => 'Value',
                'vrvreplacementvalue' => 'Replacement',
                'delete' => 'Delete'
             ); 
    }

    function get_sortable_columns() {
        $sortable_columns = array(
            //'post_title'     => array( 'post_title', false ),     //true means it's already sorted
        );
        return $sortable_columns;
    }

    function get_bulk_actions() {
        $actions = array(

        );
        return $actions;
    }

    function process_bulk_action() {
        
        //Detect when a bulk action is being triggered...
        if( 'delete'===$this->current_action() ) {
            wp_die( 'Items deleted (or they would be if we had items to delete)!' );
        }
    }

    function prepare_items_further( $data, $per_page = 5) {
        global $wpdb; //This is used only if making any database queries        

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array( $columns, $hidden, $sortable);

        $this->process_bulk_action();

        $current_page = $this->get_pagenum();

        $total_items = count( $data);

        $data = array_slice( $data,(( $current_page-1)*$per_page), $per_page);

        $this->items = $data;

        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil( $total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }
}

/**
* Uses WP_List_Table to display a list of posts created by CSV 2 POST
* that are in the default category
* 
* @author Ryan Bayne
* @package CSV 2 POST
* @since 8.1.3
* @version 1.1
* @uses WP_List_Table() in WP 3.9.1
*/
class CSV2POST_UncatPosts_Table extends WP_List_Table {

    function __construct() {
        global $status, $page;
             
        //Set parent defaults
        parent::__construct( array(
            'singular'  => 'movie',     //singular name of the listed records
            'plural'    => 'movies',    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );
        
        $this->CSV2POST = CSV2POST::load_class( 'CSV2POST', 'class-csv2post.php', 'classes' ); 
        $this->UI = CSV2POST::load_class( 'CSV2POST_UI', 'class-ui.php', 'classes' );
    }      
    
    /**
    * sets the value on a per row, per columb basis
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.1     
    */     
    function column_default( $item, $column_name){
             
        $attributes = "class=\"$column_name column-$column_name\"";

        // get the current posts record
        $record = $this->CSV2POST->get_posts_record( $item['c2p_project'], $item['ID'] );
                
        switch( $column_name){
            case 'ID':
                return $item['ID'];    
                break;            
            case 'post_title':
                return $item['post_title'];    
                break;            
            case 'level_one':

                if( $record ){
                    $cat_col = $this->CSV2POST->get_category_column( $item['c2p_project'], 0 );     
                          
                    if( $cat_col ){
                        return $record[0][ $cat_col ];
                    }else{
                        return '';
                    }         
                }

                break;            
            case 'level_two':
            
                if( $record ){
                    $cat_col = $this->CSV2POST->get_category_column( $item['c2p_project'], 1 );     
                          
                    if( $cat_col ){
                        return $record[0][ $cat_col ];
                    }else{
                        return '';
                    }         
                }
                   
                break;            
            case 'level_three':
            
                if( $record ){
                    $cat_col = $this->CSV2POST->get_category_column( $item['c2p_project'], 2 );     
                          
                    if( $cat_col ){
                        return $record[0][ $cat_col ];
                    }else{
                        return '';
                    }         
                }
                    
                break;            
            case 'level_four':
            
                if( $record ){
                    $cat_col = $this->CSV2POST->get_category_column( $item['c2p_project'], 3 );     
                          
                    if( $cat_col ){
                        return $record[0][ $cat_col ];
                    }else{
                        return '';
                    }         
                }
                    
                break;            
            case 'level_five':
            
                if( $record ){
                    $cat_col = $this->CSV2POST->get_category_column( $item['c2p_project'], 4 );     
                          
                    if( $cat_col ){
                        return $record[0][ $cat_col ];
                    }else{
                        return '';
                    }         
                }
                    
                break;                                             
            default:
                return 'No column function or default setup in switch statement';
        }
    }

    /**
     * Render a cell in the "post_title" column
     *
     * @since 8.1.3
     *
     * @param array $item Data item for the current row
     * @return string HTML content of the cell
     */
    protected function column_post_title( array $item ) {

        // ensure user has permission to use individual actions else do not display them
        $user_can_edit_posts = current_user_can( 'edit_posts' );
               
        // build the nonced URL
        $edit_url = $this->UI->action_url( $file = 'post.php', false, 'edit', 'post=' . $item['ID'] );
             
        // build row of actions
        $row_actions = array();
        
        if ( $user_can_edit_posts ) {
            $row_text = '<strong><a title="' . esc_attr( sprintf( __( 'Edit &#8220;%s&#8221;', 'csv2post' ), esc_attr( $item['post_title'] ) ) ) . '" class="row-title" href="' . $edit_url . '">' . esc_html( $item['post_title'] ) . '</a></strong>';
        } else {
            $row_text = '<strong>' . esc_html( $item['name'] ) . '</strong>';
        }
         
        // add action that takes user to Edit Posts screen
        if ( $user_can_edit_posts ) {
            $row_actions['edit'] = sprintf( '<a href="%1$s" title="%2$s">%3$s</a>', $edit_url, esc_attr( sprintf( __( 'Edit &#8220;%s&#8221;', 'csv2post' ), $item['post_title'] ) ), __( 'Edit', 'csv2post' ) );
        }
          
        return $row_text . $this->row_actions( $row_actions );
    }

    function get_columns() {
        $columns = array(
            'ID' => __( 'Post ID', 'csv2post' ),
            'post_title' => __( 'Post Title', 'csv2post' ),
            'level_one' => __( 'Level One', 'csv2post' ),
            'level_two' => __( 'Level Two', 'csv2post' ),
            'level_three' => __( 'Level Three', 'csv2post' ),
            'level_four' => __( 'Level Four', 'csv2post' ),
            'level_five' => __( 'Level Five', 'csv2post' )
        );

        return $columns;
    }

    function get_sortable_columns() {
        $sortable_columns = array(
            //'post_title'     => array( 'post_title', false ),     //true means it's already sorted
        );
        return $sortable_columns;
    }

    function get_bulk_actions() {
        $actions = array(

        );
        return $actions;
    }

    function process_bulk_action() {
        
        //Detect when a bulk action is being triggered...
        if( 'delete'===$this->current_action() ) {
            wp_die( 'Items deleted (or they would be if we had items to delete)!' );
        }
        
    }
    
    function prepare_items_further( $data, $per_page = 5) {
        global $wpdb; //This is used only if making any database queries        

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array( $columns, $hidden, $sortable);

        $this->process_bulk_action();

        $current_page = $this->get_pagenum();

        $total_items = count( $data);

        $data = array_slice( $data,(( $current_page-1)*$per_page), $per_page);

        $this->items = $data;

        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil( $total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    } 
}
?>