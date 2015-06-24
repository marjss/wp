<?php global $ci, $ci_defaults, $load_defaults; ?>
<?php if ($load_defaults===TRUE): ?>
<?php
	add_filter('ci_panel_tabs', 'ci_add_tab_advanced_options', 40);
	if( !function_exists('ci_add_tab_advanced_options') ):
		function ci_add_tab_advanced_options($tabs)
		{
			$tabs[sanitize_key(basename(__FILE__, '.php'))] = __('Advanced Options', 'ci_theme');
			return $tabs;
		}
	endif;
	
	// Default values for options go here.
	// $ci_defaults['option_name'] = 'default_value';
	// or
	// load_panel_snippet( 'snippet_name' );
	
	$ci_defaults['disable_infinitescroll']= '';
	$ci_defaults['number_of_pages']= '3';
	$ci_defaults['disable_front_comments']= '';
	$ci_defaults['front_page_comments_no']= '5';
	$ci_defaults['front_page_comments_limit']= '20';
	$ci_defaults['feat_image_links_to']= 'feat_image';
?>
<?php else: ?>

	<fieldset class="set">
		<p class="guide"><?php _e('You can disable infinite scrolling. Listing pages will not auto-load posts via AJAX and manual loading will be required.' , 'ci_theme'); ?></p>
		<?php ci_panel_checkbox('disable_infinitescroll', 'enabled', __('Disable Infinite Scroll', 'ci_theme')); ?>

		<p class="guide"><?php _e('Type how many pages you wish to be auto-loaded before the Load More Posts button fires up. After this number the user must press the Load More button in order to load the next page. If you wish to activate endless infinite scrolling loading, enter 0.' , 'ci_theme'); ?></p>
		<?php ci_panel_input('number_of_pages', __('Number of pages:', 'ci_theme')); ?>
	</fieldset>

	<fieldset class="set">
		<p class="guide"><?php _e('You can globally turn off the latest comment snippets under each post in the frontpage and all listing pages (such as categories etc).' , 'ci_theme'); ?></p>
		<?php ci_panel_checkbox('disable_front_comments', 'enabled', __('Have comments in listing pages turned off by default', 'ci_theme')); ?>

		<p class="guide"><?php _e('Type how many comments you wish to show on the listing pages.' , 'ci_theme'); ?></p>
		<?php ci_panel_input('front_page_comments_no', __('Number of comments in listing pages:', 'ci_theme')); ?>

		<p class="guide"><?php _e('Limit the words each comment snippet in the listing pages can have.' , 'ci_theme'); ?></p>
		<?php ci_panel_input('front_page_comments_limit', __('Number of words each comment snippet can have:', 'ci_theme')); ?>
	</fieldset>

	<fieldset class="set">
		<p class="guide"><?php _e('You can select where the featured image of each post leads to when clicked. It can either load up the image in a lightbox or send the user to the single post. <b>This does not apply to galleries, which will always zoom in.</b>' , 'ci_theme'); ?></p>
		<label><?php _e('By default, Featured Images will link to:', 'ci_theme'); ?></label>
		<?php ci_panel_radio('feat_image_links_to', 'feat_image', 'feat_image', __('Full image in lightbox', 'ci_theme')); ?>
		<?php ci_panel_radio('feat_image_links_to', 'feat_permalink', 'feat_permalink', __('The post itself', 'ci_theme')); ?>
	</fieldset>
<?php endif; ?>
