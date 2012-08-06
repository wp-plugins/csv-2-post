<?php
// include api functions for individual services
if(is_admin()){require_once(WTG_C2P_DIR.'templatesystem/include/webservices/csv2post_api_tickets.php');}

/**
* General status check on WebTechGlobal Web Services (online or offline)
* 
* @todo CRITICAL, causing SOAP response error
* @todo CRITICAL, causing SOAP response error 
*/
function csv2post_api_webservices_status_soapcall(){
                 
    // todo, LOWPRIORITY, add these lines to all api functions
    global $csv2post_disableapicalls;
    if($csv2post_disableapicalls){ 
        return 'soapcallsoff'; 
    }
    
    // is webtechglobal.co.uk is online
    $domain_result = csv2post_domain_online('http://www.csv2post.com');
    if($domain_result == false){ 
        return 'siteoffline';     
    }                            
       
    // now contact webtechglobal web services for wordpress and confirm online
    $client = new SoapClient(null, array(
    'location' => "http://www.csv2post.com/wordpresswebservices/wtgapi_status.php",
    'uri'      => "http://www.csv2post.com/wordpresswebservices/request/"));


    $soapcall_result_array = $client->wtgapi_status_public(); 
    

    return csv2post_soapresponse( $soapcall_result_array );   
}

/**
* Ensures response is always the standard SOAP Call Response array
* i.e. if the soap call fails due to error, this ensures
* 
* @param mixed $soapcall_result_array
* @return array, $soapcall_result_array
*/
function csv2post_soapresponse( $soapcall_result_array ){

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
function csv2post_validate_call_code($callcode){
    $client = new SoapClient(null, array(
    'location' => "http://www.csv2post.com/wordpresswebservices/wtgapi_webservice_validatecallcode.php",
    'uri'      => "http://www.csv2post.com/wordpresswebservices/request/"));
    $soapcall_result_array = $client->wtgapi_webservice_validatecallcode_SOAPCALL($callcode,$_SERVER['HTTP_HOST'],$_SERVER['SERVER_NAME']);
    return csv2post_soapresponse( $soapcall_result_array );       
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
function csv2post_confirm_current_domain_is_registered(){

    $client = new SoapClient(null, array(
    'location' => "http://www.csv2post.com/wordpresswebservices/wtgapi_webservice_checkdomainisregistered.php",
    'uri'      => "http://www.csv2post.com/wordpresswebservices/request/"));
    
    $soapcall_result_array = $client->wtgapi_confirm_domain_is_registered_SOAPCALL($_SERVER['HTTP_HOST'],$_SERVER['SERVER_NAME'],WTG_C2P_ID);
        
    return csv2post_soapresponse( $soapcall_result_array );
}
    
/**
* Checks if the domain has a paid subscription, the result will be used to extend services further on plugin interface
* 
* @return array, webtechglobal web services standard response array, to be processed by the function calling this
*/
function csv2post_api_checksubscriptionstatus_for_domain(){
    
    ### TODO: HIGHPRIORITY, ENSURE ACTIVATION CODE COMES AFTER DOMAIN CHECK 
    global $csv2post_activationcode;
    
    $client = new SoapClient(null, array(
    'location' => "http://www.csv2post.com/wordpresswebservices/wtgapi_webservice_checkdomainhassubscription.php.php",
    'uri'      => "http://www.csv2post.com/wordpresswebservices/request/"));

    $soapcall_result_array = $client->wtgapi_checksubscriptionstatus_for_domain_SOAPCALL( $_SERVER['HTTP_HOST'],$_SERVER['SERVER_NAME'],WTG_C2P_ID,$csv2post_activationcode); 
       
    return csv2post_soapresponse( $soapcall_result_array );     
}

/**
* NOT YET IN USE
* 
* @param mixed $activationcode
*/
function csv2post_api_is_activationcodevalid_soapcall( $activationcode ){
    $client = new SoapClient(null, array(
    'location' => "http://www.csv2post.com/wordpresswebservices/wtgapi_pluginactivation_calls.php",
    'uri'      => "http://www.csv2post.com/wordpresswebservices/request/"));
    $soapcall_result_array = $client->wtgapi_validateactivationcode( $http_host,$server_name,$itemid,$activationcode ); 
    return csv2post_soapresponse( $soapcall_result_array );    
}

/**
* First function to use before calls to check on session status
* 
* @return boolean
* @uses $csv2post_apiservicestatus,$csv2post_apisession_array  
*/
function csv2post_api_allowed(){
    global $csv2post_api_servicestatus,$csv2post_api_session_array;
    if($csv2post_apisession_array['state'] == 'stop'){
        
        return false;// a stop has been applied to prevent traffic flooding (service may be down for maintenence)
        
    }elseif($csv2post_api_session_array['state'] == 'session'){
        
        $expiry = $csv2post_api_session_array['seconds'] + time();
        
        if($expiry > time() && $csv2post_api_servicestatus == 'online'){
            return true;                        
        }elseif($expiry < time() || $csv2post_api_servicestatus == 'offline'){
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
function csv2post_api_update_apikeysession($seconds,$state){
    $apikey_session_array = array();
     
    $apikeysession_array['session_seconds'] = $seconds;// duration of access giving  or duration of temporary stopage on all API calls
    $apikeysession_array['session_expirydate'] = csv2post_date($seconds);// calculated expiry date and time 
    $apikeysession_array['session_expirytime'] = strtotime(csv2post_date($seconds));// calculated expiry date and time 
    $apikeysession_array['session_state'] = $state;// session or stop, a stop will prevent API calls for giving time 
    $apikeysession_array['session_changedate'] = csv2post_date(0);// used to calculate if session expired 
    
    update_option(WTG_C2P_ABB.'apisession',$apikey_session_array);    
}

/**
* Stores _apiauthmethod in Wordpress options table using update_option   (uses update_option not add_option)         
*/
function csv2post_add_is_emailauthorised($authmethod){
    return update_option(WTG_C2P_ABB.'isemailauthorised',$authmethod);          
}

/**
* Returns result from get_option(_apiauthmethod)
* 
* @todo MEDIUMPRIORITY, add these option records too the options array as none public option records
*/
function csv2post_get_is_emailauthorised(){
    return get_option(WTG_C2P_ABB.'isemailauthorised');   
}

/**
* Returns result from get_option(_activationkey)
*/
function csv2post_get_activationcode(){
    return get_option(WTG_C2P_ABB.'activationcode');   
}

/**
* Updates activation code
* @todo MEDIUMPRIORITY, add these option records too the options array as none public option records
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
?>
