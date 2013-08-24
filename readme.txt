=== Plugin Name ===
Contributors: WebTechGlobal
Donate link: http://www.webtechglobal.co.uk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: importer,datafeed,datafeeds,csvimport,autoblog,autoblogging,autoblogger,data,dataengine,csv2post
Requires at least: 3.5.0
Tested up to: 3.6.0
Stable tag: 7.0.4

CSV 2 POST Data Engine

== Description ==

Do you need to create hundreds, maybe thousands of pages within an hour?

CSV 2 POST exists to auto-blog...

Not just posts, maybe you need pages or a custom post type and with featured images?

CSV 2 POST can handle it...

Do you also want your posts to have all the correct custom fields (meta data) for your theme, any theme?

CSV 2 POST loves all themes...

Are you going to need those post put into correct categories, maybe create the categories automatically?

CSV 2 POST likes to keep blogs organized...

Have you considered some text spinning, URL cloaking and scheduling to create a more natural blog for Google?

CSV 2 POST premium is on stand by if your needs are far above average...
    
    
= About Our Plugin =
CSV importer plugin for Wordpress. CSV 2 POST Data Engine has been designed for businesses and developers working with a lot 
of data. Our WP plugin is a web tool for auto-blogging and managing imported data professionally. CSV 2 POST offers abilities
no other plugin offers and has offered some features for the first time before any other plugin did. This includes importing
two or more CSV files in one project and using data from each file to build posts. The plugin is provided by WebTechGlobal
who continue to develop and support it. So by installing CSV 2 POST today and contacting us we gaurantee you'll make progress. 

= Support =
The plugin is supported by a dedicated website at [www.webtechglobal.co.uk](http://www.webtechglobal.co.uk/). Most online support content is free. We
provide a higher level of priority to premium users. We recommend free users use the plugins forum on Wordpress.org and paid users email us.

= Our Mission =
It is very important to us that we deliver a useful free plugin for the Wordpress community to use and not
deliver software that behaves like a trial in order to advertise our paid edition. To ensure we do not make that
mistake as we have done before, we encourage all potential customers who email us to try the free edition, unless
thier project is unique and requires changes to the plugin. Development for CSV 2 POST will continue past 2014 and 
the plugin core will be shared with other plugins which will push CSV 2 POST further than other importers.

== Installation ==

Initial upload and activation as guided by Wordpress.org standard plugin installation.

1. Delete existing `csv-2-post` folder in `/wp-content/plugins/` (or delete plugin on Wordpress Plugins screen)
1. Upload the `csv-2-post` folder to the `/wp-content/plugins/` directory (or upload using Wordpress Plugins screen)
1. Activate the CSV 2 POST plugin through the 'Plugins' menu in WordPress
1. Configure the plugin by going to the Settings screen
1. Always backup your database before mass creating posts
1. Always backup your database before updating the plugin
1. You may upload CSV files using FTP to the /wp-content/wpcsvimportercontent/ folder to use them with CSV post

== Frequently Asked Questions ==

= Are custom fields supported? =
Yes

= Are the new Wordpress 3.6 Post Formats supported? =
Yes

= Can I create custom post types, not just post or page? =
Yes

= Can I create categories? =
Yes

= Is there a limit to the number of posts I can create? =
No

= Does the plugin have free support? =
Yes

= Is the plugin compatible with ShopperPress? =
Yes

= Is the plugin compatible with ClassiPress? =
Yes

= Does this plugin work with SEO by Yoast plugin? =
Yes it does, actually in a technical way all SEO plugins work with CSV 2 POST however
the most popular get some extra support to make it easier for users. That includes All In One SEO 
and we will add the extra support for any other plugins on request.

= Is CSV 2 POST well supported? =
Yes, the plugin will be supported for many years and has a dedicated website.

= Will you make changes to the plugin to suit my needs? =
We note every request on a "To Do" list and we intend to keep working through the list
every week. If your needs are more urgent we can be hired. It is mainly Ryan Bayne who 
handles the more complex requests. However sometimes we can add a new feature to the free
edition quickly so please push for the free option first.

= Will development continue for this plugin? =
Yes. We hope to be adding new features until 2015 and updating it for compatability with Wordpress for many years.

== Screenshots ==

1. Start by creating a Data Import Job and import your CSV files data to a new database table created by CSV 2 POST. We have the potential here to import to existing tables and more.
2. Create templates for placing your data into post content. Templates are stored under a custom post type so many templates can be created. This gives us the potential to apply different designs based on specific conditions.
3. You can even create title templates, so you do not need pre-made titles, just suitable columns of data to create a title string from. These templates are stored under a custom post type.
4. Set the type of posts you want to create. Many plugins and themes will require you to create a different type of post, something CSV 2 POST will do easily.
5. This screenshot shows "Basic Custom Field Rules", paid edition has advanced features but most users require the basic form which allows you to create post meta with any data.
6. You can use up to 3 columns of data to create 3 levels of categories.

== Changelog == 
= 7.0.4 =
* From The Developers
    * Released 24th August 2013
    * We decided to shutdown www.webtechglobal.co.uk and not to launch individual sites per premium plugin in future. All products and services, including free support. Can be sought at www.webtechglobal.co.uk in future.
    * Work on CSV 2 POST is scheduled from 24th August till 30th and a new version on 31st. 
* Fixes     
    * Empty field does not cause error in function which checks if expected value is monitory 
* Feature Changes
    * Removed example .csv file. Many users are assuming that their file headers must match it and that this is why the example is giving. CSV 2 POST accepts any headers.
* Technical Notes
    * Mass replace done on www.csv2post.com with www.webtechglobal.co.uk, over 100 URL to be examined for precise destination and decision made on its removal or creation of pages on WebTechGlobal website.
          
= 7.0.3 =
* From The Developers
    * Released 3rd August 2013
* Fixes     
    * Tab navigation changed for WP 3.6
* Feature Changes
    * Diagnostic checks will no longer be run during form submissions or other processing trigger by CSV 2 POST
    * Author menu replaced with a text field for entering a user ID
    * News screen removed as it only displayed RSS feeds from Google Feedburner which Google no longer supports
    * Menu array is now loaded from file, by default it was installed and loaded from options table
    * jQuery UI styling removed, related files deleted and styling options also removed
* Technical Notes
    * csv2post_diagnostics_constant_adminside() works but argument to check $_POST has been extended to use !$_POST should $_POST be set but array contain nothing
    
= 7.0.2 =
* From The Developers
    * Released 25th July 2013
* Fixes     
    * If post type is not saved it triggered a problem in category creation function because it could not establish the hierarchical taxonomy that was meant to be applied
    * Plugin query to confirm if a table exists or not was failing due to incorrect quotes in query
* Feature Changes
    * No longer creates data import job even when user fails to enter required values
    * Post adoption improved
    * Log table is now limited to storing 2 days of log entries only
    * Now prevents .csv files with spaces or hyphens in name, this is temporary while we put a system in place for managing data sources
* Technical Notes
    * csv2post_database_table_exist() improved
    
= 7.0.1 =
* From The Developers
    * Released 30th June 2013 
* Fixes     
    * Quick start title fix for files with uppercase
    * Featured image in Quick Start improved
    * Tags in Quick Start improved 
* Feature Changes
    * Removed some links pointing to the premium edition
    * Dates panel removed (was never meant to be there)
* Technical Notes
    * Schedule system setting now within the main admin settings array and schedule array file deleted
    
= 7.0.0 =
* From The Developers
    * Released 26th June 2013
    * If installing via FTP please delete the existing plugin first, enjoy :) 
* Fixes     
    * None
* Feature Changes
    * Support buttons made smaller by using Wordpress styles instead of jQuery UI theme styles
    * New diagnostic system started, the old one was a group of splintered functions, wtgcore_wp_diagostics.php created for the new approach
    * csv2post_notice() now checks if user is adminstrator straight away, this is a security measure
* Technical Notes
    * None
