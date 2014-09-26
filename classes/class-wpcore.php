<?php
/** 
 * Wordpress close to core class and functions i.e. WP functions slightly adapted or
 * functions which take global WP values and change them before using them
 * 
 * @package Opus
 * @author Ryan Bayne   
 * @since 0.0.1
 */

// load in Wordpress only
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * Wordpress close to core class and functions i.e. WP functions slightly adapted or
 * functions which take global WP values and change them before using them
* 
* @author Ryan R. Bayne
* @package Opus
* @since 8.0.0
* @version 1.0.0 
*/
class C2P_WPCore {  
    /**
    * About
    * 
    * @author Ryan R. Bayne
    * @package CSV 2 POST
    * @since 0.0.1
    * @version 1.0.0
    */
    public function capabilities() {
        global $wp_roles; 
        $capabilities_array = array();
        foreach( $wp_roles->roles as $role => $role_array ) { 
            $capabilities_array = array_merge( $capabilities_array, $role_array['capabilities'] );    
        }
        return $capabilities_array;
    }    
}
?>