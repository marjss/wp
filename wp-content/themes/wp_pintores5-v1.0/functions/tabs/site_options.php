<?php global $ci, $ci_defaults, $load_defaults; ?>
<?php if ($load_defaults===TRUE): ?>
<?php
	add_filter('ci_panel_tabs', 'ci_add_tab_site_options', 10);
	if( !function_exists('ci_add_tab_site_options') ):
		function ci_add_tab_site_options($tabs) 
		{ 
			$tabs[sanitize_key(basename(__FILE__, '.php'))] = __('Site Options', 'ci_theme'); 
			return $tabs; 
		}
	endif;

	// Default values for options go here.
	// $ci_defaults['option_name'] = 'default_value';
	// or
	// load_panel_snippet( 'snippet_name' );

	$ci_defaults['layout'] = 'default';
	$ci_defaults['listing_columns'] = 'ur-three';
	$ci_defaults['main_content_cols'] = 'nine';
	$ci_defaults['sidebar_content_cols'] = 'three';

	load_panel_snippet('logo');
	load_panel_snippet('favicon');
	load_panel_snippet('touch_favicon');

	add_filter('body_class','ci_site_layout_class_names');
	if( !function_exists('ci_site_layout_class_names')):
	function ci_site_layout_class_names($classes) {
		if(ci_setting('layout')=='alt')
			return array_merge( $classes, array('site_layout' => 'alt') );
		else
			return $classes;
	}	
	endif;

?>
<?php else: ?>
	
	<?php load_panel_snippet('logo'); ?>

	<fieldset class="set">
		<p class="guide"><?php _e('Select the layout of the site. This affects every single post of the site. Pages always have a right sidebar.', 'ci_theme'); ?></p>
		<?php 
			$options = array(
				'default' => __('Default - Posts Have Comments Underneath and Sidebar on Right', 'ci_theme'),
				'alt' => __('Alternative - Posts Have Comments on the Right, No Sidebar', 'ci_theme')
			);
			ci_panel_dropdown('layout', $options, __('Site layout', 'ci_theme'));
		?>

		<p class="guide mt10"><?php _e('Here you can configure your posts and pages layout by selecting different column widths for each of their two main areas: Main Content (on the left) and Sidebar (on the right). <b>The grid is separated into 12 columns, so the total column number you provide must add up to 12 and no more, e.g. 9 and 3, or 6 and 6.</b>', 'ci_theme'); ?></p>
		<?php
			$options = array(
				'two' => __('Two Columns', 'ci_theme'),
				'three' => __('Three Columns', 'ci_theme'),
				'four' => __('Four Columns', 'ci_theme'),
				'five' => __('Five Columns', 'ci_theme'),
				'six' => __('Six Columns', 'ci_theme'),
				'seven' => __('Seven Columns', 'ci_theme'),
				'eight' => __('Eight Columns', 'ci_theme'),
				'nine' => __('Nine Columns', 'ci_theme'),
				'ten' => __('Ten Columns', 'ci_theme')
			);
			ci_panel_dropdown('main_content_cols', $options, __('Main Content Width Span Number (left area)', 'ci_theme'));
		?>

		<?php
			$options = array(
			'two' => __('Two Columns', 'ci_theme'),
			'three' => __('Three Columns', 'ci_theme'),
			'four' => __('Four Columns', 'ci_theme'),
			'five' => __('Five Columns', 'ci_theme'),
			'six' => __('Six Columns', 'ci_theme'),
			'seven' => __('Seven Columns', 'ci_theme'),
			'eight' => __('Eight Columns', 'ci_theme'),
			'nine' => __('Nine Columns', 'ci_theme'),
			'ten' => __('Ten Columns', 'ci_theme')
			);
			ci_panel_dropdown('sidebar_content_cols', $options, __('Sidebar Width Span (right area)', 'ci_theme'));
		?>

		<p class="guide mt10"><?php _e('Select how many columns you wish the listing pages (homepage, categories, etc) to be (default: 4).', 'ci_theme'); ?></p>
		<?php
			$options = array(
				'ur-two' => __('Six Columns', 'ci_theme'),
				'ur-five' => __('Five Columns', 'ci_theme'),
				'ur-three' => __('Four Columns', 'ci_theme'),
				'ur-four' => __('Three Columns', 'ci_theme'),
				'ur-six' => __('Two Columns', 'ci_theme')
			);
			ci_panel_dropdown('listing_columns', $options, __('Listing Pages Columns', 'ci_theme'));
		?>
	</fieldset>
	
	<?php load_panel_snippet('favicon'); ?>

	<?php load_panel_snippet('touch_favicon'); ?>

	<?php load_panel_snippet('sample_content'); ?>

<?php endif; ?>
