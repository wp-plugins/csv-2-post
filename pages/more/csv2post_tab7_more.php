<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'opentickets';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Open Tickets');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Your ongoing tickets will be listed here with the latest reply being displayed.');
$panel_array['panel_help'] = __('Eventually there will be many ways to create tickets. Any buttons you use that quickly report issues or request a feature will also create a ticket. Some tickets may be automatically generated and some may be created by the plugins support in response to contact you have with them via email or the plugins forum.');
$panel_array['help_button'] = csv2post_helpbutton_text(true,true);
?>
<?php csv2post_panel_header( $panel_array );?>

    <?php
    $open_tickets = array();
    $open_tickets['111']['title'] = 'My First Ticket';
    $open_tickets['111']['lastreply'] = 'The last reply content would go here. We need a form for reply ';
    $open_tickets['222']['title'] = 'My Second Ticket';
    $open_tickets['222']['lastreply'] = 'The last reply content would go here';
    $open_tickets['333']['title'] = 'My Third Ticket';
    $open_tickets['333']['lastreply'] = 'The last reply content would go here';

    $total_tickets = count($open_tickets);

    if($total_tickets == 0){
        wtgcore_notice('You do not have any open tickets', 'info', 'Tiny', false);
    }else{?>

        <script>
        $(function() {
                $( "#<?php echo WTG_C2P_ABB;?>accordion_opentickets" ).accordion();
        });
        </script>

        <div id="<?php echo WTG_C2P_ABB;?>accordion_opentickets">
            
            <?php
            foreach($open_tickets as $ticketkey => $ticket){
                echo '<h3><a href="#">'.$ticket['title'].'</a></h3>
                <div><p>'.$ticket['lastreply'].'</p></div>';
            }
            ?>

        </div><!-- end of accordian wrapper -->
    <?php } ?>

<?php csv2post_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'closedtickets';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Closed Tickets');// user seen panel header text  
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Your previous tickets will be listed here, you can re-open them if needed');
$panel_array['panel_help'] = __('Sometimes the plugins support team may close a ticket if it has been sitting open without a response. You can re-open these tickets at anytime. Feel free to re-open a ticket if the issue covered happens again or you need to clarify some details discussed for example.');
$panel_array['help_button'] = csv2post_helpbutton_text(true,true);?>
<?php csv2post_panel_header( $panel_array );?>

    <?php
    $open_tickets = array();
    $open_tickets['111']['title'] = 'My First Ticket';
    $open_tickets['111']['lastreply'] = 'The last reply content would go here. We need a form for reply ';
    $open_tickets['222']['title'] = 'My Second Ticket';
    $open_tickets['222']['lastreply'] = 'The last reply content would go here';
    $open_tickets['333']['title'] = 'My Third Ticket';
    $open_tickets['333']['lastreply'] = 'The last reply content would go here';

    $total_tickets = count($open_tickets);

    if($total_tickets == 0){
        wtgcore_notice('You do not have any open tickets', 'info', 'Tiny', false);
    }else{?>

        <script>
        $(function() {
                $( "#<?php echo WTG_C2P_ABB;?>accordion_closedtickets" ).accordion();
        });
        </script>

        <div id="<?php echo WTG_C2P_ABB;?>accordion_closedtickets">

            <?php
            foreach($open_tickets as $ticketkey => $ticket){
                echo '<h3><a href="#">'.$ticket['title'].'</a></h3>
                <div><p>'.$ticket['lastreply'].'</p></div>';
            }
            ?>

        </div><!-- end of accordian wrapper -->
    <?php } ?>

 <?php csv2post_panel_footer();?> 

<?php
++$panel_number;// increase panel counter so this panel has unique ID
$panel_array = csv2post_SETTINGS_panel_array($pageid,$panel_number,$csv2post_tab_number);
$panel_array['panel_name'] = 'createtickets';// slug to act as a name and part of the panel ID 
$panel_array['panel_title'] = __('Create Tickets');// user seen panel header text 
$panel_array['panel_id'] = $panel_array['panel_name'].$panel_number;// creates a unique id, may change from version to version but within a version it should be unique
$panel_array['panel_intro'] = __('Create a support ticket to get more help.');
$panel_array['panel_help'] = __('The support ticket is very new and basic but this will change. One of my highest prioritise is improving customer service and support tools. I have created my own ticket plugin for the WebTechGlobal blog and this is what is used to manage your ticket submissions.');
$panel_array['help_button'] = csv2post_helpbutton_text(true,true);?>
<?php csv2post_panel_header( $panel_array );?>

    <p>You have not made any requests.</p>

<?php csv2post_panel_footer();?> 
