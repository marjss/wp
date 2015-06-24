<?php get_header(); ?>
	<div id="page">
		<div id="main">
			<div class="row">
				<div class="<?php ci_e_setting('main_content_cols'); ?> columns">
					<article class="entry box">
						<div class="box-wrap">

							<div class="entry-content">
								<h1 class="entry-title">
									<?php _e( 'Not Found', 'ci_theme' ); ?>
								</h1>

								<p><?php _e( 'Oh, no! The page you requested could not be found. Perhaps searching will help...', 'ci_theme' ); ?></p>
								<?php get_search_form(); ?>
							</div> <!-- .entry-content -->
						</div>
					</article>

					<?php
						if ( ci_setting('layout') == 'default' )
							comments_template();
					?>
				</div> <!-- .nine.columns -->

				<?php
					if ( ci_setting('layout') == 'default' ) :
						get_sidebar();
					else :
						get_sidebar('alt');
					endif;
				?>
			</div>
		</div> <!-- #main -->
	</div> <!-- #page -->

<?php get_footer(); ?>
