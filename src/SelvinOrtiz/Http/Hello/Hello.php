<?php
namespace SelvinOrtiz\Http\Hello;

/**
 * @=SelvinOrtiz\Http\Hello\Hello
 *
 * Friendly alternative to PHP CURL
 *
 * @author		Selvin Ortiz <selvin@selvinortiz.com>
 * @package		Http
 * @version		0.4.0
 * @category	HTTP (PHP)
 * @copyright	2013 Selvin Ortiz
 */

class Hello
{
	public static function createRequest( $url, $method, $data=array(), $headers=array() )
	{
		$methods = array( HttpMethod::GET, HttpMethod::POST, HttpMethod::PUT, HttpMethod::DELETE );

		if ( !in_array( $method, $methods ) ) { $method = HttpMethod::GET; }

		return Bin::getInstance()->request( $url, $method, $data, $headers );
	}

	public static function createPostRequest( $url, $data=array(), $headers=array() )
	{
		return static::createRequest( $url, HttpMethod::POST, $data, $headers );
	}

	public static function createPutRequest( $url, $data=array(), $headers=array() )
	{
		return static::createRequest( $url, HttpMethod::POST, $data, $headers );
	}

	public static function createDeleteRequest( $url, $data=array(), $headers=array() )
	{
		return static::createRequest( $url, HttpMethod::DELETE, $data, $headers );
	}
}
