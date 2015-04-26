if ($('#search-trainings').length){
	$('body').on('click', '#search-trainings', function(event){
		startLoading();
		event.preventDefault();
		jQuery.ajax({
			type: $('#search-form').attr('method'),
			url: $('#search-form').attr('action'),
			data: {
				_token: $('input[name="_token"]').val(),
				tag_list: $('#tag_list').val(),
				what: $('#what').val(),
				direction: $('#direction').val(),
			},
			success: function(data) {
				stopLoading();
				$('#search-results').html(data);
			},
			error: function(data) {
				stopLoading();
				console.error('Error in searching trainings');
				console.log(data.responseJSON);
			}
		});
	});
}

if ($('.rate').length){
	$('body').on('click', '.rate', function(event){
		startLoading();
		event.preventDefault();
		var trainingId = $(this).attr('id');

		jQuery.ajax({
			type: 'POST',
			url: 'rate/' + trainingId,
			data: {
				_token: $('input[name="_token"]').val(),
				value: $(this).html()
			},
			success: function(data) {
				stopLoading();
				$('#rate-' + trainingId).html(data);
			},
			error: function(data) {
				stopLoading();
				console.error('Error in rating a training');
				console.log(data.responseJSON);
			}
		});
	});
}