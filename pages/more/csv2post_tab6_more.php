<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'moreoffersspecialoffera';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Pre-Order');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('You can pre-order CSV 2 POST');
$panel_array['panel_help'] = __('Please send payments to paypal@csv2post.com or visit www.csv2post.com and go through the checkout.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
?>
<?php csv2post_panel_header( $panel_array );?>
<p>For a limited time only you can buy CSV 2 POST for just &dollar;39/&pound;25 and as an extra bonus
you get Easy CSV Importer premium edition free, to give you something to use until CSV 2 POST is complete.
The planned
sales price is &dollar;157/&pound;99.99. The plugin will be in development until 2013 but a well working beta will be
available by August. During 2013 many support services will be deployed also. Click on the help button
to read more.</p>
<?php csv2post_panel_footer();?> 
