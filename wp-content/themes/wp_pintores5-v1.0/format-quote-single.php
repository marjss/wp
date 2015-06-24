<?php if ( has_post_thumbnail() ) : ?>
	<?php $url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full', true ); ?>
	<figure class="entry-thumb zoomable">
		<a href="<?php echo $url[0] ?>" class="fancybox thumb" data-fancybox-group="fancybox[<?php the_ID(); ?>]">
			<?php the_post_thumbnail('ci_listing_thumb'); ?>
		</a>
		<div class="overlay"></div>
	</figure>
<?php endif; ?>

<?php $url = esc_url( get_post_meta($post->ID, 'ci_format_quote_cite', true) ); ?>

<div class="quote-text">
	<?php if ( empty($url) ) : ?>
		<blockquote>
			<p><?php echo get_post_meta($post->ID, 'ci_format_quote_text', true); ?></p>
			<cite><?php echo get_post_meta($post->ID, 'ci_format_quote_credit', true); ?></cite>
		</blockquote>
	<?php else: ?>
		<blockquote cite="<?php echo $url; ?>">
			<p><?php echo get_post_meta($post->ID, 'ci_format_quote_text', true); ?></p>
			<cite><a href="<?php echo $url; ?>"><?php echo get_post_meta($post->ID, 'ci_format_quote_credit', true); ?></a></cite>
		</blockquote>
	<?php endif; ?>
</div>
