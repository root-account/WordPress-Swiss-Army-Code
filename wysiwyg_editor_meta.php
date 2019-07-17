<?php

/****************
NOTES
-----------------
Add another WYSIWYG editor as additional field for your custom post types
*****************/

 //This function initializes the meta box.
 function custom_editor_meta_box() {
           add_meta_box (
           	  'custom-editor',
           	  __('Custom Editor', 'custom-editor') ,
           	  'custom_editor',
           	  'portfolio'
           );

 }

 //Displaying the meta box
 function custom_editor($post) {
          echo "<h3>Add Your Content Here</h3>";
          $content = get_post_meta($post->ID, 'custom_editor', true);

          //This function adds the WYSIWYG Editor
          wp_editor (
          	$content ,
          	'custom_editor',
          	array ( "media_buttons" => true )
          );

 }

 //This function saves the data you put in the meta box
 function custom_editor_save_postdata($post_id) {

    if( isset( $_POST['custom_editor_nonce'] ) && isset( $_POST['portfolio'] ) ) {

        //Not save if the user hasn't submitted changes
        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
        }

        // Verifying whether input is coming from the proper form
        if ( ! wp_verify_nonce ( $_POST['custom_editor_nonce'] ) ) {
        return;
        }

        // Making sure the user has permission
        if( 'post' == $_POST['portfolio'] ) {
               if( ! current_user_can( 'edit_post', $post_id ) ) {
                    return;
               }
        }
    }


        $data = $_POST['custom_editor'];
        update_post_meta($post_id, 'custom_editor', $data);

 }

add_action('save_post', 'custom_editor_save_postdata');

add_action('admin_init', 'custom_editor_meta_box');

?>
