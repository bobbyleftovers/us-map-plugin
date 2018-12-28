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
        Field::make( 'color', 'state_fill_color', 'State Initial Color' )
            ->set_default_value( '#aaaaaa' ),
        Field::make( 'color', 'state_inactive_color', 'Inactive State Color' )
            ->set_default_value( '#8a8a8a' ),
        Field::make( 'color', 'state_hover_color', 'State Hover Color' )
            ->set_default_value( '#f05e30' ),
        Field::make( 'color', 'state_selected_color', 'State Selected Color' )
            ->set_default_value( '#88100d' ),
        Field::make( 'color', 'state_border_color', 'State Border Color' )
            ->set_default_value( '#ffffff' ),

        // show DC? (affects state DD, frontend loop)
        Field::make( 'checkbox', 'show_dc', 'Show DC?' )
            ->set_option_value( 'false' )
    ))
    ->add_tab( 'Data Settings', array(
        Field::make( 'text', 'data_main_heading', 'Main Heading' ),
        Field::make( 'color', 'data_label_color', 'Data Label Color' )
            ->set_default_value( $default_value ),
        Field::make( 'color', 'data_border_color', 'Data Border Color' )
            ->set_default_value( $default_value ),
        
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

        // download? (show state selector/state data uploader)
        Field::make( 'checkbox', 'has_downloads', 'Use Per-state Downloads' )
            ->set_option_value( 'false' ),
        Field::make( 'complex', 'states_array', 'States To Add' )
            ->add_fields( array(
                Field::make( 'select', 'state', 'Select a State' )
                    ->add_options( $states ),
                Field::make( 'complex', 'state_meta', 'Custom State Data' )
                    ->add_fields( array(
                        Field::make( 'checkbox', 'is_download', 'Add File? (default is a link)' )
                            ->set_option_value( 'false' ),
                        Field::make( 'text', 'array_item_label', 'Item Label'),
                        Field::make( 'file', 'state_download', 'Downloadable File')
                            ->set_value_type( 'url' )
                            ->set_conditional_logic( array(
                                array(
                                    'field' => 'is_download',
                                    'value' => true,
                                )
                            ) ),
                        Field::make( 'text', 'state_url', 'URL (Opens in a separate tab)')
                            ->set_conditional_logic( array(
                                array(
                                    'field' => 'is_download',
                                    'value' => false,
                                )
                            ) ),
                    ))
            ) )
            ->set_conditional_logic( array(
                array(
                    'field' => 'has_downloads',
                    'value' => true,
                )
            ) ),
    ));
}