<?php 
function csv2post_FORM_menu_capabilities($csv2post_ARRAY_capabilities,$page_name,$key,$current){?>
    
    <select name="csv2post_capabilitiesmenu_<?php echo $page_name;?>_<?php echo $key;?>" id="csv2post_capabilitiesmenu_<?php echo $page_name;?>_<?php echo $key;?>" class="csv2post_multiselect_menu">
        <?php 
           foreach($csv2post_ARRAY_capabilities as $cap){
               $selected = '';
               if($cap == $current){
                   $selected = 'selected="selected"';
               }
               echo '<option value="'.$cap.'" '.$selected.'>'.$cap.'</option>';
           }
        ?>                                                                                                                     
    </select>        

    <script>
    $("#csv2post_capabilitiesmenu_<?php echo $page_name;?>_<?php echo $key;?>").multiselect({
       multiple: false,
       header: "Select Required Capability",
       noneSelectedText: "Select Required Capability",
       selectedList: 1
    });
    </script><?php
} 
?>