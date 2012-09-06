<?php
/**
 * jQuery is part of the styled checkboxes (with images)
 */
function wtgcsv_jquery_graphiccheckboxes(){?>
    <script>
    $(document).ready(function() {

            /* see if anything is previously checked and reflect that in the view*/
            $(".checklist input:checked").parent().addClass("selected");

            /* handle the user selections */
            $(".checklist .checkbox-select").click(
                    function(event) {
                            event.preventDefault();
                            $(this).parent().addClass("selected");
                            $(this).parent().find(":checkbox").attr("checked","checked");
                    }
            );

            $(".checklist .checkbox-deselect").click(
                    function(event) {
                            event.preventDefault();
                            $(this).parent().removeClass("selected");
                            $(this).parent().find(":checkbox").removeAttr("checked");
                    }
            );
    });
    </script><?php
}

/**
* Adds styling and script for a standardized list of items showing the status of each i.e. files
* 
* Example Use:
*             <div class="portlet">
*                <div class="portlet-header-2"> <?php echo $fileitem['name'].$pointer.$fileitem['extension'];?> </div>
*                <div class="portlet-content"><?php echo $viewedpath; ?></div>
*            </div><?php 
*        }else{?><div class="portlet">
*                <div class="portlet-header"> <?php echo $fileitem['name'].$pointer.$fileitem['extension'];?> </div>
*                <div class="portlet-content"><?php echo $viewedpath; ?></div>
*            </div> 
*/
function wtgcsv_jquery_status_list_portlets(){?>
     <style>
    .portlet { margin: 0 1em 1em 0; }
    .portlet-header { margin: 0.3em; padding-bottom: 4px; padding-left: 0.2em; color: black; background: #13E848; }
    .portlet-header .ui-icon { float: right; }
    .portlet-content { padding: 0.4em; }
    .ui-sortable-placeholder { border: 1px dotted black; visibility: visible !important; height: 50px !important; }
    .ui-sortable-placeholder * { visibility: hidden; }


    .portlet-header-2 { margin: 0.3em; padding-bottom: 4px; padding-left: 0.2em; color: black; background: red; }      
    .portlet-header-2 .ui-icon { float: right; }

    </style>
    <script>
    $(function() {
        $( ".wtgcsvcolumn" ).sortable({
            connectWith: ".column"
        });

        $( ".portlet" ).addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
            .find( ".portlet-header" )
                .addClass( "ui-widget-header ui-corner-all" )
                .addClass( "mytest1" ) 
                .prepend( "<span class='ui-icon ui-icon-minusthick'></span>")
                .end()
                
            .find( ".portlet-header-2" )
                .addClass( "ui-widget-header ui-corner-all" )
                .addClass( "mytest1" ) 
                .prepend( "<span class='ui-icon ui-icon-minusthick'></span>")
                .end()               
                
            .find( ".portlet-content" )
            .hide()

        $( ".portlet-header .ui-icon" ).click(function() {

            $( this ).toggleClass( "ui-icon-minusthick" ).toggleClass( "ui-icon-plusthick" );
            $( this ).parents( ".portlet:first" ).find( ".portlet-content" ).toggle();
        });
        
        $( ".portlet-header-2 .ui-icon" ).click(function() {

            $( this ).toggleClass( "ui-icon-minusthick" ).toggleClass( "ui-icon-plusthick" );
            $( this ).parents( ".portlet:first" ).find( ".portlet-content" ).toggle();
        });        
        
    });
    </script><?php
}
?>