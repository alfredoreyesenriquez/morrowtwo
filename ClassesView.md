# View #



## Introduction ##

The view class controls the output of the framework. The assigned content, the output format like (X)HTML, XML, Json and so on.
Also the caching of the output is controlled by this class. For a detailed explanation of output caching, take a look at the topic Output Caching.

## Example ##
```
<?php
// ... Controller-Code
 
$this->view->setHandler('XML');
$this->view->setContent($data);
$this->view->setProperty('charset', 'iso-8859-1');
 
// ... Controller-Code
?>
```

## Methods ##

### _get()_ ###
```
array get( int $compression_level )
```

Returns an array:
  * "header" the header
  * "content" the stream handle for the generated content of the view handler.
**$compression\_level** defines the gzip compression level from 1 (weak, bigger file size) to 9 (strong, smaller file size). If not given, the output will not be compressed.



### _setHandler()_ ###
```
void setHandler( string $displayhandler )
```
Sets the handler which is responsable for the format of the output. Possible values are "smarty", "php", "plain", "csv", "excel", "flash", "xml" und "json".
The usage ot the view formats are described in the manual at "View handlers".

### _setContent()_ ###
```
void setContent( mixed $value [, string $key = 'content'])
```
Assigns content variables to the actual view handler.
value can be a variable of any type which will be accessable with key name **$key**. If **$key** is not set, it will be automatically set to "content".

### _setHeader()_ ###
```
void setHeader( string $key , string $value )
```
Sets an additional http header. **$key** could be for example "Content-Length" and **$value** "378".

### _setProperty()_ ###
```
void setProperty( string $key , string $value [, string $handler ])
```
Sets handler specific properties. The properties mimetype, charset and downloadable are defined for every view handler.
It is possible to specify a **$handler** to bind the property to. If you have not chosen a handler the default handler will be used. For example if you want globally define your settings for all handlers.

### _setFilter()_ ###
```
void setFilter( string $filtername , mixed $config [, string $handler ])
```
Sets a filter to be executed after content generation.
It is possible to specify a **$handler** to bind the filter to. If you have not chosen a handler the default handler will be used.