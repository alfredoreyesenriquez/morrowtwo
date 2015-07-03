# Debugging #



## Introduction ##

Debugging is of course one of the most interesting topics while developing. Morrow gives you a simple and clean way to debug your applications.

## Dump ##

The most interesting tool is Morrow's system wide replacement for **print\_r()** and **var\_dump()**. It returns a nice layout with a lot more of information than other tools. For example where you did the call. Never forget anymore where you have placed your debugging call. Just try out.

```
<?php
 
// ... controller code
 
dump($this->page->get());
 
// ... controller code
```

## Errors & Exceptions ##

Morrow's preferred way is to work with exceptions. For that reason errors throw an exception, so you can catch them as you would do with normal exceptions. Furthermore we integrated a state-of-the-art-top-level-exception-handler.

```
<?php
 
// ... controller code
 
try {
    echo $undefined; // yes, the variable undefined was not defined before
} catch (Exception $e) {
    die($e->getMessage());
}
 
// ... controller code
```

## Configuration ##
```
### debug
$config['debug.screen']                 = true;
$config['debug.flatfile']               = false;
$config['debug.die_on_error']           = true;
```