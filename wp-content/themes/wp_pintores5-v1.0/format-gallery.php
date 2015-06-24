<?php
	$args = array(
		'post_type' => 'attachment',
		'numberposts' => -1,
		'post_status' => null,
		'post_parent' => $post->ID,
		'orderby' => 'menu_order'
	);
	$attachments = get_posts($args);
	$image_count = count($attachments);
	$slider_enabled = get_post_meta($post->ID, 'ci_cpt_post_slider', true)!='disabled' ? true : false;
?>
<?php if ( $slider_enabled ): ?>
	<?php if ( $image_count > 0 ): ?>
		<figure class="entry-thumb zoomable">
			<div class="flexslider">
				<ul class="slides">
					<?php
					foreach ( $attachments as $attachment )	{
						$attr = array(
							'alt'   => trim(strip_tags( get_post_meta($attachment->ID, '_wp_attachment_image_alt', true) )),
							'title' => trim(strip_tags( $attachment->post_title )),
							'width' => '""',
							'height' => '""'
						);
						$img_attrs = wp_get_attachment_image_src( $attachment->ID, 'full' );
						echo '<li><a class="fancybox" href="'.$img_attrs[0].'" data-fancybox-group="fancybox['.get_the_ID().']" title="">'.wp_get_attachment_image( $attachment->ID, 'ci_listing_gallery', false, $attr ).'</a></li>';
					}
					?>
				</ul>
			</div>
	
			<div class="overlay"></div>
		</figure>
	<?php endif; ?>
<?php endif; ?>
<?php include(locate_template('inc_listing-post-meta.php')); ?>
