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