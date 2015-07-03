# XML #

## Introduction ##

With this view handler it is possible to generate and output valid XML files. The assigned content has to be an array.

There are some special things you should keep in mind (take a look at the example):

  * **Equal named tags:** Use a blank to create equal named tags. All characters behind the blank will get stripped.
  * **Attributes:** add attributes by prefixing the target tag with a colon.
  * **Numeric indices:** Numeric Indices will be prefixed by "entry" to generate a valid tag.

## Example ##
**Controller code:**
```
<?php
// ... Controller code
 
// Equal named tags
$data['frame']['section 1']['headline']  = 'Example';
$data['frame']['section 2']['copy']      = 'Example text';
 
// Numeric indices
$data['frame'][0]['headline']            = 'Example';
$data['frame'][0]['copy']                = 'Example text';
 
// Attributes
$data['frame']['section2']['copy1']      = 'This is a "<a>-link</a>';
$data['frame'][':section2']['param_key'] = 'param_value';
 
$this->view->setHandler('XML');
$this->view->setContent($data);
 
// ... Controller code
?>
```

**Output:**
```
<?xml version="1.0" encoding="UTF-8"?>
 
<frame>
        <section>
                <headline>Example</headline>
        </section>
        <section>
                <copy>Example text</copy>
        </section>
        <entry_0>
                <headline>Example</headline>
                <copy>Example text</copy>
        </entry_0>
        <section2 param_key="param_value">
                <copy1><![CDATA[This is a "<a>-link</a>]]></copy1>
        </section2>
</frame>
```

## View properties ##

| Type | Keyname | Default | Description |
|:-----|:--------|:--------|:------------|
| string | mimetype | application/xml | Changes the standard mimetype of the view handler. Possible values are "text/html", "application/xml" and so on. |
| string | charset | UTF-8   | Changes the standard charset of the view handler. Possible values are "UTF-8", "iso-8859-1" and so on. |
| string | downloadable | _empty_ | Changes the http header so that the output is offered as a download. $value defines the filename which is presented to the user. The mimetype will be automatically determined via file extension. It you specify a different mimetype, that will be used. |
| string | numeric\_prefix | entry   | If numeric indices are used in the base array this parameter will be prepended to the numeric index. |
| string | strip\_tag | _space character_ | The parameter used to create equal named tags. All characters behind this parameter will get stripped. |
| string | attribute\_tag | :       | The parameter used to create attributes. Prefix the target node with this parameter. |