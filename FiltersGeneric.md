# Generic #

## Introduction ##

This is a filter for simple "one function changes". This is nice because you do not need to add special filters for simple tasks.

## Example ##
**Controller code:**
```
<?php
// ... Controller code
 
// Replace all occurrences of Morrow with MORROW
$this->view->setFilter('generic', array('str_replace', 'Morrow', 'MORROW', ':CONTENT') );
 
// Change the encoding of the whole output from iso to utf-8
$this->view->setFilter('generic', array('mb_convert_encoding', ':CONTENT', 'utf-8', 'iso-8859-1'));
 
// ... Controller code
?>
```

## Filter properties ##

| Type | Keyname | Default | Description |
|:-----|:--------|:--------|:------------|
| string | 0       | _empty_ | Defines the function to be executed. |
| array | 1       | _empty_ | Defines an array of parameters which will be passed to the defined function as single parameters. Use the string :CONTENT to define the position to pass the view output. |