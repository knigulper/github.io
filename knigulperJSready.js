jQuery(document).ready(function($){
	// browser window scroll (in pixels) after which the &quot;back to top&quot; link is shown
	var offset = 300,
		//browser window scroll (in pixels) after which the &quot;back to top&quot; link opacity is reduced
		offset_opacity = 1200,
		//duration of the top scrolling animation (in ms)
		scroll_top_duration = 700,
		//grab the &quot;back to top&quot; link
		$back_to_top = $(&#39;.cd-top&#39;);

	//hide or show the &quot;back to top&quot; link
	$(window).scroll(function(){
		( $(this).scrollTop() &gt; offset ) ? $back_to_top.addClass(&#39;cd-is-visible&#39;) : $back_to_top.removeClass(&#39;cd-is-visible cd-fade-out&#39;);
		if( $(this).scrollTop() &gt; offset_opacity ) { 
			$back_to_top.addClass(&#39;cd-fade-out&#39;);
		}
	});

	//smooth scroll to top
	$back_to_top.on(&#39;click&#39;, function(event){
		event.preventDefault();
		$(&#39;body,html&#39;).animate({
			scrollTop: 0 ,
		 	}, scroll_top_duration
		);
	});

});
