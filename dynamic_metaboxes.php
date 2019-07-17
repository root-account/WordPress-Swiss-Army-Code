<?php

/****************
NOTES
-----------------
This script is for dynamically adding more input fields in the wordpress edit screens
*****************/

add_action('admin_init', 'add_meta_boxes', 1);
function add_meta_boxes() {
	add_meta_box( 'repeatable-fields', 'DOWNLOADS', 'repeatable_meta_box_display', 'product', 'normal', 'high');
}

function repeatable_meta_box_display() {
	global $post;

	$repeatable_fields = get_post_meta($post->ID, 'repeatable_fields', true);


	wp_nonce_field( 'repeatable_meta_box_nonce', 'repeatable_meta_box_nonce' );
?>
	<script type="text/javascript">
jQuery(document).ready(function(jQuery) {
	jQuery('.metabox_submit').click(function(e) {
		e.preventDefault();
		jQuery('#publish').click();
	});
	jQuery('#add-row').on('click', function() {
		var row = jQuery('.empty-row.screen-reader-text').clone(true);
		row.removeClass('empty-row screen-reader-text');
		row.insertBefore('#repeatable-fieldset-one tbody>tr:last');
		return false;
	});
	jQuery('.remove-row').on('click', function() {
		jQuery(this).parents('tr').remove();
		return false;
	});

	jQuery('#repeatable-fieldset-one tbody').sortable({
		opacity: 0.6,
		revert: true,
		cursor: 'move',
		handle: '.sort'
	});
});
	</script>

	<table id="repeatable-fieldset-one" width="100%">
	<thead>
		<tr>
			<th width="2%"></th>
			<th width="30%">File Name</th>
			<th width="60%">File URL</th>
			<th width="2%"></th>
		</tr>
	</thead>
	<tbody>
	<?php

	if ( $repeatable_fields ) :

		foreach ( $repeatable_fields as $field ) {
?>
	<tr>
		<td><a class="button remove-row" href="#">-</a></td>
		<td><input type="text" class="widefat" name="name[]" value="<?php if($field['name'] != '') echo esc_attr( $field['name'] ); ?>" /></td>

		<td><input type="text" class="widefat" name="url[]" value="<?php if ($field['url'] != '') echo esc_attr( $field['url'] ); else echo 'http://'; ?>" /></td>
		<td><a class="sort">|||</a></td>

	</tr>
	<?php
		}
	else :
		// show a blank one
?>
	<tr>
		<td><a class="button remove-row" href="#">-</a></td>
		<td><input type="text" class="widefat" name="name[]" /></td>


		<td><input type="text" class="widefat" name="url[]" value="http://" /></td>
<td><a class="sort">|||</a></td>

	</tr>
	<?php endif; ?>

	<!-- empty hidden one for jQuery -->
	<tr class="empty-row screen-reader-text">
		<td><a class="button remove-row" href="#">-</a></td>
		<td><input type="text" class="widefat" name="name[]" /></td>


		<td><input type="text" class="widefat" name="url[]" value="http://" /></td>
<td><a class="sort">|||</a></td>

	</tr>
	</tbody>
	</table>

	<p><a id="add-row" class="button" href="#"> Add New</a>
	<!-- <input type="submit" class="metabox_submit" value="Save" /> -->
	</p>

	<?php
}

add_action('save_post', 'repeatable_meta_box_save');
function repeatable_meta_box_save($post_id) {
	if ( ! isset( $_POST['repeatable_meta_box_nonce'] ) ||
		! wp_verify_nonce( $_POST['repeatable_meta_box_nonce'], 'repeatable_meta_box_nonce' ) )
		return;

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return;

	if (!current_user_can('edit_post', $post_id))
		return;

	$old = get_post_meta($post_id, 'repeatable_fields', true);
	$new = array();


	$names = $_POST['name'];
	$urls = $_POST['url'];

	$count = count( $names );

	for ( $i = 0; $i < $count; $i++ ) {
		if ( $names[$i] != '' ) :
			$new[$i]['name'] = stripslashes( strip_tags( $names[$i] ) );


		if ( $urls[$i] == 'http://' )
			$new[$i]['url'] = '';
		else
			$new[$i]['url'] = stripslashes( $urls[$i] ); // and however you want to sanitize
		endif;
	}

	if ( !empty( $new ) && $new != $old )
		update_post_meta( $post_id, 'repeatable_fields', $new );
	elseif ( empty($new) && $old )
		delete_post_meta( $post_id, 'repeatable_fields', $old );
}




/************** TO DISPLAY IN TEMPLATE FILE ********************/

	$repeatable_fields = get_post_meta($post->ID, 'repeatable_fields', true);


	foreach($repeatable_fields as $field) {
		echo $field['name'];
	}
