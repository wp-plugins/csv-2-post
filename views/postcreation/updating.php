<?php
if(!isset($c2p_settings['currentproject']) || !is_numeric($c2p_settings['currentproject'])){
echo "<p class=\"csv2post_boxes_introtext\">". __('You have not created a project or somehow a Current Project has not been set.') ."</p>";
return;
}
?>
<div class="csv2post_boxes_twohalfs">

    <?php $myforms_title = __('Post Updating');?>
    <?php $myforms_name = 'defaultpostupdated';?>
    <div class="csv2post_boxes_content">
        <?php $C2P_UI->panel_header($myforms_title,$myforms_name,false,false,false);?>
        <table class="form-table">
        <?php
        $C2P_UI->option_switch('Update On Viewing','updatepostonviewing','updatepostonviewing',$c2p_settings['projectdefaults']['updatepostonviewing']);
        ?>
        </table>
        <input class="button" type="submit" value="Submit" />                    
    </div>
</div>