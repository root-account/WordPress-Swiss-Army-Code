<?php
/****************
NOTES
-----------------
How to add custom taxanomies to your custom post types
*****************/

//Register a new taxonomoy
function structure_taxonomy() {
    register_taxonomy(
        'nemisa_structure_category',  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
        'nemisa_board',        //post type name
        array(
            'hierarchical' => true,
            'label' => 'Categories',  //Display name
            'query_var' => true,
            'rewrite' => array(
                'slug' => 'nemisa_structure_category', // This controls the base slug that will display before each term
                'with_front' => false // Don't display the category base before
            )
        )
    );
}
add_action( 'init', 'structure_taxonomy');

// Another Method

// Register Custom Taxonomy
function ess_custom_taxonomy_Item()  {

$labels = array(
    'name'                       => 'Looks',
    'singular_name'              => 'Look',
    'menu_name'                  => 'Looks',
    'all_items'                  => 'All Looks',
    'parent_item'                => 'Parent Look',
    'parent_item_colon'          => 'Parent Look:',
    'new_item_name'              => 'New Look Name',
    'add_new_item'               => 'Add New Look',
    'edit_item'                  => 'Edit Look',
    'update_item'                => 'Update Look',
    'separate_items_with_commas' => 'Separate Look with commas',
    'search_items'               => 'Search Looks',
    'add_or_remove_items'        => 'Add or remove Looks',
    'choose_from_most_used'      => 'Choose from the most used Looks',
);
$args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
);
register_taxonomy( 'looks', 'product', $args );

}

add_action( 'init', 'ess_custom_taxonomy_item', 0 );
