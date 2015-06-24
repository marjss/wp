<form action="<?php echo esc_url(home_url('/')); ?>" class="searchform" method="get" role="search">
	<input size="27" type="text" title="<?php echo (get_search_query()!="" ? get_search_query() : __('Search', 'ci_theme') ); ?>" class="s" name="s">
	<input type="submit" class="searchsubmit btn" value="<?php _e('GO', 'ci_theme'); ?>">
</form>
