<?php
namespace SelvinOrtiz\Http\Hello;

class Bin extends \SelvinOrtiz\Zit\Zit
{
	public static function run()
	{
		$bin = Bin::getInstance();

		$bin->extend( 'status', function( $vars=array() )
		{
			return new HttpStatus( $vars );
		});
		$bin->extend( 'request', function( $url, $method, $data=array(), $headers=array() )
		{
			return new HttpRequest( $url, $method, $data, $headers );
		});
		$bin->extend( 'response', function( $response, $content )
		{
			return new HttpResponse( $response, $content );
		});
	}
}

Bin::run();
