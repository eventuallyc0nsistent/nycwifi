$(document).ready(function() {

	var longitude;
	var latitude;
	var directionService = new google.maps.DirectionsService();
    var directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true});

	if(navigator.geolocation) {

		//gets the current Position through HTML5 via browser
		navigator.geolocation.getCurrentPosition(showPosition) ;

		
	}
	else {

		$('#map').html('Geolocation not supported by map') ;
	}

	function showPosition(position) {

		var data = [];
		var image = 'include/img/marker.png';

		$.ajax({
			url : 'https://nycopendata.socrata.com/api/views/jd4g-ks2z/rows.json',
			type: 'get',
			contenttype:'json',
			async: false,
			success:function(response){
				data = response.data; 
			}
		});

		longitude = position.coords.longitude ; // get longitude of user
		latitude  = position.coords.latitude ; // get latitude of user

		latitudelongitude = new google.maps.LatLng(latitude, longitude) ;
		mapholder = document.getElementById('map') ;
		$('#map').gmap({'zoom': 16, 'disableDefaultUI':true}).bind('init', function(evt, map) {
				
				// add self marker
				$('#map').gmap('addMarker', {
					'position': latitudelongitude,
					'icon' : image
				});
				
				//set the center of the map to the location of the user
				map.setCenter(latitudelongitude);

				//get the bounds for the screen (left bounds and right bounds)
				var bounds = map.getBounds(); 

				var southWest = bounds.getSouthWest();
				var northEast = bounds.getNorthEast();

				// longitude and latitude spanning
				var lngSpan = northEast.lng() - southWest.lng();
				var latSpan = northEast.lat() - southWest.lat();
					 
				// create InfoWindow
				$.each(data, function(index,value) {

					var lat = value[15];
					var lng = value[16];
					$('#map').gmap('addMarker', { 
						'position': new google.maps.LatLng(lat, lng),
						}).click(function() {
								$('#map').gmap('openInfoWindow', 
							    			   {content : "<b>"+value[22]+"</b>\
										   				  <br/>"+ value[14] +
										   				  '<br><span lat="'+lat+'" lng="'+lng+'">\
										   				  <a class="walk">walk</a>\
										   				  &nbsp;<a class="transit">transit</a></span>'},
										   		this);
					});

				});

				//add to cluster
				$('#map').gmap('set', 'MarkerClusterer', 
							   new MarkerClusterer(map, $(this).gmap('get', 'markers')));

				// to display directions on this map
				directionsDisplay.setMap(map);
		});
			
	
	}

	// walk
	$(document).on('click', '.walk', function(){
		var gotoLat = $(this).parent().attr('lat');
		var gotoLng = $(this).parent().attr('lng');
		var request = {
			origin: new google.maps.LatLng(latitude, longitude),
			destination: new google.maps.LatLng(gotoLat, gotoLng),
			travelMode: google.maps.TravelMode.WALKING
		}
		travel(request);
	});

	// transit
	$(document).on('click', '.transit', function(){
		var gotoLat = $(this).parent().attr('lat');
		var gotoLng = $(this).parent().attr('lng');
		var request = {
			origin: new google.maps.LatLng(latitude, longitude),
			destination: new google.maps.LatLng(gotoLat, gotoLng),
			travelMode: google.maps.TravelMode.TRANSIT
		}
		travel(request);
	});

	// drive

	function travel(request){
		directionService.route(request, function(response, status) {
		    if (status == google.maps.DirectionsStatus.OK) {
		      directionsDisplay.setDirections(response);
		    }
	  	});
	}
	
});
