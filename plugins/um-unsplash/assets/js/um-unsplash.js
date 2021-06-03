jQuery( document ).ready( function($) {
	var um_unsplash_loading_template = '<p style="text-align:center;">' + wp.i18n.__( 'Loading...', 'um-unsplash' ) + '</p>';
	var um_unsplash_empty_result_template = '<p style="text-align:center;">' + wp.i18n.__( 'No result was found.', 'um-unsplash' ) + '</p>';


	// Open Unsplash Modal
	$( document.body ).on( 'click' , '.um-unsplash-trigger' , function() {
		$( 'body' ).addClass( 'um_unsplash_overlay' ).trigger( 'um_unsplash_overlay_show' );
		UM.dropdown.hideAll();
		return false;
	} );


	// Close modal window
	$( document.body ).on( 'click' , '#um_unsplash_remove_modal' , function() {
		$( 'body' ).removeClass( 'um_unsplash_overlay' ).trigger( 'um_unsplash_overlay_hide' );
	});


	//Custom body events
	$( 'body' )
		.on( 'um_unsplash_overlay_show' , function() {
			//Event on show Unsplash modal window
			var unsplash_modal = $( '.um-unsplash-modal' );


			unsplash_modal.find( '.um-unsplash-modal-body-ajax-content' ).html( um_unsplash_loading_template );

			var domain = um_unsplash_settings.proxy_url+'/search/' + um_unsplash_settings.license;
			var query = um_unsplash_settings.default_keyword;
			var per_page = um_unsplash_settings.number_of_photos;

			var url = domain+'/'+per_page+'/'+query+'/1';

			$.get( url , function( data ) {
				var html = '';
				var response = JSON.parse( JSON.stringify( data ) );

				if(response.success == true){
					var response_data_body = JSON.parse(response.data.body);
					$( response_data_body.results ).each( function( index, element ) {
						var id = element.id;
						var name = element.user.name;
	          var username = element.user.username;
						var download = element.links.download;
						var download_location = element.links.download_location;
						var user_profile = element.user.links.html;
						var thumb = element.urls.thumb;
						var full = element.urls.full + '&w=1000&h=370&fit=crop';

						html += '<input class="unsplash_img_radio" type="radio" id="' + id + '" name="unsplash_img" data-id="' + id + '" value="' + full + '" data-user="'+name+'" data-download="'+download+'" data-user_profile="'+user_profile+'" data-download_location="'+download_location+'"/>' +
							'<label for="' + id + '" style="background-image:url(' + thumb + ');"></label>';
					} );

					html += '<div class="selected-image"></div>';

				} else {
					console.warn( 'Can not get Unsplash images', response );
					html += '<p>'+wp.i18n.__( 'Unexpected Error!', 'um-unsplash' )+'</p>';
				}

				unsplash_modal.find( '.um-unsplash-modal-body-ajax-content' ).html( html );
			});

		})
		.on( 'um_unsplash_overlay_hide' , function() {
			//Event on hide Unsplash modal window
			var modal = $( '.um-unsplash-modal' );

			modal.find( '.um-unsplash-modal-body-ajax-content' ).html( '' );
			modal.find( 'form' ).trigger( 'reset' );
		});


	//Submit Unsplash Photo
	$( document.body ).on( 'click' , '#um-unsplash-submit' , function() {
		var btn = $( this );
		if ( btn.hasClass( 'disabled' ) ) {
			return;
		}

		var modal = btn.parents( '.um-unsplash-modal' );
		var form = modal.find( 'form.um-unsplash-form' );

		var cover_wrapper = $( 'body' ).find( '.um-cover-e' );
		var cover_image = cover_wrapper.find( 'img' );

		var selected_image = $( '#um-unsplash-cropable' );

		if ( selected_image.length && selected_image.attr( 'src' ) ) {
			var selected_radio = $( '.unsplash_img_radio:checked' );

			selected_radio.val( selected_image.attr( 'src' ) );
		}

		if($( '.unsplash_img_radio:checked' ).length){
			var user = $( '.unsplash_img_radio:checked' ).attr('data-user');
			var photo_id = $( '.unsplash_img_radio:checked' ).attr('id');
			var user_url = $( '.unsplash_img_radio:checked' ).attr('data-user_profile');
			var download_url = $( '.unsplash_img_radio:checked' ).attr('data-download');
			var download_location = $( '.unsplash_img_radio:checked' ).attr('data-download_location');

        	form.find('[name="photo_author"]').val(user);
					form.find('[name="photo_author_url"]').val(user_url);
					form.find('[name="photo_download_url"]').val(download_url);
					form.find('[name="photo_download_location"]').val(download_location);
					form.find('[name="photo_id"]').val( photo_id );
		}


		btn.addClass( 'disabled' );

		/*download_location +='/?client_id=e33e579bd0ffe6cead074791cfcc38825d297011d08e6cb456e0c4de9538103d';

		$.get(download_location,function(data){
			//console.log(data);
		});*/


		var form_data = form.serialize();
		wp.ajax.send({
			data: form_data,
			success: function( data ) {
				var image_url = data.image.replace( '&amp;', '&' );
				if ( cover_image.length ) {
					cover_image.attr( 'src', image_url );
				} else {
					cover_wrapper.html( data.img_html );
				}
				$( '#um_unsplash_remove_modal' ).trigger('click');

				btn.removeClass( 'disabled' );
			},
			error: function( data ) {
				form.find( '.um-unsplash-form-response' ).html( data );
				btn.removeClass( 'disabled' );
			}
		});
	});



	/**
	 * Modal window navigation handlers
	 */

	//Search button
	$( document.body ).on( 'click' , '#um-unsplash-photo-search-btn' , function(e) {
		e.preventDefault();

		var field = $( '#um-unsplash-photo-search-field' );
		if ( field.val() === '' ) {
			return;
		}

		var btn = $(this);
		var modal = btn.parents( '.um-unsplash-modal' );

		var container = modal.find( '.um-unsplash-modal-body-ajax-content' );
		container.html( um_unsplash_loading_template );

		var page = 1;
		var query = field.val();
		var domain = um_unsplash_settings.proxy_url+'/search/' + um_unsplash_settings.license;
		var per_page = um_unsplash_settings.number_of_photos;
		var url = domain+'/'+per_page+'/'+query;

		$.get( url+'/1' , function( data ) {
			var html = '';
			var response = JSON.parse( JSON.stringify( data ) );

			if(response.success == true){
			  var response_data_body = JSON.parse(response.data.body);

				if ( response_data_body.total === 0 ) {
					html += um_unsplash_empty_result_template;
				} else {
					$( response_data_body.results ).each( function( index, element ) {

						var id = element.id;
						var name = element.user.name;
	          var username = element.user.username;
						var download = element.links.download;
						var download_location = element.links.download_location;
						var user_profile = element.user.links.html;
						var thumb = element.urls.thumb;

						var full = element.urls.full+'&w=1000&h=370&fit=crop';

						html += '<input class="unsplash_img_radio" type="radio" id="'+id+'" name="unsplash_img" data-id="'+id+'" value="'+full+'" data-user="'+name+'" data-download="'+download+'" data-user_profile="'+user_profile+'" data-download_location="'+download_location+'"/><label for="'+id+'" style="background-image:url('+thumb+');"></label>';

					} );

					if ( response_data_body.total > per_page ) {
						html +='<p class="um-unsplash-ajax-load-more-holder"><a class="um-unsplash-ajax-load-more" href="javascript:void(0);" data-more="'+response_data_body.total+'" data-per_page="'+per_page+'" data-url="'+url+'" data-page="2">' + wp.i18n.__( 'Load more', 'um-unsplash' ) + ' &raquo;</a></p>';
					}

				}

				html += '<div class="selected-image"></div>';

			}else{
				console.warn( 'Can not search Unsplash images', response );
			  html += '<p>'+wp.i18n.__( 'Unexpected Error!', 'um-unsplash' )+'</p>';
			}

			container.html( html );
		});
	});


	//Load more Unsplash images
	$( document.body ).on( 'click' , '.um-unsplash-ajax-load-more' , function() {
		var btn = $(this);
		var container = btn.parents( '.um-unsplash-modal' ).find( '.um-unsplash-modal-body-ajax-content' );

		var url = btn.data( 'url' );
		var page = btn.data( 'page' );
		var per_page = btn.data( 'per_page' );

		$.get( url+'/'+page , function( data ) {
			var html = '';

			var response = JSON.parse( JSON.stringify( data ) );

			if(response.success == true){
			  var response_data_body = JSON.parse(response.data.body);

				if ( response_data_body.total === 0 ) {

					html += um_unsplash_empty_result_template;

				} else {

					$( response_data_body.results ).each( function( index, element ) {

						var id = element.id;
						var name = element.user.name;
	          var username = element.user.username;
						var download = element.links.download;
						var download_location = element.links.download_location;
						var user_profile = element.user.links.html;
						var thumb = element.urls.thumb;
						var full = element.urls.full + '&w=1000&h=370&fit=crop';

						html += '<input class="unsplash_img_radio" type="radio" id="' + id + '" name="unsplash_img" data-id="' + id + '" value="' + full + '" data-user="'+name+'" data-download="'+download+'" data-user_profile="'+user_profile+'" data-download_location="'+download_location+'"/>' +
							'<label for="' + id + '" style="background-image:url(' + thumb + ');"></label>';

					} );

				}

				if ( response_data_body.results.length ) {
					html +='<p class="um-unsplash-ajax-load-more-holder">' +
						'<a class="um-unsplash-ajax-load-more" href="javascript:void(0);" data-more="' + response_data_body.total + '" data-per_page="' + per_page + '" data-url="' + url + '"' + '" data-page="' + ( page*1 + 1 ) +'">' +
							wp.i18n.__( 'Load more', 'um-unsplash' ) + ' &raquo;' +
						'</a>' +
					'</p>';
				}

			}else{
			  console.warn( 'Can not load Unsplash images', response );
			  html += '<p>'+wp.i18n.__( 'Unexpected Error!', 'um-unsplash' )+'</p>';
			}

			btn.parent( '.um-unsplash-ajax-load-more-holder' ).remove();
			container.find( '.selected-image' ).before( html );

		});
	});


	//Select image
	$( document.body ).on( 'change' , '.unsplash_img_radio' , function() {
		var checked_radio = $( '.unsplash_img_radio:checked' );

		if ( checked_radio.length ) {
			$( '#um_unsplash_view_image' ).css( 'display' , 'inline-block' );

			$( '.um-unsplash-modal-body' ).find( '.selected-image' ).html('');

			$('body').find( '.um-unsplash-modal-footer' ).find( '.um-modal-btn.disabled' ).removeClass( 'disabled' );
		}
	});


	//Image preview
	$( document.body ).on( 'click','#um_unsplash_view_image' , function() {
		var checked_radio = $( '.unsplash_img_radio:checked' );

		if ( checked_radio.length ) {
			var image_value = checked_radio.val();

			$( '.um-unsplash-modal-body' ).find( '.selected-image' ).html(
				'<img id="um-unsplash-cropable" src="' + image_value + '" alt="" />' +
				'<span class="um-unsplash-crop-adjustment-buttons">' +
					'<a id="fp-y-up-button" class="button" href="javascript:void(0);">' +
						'<i class="um-faicon-chevron-up"></i>' +
					'</a>' +
					'<a id="fp-y-down-button" class="button" href="javascript:void(0);">' +
						'<i class="um-faicon-chevron-down"></i>' +
					'</a>' +
				'</span>'
			);
		}

		$( this ).css( 'display','none' );
	});


	//Image preview move zoom up
	$( document.body ).on( 'click' , '#fp-y-up-button' , function() {
		if ( $(this).hasClass( 'disabled' ) ) {
			return;
		}

		var image = $( '#um-unsplash-cropable' );
		if ( ! image.length ) {
			return;
		}

		var src = image.attr( 'src' );
		src = src.replace( '&crop=entropy' , '' );
		src = src.replace( '&crop=focalpoint' , '' );
		src = src + '&crop=focalpoint';

		if ( src.indexOf( '&fp-y=' ) > -1 ) {

			var fpy = parseInt( image.data( 'fpy' ) );

			if ( fpy > 0 ) {

				var new_val = fpy - 1;

				//image.data( 'fpy', new_val );

				var old_value = '0.' + fpy;
				if ( fpy === 0 ) {
					old_value = 0;
				}

				var new_val_data = 0;
				if ( new_val >= 1 ) {
					new_val_data = '0.' + new_val;
				}

				src = src.replace( '&fp-y=' + old_value, '&fp-y=' + new_val_data );

				image.data( 'fpy', new_val );
			}
		} else {

			src = src + '&fp-y=0.1';

			image.data( 'fpy', '1' );

		}

		image.attr( 'src', src );

		$( document ).trigger( 'um_unsplash_cover_position_change' );
	});


	//Image preview move zoom down
	$( document.body ).on( 'click','#fp-y-down-button' , function() {
		if ( $(this).hasClass( 'disabled' ) ) {
			return;
		}

		var image = $( '#um-unsplash-cropable' );
		if ( ! image.length ) {
			return;
		}

		var src = image.attr( 'src' );
		src = src.replace( '&crop=entropy', '' );
		src = src.replace( '&crop=focalpoint' , '' );
		src = src + '&crop=focalpoint';

		if ( src.indexOf( '&fp-y=' ) > -1) {

			var fpy = parseInt( image.data( 'fpy' ) );

			if ( fpy < 9 ) {

				var new_val = fpy + 1;

				image.data( 'fpy', new_val );

				var old_value = '0.' + fpy;
				if ( fpy === 0 ) {
					old_value = 0;
				}

				src = src.replace( '&fp-y=' + old_value, '&fp-y=0.' + new_val );
			}
		} else {

			src = src + '&fp-y=0.5';

			image.data( 'fpy', '5' );
		}

		image.attr( 'src', src );

		$( document ).trigger( 'um_unsplash_cover_position_change' );

	});
});
