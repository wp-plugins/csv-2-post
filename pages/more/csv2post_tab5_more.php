<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'moretestingpublictrialblog';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Public Premium Edition Preview Blog');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Try before you buy simply by registering on the public preview blog.');
$panel_array['panel_help'] = __('Please remember that others will have used the blog and may be using it when your logged in. It is rare that a conflict of users happen but it is possible and this is really the easiest way to provide access. I try not to limit any features unless they allow abilities that people could use to hack that blog as has happened previously.');
$panel_array['help_button'] = csv2post_helpbutton_text(true,false);?>
<?php csv2post_panel_header( $panel_array );?>

              <p>Details still to come</p>

<?php csv2post_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'moretestingtestblogs';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Test Blogs');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Access various blogs open for public testing simply by registering.');
$panel_array['panel_help'] = __('A test blog is created for every new version and everyone is welcome to access them. Simply click on the Register or Log-In link on the blogs home page to begin. Keep in mind that others may be using the blog including myself however my testing is usually very short and most of my time spent coding. You may also experience problems if you test on the the latest version and someone is working on it. This is a rare occurence and we consider testing priority so feel that open access to the latest version is important.');
$panel_array['help_button'] = csv2post_helpbutton_text(true,false);?>
<?php csv2post_panel_header( $panel_array );?>

              <p>Details still to come</p>

<?php csv2post_panel_footer();?> 