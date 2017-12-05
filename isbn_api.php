<?php

	/* We must keep in mind this possible error when account has reached request limit.
	<isbndb>
		<error>Invalid api key: mykey</error>
	</isbndb>
	"ISBN cannot be retrieved at this time; please manually enter the rest of the book's information."
	*/

	$context = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
	$url = 'http://isbndb.com/api/v2/xml/YFWZ0Z2K/book/';
	$q = $_REQUEST["q"]; //grab ISBN from current URL in browser
	$url .= $q; //append ISBN to the requesting URL

	//print URL that will actually be sent to ISNBdb API
	//echo $url . "<br>";

	$xml = file_get_contents($url, false, $context);

	//Generate pseudo-XML content
	header('Content-type: text/xml');
	header('Pragma: public');
	header('Cache-control: private');
	header('Expires: -1');
	echo $xml;
?>