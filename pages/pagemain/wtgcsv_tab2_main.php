<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'quickstartintroduction';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Quick Start Introduction');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $wtgcsv_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
?>
<?php wtgcsv_panel_header( $panel_array, false );?>

<h4>Usage Tips</h4>
<ol>
    <li>Always use the Question and Answers form on installation so the plugin configures the interface to suit your needs.</li>
    <li>Two types of panels exist on all pages, global and project. Global control all projects. This approach was decided instead of using a settings page.</li>
    <li>You do not need to use all features, ignore features you do not need</li>
    <li>Delete test projects or data import jobs before beginning on your final ones</li>
    <li>Do not select or input more than your project needs, it is just more work for the plugin to process</li>
</ol>

<h4>Quick Start Steps</h4>
<ul>
    <li>1. Create Data Import Job on Your Data page and import data from CSV file to a new database table</li>
    <li>2. Create Post Creation Project on Your Projects page and assign data tables</li>
    <li>3. Create posts or configure drip-feeding on Your Creations page</li>
</ul>
<?php wtgcsv_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'quickstartyourdata';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Step One: Create Data Import Job');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $wtgcsv_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
?>
<?php wtgcsv_panel_header( $panel_array, false );?>
<p>This plugin requires data to be in a database table before creating posts, so that is your first step before you
get started on the Your Projects screens. Unless you wish to use existing database tables, possibly creating by
another plugin or a manual import. Then you can skip Your Data screens. This approach has big advantages, including
updating the data tables with values used in advanced features i.e. setting a record to void or adding a post ID
too the record for the post made using the records data. This leads to many possible abilities.</p>
<p>Lets assume you want to start with a CSV file. You can create a post creation project before importing data from
your CSV file but you still can't make any posts. So it is recommended you at least import some
records before trying to configure Your Projects. Some features on the Your Projects screens require data to be imported
for testing prior to making posts. You do this on the Your Data screens.</p>
<h4>Create Data Import Job</h4>
<p>The plugin is new for 2012, but the long term plan and by the end of 2013 is for the plugin to be a great management tool
for data import plus auto-blogging. The plugin has been designed to assume that user wants long term management with the 
possibility of changes being required long after the initial data import and post creationg has been done. So we begin
with creating a Data Import Job. We name the job so it can be identified among many, this helps greatly if you want to
test many files quickly or you plan to use multiple CSV files to make your posts. Each CSV file requires a Data Import
Job to be created at this time.</p>
<p><strong>It is recommended that you import all rows from your CSV file/s before getting started on Your Projects screen.</strong></p>
<?php wtgcsv_panel_footer();?>

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'quickstartyourprojects';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Step Two: Create Post Creation Project');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $wtgcsv_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
?>
<?php wtgcsv_panel_header( $panel_array, false );?>
<p>The plugin has been, still is being, developed for long term projects. It allows you to make a Post Creation Project
which holds statistics, progress counters and even text history for your reading.
Unlike many CSV importers Wordpress CSV Importer does not attempt to take rows straight from CSV file and use the data
to make posts. It also does not assume the user wants to use all the data, straight away. To do this it records some
statistics such as the number of posts created, the number of records user and much more. This is the only professional
way to truly track the status of a project, especially when we consider that servers occasionally put a stop to any
processing. Post Creation Projects allow us to create small amounts of posts at a time (I call these events) and the plugin
will keep track of far on it is in regards too your data.</p>

<p>Many users look at the panels and all the features then say something to me like "I just want to import my data and
make posts". Wordpress CSV Importer will allow you to do just that and there is no need to use most of the features
however it means relying on Wordpress own defaults and the plugin needs to make assumptions. I encourage users to
learn and consider all features however I am still currently working on some methods to auto-mate the plugin, even
auto-configure settings for specific themes so users have even less to do. That is all come over 2012 and early 2013.</p>

<p><strong>Use the Create Post Creation Project panel on Your Projects page, you will find it in the "Projects" tab.</strong></p>     
<?php wtgcsv_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = array();
$panel_array['panel_name'] = 'quickstartyourcreation';// slug to act as a name and part of the panel ID 
$panel_array['panel_number'] = $panel_number;// number of panels counted on page, used to create object ID
$panel_array['panel_title'] = __('Step Three: Your Creation');// user seen panel header text 
$panel_array['pageid'] = $pageid;// store the $pageid for sake of ease
$panel_array['tabnumber'] = $wtgcsv_tab_number; 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
?>
<?php wtgcsv_panel_header( $panel_array, false );?>
<p>The step of creating posts is a big deal for big projects or developers using the plugin to complete a task for
a client. It is not good enough to simply inject hundreds of new posts into a blog and have little support after it. I
created Your Creation page for not just making posts but saving a drip-feed schedule, automatic post updating settings
and much more. An important feature is the ability to undo posts created, especially when users are new to using
Wordpress CSV Importer or possibly want to manually re-create all posts using newer data.</p>

<p><strong>You can create posts manually or automatically with drip-feeding on a schedule, now the fun begins...</strong></p>     

<?php wtgcsv_panel_footer();?>