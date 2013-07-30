<?php
namespace selvinortiz\Http\Hello;

class HttpResponse
{
	public $raw;
	public $info;
	public $status;
	public $response;

	public function __construct( $response, $content )
	{
		$this->raw			= $response;
		$this->info			= $response[ 'wrapper_data' ];
		$this->status 		= $this->getResponseStatus( $response );
		$this->response		= $content;
	}

	public function __toString()
	{
		$str = '';

		if ( is_string( $this->response) ) { $str = $this->response; }

		return $str;
	}

	public function getResponseStatus( $response=array() )
	{
		$status = array();
		try {
			$status	= array_shift( $response );
			$status	= explode( ' ', $status[0] );
			$status = array( 'version'=>$status[0], 'code'=>$status[1], 'message'=>$status[2]);
			$status = new HttpStatus( $status );
		} catch ( \Exception $e ) {
			throw new \Exception( $e->getMessage() );
		}

		return $status;
	}
}
