	var map;

	function initialize() {
		var estonia = new google.maps.LatLng(58.886, 25.547);
		//Map itself
		var mapOptions = {
			center: estonia,
			zoom: 8
		};

		map = new google.maps.Map(document.getElementById('map-container'), mapOptions);

		getTrainings();
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

	function loadScript() {
		var script = document.createElement('script');
		script.type = 'text/javascript';
		script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp?key=AIzaSyDkK8oL9mzyASA_lqgYYDleQDjVZLOonOY' + '&signed_in=true&callback=initialize';
		document.body.appendChild(script);
	}
	window.onload = loadScript;
