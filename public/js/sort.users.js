if ($('#users-list').length){
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
				if ($(this).attr('dir') == 'up'){
					$(this).attr('dir', 'down');
					$(this).text('ˇ');
				}
				else if ($(this).attr('dir') == 'down'){
					$(this).attr('dir') = 'up';
					$(this).text('^');
				}
			},
			error: function(data) {
				stopLoading();
				console.error('Error in searching trainings');
				console.log(data.responseJSON);
			}
		});
	});
}