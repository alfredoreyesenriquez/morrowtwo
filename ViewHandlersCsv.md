# CSV #

## Introduction ##

With this view handler it is possible to generate and output CSV (comma separated values) files.

## Example ##
**Controller code:**
```
<?php
// ... Controller code
 
$data[0]['date']       = '2007-01-01';
$data[0]['headline']   = 'I am a Headline.';
$data[0]['intro']      = 'Very short text.';
$data[0]['text']       = "And a long text.";
$data[1]['date']       = '2008-01-01';
$data[1]['headline']   = 'I am a second Headline.';
$data[1]['intro']      = 'Very short text.';
$data[1]['text']       = "And a long text.";
 
$this->view->setHandler('CSV');
$this->view->setContent($data);
 
// ... Controller code
?>
```

**Output:**
```
"date";"headline";"intro";"text"
"2007-01-01";"I am a Headline.";"Very short text.";"And a long text."
"2008-01-01";"I am a second Headline.";"Very short text.";"And a long text."
```

## View properties ##

| Type | Keyname | Default | Description |
|:-----|:--------|:--------|:------------|
| string | mimetype | application/vnd.ms-excel | Changes the standard mimetype of the view handler. Possible values are "text/html", "application/xml" and so on. |
| string | charset | iso-8859-1 | Changes the standard charset of the view handler. Possible values are "UTF-8", "iso-8859-1" and so on. |
| string | downloadable | _empty_ | Changes the http header so that the output is offered as a download. $value defines the filename which is presented to the user. The mimetype will be automatically determined via file extension. It you specify a different mimetype, that will be used. |
| string | separator | ;       | Fields get separated with this string. |
| string | delimiter | "       | The character used to enclose the fields. |
| boolean | table\_header | true    | Set to false if you do not want the field names as first row. |
| string | linebreaks | \n (UNIX line break) | The linebreak format used for output. |