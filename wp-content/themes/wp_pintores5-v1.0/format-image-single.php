<?php if ( has_post_thumbnail() ): ?>
	<?php $url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full', true ); ?>
	<figure class="entry-thumb zoomable">
		<a href="<?php echo $url[0] ?>" class="fancybox thumb" data-fancybox-group="fancybox[<?php the_ID(); ?>]">
			<?php the_post_thumbnail('ci_listing_thumb'); ?>
		</a>
		<div class="overlay"></div>
	</figure>
<?php endif; ?>
