<?php
//
// Uncomment one of the following two. Their functions are in panel/generic.php
//
add_action('wp_enqueue_scripts', 'ci_enqueue_modernizr', 1);
//add_action('wp_enqueue_scripts', 'ci_print_html5shim', 1);


// This function lives in panel/generic.php
add_action('wp_footer', 'ci_print_selectivizr', 100);


add_action('init', 'ci_register_theme_scripts');
if( !function_exists('ci_register_theme_scripts') ):
function ci_register_theme_scripts()
{
	//
	// Register all scripts here, both front-end and admin. 
	// There is no need to register them conditionally, as the enqueueing can be conditional.
	//

	wp_register_script('jquery-superfish', get_child_or_parent_file_uri('/panel/scripts/superfish.js'), array('jquery'), false, true);
	wp_register_script('jquery-flexslider', get_child_or_parent_file_uri('/panel/scripts/jquery.flexslider-2.1-min.js'), array('jquery'), false, true);
	wp_register_script('jquery-fitVids', get_child_or_parent_file_uri('/panel/scripts/jquery.fitvid-1.0.js'), array('jquery'), false, true);
	wp_register_script('jquery-jplayer', get_child_or_parent_file_uri('/js/jquery.jplayer.js'), array('jquery'), false, true);
	wp_register_script('jquery-formLabels', get_child_or_parent_file_uri('/js/jquery.formLabels1.0.js'), array('jquery'), false, true);
	wp_register_script('jquery-isotope', get_child_or_parent_file_uri('/js/jquery.isotope.js'), array('jquery'), false, true);
	wp_register_script('jquery-infinitescroll', get_child_or_parent_file_uri('/js/jquery.infinitescroll.min.js'), array('jquery'), false, true);
	wp_register_script('jquery-cookie', get_child_or_parent_file_uri('/js/jquery.cook.js'), array('jquery'), false, true);

	wp_register_script('ci-front-scripts', get_child_or_parent_file_uri('/js/scripts.js'),
		array(
			'jquery',
			'jquery-isotope',
			'jquery-formLabels',
			'fancybox',
			'jquery-fitVids',
			'jquery-superfish',
			'jquery-infinitescroll',
			'jquery-flexslider',
			'jquery-cookie',
			'jquery-jplayer'
		),
		CI_THEME_VERSION, true);

}
endif;


add_action('wp_enqueue_scripts', 'ci_enqueue_theme_scripts');
if( !function_exists('ci_enqueue_theme_scripts') ):
function ci_enqueue_theme_scripts()
{
	//
	// Enqueue all (or most) front-end scripts here.
	// They can be also enqueued from within template files.
	//	
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );


	//
	// Slider options export for ci-front-scripts
	//
	$params['slider_autoslide'] = ci_setting('slider_autoslide')=='enabled' ? true : false;
	$params['slider_effect'] = ci_setting('slider_effect');
	$params['slider_direction'] = ci_setting('slider_direction');
	$params['slider_duration'] = (string)ci_setting('slider_duration');
	$params['slider_speed'] = (string)ci_setting('slider_speed');
	$params['swfPath'] = get_template_directory_uri().'/js';
	wp_enqueue_script('ci-front-scripts');
	wp_localize_script('ci-front-scripts', 'ThemeOption', $params);

}
endif;


add_action('admin_enqueue_scripts','ci_enqueue_admin_theme_scripts');
if( !function_exists('ci_enqueue_admin_theme_scripts') ):
function ci_enqueue_admin_theme_scripts() 
{
	global $pagenow;

	//
	// Enqueue here scripts that are to be loaded on all admin pages.
	//

	if(is_admin() and $pagenow=='themes.php' and isset($_GET['page']) and $_GET['page']=='ci_panel.php')
	{
		//
		// Enqueue here scripts that are to be loaded only on CSSIgniter Settings panel.
		//

	}
}
endif;

/**
 * Infinite Scroll
 */
add_action( 'wp_footer', 'custom_infinite_scroll_js', 100 );
if( !function_exists('custom_infinite_scroll_js') ):
function custom_infinite_scroll_js() {
	if ( !is_singular()  )
	{ 
		?>
		<script>
			currPage = 0;
			maxPages = parseInt(<?php ci_e_setting('number_of_pages'); ?>);
			var infinite_scroll = {
				loadingImg: "<?php echo get_template_directory_uri(); ?>/images/ajax-loader.gif",
				loadingText: "<?php _e( 'Loading', 'ci_theme' ); ?>",
				donetext: "<?php _e( 'All entries loaded', 'ci_theme' ); ?>",
				"nextSelector":"#paging .nav-prev a",
				"navSelector":"#paging .nav-prev a",
				"itemSelector":"article.entry",
				"contentSelector":"#entry-list",
				"bufferPx": -100
			};
			
			jQuery( infinite_scroll.contentSelector ).infinitescroll( infinite_scroll, function(newElements) {
				var $newElems = jQuery(newElements).addClass("newItem");
				$newElems.hide().imagesLoaded(function(){
					if( jQuery(".format-gallery .flexslider").length > 0) {
						jQuery(".format-gallery .flexslider").flexslider({
							'controlNav': false,
							'directionNav': true,
							'animation': ThemeOption.slider_effect,
							'slideDirection': ThemeOption.slider_direction,
							'slideshow': Boolean(ThemeOption.slider_autoslide),
							'slideshowSpeed': Number(ThemeOption.slider_speed),
							'animationDuration': Number(ThemeOption.slider_duration)
						});
					}
					jQuery(this).show();
					jQuery('#infscr-loading').fadeOut('normal');
					jQuery("#entry-list").isotope('appended', $newElems );
					loadAudioPlayer(ThemeOption.swfPath);
					/*loadAudioPlayer(ThemeOption.swfPath);*/
					jQuery(".format-video .entry-thumb").fitVids();
					currPage++;

					if ( (maxPages != 0) && (currPage >= maxPages) ) {
						// kill scroll binding
						jQuery(window).unbind('.infscr');
						// hook up the manual click guy.
						jQuery('.load-more').fadeIn();
						jQuery('.load-more').click(function(){
							jQuery(document).trigger('retrieve.infscr');
							return false;
						});
						// remove the paginator when we're done.
						jQuery(document).ajaxError(function(e,xhr,opt){
							if (xhr.status == 404) {
								jQuery('.load-more').remove();
								jQuery('#infscr-loading').fadeOut();
							}
						});
					}

				});
			});

			<?php if ( (ci_setting('disable_infinitescroll') == 'enabled')  ) : ?>
				// kill scroll binding
				jQuery(window).unbind('.infscr');
				// hook up the manual click guy.
				jQuery('.load-more').click(function(){
					jQuery(document).trigger('retrieve.infscr');
					return false;
				});
				// remove the paginator when we're done.
				jQuery(document).ajaxError(function(e,xhr,opt){
					if (xhr.status == 404) {
						jQuery('.load-more').remove();
					}
				});
			<?php endif; ?>

		</script>
		<?php
	}
}
endif;

?>
