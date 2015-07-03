# Http #



## Introduction ##

This class is w wrapper for the cURL extension and allows to send HTTP requests.

## Example ##

```
<?php
// ... Controller code
 
// configure HTTP class
$this->load('http', array(
    CURLOPT_USERAGENT => 'Rumpelstilzchen',
    CURLOPT_REFERER => 'http://www.google.com',
    CURLOPT_HTTPHEADER => array('X-Foo-1: Bar 1', 'X-Foo-2: Bar 2'),
));

// HEAD request
$response = $this->http->head('http://localhost/?test_fdfd=123');

// GET request
$response = $this->http->get('http://localhost/?test_fdfd=123');

// POST request
$response = $this->http->post('http://localhost/?test_get=get', array('test_post' => 'post'), array('test_file' => 'test.png'));
 
// ... Controller code
?>
```

## Methods ##

### _head()_ ###
```
array head( string $url )
```
Sends a HEAD request. Just pass the **$url** you want to send your request to.
Returns an array with the keys "headers" and "body".

### _get()_ ###
```
array get( string $url )
```
Sends a GET request. Just pass the **$url** you want to send your request to.
Returns an array with the keys "headers" and "body".

### _post()_ ###
```
array post( $url [, array $data = array ( ) [, array $files = array ( )]] )
```
This method sends a POST request. You have to specify the **$url** the request should be sent to.
**$data** defines POST data you want to send. Use **$files** to send files.
Returns an array with the keys "headers" and "body".