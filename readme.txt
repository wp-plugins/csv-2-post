=== Plugin Name ===
Contributors: WebTechGlobal
Donate link: http://www.webtechglobal.co.uk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: CSV 2 POST, csv2post,dataimport,importer,.csv,data,autoblogger,autoblogging,wpcsvimporter
Requires at least: 3.8.0
Tested up to: 4.0.0
Stable tag: trunk

Adaptable data import plugin for professionals. Pro edition used by Ryanair Ltd, Trevithick Society and many more.

== Description ==

Lets turn data into websites! CSV 2 POST for Wordpress can import any .csv file (properly formatted) then autoblog the data into hundreds or even thousands of well designed WP posts. My CSV importer plugin creates custom fields, categories and meta. If your new to Wordpress those are some of the elements that make up a web page in WP. CSV 2 POST is the first plugin to import data to a custom database table allowing the data to be prepared and other more advanced steps during the autoblogging procedure. Combine that with the power of Wordpress and there is no limit to how many high quality websites you can create using any data.
 
= Main Links = 
*   <a href="http://www.webtechglobal.co.uk/csv-2-post/" title="CSV 2 POST Website">Plugins Portal</a>
*   <a href="http://forum.webtechglobal.co.uk/viewforum.php?f=8" title="CSV 2 POST Forum">Plugins Forum</a>
*   <a href="https://www.facebook.com/csv2post" title="CSV 2 POST Facebook Page">Plugins Facebook</a>
*   <a href="http://www.twitter.com/CSV2POST" title="CSV 2 POST Twitter Tweets">Plugins Twitter</a>
*   <a href="http://www.webtechglobal.co.uk/csv-2-post-demo/" title="CSV 2 POST Premium Software and Services Demo">Pro Edition Demo</a>

= Why CSV 2 POST? = 

You have a .csv file and you would like to see the contents turned into hundreds of posts. CSV 2 POST can do that for you. It will
also help you manage your posts long after they are created. My Wordpress data importer inserts your .csv file contents to
a custom database table first. CSV 2 POST was the first plugin to do this and it surprises many but there are many advantages
to this approach i.e. integration with other software, sharing the table (raw data) and not the data in WP tables which the
Wordpress core will change in many ways. Professionals need to keep an original, businesses need to do things in smaller steps
and always have a backup. CSV 2 POST does that and by doing so avoids major mistakes i.e. the wrong rows in .csv file being applied
to the wrong posts during updating. The pro edition of CSV 2 POST takes things even further and when donations come in I move
premium features into the free edition to be fair to the Wordpress community.                                     

1. No autoblogging limits at all
1. Create posts, pages and custom post types
1. Systematic post updating or do it all at once
1. Text-spinning to improve SEO
1. Merge multiple .csv files
1. Functionality exists to change .csv file path during project
1. Create hierarchical categories
1. Map category terms in data to exisiting categories
1. Import custom field meta
1. Free support from WebTechGlobal
1. Design your content using WYSIWYG editor
1. Import pre-made tags
1. Import images to Wordpress media gallery
1. Customize post titles
1. Manage .csv files as long term data sources
1. Adopt existing posts
1. Premium upgrade option when your site needs it
1. Generate tags using any text data
1. Works with most .csv files
1. Imports data to custom table
1. Create image attachments
1. WordPress styled interface
1. Sandbox design for easy upgrading
1. No advertising
1. Help text for every feature              
1. Log system to trace staff or even clients steps great if something goes wrong
1. More updates planned
1. Free support
1. More updates coming 
1. Services available    
 
== Installation ==

1. You can place the csv-2-post folder in the plugins directory using FTP
1. You can also upload the plugin using Wordpress plugin screen (wp-admin/plugin-install.php)
1. If your Wordpress installation is on a path that includes "csv2post" it will trigger debugging to activate. This is meant for localhost development and can be disabled.
1. Your CSV file should be uploaded using FTP or Wordpress itself. Submit the path to CSV 2 POST, CSV 2 POST does not handle the upload. I have left this independent because there is security to consider for a lot of .csv files and the user should decide where best to store the file.
1. Please ensure wherever your .csv file is stored that Wordpress has permission to access the folder and file. Permissions can be changed in your hosting control panel for a directory. Developer software such as PhpED also allows it.

== Frequently Asked Questions ==

= Can I import CommissionJunction affiliate feeds? =
Download .csv files from Commission Junction then upload them or paste a URL directly to a .csv file on any domain to import it that way.
Commission Junction and all other affiliate networks are supported. 

= Is there a limit to the number of posts I can create? =
There are no limits others than what your server will allow you to do in a single request. There are also more features
in CSV 2 POST free edition than most (possibly all) .csv importers. Things like features images and permalinks are withheld
in other free editions to encourage premium sale. I rely on people purchasing CSV 2 POST pro to either show their gratitide for
my hundreds of hours unpaid work on the project.

= Will CSV 2 POST help me with SEO? = 
Yes CSV 2 POST allows the creation of post meta (custom fields) which are used by most SEO solutions. More support can be added on
request for free. The plugin also offers text-spinning without limits and there is more planned on that.

= When was CSV 2 POST released? =
The project started in 2009 and was quickly backed by large businesses including Ryanair Ltd. I created the plugin while technically still at University so
it didn't take long for a re-development to happen. I found myself re-developing it again in 2014 with the aim of making more use of the Wordpress core. Version
8.0.0 should be the last big update of this free plugin which has been designed based on years of feedback.

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

Do not update without backing up your entire site both files and data. The nature of an import plugin requires great care.

== Changelog == 

= 8.1.35 =          
* Feature Changes
    * Automatic post updating addeded based on schedule
    * Systematic post updating now post (happens when old post is opened)
    * Unlimited manual post updating using a forum
    * Spintax (text-spinning) added
    * Multiple post design form added
    * Multiple post types can be applied dynamically
    * Better data source management (more updates coming for that)
    * Can now split data from one .csv file column into multiple database columns
    * Data Sources page renamed to Manage Data Sources
    * The table of sources has been removed from Manage Data Sources (new improved table being added)
    * New page named Data Sources List with a table of all sources (more details about sources available than the previous table)
    * New form for creating multiple data sources using a directory of .csv files, one file is made parent and it is the parent source that is linked to a project.
* Technical Notes
    * Fault relating to term_exists_in_level() when creating posts has been fixed
    * Title sample field reads "Please import data to see a sample based on your template." when user has not imported data
    * Accidental dump of post data fixed (happens when using Re-create Missing Posts form)
* Known Issues
    * Data Table view is not suitable as tables are too wide, column titles cannot be read
    * Some forms are not suitable for being in the narrow sidebar by default, probably use that bar for quick tools and small information.
    * Occasionally clicking on "CSV 2 POST" media button above WYSIWYG editor shows an overlay but the content is not centered. Found this myself and has not been reported by a user.
    
= 8.1.34 =          
* Feature Changes
    * None
* Technical Notes
    * options_array.php removed (new options class coming and will be used to improve installation)
    * Most class no longer use extend
    * tableschema_array.php now only included when required (it will soon be deleted also)
    * get_category_data_used() no longer creates new C2P_DB object
    * beginpluginupdate() function now loads
    * $c2p_installation_required removed 100%
    * Couple of bugs fixed
* Known Issues
    * Data Table view is not suitable as tables are too wide, column titles cannot be read
    * Some forms are not suitable for being in the narrow sidebar by default, probably use that bar for quick tools and small information.

= 8.1.33 =
* Feature Changes
    * Default content design no longer creates a new post or has option to do so, another form added to do that.
    * New form added with WYSIWYG editor for creating new content templates from plugin pages, has more use in the pro edition with ability to setup rules etc but it may have other uses
    * Every existing form can now be added to the dashboard as a widget, security measures available
    * New UI setting to switched between WTG styled notices and WP core styled, this setting is temporary during a transition to WP core style
    * List of ShopperPress custom field names added to the Custom Fields page
    * New form box added for changing the current active project
    * Form buttons now blue: the primary style, grey is normally for inner form buttons, often for form inputs processed using Ajax
    * Next button added to quick actions toolbar for changing the current project to the next
    * Previous button added to quick actions toolbar for changing the current active project to the previous one, as per their order in c2p_projects table
    * Flag system switch added, can now disable and hide the Flags post type, it is disabled by default and flags will not be created unless activated
    * Main page is now named the CSV 2 POST Dashboard
    * Delete datasource form added
    * Added form for creating data source using .csv file already on the server
    * Source delete form now has confirmation fields to prevent accidental deletion of sources
    * Title Template form now displays an example title based on impoted data, refreshing changes the title as it uses a random imported record
    * Help text added to most boxes, more detailed help text coming to the Help tab in future and documentation in the portal
* Technical Notes
    * Someone reported an error regarding upgrade.php which the plugin calls, yet I've never seen it happen myself, changed include to include_once so hopefully it is fixed as I could not generate the error to confirm.
    * Fix applied for a problem where imported row was not updated after being used to create a post   
    * Minor error prevented when user does not setup an ID column and the plugin attempts to gather statistics based on such a column
    * Content and Title templates were not being re-populated in forms that has been corrected
    * Can now ide tab menu using menu array when one page in use for a section (add $menu_array['eventsone']['pluginmenu'] = false;// boolean (false for single page views))
* Known Issues
    * Data Table view is not suitable as tables are too wide, column titles cannot be read
    * Some forms are not suitable for being in the narrow sidebar by default, probably use that bar for quick tools and small information.
    
= 8.1.32 =
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
    * unexpected output during activation caused by extending class sharing same function name
    * dbDelta() problems fixed with changes to queries  
* Known Issues
    * Data Table view is not suitable as tables are too wide, column titles cannot be read
    
= 8.1.31 =
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
    * Problem with post status fixed
* Known Issues
    * Data Table view is not suitable as tables are too wide, column titles cannot be read

== Plugin Author == 

Thank you for considering CSV 2 POST. I import data to Wordpress for a living. If your stuck, if you need another solution
or help with any existing data importer. Please visit forum.webtechglobal.co.uk for free help.

== Request Pro Edition Demo ==

A great way to try the pro edition of the CSV 2 POST plugin is to use a test/demo blog setup just for you. You can <a href="http://www.webtechglobal.co.uk/csv-2-post-demo/" title="CSV 2 POST Premium Software and Services Demo">request a pro demo</a> today for free. If you do decide to continue using the free edition, please consider a small donation to help support the plugins development and cover my time.

== Version Numbers and Updating ==

Explanation of versioning used by myself Ryan Bayne. The versioning scheme I use is called "Semantic Versioning 2.0.0" and more
information about it can be found at http://semver.org/ 

= Summary =

These are the rules followed to increase the CSV 2 POST plugin version number. Given a version number MAJOR.MINOR.PATCH, increment the:

MAJOR version when you make incompatible API changes,
MINOR version when you add functionality in a backwards-compatible manner, and
PATCH version when you make backwards-compatible bug fixes.
Additional labels for pre-release and build metadata are available as extensions to the MAJOR.MINOR.PATCH format.

