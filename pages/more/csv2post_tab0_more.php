<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'moresupportuserstutorials';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Users Tutorials');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Featured tutorials created by users of '.$csv2post_plugintitle);
$panel_array['panel_help'] = __('Create a tutorial for '.$csv2post_plugintitle.' and make it available to the public to get a mention in the plugin plus a backlink to your own site. It is recommended you also put the WebTechGlobal site address on the backlinked page for good SEO.'); 
$panel_array['help_button'] = csv2post_helpbutton_text(true,false);
?>
<?php csv2post_panel_header( $panel_array );?>
<p>No tutorials submitted yet, please be patient, the plugin is still very new</p>
<?php csv2post_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'hirepluginauthor';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Hire Plugin Author');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $csv2post_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Hire the plugin author to complete a project using the plugin itself');
$panel_array['panel_help'] = __('A great way to improve the plugin is to use it on real projects, this is something the plugin author does not find time to do much unless it is under hire. You are welcome to offer a fee for services that require the use of CSV 2 POST. You can also request changes to the plugin to suit your project requirements.'); 
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);?>
<?php csv2post_panel_header( $panel_array );?>

  <h4><?php echo $csv2post_plugintitle;?> Price List</h4>

  <p>Customised Feature or New Feature: £50</p>

  <h4>Wordpress Price List</h4>

  <p>Theme Customisation: £30</p>              
  <p>Wordpress Hosting: £20 per year inc VAT</p>
             
<?php csv2post_panel_footer();?> 