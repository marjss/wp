jQuery(document).ready(function($) {

	$('.love-btn').live('click', function() {
		if($(this).hasClass('loved')) {
			//
			// Unlove
			//
			var post_id = $(this).data('post-id');
			var post_data = {
				action: 'unlove_it',
				item_id: post_id,
				love_it_nonce: love_it_vars.nonce
			};
			var that = $(this);
			$.post(love_it_vars.ajaxurl, post_data, function(response) {
				// Check legit responses (i.e. not 'failed')
				if(response == 'unloved' || response == 'user_unloved') {
					// Only process cookie for guests
					if(response == 'unloved'){	
						var $ids = $.cookie('ci_love_it_cookie');
						if($ids!==null)
						{
							$ids = $ids.split(',');
						
							for (var key in $ids) {
							    if ($ids[key] == post_id) {
							        $ids.splice(key, 1);
							    }
							}
							
							$.cookie('ci_love_it_cookie', $ids, { expires: 14, path: '/' });
						}
					}

					that.removeClass('loved');
					var count = that.find('.love-no').text();
					that.find('.love-no').text(parseInt(count) - 1);
				} else {
					alert(love_it_vars.error_message);
				}
			});
		}
		else
		{
			//
			// Love
			//
			var post_id = $(this).data('post-id');
			var post_data = {
				action: 'love_it',
				item_id: post_id,
				love_it_nonce: love_it_vars.nonce
			};
			var that = $(this);
			$.post(love_it_vars.ajaxurl, post_data, function(response) {
				// Check legit responses (i.e. not 'failed')
				if(response == 'loved' || response == 'user_loved') {
					// Only process cookie for guests
					if(response == 'loved'){
						var $ids = $.cookie('ci_love_it_cookie');
						
						// Let's try to convert the string into an array of IDs
						// $.cookie returns arrays as strings for some reason.
						if($ids!==null) {
							$ids = $ids.split(',');
						}
						else {
							$ids = new Array();
						}

						$ids.push(post_id);
						$.cookie('ci_love_it_cookie', $ids, { expires: 14, path: '/' });
					}
					
					that.addClass('loved');
					var count = that.find('.love-no').text();
					that.find('.love-no').text(parseInt(count) + 1);
				} else {
					alert(love_it_vars.error_message);
				}
			});
		}

		return false;
	});

});
