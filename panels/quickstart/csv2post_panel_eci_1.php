<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'ecifreeuploadcsvfile';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Step 1: Upload CSV File');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_url'] = 'http://www.csv2post.com/feature-guides/csv-file-uploader';
// Form Settings - create the array that is passed to jQuery form functions
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
?>

<?php csv2post_panel_header( $panel_array );?>
  
  <?php
  if($csv2post_ecisession_array['nextstep'] > 1){
      csv2post_n_incontent('You have completed this step. You selected a CSV file named '.$csv2post_ecisession_array['filename'].' for your new project.','success','Small','Step Complete');
  }else{?>
  
       <h4>You have a <?php echo ini_get( "upload_max_filesize").'B upload limit on your server';?></h4>
       <p>No changes will be made to your blog on submitting this form.</p>
       
       <form method="post" enctype="multipart/form-data" name="uploadform" class="form-table">                
                
            <!-- nonce -->
            <input type="hidden" name="csv2post_admin_referer" value="quickstartuploadpaid">
            <?php wp_nonce_field('quickstartuploadpaid');?> 
            <!-- nonce -->
                    
            <input type="file" name="file" size="70" /><br /><br />
            <input type="hidden" id="csv2post_post_processing_required" name="csv2post_post_processing_required" value="true">
            <input type="hidden" id="csv2post_post_eciuploadcsvfile" name="csv2post_post_eciuploadcsvfile" value="true">
            <input type="hidden" name="csv2post_hidden_pageid" value="<?php echo $pageid;?>">
            <input type="hidden" name="csv2post_hidden_panel_name" value="<?php echo $panel_array['panel_name'];?>">
            <input type="hidden" name="csv2post_hidden_panel_title" value="<?php echo $panel_array['panel_title'];?>">
            <input type="hidden" name="csv2post_hidden_tabnumber" value="1">
            
            <div class="jquerybutton">
                <input class="button-primary" type="submit" value="Upload CSV File" name="eci_csvupload_submit" />
            </div>
              
            <?php
            // add the javascript that will handle our form action, prevent submission and display dialog box
            csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);
            ?>
            
        </form>
           
        <?php csv2post_jquery_form_promptdiv($jsform_set);?>
        
  <?php 
  }?>
  
<?php csv2post_panel_footer();?>
