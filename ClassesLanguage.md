# Language #



## Introduction ##

The Language class provide an interface to the the data that is stored in arrays the `_`i18n folder. The language of the files read is automatically the current language.
The Language class is instanced by Morrow and relies on the following configuration variables:

  * **language.default:** the default language key (string).
  * **language.possible:** an array of possible language keys

## Example ##
```
<?php

// ... Controller code
 
$alias = $this->page->get('alias');
 
// passing language content to the template
$lcontent = $this->language->getContent($alias);
$this->view->setContent($lcontent);
 
// passing the list of available translations to the template
$translations = $this->language->getTranslations($alias);
$this->view->setContent($translations, 'translations');
 
// ... Controller code
```

## Methods ##

### _get()_ ###
```
string get( )
```
returns the currently selected language key.

### _set()_ ###
```
bool set( [ String $lang = null])
```
sets the current language key if it is a valid language.

### _isValid()_ ###
```
bool isValid( String $lang )
```
returns true if $lang is in the list of possible languages, otherwise false.

### _getContent()_ ###
```
array getContent( String $alias )
```
returns the language specific content array for the page alias.

### _getFormContent()_ ###
```
array getFormContent( String $alias )
```
returns the language specific form content array for the page alias.

### _getTree()_ ###
```
array getTree( )
```
returns the language specific navigation tree array.

### _getTranslations()_ ###
```
array getTranslations( String $alias )
```
returns an array of language keys for which the page alias exist. This is based on the existance of the same key in another language's navigation tree.

### _translationExists()_ ###
```
bool translationExists( String $lang , String $alias )
```
returns true if the page $alias exists in the navigation tree of language $lang, otherwise false.

ias exists in the navigation tree of language $lang, otherwise false.

### _getLocale()_ ###
```
bool getLocale( [String $lang] )
```
returns the config array from the i18n-file for $lang or for the current language if $lang is not set.