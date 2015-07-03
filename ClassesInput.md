# Input #



## Introduction ##

This class handles the access to input that comes from the outside of the framework: $`_`GET, $`_`POST and $`_`FILES. It cleans the input vars and reformats the $`_`FILES array for a uniform access to it.

### Dot Syntax ###

This class works with the extended dot syntax. So if you have keys like input\_example.host and input\_example.smtp in your input, you can call $this->input->get('input\_example') to receive an array with the keys host and smtp.

## Example ##
```
<?php
// ... Controller code
 
// retrieve full framework configuration
dump($this->input->get());
 
// ... Controller code
```

## Methods ##

### _get()_ ###
```
mixed function get( [ string $key = null ])
```
Retrieves input that came per $`_`POST, $`_`GET or $`_`FILES.
If $key is NULL, it returns an array or a string with the complete input. Otherwise only the parameters below $key.

### _getPost()_ ###
```
mixed function getPost( [ string $key = null ])
```
Like get(), but just returns values which came per POST request.

### _getGet()_ ###
```
mixed function getGet( [ string $key = null ])
```
Like get(), but just returns values which came per GET request.

### _getFiles()_ ###
```
mixed function getFiles( [ string $key = null ])
```
Like get(), but just returns values which came per FILES request.

### _clean()_ ###
```
array function clean( [ mixed $input ])
```
Unifies line breaks to \n (UNIX line breaks) and trims the content (strips whitespace from the beginning and the end of $input).
You do not have to call this method for the standard input variables because this is automatically done for you.

### _removeXss()_ ###
```
string function removeXss( string $var )
```
Filters a string from XSS attack vectors. Returns the cleaned string.