<?php
use SelvinOrtiz\Http\Hello\Hello;

class HelloTest extends PHPUnit_Framework_TestCase
{
	public function setUp()	{}

	public function tearDown() {}

	public function inspect($data)
	{
		fwrite( STDERR, print_r($data) );
	}

	public function testPost()
	{
		$url		= 'http://rest.akismet.com/1.1/verify-key';
		$data		= array( 'blog' => 'http://domain.com', 'key' => '' );
		$headers	= array( 'user-agent' => 'Hello 1.0 SelvinOrtiz/Hello' );
		$response	= Hello::createPostRequest( $url, $data )->send();

		$this->assertEquals( 'invalid', (string) $response );
		$this->assertInstanceOf( 'SelvinOrtiz\\Http\\Hello\\HttpResponse', $response );
	}
}
