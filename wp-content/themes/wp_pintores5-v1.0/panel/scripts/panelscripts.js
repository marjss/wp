jQuery(document).ready(function($) {
 
	// delay equivalent for jQuery 1.3.2
	$.fn.hold = function(time){
		var o = $(this);
		o.queue(function(){
			setTimeout(function() {
				o.dequeue();
			}, time);
		});
		return this;
	};

	 //tabs
	$('.tab').hide();
	$('.one').show();

	$('#ci_sidebar ul li a').click( function() {
		$(this).addClass('active').parents('li').siblings().find('a').removeClass('active');
		var tab = $(this).attr('rel');
		$('#ci_options div#'+tab).show().siblings().hide();
		return false;
	});
 
	//form submission 
	$("#ci_panel .success").hide();
	$("#ci_panel .resetbox").hold(2000).fadeOut(500);
	
	$('input.save').click(function() {
		var theoptions = $('#theform').serialize();
		$.ajax({
			type: "POST",
			url: "options.php",
			data: theoptions,
			beforeSend: function() { $("#ci_panel .success").html('<p class="modal-working">Working...</p>').fadeIn(500); },
			success: function(response){ $("#ci_panel .success").html('<p class="modal-saved">Settings saved!</p>').hold(1000).fadeOut(500); }
		});
		return false;  
	});	 


	$('.colorpckr').ColorPicker({
		onSubmit: function(hsb, hex, rgb, el) {
			$(el).val(hex);
			$(el).ColorPickerHide();
		},
		onBeforeShow: function () {
			$(this).ColorPickerSetColor(this.value);
		}
	}).bind('keyup', function(){
		$(this).ColorPickerSetColor(this.value);
	});

	$('.toggle-button').each(function(){
		var isEnabled = $(this).attr('checked');
		//var pane = $(this).parents('div.tab').children('.toggle-pane');
		var pane = $(this).parent().next('.toggle-pane');
		if (isEnabled) { pane.hide(); } else { pane.show(); }
	});
	
	$('.toggle-button').click(function(){
		//var pane = $(this).parents('div.tab').children('.toggle-pane');
		var pane = $(this).parent().next('.toggle-pane');
		if ($(this).attr('checked')=="checked") {
			pane.fadeOut();
		}
		else {
			pane.fadeIn();
		}
	});
	//$('.toggle-button').click();


	$('input#ci_create_sample_content').click(function() {
		var button = $(this);
		var answer = confirm('Are you sure? Sample content will be created!');		
		if(answer)
		{
			var data = { action: 'ci_create_sample_content'	};
			$.ajax({
				type: "POST",
				url: ajaxurl,
				data: data,
				beforeSend: function() { $("#ci_panel .success").html('<p class="modal-working">Working...</p>').fadeIn(500); }, 
				success: function(response){ 
					$("#ci_panel .success").html('<p class="modal-saved">Sample content created!</p>').hold(2000).fadeOut(500); 
					button.fadeOut();
				}
			});
		}
		return false; 
	});	 
	$('input#ci_delete_sample_content').click(function() {
		var button = $(this);
		var answer = confirm('Are you sure? All sample content will be lost!');		
		if(answer)
		{
			var data = { action: 'ci_delete_sample_content'	};
			$.ajax({
				type: "POST",
				url: ajaxurl,
				data: data,
				beforeSend: function() { $("#ci_panel .success").html('<p class="modal-working">Working...</p>').fadeIn(500); }, 
				success: function(response){ 
					$("#ci_panel .success").html('<p class="modal-saved">Sample content deleted!</p>').hold(2000).fadeOut(500); 
					button.fadeOut();
				}
			});
		}
		return false;  
	});

});
