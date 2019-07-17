<?php

/****************
NOTES
-----------------
If you want to add more input fields in the wordpress edit screens this are the functions.
You can add additional fields to any post type including the page post type
*****************/

/**************************
META BOXES
**************************/

add_action( 'add_meta_boxes', 'events_meta_box_add' );
function events_meta_box_add()
{
    add_meta_box( 'events-meta-id', 'EVENT DETAILS', 'events_meta_box_cb', 'events', 'normal', 'high' );
}

// Function to display input boxes
function events_meta_box_cb()
{
    global $post;
    wp_nonce_field( basename( __FILE__ ), 'events_box_nonce' );

    $values = get_post_custom( $post->ID );

    $dimensipns = isset( $values['dime_text'][0] ) ? $values['dime_text'][0] : '';
    $speci = isset( $values['speci_text'][0] ) ? $values['speci_text'][0] : '';
    $events_image = isset( $values['events_image_url'][0] ) ? $values['events_image_url'][0] : '';

    ?>

    <p>
				<label for="events_image_url"> Date</label>
        <input type="text" placeholder="Event Date" name="events_image_url" id="events_image_url" value="<?php echo $events_image; ?>" />
    </p>

		<p>
			<label for="dime_text"> Time</label>
        <input type="text" placeholder="Event Time" name="dime_text" id="dime_text" value="<?php echo $dimensipns; ?>" />
    </p>

		<p>
			<label for="speci_text"> Venue</label>
        <input type="text" placeholder="Venue" name="speci_text" id="speci_text" value="<?php echo $speci; ?>" />
    </p>


<?php
}

// Save events Data
add_action( 'save_post', 'events_meta_box_save' );
function events_meta_box_save( $post_id )
{
       $is_autosave = wp_is_post_autosave( $post_id );
        $is_revision = wp_is_post_revision( $post_id );
        $is_valid_nonce = ( isset( $_POST[ 'events_box_nonce' ] ) && wp_verify_nonce( $_POST[ 'events_box_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

        // Exits script depending on save status
        if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
            return;
        }

        // Checks for input and sanitizes/saves if needed

        if( isset( $_POST[ 'dime_text' ] ) ) {
            update_post_meta( $post_id, 'dime_text', sanitize_text_field( $_POST[ 'dime_text' ] ) );
        }

        if( isset( $_POST[ 'speci_text' ] ) ) {
            update_post_meta( $post_id, 'speci_text', sanitize_text_field( $_POST[ 'speci_text' ] ) );
        }

        if( isset( $_POST[ 'events_image_url' ] ) ) {
            update_post_meta( $post_id, 'events_image_url', sanitize_text_field( $_POST[ 'events_image_url' ] ) );
        }
}
