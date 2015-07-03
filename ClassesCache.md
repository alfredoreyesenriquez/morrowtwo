# Cache #



## Introduction ##

With this class it is possible to store variables (except ressources) in an internal cache for performance reasons. This is very useful for operations or calculations which take much time to execute.

Imagine a very complex and time consuming database query which results only have to determined once an hour. Or an RSS Reader, whose external rss sources should only be retrieved once a day. Or a parser which should not parse a file twice when the modified time of the file did not change.

For such cases it could be a big performance boost to use the cache class.

## Example ##
```
<?php

// ... Controller code
 
if (!$result = $this->cache->load('result_id')) {
    // ... time consuming calculation
    $result = 'result of a very time consuming calculation';
    $this->cache->save('result_id', $result, '+5 seconds');
}

// your data
print_r($result);

// ... Controller code
```

If your cache item has expired but you cannot generate a new cache, it is possible to use the expired cache.

```
<?php

// ... Controller code
 
if (!$result = $this->cache->load('result_id')) {
    try {
        // ... time consuming calculation
        $result = 'result of a very time consuming calculation';
        $this->cache->save('result_id', $result, '+5 seconds');
    } catch (Exception $e) {
        // use the old result if something went wrong
        $temp = $this->cache->get($id);
        $result = $temp['object'];
    }
}

// your data
print_r($result);

// ... Controller code
```

## Methods ##

### _`__`construct()_ ###

Change $cachedir to change the standard cache directory. If $user\_droppable is set to true, it is possible to invalidate the cache with a browser refresh of the actual page.

**Parameters:**
| Type	| Keyname | Required | Default |
|:-----|:--------|:---------|:--------|
| string | cachedir | No       | PROJECT\_PATH/temp/_codecache/_|
| bool | user\_droppable| No       | If set to true, the cache will be refreshed on header HTTP-HTTP\_CACHE\_CONTROL |

### _load()_ ###
```
void load( string $cache_id, mixed $comparator = NULL)
```
Gets a variable with a given $cache\_id from cache, dependent on validity. With the $comparator you can pass an additional comparison variable of any type, which is also used in save(). Do the comparators differ the cache is not valid.

Returns the cached variable on success or FALSE on failure or invalid cache.

### _get()_ ###
```
void get( string $cache_id, mixed $comparator = NULL )
```
Same as load(), but also returns the cache item data if the item has expired.
Returns FALSE if there is no cached data yet.

### _save()_ ###
```
bool save( string $cache_id, mixed $var, string $lifetime, mixed $comparator = NULL, $user_droppable = NULL )
```
Puts a variable with a given $cache\_id into cache. $lifetime determines the maximum lifetime, given as a string strtotime() recognizes.
With the $comparator you can pass an additional comparison variable of any type, which is also used in save(). Do the comparators differ the cache is not valid. You could for example pass the modification time of a file to renew the cache on change of that file.

Return TRUE on success an FALSE on failure.

| **Take care of references:** Circular references inside the variable you are caching will be stored. Any other reference will be lost. |
|:---------------------------------------------------------------------------------------------------------------------------------------|

| **Take care of objects:** The class uses serialize() to store variables. When serializing objects, PHP will attempt to call the member function sleep() prior to serialization. This is to allow the object to do any last minute clean-up, etc. prior to being serialized. Likewise, when the object is restored using unserialize() the wakeup() member function is called. |
|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|

### _delete()_ ###
```
int delete( string $cache_pattern )
```
Deletes all cache ids with a given pattern $cache\_pattern. The pattern works with from shell known wildcards "`*`" and "?". The pattern "result`_*`" for example deletes alle cache ids which start with "result`_`".

Returns the number of deleted cache ids.