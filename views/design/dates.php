<?php 
/** 
 * dates settings view in designs area
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

<div class="csv2post_boxes_twohalfs">

    <?php $myforms_title = __('Publish Dates');?>
    <?php $myforms_name = 'defaultpublishdates';?>
    <div class="csv2post_boxes_content">
        <?php $C2P_UI->panel_header($myforms_title,$myforms_name,false,false,false);?>
        <form method="post" name="<?php echo $myforms_name;?>" action="<?php $C2P_UI->form_action(); ?>">
            <?php $C2P_WP->hidden_form_values($myforms_name,$myforms_title);?>        
            <table class="form-table">
                <?php
                // date method
                $publishdatemethod = 'nocurrent123';
                if(isset($projectsettings['dates']['publishdatemethod'])){$publishdatemethod = $projectsettings['dates']['publishdatemethod'];}         
                $C2P_UI->option_radiogroup(__('Date Method'),'publishdatemethod','publishdatemethod',array('wordpress' => 'Wordpress','data' => __('Imported Dates'),'incremental' => __('Incremental'),'random' => __('Random')),$publishdatemethod,'random');
                
                // imported dates
                $datescolumn_table = ''; 
                $datescolumn_column = '';
                if(isset($projectsettings['dates']['datescolumn']['table'])){$datescolumn_table = $projectsettings['dates']['datescolumn']['table'];}
                if(isset($projectsettings['dates']['datescolumn']['column'])){$datescolumn_column = $projectsettings['dates']['datescolumn']['column'];}             
                $C2P_UI->option_projectcolumns(__('Pre-Made Dates'),$c2p_settings['currentproject'],'datescolumn','datescolumn',$datescolumn_table,$datescolumn_column,'notrequired','Not Required');?>
                
                <!-- Option Start -->
                <tr valign="top">
                    <th scope="row"> Format </th>
                    <td>
                    
                        <?php
                        $dateformat = 'nocurrent123'; 
                        if(isset($projectsettings['dates']['dateformat'])){$dateformat = $projectsettings['dates']['dateformat'];}
                        ?>
                        <select name="dateformat" id="dateformat">
                            <option value="noformat" <?php if($dateformat == 'noformat'){echo 'selected="selected"';} ?>>Do Not Format (use date data as it is)</option>       
                            <option value="uk" <?php if($dateformat == 'uk'){echo 'selected="selected"';} ?>>UK (will be formatted to MySQL standard)</option>
                            <option value="us" <?php if($dateformat == 'us'){echo 'selected="selected"';} ?>>US (will be formatted to MySQL standard)</option>
                            <option value="mysql" <?php if($dateformat == 'mysql'){echo 'selected="selected"';} ?>>MySQL Standard</option>
                            <option value="unsure" <?php if($dateformat == 'unsure'){echo 'selected="selected"';} ?>>Unsure</option>                                                                                                                     
                        </select>
                        
                    </td>
                </tr>
                <!-- Option End --><?php  
            
                // incremental                
                $C2P_UI->option_subline(__('Incremental dates configuration...'));
                
                $incrementalstartdate = ''; 
                if(isset($projectsettings['dates']['incrementalstartdate'])){$incrementalstartdate = $projectsettings['dates']['incrementalstartdate'];}        
                $C2P_UI->option_text(__('Start Date'),'incrementalstartdate','incrementalstartdate',$incrementalstartdate,false);
                
                $naturalvariationlow = ''; 
                if(isset($projectsettings['dates']['naturalvariationlow'])){$naturalvariationlow = $projectsettings['dates']['naturalvariationlow'];}        
                $C2P_UI->option_text(__('Variation Low'),'naturalvariationlow','naturalvariationlow',$naturalvariationlow,false);
                
                $naturalvariationhigh = ''; 
                if(isset($projectsettings['dates']['naturalvariationhigh'])){$naturalvariationhigh = $projectsettings['dates']['naturalvariationhigh'];}        
                $C2P_UI->option_text(__('Variation High'),'naturalvariationhigh','naturalvariationhigh',$naturalvariationhigh,false);
                            
                // random
                $C2P_UI->option_subline(__('Random dates configuration...'));
                
                $randomdateearliest = ''; 
                if(isset($projectsettings['dates']['randomdateearliest'])){$randomdateearliest = $projectsettings['dates']['randomdateearliest'];}        
                $C2P_UI->option_text(__('Earliest Date'),'randomdateearliest','randomdateearliest',$randomdateearliest,false);
               
                $randomdatelatest = ''; 
                if(isset($projectsettings['dates']['randomdatelatest'])){$randomdatelatest = $projectsettings['dates']['randomdatelatest'];}         
                $C2P_UI->option_text(__('Latest Date'),'randomdatelatest','randomdatelatest',$randomdatelatest,false); 
                ?>
            </table>
            <input class="button" type="submit" value="Submit" />
        </form>                                
    </div>
</div> 