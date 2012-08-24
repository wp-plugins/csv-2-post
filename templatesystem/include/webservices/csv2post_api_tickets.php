<?php
################################################################
####                                                        ####
####        WebTechGlobal Ticket Web Service - SOAP         ####
####                                                        #### 
####        Purpose of this file is to act as an            #### 
####        extension. Validation, processing,              #### 
####        SOAP calls all included. Call the functions     ####
####        within this file from $_POST Validation file.   ####
####                                                        #### 
################################################################

/**
* Validation function, not SOAP Call (soap calls are at the end of this file) 
* initiates contact of ticket service. Can asign action required, ticket ID to be changed
* and an array of required values.
* 
* @param string $action (create,update,delete,archive,bump,list,view,close,reopen,rate,search)
* @param integer $ticket_id, null if creating ticket or searching else an integer
* @param array mixed $values, requires extra, different values required per action
* @param boolean $output default = true (false hides all output csv2post_notice is not used for example) 
* @uses csv2post_api_ticket_soapcall()
*/
function csv2post_api_webservice_ticket($action,$ticket_id,$values,$output = true){
    global $csv2post_disableapicalls;
    extract($values);
    // validate users subsmitted values
    
    
    // if validation complete do soapcall
    $soapcall_result_array = csv2post_api_ticket_soapcall($action,$ticket_id,$values);   
    

}

####################################
####                            ####
####     TICKET SOAP CALLS      ####
####                            ####
####################################

/**
* put your comment there...
* 
* @param mixed $action
* @param mixed $ticket_id
* @param mixed $values
* 
* @todo WebTechGlobal Ticket Service plugin
*/
function csv2post_api_ticket_soapcall($action,$ticket_id,$values){
    global $csv2post_disableapicalls;    
    ### @todo need to create ticket web service, with database tables
}

?>
