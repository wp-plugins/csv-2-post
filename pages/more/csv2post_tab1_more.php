<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'morecommunitydonations';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Donations');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Donations encourage more work on free services and can pay for more support content');
$panel_array['panel_help'] = __('Donations are sent too WebTechglobal. You may notice on buying CSV 2 POST full edition your payment is sent too WebTechGlobal Software. You may make payments too either by using paypal@webtechglobal.co.uk or paypal@csv2post.com. The "Software" account exists only to make admin easier and to increase our security.'); 
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
?>
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
$panel_array = array();
$panel_array['panel_name'] = 'morecommunitytestimonials';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Testimonials');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Read testimonials from other users for both the free edition and premium edition.');
$panel_array['panel_help'] = __('You can submit a testmonial here and testimonials by other users. There is no need to tell us what edition you are using, that is detected automatically. We really appreciate any time you take to provide any type of feedback to us.'); 
$panel_array['help_button'] = csv2post_helpbutton_text(true,false);
?>
<?php csv2post_panel_header( $panel_array );?>

<p>No Testimonials Submitted</p>

<?php csv2post_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'morecommunitylatestforumthreads';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Latest Forum Threads');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Read the latest forum conversations related to this plugin from the plugins official forum.');
$panel_array['panel_help'] = __('I plan to make this feature more advanced with the ability to hold discussions on the plugins forum from your own blog. For now however it will show the latest discussions by all authors.'); 
$panel_array['help_button'] = csv2post_helpbutton_text(true,true);
?>
<?php csv2post_panel_header( $panel_array );?>

<p>No Forum Threads Created</p>

<?php csv2post_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'morecommunityexampleblogs';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Example Blogs');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Submit your blog to be listed here if you are a proud user of this plugin.');
$panel_array['panel_help'] = __('We will list your website here and tweet that you are a proud user of this plugin. We are creating support software to make all of this automated, if you use any of our other plugins you will be able to quickly tell the world with the click of a button.'); 
$panel_array['help_button'] = csv2post_helpbutton_text(true,false);
?>
<?php csv2post_panel_header( $panel_array );?>

<p>No Example Blogs Submitted</p>

<?php csv2post_panel_footer();?> 
