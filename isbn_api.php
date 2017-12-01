<?php

	/* We must keep in mind this possible error when account has reached request limit.
	<isbndb>
		<error>Invalid api key: mykey</error>
	</isbndb>
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


/*
	$xml = simplexml_load_string($xml);

	echo "<hr>XML Contents:<br>";
	echo $xml;

	echo "Title: ";
	echo $xml->data->title;
	echo "<br>";

	echo "\n\n ISBN10: ";
	echo $xml->data->isbn10;
	echo "<br>";

	echo "\n\n ISBN13: ";
	echo $xml->data->isbn13;
	echo "<br>";

	echo "\n\n Edition: ";
	echo $xml->data->edition_info;
	echo "<br>";

	echo "\n\n Author: ";
	echo $xml->data->author_data->name;
	echo "<br>";

	echo "\n\n Publisher: ";
	echo $xml->data->publisher_name;
	echo "<br>";
*/
?>