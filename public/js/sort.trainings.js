if ($('#admin-trainings-list').length){
	$('body').on('click', '.sort', function(event){
		startLoading();
		event.preventDefault();
		jQuery.ajax({
			type: 'get',
			url: $(this).attr('href'),
			data: {
				_token: $('input[name="_token"]').val(),
				id: $(this).attr('id'),
				dir: $(this).attr('dir'),
			},
			success: function(data) {
				stopLoading();
				$('#admin-trainings-list').html(data);
			},
			error: function(data) {
				stopLoading();
				console.error('Error in sorting trainings');
				console.log(data.responseJSON);
			}
		});
	});
}