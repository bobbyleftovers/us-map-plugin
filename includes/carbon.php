<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'crb_attach_theme_options' );

function crb_attach_theme_options() {

    $states = [
        'AL' => 'Alabama',
        'AK' => 'Alaska',
        'AZ' => 'Arizona',
        'AR' => 'Arkansas',
        'CA' => 'California',
        'CO' => 'Colorado',
        'CT' => 'Connecticut',
        'DE' => 'Delaware',
        'DC' => 'District Of Columbia',
        'FL' => 'Florida',
        'GA' => 'Georgia',
        'HI' => 'Hawaii',
        'ID' => 'Idaho',
        'IL' => 'Illinois',
        'IN' => 'Indiana',
        'IA' => 'Iowa',
        'KS' => 'Kansas',
        'KY' => 'Kentucky',
        'LA' => 'Louisiana',
        'ME' => 'Maine',
        'MD' => 'Maryland',
        'MA' => 'Massachusetts',
        'MI' => 'Michigan',
        'MN' => 'Minnesota',
        'MS' => 'Mississippi',
        'MO' => 'Missouri',
        'MT' => 'Montana',
        'NE' => 'Nebraska',
        'NV' => 'Nevada',
        'NH' => 'New Hampshire',
        'NJ' => 'New Jersey',
        'NM' => 'New Mexico',
        'NY' => 'New York',
        'NC' => 'North Carolina',
        'ND' => 'North Dakota',
        'OH' => 'Ohio',
        'OK' => 'Oklahoma',
        'OR' => 'Oregon',
        'PA' => 'Pennsylvania',
        'RI' => 'Rhode Island',
        'SC' => 'South Carolina',
        'SD' => 'South Dakota',
        'TN' => 'Tennessee',
        'TX' => 'Texas',
        'UT' => 'Utah',
        'VT' => 'Vermont',
        'VA' => 'Virginia',
        'WA' => 'Washington',
        'WV' => 'West Virginia',
        'WI' => 'Wisconsin',
        'WY' => 'Wyoming',
    ];

    Container::make( 'post_meta', 'Map Data and Options' )
    ->where('post_type', '=', 'map')
    ->add_tab('Map Settings', array(
        Field::make( 'color', 'state_fill_color', 'State Fill Color' ),
        Field::make( 'color', 'state_hover_color', 'State Hover Color' ),
        Field::make( 'color', 'state_border_color', 'State Border Color' ),
        Field::make( 'checkbox', 'show_dc', 'Show DC?' )
            ->set_option_value( 'false' )
        // show DC? (affects state DD, frontend loop)
    ))
    ->add_tab( 'Data Settings', array(
        Field::make( 'text', 'data_label', 'Data Label' ),
        Field::make( 'color', 'data_label_color', 'Data Label Color' ),
        Field::make( 'color', 'data_border_color', 'Data Border Color' ),
        
        // spreaadsheet? (show csv uploader)
        Field::make( 'checkbox', 'has_spreadsheet', 'Use Spreadsheet Data?' )
            ->set_option_value( 'false' ),
        Field::make( 'file', 'data_spreasheet', 'CSV File (must have .csv file type)')
            ->set_conditional_logic( array(
                array(
                    'field' => 'has_spreadsheet',
                    'value' => true,
                )
            ) ),
        Field::make( 'checkbox', 'has_downloads', 'Use Per-state Downloads' )
            ->set_option_value( 'false' ),
        Field::make( 'complex', 'states_array', 'States To Add' )
            ->add_fields( array(
                Field::make( 'select', 'state', 'Select a State' )
                    ->add_options( $states ),
                Field::make( 'complex', 'crb_slide' )
                    ->add_fields( array(
                        Field::make( 'file', 'downloadable', 'Doanloadable File')
                    ))
            ) )
            ->set_conditional_logic( array(
                array(
                    'field' => 'has_downloads',
                    'value' => true,
                )
            ) ),
        // download? (show state selector/state data uploader)
    ));
}