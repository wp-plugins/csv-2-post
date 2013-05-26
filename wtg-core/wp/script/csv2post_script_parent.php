<?php
if($side == 'public'){  
    
}elseif($side == 'admin'){
                 
    require_once('csv2post_script_admin_jqueryui.php');

    function csv2post_ADDACTION_admin_init_registered_scripts() {
        global $csv2post_currentversion;
        
        $version = 'latest';// wordpress - stable - (nothing in between yet) - latest:gets from google
                
        // this version approach is a quick fix, I plan to make full transition to 1.9.1 once WP 3.6 has been released
        if( csv2post_get_wp_version() < '3.6' ){
            wp_deregister_script( 'jquery' );
            wp_register_script( 'jquery','http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');                
        }else{
            wp_register_script( 'jquery191','http://code.jquery.com/jquery-1.9.1.js');
        }

        wp_deregister_script( 'jquery-ui' );
        //wp_register_script( 'jquery-ui');     
        wp_register_script( 'jquery-ui', 'http://code.jquery.com/ui/1.10.2/jquery-ui.js',array('jquery')); 

        #####################################################################################
        #                                                                                   #
        #                        SCRIPTS NOT PACKAGED WITH WORDPRESS                        #
        #                                                                                   #
        #####################################################################################
        // multi-select (lists, not the same as multiselect menus)
        if($version == 'original'){
            wp_register_script('jquery-multi-select',WTG_C2P_URL.'wtg-core/wp/script/multi-select-basic/jquery.multi-select.js',array('jquery'));
        }elseif($version == 'latest'){ 
            wp_register_script('jquery-multi-select','https://raw.github.com/lou/multi-select/master/js/jquery.multi-select.js',array('jquery'));
        }    

        // multi-select (lists, not the same as multiselect menus)
        if($version == 'original'){
            wp_register_script('jquery-cookie',WTG_C2P_URL.'wtg-core/wp/script/jquery.cookie.js',array('jquery'));
        }elseif($version == 'latest'){ 
            wp_register_script('jquery-cookie','https://raw.github.com/carhartl/jquery-cookie/master/jquery.cookie.js',array('jquery'));
        }    
    }
       
    /**
    * Enqueues scripts using Wordpress functions.
    * This is where new .js files should be added. 
    */
    function csv2post_print_admin_scripts() {
        global $csv2post_currentversion;
                    
         // $csv2post_js_switch and similiar variables set in main file
         $csv2post_js_switch = true;
         if($csv2post_js_switch == true){

            if( csv2post_get_wp_version() < '3.6' ){
                wp_enqueue_script('jquery');    
            }else{
                wp_enqueue_script('jquery191');    
            }
  
            wp_enqueue_script('jquery-ui');
            wp_enqueue_script('jquery-ui-widget');
            wp_enqueue_script('jquery-ui-button');
            wp_enqueue_script('jquery-ui-tabs');
            wp_enqueue_script('jquery-ui-dialog');
            wp_enqueue_script('jquery-ui-datepicker');
            wp_enqueue_script('jquery-ui-slider'); 
             
            #####################################################################################
            #                                                                                   #
            #                        SCRIPTS NOT PACKAGED WITH WORDPRESS                        #
            #                                                                                   #
            #####################################################################################
                    
            // multi-select (side by side selectable style lists, not the same as multiselect menus)
            wp_enqueue_script('jquery-multi-select');
            
            // multi-select (lists, not the same as multiselect menus)
            wp_enqueue_script('jquery-cookie');  
         }
    }

   
    /**
     * Required for help button, displays dialog box (no buttons included inside box)
     * Called in csvip_helpbutton
     * @param integer or string $id (usually the total of number of uses of the help button already)
     */
    function csv2post_jquery_opendialog($id){?>
	<script>
	// increase the default animation speed to exaggerate the effect
	$.fx.speeds._default = 1000;
	$(function() {
		$( "#<?php echo WTG_C2P_ABB;?>dialog<?php echo $id;?>" ).dialog({
			autoOpen: false,
			show: "blind",
			hide: "clip",
            modal: false,
			minWidth: 575
		});

		$( "#<?php echo WTG_C2P_ABB;?>opener<?php echo $id;?>" ).click(function() {
			$( "#<?php echo WTG_C2P_ABB;?>dialog<?php echo $id;?>" ).dialog( "open" );
			return false;
		});
	});
	</script><?php
    }

    /**
     * Dialogue with 2 buttons, for confirming the forms button action
     * Called in csvip_helpbutton
     * @param integer or string $id (usually the total of number of uses of the help button already)
     * @param array $formobjects_array (array of form input IDs and related information for building content)
     */
    function csv2post_jquery_opendialog_contact($jsform_set){

        // you can find possible values passed by jqueryform_settings here...
        // http://www.webtechglobal.co.uk/blog/wordpress/wtg-plugin-template/wtg-pt-jquery-dialogue-form
        extract( shortcode_atts( array(
        'has_options' => false,
        'pageid' => 0,
        'panelnumber' => 0,
        'panel_name' => 'nopanelname',
        'panel_title' => 'No Panel Name',
        'dialogbox_title' => '$dialoguebox_title has not been set',
        'dialogbox_height' => false,
        'dialogbox_width' => false,
        'dialogbox_autoresize' => false,        
        'dialoguebox_id' => WTG_C2P_ABB . 'ERROR',
        'noticebox_content' => '$dialogbox_content has not been set',
        'noticebox_type' => 'question',
        'noticebox_size' => 'Small',
        'form_id' => WTG_C2P_ABB.'form_id_exampleonly',
        'form_name' => WTG_C2P_ABB.'form_name_exampleonly',
        'acceptbutton' => 'Submit',
        'cancelbutton' => 'Cancel',
        ), $jsform_set ) );?>

        <script>
        $(function(){
            var form_id = "<?php echo $form_id; ?>";
            var form_name = "<?php echo $form_name; ?>";
            var dialog_id = "<?php echo $jsform_set['dialogbox_id']; ?>";

            // auto resize dialog box or not
            // apply auto resize if height and width is set to false
            <?php if($dialogbox_autoresize || !$dialogbox_height && !$dialogbox_width){?>

                $(<?php echo '"#'.$jsform_set['dialogbox_id'].'"'; ?>).dialog(
                  "resize", "auto"
                 );

            <?php }?>

            // display dialog box
            $(<?php echo '"#'.$jsform_set['dialogbox_id'].'"'; ?>).dialog({
                autoOpen: false,
                modal: false,
                width: 800,
                resizable: true,
                buttons: {                    
                    "<?php echo $acceptbutton; ?>": function() {
                        document.<?php echo $form_name; ?>.submit();
                        $(this).dialog("close");
                    },
                    "<?php echo $cancelbutton; ?>": function() {
                        $(this).dialog("close");
                    }
                }
            });

            // prevent form submission, display dialog box instead
            $(<?php echo '"#'.$form_id.'_formbutton"'; ?>).click(function(e){
                e.preventDefault();
           
                <?php
                    //echo '$("td#showinput-'.$ID.'").html($("input#'.$ID.'").val());';
                ?>

                $(<?php echo '"#'.$jsform_set['dialogbox_id'].'"'; ?>).dialog('open');
            });
        });
        </script><?php
    }      
    
    /**
     * Dialogue with 2 buttons, for confirming the forms button action
     * Called in csvip_helpbutton
     * @param integer or string $id (usually the total of number of uses of the help button already)
     * @param array $formobjects_array (array of form input IDs and related information for building content)
     */
    function csv2post_jquery_opendialog_confirmformaction($jsform_set,$formobjects_array){

        extract( shortcode_atts( array(
        'has_options' => false,
        'pageid' => 0,
        'panel_number' => 0,
        'panel_name' => 'nopanelname',
        'panel_title' => 'No Panel Name',
        'dialogbox_title' => '$dialogbox_title has not been set',
        'dialogbox_height' => false,
        'dialogbox_width' => false,
        'dialogbox_autoresize' => false,
        'noticebox_content' => '$dialogbox_content has not been set',
        'noticebox_type' => 'question',
        'noticebox_size' => 'Small',
        'form_id' => 'csv2post_form_id_exampleonly',
        'form_name' => 'csv2post_form_name_exampleonly',
        ), $jsform_set ) );?>

        <script>
        $(function(){
            var form_id = "<?php echo $form_id; ?>";
            var form_name = "<?php echo $form_name; ?>";
            var dialogue_id = "<?php echo $jsform_set['dialogbox_id']; ?>";

            // auto resize dialog box or not
            // apply auto resize if height and width is set to false
            <?php if($dialogbox_autoresize || !$dialogbox_height && !$dialogbox_width){?>
                        
                $(<?php echo '"#'.$jsform_set['dialogbox_id'].'"'; ?>).dialog(
                  "resize", "auto"
                 );

            <?php }?>

            // display dialog box
            $(<?php echo '"#'.$jsform_set['dialogbox_id'].'"'; ?>).dialog({
                autoOpen: false,
                modal: false,
                width: 800,
                resizable: true,
                buttons: {
                    "Submit": function() {
                        <?php echo 'document.'.$form_name.'.submit();'; ?>
                    },
                    "Cancel": function() {
                        $(this).dialog("close");
                    }
                }
            });

            // prevent form submission, display dialog box instead
            $(<?php echo '"#'.$form_id.'_formbutton"'; ?>).click(function(e){
                e.preventDefault();

                <?php
                // TODO: MEDIUMPRIORITY, improve dialog information using inputs, can use this to display values user selected
                // loop through the giving array of input ID's
                /*
                 *       $formobjects_array['testid1']['label'] = 'Test Name One';
                 *       $formobjects_array['testid1']['name'] = 'testname1';
                 *       $formobjects_array['testid1']['type'] = 'hidden';
                 */
                //foreach( $formobjects_array as $ID => $parameter){
                    // build form input ID as used in form html per input
                    //$ID = $panel_name.$panelnumber.$arraykey;
                    //echo '$("td#showinput-'.$ID.'").html($("input#'.$ID.'").val());';
                //}
                ?>

                $(<?php echo '"#'.$jsform_set['dialogbox_id'].'"'; ?>).dialog('open');
            });
        });
        </script><?php
    }              

    /**
    * Displays help button in panels with but report and bookmark option also
    * 
    * @param mixed $panel_number
    * @param mixed $panel_title
    * @param mixed $panel_help
    * @param mixed $panel_icon
    * @param mixed $panel_name
    * 
    * @deprecated 16th February 2013
    */
    function csv2post_jquery_opendialog_helpbutton($panel_number,$panel_title,$panel_help,$panel_icon,$panel_name,$panel_url){
       global $csv2post_adm_set;?>
        
        <script>
        $(function() {
            
            $("#csv2post_helpbutton-<?php echo $panel_number;?>" ).dialog({
                autoOpen: false,
                resizable: true,                
                <?php echo 'height:300,';?>
                <?php echo 'width:800,';?>
                modal: false,
                buttons: {                    
                    "View More Help": function() {
                        window.open("<?php echo $panel_url;?>", '_blank', '');       
                        $(this).dialog("close");
                    },                                        
                    "Close": function() {
                        $( this ).dialog( "close" );
                    }        
                }
            });

            $( "#csv2post_opener<?php echo $panel_number;?>" ).click(function() {
                $( "#csv2post_helpbutton-<?php echo $panel_number;?>" ).dialog( "open" );
                return false;
            });
        });
        </script><?php
    }
   
    /**
    * Displays help button in panels with but report and bookmark option also
    * 
    * @param mixed $panel_ID
    * @param mixed $panel_title
    * @param mixed $panel_help
    * @param mixed $panel_icon
    * @param mixed $panel_name
    */
    function csv2post_jquery_opendialog_accordianpanel_button($button_type,$panel_number,$panel_title,$panel_help,$panel_icon,$panel_name,$panel_url){
       global $csv2post_adm_set;?>
        
        <script>
        $(function() {
            
            $("#csv2post_accordianpanelbutton_<?php echo $panel_number.$button_type;?>" ).dialog({
                autoOpen: false,
                resizable: true,                
                <?php echo 'height:600,';?>
                <?php echo 'width:800,';?>
                modal: false,
                buttons: {                    
                    "View More Help": function() {
                        window.open("<?php echo $panel_url;?>", '_blank', '');       
                        $(this).dialog("close");
                    },                                        
                    "Close": function() {
                        $( this ).dialog( "close" );
                    }        
                }
            });

            $( "#csv2post_opener<?php echo $panel_number.$button_type;?>" ).click(function() {
                $( "#csv2post_accordianpanelbutton_<?php echo $panel_number.$button_type;?>" ).dialog( "open" );
                return false;
            });
        });
        </script><?php
    }   
    
    /**
     * Dialogue for button that requires a url sending button, mainly used as part of form process results output
     * but can use as an alternative to $_POST by passing values through url
     * 
     * @deprecated 18th October 2012 we will not display a dialog as part of form submission result
     */
    function csv2post_jquerydialog_results($documentlocation = 'default',$buttontext = 'Click Here'){?>

        <script>
        $(function() {
            $( "#<?php echo WTG_C2P_ABB;?>dialogoutcome" ).dialog({
                autoOpen: true,
                resizable: false,
                width:800,
                autoResize: true,
                modal: false,
                buttons: { 
                
                    <?php if($documentlocation == 'default'){ ?>
                  
                        "Close": function() {
                            $( this ).dialog( "close" );
                        }

                    <?php }else{ ?>                     
                        
                        <?php echo '"'.$buttontext.'"'; ?>: function() {
                            document.location = '<?php echo $documentlocation;?>';
                        },              
                        
                    <?php } ?> 
                    
                }
            });
        });
        </script><?php
    }   
}
?>
