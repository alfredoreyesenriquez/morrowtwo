# Plain #

## Introduction ##

With this view handler it is possible to output single values. Useful if you create data by hand and want just to display it. The input has to be a scalar variable or a stream.

## Example ##
**Controller code:**
```
<?php
// ... Controller code
 
// standard example
$data = file_get_contents('testimage.jpg');
$this->view->setHandler('Plain');
$this->view->setProperty('mimetype', 'image/jpg');
$this->view->setContent($data);
 
// stream example
$handle = fopen('testimage.jpg', 'r');
$this->view->setHandler('Plain');
$this->view->setProperty('mimetype', 'image/jpg');
$this->view->setContent($handle);
 
// ... Controller code
?>
```

## View properties ##

| Type | Keyname | Default | Description |
|:-----|:--------|:--------|:------------|
| string | mimetype | text/plain | Changes the standard mimetype of the view handler. Possible values are "text/html", "application/xml" and so on. |
| string | charset | iso-8859-1 | Changes the standard charset of the view handler. Possible values are "UTF-8", "iso-8859-1" and so on. |
| string | downloadable | _empty_ | Changes the http header so that the output is offered as a download. $value defines the filename which is presented to the user. The mimetype will be automatically determined via file extension. It you specify a different mimetype, that will be used. |