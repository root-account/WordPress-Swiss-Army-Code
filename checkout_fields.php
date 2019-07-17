<?php
/****************
NOTES
----------
If you want to add additional fields to the chekout page of woocomeerce, this is how
*****************/

//Add the field to the checkout page
add_action( 'woocommerce_after_order_notes', 'bbloomer_checkout_radio_choice' );

function bbloomer_checkout_radio_choice() {

		// Select Field
    $chosen = WC()->session->get('radio_chosen');
    $chosen = empty( $chosen ) ? WC()->checkout->get_value('radio_choice') : $chosen;
    $chosen = empty( $chosen ) ? 'no_option' : $chosen;

    $select_field = array(
    'type' => 'select',
    'class' => array( 'form-row-wide' ),
		'label' => __('Address Type'),
    'options' => array(
        'Residence' => 'Residence',
        'Business' => 'Business',
        'Hospital' => 'Hospital',
        'School' => 'School'
    ),
    'default' => $chosen
    );

		// BUSINESS Field
		$company_name = array(
    'type' => 'text',
    'class' => array( 'form-row-wide' ),
		// 'required' => true,
		'label' => __('Company Name')
    );

		$comp_name = WC()->session->get('comp_name');
		$comp_name = empty( $comp_name ) ? WC()->checkout->get_value('comp_name') : $comp_name;

		// HOSPITAL Fields
		$hosptital_name = array(
    'type' => 'text',
    'class' => array( 'form-row-wide' ),
		// 'required' => true,
		'label' => __('Hospital Name')
    );

		$hosp_name = WC()->session->get('hosp_name');
		$hosp_name = empty( $hosp_name ) ? WC()->checkout->get_value('hosp_name') : $hosp_name;

		$ward_number = array(
    'type' => 'text',
    'class' => array( 'form-row-wide' ),
		// 'required' => true,
		'label' => __('Ward Number')
    );

		$ward_no = WC()->session->get('ward_no');
		$ward_no = empty( $ward_no ) ? WC()->checkout->get_value('ward_no') : $ward_no;

		// SCHOOL Fields
		$school_name = array(
    'type' => 'text',
    'class' => array( 'form-row-wide' ),
		// 'required' => true,
		'label' => __('School Name')
    );

		$scho_name = WC()->session->get('scho_name');
		$scho_name = empty( $scho_name ) ? WC()->checkout->get_value('scho_name') : $scho_name;


    echo '<div id="checkout-select">';

    woocommerce_form_field( 'radio_choice', $select_field, $chosen );
		woocommerce_form_field( 'comp_name', $company_name, $comp_name);
		woocommerce_form_field( 'hosp_name', $hosptital_name, $hosp_name);
		woocommerce_form_field( 'ward_no', $ward_number, $ward_no);
		woocommerce_form_field( 'scho_name', $school_name, $scho_name);

    echo '</div>';

}


// SAVE VARIBLE FROM FIELD
add_action( 'woocommerce_new_order', 'tp_new_order' );
function tp_new_order( $order_id ) {

  $tp_preferred_slot_nr = isset( $_POST['radio_choice'] ) ? $_POST['radio_choice'] : 0;
	$comp_name = isset( $_POST['comp_name'] ) ? $_POST['comp_name'] : 0;
	$hosp_name = isset( $_POST['hosp_name'] ) ? $_POST['hosp_name'] : 0;
	$ward_no = isset( $_POST['ward_no'] ) ? $_POST['ward_no'] : 0;
	$scho_name = isset( $_POST['scho_name'] ) ? $_POST['scho_name'] : 0;


  add_post_meta( $order_id, 'radio_choice', $tp_preferred_slot_nr, true );
	add_post_meta( $order_id, 'comp_name', $comp_name, true );
	add_post_meta( $order_id, 'hosp_name', $hosp_name, true );
	add_post_meta( $order_id, 'ward_no', $ward_no, true );
	add_post_meta( $order_id, 'scho_name', $scho_name, true );

}

// Show on email template
add_action( 'woocommerce_email_after_order_table', 'woocommerce_email_after_order_table_func' );
function woocommerce_email_after_order_table_func( $order ) {

	$choice = wptexturize( get_post_meta( $order->id, 'radio_choice', true ) );
	$company_name = wptexturize( get_post_meta( $order->id, 'comp_name', true ) );
	$hospital_name = wptexturize( get_post_meta( $order->id, 'hosp_name', true ) );
	$ward_no = wptexturize( get_post_meta( $order->id, 'ward_no', true ) );
	$school_name = wptexturize( get_post_meta( $order->id, 'scho_name', true ) );
	?>

	<h3>Additional information</h3>
	<table>

		<tr>
			<td>Address Type: </td>
			<td><?php echo $choice; ?></td>
		</tr>

		<?php if($choice == 'Business'){?>
				<tr>
					<td>Company Name: </td>
					<td><?php echo $company_name; ?></td>
				</tr>
		<?php }?>

		<?php if($choice == 'Hospital'){?>
				<tr>
					<td>Hospital Name: </td>
					<td><?php echo $hospital_name; ?></td>
				</tr>

				<tr>
					<td>Ward Number: </td>
					<td><?php echo $ward_no; ?></td>
				</tr>
		<?php }?>

		<?php if($choice == 'School'){?>
				<tr>
					<td>School Name: </td>
					<td><?php echo $school_name; ?></td>
				</tr>
		<?php }?>


	</table>

	<?php

} //End function

/**
 * Display field value on the order edit page
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

function my_custom_checkout_field_display_admin_order_meta($order){
    echo '<p><strong>'.__('Address Type').':</strong> ' . get_post_meta( $order->id, 'radio_choice', true ) . '</p>';
		echo '<p><strong>'.__('Company Name').':</strong> ' . get_post_meta( $order->id, 'comp_name', true ) . '</p>';
		echo '<p><strong>'.__('Hospital Name').':</strong> ' . get_post_meta( $order->id, 'hosp_name', true ) . '</p>';
		echo '<p><strong>'.__('Ward Number').':</strong> ' . get_post_meta( $order->id, 'ward_no', true ) . '</p>';
		echo '<p><strong>'.__('School Name').':</strong> ' . get_post_meta( $order->id, 'scho_name', true ) . '</p>';
}


// REMOVE SOME FIELDS
// Hook in
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields( $fields ) {
     unset($fields['billing']['billing_company']);
		 unset($fields['billing']['billing_address_1']);

     return $fields;
}
