//Loading ===================================================================

function startLoading() {
	var left = $(window).width() / 2;
	var top = $(window).height() / 2;

	if (!$('#loader').length){
		$('<div/>', {
			id: 'loader',
			style: 'left: ' + left + 'px; top: ' + top + 'px;',
		}).appendTo('body');
	}
}

function stopLoading(){
	if ($('#loader').length){
		$('#loader').remove();
	}
}


//Modal box ===============================================================
$('.open-in-modal').on('click', function(event){
	event.preventDefault();
	var title = $(this).attr('title');
	startLoading();
	jQuery.ajax({
		type: 'GET',
		url: $(this).attr('href'),
		success: function(data) {
			stopLoading();
			bootbox.dialog({
				title: title,
				message: data
			});
		}
	});
});

$('body').on('submit', '.form-modal', function(event){
	event.preventDefault();

	startLoading();
	jQuery.ajax({
		type: $(this).attr('method'),
		url: $(this).attr('action'),
		data: {
			_token: $('input[name="_token"]').val(),
			email: $('input[name="email"]').val(),
			password: $('input[name="password"]').val(),
		},
		success: function(data) {
			stopLoading();
			console.log(data);
			if (data.success == 'false') {
				console.log('Form: Not success');
				$('#ajaxError').html(data.message);
				$('#ajaxError').show();
			}
			else {
				console.log('Form: Success');
				$('#ajaxError').hide();
				window.location.href = data.redirect;
			}
		},
		error: function(data) {
			stopLoading();
			$.each(data.responseJSON, function(i, item) {
				$('#ajaxError').html(item);
			});
			$('#ajaxError').show();
			console.log(data.responseJSON);
		}
	});
});

//Select ====================================================================
if ($('#tag_list').length){
	$('#tag_list').select2({
		placeholder: 'Vali märksõnad',
		tags: true,
	});
}