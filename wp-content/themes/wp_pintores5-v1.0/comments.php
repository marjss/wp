<?php
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die (__('Please do not load this page directly. Thanks!', 'ci_theme'));
	if ( post_password_required() ) {
		echo '<p class="nocomments">' . __('This post is password protected. Enter the password to view comments.', 'ci_theme') . '</p>';
		return;
	}
?>

<?php if (have_comments()): ?>
	<section id="comment-wrap" class="entry box">
		<div class="box-wrap">
		<div id="comments" class="box post-comments">
			<div class="box-content">
				<h3><?php comments_number(__('No comments', 'ci_theme'), __('1 comment', 'ci_theme'), __('% comments', 'ci_theme')); ?></h3>
			
				<ol id="comment-list" class="group">
					<?php wp_list_comments(array(
						'callback' => 'ci_comment'
					)); ?>
				</ol>
				<div class="comments-pagination"><?php paginate_comments_links(); ?></div>
		
			</div>
		</div>
		</div> <!-- .box-wrap -->
	</section> <!-- #comment-wrap -->
<?php else: ?>
	<?php if(!comments_open() and ci_setting('comments_off_message')=='enabled'): ?>
		<section id="comment-wrap" class="entry box">
			<div class="box-wrap">
				<p><?php _e('Comments are closed.', 'ci_theme'); ?></p>
			</div> <!-- .box-wrap -->
		</section> <!-- #comment-wrap -->
	<?php endif; ?>
<?php endif; ?>

<?php if(comments_open()):  ?>
	<section id="comment-form-wrap" class="entry box">
		<div class="box-wrap">
				<?php get_template_part('comment-form'); ?>
		</div> <!-- .box-wrap -->
	</section> <!-- #comment-form-wrap -->
<?php endif; ?>
