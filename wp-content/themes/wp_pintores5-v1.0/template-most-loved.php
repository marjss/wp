<?php
/*
 * Template Name: Most Loved Posts
 */
?>
<?php
	global $paged;
	
	$args = array(
		'paged' => $paged,
		'meta_key' => '_li_love_count',
		'orderby' => 'meta_value_num',
		'order' => 'DESC'
	);
	
	query_posts($args);
	
	get_template_part('index');
?>
