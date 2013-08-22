<?php
namespace SelvinOrtiz\Http\Hello;

/**
 * @=SelvinOrtiz\Http\Hello\Hello
 *
 * The simplest and most friendly alternative to PHP CURL
 *
 * @author		Selvin Ortiz - http://twitter.com/selvinortiz
 * @package		Http
 * @version		0.3.0
 * @category	HTTP (PHP)
 * @copyright	2013 Selvin Ortiz
 *
 * @todo
 * - Implement Hello::put()
 * - Implement Hello::delete()
 * - Add Composer
 * - Add PHPUnit
 */

class Hello
{
	public static function get( $url, $dataSet=array(), $headers=array() )
	{
		return static::request( HttpMethod::GET, $url, $dataSet, $headers );
	}

	public static function post( $url, $dataSet=array(), $headers=array() )
	{
		return static::request( HttpMethod::POST, $url, $dataSet, $headers );
	}

	protected static function request( $method, $url, $dataSet=array(), $headers=array() )
	{
		$context = array(
			'timeout'			=> 60,
			'max_redirects'		=> 10,
			'protocol_version'	=> 1.1
		);

		switch ( strtoupper( trim( $method ) ) )
		{
			case HttpMethod::GET:
				$context[ 'method' ]		= HttpMethod::GET;
			break;
			case HttpMethod::POST:
				$context[ 'method' ]		= HttpMethod::POST;
				$headers[ 'content-type' ]	= 'application/x-www-form-urlencoded';
			break;
			case HttpMethod::PUT:
				$context[ 'method' ]		= HttpMethod::POST;
				$dataSet[ '__method' ]		= HttpMethod::PUT;
				$headers[ 'content-type' ]	= 'application/x-www-form-urlencoded';
			break;
			case HttpMethod::DELETE:
				$context[ 'method' ]		= HttpMethod::POST;
				$dataSet[ '__method' ]		= HttpMethod::DELETE;
			break;
			default:
				$context[ 'method' ]		= HttpMethod::GET;
			break;
		}

		$context[ 'header' ]	= static::normalizeHeaders( $headers );
		$context[ 'content' ]	= static::normalizeData( $dataSet );

		try {
			$url		= static::normalizeUrl( $url );
			$context	= stream_context_create( array( 'http'=>$context ) );
			$stream		= fopen( $url, 'r', false, $context );
			$content	= stream_get_contents( $stream );
			$response	= stream_get_meta_data( $stream );
			fclose( $stream );
		} catch( \Exception $e ) {
			throw new \Exception( $e->getMessage() );
		}

		return new HttpResponse( $response, $content );
	}

	protected static function normalizeData( $data )
	{
		if ( is_array( $data ) && count( $data) )
		{
			return http_build_query( $data );
		}

		return false;
	}

	protected static function normalizeHeaders( $headers=array() )
	{
		$normalized = array();

		if ( is_array( $headers ) && count( $headers) )
		{
			foreach ( $headers as $key => $val ) {
				$key = strtolower( trim( $key ) );
				if ( 'user-agent' === $key || 'expect' === $key ) { continue; }
				$normalized[] = sprintf( '%s: %s', $key, $val );
			}
		}

		$normalized[] = 'user-agent: Hello 1.0 selvinortiz/hello';
		$normalized[] = 'expect:';

		return implode( "\r\n", $normalized );
	}

	protected static function normalizeUrl( $url )
	{
		$url = parse_url($url);

		$scheme	= $url['scheme'] . '://';
		$host	= $url['host'];
		$port	= isset( $url['port'] )		? $url['port']	: null;
		$path	= isset( $url['path'] )		? $url['path']	: null;
		$query	= isset( $url['query'] )	? $url['query']	: null;

		if ( ! is_null( $query ) ) {
			parse_str( $url['query'], $queryParsed );
			$query = sprintf( '?%s', http_build_query( $queryParsed ) );
		}

		if ( $port && $port[0] != ':') { $port = ':' . $port; }
		$result = $scheme.$host.$port.$path.$query;

		return $result;
	}
}
