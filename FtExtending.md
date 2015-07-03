# Extending Morrow #



## Introduction ##

Sometimes you will reach a point where you need more power. No problem. You can integrate own user classes and also your own view handlers to extend Morrows power. When you load a class the factory also looks for class files in

  1. **FW\_PATH**/`_`libs/**class\_name**.class.php
  1. **PROJECT\_PATH**/`_`libs/**class\_name**.class.php

Place your class in path 1 if you need it in more than one project. Place it in path 2 if you need it in just one project.

## Integrating user classes ##

### Example ###

This example integrates the PEAR Text\_Diff into Morrow. It shows how to integrate a PEAR class in a system where the PEAR installer is not available. The PEAR files in this example are located in PROJECT\_PATH/`_`libs/pear/**.**

We create a new file textdiff.class.php that corresponds to the naming and folder conventions of Morrow and extend the original class in that file.

**PROJECT\_PATH/`_`libs/textdiff.class.php**
```
<?php

// PEAR needs its path set in the PHP include path. So we have to set the include_path manually.
 
set_include_path(PROJECT_PATH.'_libs/pear' . PATH_SEPARATOR . get_include_path() );
 
// include the PEAR class "Text_Diff"
require_once 'Text/Diff.php';
 
class textdiff extends Text_Diff {
    public function __construct($engine, $array1, $array2 ) {
        parent::Text_Diff($engine, array($array1, $array2));
    }
}

?>
```

**Our controller file looks like this:**
```
<?php

class PageController extends GlobalController {
    public function run() {
        $this->load('textdiff','auto', $array1, $array2);
        // now do with your class what you want to
        ...
    }
}

?>
```

## Integrate view handlers ##

Imagine you need a new view handler to display for example RSS Feeds, automated SQL export scripts, automatically computed graphs and so on. This is really simple to implement in Morrow.

There is a naming convention you have to follow. A view handler class has to start with the string **view**.

Let us take a look at the viewPlain handler which has the smallest code base. At the moment this handler returns just a scalar variable that was passed via $this->view->setContent().

```
<?php
 
class Viewplain extends ViewAbstract {
    public $mimetype        = 'text/plain';
    public $charset         = 'iso-8859-1';
 
    public function getOutput($content) {
        if (!is_scalar($content['content'])) {
            trigger_error(__class__.': The content variable for this handler has to be scalar.', e_user_error); return false;
        }
        return $content['content'];
    }
}
 
?>
```

You always have to extend Viewabstract which is the base for all view handlers. It also makes sure that the following method exists.

All members you declare as public are changeable via $this->view->setProperty() in the controller.

### _getOutput()_ ###
```
array function getOutput( array $content )
```
Returns the final output of this handler. The array $content contains all variables which was passed via $this->view->setContent(). If you have not passed a key for setContent in your controller, then you will find your content in the standard key "content".

## Integrate filters ##

There is a naming convention you have to follow. A filter class has to start with the string **filter**.

### Example ###
The following construct is the base for all new filters.
```
<?php
 
class FilterYourname extends FilterAbstract {
    protected $params = array();    

    public function __contruct($params) {
        $this->params = $params:
    }
    
    public function get($content) {
        // change the content here
        return $content;
    }
}

?>
```

To set the filter, call the following function in your controller.
```
$this->view->setFilter('yourname', $your_params);
```