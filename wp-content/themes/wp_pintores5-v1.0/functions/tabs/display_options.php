<?php global $ci, $ci_defaults, $load_defaults, $content_width; ?>
<?php if ($load_defaults===TRUE): ?>
<?php
	add_filter('ci_panel_tabs', 'ci_add_tab_display_options', 30);
	if( !function_exists('ci_add_tab_display_options') ):
		function ci_add_tab_display_options($tabs) 
		{ 
			$tabs[sanitize_key(basename(__FILE__, '.php'))] = __('Display Options', 'ci_theme'); 
			return $tabs; 
		}
	endif;
	
	// Default values for options go here.
	// $ci_defaults['option_name'] = 'default_value';
	// or
	// load_panel_snippet( 'snippet_name' );

	$ci_defaults['show_author_info']= 'enabled';

	load_panel_snippet('excerpt');
	load_panel_snippet('seo');
	load_panel_snippet('comments');
	load_panel_snippet('slider_flexslider');


	$ci_defaults['disable_excerpt_standard']= '';
	$ci_defaults['disable_excerpt_image']= '';
	$ci_defaults['disable_excerpt_gallery']= '';
	$ci_defaults['disable_excerpt_quote']= '';
	$ci_defaults['disable_excerpt_video']= '';
	$ci_defaults['disable_excerpt_audio']= '';
	$ci_defaults['disable_excerpt_link']= '';

	$ci_defaults['disable_meta_standard']= '';
	$ci_defaults['disable_meta_image']= '';
	$ci_defaults['disable_meta_gallery']= '';
	$ci_defaults['disable_meta_quote']= '';
	$ci_defaults['disable_meta_video']= '';
	$ci_defaults['disable_meta_audio']= '';
	$ci_defaults['disable_meta_link']= '';
	
	$ci_defaults['show_author_info']= '';
	
?>
<?php else: ?>

	<?php load_panel_snippet('slider_flexslider'); ?>

	<?php load_panel_snippet('excerpt'); ?>

	<fieldset class="set">
		<p class="guide"><?php _e('Enable or disable post excerpts/content in the listing pages such as the Homepage and Category pages.' , 'ci_theme'); ?></p>
		<fieldset>
			<?php ci_panel_checkbox('disable_excerpt_standard', 'enabled', __('Disable the Excerpt/Content for Standard Posts.', 'ci_theme')); ?>
		</fieldset>
		<fieldset>
			<?php ci_panel_checkbox('disable_excerpt_image', 'enabled', __('Disable the Excerpt/Content for Image Posts.', 'ci_theme')); ?>
		</fieldset>
		<fieldset>
			<?php ci_panel_checkbox('disable_excerpt_gallery', 'enabled', __('Disable the Excerpt/Content for Gallery Posts.', 'ci_theme')); ?>
		</fieldset>
		<fieldset>
			<?php ci_panel_checkbox('disable_excerpt_video', 'enabled', __('Disable the Excerpt/Content for Video Posts.', 'ci_theme')); ?>
		</fieldset>
		<fieldset>
			<?php ci_panel_checkbox('disable_excerpt_audio', 'enabled', __('Disable the Excerpt/Content for Audio Posts.', 'ci_theme')); ?>
		</fieldset>
		<fieldset>
			<?php ci_panel_checkbox('disable_excerpt_quote', 'enabled', __('Disable the Excerpt/Content for Quote Posts.', 'ci_theme')); ?>
		</fieldset>
		<fieldset>
			<?php ci_panel_checkbox('disable_excerpt_link', 'enabled', __('Disable the Excerpt/Content for Link Posts.', 'ci_theme')); ?>
		</fieldset>
	</fieldset>

	<fieldset class="set">
		<p class="guide"><?php _e('Enable or disable post meta (titles, date posted etc) in the listing pages.' , 'ci_theme'); ?></p>
		<fieldset>
			<?php ci_panel_checkbox('disable_meta_standard', 'enabled', __('Disable the Meta/Title for Standard Posts.', 'ci_theme')); ?>
		</fieldset>
		<fieldset>
			<?php ci_panel_checkbox('disable_meta_image', 'enabled', __('Disable the Meta/Title for Image Posts.', 'ci_theme')); ?>
		</fieldset>
		<fieldset>
			<?php ci_panel_checkbox('disable_meta_gallery', 'enabled', __('Disable the Meta/Title for Gallery Posts.', 'ci_theme')); ?>
		</fieldset>
		<fieldset>
			<?php ci_panel_checkbox('disable_meta_video', 'enabled', __('Disable the Meta/Title for Video Posts.', 'ci_theme')); ?>
		</fieldset>
		<fieldset>
			<?php ci_panel_checkbox('disable_meta_audio', 'enabled', __('Disable the Meta/Title for Audio Posts.', 'ci_theme')); ?>
		</fieldset>
		<fieldset>
			<?php ci_panel_checkbox('disable_meta_quote', 'enabled', __('Disable the Meta/Title for Quote Posts.', 'ci_theme')); ?>
		</fieldset>
		<fieldset>
			<?php ci_panel_checkbox('disable_meta_link', 'enabled', __('Disable the Meta/Title for Link Posts.', 'ci_theme')); ?>
		</fieldset>
	</fieldset>

	<?php load_panel_snippet('seo'); ?>	

	<?php load_panel_snippet('comments'); ?>	

	<fieldset class="set">
		<p class="guide"><?php _e('You can enable and disable the Author name below each post\'s title.' , 'ci_theme'); ?></p>
		<?php ci_panel_checkbox('show_author_info', 'enabled', __('Enable Author name', 'ci_theme')); ?>
	</fieldset>

<?php endif; ?>
