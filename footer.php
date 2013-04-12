
	</div> <!-- Close div.container" -->
	<script type="text/javascript">

		$(document).ready(function() {

	// var myarr = new Array() ;

	$.ajax({

			url : 'include/xml/wifi.xml',
			cache : true,
			dataType : "xml" ,
			success : function(xml){ }
	
			
	}) ;

	if(navigator.geolocation) {

		navigator.geolocation.getCurrentPosition(showPosition) ;

		
	}
	else {

		$('#map').html('Geolocation not supported by map') ;
	}

	function showPosition(position) {

		var myarray = new Array();
		myarray = <?php echo json_encode($myarray) ?> ;
		
		$(myarray).find('latitude').text();

		longitude = position.coords.longitude ;
		latitude  = position.coords.latitude ;
		latitudelongitude = new google.maps.LatLng(latitude, longitude) ;
		mapholder = document.getElementById('map') ;
		console.log(mapholder) ;
		mapholder.style.height = '250px' ;
		mapholder.style.width  = '100%' ;


		 // var myOptions={

			//   center:latitudelongitude,zoom:14,
			//   mapTypeId:google.maps.MapTypeId.ROADMAP,
			//   mapTypeControl:false,
			//   navigationControlOptions:{style:google.maps.NavigationControlStyle.SMALL}

		 //  };
		 //  var map=new google.maps.Map(mapholder,myOptions);
		 //  var marker=new google.maps.Marker({position:latitudelongitude,map:map,title:"Map Title"});


		   // We need to bind the map with the "init" event otherwise bounds will be null

		   $(xml).find('row').each(function(){

							var objectid = $(this).find('objectid').text();
							var longitude = $(this).find('shape').attr('longitude');
							var latitude = $(this).find('shape').attr('latitude');
							var name = $(this).find('name').text() ;

							console.log(objectid);
							
		});

		$('#map').gmap({'zoom': 14, 'disableDefaultUI':true}).bind('init', function(evt, map) { 
			
			map.setCenter(latitudelongitude);
			var bounds = map.getBounds();
			var southWest = bounds.getSouthWest();
			var northEast = bounds.getNorthEast();

			var lngSpan = northEast.lng() - southWest.lng();
			var latSpan = northEast.lat() - southWest.lat();
			 
			for ( var i = 0; i < 1000; i++ ) {

				var lat = southWest.lat() + latSpan * Math.random();
				var lng = southWest.lng() + lngSpan * Math.random();
				$('#map').gmap('addMarker', { 
					'position': new google.maps.LatLng(lat, lng) 
				}).click(function() {
					$('#map').gmap('openInfoWindow', { content : 'Hello world!' }, this);
				});
			}
			$('#map').gmap('set', 'MarkerClusterer', new MarkerClusterer(map, $(this).gmap('get', 'markers')));
			// To call methods in MarkerClusterer simply call 
			// $('#map').gmap('get', 'MarkerClusterer').callingSomeMethod();

			
		 });
	
	}

});

	</script>
</body>
</html>