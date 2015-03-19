$(document).ready(function() {

	if(navigator.geolocation) {

		//gets the current Position through HTML5 via browser
		navigator.geolocation.getCurrentPosition(showPosition) ;

		
	}
	else {

		$('#map').html('Geolocation not supported by map') ;
	}

	function showPosition(position) {

		var data = [];
		var image = 'include/img/marker.png'

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
			 
			$.each(data, function(index,value) {

				//set latitude and longitude from array
				var lat = value[14];
				var lng = value[15];

				// add the marker for the location
				$('#map').gmap('addMarker', { 
					'position': new google.maps.LatLng(lat, lng),
				}).click(function() {
					$('#map').gmap('openInfoWindow', 
								   { content : "<b>"+value[21]+"</b>\
								   				<br/>"+ value[13] +
								   				'<br><a href="#">Walk</a>\
								   				&nbsp;<a href="#">transit</a>'},
								   this);
				});
			});

			//add to cluster
			$('#map').gmap('set', 'MarkerClusterer', new MarkerClusterer(map, $(this).gmap('get', 'markers')));
						
		 });
	
	}

});