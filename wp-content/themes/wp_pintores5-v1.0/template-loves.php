<?php
/*
 * Template Name: Loved Posts
 */
?>
<?php
	global $paged;
	
	$args = array(
		'paged' => $paged,
		'post__in' => li_get_user_loved_posts()
	);
	
	query_posts($args);
	
	get_template_part('index');
?>
