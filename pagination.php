<?php
/****************
NOTES
-----------------
this function is for adding pagination to your post types loops
*****************/


// Query args
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
// $current_category = single_cat_title("", false);

$args = array(
	'post_type' => 'post',
	'posts_per_page' => 4,
	'paged' => $paged,
	// 'category_name'  => $current_category
	);

$loop = new WP_Query( $args );

// Loop here


// Paste this in template file where pagination should appear (Outside loop)
global $wp_query;

$big = 999999999; // need an unlikely integer


$pagination_args = array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $loop->max_num_pages,
		'show_all'           => false,
		'end_size'           => 1,
		'mid_size'           => 2,
		'prev_next'          => true,
		'prev_text'          => __('<'),
		'next_text'          => __('>'),
		// 'type'               => 'list',
		'add_args'           => false,
		'add_fragment'       => '',
		'before_page_number' => '',
		'after_page_number'  => ''
);

echo paginate_links($pagination_args);




// function my_pagination_rewrite() {
//     add_rewrite_rule('blog/page/?([0-9]{1,})/?$', 'index.php?category_name=blog&paged=$matches[1]', 'top');
// }
// add_action('init', 'my_pagination_rewrite');


?>
