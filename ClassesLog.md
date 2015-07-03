# Log #



## Introduction ##

This class is a simple solution to log various variables to a file for controlling issues.

## Example ##
**Code**
```
<?php

// ... Controller code
 
// variables to log
$integer = 1;
$string  = 'foobar';
$boolean = false;
$null    = null;
$array   = array('foo'=>'bar', 'foo2'=>'bar2');
$object  = new stdClass();
 
// now log
$this->log->set($integer, $string, $boolean, $null, $array, $object);
 
// ... Controller code
```

**Output**
```
date: 2008-01-30 13:33:51 .481
call: /var/www/framework/project/_controller/example.php (line 14)
---
int(1)
---
string(6) "foobar"
---
bool(false)
---
NULL
---
array(2) {
  ["foo"]=>
  string(3) "bar"
  ["foo2"]=>
  string(4) "bar2"
}
---
object(stdClass)#23 (0) {
}
==============================
```

## Methods ##

### _`__`construct()_ ###

Change the path to the log file using the key logfile.

Parameters
| Type | Keyname |Required | Default |
|:-----|:--------|:--------|:--------|
| string | logfile | No      | **FRAMEWORK\_ROOT**/`_`logs/log`_`**YYYY-MM-DD**.txt |

### _set()_ ###
```
bool set( mixed $var1 [, mixed $var2 [, ... ]])
```
Writes a log message with all dumped variables into the log file. You can pass any number of variables of any type. Every log message will be appended to the log file.

Return TRUE on success or FALSE on failure.