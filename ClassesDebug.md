# Debug #



## Introduction ##

This class helps you to debug your application. The methods described here need not to be called directly.

You are able to change the behaviour of these methods with the following parameters you should set in your configuration files:

| Type | Keyname | Default | Description |
|:-----|:--------|:--------|:------------|
| bool | debug.screen | true    | Defines if errors should be displayed on screen. |
| bool | debug.flatfile | false   | Defines if errors should be logged in a file. The directory for log files is `_`logs below the root. |
| bool | debug.die\_on\_error | true    | Defines if the execution of the script should be stopped after an error to prevent inherited errors. |

## Example ##
```
<?php
// ... Controller code
 
$this->benchmark->start('Section 1');
 
// ... The code to be benchmarked
 
$this->benchmark->stop();
dump($this->benchmark->get());
 
// ... Controller code
```

## Methods ##

### _dump()_ ###
```
void dump( mixed $var )
```
This method is similar to the PHP own var\_dump() but provides a nicer look and a little more information.

| We registered a **global function dump()** for you that initializes this class and calls this method with all parameters you passed to it. |
|:-------------------------------------------------------------------------------------------------------------------------------------------|