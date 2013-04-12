#Finding free Wi-Fi locations around NYC

Find the closest locations with Free-Wifi using the XML data sets available from data sets by nyc.gov

Firstly load the XML from the location using 

	$xml_file = simplexml_load_file('include/xml/file.xml') ;

Then iterate through the locations to find the latitudes and longitudes in the file

Then using the Google Map API set the markers for the closest locations to the user.