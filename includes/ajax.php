<?php
add_action( 'wp_ajax_nopriv_get_map_csv', 'get_map_csv');
add_action( 'wp_ajax_get_map_csv', 'get_map_csv');

function get_map_csv(){

  $fields = [];
  $fields[] = get_field('map_csv', $_POST['csv']);
  wp_send_json($fields);

}