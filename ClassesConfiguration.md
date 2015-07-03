# Config #



## Introduction ##

This class handles the access to the configuration of the framework.

It automatically loads the config files in the configuration folders FW\_PATH/`_`config and for the project PROJECT\_PATH/`_`config. A file named `_`default.php will always be loaded. But you can override the default config with files which include either the IP address or the hostname of the server in their filename. Use for example a file localhost.php or 127.0.0.1.php to override parameters for your local development server.

### Dot Syntax ###

This class works with the extended dot syntax. So if you use keys like mailer.host and mailer.smtp as identifiers in your config, you can call $this->config->get('mailer') to receive an array with the keys host and smtp.


## Example ##
```
<?php
// ... Controller code
 
// show full framework configuration
dump($this->config->get());
 
// ... Controller code
```

## Methods ##

### _get()_ ###
```
array function get( [ string $identifier = null ])
```
Retrieves configuration parameters.
If $identifier is NULL, it returns an array with the complete configuration. Otherwise only the parameters below $identifier.

### _set()_ ###
```
void set( string $identifier , mixed $value )
```
Sets registered config parameters below $identifier.
$value can be of type string or array.