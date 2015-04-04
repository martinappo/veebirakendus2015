if ($('#search-trainings').length){
	$('body').on('submit', '#search-form', function(event){
		event.preventDefault();
		jQuery.ajax({
			type: $(this).attr('method'),
			url: $(this).attr('action'),
			data: {
				_token: $('input[name="_token"]').val(),
				tag_list: $('#tag_list').val(),
			},
			success: function(data) {
				$('#search-results').html(data);
			},
			error: function(data) {
				console.error('Error in searching trainings');
				console.log(data.responseJSON);
			}
		});
	});
}