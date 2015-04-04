//Initializing map =============================================================
var map;
var marker;
var geocoder;
var input = (document.getElementById('aadress')); //html5 object of input
var aadressInput = $( "input#aadress" );
var coordinatesInput = $ ( "input#coordinates" );

function initialize() {
	geocoder = new google.maps.Geocoder();

	if (coordinatesInput.val()){
		//Parse coordinates of current training
		var coordinates = coordinatesInput.val().replace(/[\)\(\s]/g, '').split(',');
		var coordinatesLatLng = new google.maps.LatLng(coordinates[0], coordinates[1]);
		var zoom = 15;
	}
	else {
		var coordinatesLatLng = new google.maps.LatLng(58.886, 25.547);
		var zoom = 8;
	}

	//Map itself
	var mapOptions = {
		center: coordinatesLatLng,
		zoom: zoom
	};
	map = new google.maps.Map(document.getElementById('map-container-form'), mapOptions);

	if (coordinatesInput.val()){
		placeMarker(coordinatesLatLng);
	}

	//Add search box to map
	map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
	var searchBox = new google.maps.places.SearchBox((input));

	//Add listener for selecting item from search
	google.maps.event.addListener(searchBox, 'places_changed', function() {
		var places = searchBox.getPlaces();
		if (places.length == 0) {
			return;
		}

		placeMarker(places[0].geometry.location);
		map.setCenter(places[0].geometry.location);
	});

	//Add listener for choosing place from map
	google.maps.event.addListener(map, 'click', function(event) {
		placeMarker(event.latLng);
	});
}

function loadScript() {
	var script = document.createElement('script');
	script.type = 'text/javascript';
	script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp?key=AIzaSyDkK8oL9mzyASA_lqgYYDleQDjVZLOonOY' + 
					 '&signed_in=true&callback=initialize&libraries=places,geometry';
	document.body.appendChild(script);
}
window.onload = loadScript;

//Functions on map =============================================================

//Placing marker
function placeMarker(location) {
	//Remove last marker
	if (marker) {
		marker.setMap(null);
	}

	//Adding marker
	marker = new google.maps.Marker({
		position: location,
		map: map,
	});

	//Get/update address from coordinates
	geocodePosition(location);

	//Set coordinates input
	coordinatesInput.val(location);

	var infoWindow = new google.maps.InfoWindow({
		content: aadressInput.val(),
	})

	//Listener to marker
	google.maps.event.addListener(marker, 'click', function() {
		infoWindow.open(map,marker);
	});

	map.setZoom(15);

}

//Getting aadress from position
function geocodePosition(pos) {
	geocoder.geocode({
		latLng: pos
	},
	function(responses) {
		if (responses && responses.length > 0) {
			aadressInput.val(responses[0].formatted_address);
		} else {
			alert('Sellele kohale ei saa omastada aadressit, palun valige uus koht.');
		}
	});
}