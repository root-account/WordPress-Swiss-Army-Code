<?php
/****************
NOTES
-----------------
Radio buttons custom meta boxes for wordpress
*****************/

function featured_image_align() {
add_meta_box('featured_image_align', 'Featured Image Alignment', 'featured_image_align_meta', 'aglet_slider' ); //you can change the 4th paramter i.e. post to custom post type name, if you want it for something else

}

add_action( 'add_meta_boxes', 'featured_image_align' );
function featured_image_align_meta( $post ) {
 wp_nonce_field( 'featured_image_align', 'featured_image_align_nonce' );
 $value = get_post_meta( $post->ID, 'featured_image_align', true ); //featured_image_align is a meta_key. Change it to whatever you want
?>
<input type="radio" name="image_align" value="left" <?php checked( $value, 'left' ); ?> >
Left<br>
<input type="radio" name="image_align" value="right" <?php checked( $value, 'right' ); ?> >
Right<br>
<input type="radio" name="image_align" value="center" <?php checked( $value, 'center' ); ?> >
Center<br>
<?php
}

function fia_save_meta_box_data( $post_id ) {

        /*
         * We need to verify this came from our screen and with proper authorization,
         * because the save_post action can be triggered at other times.
         */

        // Check if our nonce is set.
        if ( !isset( $_POST['featured_image_align_nonce'] ) ) {
                return;
        }

        // Verify that the nonce is valid.
        if ( !wp_verify_nonce( $_POST['featured_image_align_nonce'], 'featured_image_align' ) ) {
                return;
        }

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return;
        }

        // Check the user's permissions.
        if ( !current_user_can( 'edit_post', $post_id ) ) {
                return;
        }


        // Sanitize user input.
        $new_meta_value = ( isset( $_POST['image_align'] ) ? sanitize_html_class( $_POST['image_align'] ) : '' );

        // Update the meta field in the database.
        update_post_meta( $post_id, 'featured_image_align', $new_meta_value );

}

add_action( 'save_post', 'fia_save_meta_box_data' );
