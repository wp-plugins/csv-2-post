<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'recentchanges';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Recent Changes');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('The most recent changes made to the plugin');
$panel_array['panel_help'] = __('This panel shows the most recent key changes to the plugin. For more detailed list of changes please go to www.wordpresscsvimpoter.com where each versions changes are stored.');
$panel_array['help_button'] = csv2post_helpbutton_text(true,false);
// TODO: HIGHPRIORITY, create a changes systems, offer details via API, changes system will offer copy and paste for .txt file plus extended details called by shortcode for public display
?>
<?php csv2post_panel_header( $panel_array );?>

<p>No Changes Yet</p>

<?php csv2post_panel_footer();?> 

<?php
$panel_array = csv2post_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array = array();
$panel_array['panel_name'] = 'requestedchanges';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Requested Changes');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Find out what others have already requested each requests status.');
$panel_array['panel_help'] = __('This is another idea to increase communications between myself and users of my plugins. If a requested change is made I process it to ensure it is a new requesst, whatever the case the user submitted the request is registered with the change tha will possibly be made. If the change is made, I then change its status to complete and all those interested are automatically sent an email letting them know.');
$panel_array['help_button'] = csv2post_helpbutton_text(true,false);
// TODO: changes system will manage requests, completion. API call will list public requests here
?>
<?php csv2post_panel_header( $panel_array );?>

              <p>No requested changes</p>

<?php csv2post_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'requestachange';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Request A Change');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Requesting a change here will enter it straight into the requests database.');
$panel_array['panel_help'] = __('Not everyone has access to this service as it makes entries straight to what is essentially a to do list. It is a feature only activated by myself, usually for beta testers. Please try to avoid submitting duplicate requests however I do understand one persons description of an idea may differ from another persons.');
$panel_array['help_button'] = csv2post_helpbutton_text(true,false);
// TODO: form for submitting request, do it via ticket system ticket system will enter requests into requests system
?>
<?php csv2post_panel_header( $panel_array );?>

              <p>Under Construction</p>

<?php csv2post_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'jobsavailable';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Jobs Available');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Jobs are set priced, not full-time work and involve working on all my Wordpress projects.');
$panel_array['panel_help'] = __('I want to offer something back to the community of all my software. One
way of doing this will be to offer freelance jobs. To do that in an efficient way I plan to create an API
for tasks I require done. It will be the start to a long term freelance website I plan. Initially it will simply
be information allowing small jobs to be listed here in this panel and users can respond to each of them. This approach
has many benefits for myself and users, developers or not.');
$panel_array['help_button'] = csv2post_helpbutton_text(false,false);
// TODO: LOWPRIORITY, 2013 part of freelance community API
?>
<?php csv2post_panel_header( $panel_array );?>

            <table class="widefat post fixed">
                <tr class="first">
                    <td width="150"><strong>Job ID</strong></td>
                    <td width="50"><strong>Job Name</strong></td>
                    <td width="100"><strong>Description</strong></td>
                    <td><strong>Job Reward (£)</strong></td>                    
                    <td><strong>Posted</strong></td>                                                       
                </tr>

                <tr>
                    <td>1</td>
                    <td>AdWords Banners</td>
                    <td>A full range of web banners for all AdWords sizes advertising CSV 2 POST
                    with the standard price. More details will be giving on request.</td>
                    <td>19.99</td>
                    <td>8th April 2012</td>                                                        
                </tr>                   
                                     
            </table>

<?php csv2post_panel_footer();?> 