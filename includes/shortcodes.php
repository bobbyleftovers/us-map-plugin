<?php
function display_map($atts){

    ob_start();
    global $post;
    if($atts['slug']):?>
        <style>
            #states {
                fill: #aaa;
                .D {
                    fill: #3B618C;
                }
                .R {
                    fill: #E63A45;
                }
                .Both {
                    fill: #3F3A6D;
                }
                .current {
                    fill: black;
                }
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
        <div id="us-map" data-map="<?=$atts['slug']?>"></div><?php
    endif;
    return ob_get_clean();
  
}

add_shortcode( 'USMap', 'display_map' );