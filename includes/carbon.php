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

    Container::make( 'post_meta', 'Map Setup' )
    ->where('post_type', '=', 'map')
    
    ->add_tab('Map', array(
        // setup fields
        Field::make( 'checkbox', 'show_dc', 'Show DC' )
            ->set_option_value( 'false' ),
        Field::make( 'checkbox', 'show_small_state_icons', 'Show Icons for small states and districts' )
            ->set_option_value( 'false' ),
        
        // style fields
        Field::make( 'color', 'state_fill_color', 'State Initial Color' )
            ->set_default_value( '#aaaaaa' ),
        Field::make( 'color', 'state_hover_color', 'State Hover Color' )
            ->set_default_value( '#f05e30' ),
        Field::make( 'color', 'state_selected_color', 'State Selected Color' )
            ->set_default_value( '#88100d' ),
        Field::make( 'color', 'state_border_color', 'State Border Color' )
            ->set_default_value( '#ffffff' ),
    ))

    ->add_tab('Viewer Window', array(
        Field::make( 'text', 'data_empty_heading', 'Window Heading (When no state is selected)' )
        ->set_default_value( 'CLICK A STATE TO VIEW DATA' ),
        Field::make( 'color', 'data_label_color', 'Data Label Color' )
            ->set_default_value( $default_value ),
        Field::make( 'color', 'data_border_color', 'Data Border Color' )
            ->set_default_value( $default_value ),
        
        // spreadsheet? (show csv uploader)
        Field::make( 'checkbox', 'has_csv', 'Use CSV Data?' )
            ->set_option_value( 'false' ),
        Field::make( 'file', 'map_csv', 'CSV File')
            // ->set_type( 'csv' )
            ->set_value_type( 'url' )
            ->set_conditional_logic( array(
                array(
                    'field' => 'has_csv',
                    'value' => true,
                )
            ) ),

        // download? (show state selector/state data uploader)
        Field::make( 'checkbox', 'has_downloads', 'Use Per-state Downloads' )
            ->set_option_value( 'false' )
            ->set_conditional_logic( array(
                array(
                    'field' => 'has_csv',
                    'value' => false,
                )
            ) ),
        Field::make( 'complex', 'states_array', 'States To Add' )
            ->add_fields( array(
                Field::make( 'select', 'state', 'Select a State' )
                    ->add_options( $states ),
                Field::make( 'complex', 'state_meta', 'Custom State Data' )
                    ->add_fields( array(
                        Field::make( 'checkbox', 'is_download', 'Add File? (default is a link)' )
                            ->set_option_value( 'false' ),
                        Field::make( 'text', 'array_item_label', 'Item Header'),
                        Field::make( 'file', 'state_download', 'Downloadable File')
                            ->set_value_type( 'url' )
                            ->set_conditional_logic( array(
                                array(
                                    'field' => 'is_download',
                                    'value' => true,
                                )
                            ) ),
                        Field::make( 'text', 'array_item_data', 'Item Copy')
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