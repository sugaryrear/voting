$(document).ready(function() {

	$('.to-top').click(function(e) {
		e.preventDefault();
		var target = this.hash;
		var $target = $(target);
		$('html, body').stop().animate({
			'scrollTop' : 0
		}, 900, 'swing');
	});

	var step = 1;

	$.post("templates/steps/step1.php", {
		url: window.location.href
	}, function(data) {
  		$("#step").html(data);
	});

	$.get("templates/stats_index.php",function(data) {
  		$("#stats").html(data);
	});

	setInterval(function() {
		$.get("templates/stats_index.php",function(data) {
	  		$("#stats").html(data);
		});
	}, 5000);

	$(document).on("submit", ".vote", function(event) {
		event.preventDefault();
		var field = $(this).find("#username");
		var input = field.val();

		if (input == "" || input.length < 3 || input.length > 15) {
			field.addClass("error");
			$('#error').html("Username must be between 3 and 15 characters.");
		} else {
			$.cookie('vote_user', input, { expires: 1, path: '/' });

			$('#step').fadeOut("fast", function() {
				getButtons();
				setInterval(function() {
					getButtons();
				}, 5000);
			});
		}
	});

	function getButtons() {
		$.post("templates/steps/step2.php", {
			url: window.location.href
		}, function(data) {
	  		$("#step").html(data).fadeIn();
		});
	}

	function isValidSite(url){
		$.post("templates/validate.php", {
			site: url
		}, function(data) {
			return data.toString() == "valid";
		});
	}

});
