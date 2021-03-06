jQuery(window).load(function() {

	//
	// Flexslider
	//
	if( jQuery(".flexslider").length > 0) {
		jQuery(".flexslider").flexslider({
			'controlNav': false,
			'directionNav': true,
			'animation': ThemeOption.slider_effect,
			'slideDirection': ThemeOption.slider_direction,
			'slideshow': Boolean(ThemeOption.slider_autoslide),
			'slideshowSpeed': Number(ThemeOption.slider_speed),
			'animationDuration': Number(ThemeOption.slider_duration)
		});
	}

	jQuery('#entry-list').isotope({
		animationOptions: {
			duration: 750,
			easing: 'linear',
			queue: false
		},
		itemSelector: 'article.entry',
		transformsEnabled: true
	});


	// Page width calculations

	jQuery(window).resize(setContainerWidth);
	var $box = jQuery(".box-item");

	function setContainerWidth() {
		var columnNumber = parseInt((jQuery(window).width()) / ($box.outerWidth(true))),
			containerWidth = (columnNumber * $box.outerWidth(true));

		if ( columnNumber > 1 )  {
			jQuery("#box-container").css("width",containerWidth+'px');
		} else {
			jQuery("#box-container").css("width", "100%");
		}
	}

	setContainerWidth();
	loadAudioPlayer(ThemeOption.swfPath);

	//bottom twitter widget, add flexslider classes
	var twitter_item  = jQuery("#bottom-widget .widget_ci_twitter_widget");
	if ( twitter_item.length ) {
		twitter_item.find('.tul').addClass("flexslider");
		twitter_item.find('ul').addClass("slides");

		twitter_item.flexslider({
			directionNav: false,
			controlNav: false
		});
	}

});

jQuery(document).ready(function($) {

	$.fn.formLabels();

	// Main navigation
	$('ul#navigation').superfish({
	    delay:       1000,
	    animation:   {opacity:'show',height:'show'},
	    speed:       'fast',
	    dropShadows: false
	});
	
	// Responsive Menu
    // Create the dropdown base
    $("<select class='alt-nav' />").appendTo("#nav");

    // Create default option "Go to..."
    $("<option />", {
       "selected": "selected",
       "value"   : "",
       "text"    : "Go to..."
    }).appendTo("#nav select");

    // Populate dropdown with menu items
    $("#navigation a").each(function() {
     var selected = "";
     var el = $(this);
     var cl = $(this).parents('li').hasClass('current-menu-item');
     if (cl) {
	     $("<option />", { "value": el.attr("href"), "text" : el.text(), "selected": selected }).appendTo("#nav select");
	 }
	 else {
		 $("<option />", { "value": el.attr("href"), "text" : el.text() }).appendTo("#nav select");
	 }    
    });

    $(".alt-nav").change(function() {
      window.location = $(this).find("option:selected").val();
    });

	// FitVids
	$(".format-video .entry-thumb").fitVids();

	$(".fancybox").fancybox({
		fitToView	: true
	});



});



function loadAudioPlayer(domain) {
	jQuery(".format-audio").each(function() {
		var that = jQuery(this);
		var $audio_id = jQuery(this).find(".audio-wrap").data("audio-id"),
			$media = jQuery(this).find(".audio-wrap").data("audio-file"),
			$play_id = '#jp-'+$audio_id,
			$play_ancestor = '#jp-play-'+$audio_id,
			$extension = $media.split('.').pop();

		if ( $extension.toLowerCase() =='mp3' ) {
			var $extension = 'mp3';
		} else if ( $extension.toLowerCase() =='mp4' ||  $extension.toLowerCase() =='m4a' ) {
			var $extension = 'm4a';
		} else if ( $extension.toLowerCase() =='ogg' || $extension.toLowerCase() =='oga' ) {
			var $extension = 'oga';
		} else {
			var $extension = '';
		}

		jQuery($play_id).jPlayer({
			ready: function (event) {
				var playerOptions = {
					$extension: $media
				};
				playerOptions[$extension] = $media;
				jQuery(this).jPlayer("setMedia", playerOptions);
			},
			swfPath: domain,
			supplied: $extension,
			wmode: 'window',
			cssSelectorAncestor: $play_ancestor
		});

		var ffaction;
		var rwaction;
		var rewinding = false;
		var fastforward = false;
		var paused = false;

		//FastForward
		that.find(".jp-forward").live("mousedown", function(e) {
			fastforward = true;
			//Pause the player
			jQuery($play_id).jPlayer("pause");
			FastforwardTrack();
			ffaction = window.setInterval(function () { FastforwardTrack() }, 200);
		});

		that.find(".jp-forward").live("mouseup", function(e) {
			fastforward = false;
			window.clearInterval(ffaction);
			jQuery($play_id).jPlayer("play");
		});

		//Rewind
		that.find(".jp-back").live("mousedown", function(e) {
			rewinding = true;
			//Pause the player
			jQuery($play_id).jPlayer("pause");
			RewindTrack();
			rwaction = window.setInterval(function () { RewindTrack() }, 200);
		});

		that.find(".jp-back").live("mouseup", function(e) {
			rewinding = false;
			window.clearInterval(rwaction);
			jQuery($play_id).jPlayer("play");
		});

		function GetPlayerProgress() {
			return (that.find('.jp-play-bar').width() / that.find('.jp-seek-bar').width() * 100);
		}

		function RewindTrack() {
			//Get current progress and decrement
			var currentProgress = GetPlayerProgress();
			var futureProgress = currentProgress - 5;
			//If it goes past the starting point - stop rewinding and pause
			if (futureProgress <= 0) {
				rewinding = false;
				window.clearInterval(rwaction);
				jQuery($play_id).jPlayer("pause", 0);
			}
			//Continue rewinding
			else {
				jQuery($play_id).jPlayer("playHead", parseInt(futureProgress, 10));
			}
		}

		function FastforwardTrack() {
			//Get current progress and increment
			var currentProgress = GetPlayerProgress();
			var futureProgress = currentProgress + 5;
			//If the percentage exceeds the max - stop fast forwarding at the end.
			if (futureProgress >= 100) {
				fastforward = false;
				window.clearInterval(ffaction);
				jQuery($play_id).jPlayer("playHead", parseInt(jQuery($play_id).find('.jp-duration').text().replace(':', '')));
			}
			else {
				jQuery($play_id).jPlayer("playHead", parseInt(futureProgress, 10));
			}
		}
	});
}
