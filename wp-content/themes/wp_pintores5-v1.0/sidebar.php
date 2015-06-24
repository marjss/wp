<div class="sidebar box-item <?php ci_e_setting('sidebar_content_cols'); ?> columns">
	<div class="box-wrap">
		<?php
			if ( is_page() ) {
				dynamic_sidebar('page-sidebar');
			}
			else {
				dynamic_sidebar('blog-sidebar');
			}
		?>
	</div>
</div>
