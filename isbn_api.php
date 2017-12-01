<?php
	$context = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
	$url = 'http://isbndb.com/api/v2/xml/YFWZ0Z2K/book/';
	$url .= '0124077269';

	$xml = file_get_contents($url, false, $context);
	$xml = simplexml_load_string($xml);
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
?>