<?php
/** 
 * Form builder and handler classes for Wordpress only
 * 
 * @package CSV 2 POST
 * @author Ryan Bayne   
 * @since 8.1.33
 * @version 1.0.0
 */  

/** 
* Main form builder and handler class for Wordpress
* 
* @package CSV 2 POST
* @author Ryan Bayne   
* @since 8.1.33
* @version 1.0.0
*/
class C2P_Formbuilder extends C2P_UI {
    
    // array of valid input types, custom ones can be added which relate to special variations of original functions
    var $input_types = array( 
        'text', 
        'hidden', 
        'dateandtime',
        'menu_cronhooks',
        'menu_cronrepeat',
        'menu_capabilities',
        'file',
        'radiogroup_postformats',
        'radiogroup_posttypes',
        'menu_categories',
        'menu_users',
        'checkbox_single',
        'menu',
        'textarea',
        'radiogroup',
        'switch'
    );
    
    // array of available validation methods (applies validation automatically on submission with standard outputs)
    var $validation_types = array( 
        'alpha', 
        'alphanumeric',
        'numeric',
        'unset',
        'URL',
        'url',
        'none'
    );
    
    // build an array of known inputs we do not need to validate ever, used to exit processes as early as possible
    var $ignored_inputs = array( '_wpnonce', '_wp_http_referer' );

    // set visual settings
    var $seen_title = 'Input';
    
    var $seen_append_ = '';// added to second field, after input
    
    var $seen_instructions = '';// used for HTML 5 popup (populated in title_att if set)
    
    var $validation = '';// forced requirement on the values or selection user makes
    
    var $appendtext = '';// placed after form input 
    
    var $instructions = '';

    var $first_switch_label = 'Enabled';
    
    var $second_switch_label = 'Disabled';
    
    var $items = array();
            
    // set default attribute values "att_"
    var $att_type = 'invalidtype';// this default will prevent an input being added to form
    
    var $att_name = '';
    
    var $att_id = '';
    
    var $att_currentvalue = '';
    
    var $att_title = '';// title="" 
    
    var $att_alt = '';
    
    var $att_class = 'csv2post_inputtext';
    
    var $att_readonly = false;
    
    var $att_required = false;
    
    var $att_disabled = false;
    
    var $att_defaultvalue = '';
    
    var $att_defaultitem_name = '';
    
    var $att_defaultitem_value = '';
    
    var $att_checkon = true;
    
    var $att_label = 'Label Text';// label for single checkbox creation
    
    var $att_rows = 10;
    
    var $att_cols = 10; 
    
    public function __construct() {
        // create class objects
        $this->UI = CSV2POST::load_class( 'C2P_UI', 'class-ui.php', 'classes' );
        $this->PHP = CSV2POST::load_class( 'C2P_PHP', 'class-phplibrary.php', 'classes' );
        $this->WPCore = CSV2POST::load_class( 'C2P_WPCore', 'class-wpcore.php', 'classes' );
        
        // re-populate class var with the localized value
        $this->first_switch_label = __( 'Enabled', 'csv2post' );
        $this->second_switch_label = __( 'Disabled', 'csv2post' );
    }
               
    /**
    * Returns an array of input types by default but can be used to check if a specific type is valid
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.33
    * @version 1.0.0
    * 
    * @returns array of input types, if $string will return boolean (true if $string is a valid input type)
    */
    public function input_types( $string = null ) {  
        if( !$string ) { return $this->input_types; }
        if( in_array( $string, $this->input_types ) ) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
    * Returns array of validation types or if $string used confirms if a validation type is valid
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.33
    * @version 1.0.0
    */
    public function validation_types( $string = null ) {
        if( !$string ) { return $this->validation_types; }
        if( in_array( $string, $this->validation_types ) ) {
            return true;
        } else {
            return false;
        }    
    }
    
    /**
    * Call this for any new form input, the idea is to make form building quick but safe by including all security measures.
    * You can pass values to $att_array or use the parameters after $att_array.
    * 
    * 1. Copy and paste the function line, remove variable name and leave "null" for any par not required for input
    * OR
    * 2. Build up $par_array() 
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.33
    * @version 1.0.0
    */
    public function input( $par_type, $par_seentitle, $par_name, $par_array = null, $par_validation = null, $par_defaultvalue = null, $par_currentvalue = null, $par_required = null, $par_id = null, $par_readonly = null, $par_disabled = null, $par_defaultitem_name = null, $par_defaultitem_value = null, $par_appendtext = null, $par_alt = null, $par_class = null, $par_title = null, $par_checkon = null, $par_instructions = null, $par_label = null, $par_items = null, $par_rows = null, $par_cols = null ) {
             
        // ensure input type is valid else add a message to the form indicating code issue
        if( !in_array( $par_type, $this->input_types, false ) ) {
            self::option_subline( __( 'This is a technical matter please report it. There should be a form input here that you may require before you continue.', 'csv2post' ), __( 'Invalid Input Type', 'csv2post' ) );
            return false;    
        }
        
        // ensure validation type is valid, we do not want a spelling mistake to redue security measures
        if( !in_array( $par_validation, $this->validation_types ) ) {
            self::option_subline( __( 'This is a technical matter please report it. There should be a form input here that you may require before you continue.', 'csv2post' ), __( 'Invalid Validation Type', 'csv2post' ) );
            return false;    
        }        
        
        // add required parameters to required attributes
        $this->att_type = $par_type;
        $this->seentitle = $par_seentitle;// title seen by user, added to left column of WP styled <table>
        $this->att_name = $par_name;
        
        // add optional parameters, populate with HTML here or the parameter variable itself
        // parameters can have any value to lead to $this variable being created for use later
        if( $par_defaultvalue ){ $this->att_defaultvalue = $par_defaultvalue; }
        if( $par_alt ){ $this->att_alt = $par_alt; }
        if( $par_validation ){ $this->validation = $par_validation; }
        if( $par_currentvalue ){ $this->att_currentvalue = $att_currentvalue; }
        if( $par_id ){ $this->att_id = $par_id; } else { $this->att_id = $this->att_name; }
        if( $par_defaultitem_name ){ $this->att_defaultitem_name = $par_defaultitem_name; }
        if( $par_defaultitem_value ){ $this->att_defaultitem_value = $par_defaultitem_value; }
        if( $par_appendtext ){ $this->appendtext = $par_appendtext; }
        if( $par_class ){ $this->att_class = $par_class; }    
        if( $par_readonly ){ $this->att_readonly = true; }
        if( $par_disabled ){ $this->att_disabled = true; }   
        if( $par_required ){ $this->att_required = true;}
        if( $par_instructions ){ $this->instructions = $par_instructions; }
        if( $par_checkon ){ $this->att_checkon = true; }
        if( $par_label ){ $this->att_label = true; }
        if( $par_items ){ $this->items = true; }
        
        // re-add all of the above but from the $att_array - an alternative method when adding new inputs to forms
        if( isset( $par_array['defaultvalue'] ) ) { $this->att_defaultvalue = $par_array['defaultvalue']; }
        if( isset( $par_array['alt'] ) ){ $this->att_alt = $par_array['alt']; }
        if( isset( $par_array['currentvalue'] ) ){ $this->att_currentvalue = $par_array['validation']; }
        if( isset( $par_array['id'] ) ){ $this->att_id = $par_array['id']; }
        if( isset( $par_array['defaultitem_name'] ) ){ $this->att_defaultitem_name = $par_array['defaultitem_name']; }
        if( isset( $par_array['defaultitem_value'] ) ){ $this->att_defaultitem_value = $par_array['defaultitem_value']; }
        if( isset( $par_array['class'] ) ){ $this->att_class = $par_array['class']; }    
        if( isset( $par_array['readonly'] ) ){ $this->att_readonly = true; }
        if( isset( $par_array['disabled'] ) ){ $this->att_disabled = true; }   
        if( isset( $par_array['required'] ) ){ $this->att_required = true; }       
        if( isset( $par_array['instructions'] ) ){ $this->instructions = $par_array['instructions']; }
        if( isset( $par_array['appendtext'] ) ){ $this->appendtext = $par_array['appendtext']; }
        if( isset( $par_array['validation'] ) ){ $this->validation = $par_array['validation']; }
        if( isset( $par_array['checkon'] ) ){ $this->att_checkon = $par_array['checkon']; }
        if( isset( $par_array['label'] ) ){ $this->att_label = $par_array['label']; }
        if( isset( $par_array['items'] ) ){ $this->items = $par_array['items']; }
        
        // register the input - also uses the above values, the idea is to register everything and ensure it has not been changed by hacker before submission
        self::register_input();
        
        // create input
        eval( 'self::input_' . $this->att_type . '();' );
    }     
    
    /**
    * Stores the input attribute details, we use it to validate the input and ensure the form was not hacked using source code inspection tools.
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.32
    * @version 1.0.0
    */
    public function register_input() {

        // ensure passed $input_validation is expected else do not register, this prevents problems during processing
        // this is and should be done earlier, before calling register_input but its yet another precaution
        if( !in_array( $this->validation, $this->validation_types ) ) {
            return false;    
        }
                   
        // get the form validation array
        $form_validation_array = get_option( 'csv2post_formvalidation' );
        
        // initiate array if need to
        if( !$form_validation_array ) {
            $form_validation_array = array();
        }
            
        // we use the $input_id (an actual HTML ID) to apply the correct validation at the point of $_POST or $_GET processing
        $form_validation_array[ $this->att_name ]['seentitle'] = $this->seentitle;// used to make user readable notice on invalid entry
        $form_validation_array[ $this->att_name ]['id'] = $this->att_id;// used for confirming the submitted $_POST value
        $form_validation_array[ $this->att_name ]['validation'] = $this->validation;
        $form_validation_array[ $this->att_name ]['input_type'] = $this->att_type;
        $form_validation_array[ $this->att_name ]['seentitle'] = $this->seentitle;
        $form_validation_array[ $this->att_name ]['name'] = $this->att_name;
        $form_validation_array[ $this->att_name ]['required'] = $this->att_required;
        $form_validation_array[ $this->att_name ]['defaultitem_name'] = $this->att_defaultitem_name;
        $form_validation_array[ $this->att_name ]['defaultitem_value'] = $this->att_defaultitem_value; 
        $form_validation_array[ $this->att_name ]['current_value'] = $this->att_currentvalue; 
        $form_validation_array[ $this->att_name ]['title'] = $this->att_title;// link title, not visible input title 
        $form_validation_array[ $this->att_name ]['alt'] = $this->att_alt;  
        $form_validation_array[ $this->att_name ]['class'] = $this->att_class;
        $form_validation_array[ $this->att_name ]['readonly'] = $this->att_readonly;  
        $form_validation_array[ $this->att_name ]['required'] = $this->att_required; 
        $form_validation_array[ $this->att_name ]['disabled'] = $this->att_disabled;
        $form_validation_array[ $this->att_name ]['instructions'] = $this->instructions;

        update_option( 'csv2post_formvalidation', $form_validation_array );   
    } 

    /**
    * Validates the values for individual form inputs and stop further processing of request if a value does not pass
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.32
    * @version 1.0.1
    */
    public function apply_input_validation() {
        // set result, default true to allow processing to complete, change to false if user made invalid entry
        $result = true;
        
        // get the current users form validation array
        $form_validation_array = get_option( 'csv2post_formvalidation' );
        
        // if no validation array return a true result now to avoid serious errors
        if( !$form_validation_array ) {
            return $result;
        } 
     
        // loop through $_POST values and if the name is registered apply validation    
        foreach( $_POST as $name => $value ) {
               
            // get the inputs validation method if it has been registered
            $validation_method = self::get_input_validation_method( $name );
                                
            if( $validation_method !== false ) {
                                       
                // ensure the expected input_validation_example() function exists
                if( method_exists( $this, 'validate_' . $validation_method ) ) { 
                    
                    // found a situation where this is not set, this is probably temporary
                    if( !isset( $form_validation_array[$name]["seentitle"] ) ) {
                        $form_validation_array[$name]["seentitle"] = 'the submitted form';
                    }
                      
                    // input_validation functions return boolean false on fail and output a notice to make user aware
                    // else nothing else happens, next input is processed
                    eval( '$result = self::validate_' . $validation_method . '( $value, $form_validation_array[$name]["seentitle"] );');// $result is always boolean    
                    
                    // false results in the final processing function not being called at all
                    return $result;
                }    
            }
        }
        
        // true allows the final function to be called, processing the request further
        // that function may perform further sanitization and even validation
        return $result;
    }
    
    /**
    * Checks registered input values for HTML form attributes and detects anything wrong.
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.33
    * @version 1.0.0
    */
    public function apply_input_security() {
        $result = true;
        
        # does $_POST value exist for an input that was disabled="disabled" indicating a hacker endabled it
        
        # is a $_POST value missing that should exist (hacker disabled it)
        
        # did the selected item for a menu exist when the form was registered (extra item indicate hacker added them)
        
        # did all checked boxes exist when the form was parsed (if one exists that did not, hacker added one)
        
        return $result;
    }
    
    /**
    * Overall form security
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.33
    * @version 1.0.0
    */
    public function apply_form_security() {
        $result = true;
        
        # possible move nonce check to here, where it is may be better as it is before even this but not 100% sure
        
        # detect extra fields (not registered), unless form is not registered at all then we do not do this
        
        # check capability and ensure user submitting form still has permission (what if permission is revoked after form loads?)
        
        return $result;    
    }

    /**
    * Returns what validation is to be used on form input value
    * 
    * @returns optional array (human rea
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.32
    * @version 1.0.0
    */
    public function get_input_validation_method( $name, $return = 'validation' ) {
        
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
    * standard notice generated indicating no permission if no capability exists in users data
    * @returns boolean false if that is the case, else returns true
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.0.0
    * @version 1.0.2
    */    
    public function user_can( $capability = 'activate_plugins' ){
        if(!current_user_can( $capability ) ){
            $this->UI->create_notice( __( 'Your request was rejected as your account does not have the required permission.', 'csv2post' ), 'success', 'Small', __( 'Not Permitted', 'csv2post' ) );          
            return false;
        }   
        return true;
    }     

    ##########################################################
    #                                                        #
    #                  VALIDATION FUNCTIONS                  #
    #                                                        #
    ##########################################################
    
    /**
    * Requires string to be alphabetic characters only (not alpha numeric or special characters letters only)
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.33
    * @version 1.0.0
    */
    public function validate_alpha( $value, $seentitle ) {   
        if( !ctype_alpha( $value ) ) {
            $this->UI->create_notice( __( "The $seentitle input is only for letters, please edit your entry and remove any numbers or special characters.", 'csv2post' ), 'error', 'Small', __( 'Invalid Entry', 'csv2post' ) );               
            return false;            
        }
        return true;
    }
             
    /**
    * Confirms if a value is alphanumeric or not (must always return boolean)
    * 
    * @returns boolean but also generates notice
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.32
    * @version 1.0.1
    */
    public function validate_alphanumeric( $value, $seentitle ) {
        if( !ctype_alnum( $value ) ) {   
            $this->UI->create_notice( __( "The $seentitle input is for letters or numbers, no special characters allowed.", 'csv2post' ), 'error', 'Small', __( 'Invalid Entry', 'csv2post' ) );               
            return false;
        }
        return true;
    }
    
    /**
    * Confirms value is a URL or not
    * 
    * @returns boolean but also generates notice
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.33
    * @version 1.0.1
    */
    public function validate_url( $url, $seentitle ) {
        if( !$this->PHP->validate_url( $url ) ) {
            $this->UI->create_notice( __( "You did not enter a valid URL in the $seentitle input. Please ensure that all characters match the online URL.", 'csv2post' ), 'error', 'Small', __( 'Invalid Entry', 'csv2post' ) );               
            return false;
        }        
        return true;
    } 
    
    /**
    * Checks if string is numeric only (no alpha or special characters allowed)
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.33
    * @version 1.0.0
    */
    public function validate_numeric( $value, $seentitle ) {  
        if( !ctype_digit( $value ) ) {
            $this->UI->create_notice( __( "Only numbers are meant to be entered into the $seentitle field.", 'csv2post' ), 'error', 'Small', __( 'Invalid Entry', 'csv2post' ) );               
            return false;
        }        
        return true;    
    }
    
    ##########################################################
    #                                                        #
    #                     INPUT FUNCTIONS                    #
    #                                                        #
    ##########################################################
    
    /*
    * use in options table to add a line of text like a separator 
    * 
    * @param mixed $secondfield
    * @param mixed $firstfield
    *
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.33
    * @version 1.0.0
    */
    public function input_subline( $secondfield, $firstfield = '' ){?>
        <!-- Option Start -->        
        <tr valign="top">
            <th scope="row"><?php echo $firstfield;?></th>
            <td><?php echo $secondfield;?></td>
        </tr>
        <!-- Option End --><?php     
    } 
    
    /**
    * add text input to Wordpress style form which is tabled and has optional HTML5 support
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
    public function input_text(){?>
        <!-- Option Start -->        
        <tr valign="top">
            <th scope="row">
            
                <?php echo $this->seentitle; ?>
            
                <?php 
                // if required add asterix ( "required" also added to input to make use of HTML5 control")
                if( $this->att_required === true ){
                    echo '<abbr class="req" title="required">*</abbr>';
                }
                ?>
                            
            </td>
            <td>

                <input type="text" name="<?php echo $this->att_name;?>" id="<?php echo $this->att_id;?>" value="<?php echo $this->att_currentvalue;?>" title="<?php echo $this->att_title; ?>" class="<?php echo $this->att_class; ?>"<?php echo $this->att_readonly;?><?php echo $this->att_required;?><?php if( $this->att_disabled ){ echo ' disabled';} ?>> 
                
                <?php echo $this->appendtext;?>

            </td>
        </tr>
        <!-- Option End --><?php 
    }   
    
    /**
    * Creates a hidden input, registered like all other inputs and security applied during submission to prevent hacking.
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.33
    * @version 1.0.0
    */
    public function input_hidden(){?>
        <input type="hidden" name="<?php echo $this->att_name; ?>" id="<?php echo $this->att_id; ?>" value="<?php echo $this->att_currentvalue;?>"<?php if( $this->att_disabled ){ echo ' disabled';} ?>><?php     
    }
    
    /**
    * table row with two choice radio group styled by Wordpress and used for switch type settings
    * 
    * $current_value should be enabled or disabled, use another method and do not change this if you need other values
    *     
    * @param mixed $title
    * @param mixed $name
    * @param mixed $id
    * @param mixed $current_value
    * @param string $default pass enabled or disabled depending on the softwares default state
    */
    public function input_switch(){
        if( $this->att_defaultvalue != 'enabled' && $this->att_defaultvalue != 'disabled' ){
            $this->att_defaultvalue = 'disabled';
        }
             
        // only enabled and disabled is allowed for the switch, do not change this, create a new method for a different approach
        if( $this->att_currentvalue != 'enabled' && $this->att_currentvalue != 'disabled' ){
            $this->att_currentvalue = $this->att_defaultvalue;
        }       
        ?>
    
        <!-- Option Start -->
        <tr valign="top">
            <th scope="row"><?php _e( $this->seentitle, 'csv2post' ); ?></th>
            <td>
                <fieldset <?php if( $this->att_disabled ){ echo ' disabled';} ?>><legend class="screen-reader-text"><span><?php echo $this->seentitle; ?></span></legend>
                    <input type="radio" id="<?php echo $this->att_name;?>_enabled" name="<?php echo $this->att_name;?>" value="enabled" <?php echo self::is_checked( $this->att_currentvalue, 'enabled', 'return' );?> />
                    <label for="<?php echo $this->att_name;?>_enabled"> <?php echo $this->first_switch_label; ?></label>
                    <br />
                    <input type="radio" id="<?php echo $this->att_name;?>_disabled" name="<?php echo $this->att_name;?>" value="disabled" <?php echo self::is_checked( $this->att_currentvalue, 'disabled', 'return' );?> />
                    <label for="<?php echo $this->att_name;?>_disabled"> <?php echo $this->second_switch_label; ?></label>
                </fieldset>
            </td>
        </tr>
        <!-- Option End -->
                            
    <?php  
    }  
    
    /**
    * Basic radiogroup input.
    * 
    * @param mixed $title
    * @param mixed $id
    * @param mixed $name
    * @param mixed $radio_array
    * @param mixed $current
    * @param mixed $default
    * @param mixed $validation
    */
    public function input_radiogroup(){
        echo '
        <!-- Option Start -->        
        <tr valign="top">
            <th scope="row">' . $this->seentitle . '</th>
            <td><fieldset>';
            
            echo '<legend class="screen-reader-text"><span>' . $this->seentitle . '</span></legend>';
            
            $default_set = false;

            $items_count = count( $this->items );
            $itemsapplied = 0;
            foreach( $this->items as $key => $option ){
                ++$itemsapplied;
                    
                // determine if this option is the currently stored one
                $checked = '';
                if( $this->att_currentvalue === $key ){
                    $default_set = true;
                    $checked = ' checked';
                }elseif( $this->att_currentvalue == 'nocurrent123' && $default_set == false ){
                    $default_set = true;
                    $checked = ' checked';
                }
                
                // set the current to that just submitted
                if( isset( $_POST[ $this->att_name ] ) && $_POST[ $this->att_name ] == $key ){
                    $default_set = true;
                    $checked = ' checked';                
                }
                
                // check current item is not current giving or current = '' 
                if( is_null( $this->att_currentvalue ) || $this->att_currentvalue == 'nocurrent123' ){
                    if( $this->default == $key ){
                        $default_set = true;
                        $checked = ' checked';                
                    } 
                }
                
                // if on last option and no current set then check last item
                if( $default_set == false && $items_count == $itemsapplied){
                    $default_set = true;
                    $checked = ' checked';                
                }                
                
                // create an object id                 
                $itemid = $this->att_id . $this->PHP->clean_string( $option );
 
                $value = $key;
                ?>
                      
                <input type="radio" id="<?php echo $itemid; ?>" name="<?php echo $this->att_name; ?>" value="<?php echo $value; ?>"<?php echo $checked;?><?php if( $this->att_disabled ){ echo ' disabled';} ?>/>
                
                <?php 
                echo '<label for="">' . $option .'</label>
                <br />';
            }
            
        echo '</fieldset>
            </td>
        </tr>
        <!-- Option End -->';                 
    }
    
    /**
    * HTML form textarea with Wordpress table structure.
    * 
    * @param mixed $title
    * @param mixed $id
    * @param mixed $name
    * @param mixed $rows
    * @param mixed $cols
    * @param mixed $current_value
    * @param mixed $required
    * @param mixed $validation
    */
    public function input_textarea(){
        ?>
        <!-- Option Start -->        
        <tr valign="top">
            <th scope="row">
            
                <?php echo $this->seentitle;
                 
                // if required add asterix ( "required" also added to input to make use of HTML5 control")
                if( $this->att_required ){
                    echo '<abbr class="req" title="required">*</abbr>';
                }?>
                
                </th>
            <td>
                <textarea id="<?php echo $this->att_id;?>" name="<?php echo $this->att_name;?>" rows="<?php echo $this->att_rows;?>" cols="<?php echo $this->att_cols;?>"<?php if( $this->att_required ){echo ' required';}?><?php if( $this->att_disabled ){ echo ' disabled';} ?>><?php echo $this->att_currentvalue;?></textarea>
            </td>
        </tr>
        <!-- Option End --><?php     
    }
    
    /**
    * Basic form menu within table row.
    * 
    * @param mixed $title
    * @param mixed $id
    * @param mixed $name
    * @param mixed $array
    * @param mixed $current
    * @param mixed $defaultvalue
    * @param mixed $defaulttitle
    * @param mixed $validation
    */
    public function input_menu(){
        ?>
        <!-- Option Start -->        
        <tr valign="top">
            <th scope="row"><label for="<?php echo $this->att_id; ?>"><?php echo $this->seentitle; ?></label></th>
            <td>            
                <select name="<?php echo $this->att_name;?>" id="<?php echo $this->att_id;?>"<?php if( $this->att_disabled ){ echo ' disabled';} ?>>
                    <?php
                    if( $this->att_defaultvalue != 'nodefaultrequired123' && $this->att_defaultvalue != 'nodefaultrequired123' ){
                        echo '<option selected="selected" value="notrequired">Not Required</option>';
                    }                    
                    
                    $selected = '';            
                    foreach( $this->items as $key => $option_title ){
                        
                        if( $key == $this->att_currentvalue ){
                            $selected = 'selected="selected"';
                        } 
                        
                        echo '<option ' . $selected . ' value="' . $key . '">' . $option_title . '</option>';    
                    }
                    ?>
                </select>                  
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
    */
    public function input_checkbox_single(){
        $checked = '';
        
        if( $this->att_checkon == 'on' ) {
            $checked = ' checked';
        }
        
        $thevalue = '';
        if( $this->att_currentvalue !== false ) {
            $thevalue = ' value="' . $this->att_currentvalue . '" ';
        }
        
        $disabled = '';
        if( $this->att_disabled ){ 
            $disabled = ' disabled';
        } 
        ?>
        
        <!-- Option Start -->
        <tr valign="top">
            <th scope="row"><?php echo $this->seentitle;?></th>
            <td>
            
            <?php 
            echo '<label for="' . $this->att_id . '"><input type="checkbox" name="' . $this->att_name . '" id="' . $this->att_id . '"' . $thevalue .  $checked . $disabled . '>' . $this->att_label . '</label>';
            ?>
            
            </td>
        </tr>
        <!-- Option End --><?php     
    }

    /**
    * a standard menu of users wrapped in <td> 
    */
    public function input_menu_users(){
        $blogusers = get_users( 'blog_id=1&orderby=nicename' );?>

        <!-- Option Start -->
        <tr valign="top">
            <th scope="row"><?php echo $this->seentitle;?></th>
            <td>                                     
                <select name="<?php echo $this->att_name;?>" id="<?php echo $this->att_id;?>"<?php if( $this->att_disabled ){ echo ' disabled';} ?>>
            
                    <?php        
                    $selected = '';                    
                    ?>
                    
                    <option value="notselected" <?php echo $selected;?>><?php _e( 'None Selected', 'csv2post' ); ?></option> 
                                                    
                    <?php         
                    foreach ( $blogusers as $user ){ 

                        // apply selected value to current save
                        $selected = '';
                        if( $this->att_currentvalue == $user->ID ) {
                            $selected = 'selected="selected"';
                        }

                        echo '<option value="' . $user->ID . '" ' . $selected . '>' . $user->ID . ' - ' . $user->display_name . '</option>'; 
                    }?>
                                                                                                                                                                 
                </select>  
            </td>
        </tr>
        <!-- Option End --><?php 
    } 
    
    /**
    * a standard menu of categories wrapped in <td> 
    */
    public function input_menu_categories(){    
        $cats = get_categories( 'hide_empty=0&echo=0&show_option_none=&style=none&title_li=' );?>

        <!-- Option Start -->
        <tr valign="top">
            <th scope="row"><?php echo $this->seentitle;?></th>
            <td>                                     
                <select name="<?php echo $this->att_name;?>" id="<?php echo $this->att_id;?>"<?php if( $this->att_disabled ){ echo ' disabled';} ?>>
            
                    <?php        
                    $selected = '';                    
                    ?>
                    
                    <option value="notselected" <?php echo $selected;?>><?php _e( 'None Selected', 'csv2post' ); ?></option> 

                    <?php         
                    foreach( $cats as $c ){ 
                        
                        // apply selected value to current save
                        $selected = '';
                        if( $this->att_currentvalue == $c->term_id ) {
                            $selected = 'selected="selected"';
                        }
                        
                        echo '<option value="' . $c->term_id . '" ' . $selected . '>' . $c->term_id . ' - ' . $c->name .'</option>'; 
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
    */
    public function input_radiogroup_posttypes(){ 
        
        // apply disabled status
        $disabled = '';
        if( $this->att_disabled ){ $disabled = ' disabled="disabled"';}
         
        echo '
        <!-- Option Start -->        
        <tr valign="top">
            <th scope="row">' . $this->seentitle . '</th>
            <td><fieldset' . $disabled . '>';
            
            echo '<legend class="screen-reader-text"><span>' . $this->seentitle . '</span></legend>';
            
            $post_types = get_post_types( '', 'names' );
            $current_applied = false;        
            $i = 0; 
            foreach( $post_types as $post_type ){
                
                // dont add "post" as it is added last so that it can be displayed as current default when required
                if( $post_type != 'post' ){
                    $checked = '';
                    
                    if( $post_type == $this->att_currentvalue){
                        $checked = 'checked="checked"';
                        $current_applied = true;    
                    }elseif( $this->att_currentvalue == 'nocurrent123' && $current_applied == false ){
                        $checked = 'checked="checked"';
                        $current_applied = true;                        
                    }
                    
                    echo '<input type="radio" name="' . $this->att_name . '" id="' . $this->att_id . $i . '" value="' . $post_type . '" ' . $checked . ' />
                    <label for="' . $this->att_id . $i . '"> ' . $post_type . '</label><br>';
    
                    ++$i;
                }
            }
            
            // add post last, if none of the previous post types are the default, then we display this as default as it would be in Wordpress
            $post_default = '';
            if(!$current_applied){
                $post_default = 'checked="checked"';            
            }
            
            echo '<input type="radio" name="' . $this->att_name . '" id="' . $this->att_id . $i . '" value="post" ' . $post_default . ' />
            <label for="' . $this->att_id . $i . '">post</label>';
                    
        echo '</fieldset>
            </td>
        </tr>
        <!-- Option End -->';
    } 
    
    /**
    * Radio group of post formats wrapped in table.
    * 
    * @param mixed $title
    * @param mixed $name
    * @param mixed $id
    * @param mixed $current_value
    * @param mixed $validation
    */
    public function input_radiogroup_postformats(){  
    
        // apply disabled status
        $disabled = '';
        if( $this->att_disabled ){ $disabled = ' disabled="disabled"';}
                
        echo '
        <!-- Option Start -->        
        <tr valign="top">
            <th scope="row">' . $this->seentitle . '</th>
            <td><fieldset' . $disabled . '>';
            
            echo '<legend class="screen-reader-text"><span>' . $this->seentitle . '</span></legend>';
      
            $optionchecked = false;     
            $post_formats = get_theme_support( 'post-formats' );
            if ( is_array( $post_formats[0] ) ) {
                
                $i = 0;
                
                foreach( $post_formats[0] as $key => $format ){
                    
                    $statuschecked = '';
                    if( $this->att_currentvalue === $format ){
                        $optionchecked = true;
                        $statuschecked = ' checked="checked" ';    
                    }
                                   
                    echo '<input type="radio" id="' . $this->att_id . $i . '" name="' . $this->att_name . '" value="' . $format . '"' . $statuschecked . '/>
                    <label for="' . $this->att_id . $i . '">' . $format . '</label><br>';
                    ++$i; 
                }
                
                if(!$optionchecked){$statuschecked = ' checked="checked" ';}
                
                echo '<input type="radio" id="' . $this->att_id . $i . '" name="' . $this->att_name . '" value="standard"' . $statuschecked . '/>
                <label for="' . $this->att_id . $i . '">standard (default)</label>';               
                    
            }            
                    
        echo '</fieldset>
            </td>
        </tr>
        <!-- Option End -->';
    }    

    /**
    * Add a file uploader to a form
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.33
    * @version 1.0.0
    * 
    * @param string $title
    * @param string $name
    * @param string $id
    * @param string $validation - pass name of a custom validation function 
    */
    public function input_file(){?>         
        <tr valign="top">
            <th scope="row"><?php echo $this->seentitle;?></th>
            <td>
                <input type="file" name="<?php echo $this->att_name;?>" id="<?php echo $this->att_id;?>"<?php if( $this->att_disabled ){ echo ' disabled';} ?>> 
            </td>
        </tr><?php 
    }      
    
    /**
    * A table row with menu of all Wordpress capabilities
    * 
    * @param mixed $title
    * @param mixed $id
    * @param mixed $name
    * @param mixed $current
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.33
    * @version 1.0.0
    */
    public function input_menu_capabilities(){
        global $wp_roles; 
        $capabilities_array = $this->WPCore->capabilities();
        
        // put into alphabetical order as it is a long list 
        ksort( $capabilities_array );
        ?>
        <!-- Option Start -->        
        <tr valign="top">
            <th scope="row"><label for="<?php echo $this->att_id; ?>"><?php echo $this->seentitle; ?></label></th>
            <td>            
                <select name="<?php echo $this->att_name;?>" id="<?php echo $this->att_id;?>"<?php if( $this->att_disabled ){ echo ' disabled';} ?>>
                    <?php            
                    foreach( $capabilities_array as $key => $cap ){
                        $selected = '';
                        if( $key == $this->att_currentvalue ){
                            $selected = 'selected="selected"';
                        } 
                        echo '<option value="' . $key . '" ' . $selected . '>' . $key . '</option>';    
                    }
                    ?>
                </select>                  
            </td>
        </tr>
        <!-- Option End --><?php          
    }

    /**
    * Menu of CRON schedules, I have named them cron repeats because "schedule" is used
    * methods very often.
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.33
    * @version 1.0.0
    */
    public function input_menu_cronrepeat() {
        ?>
        <!-- Option Start -->        
        <tr valign="top">
            <th scope="row"><label for="<?php echo $this->att_id; ?>"><?php echo $this->seentitle; ?></label></th>
            <td>            
                <select name="<?php echo $this->att_name;?>" id="<?php echo $this->att_id;?>"<?php if( $this->att_disabled ){ echo ' disabled';} ?>>
                    <option value="hourly" <?php if( $this->att_currentvalue == 'hourly' ){ echo $selected; }?>><?php _e( 'Hourly', 'csv2post' ); ?></option>
                    <option value="twicedaily" <?php if( $this->att_currentvalue == 'twicedaily' ){ echo $selected; }?>><?php _e( 'Twice Daily', 'csv2post' ); ?></option>
                    <option value="daily" <?php if( $this->att_currentvalue == 'daily' ){ echo $selected; }?>><?php _e( 'Daily', 'csv2post' ); ?></option>
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
    * @version 1.0.0
    */
    public function input_menu_cronhooks() {
        $selected = 'selected="selected"';
        ?>
        <!-- Option Start -->        
        <tr valign="top">
            <th scope="row"><label for="<?php echo $this->att_id; ?>"><?php echo $this->seentitle; ?></label></th>
            <td>            
                <select name="<?php echo $this->att_name;?>" id="<?php echo $this->att_id;?>"<?php if( $this->att_disabled ){ echo ' disabled';} ?>>
                    <option value="eventcheckwpcron" <?php if( $this->att_currentvalue == 'eventcheckwpcron' ){ echo $selected; }?>>eventcheckwpcron</option>
                </select>                  
            </td>
        </tr>
        <!-- Option End --><?php     
    }
    
    /**
    * Set of text field inputs as used on Edit Post page.
    * 
    * Day, Month, Year, Hour and Minute inputs on a single row (taking from Edit Post screen)
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.33
    * @version 1.0.1
    */
    public function input_dateandtime() {
        global $wp_locale;

        // apply disabled status
        $disabled = '';
        if( $this->att_disabled ){ $disabled = ' disabled="disabled"';}
                
        $time_adj = current_time('timestamp');

        $jj = gmdate( 'd', $time_adj );
        $mm = gmdate( 'm', $time_adj );
        $aa = gmdate( 'Y', $time_adj );
        $hh = gmdate( 'H', $time_adj );
        $mn = gmdate( 'i', $time_adj );
        $ss = gmdate( 's', $time_adj );

        $month = '<select name="mm"' . $disabled . '>';
        
        for ( $i = 1; $i < 13; $i = $i +1 ) {
            $monthnum = zeroise($i, 2);
            $month .= "\t\t\t" . '<option value="' . $monthnum . '" ' . selected( $monthnum, $mm, false ) . '>';
            /* translators: 1: month number (01, 02, etc.), 2: month abbreviation */
            $month .= sprintf( __( '%1$s-%2$s' ), $monthnum, $wp_locale->get_month_abbrev( $wp_locale->get_month( $i ) ) ) . "</option>\n";
        }
        $month .= '</select>';

        $day = '<input type="text" id="jj" name="jj" value="' . $jj . '" size="2" maxlength="2" autocomplete="off"' . $disabled . ' />';
        $year = '<input type="text" ="aa" name="aa" value="' . $aa . '" size="4" maxlength="4" autocomplete="off"' . $disabled . ' />';
        $hour = '<input type="text" id="hh" name="hh" value="' . $hh . '" size="2" maxlength="2" autocomplete="off"' . $disabled . ' />';
        $minute = '<input type="text" id="mn" name="mn" value="' . $mn . '" size="2" maxlength="2" autocomplete="off"' . $disabled . ' />';

        ?>
        <!-- Option Start -->        
        <tr valign="top">
            <th scope="row"><?php echo $this->seentitle; ?></th>
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
    * Use to apply selected="selected" to HTML form menu
    * 
    * @param mixed $actual_value
    * @param mixed $item_value
    * @param mixed $output
    * @return mixed
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 8.1.33
    * @version 1.0.0
    */
    public function is_selected( $actual_value, $item_value, $output = 'return' ){
        if( $actual_value === $item_value){
            if( $output == 'return' ){
                return ' selected="selected"';
            }else{
                echo ' selected="selected"';
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
}
?>