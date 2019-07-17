<?php
/****************
NOTES
-----------------
For creating additional post types for things like portfolio, events or whatever post type you want in wordpress
*****************/

//Function to register the actual post type

function the_post_type(){
	$args = array('public' => true, 'has-archive' => true, supports => array('title', 'editor', thumbnail), 'label' => "Profile");
	register_post_type('profile', $args);
}
add_action('init', 'the_post_type');


//Function to add meta boxes to te post type
function meta_box_function_name() {
    add_meta_box( 'meta_box_id', __( 'Tender Details', 'meta-textdomain' ), 'meta_box_callback', 'the_post_type' );
}
add_action( 'add_meta_boxes', 'meta_box_function_name' );



//Function to add input boxes to meta boxes
function meta_box_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'meta_box_nonce' );
    $prfx_stored_meta = get_post_meta( $post->ID );
    ?>

    <p>
        <label for="reference" class="prfx-row-title"><?php _e( 'Label_name', 'meta-textdomain' )?></label>
        <input type="text" name="reference" required id="reference" value="<?php if ( isset ( $prfx_stored_meta['reference'] ) ) echo $prfx_stored_meta['reference'][0]; ?>" />
    </p>

<?php
}



//Function to save input box data when save button is pressed
function meta_box_save( $post_id ) {
    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'meta_box_nonce' ] ) && wp_verify_nonce( $_POST[ 'meta_box_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    // Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ 'reference' ] ) ) {
        update_post_meta( $post_id, 'reference', sanitize_text_field( $_POST[ 'reference' ] ) );
    }

}
add_action( 'save_post', 'meta_box_save' );


/*--------------------- ADDITIONAL NOTES -----------------------*/
