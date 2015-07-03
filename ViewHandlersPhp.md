# PHP #

## Introduction ##

Beside Serpent it is also possible to use PHP itself as template language. Useful, if you need best performance in your application or you are not familiar with Serpent.

## Example ##
**Controller code:**
```
<?php
// ... Controller code
 
$data = "That's an example.";
 
$this->view->setHandler('Php');
$this->view->setContent($data);
 
// ... Controller code
?>
```

**Template code:**
```
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <base href="<?php echo $page['base_href']; ?>" />
        <title>Foobar</title>
</head>
<body>
 
<?php echo $content; ?>
 
<!-- or this if "short tags" are enabled at your server -->
<?= $content; ?>
 
</body>
</html>
```

## View properties ##

| Type | Keyname | Default | Description |
|:-----|:--------|:--------|:------------|
| string | mimetype | text/html | Changes the standard mimetype of the view handler. Possible values are "text/html", "application/xml" and so on. |
| string | charset | iso-8859-1 | Changes the standard charset of the view handler. Possible values are "UTF-8", "iso-8859-1" and so on. |
| string | downloadable | _empty_ | Changes the http header so that the output is offered as a download. $value defines the filename which is presented to the user. The mimetype will be automatically determined via file extension. It you specify a different mimetype, that will be used. |
| string | template | `_`index | Defines the frame template without the template suffix. The default value is "`_`index". Meaningful for example on popups, whose html code differs from the standard frame template. |
| string | content\_template | _alias_ | Defines the content template string without the template suffix. The default value is the alias of the actual page, for example manual\_view-handlers\_php. |
| string | template\_suffix | .tpl    | The extension that will be added to the content\_template and the template parameter. |