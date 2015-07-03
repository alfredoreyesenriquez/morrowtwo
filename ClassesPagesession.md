# Pagesession #



## Introduction ##

The Pagesession class is identical to the Session class except that the information stored is only accessible from the current page (based on $page->alias).

The Pagesession is useful for storing user information that is only relevant for the current page, e.g. table sorting information on database output, or like the example below, counting user visits per page.

| Calling $session->delete() has no affect on Pagesession values, since the information is stored separately. |
|:------------------------------------------------------------------------------------------------------------|

## Example ##
```
<?php
// ... Controller code
 
// counting user visits to each page
$pageview = $this->pagesession->get("visits");
 
if($pageview == null) {
        $pageview = 0;
}
 
$view = $pageview+1;
 
$this->pagesession->set("visits", $view);
 
// ... Controller code
?>
```

## Methods ##

See [Session](ClassesSession.md).