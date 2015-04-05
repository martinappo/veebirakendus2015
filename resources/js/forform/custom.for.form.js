//Fileupload
$('#fileupload').fileupload({
	dataType: 'json',
	fail: function(e,data) {
		//If last file
		if ($('#progress').text() == 100) {
			stopLoading();
		}
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
		stopLoading();
		console.log(data);
	},

}).prop('disabled', !$.support.fileInput)
	.parent().addClass($.support.fileInput ? undefined : 'disabled')
	//Updating progress div
	.on('fileuploadprogressall', function (e, data) {
		var progress = parseInt(data.loaded / data.total * 100, 10);
		$('#loader').html(
			'<span id="progress">' + progress + '</span>' + '%'
		);
	})
	//Displaying loader div
	.on('fileuploadadd', function (e, data) {
		startLoading();
	});

//Deleting image
$(document).on('click', '.delete-file', function(event){
	startLoading($(this));
	event.preventDefault();
	var id = $(this).attr('id');
	jQuery.ajax({
		type: 'DELETE',
		url: $(this).attr('href'),
		data: {
			_token: $('input[name="_token"]').val(),
		},
		success: function(data) {
			stopLoading();
			console.log('successfully removed image #file-'+id);
			$('#file-'+id).remove();
		},
		error: function(data) {
			stopLoading();
			console.log(data.responseJSON);
		}
	});
});