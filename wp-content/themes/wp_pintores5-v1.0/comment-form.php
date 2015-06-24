<?php
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die (__('Please do not load this page directly. Thanks!', 'ci_theme'));

ci_comment_form(array(
	'comment_notes_before' => '',
	'comment_notes_after'  => ''
));

?>

<?php
// Based on WP 3.0 wp-includes/comment-template.php / comment_form()
// Customized for CSSIgniter, keeping existing functionality, i.e. hooks, etc.
function ci_comment_form( $args = array(), $post_id = null ) {
	global $user_identity, $id;

	if ( null === $post_id )
		$post_id = $id;
	else
		$id = $post_id;

	$commenter = wp_get_current_commenter();

	$req = get_option( 'require_name_email' );
	$req_string = ($req ? '<span class="required">*</span>' : '');
	$aria_req = ( $req ? " aria-required='true'" : '' );

	$fields =  array(
		'author' => '<fieldset class="group"><p><input title="'.__('Your Name', 'ci_theme') .'" type="text" class="input-text" id="author" name="author" value="' . esc_attr( $commenter['comment_author'] ) . '"' . $aria_req . ' ></p>',
		'email'  => '<p><input type="text" title="'. __('Your Email', 'ci_theme').'" class="input-text" id="email" name="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '"' . $aria_req . ' ></p></fieldset>',
	);

	$required_text = sprintf( ' %s', '<span class="required">*</span>' );

	$defaults = array(
		'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
		'comment_field'        => '<fieldset><p><textarea title="'.__('Your Comment', 'ci_theme').'" cols="30" rows="4" id="comment" name="comment" aria-required="true"></textarea></p></fieldset>',
		'must_log_in'          => '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'ci_theme' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'logged_in_as'         => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'ci_theme' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
		'comment_notes_before' => '',
		'comment_notes_after'  => '',
		'id_form'              => 'commentform',
		'id_submit'            => 'submit',
		'title_reply'          => __( 'Post your comment', 'ci_theme'),
		'title_reply_to'       => __( 'Reply to %s', 'ci_theme'),
		'cancel_reply_link'    => __( 'Cancel reply', 'ci_theme'),
		'label_submit'         => __( 'Submit', 'ci_theme'),
	);

	$args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );

?>
<?php if ( comments_open() ) : ?>
	<?php do_action( 'comment_form_before' ); ?>

	<h3 id="respond" class="comments"><?php comment_form_title( $args['title_reply'], $args['title_reply_to'] ); ?></h3>

	<div class="post-form innerbox">
		<?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
			<?php echo $args['must_log_in']; ?>
			<?php do_action( 'comment_form_must_log_in_after' ); ?>
		<?php else : ?>
			<form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" class="group" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>">
				<?php do_action( 'comment_form_top' ); ?>
				<?php if ( is_user_logged_in() ) : ?>
					<?php echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity ); ?>
					<?php do_action( 'comment_form_logged_in_after', $commenter, $user_identity ); ?>
				<?php else : ?>
					<?php echo $args['comment_notes_before']; ?>
					<?php
						do_action( 'comment_form_before_fields' );
						foreach ( (array) $args['fields'] as $name => $field ) {
							echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
						}
						do_action( 'comment_form_after_fields' );
					?>
				<?php endif; ?>
				<?php echo apply_filters( 'comment_form_field_comment', $args['comment_field'] ); ?>
				<?php echo $args['comment_notes_after']; ?>

				<input type="submit" name="submit" class="btn" id="<?php echo esc_attr( $args['id_submit'] ); ?>" value="<?php echo esc_attr( $args['label_submit'] ); ?>">
				<?php comment_id_fields(); ?>

				<?php do_action( 'comment_form', $post_id ); ?>
			</form>
		<?php endif; ?>
	</div>
	<?php do_action( 'comment_form_after' ); ?>
<?php else : ?>
	<?php do_action( 'comment_form_comments_closed' ); ?>
<?php endif; ?>
<?php
}
?>
