<?php
/****************
NOTES
-----------------
Various woocomerce functions that are important
*****************/

// ADD WOOCOMMERCE SUPPORT
function mytheme_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );

// Breadcrums
add_filter( 'woocommerce_breadcrumb_defaults', 'wcc_change_breadcrumb_delimiter' );
function wcc_change_breadcrumb_delimiter( $defaults ) {
	// Change the breadcrumb delimeter from '/' to '>'
	$defaults['delimiter'] = ' <span>/</span> ';
	return $defaults;
}

// GET CATEGORY TERMS
$terms = get_the_terms( get_the_ID(), 'product_cat' );
foreach ( $terms as $term ){
	echo $term->name[0];
}

// GET THE CURRENT TERM NAME
$queried_object = get_queried_object();
echo $queried_object->name;

// another method
$categories = get_the_terms( get_the_ID(), 'product_cat' );

// wrapper to hide any errors from top level categories or products without category
if ( $categories && ! is_wp_error( $category ) ) :

	 // loop through each cat
	 foreach($categories as $category) :
		 // get the children (if any) of the current cat
		 $children = get_categories( array ('taxonomy' => 'product_cat', 'parent' => $category->term_id ));

		 if ( count($children) == 0 ) {
				 // if no children, then echo the category name.
				 echo '<h6>'.$category->name.'</h6>';
		 }
	 endforeach;

endif;

// get child terms of current taxonomy
$term_children = get_terms(
    'product_cat',
    array(
        'parent' => get_queried_object_id(),
    )
);

if ( ! is_wp_error( $terms ) ) {
	echo '<ul>';
	foreach ($term_children as $child ) {
	    echo '<li><a href="#' . $child->slug . '">' . $child->name . '</a></li>';
	}
	echo "</ul>";
}


// Get sale badge
global $product;
global $woocommerce;
$currency = get_woocommerce_currency_symbol();
$price = get_post_meta( get_the_ID(), '_regular_price', true);
$sale = get_post_meta( get_the_ID(), '_sale_price', true);

<?php if($sale) : ?>
<p class="product-price-tickr"><?php echo $currency; echo $sale; ?> <del><?php echo $currency; echo $price; ?></del></p>
<?php elseif($price) : ?>
<p class="product-price-tickr"><?php echo $currency; echo $price; ?></p>
<?php endif; ?>



<!--********************
LINKED PRODUCTS LOOP
**********************-->
<?php
/* crossells */
$crosssell_ids = get_post_meta( get_the_ID(), '_crosssell_ids' );
$crosssell_ids=$crosssell_ids[0];

if(count($crosssell_ids)>0){
$args = array( 'post_type' => 'product', 'posts_per_page' => 10, 'post__in' => $crosssell_ids );
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post();
?><a href='<?php the_permalink(); ?>'><?php
the_post_thumbnail( 'thumbnail' );
the_title();
?></a><?php
endwhile;
}
?>

<!--*************************************
EMAIL TEMPLATE AND EXTRA CHECKOUT FIELDS
**************************************-->
<?php
//Add the field to the checkout page
add_action( 'woocommerce_after_order_notes', 'bbloomer_checkout_radio_choice' );

function bbloomer_checkout_radio_choice() {

    $chosen = WC()->session->get('radio_chosen');
    $chosen = empty( $chosen ) ? WC()->checkout->get_value('radio_choice') : $chosen;
    $chosen = empty( $chosen ) ? 'no_option' : $chosen;

    $args = array(
    'type' => 'select',
    'class' => array( 'form-row-wide' ),
    'options' => array(
        'no_option' => 'select...',
        'Word_of_mouth' => 'Word of mouth',
        'Google' => 'Google',
        'In_store' => 'In store',
        'Blog' => 'Blog',
        'Online_Ads' => 'Online Ads',
        'Social' => 'Social',
    ),
    'default' => $chosen
    );

    echo '<div id="checkout-select">';
    echo '<label>How did you hear about us?</label>';
    woocommerce_form_field( 'radio_choice', $args, $chosen );
    echo '</div>';

}

// SAVE VARIBLE FROM FIELD
add_action( 'woocommerce_new_order', 'tp_new_order' );
function tp_new_order( $order_id ) {
  $tp_preferred_slot_nr = isset( $_POST['radio_choice'] ) ? $_POST['radio_choice'] : 0;
    add_post_meta( $order_id, 'radio_choice', $tp_preferred_slot_nr, true );
}


// Show on email template
add_action( 'woocommerce_email_after_order_table', 'woocommerce_email_after_order_table_func' );
function woocommerce_email_after_order_table_func( $order ) {
	?>

	<h3>Additional information</h3>
	<table>
		<tr>
			<td>Card message: </td>
			<td><?php echo wptexturize( get_post_meta( $order->id, 'radio_choice', true ) ); ?></td>
		</tr>
		<tr>
			<td>Order delivery date: </td>
			<td><?php echo wptexturize( get_post_meta( $order->id, 'radio_choice', true ) ); ?></td>
		</tr>
	</table>

	<?php
}
?>



<!--*************************************
VARIATIONS IMAGES ON TEMPLATE
**************************************-->


<?php
if ( $product->is_type( 'variable' ) ) {

	if ( $product->has_child() ) {
			$variations = $product->get_children();
			foreach ( $variations as $variation ) {
					if ( has_post_thumbnail( $variation ) ) {

							 ?>
							 <li>
								<?php echo get_the_post_thumbnail( $variation );?>
							</li>
							<?php
					}
			}
	}

}
?>


<!--*************************************
EMAIL TEMPLATE AND EXTRA CHECKOUT FIELDS
**************************************-->
