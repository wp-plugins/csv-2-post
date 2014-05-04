<?php
/** 
 * tools for post creation
 * 
 * @link by http://www.webtechglobal.co.uk
 * 
 * @author Ryan Bayne 
 *
 * @package CSV 2 POST
 */       
 
global $wpdb,$C2P_UI,$C2P_WP,$C2P_DB,$c2p_settings,$c2p_mpt_arr,$c2p_tab_number,$c2p_page_name;?>

<?php
if(!isset($c2p_settings['currentproject']) || !is_numeric($c2p_settings['currentproject'])){
echo "<p class=\"csv2post_boxes_introtext\">". __('You have not created a project or somehow a Current Project has not been set.') ."</p>";
return;
}
?>

<div class="csv2post_boxes_twohalfs">
    <?php $myforms_title = __('Create Posts');?>
    <?php $myforms_name = 'createpostsbasic';?>
    <div class="csv2post_boxes_content" style="max-height: 300px;"> 
        <?php $C2P_UI->panel_header($myforms_title,$myforms_name,false,false,false);?>     
        <form method="post" name="<?php echo $myforms_name;?>" action="<?php $C2P_UI->form_action(); ?>">
            <?php $C2P_WP->hidden_form_values($myforms_name,$myforms_title);?>
            <table class="form-table">
            <?php $C2P_UI->option_text('Total','totalposts','totalposts','1')?>
            </table>
            <input class="button" type="submit" value="Submit" />
        </form> 
    </div>
</div> 