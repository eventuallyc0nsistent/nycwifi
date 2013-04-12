
	</div> <!-- Close div.container" -->
	<script type="text/javascript">

$(document).ready(function() {
	

	if(navigator.geolocation) {

		navigator.geolocation.getCurrentPosition(showPosition) ;

		
	}
	else {

		$('#map').html('Geolocation not supported by map') ;
	}

	function showPosition(position) {

		var myarray = new Array();
		myarray = <?php echo json_encode($myarray) ?> ;
		//console.log(myarray) ;


		longitude = position.coords.longitude ;
		latitude  = position.coords.latitude ;
		latitudelongitude = new google.maps.LatLng(latitude, longitude) ;
		mapholder = document.getElementById('map') ;
		mapholder.style.height = '250px' ;
		mapholder.style.width  = '100%' ;

		$('#map').gmap({'zoom': 14, 'disableDefaultUI':true}).bind('init', function(evt, map) { 
			
			map.setCenter(latitudelongitude);
			var bounds = map.getBounds();
			var southWest = bounds.getSouthWest();
			var northEast = bounds.getNorthEast();

			var lngSpan = northEast.lng() - southWest.lng();
			var latSpan = northEast.lat() - southWest.lat();
			 
			$.each(myarray,function(index,value) {

				var lat = value.latitude[0] ;
				var lng = value.longitude[0];

				$('#map').gmap('addMarker', { 
					'position': new google.maps.LatLng(lat, lng) 
				}).click(function() {
					$('#map').gmap('openInfoWindow', { content : value.name[0] }, this);
				});
			});
			$('#map').gmap('set', 'MarkerClusterer', new MarkerClusterer(map, $(this).gmap('get', 'markers')));
			// To call methods in MarkerClusterer simply call 
			// $('#map').gmap('get', 'MarkerClusterer').callingSomeMethod();

			
		 });
	
	}

});

	</script>
</body>
</html>