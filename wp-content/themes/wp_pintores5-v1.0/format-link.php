<?php if ( has_post_thumbnail() ): ?>
	<?php $url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full', true ); ?>
	<figure class="entry-thumb zoomable">
		<a href="<?php echo $url[0] ?>" class="fancybox thumb" data-fancybox-group="fancybox[<?php the_ID(); ?>]">
			<?php the_post_thumbnail('ci_listing_thumb'); ?>
		</a>
		<div class="overlay"></div>
	</figure>
<?php endif; ?>

<?php
	// Get all the link format custom fields
	$linkurl = get_post_meta($post->ID, 'ci_format_link_url', true);
	$nofollow = get_post_meta($post->ID, 'ci_format_link_nofollow', true);
	$nofollow = $nofollow=='nofollow' ? 'rel="nofollow"' : '';
?>
<div class="link-container">
	<a href="<?php echo esc_url($linkurl); ?>" <?php echo $nofollow; ?> target="_blank" title="<?php echo esc_attr(sprintf(__('External link to: %s', 'ci_theme'), get_the_title())); ?>"><?php echo esc_url($linkurl); ?></a>
</div>

<?php include(locate_template('inc_listing-post-meta.php')); ?>
