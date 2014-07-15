<?php
/** 
 * Sections array for CSV 2 POST plugin
 * 
 * @link by http://www.webtechglobal.co.uk
 * 
 * @author Ryan Bayne 
 *
 * @package CSV 2 POST
 * 
 * @since 8.0.0
 * 
 * This array like many can be used to configure the plugin before activastion in Wordpress: for experienced users.
 */
 
global $c2p_sections_array; 
$c2p_sections_array = array();

// main
$c2p_sections_array['main']['title'] = __( 'Main', 'csv2post');
$c2p_sections_array['main']['active'] = true;// not the same as the section switch in $c2p_settings, this prevents a section even being detected and the class being loaded
$c2p_sections_array['main']['developmentinsight'] = __( 'The main section is where the initial plugin configuration begins. There is some information and occasional news available.');
$c2p_sections_array['main']['developmentprogress'] = array( 'free' => 75, 'paid' => 50, 'support' => 5, 'translation' => 0);

// project
$c2p_sections_array['project']['title'] = __( 'Project', 'csv2post');
$c2p_sections_array['project']['active'] = true;// not the same as the section switch in $c2p_settings, this prevents a section even being detected and the class being loaded
$c2p_sections_array['project']['developmentinsight'] = __( 'offer all subscribers an affiliate URL and affiliate views. One feature I will add is the ability to automatically increase commission or pay bonuses when targets are reached. I have also put thought into controlling affiliates per product i.e. limit the number of affiliates per region so that translators have further incentive', 'csv2post');
$c2p_sections_array['project']['developmentprogress'] = array( 'free' => 0, 'paid' => 0, 'support' => 0, 'translation' => 0);
?>