<?php
//
// Code for fancybox.
// All the theme needs to do is call add_fancybox_support() after the bootstrap.
//
if( !function_exists('add_fancybox_support') ):
function add_fancybox_support()
{
	add_action('init', 'ci_enqueue_fancybox');
	add_action('wp_footer', 'ci_print_fancybox_selectors');
	
	add_filter('the_content', 'ci_fancyboxrel', 12);
	add_filter('get_comment_text', 'ci_fancyboxrel');
	add_filter('wp_get_attachment_link', 'ci_fancyboxrel');
}
endif;

if( !function_exists('remove_fancybox_support') ):
function remove_fancybox_support()
{
	remove_action('init', 'ci_enqueue_fancybox');
	remove_action('wp_footer', 'ci_print_fancybox_selectors');
	
	remove_filter('the_content', 'ci_fancyboxrel', 12);
	remove_filter('get_comment_text', 'ci_fancyboxrel');
	remove_filter('wp_get_attachment_link', 'ci_fancyboxrel');
}
endif;


if( !function_exists('ci_fancyboxrel') ):
function ci_fancyboxrel($content)
{
	global $post;
	$pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
	
	if(woocommerce_enabled())
		$replacement = '<a$1href=$2$3.$4$5 rel="thumbnails"$6 class="zoom">$7</a>';
	else
		$replacement = '<a$1href=$2$3.$4$5 rel="fancybox['.$post->ID.']"$6>$7</a>';
	
	$content = preg_replace($pattern, $replacement, $content);
	return $content;
}
endif;

if( !function_exists('ci_enqueue_fancybox') ):
function ci_enqueue_fancybox()
{
	global $woocommerce;
    
    // WooCommerce >= v2.0 uses prettyPhoto.
    if(woocommerce_enabled() and version_compare($woocommerce->version, '1.9.9', '<='))
	{
		wp_enqueue_script( 'fancybox', plugins_url('/woocommerce/assets/js/fancybox/fancybox.min.js'), array( 'jquery' ), false, true );	
		wp_enqueue_style( 'woocommerce_fancybox_styles', plugins_url('/woocommerce/assets/css/fancybox.css'));		
	}
	else
	{
		wp_enqueue_script('fancybox', get_child_or_parent_file_uri('/panel/scripts/fancybox/source/jquery.fancybox.pack.js'), array('jquery'), false, true);
		wp_enqueue_style('fancybox', get_child_or_parent_file_uri('/panel/scripts/fancybox/source/jquery.fancybox.css'));
	}
}
endif;

if( !function_exists('ci_print_fancybox_selectors') ):
function ci_print_fancybox_selectors()
{
	if( ! woocommerce_enabled() ): 	
		?>
		<script type='text/javascript'>
			jQuery(document).ready( function($) {
				$(".fancybox, a[rel^='fancybox[']").fancybox({
					fitToView: true,
					nextEffect: 'fade',
					prevEffect: 'fade'
				});
			});
		</script>
		<?php 
	endif;
}
endif;


?>
