jQuery(document).ready(function($){

	$('#gql_loadmore').on('click', function(event) {
		event.preventDefault();
	    // $.ajax({
	    //     data: {
	    //         action: 'related_post_ajax',
	    //     },
	    //     type: 'post',
	    //     url: child_ajax.ajaxurl,
	    //     beforeSend: function () {
	    //         // $('#loader').fadeIn(500);
	    //     },
	    //     success: function (response) {
	    //         $('#related_posts_ajax').append(response);
	    //     },
	    //     complete: function () {
	    //         // $('#loader').fadeOut(500);
	    //         // The .each() method is unnecessary here:
	    //     }
	    // });

	    $.ajax({
	    	dataType: 'json',
	    	url: child_ajax.jsonurl,
	    })
	    .done( function(response) {
	    	$.each( response, function(index, object ) {
				
				var feat_img = "";
	    		
	    		if( object.featured_media != 0 ){
	    			var feat_img = '<figure class="related-feature-image">' 
	    			+ '<img src="' + object.featured_media_src + '" alt="">'
	    			+ '</figure>';

	    		}
	    		var related_loop = '<aside class="related-posts clear">' 
	    		+ '<a href="'+object.link +'">' 
	    		+ '<h4 class="related-post-title">'+object.title.rendered +'</h1>' 
	    		+ '<div class="related-excerpt">' 
	    		+ feat_img
	    		+ '</div>'
	    		+ '<div class="related-excerpt">'
	    		+ object.excerpt.rendered
	    		+ '</div>'
	    		+ '<div class="related-author"> Posted By ' 
	    		+ object.author_name
	    		+ '</div>'
	    		+ '</a>';
	    		$("#related_posts_ajax").append( related_loop );
	    	})

	    })
	    .fail(function(){
	    	console.log( 'Disaster !!!' )
	    })
	    .always( function(){
	    	console.log( "Complete");
	    	console.log( child_ajax.jsonurl );
	    });
	});


});