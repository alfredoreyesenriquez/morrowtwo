# Url #



## Introduction ##

This class provides some usefull methods for dealing with URLs. Especially makeUrl() and redirect() are important, since they provide correct handling of Morrow paths in the context of "projects" (see topic Multiple Sites).

| Morrow normally works with Apache's mod\_rewrite functionality in order to present search engine safe URLs. If it is not possible to use URL-rewriting this functionality can be turned off by setting the config variable url.modrewrite to "0". |
|:--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| Since makeUrl() will return a correct URL even in that case, it is highly recommended that you always use the Url class methods for all paths.                                                                                                    |

## Methods ##

### _makeUrl()_ ###
```
string makeUrl( String $path [, array $query ][, array $replacements ][, bool $rel2abs = false] [, String $sep = null])
```
returns a properly formatted URL for $path.

  * **$path:** either a relative path to page in the same Morrow installation or a full URL to another site.
  * **$query:** an array of values that should be added to the query string. `$query['id'] = 1` will add &id=1 to the URL.
  * **$replacements:** array of changes to the url (see method rewrite)
  * **$rel2abs:** if true, the URL will be returned as a full URL (including scheme and host).
  * **$sep:** The separator for the the query string. Default is &amp; for valid XHTML. For using URLs other than in XHTML this should be set to &.

If a path does not begin with a slash, then the URL will be returned beginning with the current project.

**Acceptable values for path:**
(assuming we are in the project 'admin')

  * link to a page in the same project: users/view/ or /admin/users/view/
  * link to a file in the same project: xtras/files/data.txt`*`
  * link to a different project (called "promo"): /promo/register/
  * link to the main project: /home/
  * link to a different domain: http://domain.tld/path/
`*` if a file does not exist or cannot be found, the path will be treated as a page.

example with Serpent in view:
```
   <p>
      <a href="~~:url('/')~">back</a>
   </p>
```

### _redirect()_ ###
```
void redirect( String $path [, array $query = array ][, array $replacements ])
```

causes a clean http redirect to a new page or website. Valid values for **$path** are the same as for makeUrl().

  * **$path:** either a relative path to page in the same Morrow installation or a full URL to another site.
  * **$query:** an array of values that should be added to the query string. `$query['id'] = 1` will add &id=1 to the URL.
  * **$replacements:** array of changes to the url (see method rewrite)

### _parse()_ ###
```
array parse( String $url )
```
like PHP's parse\_url but returns an array with all of the keys even if they are empty
  * scheme
  * host
  * port
  * user
  * pass
  * path
  * query
  * fragment

### _rewrite()_ ###
```
string rewrite( String $url , array $replacements )
```
replaces parts of **$url** with the data supplied in **$replacements**. The keys for **$replacements** are the same as those returned by parse().