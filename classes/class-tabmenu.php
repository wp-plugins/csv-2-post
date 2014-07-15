<?php
/**
* Beta testing only (check if in use yet) - phasing array files into classes of their own then calling into the main class
*/
class CSV2POST_TabMenu {
    public function menu_array() {
        $menu_array = array();
        
        ######################################################
        #                                                    #
        #                        MAIN                        #
        #                                                    #
        ######################################################
        // can only have one view in main right now until WP allows pages to be hidden from showing in
        // plugin menus. This may provide benefit of bringing user to the latest news and social activity
        // main page
        $menu_array['main']['groupname'] = 'main';        
        $menu_array['main']['slug'] = 'csv2post';// home page slug set in main file
        $menu_array['main']['menu'] = 'CSV 2 POST';// plugin admin menu
        $menu_array['main']['tabmenu'] = __( 'News & Support' ,'csv2post' );// for tabbed menu
        $menu_array['main']['name'] = "main";// name of page (slug) and unique
        $menu_array['main']['title'] = 'CSV 2 POST';// title at the top of the admin page
        $menu_array['main']['parent'] = 'parent';// either "parent" or the name of the parent - used for building tab menu         
        
        ######################################################
        #                                                    #
        #                   PLUGIN UPDATE                    #
        #                                                    #
        ######################################################
        // requests user to initiate plugin update
        $menu_array['pluginupdate']['groupname'] = 'installation';        
        $menu_array['pluginupdate']['slug'] = 'csv2post_pluginupdate';// home page slug set in main file
        $menu_array['pluginupdate']['menu'] = __( 'CSV 2 POST Update Ready', 'csv2post' );// plugin admin menu
        $menu_array['pluginupdate']['tabmenu'] = __( 'Update Information' ,'csv2post' );// for tabbed menu
        $menu_array['pluginupdate']['name'] = "pluginupdate";// name of page (slug) and unique
        $menu_array['pluginupdate']['title'] = __( 'CSV 2 POST Update Ready', 'csv2post' );// title at the top of the admin page
        $menu_array['pluginupdate']['parent'] = 'parent';// either "parent" or the name of the parent - used for building tab menu 

        ######################################################
        #                                                    #
        #                    PROJECTS                        #
        #                                                    #
        ###################################################### 
        // projects  
        $menu_array['projects']['groupname'] = 'projects';
        $menu_array['projects']['slug'] = 'csv2post_projects'; 
        $menu_array['projects']['menu'] = __( '1. Projects', 'csv2post' );
        $menu_array['projects']['tabmenu'] = __( 'Projects', 'csv2post' );
        $menu_array['projects']['name'] = "projects";
        $menu_array['projects']['title'] = __( 'Projects', 'csv2post' ); 
        $menu_array['projects']['parent'] = 'parent'; 

        // datasources  
        $menu_array['datasources']['groupname'] = 'projects';
        $menu_array['datasources']['slug'] = 'csv2post_datasources'; 
        $menu_array['datasources']['menu'] = __( 'Data Sources', 'csv2post' );
        $menu_array['datasources']['tabmenu'] = __( 'Data Sources', 'csv2post' );
        $menu_array['datasources']['name'] = "datasources";
        $menu_array['datasources']['title'] = __( 'Data Sources', 'csv2post' ); 
        $menu_array['datasources']['parent'] = 'projects';         
        
        // datasources  
        $menu_array['generalsettings']['groupname'] = 'projects';
        $menu_array['generalsettings']['slug'] = 'csv2post_generalsettings'; 
        $menu_array['generalsettings']['menu'] = __( 'General Settings', 'csv2post' );
        $menu_array['generalsettings']['tabmenu'] = __( 'General Settings', 'csv2post' );        
        $menu_array['generalsettings']['name'] = "generalsettings";
        $menu_array['generalsettings']['title'] = __( 'General Settings', 'csv2post' ); 
        $menu_array['generalsettings']['parent'] = 'projects';                

        ######################################################
        #                                                    #
        #                      RULES                         #
        #                                                    #
        ###################################################### 
        // rules  
        $menu_array['rules']['groupname'] = 'import';
        $menu_array['rules']['slug'] = 'csv2post_rules'; 
        $menu_array['rules']['menu'] = __( '2. Data Import', 'csv2post' );
        $menu_array['rules']['tabmenu'] = __( 'Rules', 'csv2post' );
        $menu_array['rules']['name'] = "rules";
        $menu_array['rules']['title'] = __( 'Data  Rules', 'csv2post' ); 
        $menu_array['rules']['parent'] = 'parent';             

        // import  
        $menu_array['import']['groupname'] = 'import';
        $menu_array['import']['slug'] = 'csv2post_import'; 
        $menu_array['import']['menu'] = __( 'Data Import', 'csv2post' );
        $menu_array['import']['tabmenu'] = __( 'Data Import', 'csv2post' );
        $menu_array['import']['name'] = "import";
        $menu_array['import']['title'] = __( 'Data Import', 'csv2post' ); 
        $menu_array['import']['parent'] = 'rules';             

        // sources  
        $menu_array['sources']['groupname'] = 'import';
        $menu_array['sources']['slug'] = 'csv2post_sources'; 
        $menu_array['sources']['menu'] = __( 'Sources', 'csv2post' );
        $menu_array['sources']['tabmenu'] = __( 'Sources', 'csv2post' );
        $menu_array['sources']['name'] = "sources";
        $menu_array['sources']['title'] = __( 'Sources', 'csv2post' ); 
        $menu_array['sources']['parent'] = 'rules';        
        
        // table  
        $menu_array['table']['groupname'] = 'import';
        $menu_array['table']['slug'] = 'csv2post_table'; 
        $menu_array['table']['menu'] = __( 'View Table', 'csv2post' );
        $menu_array['table']['tabmenu'] = __( 'View Data Table', 'csv2post' );
        $menu_array['table']['name'] = "table";
        $menu_array['table']['title'] = __( 'View Data Table', 'csv2post' ); 
        $menu_array['table']['parent'] = 'rules';

        ######################################################
        #                                                    #
        #                   CATEGORIES                       #
        #                                                    #
        ######################################################
        
        // columns  
        $menu_array['columns']['groupname'] = 'categories';
        $menu_array['columns']['slug'] = 'csv2post_columns'; 
        $menu_array['columns']['menu'] = __( '3. Categories', 'csv2post' );
        $menu_array['columns']['tabmenu'] = __( 'Columns', 'csv2post' );
        $menu_array['columns']['name'] = "columns";
        $menu_array['columns']['title'] = __( 'Columns', 'csv2post' ); 
        $menu_array['columns']['parent'] = 'parent';         
        
        // categorycreation  
        $menu_array['categorycreation']['groupname'] = 'categories';
        $menu_array['categorycreation']['slug'] = 'csv2post_categorycreation'; 
        $menu_array['categorycreation']['menu'] = __( 'Create Categories', 'csv2post' );
        $menu_array['categorycreation']['tabmenu'] = __( 'Creation', 'csv2post' );
        $menu_array['categorycreation']['name'] = "categorycreation";
        $menu_array['categorycreation']['title'] = __( 'Create Categories', 'csv2post' ); 
        $menu_array['categorycreation']['parent'] = 'columns';                  

        ######################################################
        #                                                    #
        #                     DESIGN                         #
        #                                                    #
        ######################################################
        
        // postsettings  
        $menu_array['postsettings']['groupname'] = 'design';
        $menu_array['postsettings']['slug'] = 'csv2post_postsettings'; 
        $menu_array['postsettings']['menu'] = __( '4. Design', 'csv2post' );
        $menu_array['postsettings']['tabmenu'] = __( 'Post Settings', 'csv2post' );
        $menu_array['postsettings']['name'] = "postsettings";
        $menu_array['postsettings']['title'] = __( 'Post Settings', 'csv2post' ); 
        $menu_array['postsettings']['parent'] = 'parent';         
        
        // content  
        $menu_array['content']['groupname'] = 'design';
        $menu_array['content']['slug'] = 'csv2post_content'; 
        $menu_array['content']['menu'] = __( 'Content', 'csv2post' );
        $menu_array['content']['tabmenu'] = __( 'Content', 'csv2post' );
        $menu_array['content']['name'] = "content";
        $menu_array['content']['title'] = __( 'Content Templates', 'csv2post' ); 
        $menu_array['content']['parent'] = 'postsettings'; 
               
        // dates  
        $menu_array['dates']['groupname'] = 'design';
        $menu_array['dates']['slug'] = 'csv2post_dates'; 
        $menu_array['dates']['menu'] = __( 'Dates', 'csv2post' );
        $menu_array['dates']['tabmenu'] = __( 'Dates', 'csv2post' );
        $menu_array['dates']['name'] = "dates";
        $menu_array['dates']['title'] = __( 'Dates', 'csv2post' ); 
        $menu_array['dates']['parent'] = 'postsettings';     
        
        // posttypes  
        $menu_array['posttypes']['groupname'] = 'design';
        $menu_array['posttypes']['slug'] = 'csv2post_posttypes'; 
        $menu_array['posttypes']['menu'] = __( 'Post Types', 'csv2post' );
        $menu_array['posttypes']['tabmenu'] = __( 'Post Types', 'csv2post' );
        $menu_array['posttypes']['name'] = "posttypes";
        $menu_array['posttypes']['title'] = __( 'Post Types', 'csv2post' ); 
        $menu_array['posttypes']['parent'] = 'postsettings';
                                                                                                
        ######################################################
        #                                                    #
        #                        META                        #
        #                                                    #
        ######################################################
        // customfields
        $menu_array['customfields']['groupname'] = 'meta'; 
        $menu_array['customfields']['slug'] = 'csv2post_customfields';// home page slug set in main file
        $menu_array['customfields']['menu'] = '5. Meta';// main menu title
        $menu_array['customfields']['tabmenu'] = 'Custom Fields';// main menu title        
        $menu_array['customfields']['name'] = "customfields";// name of page (slug) and unique
        $menu_array['customfields']['title'] = 'Custom Fields';// page title seen once page is opened
        $menu_array['customfields']['parent'] = 'parent';// either "parent" or the name of the parent - used for building tab menu    
        
        // taxonomies
        $menu_array['taxonomies']['groupname'] = 'meta';
        $menu_array['taxonomies']['slug'] = 'csv2post_taxonomies';// home page slug set in main file
        $menu_array['taxonomies']['menu'] = __( 'Taxonomies', 'csv2post' );// main menu title
        $menu_array['taxonomies']['tabmenu'] = __( 'Taxonomies', 'csv2post' );// main menu title
        $menu_array['taxonomies']['name'] = "taxonomies";// name of page (slug) and unique
        $menu_array['taxonomies']['title'] = __( 'Taxonomies', 'csv2post' );// page title seen once page is opened 
        $menu_array['taxonomies']['parent'] = 'customfields';// either "parent" or the name of the parent - used for building tab menu   
        
        ######################################################
        #                                                    #
        #                   POST CREATION                    #
        #                                                    #
        ######################################################
        // tools
        $menu_array['tools']['groupname'] = 'postcreation'; 
        $menu_array['tools']['slug'] = 'csv2post_tools';// home page slug set in main file
        $menu_array['tools']['menu'] = '6. Post Creation';// main menu title
        $menu_array['tools']['tabmenu'] = 'Tools';// main menu title        
        $menu_array['tools']['name'] = "tools";// name of page (slug) and unique
        $menu_array['tools']['title'] = 'Post Creation Tools';// page title seen once page is opened
        $menu_array['tools']['parent'] = 'parent';// either "parent" or the name of the parent - used for building tab menu    
        
        // lastpost
        $menu_array['lastpost']['groupname'] = 'postcreation';
        $menu_array['lastpost']['slug'] = 'csv2post_lastpost';// home page slug set in main file
        $menu_array['lastpost']['menu'] = __( 'Last Post', 'csv2post' );// main menu title
        $menu_array['lastpost']['tabmenu'] = __( 'Last Post', 'csv2post' );// main menu title
        $menu_array['lastpost']['name'] = "lastpost";// name of page (slug) and unique
        $menu_array['lastpost']['title'] = __( 'Last Post Created', 'csv2post' );// page title seen once page is opened 
        $menu_array['lastpost']['parent'] = 'tools';// either "parent" or the name of the parent - used for building tab menu   

        ######################################################
        #                                                    #
        #                   BETA TESTING                     #
        #                                                    #
        ######################################################
        // test view one
        $menu_array['betatest1']['groupname'] = 'betatesting'; 
        $menu_array['betatest1']['slug'] = 'csv2post_betatest1';// home page slug set in main file
        $menu_array['betatest1']['menu'] = 'Beta Testing';// main menu title
        $menu_array['betatest1']['tabmenu'] = 'Test 1: New Categories Class';// main menu title        
        $menu_array['betatest1']['name'] = "betatest1";// name of page (slug) and unique
        $menu_array['betatest1']['title'] = 'Beta Testing 1: Categories';// page title seen once page is opened
        $menu_array['betatest1']['parent'] = 'parent';// either "parent" or the name of the parent - used for building tab menu    
        
        // test view two
        $menu_array['betatest2']['groupname'] = 'betatesting'; 
        $menu_array['betatest2']['slug'] = 'csv2post_betatest2';// home page slug set in main file
        $menu_array['betatest2']['menu'] = 'Beta Testing';// main menu title
        $menu_array['betatest2']['tabmenu'] = 'Test 2: UI (postboxes, pointers, support icons)';// main menu title        
        $menu_array['betatest2']['name'] = "betatest1";// name of page (slug) and unique
        $menu_array['betatest2']['title'] = 'Beta Testing 1: Post-boxes UI';// page title seen once page is opened
        $menu_array['betatest2']['parent'] = 'betatest1';// either "parent" or the name of the parent - used for building tab menu    
                                   
        return $menu_array;
    }
} 
?>
