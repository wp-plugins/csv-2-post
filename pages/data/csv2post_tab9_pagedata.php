<?php $csv2post_tabletotable_array = csv2post_get_option_tabletotable_array();?>

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'pairtables';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Pair Tables');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Create a pair of tables and copy data from one to the other');
$panel_array['panel_help'] = __('Use this panel to create the pair of tables. Select the Source table and 
destination table. This pairing is stored permanently and once submitted a new panel will appear on the Table To Table
screen. The new panel will allow you to create a relationship between columns in each table and must be used to
complete the Table To Table process.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
// <form> values, seperate from panel value
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
$jsform_set['dialogbox_title'] = 'Create Pair';
$jsform_set['noticebox_content'] = 'You are about to create a pair of tables. This will display a new panel offering
a form used to create relationships between columns. So once you create this pair, please find the panel for your
two tables. Do you wish to continue?';?>

<?php csv2post_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?> 
    
    <p>  
        <label for="csv2post_wtgpt_tabletotable_tableone">Source</label>      
        <select id="wtgpt_tabletotable_tableone" name="wtgpt_tabletotable_tableone" multiple="no" class="csv2post_multiselect_menu">
            <?php csv2post_tabletotable_option_items_databasetables();?>
        </select>   
    </p>
    
    <script>
    $("#wtgpt_tabletotable_tableone").multiselect({
       multiple: false,
       header: "Select a table",
       noneSelectedText: "Select a table",
       selectedList: 1
    });
    </script>
   
    <p> 
        <label for="csv2post_wtgpt_tabletotable_tabletwo">Destination</label>        
        <select id="wtgpt_tabletotable_tabletwo" name="wtgpt_tabletotable_tabletwo" multiple="no" class="csv2post_multiselect_menu">
            <?php csv2post_tabletotable_option_items_databasetables();?>
        </select>   
    </p>
    
    <script>
    $("#wtgpt_tabletotable_tabletwo").multiselect({
       multiple: false,
       header: "Select a table",
       noneSelectedText: "Select a table",
       selectedList: 1
    });
    </script>
           
     <?php 
    // add js for dialog on form submission and the dialog <div> itself
    if(csv2post_SETTINGS_form_submit_dialog($panel_array)){
        csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
        csv2post_jquery_form_prompt($jsform_set);
    }
    ?>
        
    <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?> 
        
<?php csv2post_panel_footer();?>

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'pairtablesdelete';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Delete Pairs');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Remove a pairing from the interface');
$panel_array['panel_help'] = __('You can delete a pairing of two tables using this panel. If you need to change the
column relationships within a pair you must delete it first then use the Pair Tables panel again. This feature
will not delete your actual database tables or reverse transferred data.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
// <form> values, seperate from panel value
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
$jsform_set['dialogbox_title'] = 'Delete Pair';
$jsform_set['noticebox_content'] = 'You are about to delete a pair. Do you wish to continue?';?>

<?php csv2post_panel_header( $panel_array );?>

    <?php 
    // begin form and add hidden values
    csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
    csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
    ?> 
    
    <?php
    if(!isset($csv2post_tabletotable_array) || !is_array($csv2post_tabletotable_array)){
        echo csv2post_notice('You do not have any paired tables.','info','Small','','','return');    
    }else{
        echo '<table class="widefat post fixed">';
                
        echo '
        <tr>
            <td width="50">Select</td>
            <td width="250">Source Table</td>
            <td>Destination Table</td> 
        </tr>';
        
        foreach($csv2post_tabletotable_array as $key => $pair){
            
            echo '
            <tr>
                <td>';?>
                    
                    <script>
                    $(function() {
                        $( "#csv2post_pair_<?php echo $key;?>" ).buttonset();
                    });
                    </script>

                    <div id="csv2post_pair_<?php echo $key;?>">                    
                        <input type="checkbox" name="csv2post_pairs[]" id="csv2post_pairs_<?php echo $key;?>" value="<?php echo $key;?>" />
                        <label for="csv2post_pairs_<?php echo $key;?>">*</label>                     
                    </div>
                    
                <?php 

                echo '</td>
                
                <td>'.$pair['t1'].'</td>
                
                <td>'.$pair['t2'].'</td>';?>

            </tr><?php                         
                           
        }// end while
        
        echo '</table>';        
    }
    ?>
           
     <?php 
    // add js for dialog on form submission and the dialog <div> itself
    if(csv2post_SETTINGS_form_submit_dialog($panel_array)){
        csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
        csv2post_jquery_form_prompt($jsform_set);
    }
    ?>
        
    <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>
        
<?php csv2post_panel_footer();?>

<h1>Tables Pairs</h1>

<?php
#############################################################
#                                                           #
#           DISPLAY TABLE TO TABLE PAIRING PANELS           #
#                                                           #
#############################################################
if(!$csv2post_tabletotable_array){
    echo csv2post_notice('You do not have any paired tables yet. Please use the Pair Tables panel to setup a pair
    and this message will be replaced with a panel offering more options.','info','Large','No Table Pairs','','return');
}elseif(!is_array($csv2post_tabletotable_array)){
    echo csv2post_notice('There Table To Table variable is not an array as expected. This is a fault and must be reported before using features on this screen.','error','Large','Fault Detected','','return');
}else{
    
    foreach($csv2post_tabletotable_array as $key => $pair){?>

        <?php
        ### TODO:HIGHPRIORITY, change the help and dialog text after first time column setup done to mention actual data transfer
        ++$panel_number;// increase panel counter so this panel has unique ID
        $panel_array = csv2post_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
        $panel_array['panel_name'] = 'tabletotablepair'.$key;// slug to act as a name and part of the panel ID 
        $panel_array['panel_title'] = __($pair['t1'].' to ' . $pair['t2']);// user seen panel header text 
        $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
        $panel_array['panel_intro'] = __('Transfer data from '.$pair['t1'].' to ' . $pair['t2']);
        $panel_array['panel_help'] = __('First we need to tell CSV 2 POST where the data is meant to go. We need
        to create a relationship between each column we want to transfer data from in Table One and each table
        we want the data to be put into in Table Two. We do not need to use every table, that is one of the great things
        about this tool we have created. CSV 2 POST builds the required SQL query to suit your tables and the
        columns you want involved. The two lists of column names have no relationship, their order does not matter.
        Do not get confused with the list of column names as they are for reference only. What matters is the
        selections you make in the menus adjacent to each of the Destination columns, that is where a relationship
        is created.');
        $panel_array['help_button'] = csv2post_helpbutton_text(false,false);
        // <form> values, seperate from panel value
        $jsform_set_override = array();
        $jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
        $jsform_set['dialogbox_title'] = 'Save Table To Table Settings';
        $jsform_set['noticebox_content'] = 'If you select the wrong columns or have selected the wrong
        tables you may cause irreversable corruption in your database data. If you are unsure in the slightest
        please backup your database. Do you wish to continue?';?>

        <?php csv2post_panel_header( $panel_array );?>

            <?php // begin form and add hidden values
            csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
            csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
            ?> 
    
            <input type="hidden" name="csv2post_t1" value="<?php echo $pair['t1'];?>">
            <input type="hidden" name="csv2post_t2" value="<?php echo $pair['t2'];?>">
            <input type="hidden" name="csv2post_t2no" value="<?php echo $pair['t2'];?>">
            <input type="hidden" name="csv2post_arraykey" value="<?php echo $key;?>">
            
            <?php 
            // if the pairing does not yet have column relationships set we display that form first 
            if( isset( $pair['columns'] ) ){?>
            
                <input type="hidden" name="csv2post_tabletotable_transfer" value="true"><?php
                 
                echo csv2post_notice('Your column relationships have been saved for this Table To Table pairing. To
                begin transferring data click the Submit button below. The transfer process continues until
                every record is transferred. If you find that you need to change the relationships between
                columns you must delete this pairing and re-make it.','info','Small','','','return');
                
            }else{?>                         
                
                <input type="hidden" name="csv2post_tabletotable_configure" value="true">
                                                  
                <?php 
                // ensure both tables still exist before querying column names
                $tables_exist_result = csv2post_sql_do_tables_exist(array($pair['t1'],$pair['t2']));
                if(!$tables_exist_result){
                    echo csv2post_notice('One of the tables in this pair no longer exists. Please delete the pair.','warning','Small','','','return');
                }else{?>
                
                    <table class="widefat post fixed">
                    
                        <tr>
                            <td width="180"><strong>Distination Columns</strong></td><td><strong>Select Source Column Going Into Destination Column</strong></td>
                            
                            <?php if(!$csv2post_is_free){echo '<td><strong>ID Column</strong></td>';}?>
                        
                        </tr>
                                        
                        <?php csv2post_tabletotable_list_column_menus($pair['t1'],$pair['t2'],$key);?>
                        
                    </table><?php
                    
                }// end if tables exist
            }// end if column relationships set
            

            // add js for dialog on form submission and the dialog <div> itself
            if(csv2post_SETTINGS_form_submit_dialog($panel_array)){
                csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
                csv2post_jquery_form_prompt($jsform_set);
            }
            ?>
                
            <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?> 
                
        <?php csv2post_panel_footer();?>
        
        <?php 
    }       
}
?>

<?php
if($csv2post_is_dev){
    ++$panel_number;// increase panel counter so this panel has unique ID
    $panel_array = csv2post_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
    $panel_array['panel_name'] = 'tabletotablearraydump';// slug to act as a name and part of the panel ID 
    $panel_array['panel_title'] = __('Table To Table Array Dump');// user seen panel header text 
    $panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
    $panel_array['panel_intro'] = __('A dump of the Table To Table array');
    $panel_array['panel_help'] = __('The array dump shows the values that CSV 2 POST works with and is intended for advanced users. This panel only shows when Developer Mode is active, with the idea that only developers would really have use for what is then displayed. The more data in this array, the higher chance there is of post creation being slower. Not because there are more values in this array, but because the values trigger more functions to be used. If you see values in the array for settings and features you realise you do not need. It is recommended that you remove them by visiting the applicable screens and panels.');
    $panel_array['help_button'] = csv2post_helpbutton_text(false,true);?>
    <?php csv2post_panel_header( $panel_array );?>

        <?php
        $tabletotable_array = csv2post_get_option_tabletotable_array();
        
        if(isset($csv2post_tabletotable_array) && !is_array($csv2post_tabletotable_array)){
            echo '<p>No table to table array found</p>';
        }elseif(isset($csv2post_tabletotable_array)){ 
            csv2post_var_dump($csv2post_tabletotable_array);
        }?>

    <?php csv2post_panel_footer();
}?>
      