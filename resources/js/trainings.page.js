// ============== SEARCHING

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
				latitude: $('#latitude').val(),
				longitude: $('#longitude').val(),
				radius: $('#radius').val()
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

// ==== RATING
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

// === COMMENTING

if ($('.add-comment').length){
	$('body').on('click', '.add-comment', function(event){
		startLoading();
		event.preventDefault();
		var trainingId = $(this).attr('training');
		var content = $('#comment-' + trainingId).val();

		jQuery.ajax({
			type: 'POST',
			url: 'comments',
			data: {
				_token: $('input[name="_token"]').val(),
				content: content,
				trainingId: trainingId
			},
			success: function(data) {
				stopLoading();
				$('#comment-' + trainingId).val('');
				$('#' + trainingId + ' .comments').html(data);
				console.log('comment added');
			},
			error: function(data) {
				stopLoading();
				console.error('Error in commenting a training');
				console.log(data.responseJSON);
			}
		});
	});
}

if ($('.delete-comment').length){
	$('body').on('click', '.delete-comment', function(event){
		startLoading();
		event.preventDefault();
		var commentId = $(this).attr('commentid');

		jQuery.ajax({
			type: 'DELETE',
			url: 'comments/' + commentId,
			data: {
				_token: $('input[name="_token"]').val(),
			},
			success: function(data) {
				stopLoading();
				$('#comment-' + commentId).remove();
				console.log('comment deleted');
			},
			error: function(data) {
				stopLoading();
				console.error('Error in deleting a comment');
				console.log(data.responseJSON);
			}
		});
	});
}

// ========================== MAP

var map;
var marker;
var latitudeInput = $ ( "input#latitude" );
var longitudeInput = $ ( "input#longitude" );

function initialize() {
	console.log($('#map-container-search').length != 0);
	var estonia = new google.maps.LatLng(58.886, 25.547);
	//Set coordinates input
	latitudeInput.val(estonia.A);
	longitudeInput.val(estonia.F);
	//Map itself
	var mapOptions = {
		center: estonia,
		zoom: 8
	};

	map = new google.maps.Map(document.getElementById('map-container-search'), mapOptions);

	getTrainings();

	//Add listener for choosing place from map
	google.maps.event.addListener(map, 'click', function(event) {
		placeMarkerForSearching(event.latLng);
	});
}

function getTrainings() {
	jQuery.ajax({
		type: 'GET',
		url: 'trainings/map',
		success: function(data) {
			populateTrainings(data);
		}
	});
}

function populateTrainings(trainings) {
	for (var i = 0, training; training = trainings[i]; i++) {
		placeMarker(training);
	}
}

function placeMarker(training) {
	//Parse coordinates
	var coordinatesLatLng = new google.maps.LatLng(training.latitude, training.longitude);

	//Info window
	var infoContent = '<h5>'+training.title+'</h5>'+
		'<p>'+training.description+'</p>';
	var infoWindow = new google.maps.InfoWindow({
		content: infoContent,
	})

	//Adding marker
	var marker = new google.maps.Marker({
		position: coordinatesLatLng,
		map: map,
		title: training.title
	});

	//Listener to marker
	google.maps.event.addListener(marker, 'click', function() {
		infoWindow.open(map,marker);
	});
}

function placeMarkerForSearching(location) {
	//Remove last marker
	if (marker) {
		marker.setMap(null);
	}

	//Adding marker
	marker = new google.maps.Marker({
		position: location,
		map: map,
	});

	//Set coordinates input
	latitudeInput.val(location.A);
	longitudeInput.val(location.F);

}

function loadScript() {
	var script = document.createElement('script');
	script.type = 'text/javascript';
	script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp?key=AIzaSyDkK8oL9mzyASA_lqgYYDleQDjVZLOonOY' + '&signed_in=true&callback=initialize';
	document.body.appendChild(script);
}
window.onload = loadScript;
