<?php
/** 
* Class for interface functions, those that output HTML.
* Can include Ajax and Javascript related functions. 
* 
* @since 8.0.0
* 
* @author Ryan Bayne 
*/

class C2P_ui {
    public function __construct() {
        
    }                         
    public function form_action($values = ''){
        global $c2p_tab_number;
        echo get_admin_url() . 'admin.php?page=' . $_GET['page'] . '&c2ptab='.$c2p_tab_number.$values;
    }

    /**
    * Use to apply selected="selected" to HTML form menu
    * 
    * @param mixed $actual_value
    * @param mixed $item_value
    * @param mixed $output
    * @return mixed
    */
    public function is_selected($actual_value,$item_value,$output = 'return'){
        if($actual_value === $item_value){
            if($output == 'return'){
                return ' selected="selected"';
            }else{
                echo ' selected="selected"';
            }
        }else{
            if($output == 'return'){
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
    public function is_checked($actual_value,$item_value,$output = 'return'){
        if($actual_value === $item_value){
            if($output == 'return'){
                return ' checked';
            }else{
                echo ' checked';
            }
        }else{
            if($output == 'return'){
                return '';
            }else{
                echo '';
            }
        }
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
    public function option_switch($title,$name,$id,$current_value = 'nocurrent123',$onlabel = 'Enabled',$offlabel = 'Disabled',$default = 'enabled'){
        if($default != 'enabled' && $default != 'disabled'){
            $default = 'disabled';
        }
             
        // only enabled and disabled is allowed for the switch, do not change this, create a new method for a different approach
        if($current_value != 'enabled' && $current_value != 'disabled'){
            $current_value = $default;
        }
        
        $firstlabel = __('Enabled');
        $secondlabel = __('Disabled');
        
        if($onlabel !== 'Enabled'){$firstlabel = $onlabel;}
        if($onlabel !== 'Disabled'){$secondlabel = $offlabel;}        
        ?>
    
        <!-- Option Start -->
        <tr valign="top">
            <th scope="row"><?php _e($title,'csv2post'); ?></th>
            <td>
                <fieldset><legend class="screen-reader-text"><span><?php echo $title; ?></span></legend>
                    <input type="radio" id="<?php echo $name;?>_enabled" name="<?php echo $name;?>" value="enabled" <?php echo $this->is_checked($current_value,'enabled','return');?> />
                    <label for="<?php echo $name;?>_enabled"> <?php echo $firstlabel; ?></label>
                    <br />
                    <input type="radio" id="<?php echo $name;?>_disabled" name="<?php echo $name;?>" value="disabled" <?php echo $this->is_checked($current_value,'disabled','return');?> />
                    <label for="<?php echo $name;?>_disabled"> <?php echo $secondlabel; ?></label>
                </fieldset>
            </td>
        </tr>
        <!-- Option End -->
                            
    <?php  
    }  
    /**
    * add text input to Wordpress style form which is tabled and has optional HTML5 support
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
    */
    public function option_text($title,$name,$id,$current_value = '',$readonly = false,$class = 'csv2post_inputtext',$append_text = '',$left_field = false,$right_field_content = '',$required = false){
        if(isset($_POST[$name])){                   
            $current_value = stripslashes($_POST[$name]);
        }
        ?>
        <!-- Option Start -->        
        <tr valign="top">
            <th scope="row"><?php echo $title; ?>
            
                <?php 
                // if required add asterix ("required" also added to input to make use of HTML5 control")
                if($required){
                    echo '<abbr class="req" title="required">*</abbr>';
                }
                 
                // if $left_field is true the input put in the first field and not second
                if(!$left_field){ echo '</th><td>'; }?>
   
                <input type="text" name="<?php echo $name;?>" id="<?php echo $id;?>" value="<?php echo $current_value;?>" class="<?php echo $class;?>" <?php if($readonly){echo ' readonly';}?><?php if($required){echo 'required';}?>> 
                <?php echo $append_text;?>

                <?php 
                // if $left_field is true we start the second (right side) field here
                if($left_field){ echo '</th><td>' . $right_field_content; }
                ?>            
                
            </td>
        </tr>
        <!-- Option End --><?php 
    }
    /**
    * uses option_text() to add input, this version requires the most common required attributes only
    * 
    */
    public function option_text_simple($title,$nameandid,$current_value = '',$required = false){
        $this->option_text($title,$nameandid,$nameandid,$current_value,false,'csv2post_inputtext','',false,'',true);
    }
    /**
    * use in options table to add a line of text like a separator 
    * 
    * @param mixed $secondfield
    * @param mixed $firstfield
    */
    public function option_subline($secondfield,$firstfield = ''){?>
        <!-- Option Start -->        
        <tr valign="top">
            <th scope="row"><?php echo $firstfield;?></th>
            <td><?php echo $secondfield;?></td>
        </tr>
        <!-- Option End --><?php     
    }
    public function option_radiogroup($title,$id,$name,$radio_array,$current = 'nocurrent123',$default = 'nodefaultset123'){
        global $C2P_PHP,$C2P_WP;
   
        echo '
        <!-- Option Start -->        
        <tr valign="top">
            <th scope="row">'.$title.'</th>
            <td><fieldset>';
            
            echo '<legend class="screen-reader-text"><span>'.$title.'</span></legend>';
            
            $default_set = false;

            $items = count($radio_array);
            $itemsapplied = 0;
            foreach($radio_array as $key => $option){
                ++$itemsapplied;
                    
                // determine if this option is the currently stored one
                $checked = '';
                if($current == $key){
                    $default_set = true;
                    $checked = 'checked';
                }elseif($current == 'nocurrent123' && $default_set == false){
                    $default_set = true;
                    $checked = 'checked';
                }
                
                // set the current to that just submitted
                if(isset($_POST[$name]) && $_POST[$name] == $key){
                    $default_set = true;
                    $checked = 'checked';                
                }
                
                // check current item is no current giving or current = '' 
                if($current == 'nocurrent123' && $default == $key){
                    $default_set = true;
                    $checked = 'checked';                
                } 
                
                // if on last option and no current set then check last item
                if($default_set == false && $items == $itemsapplied){
                    $default_set = true;
                    $checked = 'checked';                
                }                
                
                // create an object id                 
                $itemid = $id . $C2P_WP->clean_string($option);
 
                $value = $key;
                      
                echo '<input type="radio" id="'.$itemid.'" name="'.$name.'" value="'.$value.'" '.$checked.'/>
                <label for="">'. $option .'</label>
                <br />';
            }
            
        echo '</fieldset>
            </td>
        </tr>
        <!-- Option End -->';                 
    }
    
    public function option_textarea($title,$id,$name,$rows = 4,$cols = 50,$current_value){?>
        <!-- Option Start -->        
        <tr valign="top">
            <th scope="row"><?php echo $title; ?></th>
            <td>
                <textarea id="<?php echo $id;?>" name="<?php echo $name;?>" rows="<?php echo $rows;?>" cols="<?php echo $cols;?>"><?php echo $current_value;?></textarea>
            </td>
        </tr>
        <!-- Option End --><?php     
    }
    
    public function option_menu($title,$id,$name,$array,$current = 'nocurrentvalue123',$defaultvalue = 'nodefaultrequired123',$defaulttitle = 'nodefaultrequired123'){?>
        <!-- Option Start -->        
        <tr valign="top">
            <th scope="row"><label for="<?php echo $id; ?>"><?php echo $title; ?></label></th>
            <td>            
                <select name="<?php echo $name;?>" id="<?php echo $id;?>">
                    <?php
                    if($defaultvalue != 'nodefaultrequired123' && $defaulttitle != 'nodefaultrequired123'){
                        echo '<option selected="selected" value="notrequired">Not Required</option>';
                    }                    
                    
                    $selected = '';            
                    foreach($array as $key => $title){
                        if($key == $current){
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
    * outputs a single html checkbox with label
    * 
    * wrap in <fieldset><legend class="screen-reader-text"><span>Membership</span></legend></fieldset>
    * 
    * @param mixed $label
    */
    public function option_checkbox_single($name,$label,$id,$check = 'off',$value = false){
        $selected = '';
        if($check == 'on'){$selected = 'checked';}
        if($value !== false){$thevalue = ' value="'.$value.'" ';}else{$thevalue = '';}
        echo '<label for="'.$id.'"><input name="'.$name.'" type="checkbox" id="'.$id.'"'.$thevalue.''.$selected.'>'.$label.'</label>';
    }

    /**
    * Displays a mid grey area for pres
    * 
    * @param mixed $title
    * @param mixed $message
    */
    public function info_area($title,$message,$admin_only = true){ 
        if($admin_only == true && current_user_can( 'manage_options' ) || $admin_only !== true){
            return '
            <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
                <h4>'.$title.'</h4>
                <p>'.$message.'</p>
            </div>';          
        }
    } 
    /**
    * a standard menu of users wrapped in <td> 
    */
    public function option_menu_users($title,$name,$id,$current_value = 'nocurrentvalue123'){
                 
        $blogusers = get_users('blog_id=1&orderby=nicename');?>

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
                    foreach ($blogusers as $user){ 

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
    */
    public function option_menu_categories($title,$name,$id,$current_value = 'nocurrentvalue123'){                      
        $cats = get_categories('hide_empty=0&echo=0&show_option_none=&style=none&title_li=');?>

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
    */
    public function option_radiogroup_posttypes($title,$name,$id,$current_value = 'nocurrent123'){         
        echo '
        <!-- Option Start -->        
        <tr valign="top">
            <th scope="row">'.$title.'</th>
            <td><fieldset>';
            
            echo '<legend class="screen-reader-text"><span>'.$title.'</span></legend>';
            
            $post_types = get_post_types('','names');
            $current_applied = false;        
            $i = 0; 
            foreach( $post_types as $post_type ){
                
                // dont add "post" as it is added last so that it can be displayed as current default when required
                if($post_type != 'post'){
                    $checked = '';
                    
                    if($post_type == $current_value){
                        $checked = 'checked="checked"';
                        $current_applied = true;    
                    }elseif($current_value == 'nocurrent123' && $current_applied == false){
                        $checked = 'checked="checked"';
                        $current_applied = true;                        
                    }
                    
                    echo '<input type="radio" name="'.$name.'" id="'.$id.$i.'" value="'.$post_type.'" '.$checked.' />
                    <label for="'.$id.$i.'"> '.$post_type.'</label><br>';
    
                    ++$i;
                }
            }
            
            // add post last, if none of the previous post types are the default, then we display this as default as it would be in Wordpress
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
    public function option_radiogroup_postformats($title,$name,$id,$current_value = 'nocurrent123'){         
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
                
                foreach($post_formats[0] as $key => $format){
                    
                    $statuschecked = '';
                    if($current_value === $format){
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
    */
    public function option_menu_posttemplates($title,$name,$id,$current_value = 'nocurrentvalue123'){                      
        $cats = get_categories('hide_empty=0&echo=0&show_option_none=&style=none&title_li=');?>

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
                        if($current_value == $post->ID){
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
    * lists a projects headers with checkboxes in Wordpress options table styling
    */
    public function option_project_headers_checkboxes($project_id,$name){
        global $C2P_WP,$C2P_WP;
        $project_columns_array = $C2P_WP->get_project_columns_from_db($project_id,true);
        // get the data treatment then remove it to make the loops simple
        $treatment = $project_columns_array['arrayinfo']['datatreatment'];
        unset($project_columns_array['arrayinfo']['datatreatment']);
   
        // build array data types
        $datatypes_array = array();
        $datatypes_array['notrequired'] = 'Not Required';
        $datatypes_array['alphanumeric'] = 'Alphanumeric';
        $datatypes_array['numeric'] = 'Numeric';
        $datatypes_array['linkurl'] = 'Link URL';
        $datatypes_array['imageurl'] = 'Not Required';
        $datatypes_array['boolean'] = 'Boolean';
      
        // loop through query result, the initial keys are table names
        foreach($project_columns_array as $table_name => $columns_array){
            // the array should have a key named arrayinfo which we skip
            if($table_name != 'arrayinfo'){
                // loop through the current tables columns
                foreach($columns_array as $key => $acolumn){

                    // we tidy the interface for roundnumber up and down by hiding columns that have a set datatype which is not numerical
                    if($name == 'roundnumberupcolumns' || $name == 'roundnumbercolumns'){
                        $rules_array = $C2P_WP->get_data_rules_source($project_columns_array['arrayinfo']['sources'][$table_name]);
                        if(!empty($rules_array)){
                            if(isset($rules_array['datatypes'][$acolumn]) && $rules_array['datatypes'][$acolumn] != 'numeric'){
                                continue;
                            }
                        }
                    }
                    
                    $checked = '';
                    
                    // update form from previous submission
                    if(isset($_POST["$name#$table_name#$acolumn"])){
                        $checked = 'checked';
                    }
                                       
                    $rules_array = $C2P_WP->get_data_rules_source($project_columns_array['arrayinfo']['sources'][$table_name]);
                    if(!empty($rules_array)){
                        if(isset($rules_array[$name][$acolumn])){
                            $checked = 'checked';       
                        }
                    }          
                    ?>  
                
                
                    <?php 
                    if($treatment == 'individual'){$label = $acolumn . '<br><span style="color:grey;">'.$table_name . '</span>';}else{$label = $acolumn;}
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
    public function option_projectcolumns($title,$project_id,$name,$id,$current_table = 'nocurrentvalue123',$current_column = 'nocurrentvalue123',$default_value = false,$default_label = false){
        global $C2P_WP;
        $project_columns_array = $C2P_WP->get_project_columns_from_db($project_id,true);
        unset($project_columns_array['arrayinfo']);
        ?>         
        <tr valign="top">
            <th scope="row"><?php echo $title;?></th>
            <td>
                <select name="<?php echo $name;?>" id="<?php echo $id;?>">
                
                    <?php 
                    if($default_value && $default_label){
                        echo '<option value="'.$default_value.'">'.$default_label.'</option>';
                    }

                    foreach($project_columns_array as $table_name => $columns_array){

                        foreach($columns_array as $key => $acolumn){
                         
                            $selected = '';
                            if($current_table == $table_name && $current_column == $acolumn){
                                $selected = ' selected="selected"'; 
                            }

                            $label = $table_name . ' - '. $acolumn;

                            echo '<option value="'.$table_name . '#' . $acolumn.'"'.$selected.'>'.$label.'</option>';    
                        }  
                    }
                    ?>
                    
                </select> 
                 
            </td>
        </tr><?php 
    }     
    public function option_projectcolumns_splittermenu($title,$project_id,$name,$id,$current = 'nocurrentvalue123',$default_value = false,$default_label = false){
        global $C2P_WP;
        $project_columns_array = $C2P_WP->get_project_columns_from_db($project_id,true);
        unset($project_columns_array['arrayinfo']);
        ?>         
        <tr valign="top">
            <th scope="row"><?php echo $title;?></th>
            <td>
                <select name="<?php echo $name;?>" id="<?php echo $id;?>">
                
                    <?php 
                    if($default_value && $default_label){
                        echo '<option value="'.$default_value.'">'.$default_label.'</option>';
                    }

                    foreach($project_columns_array as $table_name => $columns_array){

                        foreach($columns_array as $key => $acolumn){
                         
                            $selected = '';
                            
                            // ensure we have rules
                            if($current == $acolumn){
                                $selected = ' selected="selected"'; 
                            }

                            $label = $table_name . ' - '. $acolumn;

                            echo '<option value="'.$table_name . '#' . $acolumn.'"'.$selected.'>'.$label.'</option>';    
                        }  
                    }
                    ?>
                    
                </select> 
                 
            </td>
        </tr><?php 
    }
    public function option_projectcolumns_categoriesmenu($title,$project_id,$name,$id,$current_table = 'nocurrentvalue123',$current_column = 'nocurrentvalue123',$default_value = false,$default_label = false){
        global $C2P_WP;
        $project_columns_array = $C2P_WP->get_project_columns_from_db($project_id,true);
        unset($project_columns_array['arrayinfo']);
        ?>         
        <tr valign="top">
            <th scope="row"><?php echo $title;?></th>
            <td>
                <select name="<?php echo $name;?>" id="<?php echo $id;?>">
                
                    <?php 
                    if($default_value && $default_label){
                        echo '<option value="'.$default_value.'">'.$default_label.'</option>';
                    }

                    foreach($project_columns_array as $table_name => $columns_array){

                        foreach($columns_array as $key => $acolumn){
                         
                            $selected = '';
                            if($current_table == $table_name && $current_column == $acolumn){
                                $selected = ' selected="selected"'; 
                            }

                            $label = $table_name . ' - '. $acolumn;

                            echo '<option value="'.$table_name . '#' . $acolumn.'"'.$selected.'>'.$label.'</option>';    
                        }  
                    }
                    ?>
                    
                </select> 
                 
            </td>
        </tr><?php 
    }           
    /**
    * menu of project columns with a menu for each used to select that columns data type
    * 
    * @param mixed $project_id
    * @param mixed $name
    * @param mixed $id
    */
    public function option_column_datatypes($project_id,$name,$id){
        if(!is_numeric($project_id)){
            return false;
        }
        
        global $C2P_WP;
        $project_columns_array = $C2P_WP->get_project_columns_from_db($project_id,true);
                
        // get the data treatment then remove it to make the loops simple
        $treatment = $project_columns_array['arrayinfo']['datatreatment'];
        
        if(isset($project_columns_array['arrayinfo']['datatreatment'])){
            unset($project_columns_array['arrayinfo']['datatreatment']);
        }
          
        $current_value = 'notrequired';
                                
        $datatypes_array = array();
        $datatypes_array['notrequired'] = 'Not Required';
        $datatypes_array['alphanumeric'] = 'Alphanumeric';
        $datatypes_array['numeric'] = 'Numeric';
        $datatypes_array['linkurl'] = 'Link URL';
        $datatypes_array['imageurl'] = 'Image URL';
        $datatypes_array['boolean'] = 'Boolean';
                           
        foreach($project_columns_array as $table_name => $columns_array){     
            if($table_name != 'arrayinfo'){   
                foreach($columns_array as $key => $acolumn){
                    $rules_array = $C2P_WP->get_data_rules_source($project_columns_array['arrayinfo']['sources'][$table_name]);
                    if(!empty($rules_array)){
                        if(isset($rules_array['datatypes'][$acolumn])){
                            $current_value = $rules_array['datatypes'][$acolumn];       
                        }
                    }
                            
                    // update form from previous submission
                    if(isset($_POST["$name#$table_name#$acolumn"])){
                        $current_value = $_POST["$name#$table_name#$acolumn"];
                    }
                    ?>  
                
                    <?php 
                    if($treatment == 'individual'){$label = $acolumn . '<br><span style="color:grey;">'.$table_name . '</span>';}else{$label = $acolumn;}
                    ?>
                                        
                    <tr valign="top">                    
                        <th scope="row"><?php echo $label;?></th>
                        <td>
                            <input type="hidden" name="sourceid_<?php echo $table_name . $acolumn;?>" value="<?php echo $project_columns_array['arrayinfo']['sources'][$table_name];?>">
                            <select name="<?php echo "$name#$table_name#$acolumn";?>" id="<?php echo "$name$table_name$acolumn";?>">
                                <?php    
                                foreach($datatypes_array as $key => $data_type){
                                    $selected = ''; 
                                    if($current_value == $key){$selected = ' selected="selected"';}
                                
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
    public function display_current_project(){
        global $c2p_settings,$C2P_WP,$C2P_DB,$CSV2POST,$wpdb,$C2P_UI;
        $current = 'No Projects'; 
        $projectid = 'N/A';              
        if(isset($c2p_settings['currentproject']) && is_numeric($c2p_settings['currentproject'])){
            $current = $C2P_WP->get_project_name($c2p_settings['currentproject']);
            $projectid = $c2p_settings['currentproject'];    
        }else{
            $row = $C2P_DB->selectrow($wpdb->c2pprojects,'projectid = projectid','projectname');  
            if($row == NULL){
                $current = 'No Projects Created';
            }else{  
                // set the found project as the current one
                if(isset($row->projectid) && is_numeric($row->projectid)){
                    $c2p_settings['currentproject'] = $row->projectid;
                    $projectid = $row->projectid;
                    $C2P_WP->update_settings($c2p_settings);
                } 

                $current = $row->projectname;
            }
        }

        echo $C2P_UI->info_area('Current Project: ' . $current .' ('. $projectid .')',
            $C2P_WP->linkaction($C2P_WP->tabnumber(),$_GET['page'],'createpostscurrentproject','Create posts using the current project','Create Posts','') . 
            $C2P_WP->linkaction($C2P_WP->tabnumber(),$_GET['page'],'importdatecurrentproject','Import data for the current project','Import Data','') 
        );
    }
    /**
    * displays a vertical list of icons, for use inside panels
    * 
    * @param string $form_name required to create id
    * @param boolean $trash reset the form, usually found on large forms
    * @param string $youtube pass the video id and nothing else
    * @param integer $information pass the array key for ['help'] in the menu array for the feature icon is for
    */
    public function panelicons($form_name,$trash = false,$youtube = false,$information = false){
        $total_icons = 0; 
        
        if($trash){$this->trash_icon($form_name);++$total_icons;}

        if($youtube){                
            $this->video_icon($form_name,$youtube);++$total_icons;
        } 

        if($information !== false){               
            $this->information_icon($form_name,$information);++$total_icons;
        }; 
    }
    public function trash_icon($form_name){?>
        <a href="<?php echo $form_name;?>"><img src="../wp-content/plugins/csv-2-post/images/trash-icon.gif" alt="<?php _e('Reset form');?>" title="<?php _e('Reset form');?>"></a><?php 
    }
    public function video_icon($form_name,$youtubeid = 'xVmrPMt9SMQ'){
        add_thickbox();
        if($youtubeid){?>
            <a href="https://www.youtube.com/watch?v=<?php echo $youtubeid;?>" target="_blank"><img src="../wp-content/plugins/csv-2-post/images/video-icon.gif" alt="<?php _e('View video on YouTube');?>" title="<?php _e('View video on YouTube');?>"></a><?php
        } 
    }
    public function information_icon($form_name,$information){
        global $c2p_mpt_arr,$c2p_page_name,$c2p_tab_number;
        add_thickbox();?>
        <div id="infothickbox<?php echo $form_name;?>" style="display:none;">
            <h3><?php echo $c2p_mpt_arr[$c2p_page_name]['tabs'][$c2p_tab_number]['help'][$information][0];?></h3>
            <p><?php echo $c2p_mpt_arr[$c2p_page_name]['tabs'][$c2p_tab_number]['help'][$information][1];?></p>   
        </div>    
        <a href="#TB_inline?width=600&height=550&inlineId=infothickbox<?php echo $form_name;?>" class="thickbox">
        <img src="../wp-content/plugins/csv-2-post/images/info-icon.gif" alt="<?php _e('View help for this feature');?>" title="<?php _e('View help for this feature');?>">
        </a><?php 
    }
    public function panel_header($myforms_title,$myforms_name,$trash = false,$video = false,$information = false,$introduction = false){
        global $C2P_UI;?>
        <a id="anchor_<?php echo $myforms_name;?>"></a>
        <table width="100%">
            <tr>
                <td width="50%">
                    <h2><?php echo $myforms_title; ?></h2>
                </td>
                <td width="50%" align="right">
                    <?php $C2P_UI->panelicons($myforms_name,$trash,$video,$information);?>
                </td>
            </tr>
        </table>
        
        <?php if($introduction !== false && !empty($introduction)){echo "<p class=\"csv2post_boxes_introtext\">". $introduction ."</p>";}?>
        
        <?php 
    }
} 

?>
