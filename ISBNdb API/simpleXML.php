//http://phpfiddle.org/
//https://stackoverflow.com/questions/12549543/echo-out-values-from-a-php-object
//http://php.net/manual/en/language.operators.string.php

$context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
$url = 'http://isbndb.com/api/v2/xml/YFWZ0Z2K/book/9780849303159';

$xml = file_get_contents($url, false, $context);
$xml = simplexml_load_string($xml);
print_r($xml);




$context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
$url = 'http://isbndb.com/api/v2/xml/YFWZ0Z2K/book/0124077269';

$xml = file_get_contents($url, false, $context);
$xml = simplexml_load_string($xml);
echo $xml->data->isbn10;



////////////////////////////////////////////////IGNORE ABBOVE///////////////////////////////////////////////////////

$context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
$url = 'http://isbndb.com/api/v2/xml/YFWZ0Z2K/book/';
$url .= '0124077269';

$xml = file_get_contents($url, false, $context);
$xml = simplexml_load_string($xml);
echo "Title: ";
echo $xml->data->title;
echo "\n\n ISBN10: ";
echo $xml->data->isbn10;
echo "\n\n ISBN13: ";
echo $xml->data->isbn13;
echo "\n\n Edition: ";
echo $xml->data->edition_info;
echo "\n\n Author: ";
echo $xml->data->author_data->name;
echo "\n\n Publisher: ";
echo $xml->data->publisher_name;