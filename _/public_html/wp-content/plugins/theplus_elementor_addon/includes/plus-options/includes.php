<?php	
	require_once THEPLUS_INCLUDES_URL.'plus-options/post-type.php';	
	
	$megamenu=theplus_get_option('general','check_elements');
	$check_category= get_option( 'theplus_api_connection_data' );
	if(isset($megamenu) && !empty($megamenu) && in_array("tp_dynamic_categories", $megamenu) && !empty($check_category['dynamic_category_thumb_check'])){
		require_once THEPLUS_INCLUDES_URL.'plus-options/custom-metabox/taxonomy_options.php';		
	}
	
	require_once THEPLUS_INCLUDES_URL.'plus-options/custom-metabox/custom_field_repeater_option.php';
?>