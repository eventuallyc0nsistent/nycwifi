<?php require_once('header.php') ; 

 $xml_file = simplexml_load_file('include/xml/wifi.xml') ;
 $myarray = array() ; //declare array

 foreach ($xml_file->row->row as $row ) { 

 	$latitude = $row->shape['latitude']; 
 	$longitude = $row->shape['longitude'];
 	$name = $row->name; // get the name of the place 
 	$id = $row->objectid; // get the id
 	
 	// echo 'id:'.$objectid.' Name: '.$name.' Latitude: '.$latitude.' Longitude: '.$longitude; 
 	// echo "<br>" ;

 	$options = array(

 				'id' => $id,
 				'name' => $name,
 				'latitude'=>$latitude,
 				'longitude'=>$longitude
 				

 		) ;

 	$myarray[] = $options ;
 	
 }

 ?>
	<div class="hero-unit">

	<h2>Finding free WiFi locations</h2>

	<p>
		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tortor risus, cursus non blandit in, sodales in diam. Duis feugiat condimentum sapien nec tincidunt. Maecenas a mauris est. Sed dolor ante, tempor in aliquam at, pretium ut neque. Donec congue libero id mauris auctor vehicula. Fusce felis libero, egestas sed pharetra bibendum, vulputate ac urna. Donec feugiat faucibus molestie. Nam mollis condimentum elit, ornare commodo est dignissim ut. Aenean volutpat orci sed nisl aliquam feugiat.
	</p>

	<div id="map"></div>

	<a class="btn btn-primary btn-small" onclick="showlocation()">Free WiFi</a>
</div>
<?php require_once('footer.php') ; ?>