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

<?php include(locate_template('inc_listing-post-meta.php')); ?>
