<?php
/*
 * Title: TEMPLATE System Script Parent File
 *
 * Description: Called by wtgcsv_scripts($side), Javascript arguments, registration processed here.
 * 
 * Original Author: Zara Walsh
 *
 * Site: http://www.importcsv.eu 
 *
 * Created: 05/09/2011

 * TODO: MEDIUMPRIORITY, would it be worth loading scripts only when visiting pages that require them?
 * TODO: LOWPRIORITY, investigate the use of min files, is it worth replacing all or having a copy of each in package?
 */
if($side == 'admin'){
                 
    require_once('wtgcsv_script_admin_jqueryui.php');
   
    /**
     * jQuery script for styling button with roll over effect
     * @see function wtgcsv_header_page()
     */
    function wtgcsv_jquery_button(){?>
        <script>
            $(function() {
                $( "button, input:submit, a", ".jquerybutton" ).button();
                $( "a", ".jquerybutton" ).click(function() { return false; });
            });
        </script><?php
    }

    /**
     * Required for help button, displays dialogue box (no buttons included inside box)
     * Called in csvip_helpbutton
     * @param integer or string $id (usually the total of number of uses of the help button already)
     */
    function wtgcsv_jquery_opendialog($id){?>
	<script>
	// increase the default animation speed to exaggerate the effect
	$.fx.speeds._default = 1000;
	$(function() {
		$( "#<?php echo WTG_CSV_ABB;?>dialog<?php echo $id;?>" ).dialog({
			autoOpen: false,
			show: "blind",
			hide: "clip",
            modal: true,
			minWidth: 575
		});

		$( "#<?php echo WTG_CSV_ABB;?>opener<?php echo $id;?>" ).click(function() {
			$( "#<?php echo WTG_CSV_ABB;?>dialog<?php echo $id;?>" ).dialog( "open" );
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
    function wtgcsv_jquery_opendialog_contact($jsform_set){

        // you can find possible values passed by jqueryform_settings here...
        // http://www.webtechglobal.co.uk/blog/wordpress/wtg-plugin-template/wtg-pt-jquery-dialogue-form
        extract( shortcode_atts( array(
        'has_options' => false,
        'pageid' => 0,
        'panelnumber' => 0,
        'panel_name' => 'nopanelname',
        'panel_title' => 'No Panel Name',
        'dialoguebox_title' => '$dialoguebox_title has not been set',
        'dialoguebox_height' => false,
        'dialoguebox_width' => false,
        'dialoguebox_autoresize' => false,        
        'dialoguebox_id' => WTG_CSV_ABB . 'ERROR',
        'noticebox_content' => '$dialoguebox_content has not been set',
        'noticebox_type' => 'question',
        'noticebox_size' => 'Small',
        'form_id' => WTG_CSV_ABB.'form_id_exampleonly',
        'form_name' => WTG_CSV_ABB.'form_name_exampleonly',
        'acceptbutton' => 'Submit',
        'cancelbutton' => 'Cancel',
        ), $jsform_set ) );?>

        <script>
        $(function(){
            var form_id = "<?php echo $form_id; ?>";
            var form_name = "<?php echo $form_name; ?>";
            var dialogue_id = "<?php echo $jsform_set['dialoguebox_id']; ?>";

            // auto resize dialogue box or not
            // apply auto resize if height and width is set to false
            <?php if($dialoguebox_autoresize || !$dialoguebox_height && !$dialoguebox_width){?>

                $(<?php echo '"#'.$jsform_set['dialoguebox_id'].'"'; ?>).dialog(
                  "resize", "auto"
                 );

            <?php }?>

            // display dialogue box
            $(<?php echo '"#'.$jsform_set['dialoguebox_id'].'"'; ?>).dialog({
                autoOpen: false,
                modal: true,
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

            // prevent form submission, display dialogue box instead
            $(<?php echo '"#'.$form_id.'_formbutton"'; ?>).click(function(e){
                e.preventDefault();
           
                <?php
                    //echo '$("td#showinput-'.$ID.'").html($("input#'.$ID.'").val());';
                ?>

                $(<?php echo '"#'.$jsform_set['dialoguebox_id'].'"'; ?>).dialog('open');
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
    function wtgcsv_jquery_opendialog_confirmformaction($jsform_set,$formobjects_array){

        extract( shortcode_atts( array(
        'has_options' => false,
        'pageid' => 0,
        'panel_number' => 0,
        'panel_name' => 'nopanelname',
        'panel_title' => 'No Panel Name',
        'dialoguebox_title' => '$dialoguebox_title has not been set',
        'dialoguebox_height' => false,
        'dialoguebox_width' => false,
        'dialoguebox_autoresize' => false,
        'noticebox_content' => '$dialoguebox_content has not been set',
        'noticebox_type' => 'question',
        'noticebox_size' => 'Small',
        'form_id' => 'wtgcsv_form_id_exampleonly',
        'form_name' => 'wtgcsv_form_name_exampleonly',
        ), $jsform_set ) );?>

        <script>
        $(function(){
            var form_id = "<?php echo $form_id; ?>";
            var form_name = "<?php echo $form_name; ?>";
            var dialogue_id = "<?php echo $jsform_set['dialoguebox_id']; ?>";

            // auto resize dialogue box or not
            // apply auto resize if height and width is set to false
            <?php if($dialoguebox_autoresize || !$dialoguebox_height && !$dialoguebox_width){?>
                        
                $(<?php echo '"#'.$jsform_set['dialoguebox_id'].'"'; ?>).dialog(
                  "resize", "auto"
                 );

            <?php }?>

            // display dialogue box
            $(<?php echo '"#'.$jsform_set['dialoguebox_id'].'"'; ?>).dialog({
                autoOpen: false,
                modal: true,
                width: 800,
                resizable: true,
                buttons: {
                    "Submit": function() {
                        document.<?php echo $form_name; ?>.submit();
                    },
                    "Cancel": function() {
                        $(this).dialog("close");
                    }
                }
            });

            // prevent form submission, display dialogue box instead
            $(<?php echo '"#'.$form_id.'_formbutton"'; ?>).click(function(e){
                e.preventDefault();

                <?php
                // TODO: MEDIUMPRIORITY, improve dialogue information using inputs
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

                $(<?php echo '"#'.$jsform_set['dialoguebox_id'].'"'; ?>).dialog('open');
            });
        });
        </script><?php
    }              

    /**
    * Displays help button in panels with but report and bookmark option also
    * 
    * @param mixed $panel_number
    * @param mixed $panel_intro
    * @param mixed $panel_title
    * @param mixed $panel_help
    * @param mixed $panel_icon
    * @param mixed $panel_name
    */
    function wtgcsv_jquery_opendialog_helpbutton($panel_number,$panel_intro,$panel_title,$panel_help,$panel_icon,$panel_name,$panel_url){
       global $wtgcsv_adm_set;?>
        
        <script>
        $(function() {
            
            $("#wtgcsv_helpbutton-<?php echo $panel_number;?>" ).dialog({
                autoOpen: false,
                resizable: true,
                //TODO: height:<?php echo $wtgcsv_adm_set['ui_helpdialogue_height'];?>,
                //TODO: width:<?php echo $wtgcsv_adm_set['ui_helpdialogue_width'];?>,                
                height:<?php echo '300';?>,
                width:<?php echo '800';?>,
                modal: true,
                buttons: {                    
                    "View More Help": function() {
                        document.location = '<?php echo $panel_url;?>';       
                        $(this).dialog("close");
                    },                                        
                    "Close": function() {
                        $( this ).dialog( "close" );
                    }        
                }
            });

            $( "#wtgcsv_opener<?php echo $panel_number;?>" ).click(function() {
                $( "#wtgcsv_helpbutton-<?php echo $panel_number;?>" ).dialog( "open" );
                return false;
            });
        });
        </script><?php
    }
   
    
    /**
     * Dialogue for button that requires a url sending button, mainly used as part of form process results output
     * but can use as an alternative to $_POST by passing values through url
     */
    function wtgcsv_jquerydialogue_results($documentlocation = 'default',$buttontext = 'Click Here'){?>

        <script>
        $(function() {
            $( "#<?php echo WTG_CSV_ABB;?>dialogueoutcome" ).dialog({
                autoOpen: true,
                resizable: false,
                width:800,
                autoResize: true,
                modal: true,
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
