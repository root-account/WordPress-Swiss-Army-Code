<?php
/****************
NOTES
-----------------
How to create a shortcode
copy code to your functions.php
*****************/


//Register a shortcode
function shortcode_func(){

	//the content of the shortcode
	ob_start();
	?>

	<!-- HTML START HERE -->

	<!-- HTML END -->

	<?php
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}

add_shortcode('name_of_shortcode','shortcode_func');
