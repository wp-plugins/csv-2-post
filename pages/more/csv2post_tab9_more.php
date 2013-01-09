<?php 
// The contact page can be configured depending on why the user wishes to use it, through clicking on other screens
// decide the main purpose of the users contact with WebTechGlobal and change screen to suit it
if(isset($_POST[WTG_C2P_ABB . 'openpluginhelp'])){$contactreason = 'pluginhelp';}
elseif(isset($_POST[WTG_C2P_ABB . 'openhire'])){$contactreason = 'openhire';}            
elseif(isset($_POST[WTG_C2P_ABB . 'opentestimonial'])){$contactreason = 'testimonial';}            
elseif(isset($_POST[WTG_C2P_ABB . 'openbugreport'])){$contactreason = 'bug';}            
elseif(isset($_POST[WTG_C2P_ABB . 'opengeneraladvice'])){$contactreason = 'generaladvice';}            
elseif(isset($_POST[WTG_C2P_ABB . 'openrequestchanges'])){$contactreason = 'requestchanges';}            
elseif(isset($_POST[WTG_C2P_ABB . 'openrequestfeature'])){$contactreason = 'requestfeature';}            
elseif(isset($_POST[WTG_C2P_ABB . 'openrequesttutorial'])){$contactreason = 'requesttutorial';}            
elseif(isset($_POST[WTG_C2P_ABB . 'openaffiliateenquiry'])){$contactreason = 'affiliateenquiry';}  
elseif(isset($_POST[WTG_C2P_ABB . 'openprovideftp'])){$contactreason = 'provideftp';}  
elseif(isset($_POST[WTG_C2P_ABB . 'openprovideadmin'])){$contactreason = 'provideadmin';}  
elseif(isset($_POST[WTG_C2P_ABB . 'openprovidemysql'])){$contactreason = 'providemysql';}  
elseif(isset($_POST[WTG_C2P_ABB . 'openprovidehosting'])){$contactreason = 'providehosting';}                 
else{$contactreason = 'pluginhelp';}?>

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'contact';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Contact');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['help_button'] = csv2post_helpbutton_text(true,false);
#### change these two lines for this page they are more dynamic
$panel_array['panel_intro'] = __('When a post does not have settings in its custom fields, these defaults are used.');
$panel_array['panel_help'] = __('Settings which effect posts (that includes pages or custom post types) will be found here. This panel of settings behaves as a default, in many cases the default is ignored when a setting is applied to a specific post i.e. setting value stored in a custom field.');  
?>
<div id="titles" class="postbox">
    <div class="handlediv" title="Click to toggle"><br /></div>

    <?php // change panel title depending on contact reason - this gets added to hidden field also as csv2post_contactreason_frompost
    if($contactreason == 'pluginhelp'){
        $panel_array['panel_title'] = 'Request Plugin Help';
        $panel_array['panel_intro'] = 'Priority support is giving to Gold members';// ### @todo indicate what subscription the user is
        $panel_array['panel_help'] = 'Over 2012 I will be working on an FAQ system, tickets and improving how we interact with the plugins forum. Until the required plugins are complete, all support will be taking through email.';        
    }elseif($contactreason == 'openhire'){
        $panel_array['panel_title'] = 'Hire WebTechGlobal';
        $panel_array['panel_intro'] = 'Please contact me for a quote by submitting the form below...';
        $panel_array['panel_help'] = 'I provide Web Design & Development services, all aspects of the Internet are part of my profession. However I focus on Wordpress and can provide cheaper services to Wordpress users. If you need a new plugin created, existing one adapting, a theme creating or even the core of Worpress customised then I can do this for you.';         
    }elseif($contactreason == 'testimonial'){
        $panel_array['panel_title'] = 'Provide A Testimonial';
        $panel_array['panel_intro'] = 'I really appreciate any time you take to provide a good testimonial, thank you';
        $panel_array['panel_help'] = 'I plan to create a simple web service in 2012 for handling testimonial submissions from my contact form. Testimonials automatically be displayed on various pages, even multiple sites, after the are accepted at the click of a button. Testimonials are imported and a good testimonial is often priceless. A good testimonial is one backed by evidence that the person providing it is real, so it helps to get your own website address and full name.'; 
    }elseif($contactreason == 'bug'){
        $panel_array['panel_title'] = 'Reporting Plugin Fault';
        $panel_array['panel_intro'] = 'Please provide all the details you can and evidence of the fault';
        $panel_array['panel_help'] = 'A reported fault gets instant attention if evidence is also provided. It can be a serious waste of time hunting for a fault in the wrong place or in some cases a fault is a conflict with another plugin or theme. I have spent many hours trying to fix bugs that turned out to be caused by a users Wordpress installation, admitted by them. Time is money, so any reports of faults without enough information will be read but may not get instant attention. What I will do is wait to see if multiple people report the fault, then using the gathered information get to work on fixing the issue. In 2012 I will be working on a system that will keep you updated on the progress of any reports you submit.'; 
    }elseif($contactreason == 'generaladvice'){
        $panel_array['panel_title'] = 'Request Project Advice';
        $panel_array['panel_intro'] = 'Gold members will get priority responses for help on configuring your project';
        $panel_array['panel_help'] = 'Silver members will get a reply but Gold members contact submission is processed by more Web Services and flagged priority over Silver users within the WebTechGlobal administration area. Gold members are those who have purchased the plugin within the last 3 months (3 month free subscription) or those who are subscribing monthly after their initial free 3 months.'; 
    }elseif($contactreason == 'requestchanges'){
        $panel_array['panel_title'] = 'Request Feature Change';
        $panel_array['panel_intro'] = 'Requests are added to a to list, priority is giving to paid requests';
        $panel_array['panel_help'] = 'Changing an existing feature effects all users. It is not something that can be done without a lot of planning, in most cases even prototypes are needed. If you have the budget you can request the change be made only for you, for the version of the plugin you have. Please keep in mind that the change may not exist in future versions after it has been made plus it is also more expensive. You can pay to have the change made with priority, this is cheaper and is usually £30-£100 depending on how advanced your request is. You can ofcourse pay more for urgency. All work requires 2 weeks notice unless a premium of £50.00 (or more) is paid to begin the work straight away. Changes to existing features cost less than requesting a new feature in most cases but not all. A final fee must be agreed on.';
    }elseif($contactreason == 'requestfeature'){
        $panel_array['panel_title'] = 'Request New Feature';
        $panel_array['panel_intro'] = 'New features will be added to a long list unless backed with funding';
        $panel_array['panel_help'] = 'A new feature may be actually be something I already have on the plugins to do list. However if the feature was scheduled and requires other changes to be complete first I cannot promise it will be done straight away. For a fee of £100 I can begin working on it straight away providing I was planning to eventually anyway. If you want a feature I was not planning to do I will consider adding it to the plugins to do list. If I feel the request does not suit my vision of '.$csv2post_plugintitle.' I will reject the request. This is rare and the chances are you will know if your request is something so different it may not be suitable within the existing plugin. In this case we can discuss a fee for making it happen but costs would start at £150 at least for major changes to the existing plugin or £250 upwards for a new plugin designed specifically for your needs. ';
    }elseif($contactreason == 'requesttutorial'){
        $panel_array['panel_title'] = 'Request New Tutorials'; 
        $panel_array['panel_intro'] = 'I try to make tutorials on demand but most will be added to my scheduled tutorial creation day';
        ### @todo - pass gold to the csv2post_google_searchlink() function when user has active subscription, this will create a link to google.com, silver users get sent to a WebTechGlobal AdSense Search page instead
        $panel_array['panel_help'] = 'Tutorials are uploaded to YouTube and the '.$csv2post_plugintitle.' YouTube Channel can be viewed '.csv2post_link('here','to be confirmed','_blank').'. Chances are the area you need support on is already covered as I do do tutorials for every screen and tab. It may be that the screen you need help for is not mentioned in the videos title. Please try a Google search, '.csv2post_google_searchlink('click here','silver','Test Search String @todo').' to do a relevent search for the current screen and tab. If you find content please check if the video is displayed within a help page, if not please let me know and I can arrange for the video to be created plus added to any text content that does not have a suitable video. I will try to create all tutorials requested. Gold members get priority but even Gold members requests may be scheduled for creation on a set date when I make tutorials in bulk. This is the most effecient way to work but I will always be happy to consider making your request priority depending on the circumstances.'; 
    }elseif($contactreason == 'affiliateenquiry'){
        $panel_array['panel_title'] = 'WebTechGlobal Affiliate Enquiry';
        $panel_array['panel_intro'] = 'Enquire about the WebTechGlobal affiliate programme';
        $panel_array['panel_help'] = 'My affiliate programme allows promotion of all services and products. Over the next few years these will grow and there will be more to offer. The advantage is the varied range of options affiliates will be able to take advantage of i.e. plugins for Wordpress, graphic design related services or even consultation. A single affiliate link works for all and gets you a commission on anything purchased. This may be a £10 plugin or a £1000 website, over 2012 things will expand greatly and in 2013 existing affiliates who are already earnign will see a massive increase in commission.'; 
    }elseif($contactreason == 'provideftp'){
        $panel_array['panel_title'] = 'Provide FTP Login';
        $panel_array['panel_intro'] = 'Send your FTP login to WebTechGlobal (please click help and read terms)';
        ### @todo     CREATE WEB SERVICE THAT PROVIDES IP ADDRESS TO GOLD USERS
        $panel_array['panel_help'] = 'The purpose of this form is to send the details via a SOAP API/Web Service, they are encrypted and stored in a database. This is more secure than by email and later in 2012 you will be able to edit your details in your WebTechGlobal account. You are in FTP mode on the contact form. Click on the Contact tab to view the normal contact form. In FTP mode you have the option of storing your FTP details in your own blog, data is encrypted but I still recommend only using this feature for temporary FTP accounts. You may also send your FTP details so that they become stored in your WebTechGlobal account, this helps us provide support services. Again please provide temporary details or a temporary IP permission on the FTP account making it easy to open access if I need it again after the initial use. All data is encrypted but I am not responsible for live websites. It is a standard practice to change login information when going live or provide limited, short time access for a specific IP address especially on a live site that has valuable data or files stored. See your hosting control panel for more information on how to provide FTP login that is limited to a single IP address. My current IP address is TBC. This method allows you to check FTP logs and confirm what account has made file changes on your server.'; 
    }elseif($contactreason == 'provideadmin'){
        $panel_array['panel_title'] = 'Provide Wordpress Admin Login';
        $panel_array['panel_intro'] = 'Provide a short term admin login so I can work directly on your blog';
        $panel_array['panel_help'] = 'It is always recommended to provide temporary login access only however all login details are stored in the WebTechGlobal database and encrypted. The purpose of this form is to send the details via a SOAP API/Web Service and avoid using email which is less secure. Later in 2012 you will be able to edit the information provided in your account.'; 
    }elseif($contactreason == 'providemysql'){
        $panel_array['panel_title'] = 'Provide MySQL Login';
        $panel_array['panel_intro'] = 'Provide MySQL login with an expiry for extra security (48 hours forced expiry)';
        $panel_array['panel_help'] = 'Out of all the services to share login details, this one is different from some because the information has a forced expiry of 48 hours for extra security. Your details will be deleted from my database automatically. In most cases this will be enough time for me to access your database when working for you or providing support. I also try to remember and remove these login details after a job is done. You are updated when these changes happen but where possible it is always recommended that you change your MySQL password after sharing it or work on a test blog.'; 
    }elseif($contactreason == 'providehosting'){
        $panel_array['panel_title'] = 'Provide Hosting CP Login';
        $panel_array['panel_intro'] = 'Provide your web hosting login details (24 hour forced expiry)';
        $panel_array['panel_help'] = 'Your login details for your web hosting will be sent to WebTechGlobal database via a Web Service, created using SOAP. They will automatically be deleted after 24 hours, unless you opt otherwise. You can only opt otherwise if you check the box that states that the account is of a type that has no value or security risk to business, data or files or anything similiar. The option of not having an expiry is needed if I plan to work on your site and need hosting access for many days.'; 
    }else{
        $panel_array['panel_title'] == 'Contact Zara Walsh';
        $panel_array['panel_intro'] = 'Contact the developer of '.$csv2post_plugintitle.' for support or general questions';
        $panel_array['panel_help'] = 'Tickets are giving priority and are recommended as it stores a history of all contact. Gold members are giving priority over Silver members also.'; 
    }?>
        
    <h3 class="hndle"><span><?php echo $panel_array['panel_title'];?></span></h3>

    <div class="inside" id="<?php echo $panel_array['panel_name'];?>-box-inside-icon">
    
        <div class="csv2post_boxintro_div">
            
            <p><strong>Warning: this contact form is not complete, the security features explained are not active. They were require extensive testing and the Web Services are also being improved to handle
            requests from this form. Everything will be sent by email until further notice. If you do not understand the form
            below please send your enquiry to webmaster@webtechglobal.co.uk. </strong></p>
            
            <?php ### @todo adapt the help box to suit the specific reason for contact 
            csv2post_helpbutton_closebox($panel_array);?>
        
        </div>
        <div class="<?php echo WTG_C2P_ABB;?>boxcontent_div">
                       
            <?php 
            // Update any changes to this array on the following page...
            // http://www.webtechglobal.co.uk/blog/wordpress/CSV2POST/wtg-pt-jquery-dialogue-form
            $jsform_set_override = array();
            $jsform_set = csv2post_jqueryform_commonarrayvalues($pageid,$panel_array['tabnumber'],$panel_array['panel_number'],$panel_array['panel_name'],$panel_array['panel_title'],$jsform_set_override);
            $jsform_set['has_options'] = true;// true or false (controls output of selected settings)
            $jsform_set['pageid'] = $pageid;
            $jsform_set['panelnumber'] = $panel_array['panel_number'];
            $jsform_set['panel_name'] = $panel_array['panel_name'];
            $jsform_set['panel_title'] = $panel_array['panel_title'];
            // dialog box, javascript
            $jsform_set['dialogbox_id'] = $jsform_set['panel_name'].$jsform_set['panelnumber'];
            $jsform_set['dialogbox_title'] = 'Send Communication';
            // wtg notice box display
            $jsform_set['noticebox_content'] = 'Do you want to continue sending your communication?';
            // form related
            $jsform_set['form_id'] = WTG_C2P_ABB.'form_id_' .$panel_array['panel_name'];
            $jsform_set['form_name'] = WTG_C2P_ABB.'form_name_'.$panel_array['panel_name'];
            ?>
            
            <?php // begin form and add hidden values
            csv2post_formstart_standard($jsform_set['form_name'],$jsform_set['form_id'],'post','csv2post_form',$csv2post_form_action);
            csv2post_hidden_form_values($csv2post_tab_number,$pageid,$panel_array['panel_name'],$panel_array['panel_title'],$panel_array['panel_number']);
            ?> 
                    
            <input type="hidden" id="<?php echo WTG_C2P_ABB;?>contactreason_frompost" name="<?php echo WTG_C2P_ABB;?>contactreason_frompost" value="<?php echo $contactreason; ?>"> 

            <!-- CONTACT METHODS -->
            <script type="text/javascript">
            $(function(){
                $("#csv2post_contactmethods").multiselect({
                    selectedList: 10
                });
            });
            </script>   

            <?php // decide default contact method (some are web services only)
            $method_email_selected = '';
            $method_ticket_selected = '';
            $method_forum_selected = '';
            $method_testimonialservice_selected = '';        
            if($contactreason == 'pluginhelp'){$method_forum_selected = 'selected="selected"';}
            elseif($contactreason == 'openhire'){$method_email_selected = 'selected="selected"';}            
            elseif($contactreason == 'testimonial'){$method_testimonialservice_selected = 'selected="selected"';}            
            elseif($contactreason == 'bug'){$method_ticket_selected = 'selected="selected"';}            
            elseif($contactreason == 'generaladvice'){$method_email_selected = 'selected="selected"';}            
            elseif($contactreason == 'requestchanges'){$method_forum_selected = 'selected="selected"';}            
            elseif($contactreason == 'requestfeature'){$method_forum_selected = 'selected="selected"';}            
            elseif($contactreason == 'requesttutorial'){$method_forum_selected = 'selected="selected"';}            
            elseif($contactreason == 'affiliateenquiry'){$method_ticket_selected = 'selected="selected"';}
            elseif($contactreason == 'provideftp'){$method_ticket_selected = 'selected="selected"';}
            elseif($contactreason == 'provideadmin'){$method_ticket_selected = 'selected="selected"';}
            elseif($contactreason == 'providemysql'){$method_ticket_selected = 'selected="selected"';}
            elseif($contactreason == 'providehosting'){$method_ticket_selected = 'selected="selected"';}?>    
            <p>
            <!-- http://www.erichynds.com/examples/jquery-ui-multiselect-widget/demos/ -->
            <label for="<?php echo WTG_C2P_ABB;?>contactmethods">Select Contact Methods:</label>
                <select title="Contact Methods" multiple="multiple" name="<?php echo WTG_C2P_ABB;?>contactmethods" id="<?php echo WTG_C2P_ABB;?>contactmethods" class="csv2post_multiselect_menu">
                    <option value="email" selected="selected">Email (private)</option>
                    <option value="ticket" disabled="disabled">Ticket (not available yet)</option>
                    <option value="forum" disabled="disabled">Forum Post (not available yet)</option>
                    <option value="testimonialservice" disabled="disabled">Testimonial Web Service (not available yet)</option>                     
                </select>
            </p>

            <script type="text/javascript">
            $("#csv2post_contactmethods").multiselect().multiselectfilter();
            </script> 

            <?php // CONTACT REASON
            $reason_pluginhelp_selected = '';
            $reason_hire_selected = ''; 
            $reason_testimonial_selected = '';
            $reason_bug_selected = ''; 
            $reason_generaladvice_selected = '';
            $reason_requestchanges_selected = '';
            $reason_requestfeature_selected = '';
            $reason_requesttutorial_selected = '';
            $reason_affiliateenquiry_selected = ''; 
            $reason_provideftp_selected = '';                                                 
            $reason_provideadmin_selected = '';                                                 
            $reason_providemysql_selected = '';                                                
            $reason_providehosting_selected = '';            
                  
            if($contactreason == 'pluginhelp'){$reason_pluginhelp_selected = 'selected="selected"';}
            elseif($contactreason == 'openhire'){$reason_hire_selected = 'selected="selected"';}            
            elseif($contactreason == 'testimonial'){$reason_testimonial_selected = 'selected="selected"';}            
            elseif($contactreason == 'bug'){$reason_bug_selected = 'selected="selected"';}            
            elseif($contactreason == 'generaladvice'){$reason_generaladvice_selected = 'selected="selected"';}            
            elseif($contactreason == 'requestchanges'){$reason_requestchanges_selected = 'selected="selected"';}            
            elseif($contactreason == 'requestfeature'){$reason_requestfeature_selected = 'selected="selected"';}            
            elseif($contactreason == 'requesttutorial'){$reason_requesttutorial_selected = 'selected="selected"';}            
            elseif($contactreason == 'affiliateenquiry'){$reason_affiliateenquiry_selected = 'selected="selected"';}
            elseif($contactreason == 'provideftp'){$reason_provideftp_selected = 'selected="selected"';}
            elseif($contactreason == 'provideadmin'){$reason_provideadmin_selected = 'selected="selected"';}
            elseif($contactreason == 'providemysql'){$reason_providemysql_selected = 'selected="selected"';}
            elseif($contactreason == 'providehosting'){$reason_providehosting_selected = 'selected="selected"';}?>
            
            <script type="text/javascript">
            $(function(){
                $("#<?php echo WTG_C2P_ABB;?>contactreason").multiselect({
                    selectedList: 10
                });
            });
            </script>                                                                                      
                 
            <p><label for="<?php echo WTG_C2P_ABB;?>contactreason">Reason For Contact:</label>
                <select title="Contact Reason" multiple="multiple" name="<?php echo WTG_C2P_ABB;?>contactreason" id="<?php echo WTG_C2P_ABB;?>contactreason" class="csv2post_multiselect_menu">
                    <option value="hire" <?php echo $reason_hire_selected;?>>Hire WebTechGlobal</option>                     
                    <option value="pluginhelp" <?php echo $reason_pluginhelp_selected;?>>Plugin Help</option> 
                    <option value="testimonial" <?php echo $reason_testimonial_selected;?>>Testimonial</option>   
                    <option value="bug" <?php echo $reason_bug_selected;?>>Bug</option>      
                    <option value="generaladvice" <?php echo $reason_generaladvice_selected;?>>General Advice</option>                     
                    <option value="requestchanges" <?php echo $reason_requestchanges_selected;?>>Request Changes</option>                     
                    <option value="requestfeature" <?php echo $reason_requestfeature_selected;?>>Request Feature</option>                    
                    <option value="requesttutorial" <?php echo $reason_requesttutorial_selected;?>>Request Tutorial</option>                    
                    <option value="affiliateenquiry" <?php echo $reason_affiliateenquiry_selected;?>>Affiliate Enquiry</option>                                                 
                    <option value="provideftp" <?php echo $reason_provideftp_selected;?>>Provide FTP</option>                                                 
                    <option value="provideadmin" <?php echo $reason_provideadmin_selected;?>>Provide Admin</option>                                                 
                    <option value="providemysql" <?php echo $reason_providemysql_selected;?>>Provide MySQL</option>                                                 
                    <option value="providehosting" <?php echo $reason_providehosting_selected;?>>Provide Hosting</option>                                                 
                </select>
            </p>
            
             <script type="text/javascript">
            $("#<?php echo WTG_C2P_ABB;?>contactreason").multiselect({
               multiple: false,
               header: "Select an option",
               noneSelectedText: "Select an Option",
               selectedList: 1
            });
            </script>           
            
            <?php // CONTACT PRIORITY
            $include_admin_select = '';
            $include_ftp_select = '';
            $include_hosting_select = '';
            $include_mysql_select = '';
            if($contactreason == 'provideadmin'){$include_admin_select = 'selected="selected"';}
            elseif($contactreason == 'provideftp'){$include_ftp_select = 'selected="selected"';}
            elseif($contactreason == 'providehosting'){$include_hosting_select = 'selected="selected"';}
            elseif($contactreason == 'providemysql'){$include_mysql_select = 'selected="selected"';}                                    
            ?>
            
            <script type="text/javascript">
            $(function(){
                $("#<?php echo WTG_C2P_ABB;?>contactinclude").multiselect({
                    selectedList: 10
                });
            });
            </script> 
             
            <p><label for="<?php echo WTG_C2P_ABB;?>contactinclude">Send Sensitive Data:</label>
                <select title="Basic example" multiple="multiple" name="<?php echo WTG_C2P_ABB;?>contactinclude" id="<?php echo WTG_C2P_ABB;?>contactinclude" class="csv2post_multiselect_menu">                   
                    <option value="admin" <?php echo $include_admin_select;?>>WordpressAdmin Login</option>
                    <option value="ftp" <?php echo $include_ftp_select;?>>FTP</option>
                    <option value="hosting" <?php echo $include_hosting_select;?>>Hosting Login</option>
                    <option value="mysql" <?php echo $include_mysql_select;?>>MySQL Login</option>
                    <option value="none" selected="selected">None</option>  
                </select>
            </p>
            
            <script type="text/javascript">
            $("#<?php echo WTG_C2P_ABB;?>contactinclude").multiselect().multiselectfilter();
            </script>         
            
            
            <!-- CONTACT PRIORITY START -->
            <script type="text/javascript">
            $(function(){
                $("#<?php echo WTG_C2P_ABB;?>contactpriority").multiselect({
                    selectedList: 10
                });
            });
            </script>  
               
            <p><label for="<?php echo WTG_C2P_ABB;?>contactpriority">Priority:</label>
                <select title="Basic example" multiple="multiple" name="<?php echo WTG_C2P_ABB;?>contactpriority" id="<?php echo WTG_C2P_ABB;?>contactpriority" class="csv2post_multiselect_menu">
                    <option value="high">High</option><?php ### @todo make high option for Gold users only ?>
                    <option value="medium" selected="selected">Medium</option>
                    <option value="low">Low</option>                    
                </select>
            </p>               
                        
            <script type="text/javascript">
            $("#<?php echo WTG_C2P_ABB;?>contactpriority").multiselect({
               multiple: false,
               header: "Select an option",
               noneSelectedText: "Select an Option",
               selectedList: 1
            });
            </script>
            
            
            <!-- REST OF FORM -->            

            <p>
                <textarea name="<?php echo WTG_C2P_ABB;?>contactdescription" id="<?php echo WTG_C2P_ABB;?>contactdescription" rows="10" cols="58">Please include further details here</textarea> 
            </p>
            
            <?php 
            ### @todo user jquery to allow user to add as many link fields as they need
            ### @todo validate links, still send them but also add note to output to let user know 
            ?>
            
            <p><label for="<?php echo WTG_C2P_ABB;?>linkone">Link 1:</label><input type="text" name="<?php echo WTG_C2P_ABB;?>linkone" id="<?php echo WTG_C2P_ABB;?>linkone" value="" size="60" /></p>
                
            <p><label for="<?php echo WTG_C2P_ABB;?>linkone">Link 2:</label><input type="text" name="<?php echo WTG_C2P_ABB;?>linktwo" id="<?php echo WTG_C2P_ABB;?>linktwo" value="" size="60" /></p>
                            
            <p><label for="<?php echo WTG_C2P_ABB;?>linkone">Link 3:</label><input type="text" name="<?php echo WTG_C2P_ABB;?>linkthree" id="<?php echo WTG_C2P_ABB;?>linkthree" value="" size="60" /></p>                 
                                
            <?php
            // add the javascript that will handle our form action, prevent submission and display dialog box
            csv2post_jqueryform_singleaction_middle($jsform_set,$csv2post_options_array);

            // add end of form - dialog box does not need to be within the <form>
            csv2post_formend_standard('Submit',$jsform_set['form_id']);?>

            <?php csv2post_jquery_form_prompt($jsform_set);?>

            <br /><br /> 
            
            <?php // Display help content
            #### REMOVE THIS IFRAME, THESE GET PICKED UP AS A SECURITY ISSUE IN WORDPRESS PLUGINS AND WE DONT WANT TO RISK IT
            if($contactreason == 'bug'){?>
            
                <div id="titles" class="postbox"> 
                    <div class="handlediv" title="Click to toggle"><br /></div> 
                        <h3 class="hndle"><span>Writing A Good Bug/Fault Report</span></h3> 
                        <div class="inside"> 
                        <!-- Start Panel Content Here -->
                        <iframe src="http://www.webtechglobal.co.uk/blog/wordpress/wtg-csv-importer/writing-a-good-bugfault-report" width="100%" height="600">
                        <p>Your browser does not support iframes.</p>
                        </iframe>
                        <!-- End Panel Content Here -->            
                    </div>
                </div>
                
            <?php }?>

<?php csv2post_panel_footer();?> 
