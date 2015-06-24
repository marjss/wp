<?php
$has_thumb = false;
if ( has_post_thumbnail() ):
	$has_thumb = true;
	$url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full', true );
	?>
	<figure class="entry-thumb zoomable">
		<a href="<?php echo $url[0]; ?>" class="fancybox thumb" data-fancybox-group="fancybox[<?php the_ID(); ?>]">
			<?php the_post_thumbnail('ci_listing_thumb'); ?>
		</a>
		<div class="overlay"></div>
	</figure>
<?php endif; ?>

<?php $url = get_post_meta($post->ID, 'ci_format_audio_url', true); ?>

<div class="audio-wrap <?php if ( $has_thumb) { echo 'with-thumb'; } ?>" data-audio-id="<?php the_ID(); ?>" data-audio-file="<?php echo esc_attr($url); ?>">
	<div id="jp-<?php the_ID(); ?>" class="jp-jplayer"></div>

	<div id="jp-play-<?php the_ID(); ?>" class="jp-audio">
		<div class="jp-type-single">
			<div class="jp-gui jp-interface">
				<ul class="jp-controls">
					<li><a href="#" class="jp-back"><?php _e('Back', 'ci_theme'); ?></a></li>
					<li><a href="#" class="jp-play" tabindex="1"><?php _e('Play', 'ci_theme'); ?></a></li>
					<li><a href="#" class="jp-pause" tabindex="1"><?php _e('Pause', 'ci_theme'); ?></a></li>
					<li><a href="#" class="jp-forward"><?php _e('Forward', 'ci_theme'); ?></a></li>
				</ul>

				<div class="jp-progress">
					<div class="jp-seek-bar">
						<div class="jp-play-bar"></div>
					</div>
				</div>

				<div class="jp-current-time"></div>

			</div>
		</div>
	</div>
</div> <!-- .audio-wrap -->
