if ($('#users-list').length){
	alert("tekst");
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
				$('#users-list').html(data);
			},
			error: function(data) {
				stopLoading();
				console.error('Error in searching trainings');
				console.log(data.responseJSON);
			}
		});
	});
}