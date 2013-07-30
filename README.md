## Hello 0.1.0 (Friendly HTTP)
The simplest and most friendly alternative to **PHP CURL** *by* [Selvin Ortiz](http://twitter.com/selvinortiz)

### Description
This mini library allows you to perform `GET` and `POST` requests without much fuzz using sockets.

### Requirements
- PHP 5.3
- Composer _(Package will be added soon)_

### Usage

```php
require '/path/to/vendor/autoload.php';

use selvinortiz\Http\Hello\Hello;

$url        = 'http://rest.akismet.com/1.1/verify-key';
$data       = array( 'blog' => 'http://domain.com', 'key'=>'' );
$headers    = array( 'user-agent' => 'Kismet 1.0 selvinortiz/kismet' );
$response   = Hello::post( $url, $headers, $data );

echo $response;     // Outputs the response content (invalid)

print_r($response); // Outputs the response object

/*

selvinortiz\Http\Hello\HttpResponse Object
(
    [raw] => Array
        (
            [wrapper_data] => Array
                (
                    [0] => HTTP/1.1 200 OK
                    [1] => Server: nginx
                    [2] => Date: Tue, 30 Jul 2013 20:33:40 GMT
                    [3] => Content-Type: text/plain; charset=utf-8
                    [4] => Content-Length: 7
                    [5] => Connection: close
                    [6] => X-akismet-server: 192.168.7.151
                    [7] => X-akismet-debug-help: Empty "key" value
                )

            [wrapper_type] => http
            [stream_type] => tcp_socket/ssl
            [mode] => r
            [unread_bytes] => 0
            [seekable] =>
            [uri] => http://rest.akismet.com/1.1/verify-key
            [timed_out] =>
            [blocked] => 1
            [eof] => 1
        )

    [info] => Array
        (
            [0] => HTTP/1.1 200 OK
            [1] => Server: nginx
            [2] => Date: Tue, 30 Jul 2013 20:33:40 GMT
            [3] => Content-Type: text/plain; charset=utf-8
            [4] => Content-Length: 7
            [5] => Connection: close
            [6] => X-akismet-server: 192.168.7.151
            [7] => X-akismet-debug-help: Empty "key" value
        )

    [status] => selvinortiz\Http\Hello\HttpStatus Object
        (
            [version] => HTTP/1.1
            [code] => 200
            [message] => OK
        )

    [response] => invalid
)

*/
```

### Changelog

#### v0.1.0 (alpha)
- Initial release implements `Hello::get()` and `Hello::post()`
