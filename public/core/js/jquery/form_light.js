$(document).ready(function(){
	$("input").focus(function() {
		$(this)
			.parent()
				.addClass("curFocus")
			.children("div")
				.toggle();
	});
	$("input").blur(function() {
		$(this)
			.parent()
				.removeClass("curFocus")
			.children("div")
				.toggle();
	});
	
	$('<div class="tl"></div><div class="tr"></div><div class="bl"></div><div class="br"></div>').appendTo("div.single-field");
});
