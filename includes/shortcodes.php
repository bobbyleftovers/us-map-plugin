<?php
function display_map($atts){
    
    // Include scripts (Vue.js, etc)
    wp_enqueue_script('map_vue_js',site_url().'/wp-content/plugins/Mapping/dist/bundle.js', [], false, true);
    wp_enqueue_script('d3_js','https://d3js.org/d3.v3.min.js');
    wp_enqueue_script('topojson_js','https://d3js.org/topojson.v1.min.js');

    ob_start();

    global $post;
    if($atts['id']):?>
        <style>
            #states {
                fill: #aaa;
            }
            #states .D {
                fill: #3B618C;
            }
            #states .R {
                fill: #E63A45;
            }
            #states .Both {
                fill: #3F3A6D;
            }
            #states .current {
                fill: black;
            }

            #state-name {
                color: #444;
            }

            #comments-box {
                border-color: #bbb;
                color: #444;
            }

            #state-box {
                border-color: #bbb;
                color: #444;
            }

            #state-co2-emissions:hover {
                background: #bbb;
            }

            .axis path,
            .axis line {
                stroke: #000;
            }

            .line {
                fill: none;
                stroke: black;
            }

            .arrow {
                fill: black;
                stroke: black;
            }

            #programs-box {
                border-color: #bbb;
                color: #444;
            }
        </style>
        <div id="us-map" data-map="<?=$atts['id']?>"><map-main /></div><?php
    endif;
    return ob_get_clean();
  
}

add_shortcode( 'USMap', 'display_map' );