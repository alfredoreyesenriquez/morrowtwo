# Sitesearch #



## Introduction ##

This class accesses a sitesearch database created with the [Sitesearch](FiltersSiteSearch.md) filter which is necessary to be created first.

Those in combination provide a simple way to integrate a site wide search engine.

## Example ##
```
<?php
// ... Controller code
 
$q = $this->input->get('q');
$results = $this->sitesearch->get($q);
 
// ... Controller code
?>
```

The result array will return two elements: data and timestamp. You will get your search results with the array element 'data'.

## Methods ##

### _`__`construct()_ ###
```
void __construct( [ array $config ])
```
The constructor accepts an array with parameters for specifying sitesearch parameters.
For a list of parameters take a look at the parameters of the sitesearch filter. The only parameter you need to pass is db\_config if you have changed it in the filter.

### _get()_ ###
```
array get( string $q )
```
Returns the results of a query for the passed string **$q**.

It is possible to pass strings like "foo bar". This will work like "Find all pages with foo OR bar".
Words with less than two characters or typical stopwords will be ignored.
The search is always case insensitive.

### _getAll()_ ###
```
array getAll( [ string $where = ''])
```
Returns all indexed pages from the database for debugging purposes.
It is possible to pass a where clause to limit the number of results.