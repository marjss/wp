<?php
add_action( 'widgets_init', 'ci_widgets_init' );
if( !function_exists('ci_widgets_init') ):
function ci_widgets_init() {

	register_sidebar(array(
		'name' => __( 'Blog Sidebar', 'ci_theme'),
		'id' => 'blog-sidebar',
		'description' => __( 'Your blog widgets. They appear in your single posts.', 'ci_theme'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s group">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name' => __( 'Page Sidebar', 'ci_theme'),
		'id' => 'page-sidebar',
		'description' => __( 'Your page widgets. They appear in your pages.', 'ci_theme'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s group">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name' => __( 'Top Bar', 'ci_theme'),
		'id' => 'top-bar',
		'description' => __( 'Top Widget Bar of the Theme. Only the Search and Socials Ignited widgets are allowed here.', 'ci_theme'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s group">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name' => __( 'First Box Widget', 'ci_theme'),
		'id' => 'first-box',
		'description' => __( 'This is the first box of your homepage layout. You can put any widgets here.', 'ci_theme'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s group">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name' => __( 'Repeatable Last Box', 'ci_theme'),
		'id' => 'last-box-repeat',
		'description' => __( 'This widget area appears as the last box of each page. Useful for repeatable information and/or advertisements.', 'ci_theme'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s group">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name' => __( 'Bottom Row Widget', 'ci_theme'),
		'id' => 'bottom-row-widgets',
		'description' => __( 'Only the Twitter Widget is supported here. No title.', 'ci_theme'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s group twelve columns">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name' => __( 'Repeatable Last Box', 'ci_theme'),
		'id' => 'last-box-repeat',
		'description' => __( 'This widget area appears as the last box of each page. Useful for repeatable information and/or advertisements.', 'ci_theme'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s group">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name' => __( 'Footer Column 1', 'ci_theme'),
		'id' => 'footer-col-1',
		'description' => __( 'This widget area appears as the first footer widget area.', 'ci_theme'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s group">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name' => __( 'Footer Column 2', 'ci_theme'),
		'id' => 'footer-col-2',
		'description' => __( 'This widget area appears as the second footer widget area.', 'ci_theme'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s group">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name' => __( 'Footer Column 3', 'ci_theme'),
		'id' => 'footer-col-3',
		'description' => __( 'This widget area appears as the third footer widget area.', 'ci_theme'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s group">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));

	register_sidebar(array(
		'name' => __( 'Footer Column 4', 'ci_theme'),
		'id' => 'footer-col-4',
		'description' => __( 'This widget area appears as the fourth footer widget area.', 'ci_theme'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s group">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));

}
endif;
?>
