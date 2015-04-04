//Fileupload
$('#fileupload').fileupload({
	dataType: 'json',

	fail: function(e,data) {
		console.log(data.jqXHR);
		if (data.jqXHR.status == 200) { //Sent a view
			console.log(data);
			$.each(data.files, function (index, file) {
				$('#files').prepend(data.jqXHR.responseText); //writing the html
			});
		}
		else {
			//If the training file has an error
			console.log('error uploading file');
			$('#fileErrors').show();
			$.each(data.jqXHR.responseJSON, function(i, item) {
				$('#fileErrors').append('<p>' + item + '</p>');
			});
		}
	},
	done: function (e, data) {
		console.log(data);
	},

}).prop('disabled', !$.support.fileInput)
	.parent().addClass($.support.fileInput ? undefined : 'disabled');

//Deleting image
$(document).on('click', '.delete-file', function(event){
	event.preventDefault();
	var id = $(this).attr('id');
	jQuery.ajax({
		type: 'DELETE',
		url: $(this).attr('href'),
		data: {
			_token: $('input[name="_token"]').val(),
		},
		success: function(data) {
			console.log('successfully removed image #file-'+id);
			$('#file-'+id).remove();
		},
		error: function(data) {
			console.log(data.responseJSON);
		}
	});
});