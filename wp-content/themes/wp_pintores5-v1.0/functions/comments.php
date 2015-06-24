<?php
if( !function_exists('ci_comment') ):
function ci_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
			?>
			<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
				<span class="comment-meta">
					<?php echo sprintf(_x('Posted by %1$s, at %2$s', 'posted by author at date/time', 'ci_theme'), '<strong>'.get_comment_author_link().'</strong>', '<time datetime="'.get_comment_date().'">'.get_comment_date().'</time>'); ?> &mdash; <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</span>
		
				<div class="comment-text group">
					<?php echo get_avatar($comment, 50); ?>
				
					<div class="comment-copy">
						<?php comment_text(); ?>
						<?php if ( $comment->comment_approved == '0' ) : ?>
							<p><em><?php _e( 'Your comment is awaiting moderation.', 'ci_theme' ); ?></em></p>
						<?php endif; ?>

					</div>
				</div>
			</li>
			<?php break; ?>
		
		<?php 	
			case 'pingback':
			case 'trackback':
		?>
			<li class="comment group pingback">
				<p><?php _e( 'Pingback:', 'ci_theme' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'ci_theme'), ' ' ); ?></p></li>
			<?php break; ?>
	<?php endswitch; ?>		
	<?php
}
endif;
?>
