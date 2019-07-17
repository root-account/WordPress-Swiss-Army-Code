<?php $product = new WC_Product(get_the_ID());

/****************
NOTES
-----------------
How to get Woocommerce variations in your theme product template
*****************/

?>
<!-- GET ATTRIBUTES AND VARIATIONS -->

	<?php $attributes = $product->get_attributes() // GET ALL ATRIBUTES ?>
	<?php foreach( $attributes as $key => $value ): ?>
	    <?php $the_attribute_name = preg_replace( '/pa_/', '', $key ) // GET ATTRIBUTE NAME ?>


	        <label><?php echo $the_attribute_name; ?></label><br/><br/>

	        <?php $attribute_name = wc_get_product_terms( get_the_ID(), $key ) // GET ATTRIBUTE NAME ?>

	            <?php $attribute_slug = wc_get_product_terms( get_the_ID(), $key, array( 'fields' => 'slugs' ) ) // GET ATTRIBUTE SLUG ?>


	    <?php for ( $i=0; $i<count( $attribute_name ); $i++ ): // array_slice BECAUSE ARRAY INDEX IS NOT SEQUENCIAL ?>

	    <input type="radio" name="<?php echo $the_attribute_name ?>" value="<?php $slug = array_slice( $attribute_slug, $i, 1 ); echo $slug[0]; ?>"> <?php $name = array_slice( $attribute_name, $i, 1 ); echo $name[0]; ?><br/><br/>

	    <?php endfor ?>



	<?php endforeach ?>





		<!-- GET ALL ATRIBUTES IMAGES -->
		<?php
			$variations = $product->get_available_variations();

			foreach ( $variations as $variation ) {

			 $base =  $variation['attributes']['attribute_pa_base'] ;
			 $color =  $variation['attributes']['attribute_pa_colors'] ;
			 $material =  $variation['attributes']['attribute_pa_material'] ;
			 $wheels =  $variation['attributes']['attribute_pa_wheels'] ;
			 $var_id = $variation['variation_id'];

			 $image_src = $variation['image']['url'];


			 //print_r($variation['attributes']);

			  echo "<img src='$image_src' id='$var_id' class='var_image $color-$base-$material-$wheels'>";


			}
		?>
