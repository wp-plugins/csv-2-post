<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'morecommunitydonations';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Donations');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('Donations are sent to WebTechglobal. You may notice on buying CSV 2 POST full edition your payment is sent to WebTechGlobal Software. You may make payments to either by using paypal@webtechglobal.co.uk or paypal@csv2post.com. The "Software" account exists only to make admin easier and to increase our security.'); ?>
<?php csv2post_panel_header( $panel_array );?>
     <br />
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="8T5U9S7GN3HD4">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
</form>

<?php csv2post_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'morecommunitytestimonials';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Testimonials');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('You can submit a testmonial here and testimonials by other users. There is no need to tell us what edition you are using, that is detected automatically. We really appreciate any time you take to provide any type of feedback to us.'); ?>
<?php csv2post_panel_header( $panel_array );?>

<p>No Testimonials Submitted</p>

<?php csv2post_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'morecommunitylatestforumthreads';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Latest Forum Threads');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('I plan to make this feature more advanced with the ability to hold discussions on the plugins forum from your own blog. For now however it will show the latest discussions by all authors.'); ?>
<?php csv2post_panel_header( $panel_array );?>

<p>No Forum Threads Created</p>

<?php csv2post_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_WP_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'morecommunityexampleblogs';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Example Blogs');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_help'] = __('We will list your website here and tweet that you are a proud user of this plugin. We are creating support software to make all of this automated, if you use any of our other plugins you will be able to quickly tell the world with the click of a button.'); ?>
<?php csv2post_panel_header( $panel_array );?>

<p>No Example Blogs Submitted</p>

<?php csv2post_panel_footer();?> 
