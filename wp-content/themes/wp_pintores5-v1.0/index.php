<?php get_header(); ?>

<div id="page">
	<div id="main">
		<div id="box-container">
			<div id="entry-list" class="row">

				<?php
					global $paged;
	
					$max_page = (int) $wp_query->max_num_pages;
					if ( $max_page > (int) 1 )
						$paged = $wp_query->query_vars['paged']<=1 ? (int)1 : $wp_query->query_vars['paged'];
				?>

				<?php // Show this widget area only on the first page and only if its populated with widgets ?>
				<?php if ( $paged < 2 and is_active_sidebar('first-box')  ): ?>
					<article class="widget-box entry box-item <?php ci_e_setting('listing_columns'); ?> columns">
						<div class="box-wrap">
							<?php dynamic_sidebar('first-box'); ?>
						</div>
					</article>
				<?php endif; ?>

				<?php if ( have_posts() ): ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php
							$format = get_post_format($post->ID);
							if ( !$format ) {
								$format = 'standard';
							}
						?>
						<article id="post-<?php the_ID();?>" <?php post_class('entry box-item '.ci_setting('listing_columns').' columns format-'.$format); ?>>
							<div class="box-wrap">
								<?php include(locate_template('format-'.$format.'.php')); ?>
							</div>
						</article>
					<?php endwhile; ?>

					<?php if( is_active_sidebar('last-box-repeat') and (is_front_page() ) ): ?>
						<article class="widget-box entry box-item <?php ci_e_setting('listing_columns'); ?> columns">
							<div class="box-wrap">
								<?php dynamic_sidebar('last-box-repeat'); ?>
							</div>
						</article>
					<?php endif; ?>
				<?php endif; // have_posts() ?>

			</div> <!-- .entry-list -->
		</div>

		<?php if ( ci_setting('disable_infinitescroll') == 'enabled' ) : ?>
			<a class="load-more" href="#"><?php _e('Load More', 'ci_theme'); ?></a>
		<?php else:  ?>
			<a class="load-more" href="#" style="display: none;"><?php _e('Load More', 'ci_theme'); ?></a>
		<?php endif; ?>

		<div class="row pagination-row">
			<?php ci_pagination(); ?>
		</div>
	</div> <!-- #main -->
</div> <!-- #page -->

<?php get_footer(); ?>
