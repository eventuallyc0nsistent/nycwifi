
	</div> <!-- Close div.container" -->
	<script type="text/javascript">

$(document).ready(function() {
	

	if(navigator.geolocation) {

		//gets the current Position through HTML5 via browser
		navigator.geolocation.getCurrentPosition(showPosition) ;

		
	}
	else {

		$('#map').html('Geolocation not supported by map') ;
	}

	function showPosition(position) {

		var myarray = new Array();
		myarray = <?php echo json_encode($myarray) ?> ;
		//console.log(myarray) ;


		longitude = position.coords.longitude ; // get longitude of user
		latitude  = position.coords.latitude ; // get latitude of user

		latitudelongitude = new google.maps.LatLng(latitude, longitude) ;
		mapholder = document.getElementById('map') ;
		$('#map').gmap({'zoom': 16, 'disableDefaultUI':true}).bind('init', function(evt, map) { 
			
			//set the center of the map to the location of the user
			map.setCenter(latitudelongitude);
			
			//get the bounds for the screen (left bounds and right bounds)
			var bounds = map.getBounds(); 

			var southWest = bounds.getSouthWest();
			var northEast = bounds.getNorthEast();

			// longitude and latitude spanning
			var lngSpan = northEast.lng() - southWest.lng();
			var latSpan = northEast.lat() - southWest.lat();
			 
			$.each(myarray,function(index,value) {

				//set latitude and longitude from array
				var lat = value.latitude[0] ;
				var lng = value.longitude[0];

				// add the marker for the location
				$('#map').gmap('addMarker', { 
					'position': new google.maps.LatLng(lat, lng) 
				}).click(function() {
					$('#map').gmap('openInfoWindow', { content : value.name[0]+"<br/>"+ value.address[0] }, this);
				});
			});

			//add to cluster
			$('#map').gmap('set', 'MarkerClusterer', new MarkerClusterer(map, $(this).gmap('get', 'markers')));
						
		 });
	
	}

});

  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-13022600-4', 'kirankoduru.com');
  ga('send', 'pageview');


	</script>
</body>
</html>