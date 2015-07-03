# Save #

## Introduction ##

The Save filter just saves the output of the main view as a file.

## Example ##
**Controller code:**
```
<?php
// ... Controller code
 
$filename = $this->page->get('alias') . 'alias.html'; 
$this->view->setFilter('save', $filename);
 
// ... Controller code
?>
```

Notice that you have to manage the rights permissions for the output file. In this example the output would be set in the root directory. Remember: you'll never want to give writable rights to the root directory of your project. So you could choose another directory for the output :

```
<?php

// ... Controller code
// save filter
$directory = 'main/temp/';
$filename = $this->page->get('home') . 'home.htm'; 
$this->view->setFilter('save', $directory . $filename);
 
// ... Controller code
?>
```

Otherwise you will get this error message:

```
//www.yourdomain.de:

phpfile_put_contents(.htm) [function.file-put-contents]: failed to open stream: Permission denied


```

## Filter properties ##

| Type | Keyname | Default | Description |
|:-----|:--------|:--------|:------------|
| string| filename | _null_  | Defines the filename the content is saved to. |