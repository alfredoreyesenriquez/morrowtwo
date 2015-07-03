# Flash #

## Introduction ##

This view generates an URL encoded string which can be read from the Flash loadvars object. The keys of an multidimensional array will be combined with an underscore to create unique identifiers. Numeric keys will automatically prefixed with "entry".

## Example ##
**Controller code:**
```
<?php
// ... Controller code
 
$data['frame']['section1']     = 'Example';
$data['frame'][0]['headline']  = 'Example';
$data['frame'][0]['copy']      = 'Example text';
$data['frame']['section2']     = 'This is a "<a>-link</a>';
 
$this->view->setHandler('Flash');
$this->view->setContent($data);
 
// ... Controller code
?>
```

**Output:**
```
&frame_section1=Example&frame_entry0_headline=Example&frame_entry0_copy=Example%20text&frame_section2=This%20is%20a%20%22%3Ca%3E-link%3C%2Fa%3E&eof=1
```

## View properties ##

| Type | Keyname | Default | Description |
|:-----|:--------|:--------|:------------|
| string | mimetype | text/plain | Changes the standard mimetype of the view handler. Possible values are "text/html", "application/xml" and so on. |
| string | charset | iso-8859-1 | Changes the standard charset of the view handler. Possible values are "UTF-8", "iso-8859-1" and so on. |
| string | downloadable | _empty_ | Changes the http header so that the output is offered as a download. $value defines the filename which is presented to the user. The mimetype will be automatically determined via file extension. It you specify a different mimetype, that will be used. |
| string | numeric\_prefix | entry   | If numeric indices are used in the base array this parameter will be prepended to the numeric index. |