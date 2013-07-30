<?php
require __DIR__.'/../vendor/autoload.php';

use SelvinOrtiz\Http\Hello\Hello;
use SelvinOrtiz\Http\Hello\HttpMethod;

$url		= 'http://rest.akismet.com/1.1/verify-key';
$data		= array( 'blog' => 'http://domain.com', 'key' => '' );
$headers	= array( 'user-agent' => 'Hello 1.0 SelvinOrtiz/Hello' );
$response	= Hello::post( $url, $data );

echo '<pre>';
print_r($response);
exit('</pre>');
