<div class="entry-content">

	<?php if ( !ci_setting('disable_meta_'.$format) ): ?>
		<h1 class="entry-title">
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr(sprintf(__('Permalink to: %s', 'ci_theme'), get_the_title())); ?>">
				<?php the_title(); ?>
			</a>
		</h1>
	
		<time datetime="<?php echo esc_attr(get_the_date('Y-m-d')); ?>">
			<?php
				echo sprintf(__('Posted at %s', 'ci_theme'), get_the_date());
	
				if ( ci_setting('show_author_info') )
				{
					echo sprintf(__('by %s %s', 'ci_theme'), get_the_author_meta('first_name'), get_the_author_meta('last_name'));
				}
			?>
		</time>
	<?php endif; ?>

	<?php
		if ( !ci_setting('disable_excerpt_'.$format) )
		{
			ci_e_content();
		}
	?>
</div><!-- .entry-content -->

<div class="entry-meta">
	<?php li_display_love_link(); ?>

	<a class="comment-no" href="<?php comments_link(); ?>"  title="<?php echo esc_attr(sprintf(__('%s Comments', 'ci_theme'), get_comments_number())); ?>">
		<?php echo get_comments_number(); ?>
	</a>

	<a class="permalink" href="<?php the_permalink(); ?>"  title="<?php echo esc_attr(sprintf(__('Permalink to: %s', 'ci_theme'), get_the_title())); ?>">
		<?php echo sprintf(__('Permalink to: %s', 'ci_theme'), get_the_title()); ?>
	</a>
</div><!-- .entry-meta -->

<?php
$withcomments = 1; // This is required so that comments can be shown in the homepage.
comments_template('/inc_listing-comments.php');
?>
