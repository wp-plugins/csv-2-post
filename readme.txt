=== Plugin Name ===
Contributors: WebTechGlobal
Donate link: http://www.webtechglobal.co.uk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: CSV 2 POST, csv2post,dataimport,importer,.csv,data,autoblogger,autoblogging,wpcsvimporter
Requires at least: 3.8.0
Tested up to: 3.9.1
Stable tag: trunk

CSV 2 POST Version 8 by Ryan R. Bayne

== Description ==

Lets turn data into websites! CSV 2 POST for Wordpress can import any .csv file (only requirement is MySQL ready headers, basically no special characters allowed ) then autoblog the data into hundreds or even thousands of well designed WP posts. My CSV importer plugin creates custom fields, categories and meta. If your new to Wordpress those are some of the elements that make up a web page in WP. CSV 2 POST is the first plugin to import data to a custom database table allowing the data to be prepared and other more advanced steps during the autoblogging procedure. Combine that with the power of Wordpress and there is no limit to how many high quality websites you can create using any data.
 
= Main Links = 
*   <a href="http://www.webtechglobal.co.uk/csv-2-post/">Plugins Portal</a>
*   <a href="http://forum.webtechglobal.co.uk/viewforum.php?f=8">Plugins Forum</a>
*   <a href="https://www.facebook.com/csv2post">Plugins Facebook</a>
*   <a href="http://www.twitter.com/CSV2POST">Plugins Twitter</a>

= Why CSV 2 POST? = 

You obviously have a .csv file and you would like to make the contents public by creating hundreds of posts. Using CSV 2 POST
is the right choice because it offers everything most users need and is being updating frequently. My free edition will allow you to
do the follow things...

1. Create posts, pages and custom post types.
1. Update posts
1. Merge multiple .csv files
1. Functionality exists to change .csv file path during project
1. Create hierarchical categories.
1. Map category terms in data to exisiting categories
1. Import custom field meta.
1. Free support from WebTechGlobal.
1. Design your content using WYSIWYG editor.
1. Import pre-made tags.
1. Import images to Wordpress media gallery.
1. Customize post titles.
1. Manage .csv files as long term data sources.
1. Adopt existing posts.
1. Premium upgrade option when your site needs it.
1. Generate tags using any text data.
1. YouTube video tutorials linked from specific forms for faster training.
1. Works with most .csv files.
1. Imports data to custom table.
1. Create image attachments.
1. WordPress styled interface.
1. Sandbox design for easy upgrading.
1. No advertising.
1. Help text for every feature.              
1. Log system to trace staff or even clients steps great if something goes wrong.
1. More updates planned.
1. Dedicated developer on-hand most days.        
 
== Installation ==

1. You can place the csv-2-post folder in the plugins directory using FTP
1. You can also upload the plugin using Wordpress plugin screen (wp-admin/plugin-install.php)
1. If your Wordpress installation is on a path that includes "csv2post" it will trigger debugging to activate. This is meant for localhost development and can be disabled.
1. Your CSV file should be uploaded using FTP or Wordpress itself. Submit the path to CSV 2 POST, CSV 2 POST does not handle the upload. I have left this independent because there is security to consider for a lot of .csv files and the user should decide where best to store the file.
1. Please ensure wherever your .csv file is stored that Wordpress has permission to access the folder and file. Permissions can be changed in your hosting control panel for a directory. Developer software such as PhpED also allows it.

== Frequently Asked Questions ==

= Can I import CommissionJunction affiliate feeds? =
Firstly let me be clear that CSV 2 POST works with .csv files only. WebTechGlobal will be releasing other types of importers in time.
CSV files downloaded from C.J. affiliate network work great with this data importer plugin.

= Is there a limit to the number of posts I can create? =
No there are no limits anywhere. Let me know a plugin that has a limit for no reason other than generating premium sales and I'll
go to its page and rate it 1 star! 

= Will CSV 2 POST help me with SEO? = 
Yes CSV 2 POST includes features that makes good SEO easier to achieve. Version 8 of the free edition now allows unlimited number of
custom fields which can have very unique values designed using the WYSIWYG editor. It works in the same way as post title and post content.
Multiple columns of data can be inserted to create unique strings of text or even entire paragraphs.

= Why does the free editon have help text that only applies to premium edition? =
This is slowly being cleaned up. Some text is left in because it explains thing that helps users to understand how Wordpress works. Even
if it is based on a premium feature I hope it still helps someone. I welcome any requests to remove further mentions of a paid edition at
anytime. 

= Why are most videos based on the premium editions interface? =
Well as you can imaging creating and editing videos is time consuming. As features change videos need re-made so it is a constant job.
Most videos will cover all features in the free edition even if it takes a little longer because it has to cover options or procedures
only in the paid edition. However I'm more than happy to create YouTube tutorials on request.

= When was CSV 2 POST released? =
The project started in 2009 and was quickly backed by large businesses including Ryanair Ltd. I created the plugin while technically still at University so
it didn't take long for a re-development to happen. I found myself re-developing it again in 2014 with the aim of making more use of the Wordpress core. Version
8.0.0 should be the last big update of this free plugin which has been designed based on years of feedback. The premium will continue to expand.

= Is CSV 2 POST just like any-other .csv file importer for Wordpress? =

Innovation went into CSV 2 POST year one

= Is CSV 2 POST better than any other .csv file importer on Wordpress? =

If I said CSV 2 POST is "better" than any plugin of its kind on Wordpress it would simply be my opinion and a bias one at that. 
So lets be realistic and honest. You can bet most data importers for Wordpress are designed to do all the 
common and usual stuff. So I designed something different that is worth trying and supporting even if just a quick Tweet.

= What makes CSV 2 POST different from other importers? =

Possible better support as most free plugins lack support, sandbox style interface making it easy to customize, 
Wordpress styles used on the admin interface making it a better choice for developers to install in their clients blogs,
more video and test tutorials, less pushy sales tactics for our premium edition on both the free UI and the plugins 
portal, closer to client treatment than customer treatment even when coming to me for help as a free user.  

== Screenshots ==

1. Manage Multiple Projects.
2. Simple Import Statistics.
3. Category Data Selection.
4. Custom Fields With Templates.
5. Standard Post Settings.
6. Generate Tags.
7. Custom Publish Dates.
8. Content Templates.

== Languages ==

Translators needed.

== Upgrade Notice ==

Do not update without backing up your entire site both files and data. The nature of this plugin requires great care.

== Changelog == 
= 8.0.33 =
* From The Developer
    * The beta area has been updated, small improvements are made there before being applied to the rest of the plugin
* Fixes
    * unexpected output during activation caused by extending class sharing same function name
    * dbDelta() problems fixed with changes to queries                 
* Feature Changes
    * Data Source page is now used first, then Projects and changes to the forms on both pages help to creat a more logical flow
    * New capabilities system allows individual boxes/forms to be restricted
    * General Settings moved to the main page, sorry this was left in Projects when the new page system was applied in the last update 
    * Security improvements: input validation system helps to prevent users editing the source of forms by registering hidden inputs and their values
    * Data sources directory plays a bigger part and a new Re-Check Sources Directory form has been added for manually switching to new files without having to enter a path
    * URL file import to an existing data sources directory added
* Technical Notes   
    * Changed theconfig column from longtext to text
    * New filesarray column in c2psources table for storing multiple file names, partly as a history, can be used to specify some files out of many and is used to continue to manage multiple files                                              
    * More work done to rely on PHP classes, less global variables and better use of objects
    * Some redundant code removed  
    * $_POST and $_GET processing security moved to C2P_Requests() class
    * c2pprocess change to csv2postaction
    * New column added to c2psources table "name" for users to name their data source
    * New column added to c2psources table "directory" for multi-file treatment in a single datasource, the "path" column value can change to any file in the directory
* Known Issues
    * Data Table view is not suitable as tables are too wide, column titles cannot be read
    
= 8.0.32 =
* From The Developer
    * Report a bug in the free edition by reporting it on the WebTechGlobal Forum to get a 20% discount on the premium edition
* Fixes
    * Problem with post status fixed                 
* Feature Changes
    * Boxes are now proper WP postboxes which can be: moved, hidden, closed
    * Every view is now a registered Wordpress page
    * More screens added for various purposes
    * Screen Options available for every page
    * Log screen custom search removed to make the log screen simple and look better
    * Post updating now possible
    * Can now re-apply categories should settings or category terms in data be changed
    * Beta Testing area added, submit your own code to me for adding to testing 
* Technical Notes                                                 
    * Improved coding standards in every file
    * Class design improved, more to do 
* Known Issues
    * Data Table view is not suitable as tables are too wide, column titles cannot be read

== Plugin Author == 

This Readme file was created by Ryan Bayne