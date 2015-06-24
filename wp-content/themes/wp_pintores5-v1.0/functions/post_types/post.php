<?php
//
// Normal Post related functions.
//
add_action('admin_init', 'ci_add_cpt_post_meta');
add_action('save_post', 'ci_update_cpt_post_meta');

if( !function_exists('ci_add_cpt_post_meta') ):
function ci_add_cpt_post_meta()
{
	add_meta_box("ci_format_box_gallery", __('Gallery Details', 'ci_theme'), "ci_add_format_gallery_meta_box", "post", "normal", "high");
	add_meta_box("ci_format_box_image", __('Image Details', 'ci_theme'), "ci_add_format_image_meta_box", "post", "normal", "high");
	add_meta_box("ci_format_box_quote", __('Quote Details', 'ci_theme'), "ci_add_format_quote_meta_box", "post", "normal", "high");
	add_meta_box("ci_format_box_video", __('Video Details', 'ci_theme'), "ci_add_format_video_meta_box", "post", "normal", "high");
	add_meta_box("ci_format_box_audio", __('Audio Details', 'ci_theme'), "ci_add_format_audio_meta_box", "post", "normal", "high");
	add_meta_box("ci_format_box_link", __('Link Details', 'ci_theme'), "ci_add_format_link_meta_box", "post", "normal", "high");
}
endif;

if( !function_exists('ci_update_cpt_post_meta') ):
function ci_update_cpt_post_meta($post_id)
{
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
	if (isset($_POST['post_view']) and $_POST['post_view']=='list') return;
	
	if (isset($_POST['post_type']) and $_POST['post_type'] == "post")
	{
		update_post_meta($post_id, "ci_format_quote_text", (isset($_POST["ci_format_quote_text"]) ? $_POST["ci_format_quote_text"] : '') );
		update_post_meta($post_id, "ci_format_quote_cite", (isset($_POST["ci_format_quote_cite"]) ? $_POST["ci_format_quote_cite"] : '') );
		update_post_meta($post_id, "ci_format_quote_credit", (isset($_POST["ci_format_quote_credit"]) ? $_POST["ci_format_quote_credit"] : '') );
		update_post_meta($post_id, "ci_format_video_url", (isset($_POST["ci_format_video_url"]) ? $_POST["ci_format_video_url"] : '') );
		update_post_meta($post_id, "ci_format_audio_url", (isset($_POST["ci_format_audio_url"]) ? $_POST["ci_format_audio_url"] : '') );
		update_post_meta($post_id, "ci_format_link_url", (isset($_POST["ci_format_link_url"]) ? $_POST["ci_format_link_url"] : '') );
		update_post_meta($post_id, "ci_format_link_nofollow", (isset($_POST["ci_format_link_nofollow"]) ? $_POST["ci_format_link_nofollow"] : '') );
	}
}
endif;

if( !function_exists('ci_add_format_gallery_meta_box') ):
function ci_add_format_gallery_meta_box()
{
	?>
	<p><?php echo sprintf(__('You need to upload (or assign) two images to the post. This can be done by clicking <a href="#" class="ci-upload">here</a>, or pressing the <strong>Upload Images</strong> button bellow, or via the <strong>Add Media <img src="%s" /> button</strong>, just below the post\'s title.', 'ci_theme'), get_admin_url().'/images/media-button.png'); ?></p>
	<p><input type="button" class="button ci-upload" value="<?php echo esc_attr(__('Upload Images', 'ci_theme')); ?>" /></p>
	<?php
}
endif;

if( !function_exists('ci_add_format_image_meta_box') ):
function ci_add_format_image_meta_box()
{
	?>
	<p><?php sprintf(__('You need to upload (or assign) a <strong>Featured Image</strong> to the post. This can be done by clicking <a href="#" class="ci-upload">here</a>, or pressing the <strong>Upload Images</strong> button bellow, or via the <strong>Add Media <img src="%s" /> button</strong>, just below the post\'s title.', 'ci_theme'), get_admin_url().'/images/media-button.png'); ?></p>
	<p><?php _e('Once you have uploaded or selected your image, click on the <strong>Use as featured image</strong> link.', 'ci_theme'); ?></p>
	<p><input type="button" class="button ci-upload" value="<?php echo esc_attr(__('Upload Images', 'ci_theme')); ?>" /></p>
	<?php
}
endif;

if( !function_exists('ci_add_format_quote_meta_box') ):
function ci_add_format_quote_meta_box(){
	global $post;
	$text = get_post_meta($post->ID, 'ci_format_quote_text', true);
	$cite = get_post_meta($post->ID, 'ci_format_quote_cite', true);
	$credit = get_post_meta($post->ID, 'ci_format_quote_credit', true);
	?>
	<p class="form-field">
		<label for="ci_format_quote_text"><?php _e('Quoted text:', 'ci_theme'); ?></label>
		<textarea id="ci_format_quote_text" name="ci_format_quote_text" class="large-text code" wrap="virtual"><?php echo esc_textarea($text); ?></textarea>
	</p>
	<p><?php _e('Write the name of your source here. Always give credit to the person who said it, rather than the place you found it. Even if it is something you found on a website, try to find out who wrote it, and write the author\'s name instead of the website\'s/company\'s name.', 'ci_theme'); ?></p>
	<p class="form-field">
		<label for="ci_format_quote_credit" class="ci-block"><?php _e('Cite:', 'ci_theme'); ?></label>
		<input type="text" id="ci_format_quote_credit" name="ci_format_quote_credit" class="code" value="<?php echo esc_attr($credit); ?>" />
	</p>
	<p><?php _e('If your quote is something you found online, you can enter the URL here, and the name you entered above will become a link.', 'ci_theme'); ?></p>
	<p class="form-field">
		<label for="ci_format_quote_cite" class="ci-block"><?php _e('Citation URL:', 'ci_theme'); ?></label>
		<input type="text" id="ci_format_quote_cite" name="ci_format_quote_cite" class="code" value="<?php echo esc_attr($cite); ?>" />
	</p>
	<?php
}
endif;

if( !function_exists('ci_add_format_video_meta_box') ):
function ci_add_format_video_meta_box(){
	global $post;
	$url = get_post_meta($post->ID, 'ci_format_video_url', true);
	?>
	<p><?php _e('In the following box, you can simply enter the URL of a supported website\'s video. It needs to start with <strong>http://</strong> (E.g. <em>http://www.youtube.com/watch?v=4Z9WVZddH9w</em>). A list of supported websites can be <a href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F">found here</a>.', 'ci_theme'); ?></p>
	<p><?php _e('If you want to embed a video from an unsupported website, copy the video\'s embed code and paste it into the same box below.', 'ci_theme'); ?></p>
	<p><?php _e('Your video will be resized automatically to fit the width of the post area.', 'ci_theme'); ?></p>
	<label for="ci_format_video_url"><?php _e('The URL to the video to be embedded:', 'ci_theme'); ?></label>
	<input id="ci_format_video_url" type="text" class="code" name="ci_format_video_url" value="<?php echo esc_attr($url); ?>" size="100" /> 
	<?php
}
endif;

if( !function_exists('ci_add_format_audio_meta_box') ):
function ci_add_format_audio_meta_box(){
	global $post;
	$url = get_post_meta($post->ID, 'ci_format_audio_url', true);
	?>
	<p><?php _e('In the following box, you can simply enter the URL of an <strong>MP3</strong> file, or click on the <strong>Upload</strong> button to upload and/or select an MP3 file from within WordPress.', 'ci_theme'); ?></p>
	<label for="ci_format_audio_url"><?php _e('The URL of the MP3 file to embed:', 'ci_theme'); ?></label>
	<input id="ci_format_audio_url" type="text" class="code uploaded" name="ci_format_audio_url" size="100" value="<?php echo esc_url($url); ?>" /> 
	<input id="ci-upload-audio-button" type="button" class="button ci-upload" value="<?php echo esc_attr(__('Upload MP3', 'ci_theme')); ?>" />
	<?php
}
endif;

if( !function_exists('ci_add_format_link_meta_box') ):
function ci_add_format_link_meta_box(){
	global $post;
	$url = get_post_meta($post->ID, 'ci_format_link_url', true);
	$nofollow = get_post_meta($post->ID, 'ci_format_link_nofollow', true);
	?>
	<p><?php _e('Linked posts are just like normal posts, but their title redirects to the URL you enter instead of the normal post content. You may optionally mark the link with the <strong>nofollow</strong> attribute, in case you link against a naughty website which you don\'t want search engines to affiliate you with.', 'ci_theme'); ?></p>
	<p class="form-field">
		<label for="ci_format_link_url"><?php _e('URL:', 'ci_theme'); ?></label>
		<input type="text" id="ci_format_link_url" name="ci_format_link_url" class="code" value="<?php echo esc_url($url); ?>" />
	</p>
	<p>
		<input type="checkbox" name="ci_format_link_nofollow" id="ci_format_link_nofollow" value="nofollow" <?php echo ($nofollow=="nofollow" ? 'checked="checked"' : ''); ?> /><label for="ci_format_link_nofollow"><?php _e('Add <strong><code>rel="nofollow"</code></strong> to link.', 'ci_theme'); ?></label>
	</p>
	<?php
}
endif;
?>
