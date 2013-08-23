<?php
namespace SelvinOrtiz\Http\Hello;

class HttpRequest
{
	public $url;
	public $method;
	public $dataset;
	public $headers;

	public function __construct( $url, $method=HttpMethod::GET, $data=array(), $headers=array() )
	{
		$this->url		= $url;
		$this->method	= $method;
		$this->dataSet	= $data;
		$this->headers	= $headers;
	}

	public function send( $dataSet=array(), $headers=array() )
	{
		$context = array(
			'timeout'			=> 60,
			'max_redirects'		=> 10,
			'protocol_version'	=> 1.1
		);

		switch ( strtoupper( trim( $this->method ) ) )
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

		$context[ 'header' ]	= $this->getNormalizedHeaders( $headers );
		$context[ 'content' ]	= $this->getNormalizedData( $dataSet );

		try {
			$url		= $this->getNormalizedUrl();
			$context	= stream_context_create( array( 'http'=>$context ) );
			$stream		= fopen( $url, 'r', false, $context );
			$content	= stream_get_contents( $stream );
			$response	= stream_get_meta_data( $stream );
			fclose( $stream );
		} catch( \Exception $e ) {
			throw new \Exception( $e->getMessage() );
		}

		return Bin::getInstance()->response( $response, $content );
	}

	protected function getNormalizedData( $data=array() )
	{
		if ( is_array( $this->dataSet ) && is_array( $data ) ) {
			$data = array_merge( $this->dataSet, $data );
		}

		if ( count( $data) ) {
			return http_build_query( $data );
		}

		return false;
	}

	protected function getNormalizedHeaders( $headers=array() )
	{
		$normalized = array();

		if ( is_array( $this->headers ) && is_array( $headers ) ) {
			$headers = array_merge( $this->headers, $headers );
		}

		if ( count( $headers) ) {
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

	protected function getNormalizedUrl()
	{
		$url = parse_url( $this->url );

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
