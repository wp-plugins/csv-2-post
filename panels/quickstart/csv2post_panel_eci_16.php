<?php
/** 
 * Free edition file (applies to paid also) for CSV 2 POST plugin by WebTechGlobal.co.uk
 *
 * @package CSV 2 POST
 * 
 * @author Ryan Bayne | ryan@webtechglobal.co.uk
 */
 
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'quickstartfreethemesupport';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Step 15: Extended Theme Support');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['dialogdisplay'] = 'no';
// <form> values, seperate from panel value
$jsform_set_override = array();
$jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);            
?>

<?php csv2post_panel_header( $panel_array );?>
    
    <?php 
    if($csv2post_ecisession_array['nextstep'] > 16){

        csv2post_n_incontent('This step was complete.','success','Small','Step Complete');

    }else{?>

        <?php 
        // begin form and add hidden values
        csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
        csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
        ?>

            <p>CSV 2 POST fully supports <?php echo get_current_theme();?> by allowing custom fields to be created but
            we're trying to go a step further and so is Wordpress. As of WP 3.6 a new Post Formats ability exists, this
            panel makes use of it if your theme supports it, not all will.</p>

            <h4>Post Formats</h4>
            <?php 
            if ( current_theme_supports( 'post-formats' ) ) {?>
            
                <p>Apply the same Post Format to all posts (premium offers more options)</p>
                <script>
                $(function() {
                    $( "#csv2post_eci_postformat_radios" ).buttonset();
                });
                </script>

                <div id="csv2post_eci_postformat_radios">
                    <?php csv2post_FORMOBJECT_postformat_radios('quickstart');?>
                </div>  

            <?php 
            }else{
                csv2post_n_incontent('Post Formats were added to Wordpress 3.6 Beta in April 2013. Your theme does not yet support Post Formats.','info','Tiny','No Post Format Support');        
            }?> 
            
            <h4>Other Integration Abilities</h4>
            <p>Your theme does not have anymore features that require integration.</p>
            
        <?php csv2post_formend_standard($panel_array['form_button'],$jsform_set['form_id']);?>            
     
    <?php 
    }?>
    
<?php csv2post_panel_footer();?>