<?php
//
// Displays the love it button
//
function li_display_love_link() {
	global $post;

	// retrieve the total love count for this item
	$love_count = li_get_love_count($post->ID);

	if ( !li_user_has_loved_post(get_the_ID() ))
	{
		if (is_singular())
		{
			$output = '<a data-post-id="' . get_the_ID() . '" class="love-btn" href="#" title="'.__('Love this.', 'ci_theme').'">'.'<span class="love-no">'.$love_count.'</span></a>';
		}
		else
		{
			$output = '<a data-post-id="' . get_the_ID() . '" class="love-btn" href="#" title="'.__('Love this.', 'ci_theme').'">'.'<span class="love-no">'.$love_count.'</span></a>';
		}
	}
	else
	{
		if ( is_singular() )
		{
			$output = '<a data-post-id="' . get_the_ID() . '" class="love-btn loved" href="#" title="'.__('You love this. Unlove?', 'ci_theme').'">'.'<span class="love-no">'.$love_count.'</span></a>';
		}
		else
		{
			$output = '<a data-post-id="' . get_the_ID() . '" class="love-btn loved" href="#" title="'.__('You love this. Unlove?', 'ci_theme').'">'.'<span class="love-no">'.$love_count.'</span></a>';
		}
	}

	echo $output;
}

// check whether a user has loved an item
function li_user_has_loved_post($post_id)
{
	$loves = li_get_user_loved_posts();

	if ( is_array($loves) and in_array($post_id, $loves) )
	{
		return true;
	}
	else
	{
		return false;
	}

}

// Retrieve the current visitor's loved posts.
function li_get_user_loved_posts()
{
	if(!is_user_logged_in())
	{
		if ( !empty($_COOKIE['ci_love_it_cookie']) )
		{
			$cookie = $_COOKIE['ci_love_it_cookie'];
			$loves = explode(",", $cookie);
		}
		else
		{
			return array();
		}
	}
	else
	{
		$uid = get_current_user_id();
		$loves = get_user_meta($uid, 'pinfinity_loved_items', true);
	}

	return $loves;
}

// increments a love count
function li_mark_post_as_loved($post_id)
{
	// retrieve the love count for $post_id
	$love_count = get_post_meta($post_id, '_li_love_count', true);
	if($love_count)
		$love_count = $love_count + 1;
	else
		$love_count = 1;

	if(update_post_meta($post_id, '_li_love_count', $love_count))
	{
		if(is_user_logged_in())
		{
			$uid = get_current_user_id();
			$loves = get_user_meta($uid, 'pinfinity_loved_items', true);
			if(!is_array($loves))
				$loves = array();
			$loves[] = $post_id;
			update_user_meta($uid, 'pinfinity_loved_items', $loves);
		}

		return true;
	}

	return false;
}

// decrements a love count
function li_unmark_post_as_loved($post_id)
{
	// retrieve the love count for $post_id
	$love_count = get_post_meta($post_id, '_li_love_count', true);
	if($love_count)
		$love_count = $love_count - 1;
	else
		$love_count = 0;

	if(update_post_meta($post_id, '_li_love_count', $love_count))
	{
		if(is_user_logged_in())
		{
			$uid = get_current_user_id();
			$loves = get_user_meta($uid, 'pinfinity_loved_items', true);
			if(is_array($loves))
			{
				$key = array_search($post_id, $loves);
				if($key!==false)
				{
					unset($loves[$key]);
					update_user_meta($uid, 'pinfinity_loved_items', $loves);
				}
			}
		}

		return true;
	}

	return false;
}


// returns a love count for a post
function li_get_love_count($post_id) {
	$love_count = get_post_meta($post_id, '_li_love_count', true);
	if($love_count)
		return $love_count;
	return 0;
}

// processes the ajax request
add_action('wp_ajax_love_it', 'li_process_love');
add_action('wp_ajax_nopriv_love_it', 'li_process_love');
function li_process_love() {
	if ( isset( $_POST['item_id'] ) && wp_verify_nonce($_POST['love_it_nonce'], 'love-it-nonce') )
	{
		if( li_mark_post_as_loved(intval($_POST['item_id'])) )
		{
			if(is_user_logged_in())
				echo 'user_loved';
			else
				echo 'loved';
		}
		else
		{
			echo 'failed';
		}
	}
	die();
}

add_action('wp_ajax_unlove_it', 'li_process_unlove');
add_action('wp_ajax_nopriv_unlove_it', 'li_process_unlove');
function li_process_unlove() {
	if ( isset( $_POST['item_id'] ) && wp_verify_nonce($_POST['love_it_nonce'], 'love-it-nonce') )
	{
		if( li_unmark_post_as_loved(intval($_POST['item_id'])) )
		{
			if(is_user_logged_in())
				echo 'user_unloved';
			else
				echo 'unloved';
		}
		else
		{
			echo 'failed';
		}
	}
	die();
}

if ( !function_exists('li_front_end_js') ) {
	function li_front_end_js() {
		wp_enqueue_script('love-it', get_child_or_parent_file_uri('/js/loveit.js'), array('jquery'), false, true);
		wp_localize_script( 'love-it', 'love_it_vars',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce('love-it-nonce'),
				'already_loved_message' => __('You have already loved this item.', 'ci_theme'),
				'error_message' => __('Sorry, there was a problem processing your request.', 'ci_theme')
			)
		);
	}
	add_action('wp_enqueue_scripts', 'li_front_end_js');
}
?>
