<?php
if(!isset($c2p_settings['currentproject']) || !is_numeric($c2p_settings['currentproject'])){
echo "<p class=\"csv2post_boxes_introtext\">". __('You have not created a project or somehow a Current Project has not been set.') ."</p>";
return;
}
?>