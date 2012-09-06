<?php
// include api functions for individual services
if(is_admin()){require_once(WTG_CSV_DIR.'templatesystem/include/webservices/wtgcsv_api_tickets.php');}

/**
* General status check on WebTechGlobal Web Services (online or offline)
* 
* @todo CRITICAL, causing SOAP response error
* @todo CRITICAL, causing SOAP response error 
*/
function wtgcsv_api_webservices_status_soapcall(){
                 
    // todo, LOWPRIORITY, add these lines to all api functions
    global $wtgcsv_disableapicalls;
    if($wtgcsv_disableapicalls){ 
        return 'soapcallsoff'; 
    }
    
    // is webtechglobal.co.uk is online
    $domain_result = wtgcsv_domain_online('http://www.importcsv.eu');
    if($domain_result == false){ 
        return 'siteoffline';     
    }                            
       
    // now contact webtechglobal web services for wordpress and confirm online
    $client = new SoapClient(null, array(
    'location' => "http://www.importcsv.eu/wordpresswebservices/wtgapi_status.php",
    'uri'      => "http://www.importcsv.eu/wordpresswebservices/request/"));


    $soapcall_result_array = $client->wtgapi_status_public(); 
    

    return wtgcsv_soapresponse( $soapcall_result_array );   
}

/**
* Ensures response is always the standard SOAP Call Response array
* i.e. if the soap call fails due to error, this ensures
* 
* @param mixed $soapcall_result_array
* @return array, $soapcall_result_array
*/
function wtgcsv_soapresponse( $soapcall_result_array ){

    if (is_soap_fault($soapcall_result_array)) {
        
        ### TODO, replace this line with a persistent none displayed notice, not echo or return
        //echo '<br /><br />is_soap_fault in ' . __FILE__ . ' Line: ' . __LINE__ .' Function: ' . __FUNCTION__;        
     
        return wtgapi_responsearray_initiate();
        
    }else{
     
        return $soapcall_result_array; 
    }                      
}  

/**
* SOAP CALL - determines if giving $callcode is valid and not expired, returns standard web service array
* 
* @param mixed $callcode
* @return array,
*/
function wtgcsv_validate_call_code($callcode){
    $client = new SoapClient(null, array(
    'location' => "http://www.importcsv.eu/wordpresswebservices/wtgapi_webservice_validatecallcode.php",
    'uri'      => "http://www.importcsv.eu/wordpresswebservices/request/"));
    $soapcall_result_array = $client->wtgapi_webservice_validatecallcode_SOAPCALL($callcode,$_SERVER['HTTP_HOST'],$_SERVER['SERVER_NAME']);
    return wtgcsv_soapresponse( $soapcall_result_array );       
}

/**
* Uses SOAP call to determine if current domain is registered or not
* 
* This is part one of full edition installation security check, part two is based on call authorisation code
* 
* @todo HIGHPRIORITY, server needs call authorisation code check, check to see if a code is used before and after a different code for the same domain. 
* The first code would be considered genuine, the second would be considered made by another domain, a hack.
* 
* @return array, $soapcall_result_array
*/
function wtgcsv_confirm_current_domain_is_registered(){

    $client = new SoapClient(null, array(
    'location' => "http://www.importcsv.eu/wordpresswebservices/wtgapi_webservice_checkdomainisregistered.php",
    'uri'      => "http://www.importcsv.eu/wordpresswebservices/request/"));
    
    $soapcall_result_array = $client->wtgapi_confirm_domain_is_registered_SOAPCALL($_SERVER['HTTP_HOST'],$_SERVER['SERVER_NAME'],WTG_CSV_ID);
        
    return wtgcsv_soapresponse( $soapcall_result_array );
}
    
/**
* Checks if the domain has a paid subscription, the result will be used to extend services further on plugin interface
* 
* @return array, webtechglobal web services standard response array, to be processed by the function calling this
*/
function wtgcsv_api_checksubscriptionstatus_for_domain(){
    
    ### TODO: HIGHPRIORITY, ENSURE ACTIVATION CODE COMES AFTER DOMAIN CHECK 
    global $wtgcsv_activationcode;
    
    $client = new SoapClient(null, array(
    'location' => "http://www.importcsv.eu/wordpresswebservices/wtgapi_webservice_checkdomainhassubscription.php.php",
    'uri'      => "http://www.importcsv.eu/wordpresswebservices/request/"));

    $soapcall_result_array = $client->wtgapi_checksubscriptionstatus_for_domain_SOAPCALL( $_SERVER['HTTP_HOST'],$_SERVER['SERVER_NAME'],WTG_CSV_ID,$wtgcsv_activationcode); 
       
    return wtgcsv_soapresponse( $soapcall_result_array );     
}

/**
* NOT YET IN USE
* 
* @param mixed $activationcode
*/
function wtgcsv_api_is_activationcodevalid_soapcall( $activationcode ){
    $client = new SoapClient(null, array(
    'location' => "http://www.importcsv.eu/wordpresswebservices/wtgapi_pluginactivation_calls.php",
    'uri'      => "http://www.importcsv.eu/wordpresswebservices/request/"));
    $soapcall_result_array = $client->wtgapi_validateactivationcode( $http_host,$server_name,$itemid,$activationcode ); 
    return wtgcsv_soapresponse( $soapcall_result_array );    
}

/**
* First function to use before calls to check on session status
* 
* @return boolean
* @uses $wtgcsv_apiservicestatus,$wtgcsv_apisession_array  
*/
function wtgcsv_api_allowed(){
    global $wtgcsv_api_servicestatus,$wtgcsv_api_session_array;
    if($wtgcsv_apisession_array['state'] == 'stop'){
        
        return false;// a stop has been applied to prevent traffic flooding (service may be down for maintenence)
        
    }elseif($wtgcsv_api_session_array['state'] == 'session'){
        
        $expiry = $wtgcsv_api_session_array['seconds'] + time();
        
        if($expiry > time() && $wtgcsv_api_servicestatus == 'online'){
            return true;                        
        }elseif($expiry < time() || $wtgcsv_api_servicestatus == 'offline'){
            return false;   
        }
    }
    return false;// @todo add log entry for this, should not happen
}  
            
/**
* Updates APIKey Session in the Wordpress option table
* 
* @param mixed $seconds
* @param mixed $state
*/
function wtgcsv_api_update_apikeysession($seconds,$state){
    $apikey_session_array = array();
     
    $apikeysession_array['session_seconds'] = $seconds;// duration of access giving  or duration of temporary stopage on all API calls
    $apikeysession_array['session_expirydate'] = wtgcsv_date($seconds);// calculated expiry date and time 
    $apikeysession_array['session_expirytime'] = strtotime(wtgcsv_date($seconds));// calculated expiry date and time 
    $apikeysession_array['session_state'] = $state;// session or stop, a stop will prevent API calls for giving time 
    $apikeysession_array['session_changedate'] = wtgcsv_date(0);// used to calculate if session expired 
    
    update_option(WTG_CSV_ABB.'apisession',$apikey_session_array);    
}

/**
* Stores _apiauthmethod in Wordpress options table using update_option   (uses update_option not add_option)         
*/
function wtgcsv_add_is_emailauthorised($authmethod){
    return update_option(WTG_CSV_ABB.'isemailauthorised',$authmethod);          
}

/**
* Returns result from get_option(_apiauthmethod)
* 
* @todo MEDIUMPRIORITY, add these option records too the options array as none public option records
*/
function wtgcsv_get_is_emailauthorised(){
    return get_option(WTG_CSV_ABB.'isemailauthorised');   
}

/**
* Returns result from get_option(_activationkey)
*/
function wtgcsv_get_activationcode(){
    return get_option(WTG_CSV_ABB.'activationcode');   
}

/**
* Updates activation code
* @todo MEDIUMPRIORITY, add these option records too the options array as none public option records
*/
function wtgcsv_update_activationcode($activationcode){
    return update_option(WTG_CSV_ABB.'activationcode',$activationcode);  
}

/**
* Adds activation code (uses update_option not add_option)
*/
function wtgcsv_add_activationcode($activationcode){
    return update_option(WTG_CSV_ABB.'activationcode',$activationcode);  
}
?>
