<?php require_once('header.php') ; 

 $xml_file = simplexml_load_file('include/xml/wifi.xml') ;
 $myarray = array() ; //declare array

 foreach ($xml_file->row->row as $row ) { 

 	$latitude = $row->shape['latitude']; 
 	$longitude = $row->shape['longitude'];
 	$name = $row->name; // get the name of the place 
 	$id = $row->objectid; // get the id
 	$address = $row->address ;
 	
 	// echo 'id:'.$objectid.' Name: '.$name.' Latitude: '.$latitude.' Longitude: '.$longitude; 
 	// echo "<br>" ;

 	$options = array(

 				'id' => $id,
 				'name' => $name,
 				'latitude'=>$latitude,
 				'longitude'=>$longitude,
 				'address' => $address
 				

 		) ;

 	$myarray[] = $options ;
 	
 }

 ?>
	<div class="hero-unit">

	<h2>Finding free WiFi locations</h2>

	<p>
		When you are walking down the streets of New York, you wonder how could you stay connected seamlessly over the web with your friends. Thanks to the government of New York and the Google API I present to you the closest thing to staying connected with your friends.

		Hope this helps. Could you please share this with your friends if you find it useful ?
	</p>

	<div id="map"></div>
	<br/>

	If you think it helped you or you want to keep it running then push the Donate button
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
		<input type="hidden" name="cmd" value="_s-xclick">
		<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
		">
		<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
		<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
	</form>


	
</div>
<?php require_once('footer.php') ; ?>