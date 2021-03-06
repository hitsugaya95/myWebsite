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

	// add quote
	$(document).on('click', '#add-quote', function(e){
		$.ajax({
	        type: "GET",
	        url: "/admin/blog/quotes/add/",
	        data: $("#form-add-quote").serialize(),
	        dataType: 'json'
	    })
	    .done(function(html) {
	    	alert('La phrase a bien été ajouté')
	        $(location).attr('href', "/admin/blog/quotes/")
	    })
	    .fail(function(error) {
	    	alert('Une erreur est survenu, Veuillez réeesayer plus tard')

	        return false;
	    })
	});

	// modify quote
	$(document).on('click', '#modify-quote', function(e){
		id = $(this).attr('data-id')
		$.ajax({
	        type: "GET",
	        url: "/admin/blog/quotes/modify/"+id+"/",
	        data: $("#form-modify-quote").serialize(),
	        dataType: 'json'
	    })
	    .done(function(html) {
	    	alert('La phrase a bien été modifié')
	        $(location).attr('href', "/admin/blog/quotes/")
	    })
	    .fail(function(error) {
	    	alert('Une erreur est survenu, Veuillez réeesayer plus tard')

	        return false;
	    })
	});

	// add anecdote
	$(document).on('click', '#add-anecdote', function(e){
		$.ajax({
	        type: "GET",
	        url: "/admin/blog/anecdotes/add/",
	        data: $("#form-add-anecdote").serialize(),
	        dataType: 'json'
	    })
	    .done(function(html) {
	    	alert("L'anecdote a bien été ajouté")
	        $(location).attr('href', "/admin/blog/anecdotes/")
	    })
	    .fail(function(error) {
	    	alert('Une erreur est survenu, Veuillez réeesayer plus tard')

	        return false;
	    })
	});

	// modify anecdote
	$(document).on('click', '#modify-anecdote', function(e){
		id = $(this).attr('data-id')
		$.ajax({
	        type: "GET",
	        url: "/admin/blog/anecdotes/modify/"+id+"/",
	        data: $("#form-modify-anecdote").serialize(),
	        dataType: 'json'
	    })
	    .done(function(html) {
	    	alert("L'anecdote a bien été modifié")
	        $(location).attr('href', "/admin/blog/anecdotes/")
	    })
	    .fail(function(error) {
	    	alert('Une erreur est survenu, Veuillez réeesayer plus tard')

	        return false;
	    })
	});

	// add impression
	$(document).on('click', '#add-impression', function(e){
		$.ajax({
	        type: "GET",
	        url: "/admin/blog/impressions/add/",
	        data: $("#form-add-impression").serialize(),
	        dataType: 'json'
	    })
	    .done(function(html) {
	    	alert("L'impression a bien été ajouté")
	        $(location).attr('href', "/admin/blog/impressions/")
	    })
	    .fail(function(error) {
	    	alert('Une erreur est survenu, Veuillez réeesayer plus tard')

	        return false;
	    })
	});
	
	// modify impression
	$(document).on('click', '#modify-impression', function(e){
		id = $(this).attr('data-id')
		$.ajax({
	        type: "GET",
	        url: "/admin/blog/impressions/modify/"+id+"/",
	        data: $("#form-modify-impression").serialize(),
	        dataType: 'json'
	    })
	    .done(function(html) {
	    	alert("L'impression a bien été modifié")
	        $(location).attr('href', "/admin/blog/impressions/")
	    })
	    .fail(function(error) {
	    	alert('Une erreur est survenu, Veuillez réeesayer plus tard')

	        return false;
	    })
	});

	// publish comment in new comments
	$(document).on('click', '#publish-comment', function(e){
		id = $(this).attr('data-id')
		$.ajax({
	        type: "GET",
	        url: "/index_dev.php/admin/blog/impressions/published-comment/"+id+"/",
	        dataType: 'json',
	        beforeSend: function() { 
	        	$("#comment-loader-"+id).removeClass('loader-hidden')
	        }
	    })
	    .done(function(html) {
	    	alert("Le commentaire est maintenant afficher")
	    	$("#comment-loader-"+id).addClass('loader-hidden')
	        $("#comment-"+id).remove()
	    })
	    .fail(function(error) {
	    	alert('Une erreur est survenu, Veuillez réeesayer plus tard')
	    	$("#comment-loader-"+id).addClass('loader-hidden')
	        return false;
	    })
	});

	// publish comment
	$(document).on('click', '#publish-comment-from-impression', function(e){
		id = $(this).attr('data-id')
		commentLoader = $("#comment-loader-"+id)
		commentDiv = $("#comment-div-"+id)
		$.ajax({
	        type: "GET",
	        url: "/index_dev.php/admin/blog/impressions/published-comment/"+id+"/",
	        dataType: 'json',
	        beforeSend: function() { 
	        	commentLoader.removeClass('loader-hidden')
	        }
	    })
	    .done(function(html) {
	    	alert("Le commentaire est maintenant affiché")
	    	commentLoader.addClass('loader-hidden')
	    	commentDiv.parent().parent().children().eq(1).removeAttr('style')
	    	commentDiv.parent().parent().children().eq(1).attr('style', 'background-color:green')
	        commentDiv.empty()
	        commentDiv.removeClass('success')
	        commentDiv.addClass('danger')
	        commentDiv.append('<a id="unpublish-comment" data-id="'+id+'" >Supprimer</a>')
	    })
	    .fail(function(error) {
	    	alert('Une erreur est survenu, Veuillez réeesayer plus tard')
	    	commentLoader.addClass('loader-hidden')
	        return false;
	    })
	});

	// unpublish comment
	$(document).on('click', '#unpublish-comment', function(e){
		id = $(this).attr('data-id')
		commentLoader = $("#comment-loader-"+id)
		commentDiv = $("#comment-div-"+id)
		$.ajax({
	        type: "GET",
	        url: "/index_dev.php/admin/blog/impressions/unpublished-comment/"+id+"/",
	        dataType: 'json',
	        beforeSend: function() { 
	        	commentLoader.removeClass('loader-hidden')
	        }
	    })
	    .done(function(html) {
	    	alert("Le commentaire est maintenant supprimé")
	    	commentLoader.addClass('loader-hidden')
	    	commentDiv.parent().parent().children().eq(1).removeAttr('style')
	    	commentDiv.parent().parent().children().eq(1).attr('style', 'background-color:red')
	        commentDiv.empty()
	        commentDiv.removeClass('danger')
	        commentDiv.addClass('success')
	        commentDiv.append('<a id="publish-comment" data-id="'+id+'" >Publier</a>')
	    })
	    .fail(function(error) {
	    	alert('Une erreur est survenu, Veuillez réeesayer plus tard')
	    	commentLoader.addClass('loader-hidden')
	        return false;
	    })
	});

})();

