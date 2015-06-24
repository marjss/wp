<!doctype html>
<!--[if IE 8]> <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->

<head>

	<!-- Basic Page Needs
  ================================================== -->
	<meta charset="utf-8">
	<title><?php ci_e_title(); ?></title>

	<!-- Mobile Specific Metas
  ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<?php // JS files are loaded via /functions/scripts.php ?>

	<?php // CSS files are loaded via /functions/styles.php ?>

	<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>
<?php do_action('after_open_body_tag'); ?>

<header id="header">
	<div class="head-wrap">
		<hgroup id="logo" class="row <?php logo_class(); ?>">
			<?php ci_e_logo('<h1>', '</h1>'); ?>
			<?php ci_e_slogan('<h2>', '</h2>'); ?>
		</hgroup>

		<div id="nav-hold">
			<div class="row">
				<nav id="nav" class="nine columns">
					<?php
						if(has_nav_menu('ci_main_menu'))
							wp_nav_menu( array(
								'theme_location' 	=> 'ci_main_menu',
								'fallback_cb' 		=> '',
								'container' 		=> '',
								'menu_id' 			=> 'navigation',
								'menu_class' 		=> 'sf-menu'
							));
						else
							wp_page_menu();
					?>
				</nav><!-- /nav -->

				<div class="top-widgets three columns">
					<?php dynamic_sidebar('top-bar'); ?>
				</div>
			</div> <!-- .wrap -->
		</div> <!-- #nav-hold -->
	</div> <!-- .head-wrap -->
</header>
