<?php
/**
 * Displays the comments in listing pages (home, categories, etc).
 */
?>
<?php if ( comments_open() and !ci_setting('disable_front_comments') ): ?>

	<?php if ( have_comments()  ) : ?>
		<div class="entry-comments">
			<ol class="commentlist">
				<?php wp_list_comments( array(
					'callback' => 'ci_listings_comments',
					'page' => 1,
					'per_page' => ci_setting('front_page_comments_no'),
					'avatar' => 35
				)); ?>
			</ol>
		</div>
	<?php endif; // have_comments() ?>

	<?php if ( get_comments_number() > ci_setting('front_page_comments_no') ): ?>
		<a class="read-all-comments btn" href="<?php echo get_comment_link(); ?>"><?php _e('View More Comments', 'ci_theme'); ?></a>
	<?php endif; ?>

<?php endif; // comments_open() ?>
