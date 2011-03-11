<?php
# install shortcodes
add_shortcode( 'ecispin', 'c2pf_shortcodespinning' );
add_shortcode( 'ecilab', 'c2pf_shortcodelabel' );
add_shortcode( 'ecicol', 'c2pf_shortcodecolumn' );
//add_shortcode( 'ecisc', 'c2pf_shortcodeblock' );

# Shortcode function - Displays a label and a value, user has option to display default value or remove label if data is null
function c2pf_shortcodelabel( $atts ){return 'Shortcodes Are Not Available In Free Edition';}

# Shortcode function - replaces shortcode with value from custom field named the same as key
function c2pf_shortcodecolumn( $atts ){return 'Shortcodes Are Not Available In Free Edition';}

# Shortcode function - text spinning, randomly selects one of multiple values passed
function c2pf_shortcodespinning( $atts ){return 'Spinning In Paid Edition Only';}
?>