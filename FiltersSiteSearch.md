# Sitesearch #

## Introduction ##

Sitesearch is a simple web page spider which indexes the actual viewed page. It works with a SQLite backend and should therefore work with every website up to an intermediate size.

The access to the indexed data and the search calls are done via the Sitesearch user class.

## Example ##
**Controller code:**
```
<?php
// ... Controller code
 
$config = array(
        'buildindex' => true,
        'exclude_patterns' => array( array('searchdata'=>'=database=i') )
);
 
$this->view->setFilter('sitesearch', $config, 'smarty');
 
// ... Controller code
?>
```

**Example page:**
```
<html>
<head>
        <title>Just an example page</title>
</head>
<body>
This will not get indexed.
<!-- include_start -->
        This will get indexed.
        <!-- exclude_start -->
                This will not get indexed.
        <!-- exclude_end -->
<!-- include_end -->
 
</body>
</html>
```

If you work on a linux system you can index your whole site with the following shell command:
```
wget --recursive --level=inf --no-parent --delete-after -nv --no-directories http://path-to-your-homepage.com
```

If you work on a mac os system you could download wget for mac and index your whole site with the same shell command.

## Filter properties ##

| Type | Keyname | Default | Description |
|:-----|:--------|:--------|:------------|
| boolean | buildindex | true    | Defines whether to index the actual viewed page or not. |
| array | exclude\_patterns | _empty_ | Defines an array patterns to decide whether to index the actual viewed page or not. The key of the pattern array defines the field to apply the pattern to (possible values are "url", "title", "searchdata" and "bytes"). The value is a regular expression. When this regex hits in the defined field, then the actual page will not get indexed. Useful to exclude error pages or similar pages. |
| string | tag\_include\_start | <!-- include\_start --> | Defines the beginning string of a region to index. |
| string | tag\_include\_end | <!-- include\_end --> | Defines the end string of a region to index. |
| string | tag\_exclude\_start | <!-- exclude\_start --> | Defines the start string of a region to exclude from indexing. Makes only sense inside the include tags. |
| string | tag\_exclude\_end | <!-- exclude\_end --> | Defines the end string of a region to exclude from indexing. Makes only sense inside the include tags.|
| integer | check\_divisor | 10      | Defines the frequency this filter will be applied to the actual viewed page. |
| integer | gc\_divisor | 100     | Defines the frequency the garbage collection will get started. On default the garbage collection will be used every 1000 times because of the check\_divisor. |
| string | entry\_lifetime | +1 month | When a page is not recrawled for the entry\_lifetime it will be deleted from the index. |
| array | db\_config | array(driver => 'sqlite', 'file' => **PROJECT\_PATH**/temp/sitesearch/sitesearch.sqlite, 'host' => 'localhost', 'db' => 'sitesearch\_searchengine', 'user' => 'root', 'pass' => '') | The default config for the used database. Usually you do not have to change those parameters. The driver has to be "sqlite". "mysql" and other drivers will not work. |