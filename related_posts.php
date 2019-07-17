<?php

/****************
NOTES
-----------------
If you want to display related posts when viewing a post from any post type
*****************/

function get_related_posts($cat_name, $posttype){

	//get the taxonomy terms of custom post type
	$customTaxonomyTerms = wp_get_object_terms( get_the_ID(), $cat_name, array('fields' => 'ids') );

	$customTaxonomies = wp_get_object_terms( get_the_ID(), $cat_name, array('fields' => 'names') );

	$customTaxSlugs = wp_get_object_terms( get_the_ID(), $cat_name, array('fields' => 'slugs') );
	//query arguments
	$args = array(
			'post_type' => $posttype,
			'post_status' => 'publish',
			'posts_per_page' => 5,
			'tax_query' => array(
					array(
							'taxonomy' => $cat_name,
							'field' => 'id',
							'terms' => $customTaxonomyTerms
					)
			),
			'post__not_in' => array (get_the_ID()),
	);

	//the query
	$relatedPosts = new WP_Query( $args );

	//loop through query
	if($relatedPosts->have_posts()){
			echo '<ul>';
			while($relatedPosts->have_posts()){
					$relatedPosts->the_post();

					foreach ($customTaxonomies as $customTaxonomy) {
						echo $customTaxonomy.", ";
					}

					foreach ($customTaxSlugs as $customTaxSlug) {
						// echo $customTaxSlug.", ";
					}

	?>
					<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
	<?php
			}
			echo '</ul>';
?>

<?php

	if ($posttype == "askpoolxpert"){
		$the_slug = "askxpert-category";
	} else{
		$the_slug = "category";
	}

?>

<a href="<?php echo site_url(); ?>/<?php echo $the_slug.'/'.$customTaxSlug; ?>">show all results</a>


<?php
	}else{
			//no posts found
	}

	//restore original post data
	wp_reset_postdata();

}
