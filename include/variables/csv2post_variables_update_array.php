<?php
##############################################################
#                                                            #
#                      PLUGINS UPDATE ARRAY                  #
#                                                            #
##############################################################
# The values in this array can be used to create a summary
# of changes to be made during the plugin update process 
$csv2post_upgrade_array = array();
######################
#   Version 6.9.7    # 
######################
$v = '6.9.7';
$csv2post_upgrade_array[$v]['warning'] = 'Please backup your Wordpress files and database before updating.';
// update 0 
$csv2post_upgrade_array[$v]['changes'][0]['function'] = 'csv2post_INSTALL_tabmenu_settings';// the method we will process the update: function
$csv2post_upgrade_array[$v]['changes'][0]['title'] = 'Plugin Menu Settings';// short name to refer to what is being upgraded
$csv2post_upgrade_array[$v]['changes'][0]['description'] = 'There have been changes in the plugins menu settings array and it must be reset in the Worpdress options table for you to see the plugins screens properly.';    
$csv2post_upgrade_array[$v]['changes'][0]['type'] = 'optionrecord';// optionrecord, replacefile, addfile, deletefile, modifyfile, creatable, altertable, deletetable, editrecord, addrecord, deleterecord
$csv2post_upgrade_array[$v]['changes'][0]['name'] = 'csv2post_tabmenu';// specific name of file or the key for option record
$csv2post_upgrade_array[$v]['changes'][0]['loc'] = 'wp_options';// file path or database table name
$csv2post_upgrade_array[$v]['changes'][0]['backup'] = false;// does the existing record,file or table need backed up?
$csv2post_upgrade_array[$v]['changes'][0]['element'] = 'record';// file,record,table    
$csv2post_upgrade_array[$v]['changes'][0]['method'] = 'function';// the method we will process the update: function
$csv2post_upgrade_array[$v]['changes'][0]['package'] = 'free';// free,paid - use free to display and apply for all installations else hide a change from free users by using paid
######################
#   Version 6.9.6    # 
######################
$v = '6.9.6';
$csv2post_upgrade_array[$v]['warning'] = 'Please backup your Wordpress files and database before updating.';
// update 0 
$csv2post_upgrade_array[$v]['changes'][0]['function'] = 'csv2post_INSTALL_tabmenu_settings';// the method we will process the update: function
$csv2post_upgrade_array[$v]['changes'][0]['title'] = 'Plugin Menu Settings';// short name to refer to what is being upgraded
$csv2post_upgrade_array[$v]['changes'][0]['description'] = 'There have been changes in the plugins menu settings array and it must be reset in the Worpdress options table for you to see the plugins screens properly.';    
$csv2post_upgrade_array[$v]['changes'][0]['type'] = 'optionrecord';// optionrecord, replacefile, addfile, deletefile, modifyfile, creatable, altertable, deletetable, editrecord, addrecord, deleterecord
$csv2post_upgrade_array[$v]['changes'][0]['name'] = 'csv2post_tabmenu';// specific name of file or the key for option record
$csv2post_upgrade_array[$v]['changes'][0]['loc'] = 'wp_options';// file path or database table name
$csv2post_upgrade_array[$v]['changes'][0]['backup'] = false;// does the existing record,file or table need backed up?
$csv2post_upgrade_array[$v]['changes'][0]['element'] = 'record';// file,record,table    
$csv2post_upgrade_array[$v]['changes'][0]['method'] = 'function';// the method we will process the update: function
$csv2post_upgrade_array[$v]['changes'][0]['package'] = 'free';// free,paid - use free to display and apply for all installations else hide a change from free users by using paid
/*  MOVE OLD UPDATES TO HERE TO KEEP UPDATE HISTORY
######################
#   Version 6.8.8    #  Added 27th February 2013
######################
$csv2post_upgrade_array['6.8.8']['warning'] = 'No special warning.';
// change 0 
$csv2post_upgrade_array['6.8.8']['changes'][0]['function'] = 'csv2post_INSTALL_tabmenu_settings';// the method we will process the update: function
$csv2post_upgrade_array['6.8.8']['changes'][0]['title'] = 'Plugin Menu Settings';// short name to refer to what is being upgraded
$csv2post_upgrade_array['6.8.8']['changes'][0]['description'] = 'Initializes new theme related setting';    
$csv2post_upgrade_array['6.8.8']['changes'][0]['type'] = 'optionrecord';// optionrecord, replacefile, addfile, deletefile, modifyfile, creatable, altertable, deletetable, editrecord, addrecord, deleterecord
$csv2post_upgrade_array['6.8.8']['changes'][0]['name'] = 'csv2post_adminset';// specific name of file or the key for option record
$csv2post_upgrade_array['6.8.8']['changes'][0]['loc'] = 'wp_options';// file path or database table name
$csv2post_upgrade_array['6.8.8']['changes'][0]['backup'] = false;// does the existing record,file or table need backed up?
$csv2post_upgrade_array['6.8.8']['changes'][0]['element'] = 'record';// file,record,table    
$csv2post_upgrade_array['6.8.8']['changes'][0]['method'] = 'function';// the method we will process the update: function
$csv2post_upgrade_array['6.8.8']['changes'][0]['package'] = 'free';// free,paid - use free to display and apply for all installations else hide a change from free users by using paid
######################
#   Version 6.8.6    #  Added 27th February 2013
######################
$csv2post_upgrade_array['6.8.6']['warning'] = 'No special warning.';
// change 0 
$csv2post_upgrade_array['6.8.6']['changes'][0]['function'] = 'csv2post_INSTALL_tabmenu_settings';// the method we will process the update: function
$csv2post_upgrade_array['6.8.6']['changes'][0]['title'] = 'Plugin Menu Settings';// short name to refer to what is being upgraded
$csv2post_upgrade_array['6.8.6']['changes'][0]['description'] = 'The plugins tab menu is created using an array of settings. The array has been changed in a way that requires a new installation of the entire array. This will reverse any menu configuration you have done i.e. if you hid selected screens they may now appear again. Sorry for the inconvenience';    
$csv2post_upgrade_array['6.8.6']['changes'][0]['type'] = 'optionrecord';// optionrecord, replacefile, addfile, deletefile, modifyfile, creatable, altertable, deletetable, editrecord, addrecord, deleterecord
$csv2post_upgrade_array['6.8.6']['changes'][0]['name'] = 'csv2post_tabmenu';// specific name of file or the key for option record
$csv2post_upgrade_array['6.8.6']['changes'][0]['loc'] = 'wp_options';// file path or database table name
$csv2post_upgrade_array['6.8.6']['changes'][0]['backup'] = false;// does the existing record,file or table need backed up?
$csv2post_upgrade_array['6.8.6']['changes'][0]['element'] = 'record';// file,record,table    
$csv2post_upgrade_array['6.8.6']['changes'][0]['method'] = 'function';// the method we will process the update: function
$csv2post_upgrade_array['6.8.6']['changes'][0]['package'] = 'free';// free,paid - use free to display and apply for all installations else hide a change from free users by using paid
######################
#   Version 6.8.4    #  Added around 1st February 2013
######################
$csv2post_upgrade_array['6.8.4']['warning'] = 'No special warning.';
// change 0
$csv2post_upgrade_array['6.8.4']['changes'][0]['package'] = 'free';// free,paid - use free to display and apply for all installations else hide a change from free users by using paid   
$csv2post_upgrade_array['6.8.4']['changes'][0]['type'] = 'optionrecord';// optionrecord, replacefile, addfile, deletefile, modifyfile, creatable, altertable, deletetable, editrecord, addrecord, deleterecord
$csv2post_upgrade_array['6.8.4']['changes'][0]['name'] = 'csv2post_tabmenu';// specific name of file or the key for option record
$csv2post_upgrade_array['6.8.4']['changes'][0]['loc'] = 'wp_options';// file path or database table name
$csv2post_upgrade_array['6.8.4']['changes'][0]['backup'] = false;// does the existing record,file or table need backed up?
$csv2post_upgrade_array['6.8.4']['changes'][0]['element'] = 'record';// file,record,table    
$csv2post_upgrade_array['6.8.4']['changes'][0]['method'] = 'function';// the method we will process the update: function
$csv2post_upgrade_array['6.8.4']['changes'][0]['function'] = 'csv2post_INSTALL_tabmenu_settings';// the method we will process the update: function
$csv2post_upgrade_array['6.8.4']['changes'][0]['title'] = 'Plugin Menu Settings';// short name to refer to what is being upgraded
$csv2post_upgrade_array['6.8.4']['changes'][0]['description'] = 'The plugins tab menu is created using an array of settings. The array has been changed in a way that requires a new installation of the entire array. This will reverse any menu configuration you have done i.e. if you hid selected screens they may now appear again. Sorry for the inconvenience'; 
######################
#   Version 6.7.4    #  Added around 1st January 2013
######################
$csv2post_upgrade_array['6.7.4']['warning'] = 'This version delivers this new installation related system for updating the plugins installation status so that it suits changes in the latest version. Please do not rely on it for this plugin update. Please backup your database if your blog has CSV 2 POST projects.';
// change 0
$csv2post_upgrade_array['6.7.4']['changes'][0]['package'] = 'free';// free,paid - use free to display and apply for all installations else hide a change from free users by using paid   
$csv2post_upgrade_array['6.7.4']['changes'][0]['type'] = 'optionrecord';// optionrecord, replacefile, addfile, deletefile, modifyfile, creatable, altertable, deletetable, editrecord, addrecord, deleterecord
$csv2post_upgrade_array['6.7.4']['changes'][0]['name'] = 'csv2post_tabmenu';// specific name of file or the key for option record
$csv2post_upgrade_array['6.7.4']['changes'][0]['loc'] = 'wp_options';// file path or database table name
$csv2post_upgrade_array['6.7.4']['changes'][0]['backup'] = false;// does the existing record,file or table need backed up?
$csv2post_upgrade_array['6.7.4']['changes'][0]['element'] = 'record';// file,record,table    
$csv2post_upgrade_array['6.7.4']['changes'][0]['method'] = 'function';// the method we will process the update: function
$csv2post_upgrade_array['6.7.4']['changes'][0]['function'] = 'csv2post_INSTALL_tabmenu_settings';// the method we will process the update: function
$csv2post_upgrade_array['6.7.4']['changes'][0]['title'] = 'Plugin Menu Settings';// short name to refer to what is being upgraded
$csv2post_upgrade_array['6.7.4']['changes'][0]['description'] = 'The plugins tab menu is created using an array of settings. The structure of the array has been changed. This version expects the new array structure when building the menu and so an update must be done. This will reverse any menu configuration you have done i.e. if you hid selected screens they may now appear again. Sorry for the inconvenience'; 
// change 1
$csv2post_upgrade_array['6.7.4']['changes'][1]['package'] = 'free';// free,paid - use free to display and apply for all installations else hide a change from free users by using paid   
$csv2post_upgrade_array['6.7.4']['changes'][1]['type'] = 'optionrecord';// optionrecord, replacefile, addfile, deletefile, modifyfile, creatable, altertable, deletetable, editrecord, addrecord, deleterecord
$csv2post_upgrade_array['6.7.4']['changes'][1]['name'] = 'csv2post_adminset';// specific name of file or the key for option record
$csv2post_upgrade_array['6.7.4']['changes'][1]['loc'] = 'wp_options';// file path or database table name
$csv2post_upgrade_array['6.7.4']['changes'][1]['backup'] = false;// does the existing record,file or table need backed up?
$csv2post_upgrade_array['6.7.4']['changes'][1]['element'] = 'record';// file,record,table    
$csv2post_upgrade_array['6.7.4']['changes'][1]['method'] = 'function';// the method we will process the update: function
$csv2post_upgrade_array['6.7.4']['changes'][1]['function'] = 'csv2post_INSTALL_admin_settings';// the method we will process the update: function
$csv2post_upgrade_array['6.7.4']['changes'][1]['title'] = 'Plugins General Settings';// short name to refer to what is being upgraded
$csv2post_upgrade_array['6.7.4']['changes'][1]['description'] = 'This will re-install the plugins general settings, mostly administration related at this time. Some settings are global settings related to data import or post creation and so there may be a change to current projects. Please review your settings and proejcts after this update.'; 
*/
    
/**
* Old entries can be removed after some months if this array becomes very large
*/
?>