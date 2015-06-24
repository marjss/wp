<?php
/*
 * Template Name: Full Width Template
 */
?>
<?php get_header(); ?>
<?php while( have_posts() ) : the_post(); ?>
	<div id="page">
		<div id="main">
			<div class="row">
				<div class="twelve columns">

					<article id="post-<?php the_ID();?>" <?php post_class('entry box'); ?>>
						<div class="box-wrap">
							<?php if ( has_post_thumbnail() ): ?>
								<?php $url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full', true ); ?>
								<figure class="entry-thumb zoomable">
									<a href="<?php echo $url[0] ?>" class="fancybox thumb" data-fancybox-group="fancybox[<?php the_ID(); ?>]">
										<?php the_post_thumbnail($post->ID, 'ci_featured_full'); ?>
									</a>
									<div class="overlay"></div>
								</figure>
							<?php endif; ?>

							<div class="entry-content">
								<h1 class="entry-title">
									<?php the_title(); ?>
								</h1>

								<?php ci_e_content(); ?>
							</div> <!-- .entry-content -->
						</div>
					</article>

					<?php comments_template(); ?>

				</div> <!-- .twelve.columns -->
			</div> <!-- .row -->
		</div> <!-- #main -->
	</div> <!-- #page -->
<?php endwhile; ?>
<?php get_footer(); ?>
