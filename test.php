<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

?>

<div class="filters-rows">

	<div class="row">
		<div class="col-md-4">

		</div>

		<div class="col-md-8">

		</div>
	</div>

</div>



<div class="product-info">

	<div class="row">
		<div class="col-md-6 prod-image">
				<?php
					echo the_post_thumbnail();
					do_action( 'woocommerce_before_single_product_summary' );
				?>
		</div>

		<div class="col-md-6 prod-details">
				<h2 class="prod-title"><?php echo the_title(); ?></h1>
				<?php echo the_content(); ?>
		</div>

	</div>

</div>



<div id="product-<?php the_ID(); ?>" <?php wc_product_class(); ?>>

	<?php
		do_action( 'woocommerce_after_single_product_summary' );
	?>

</div>


<?php do_action( 'woocommerce_after_single_product' ); ?>
