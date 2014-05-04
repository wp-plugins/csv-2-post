<?php 
/** 
 * content settings view in designs area
 * 
 * @link by http://www.webtechglobal.co.uk
 * 
 * @author Ryan Bayne 
 *
 * @package CSV 2 POST
 */
 
global $C2P_WP,$C2P_UI,$c2p_settings;

if(!isset($c2p_settings['currentproject']) || !is_numeric($c2p_settings['currentproject'])){
    echo "<p class=\"csv2post_boxes_introtext\">". __('You have not created a project or somehow a Current Project has not been set.') ."</p>";
    return;
}

$project_array = $C2P_WP->get_project($c2p_settings['currentproject']);
// get the design array where we store settings related to configuring posts in every way 
$projectsettings = maybe_unserialize($project_array->projectsettings);?>

<div class="csv2post_boxes_threethirds">

    <?php $myforms_title = __('Default Title Template');?>
    <?php $myforms_name = 'defaulttitletemplate';?>
    <div class="csv2post_boxes_content">
        <?php $C2P_UI->panel_header($myforms_title,$myforms_name,false,false,false);?>
        <form method="post" name="<?php echo $myforms_name;?>" action="<?php $C2P_UI->form_action(); ?>">        
            <?php $C2P_WP->hidden_form_values($myforms_name,$myforms_title);?>
            <table class="form-table">                  
            <?php 
            $titletemplate = ''; 
            if(isset($projectsettings['titles']['defaulttitletemplate'])){$titletemplate = $projectsettings['titles']['defaulttitletemplate'];}        
            $C2P_UI->option_text('Title Template','defaulttitletemplate','defaulttitletemplate',$titletemplate,false,'csv2post_inputtext');
            $C2P_UI->option_text('','sampletitle','sampletitle','',true,'csv2post_inputtext');
            ?>
            </table>
            <input class="button" type="submit" value="Submit" />   
        </form>   
    </div>
</div>   

<div class="csv2post_boxes_threethirds">

    <?php $myforms_title = __('Default Content Template');?>
    <?php $myforms_name = 'defaultcontenttemplate';?>
    <div class="csv2post_boxes_content">
        <?php $C2P_UI->panel_header($myforms_title,$myforms_name,false,false,false);?>
        <form method="post" name="<?php echo $myforms_name;?>" action="<?php $C2P_UI->form_action(); ?>">        
            <?php $C2P_WP->hidden_form_values($myforms_name,$myforms_title);?>        
            <div id="poststuff">
            
                <?php 
                $wysiwygdefaultcontent = ''; 
                if(isset($projectsettings['content']['wysiwygdefaultcontent'])){$wysiwygdefaultcontent = $projectsettings['content']['wysiwygdefaultcontent'];} 
                wp_editor($wysiwygdefaultcontent,'wysiwygdefaultcontent',array('textarea_name' => 'wysiwygdefaultcontent'));
                ?>
            
            </div>
            <input class="button" type="submit" value="Submit" /> 
        </form>    
    </div>
</div>