<?php
require __DIR__.'/../vendor/autoload.php';

use selvinortiz\Http\Hello\Hello;
use selvinortiz\Http\Hello\HttpMethod;

$url		= 'http://rest.akismet.com/1.1/verify-key';
$data		= array( 'blog' => 'http://domain.com', 'key'=>'' );
$headers	= array( 'user-agent' => 'Kismet 1.0 selvinortiz/kismet' );
$response	= Hello::post( $url, $data );

echo '<pre>';
print_r($response);
exit('</pre>');
