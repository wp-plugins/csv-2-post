<?php

function csv2post_page_toppage(){require_once( WTG_C2P_DIR.'pages/pagemain/csv2post_main.php' );}
function csv2post_page_data(){require_once( WTG_C2P_DIR.'pages/data/csv2post_main_data.php' );}
function csv2post_page_projects(){require_once( WTG_C2P_DIR.'pages/projects/csv2post_main_projects.php' );}                
function csv2post_page_creation(){require_once( WTG_C2P_DIR.'pages/creation/csv2post_main_creation.php' );}
function csv2post_page_install(){require_once( WTG_C2P_DIR.'pages/install/csv2post_main_install.php' );}
function csv2post_page_more(){require_once( WTG_C2P_DIR.'pages/more/csv2post_main_more.php' );}

/**
* Wordpress navigation menu
*/
function csv2post_admin_menu(){
    global $csv2post_currentversion,$csv2post_mpt_arr,$wtgtp_homeslug,$csv2post_pluginname,$csv2post_is_installed,$csv2post_is_free;
     
    $n = $csv2post_pluginname;

    // if file version is newer than install we display the main page only but re-label it as an update screen
    // the main page itself will also change to offer plugin update details. This approach prevent the problem with 
    // visiting a page without permission between installation
    $installed_version = csv2post_WP_SETTINGS_get_version();                

    // installation is not done on activation, we display an installation screen if not fully installed
    if(!$csv2post_is_installed && !isset($_POST['csv2post_plugin_install_now'])){   
       
        // if URL user is attempting to visit any screen other than page=csv2post then redirect to it
        if(isset($_GET['page']) && strstr($_GET['page'],'csv2post_')){
            wp_redirect( get_bloginfo('url') . '/wp-admin/admin.php?page=csv2post' );           
            exit;    
        }
        
        // if plugin not installed
        add_menu_page(__('Install',$n.'install'), __('CSV 2 POST Install','home'), 'administrator', 'csv2post', 'csv2post_page_toppage' );
        
    }elseif(isset($csv2post_currentversion) 
    && isset($installed_version) 
    && $installed_version != false
    && $csv2post_currentversion > $installed_version 
    && !isset($_POST['csv2post_plugin_update_now'])){
        
        // if URL user is attempting to visit any screen other than page=csv2post then redirect to it
        if(isset($_GET['page']) && strstr($_GET['page'],'csv2post_')){
            wp_redirect( get_bloginfo('url') . '/wp-admin/admin.php?page=csv2post' );
            exit;    
        }
                
        // if $installed_version = false it indicates no installation so we should not be displaying an update screen
        // update screen will be displayed after installation submission if this is not in place
        
        // main is always set in menu, even in extensions main must exist
        add_menu_page(__('Update',$n.'update'), __('CSV 2 POST Update','home'), 'administrator', 'csv2post', 'csv2post_page_toppage' );
        
    }else{

        // main is always set in menu, even in extensions main must exist
        add_menu_page(__($csv2post_mpt_arr['menu']['main']['title'],$n.$csv2post_mpt_arr['menu']['main']['slug']), __($csv2post_mpt_arr['menu']['main']['menu'],'home'), csv2post_WP_SETTINGS_get_page_capability('main'), $n, 'csv2post_page_toppage' ); 

        // loop through sub-pages
        foreach($csv2post_mpt_arr['menu'] as $k => $a){

            // skip none page values such as ['arrayinfo']
            if($k != 'arrayinfo'){
                // skip main page (even extensions use the same main page file but the tab screens may be customised
                if($csv2post_is_free && $a == 'beta' || $k == 'main'){
                    // page is either for paid edition only or is added to the menu elsewhere    
                }else{
                    // if ['active'] is set and not equal to false, if not set we assume true   
                    if(!isset($csv2post_mpt_arr['menu'][$k]['active']) || isset($csv2post_mpt_arr['menu'][$k]['active']) && $csv2post_mpt_arr['menu'][$k]['active'] != false){
                        // if is free package, only show page if package value set (added 29th April 2013) and the value == free
                        if(!$csv2post_is_free || $csv2post_is_free && isset($csv2post_mpt_arr['menu'][$k]['package']) && $csv2post_mpt_arr['menu'][$k]['package'] == 'free'){
                            $required_capability = csv2post_WP_SETTINGS_get_page_capability($k);    
                            add_submenu_page($n, __($csv2post_mpt_arr['menu'][$k]['title'],$n.$csv2post_mpt_arr['menu'][$k]['slug']), __($csv2post_mpt_arr['menu'][$k]['menu'],$n.$csv2post_mpt_arr['menu'][$k]['slug']), $required_capability, $csv2post_mpt_arr['menu'][$k]['slug'], 'csv2post_page_' . $k);
                        }
                    }
                }
            }             

        }// end page loop
    }
}

/**
 * Tabs menu loader - calls function for css only menu or jquery tabs menu
 * 
 * @param string $thepagekey this is the screen being visited
 */
function csv2post_createmenu($thepagekey){           
    $csv2post_guitheme = csv2post_get_theme();
    if($csv2post_guitheme == 'wordpresscss'){  
        csv2post_navigation_css($thepagekey);
    }elseif($csv2post_guitheme == 'jquery'){
        csv2post_navigation_jquery($thepagekey);    
    }elseif($csv2post_guitheme == 'nonav'){
        echo '<div id="csv2post_maintabs">';
    }
} 

/**
* Secondary navigation builder - CSS only
* @todo MEDIUMPRIORITY, move the css in function to a .css file, double check no duplicate styles throughout plugin, also replace the paths to the overlay image
* @param mixed $thepagekey
*/
function csv2post_navigation_css($thepagekey){    
    global $csv2post_is_activated,$csv2post_is_installed,$csv2post_mpt_arr;?>   
            
    <div id="csv2post_maintabs">
        
        <?php
        $pageslug = $csv2post_mpt_arr['menu'][$thepagekey]['slug'];

        // begin building menu - controlled by jQuery
        echo '<div id="csv2post_cssmenu">
        <ul>';
              
            // loop through tabs - held in menu pages tabs array
            foreach($csv2post_mpt_arr['menu'][$thepagekey]['tabs'] as $tab => $values){

                $tabslug = $csv2post_mpt_arr['menu'][$thepagekey]['tabs'][$tab]['slug'];
                $tablabel = $csv2post_mpt_arr['menu'][$thepagekey]['tabs'][$tab]['label'];   
                
                if(csv2post_menu_should_tab_be_displayed($thepagekey,$tab)){
                    
                    $active = '';
                    if(isset($_GET['csv2posttabnumber']) && $_GET['csv2posttabnumber'] == $tab){
                        $active = 'class="active"';
                    }
                    // default menu build approach
                    echo '<li '.$active.'><a href="'.csv2post_create_adminurl($pageslug,'').'&csv2posttabnumber='.$tab.'&csv2postpagename='.$thepagekey.'">' . $tablabel . '</a></li>';                                
                
                } 
            }// for each
            
        echo '</ul></div>';
}

function csv2post_navigation_jquery($thepagekey){    
    global $csv2post_is_activated,$csv2post_is_installed,$csv2post_mpt_arr,$csv2post_projectslist_array;?>

    <script>
    $(function() {
         $( "#csv2post_maintabs" ).tabs({
            cookie: {
                // store cookie for a day, without, it would be a session cookie
                expires: 1
            },
            select: function(event, ui){
              window.location = ui.tab.href;
            }
        });       
    });
    </script>

    <div id="csv2post_maintabs">

        <?php 
        ##########################################################
        #                                                        #
        #          ADD HEADERS FIRST not currently in use        #
        #                                                        #
        ##########################################################
        if($csv2post_mpt_arr['menu'][$thepagekey]['headers'] == true){

            foreach($csv2post_mpt_arr['menu'][$thepagekey]['tabs'] as $tab => $values){

                $pageslug = $csv2post_mpt_arr['menu'][$thepagekey]['slug'];
                $tabslug = $csv2post_mpt_arr['menu'][$thepagekey]['tabs'][$tab]['slug'];
                $tablabel = $csv2post_mpt_arr['menu'][$thepagekey]['tabs'][$tab]['label'];   

                if( csv2post_menu_should_tab_be_displayed($thepagekey,$tab) ){
          
                }
            }
        }?>       
    
    <?php         
    // begin building menu - controlled by jQuery
    $menu = '';
    $menu .= '<ul>'; 
         
    // loop through tabs - held in menu pages tabs array 
    foreach($csv2post_mpt_arr['menu'][$thepagekey]['tabs'] as $tab=>$values){
                    
        $pageslug = $csv2post_mpt_arr['menu'][$thepagekey]['slug'];
        $tabslug = $csv2post_mpt_arr['menu'][$thepagekey]['tabs'][$tab]['slug'];
        $tablabel = $csv2post_mpt_arr['menu'][$thepagekey]['tabs'][$tab]['label'];   
                                           
        if( csv2post_menu_should_tab_be_displayed($thepagekey,$tab) ){
        
            // change label for first time users on
            if($thepagekey == 'projects' && !isset($csv2post_projectslist_array) || $thepagekey == 'projects' && !is_array($csv2post_projectslist_array)){
                $tablabel = 'Please create your first Post Creation Project...';
            }   
                            
            // default menu build approach
            $menu .= '<li><a href="#tabs-'.$tab.'">' . $tablabel . '</a></li>';                                
        } 
      
        // discontinue loop if no projects exist so that only the first screen is displayed
        if($thepagekey == 'projects' && !isset($csv2post_projectslist_array) || $thepagekey == 'projects' && !is_array($csv2post_projectslist_array)){
            break;
        }    
                            
    }// for each
    
    $menu .= '</ul>'; 
    echo $menu;
}       

/**
* Used to determine if a screen is meant to be displayed or not, based on package and settings 
*/
function csv2post_menu_should_tab_be_displayed($page,$tab){
    global $csv2post_mpt_arr,$csv2post_is_free,$csv2post_beta_mode;

    // if screen not active
    if(isset($csv2post_mpt_arr['menu'][$page]['tabs'][$tab]['active']) && $csv2post_mpt_arr['menu'][$page]['tabs'][$tab]['active'] == false){
        return false;
    }    
    
    // if screen is not active at all (used to disable a screen in all packages and configurations)
    if(isset($csv2post_mpt_arr['menu'][$page]['tabs'][$tab]['active']) && $csv2post_mpt_arr['menu'][$page]['tabs'][$tab]['active'] == false){
        return false;
    }
                 
    // display screen if the package not set, just to be safe as the package value should also be set if menu array installed properly
    if(!isset($csv2post_mpt_arr['menu'][$page]['tabs'][$tab]['package'])){      
        return true;
    }
                                      
    // dont allow beta mode screens to be displayed if plugin build is not in beta mode
    if($csv2post_mpt_arr['menu'][$page]['tabs'][$tab]['package'] == 'beta' && $csv2post_beta_mode == false){  
        return false;    
    }    
                
    // if package is free and screen is free OR if package is not free and screen is not free = return false
    if($csv2post_is_free && $csv2post_mpt_arr['menu'][$page]['tabs'][$tab]['package'] == 'free'  
    || !$csv2post_is_free && $csv2post_mpt_arr['menu'][$page]['tabs'][$tab]['package'] == 'paid'){   
        return true;
    }

    // if package is not free and screen is free = return true
    if(!$csv2post_is_free && $csv2post_mpt_arr['menu'][$page]['tabs'][$tab]['package'] == 'free'){   
        return true;
    }   
                 
    return true;      
}

/**
* Returns value for displaying or hiding a page based on edition (free or full).
* These is no point bypassing this. The pages hidden require PHP that is only provided with
* the full edition. You may be able to use the forms, but the data saved won't do anything or might
* cause problems.
* 
* @param mixed $package_allowed, 0=free 1=full/paid 2=dont ever display
* @returns boolean true if screen is to be shown else false
* 
* @deprecated
*/
function csv2post_page_show_hide($package_allowed = 0){
    global $csv2post_is_free;
    
    if($package_allowed == 2){
        return false;// do not display in any package   
    }elseif($csv2post_is_free && $package_allowed == 0){
        return true;     
    }elseif($csv2post_is_free && $package_allowed == 1){
        return false;// paid edition page only, not be displayed in free edition
    }
    return true;
} 
?>
