<?php
namespace selvinortiz\Http\Hello;

class HttpMethod
{
	const GET		= 'GET';
	const PUT		= 'PUT';		// POST + __method=PUT
	const POST		= 'POST';
	const DELETE	= 'DELETE';		// POST + __method=DELETE
}
