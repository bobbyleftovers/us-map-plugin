<?php
function display_map($atts){

    ob_start();
    global $post;
    if($atts['map_id']):?>
        <div id="us-map" data-map="$atts['map_id']">Map</div><?php
    endif;
    return ob_get_clean();
  
}

add_shortcode( 'us_map', 'display_map' );