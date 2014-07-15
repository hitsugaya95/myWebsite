(function() {

	// Update Collection
	$(document).on('click', '#modify-collection', function(e){
		$('#update-collection').submit();
	});

	// Update Album
	$(document).on('click', '#modify-album', function(e){
		$('#update-album').submit();
	});

	// Search Address
	$(document).on('click', '#search-address', function(e){
		$.ajax({
	        type: "POST",
	        url: "/admin/itinerary/search/",
	        data: $("#search-address-form").serialize(),
	        dataType: 'json'
	    })
	    .done(function(html) {
	        $('#latitude').val(html[0]);
	        $('#longitude').val(html[1]);
	    })
	    .fail(function(error) {
	        return false;
	    })
	});

	// add Address
	$(document).on('click', '#add-address', function(e){
		id = $(this).attr('data-id');
		$.ajax({
	        type: "POST",
	        url: "/admin/itinerary/" + id + "/add/",
	        data: $("#add-address-form").serialize(),
	        dataType: 'json'
	    })
	    .done(function(html) {
	        $(location).attr('href', "/admin/itinerary/" + id + "/");
	    })
	    .fail(function(error) {
	        return false;
	    })
	});

	// delete Address
	$(document).on('click', '#delete-itinerary', function(e){
		id = $(this).attr('data-id');
		collectionId = $(this).attr('data-collection-id');
		data = "itineraryId=" + id;
		$.ajax({
	        type: "POST",
	        url: "/admin/itinerary/delete/",
	        data: data,
	        dataType: 'json'
	    })
	    .done(function(html) {
	        $(location).attr('href', "/admin/itinerary/" + collectionId + "/");
	    })
	    .fail(function(error) {
	        return false;
	    })
	});

})();

