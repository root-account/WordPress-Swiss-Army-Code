<?php
/*
Template Name: Events
*/


/****************
NOTES
----------
Just a wordpress archive page template with loops to collect posts
*****************/

get_header();


$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

$args = array(
	'orderby' => 'date',
 'post_type' => 'events',
 'order' => 'DESC',
 'paged' => $paged
);

$args = new WP_Query( $args );

?>

<div id="container">
	<div id="content" role="main">

<?php

while ( $args->have_posts() ) : $args->the_post();
?>

	<h1 class="entry-title"><?php the_title(); ?></h1>

<?php
endwhile;

?>

	</div><!-- #content -->
</div><!-- #container -->

<?php get_footer(); ?>
