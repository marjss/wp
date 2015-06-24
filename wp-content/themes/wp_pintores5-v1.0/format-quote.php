<?php if ( has_post_thumbnail() ): ?>
	<?php 
		$url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full', true );
	
		if ( ci_setting('feat_image_links_to') === 'feat_image' ) {
			$post_url = $url[0];
			$overlay = true;
			$zoomable = true;
		} else {
			$post_url = get_the_permalink();
			$overlay = false;
			$zoomable= false;
		}
	?>
	<figure class="entry-thumb <?php if ( $zoomable ) { echo 'zoomable'; } ?>">
		<a href="<?php echo $post_url ?>" class="fancybox thumb" data-fancybox-group="fancybox[<?php the_ID(); ?>]">
			<?php the_post_thumbnail('ci_listing_thumb'); ?>
		</a>
		<?php if ( $overlay ) : ?><div class="overlay"></div><?php endif; ?>
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

<?php include(locate_template('inc_listing-post-meta.php')); ?>
