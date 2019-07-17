<?php
/****************
NOTES
-----------------
Examples of different types of wordpress loops
*****************/
 ?>

<!-- WOOCOMMERCE PRODUCTS LOOP -->

<!-- Grid class -->
<div uk-grid class="uk-child-width-1-3@m">

<!-- For normal archive page use these args -->
<?php
		$args = array(
			'post_type' => 'product',
			'posts_per_page' => 12
			);
		$loop = new WP_Query( $args );
		if ( $loop->have_posts() ) {
			while ( $loop->have_posts() ) : $loop->the_post();

		endwhile;
		}

	?>


<!-- FOR CATEGORY ARCHIVES use these query args -->
<?php
	$category = get_queried_object();

	$cpt_cat = $category->term_id;
	$args = array(
			'post_type' => 'product',
			'posts_per_page' => 10,
			'tax_query' => array(
					array(
							'taxonomy' => 'product_cat',
							'field'    => 'term_id',
							'terms'    => $cpt_cat,
					),
			),
	);
?>



	<!-- WOOCOMMERCE PRODUCTS LOOP -->
	<div uk-grid class="uk-child-width-1-3@m">
	<?php
			$args = array(
				'post_type' => 'product',
				'posts_per_page' => 12
				);
			$loop = new WP_Query( $args );
			if ( $loop->have_posts() ) {
				while ( $loop->have_posts() ) : $loop->the_post();


		?>


		<div class="uk-width-1-3@m product-block">
			<a href="<?php echo the_permalink(); ?>">

				<div class="product-image">
					<?php if($sale) : ?>
						<span class="sale-badge">SALE!</span>
					<?php endif; ?>

					<?php echo the_post_thumbnail(); ?>
				</div>
				<h5 class="product-name"><?php echo the_title(); ?></h5>

				<?php if($sale) : ?>
				<p class="product-price-tickr"><del><?php echo $currency; echo $price; ?></del> <?php echo $currency; echo $sale; ?></p>
				<?php elseif($price) : ?>
				<p class="product-price-tickr"><?php echo $currency; echo $price; ?></p>
				<?php endif; ?>

				<a href="<?php echo the_permalink(); ?>" class="prod-btn aglet_vc_btn ">View product</a>
			</a>

		</div>


		<?php
				endwhile;
			} else {
				echo __( 'No products found' );
			}
			wp_reset_postdata();
	?>
		</div>




	<div class="uk-width-1-3@m product-block">
		<a href="<?php echo the_permalink(); ?>">

			<div class="product-image">
				<?php if($sale) : ?>
					<span class="sale-badge">SALE!</span>
				<?php endif; ?>

				<?php echo the_post_thumbnail(); ?>
			</div>
			<h5 class="product-name"><?php echo the_title(); ?></h5>

			<?php if($sale) : ?>
			<p class="product-price-tickr"><del><?php echo $currency; echo $price; ?></del> <?php echo $currency; echo $sale; ?></p>
			<?php elseif($price) : ?>
			<p class="product-price-tickr"><?php echo $currency; echo $price; ?></p>
			<?php endif; ?>

			<a href="<?php echo the_permalink(); ?>" class="prod-btn aglet_vc_btn ">View product</a>
		</a>

	</div>


	<?php
			endwhile;
		} else {
			echo __( 'No products found' );
		}
		wp_reset_postdata();
?>
	</div>



<!--********************
LIST CATEGORY NAMES
***********************-->
<?php
		$orderby = 'name';
		$order = 'asc';
		$hide_empty = false ;
		$post_type = "product";
		$taxonomy_name = "product_cat";

		$cat_args = array(
			'orderby'    => $orderby,
			'order'      => $order,
			'hide_empty' => $hide_empty,
			'post_type' => $post_type,
		);

		$product_categories = get_terms( $taxonomy_name, $cat_args );

		if( !empty($product_categories) ){
			echo '

		<ul>';
			foreach ($product_categories as $key => $category) {
					echo '

		<li>';
					echo '<a href="'.get_term_link($category).'" >';
					echo $category->name;
					echo '</a>';
					echo '</li>';
			}
			echo '</ul>


		';
		}
?>


<!--********************
LOOP THOUGH PRODUCT GALLERY IMAGES
***********************-->
<?php
global $product;
 $product_image_ids = $product->get_gallery_image_ids();

 foreach( $product_image_ids as $product_image_id )
{
  $image_url = wp_get_attachment_url( $product_image_id );
  echo '<img src="'.$image_url.'">';
}
