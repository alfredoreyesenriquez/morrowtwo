# JSON #

## Introduction ##

With this view handler it is possible to generate and output valid JSON files. The assigned content has to be an array.

The most accentuated difference to XML is the more compact representation of data structures what results in less traffic overhead. For more information on JSON, visit http://www.json.org.

## Example ##
**Controller code:**
```
<?php
// ... Controller code
 
$data['frame']['section 1']['headline']  = 'Example';
$data['frame']['section 2']['copy']      = 'Example text';
$data['frame'][0]['headline']            = 'Example';
$data['frame'][0]['copy']                = 'Example text';
$data['frame']['section2']['copy1']      = 'This is a "<a>-link</a>';
$data['frame'][':section2']['param_key'] = 'param_value';
$content['content'] = $data;
 
$this->view->setHandler('JSON');
$this->view->setContent($data);
 
// ... Controller code
?>
```

**Output:**
```
{"frame":
        {"section 1":
                {"headline":"Example"},
        "section 2":
                {"copy":"Example text"},
        "0":
                {"headline":"Example", "copy":"Example text"},
        "section2":
                {"copy1":"This is a \"<a>-link</a>"},
        ":section2":
                {"param_key":"param_value"}
        }
}
```

## View properties ##

| Type | Keyname | Default | Description |
|:-----|:--------|:--------|:------------|
| string | mimetype | application/json | Changes the standard mimetype of the view handler. Possible values are "text/html", "application/xml" and so on. |
| string | charset | UTF-8   | Changes the standard charset of the view handler. Possible values are "UTF-8", "iso-8859-1" and so on. |
| string | downloadable | _empty_ | Changes the http header so that the output is offered as a download. $value defines the filename which is presented to the user. The mimetype will be automatically determined via file extension. It you specify a different mimetype, that will be used. |