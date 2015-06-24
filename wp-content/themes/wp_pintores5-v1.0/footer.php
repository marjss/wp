
<section id="bottom-widget">
	<div class="row">
		<?php dynamic_sidebar('bottom-row-widgets'); ?>
	</div>
</section> <!-- #bottom-widget -->

<footer id="footer">
	<div class="row">
		<div class="footer-widget-holder four columns">
			<?php dynamic_sidebar('footer-col-1'); ?>
		</div>

		<div class="footer-widget-holder four columns">
			<?php dynamic_sidebar('footer-col-2'); ?>
		</div>

		<div class="footer-widget-holder four columns">
			<?php dynamic_sidebar('footer-col-3'); ?>
		</div>

<!--		<div class="footer-widget-holder three columns">
			<?php dynamic_sidebar('footer-col-4'); ?>
		</div>-->
	</div>

	<div id="credits">
		<div class="row">
			<span class="eleven columns">
				<?php echo apply_filters('ci_footer_credits', ''); ?>
			</span>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
