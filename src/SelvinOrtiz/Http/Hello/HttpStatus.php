<?php
namespace SelvinOrtiz\Http\Hello;

class HttpStatus
{
	public function __construct( $vars=array() )
	{
		if ( is_array( $vars ) && count( $vars ) ) {

			foreach ($vars as $var => $val ) {
				$this->{ $var } = $val;
			}
		}
	}

	public function __set( $var, $val=null )
	{
		$this->{ $var } = $val;
	}
}
