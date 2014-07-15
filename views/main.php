<?php
/**
 * Main [section] - Projects [page]
 * 
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne   
 * @since 8.1.3
 */

// Prohibit direct script loading
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * View class for Main [section] - Projects [page]
 * 
 * @package CSV 2 POST
 * @subpackage Views
 * @author Ryan Bayne
 * @since 8.1.3
 */
class CSV2POST_Main_View extends CSV2POST_View {

    /**
     * Number of screen columns for post boxes on this screen
     *
     * @since 8.1.3
     *
     * @var int
     */
    protected $screen_columns = 2;
    
    protected $view_name = 'main';
    
    /**
     * Set up the view with data and do things that are specific for this view
     *
     * @since 8.1.3
     *
     * @param string $action Action for this view
     * @param array $data Data for this view
     */
    public function setup( $action, array $data ) {
        global $c2p_settings;
        
        // create constant for view name
        if(!defined( "WTG_CSV2POST_VIEWNAME") ){define( "WTG_CSV2POST_VIEWNAME", $this->view_name );}
        
        // create class objects
        $this->CSV2POST = CSV2POST::load_class( 'CSV2POST', 'class-csv2post.php', 'classes' );
        $this->UI = CSV2POST::load_class( 'C2P_UI', 'class-ui.php', 'classes' );  
        $this->DB = CSV2POST::load_class( 'C2P_DB', 'class-wpdb.php', 'classes' );
        $this->PHP = CSV2POST::load_class( 'C2P_PHP', 'class-phplibrary.php', 'classes' );
                        
        // load the current project row and settings from that row
        $this->project_object = $this->CSV2POST->get_project( $c2p_settings['currentproject'] );
        $this->current_project_settings = maybe_unserialize( $this->project_object->projectsettings );
                
        parent::setup( $action, $data );
        
        $this->add_meta_box( 'about-welcome', __( 'Welcome To Version 8', 'csv2post' ), array( $this, 'postbox_about_welcome' ), 'normal','default',array( 'formid' => 'welcome' ) );      
        $this->add_meta_box( 'about-computersampledata', __( 'Computer Sample Data', 'csv2post' ), array( $this, 'postbox_about_computersampledata' ), 'normal','default',array( 'formid' => 'computersampledata' ) );      
        $this->add_meta_box( 'about-iconsexplained', __( 'Icons Explained', 'csv2post' ), array( $this, 'postbox_about_iconsexplained' ), 'normal','default',array( 'formid' => 'iconsexplained' ) );      
        $this->add_meta_box( 'about-twitterupdates', __( 'Twitter Updates', 'csv2post' ), array( $this, 'postbox_about_twitterupdates' ), 'side','default',array( 'formid' => 'twitterupdates' ) );      
        $this->add_meta_box( 'about-translatorsneeded', __( 'Translators Needed', 'csv2post' ), array( $this, 'postbox_about_translatorsneeded' ), 'side','default',array( 'formid' => 'translatorsneeded' ) );      
        $this->add_meta_box( 'about-support', __( 'Support', 'csv2post' ), array( $this, 'postbox_about_support' ), 'normal','default',array( 'formid' => 'support' ) );      
        $this->add_meta_box( 'about-facebook', __( 'Facebook', 'csv2post' ), array( $this, 'postbox_about_facebook' ), 'side','default',array( 'formid' => 'facebook' ) );      
        $this->add_meta_box( 'about-theauthor', __( 'The Author', 'csv2post' ), array( $this, 'postbox_about_theauthor' ), 'side','default',array( 'formid' => 'theauthor' ) );      
        $this->add_meta_box( 'about-freevspaid', __( 'Free vs Paid', 'csv2post' ), array( $this, 'postbox_about_freevspaid' ), 'side','default',array( 'formid' => 'freevspaid' ) );      
    }                   
 
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_about_welcome( $data, $box ) {
        echo '<p>' . __( 'Version 8 looks, feels and operates far more like true WP software. The biggest change is the implementation of 
        postboxes on every page. A new help system was implemented but now being upgraded even further. It will allow help text to be created first
        on the plugins site then imported to the plugin. No other plugin does this. The edition on Wordpress.org is being taking to another level with
        post updating now being possible. Not to the extent and power in the premium edition but it will be there. The plugins code is of far higher 
        quality and development ease results in work being complete in half the time it used to take. Version 8 is supported with a new web portal which is intended to become dynamic for different users including optional subscription unlocking
        more training material.', 'csv2post' ) . '</p>';
    }       
        
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_about_computersampledata( $data, $box ) {    
        ?>  
 
        <p><?php _e( "I've saved information from PC World to make a sample file. The file is stored on Google Docs and is public. Feel free
        to download and test the plugin using my sample data. You will see this data in screenshots and
        video tutorials for both free and premium editions of the plugin."); ?>
        </p>
        
        <ol>
            <li><a href="https://docs.google.com/spreadsheets/d/1J140c85Kl5fE_9dQAIgSq-uATtD-Jtwje4G1WQFgBbU/edit?usp=sharing" id="csv2postviewmainfile" target="_blank">View Main File</a></li>
        </ol>        
         
        <h2>Advanced Multi-File Samples</h2> 
        
        <p><?php _e( "To push the plugin I've saved information from PC World, split into three separate files.
        This will be used to test multi-file projects and the data engine within CSV 2 POST."); ?>
        </p>
                
        <?php $this->UI->panel_video_icon( 'computersampledata', 'yCli1iU-0a0' );?>
               
        <h3><?php _e( 'View Original Spreadsheets' );?></h3>
        <ol>
            <li><a href="https://docs.google.com/spreadsheet/ccc?key=0An6BbeiXPNK0dHM5Q043QzBtTGw4QU9SeXNYdEM1UHc&usp=sharing" target="_blank">Main PC Details</a></li>
            <li><a href="https://docs.google.com/spreadsheet/ccc?key=0An6BbeiXPNK0dHlFZUx1V3p6bHJrOHJZMUNmcGRyUWc&usp=sharing" target="_blank">Specifications</a></li>
            <li><a href="https://docs.google.com/spreadsheet/ccc?key=0An6BbeiXPNK0dDhEdHZIYVJ4YkViUkQ3MTFESFdUR2c&usp=sharing" target="_blank">Descriptions and Images</a></li>
        </ol>
        
        <h3><?php _e( 'Download CSV Files' );?></h3>
        <p><?php _e( 'Warning: Google does not seem to handle the third file with text well, often adding line breaks in different places each time the file is downloaded. Simply correct them before using.' );?></p>

        <ol>
            <li><a href="https://docs.google.com/spreadsheet/pub?key=0An6BbeiXPNK0dHM5Q043QzBtTGw4QU9SeXNYdEM1UHc&output=csv" target="_blank">Main PC Details</a></li>
            <li><a href="https://docs.google.com/spreadsheet/pub?key=0An6BbeiXPNK0dHlFZUx1V3p6bHJrOHJZMUNmcGRyUWc&output=csv" target="_blank">Specifications</a></li>
            <li><a href="https://docs.google.com/spreadsheet/pub?key=0An6BbeiXPNK0dDhEdHZIYVJ4YkViUkQ3MTFESFdUR2c&output=csv" target="_blank">Descriptions and Images</a></li>
        </ol>
    
            
        <?php                             
    }

    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_about_iconsexplained( $data, $box ) {    
        ?>  
        <p class="about-description"><?php _e( 'The plugin has icons on the UI offering different types of help...' ); ?></p>
        
        <h3>Help Icon<?php echo $this->UI->helpicon( 'http://www.webtechglobal.co.uk/csv-2-post' )?></h3>
        <p><?php _e( 'The help icon offers a tutorial or indepth description on the WebTechGlobal website. Clicking these may open
        take a key page in the plugins portal or post in the plugins blog. On a rare occasion you will be taking to another users 
        website who has published a great tutorial or technical documentation.' )?></p>        
        
        <h3>Discussion Icon<?php echo $this->UI->discussicon( 'http://www.webtechglobal.co.uk/csv-2-post' )?></h3>
        <p><?php _e( 'The discussion icon open an active forum discussion or chat on the WebTechGlobal domain in a new tab. If you see this icon
        it means you are looking at a feature or area of the plugin that is a hot topic. It could also indicate the
        plugin author would like to hear from you regarding a specific feature. Occasionally these icons may take you to a discussion
        on other websites such as a Google circles, an official page on Facebook or a good forum thread on a users domain.' )?></p>
                          
        <h3>Info Icon<img src="<?php echo WTG_CSV2POST_IMAGES_URL;?>info-icon.png" alt="<?php _e( 'Icon with an i click it to read more information in a popup.' );?>"></h3>
        <p><?php _e( 'The information icon will not open another page. It will display a pop-up with extra information. This is mostly used within
        panels to explain forms and the status of the panel.' )?></p>        
        
        <h3>Video Icon<?php echo $this->UI->videoicon( 'http://www.webtechglobal.co.uk/csv-2-post' )?></h3>
        <p><?php _e( 'clicking on the video icon will open a new tab to a YouTube video. Occasionally it may open a video on another
        website. Occasionally a video may even belong to a user who has created a good tutorial.' )?></p> 
               
        <h3>Trash Icon<?php echo $this->UI->trashicon( 'http://www.webtechglobal.co.uk/csv-2-post' )?></h3>
        <p><?php _e( 'The trash icon will be shown beside items that can be deleted or objects that can be hidden.
        Sometimes you can hide a panel as part of the plugins configuration. Eventually I hope to be able to hide
        notices, especially the larger ones..' )?></p>      
      <?php     
    }
    
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_about_twitterupdates( $data, $box ) {    
        ?>      
        <a class="twitter-timeline" href="https://twitter.com/CSV2POST" data-widget-id="478813344225189889">Tweets by @CSV2POST</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id) ){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document, "script", "twitter-wjs");</script>                                                   
        <?php     
    }

    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_about_translatorsneeded( $data, $box ) {    
        ?>      
        <p class="about-description"><?php _e( 'It is finally time to begin translating this massive plugin. You can get your name and website 
        listed here as the sole and dedicated translator for your region. Affiliates who translate will get their affiliate URL place here instead and in
        other locations that will generate commission.', 'csv2post' ); ?></p>
        
        <ul>
            <li><a class="button" href="http://www.webtechglobal.co.uk" title="Ryan Bayne translates into English" target="_blank">Ryan Bayne - English Translator</a></li>
        </ul>                    
        <?php     
    }
        
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_about_support( $data, $box ) {    
        ?>      
        <p><?php _e( 'All users (free and premium) are invited to use the WebTechGlobal <a href="http://forum.webtechglobal.co.uk/viewforum.php?f=8" title="CSV 2 POST Forum" target="_blank">Forum</a>. Simply <a href="http://www.webtechglobal.co.uk/wp-login.php?action=register" title="Forum" target="_blank">register</a> on our
        Wordpress blog, <a href="http://www.webtechglobal.co.uk/wp-login.php" title="WebTechGlobal Log-In" target="_blank">log into</a> your WTG WP account, activate your account by answering the anti-spam question
        and then your phpBB forum account will be automatically created. You can read more <a href="http://forum.webtechglobal.co.uk/viewtopic.php?f=18&t=8" title="How To Register" target="_blank">detailed instructions</a> here.
        Please expect some content to be restricted to clients and subscribers. Their funds go towards creating professional documentation and videos specifically
        for a subscriber only area. Such areas can be accessed for a trial period in return for a small fee.', 'csv2post' ); ?></p>                     
        <?php     
    }    
    
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_about_facebook( $data, $box ) {    
        ?>      
        <p class="about-description"><?php _e( 'The CSV 2 POST project needs your support, please like my plugin...', 'csv2post' ); ?></p>
        <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2FCSV2POST&amp;width=350&amp;height=290&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true" scrolling="no" frameborder="0" style="padding: 10px 0 0 0;border:none; overflow:hidden; width:100%; height:290px;" allowTransparency="true"></iframe>                                                                             
        <?php     
    }

    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_about_theauthor( $data, $box ) {    
        ?>      
        <p><?php _e( 'I live in a town named Dysart in Scotland. It is an old fishing town of folk just getting by but it has a view of
        Edinburgh to help keep us proud. As I type this we are talking about Independence. With CSV 2 POST being such a big
        project I find myself wondering if it is the product to get me and my family through hard times or will independence be a
        walk in the park!? Either way I will not be taking any chances and I am very determined to make CSV 2 POST work for WebTechGlobal
        and for you.', 'csv2post' );?></p>
        <?php     
    }
    
    /**
    * post box function for testing
    * 
    * @author Ryan Bayne
    * @package CSV 2 POST
    * @since 8.1.3
    * @version 1.0.0
    */
    public function postbox_about_freevspaid( $data, $box ) {
        echo '<p>' . __( "The free edition is not intended to be a trial. My goal is for more than 80% of users to feel the free edition 
        is enough for their project. I feel far too many of free importers hold back basic code and limit the use of standard post options simply
        because they are being added to an autoblogging sequence which is a process outside of WP's design. I'm currently in the process of implementing a fairer approach
        which will be used for all of my plugins. One that gives more back to the WP community. My earnings will decrease but the new WP e-Customers plugin will help to streamline
        customer service and technical support in such a way that will free-up some of my time. In the end users will get more for free, everyone will
        get better support and I will have a easier job. This is the big plan rolling out right now and will take until 2016 for the entire system", 'csv2post' ) . '</p>';
    }

}?>