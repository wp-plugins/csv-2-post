<?php
/**
* Determines if domain owner is subscribing (currently effects premium support services, bonus downloads, extra credits etc)
* Subscription is not required for activation of full edition, that requires membership (which does not need annual payments)
* 
* @return boolean
*/
function csv2post_is_subscribed(){
    global $csv2post_is_domainregistered;
                     
    // is domain registered and has user giving permission for email authorisation
    if($csv2post_is_domainregistered === true){
   
        $function_boolean_result = false;
        
        // begin result array defaults
        $soapcall_result_array = array();
        $soapcall_result_array['result'] = true;
        $soapcall_result_array['rejected'] = false;
        $soapcall_result_array['rejectedreason'] = 'Not Rejected';        
        
        // use domain to make a call to web services
        $soapcall_result_array = csv2post_SOAP_checksubscriptionstatus_for_domain();
        $soapcall_result_array['result'] = true;
        $soapcall_result_array['rejected'] = false;
        $soapcall_result_array['rejectedreason'] = 'Not Rejected';
         
         return $soapcall_result_array['result'];         
    }
    
    return false;// default if domain not registered or user never gave permissions for email authorisation
}

/**
* Uses SOAP CALL to determine if the last code code is valid and not expired
* 
* @param mixed $csv2post_callcode
* @global $csv2post_callcode, set in main file
*/
function csv2post_is_callcodevalid(){
    global $csv2post_callcode;
               
    $soapcall_result_array = array();
    $soapcall_result_array = csv2post_SOAP_validate_call_code($csv2post_callcode);
                   
    if( $soapcall_result_array['resultcode'] == 2 ){
        return false;
    }elseif( $soapcall_result_array['resultcode'] == 3 ){        
        return true;
    }else{
        return false;
    }    
}

/**
* First function to calling web services and confirming domain registered for use with plugin
*/
function csv2post_is_domainregistered(){
    
    $soapcall_result_array = array();
    $soapcall_result_array = csv2post_SOAP_confirm_current_domain_is_registered();
    
    if( $soapcall_result_array['resultcode'] == 2 ){
        return false;
    }elseif( $soapcall_result_array['resultcode'] == 3 ){

        // store call code - common use after this function is for generating activation code
        csv2post_update_callcode($soapcall_result_array['callcode']);
        
        return true;
    }else{
        return false;
    }
}

/**
* Stores call code in Wordpress options table
*/
function csv2post_update_callcode($callcode){
    return update_option(WTG_C2P_ABB . 'callcode',$callcode);
}

/**
* Gets the call code record if it exists 
*/
function csv2post_get_callcode(){
    return get_option(WTG_C2P_ABB . 'callcode');                       
}

/**
* Standard interface response to SOAP faults
* 
* @param string $soapcallfunction, the function name that called soap and cause fault
*/
function csv2post_soap_fault_display($soapcallfunction){
    csv2post_notice('Sorry there was a problem contacting WebTechGlobal Web Services for Wordpress.
    Please report this notice with the following information: SOAP Call Function '.$soapcallfunction.'
    returned "soapfault". I think you for your patience. Please repeat your action again while you wait on a
    response as it may be caused by maintenance on the WebTechGlobal site.','error','Extra','WebTechGlobal Web Service Fault');    
}

/**
* Stores _apiauthmethod in Wordpress options table using update_option   (uses update_option not add_option)         
*/
function csv2post_add_is_emailauthorised($authmethod){
    return update_option(WTG_C2P_ABB.'isemailauthorised',$authmethod);          
}

/**
* Returns result from get_option(_activationkey)
*/
function csv2post_get_activationcode(){
    return get_option(WTG_C2P_ABB.'activationcode');   
}

/**
* Updates activation code
* @todo MEDIUMPRIORITY, add these option records to the options array as none public option records
*/
function csv2post_update_activationcode($activationcode){
    return update_option(WTG_C2P_ABB.'activationcode',$activationcode);  
}

/**
* Adds activation code (uses update_option not add_option)
*/
function csv2post_add_activationcode($activationcode){
    return update_option(WTG_C2P_ABB.'activationcode',$activationcode);  
}  

/**
* Returns result from get_option(_apiauthmethod)
* 
* @todo MEDIUMPRIORITY, add these option records to the options array as none public option records
*/
function csv2post_get_is_emailauthorised(){
    return get_option(WTG_C2P_ABB.'isemailauthorised');   
}
?>