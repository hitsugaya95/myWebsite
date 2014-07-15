(function() {
	// Title Bounce
	$(document).on('mouseenter', '#title', function(e){
		$('#title').addClass('animated bounce');
	});
	$(document).on('mouseleave', '#title', function(e){
		$('#title').removeClass('animated bounce');
	});

	// Animation for album index
	$(document).on('mouseenter', '#collection-img-div', function(e){
		$(this).addClass('animated pulse');
	});
	$(document).on('mouseleave', '#collection-img-div', function(e){
		$(this).removeClass('pulse');
	});

	$(document).on('mouseenter', '#collection-link-text', function(e){
		collectionId = $(this).data('collection-id');
		$('#collection-image-' + collectionId).addClass('animated pulse');
	});
	$(document).on('mouseleave', '#collection-link-text', function(e){
		collectionId = $(this).data('collection-id');
		$('#collection-image-' + collectionId).removeClass('animated');
	});

	// Zoom up for collection when clicking on it
	$(document).on('click', '#collection-link', function(e){			
		collectionId = $(this).data('collection-id');
		$('#collection-image-' + collectionId).addClass('animated zoomOutUp');
		setTimeout(function() {
			window.location.href = '/collections/' + collectionId + '/';
		}, 1500);
		
	});

	$(document).on('click', '#collection-link-text', function(e){			
		collectionId = $(this).data('collection-id');
		$('#collection-image-' + collectionId).addClass('animated zoomOutUp');
		setTimeout(function() {
			window.location.href = '/collections/' + collectionId + '/';
		}, 1500);
	});

	// Send Email
	$(document).on('click', '#send-email', function(e){
		$('#email').parents('li').removeClass("danger");
		$('#message').parents('li').removeClass("danger");
		$('#send-email-alert').remove();

		$.ajax({
	        type: "POST",
	        url: "/send-email/",
	        data: $("#send-form").serialize(),
	        dataType: 'json'
	    })
	    .done(function(html) {
	        $('#email').parents('li').before('<li class="success alert" id="send-email-alert">L\'email a bien été envoyé.</li>');
	        $('#email').val("");
	        $('#subject').val("");
	        $('#message').val("");
	    })
	    .fail(function(error) {
	    	if ("empty email" == error.responseJSON) {
	    		$('#email').parents('li').addClass("danger");
	    		$('#email').parents('li').before('<li class="danger alert" id="send-email-alert">L\'adresse email ne doit pas être vide.</li>');
	    	}

	    	if ("incorrect email" == error.responseJSON) {
	    		$('#email').parents('li').addClass("danger");
	    		$('#email').parents('li').before('<li class="danger alert" id="send-email-alert">L\'adresse email doit être correct.</li>');
	    	}

	    	if ("empty message" == error.responseJSON) {
	    		$('#message').parents('li').addClass("danger");
	    		$('#email').parents('li').before('<li class="danger alert" id="send-email-alert">Le corps du message ne doit pas être vide.</li>');
	    	}

	        return false;
	    })
	});
	
	/**
	 * Menu Hover
	 */
	// Mouse enter logo Menu
	$(document).on('mouseenter', '#nav-logo', function(e){
		$("#nav-logo-name").css("display", "block");
	});

	// Mouse leave logo Menu
	$(document).on('mouseleave', '#nav-logo', function(e){
		$("#nav-logo-name").css("display", "none");
	});

	// Mouse enter Menu
	$(document).on('mouseenter', '.navbar > .row > ul > li', function(e){
		var menu = $(this).data("menu");
		$(this).find('i').after('<span data-name="'+ menu +'"> ' + menu + '</span>');
	});

	// Mouse Leave
	$(document).on('mouseleave', '.navbar > .row > ul > li', function(e){
		$(this).find('span').remove();
	});

	// for touch devices: add class cs-hover to the figures when touching the items
	if( Modernizr.touch ) {

		// classie.js https://github.com/desandro/classie/blob/master/classie.js
		// class helper functions from bonzo https://github.com/ded/bonzo

		function classReg( className ) {
			return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
		}

		// classList support for class management
		// altho to be fair, the api sucks because it won't accept multiple classes at once
		var hasClass, addClass, removeClass;

		if ( 'classList' in document.documentElement ) {
			hasClass = function( elem, c ) {
				return elem.classList.contains( c );
			};
			addClass = function( elem, c ) {
				elem.classList.add( c );
			};
			removeClass = function( elem, c ) {
				elem.classList.remove( c );
			};
		}
		else {
			hasClass = function( elem, c ) {
				return classReg( c ).test( elem.className );
			};
			addClass = function( elem, c ) {
				if ( !hasClass( elem, c ) ) {
						elem.className = elem.className + ' ' + c;
				}
			};
			removeClass = function( elem, c ) {
				elem.className = elem.className.replace( classReg( c ), ' ' );
			};
		}

		function toggleClass( elem, c ) {
			var fn = hasClass( elem, c ) ? removeClass : addClass;
			fn( elem, c );
		}

		var classie = {
			// full names
			hasClass: hasClass,
			addClass: addClass,
			removeClass: removeClass,
			toggleClass: toggleClass,
			// short names
			has: hasClass,
			add: addClass,
			remove: removeClass,
			toggle: toggleClass
		};

		// transport
		if ( typeof define === 'function' && define.amd ) {
			// AMD
			define( classie );
		} else {
			// browser global
			window.classie = classie;
		}

		[].slice.call( document.querySelectorAll( 'ul.grid > li > figure' ) ).forEach( function( el, i ) {
			el.querySelector( 'figcaption > a' ).addEventListener( 'touchstart', function(e) {
				e.stopPropagation();
			}, false );
			el.addEventListener( 'touchstart', function(e) {
				classie.toggle( this, 'cs-hover' );
			}, false );
		} );

	}

})();

