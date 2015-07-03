# Navigation #



## Introduction ##

The class improves the handling with common navigational tasks. The navigation data has to follow a strict scheme but can be passed from different sources. The default way is to store the data in **PROJECT**/`_`i18n/**LANGUAGE**/`_`tree.php and fill a variable named **$tree**.

Because aliases can exist in more than one navigation branch (f.e. meta and main) you often have to specify the branch you want to work with.

## Example ##

_**tree.php**
```
<?php
$meta['contact']             = 'Kontakt';
$meta['imprint']             = 'Imprint';
$tree['meta'] =& $meta;
 
$navi['home']                = 'Homepage';
$navi['download']            = 'Download';
$navi['manual']              = 'Manual';
$navi['manual_first-page']   = 'First Page';
$navi['manual_second-page']  = 'Second Page';
$navi['support']             = 'Support';
$navi['development']         = 'Development';
$tree['main'] =& $navi;
 
?>
```_

**Global controller**
```
<?php
// ... Controller code
 
// the complete navigation tree
$navi = $this->navigation->get();
$this->view->setContent($navi, 'navi');
 
// breadcrumb
$breadcrumb = $this->navigation->getBreadcrumb('main');
$this->view->setContent($breadcrumb, 'breadcrumb');
               
// get previous and next page
$pager = $this->navigation->getPager('main');
$this->view->setContent($pager, 'pager');
 
// ... Controller code
?>
```

## Methods ##

### _`__`construct()_ ###
```
void __construct( $args )
```
Parameters
| Type | Keyname | Required | Default |
|:-----|:--------|:---------|:--------|
| array | data    | No       | content of _tree.php_|

### _extend()_ ###
```
void extend( array $data )
```
Extends the navigation data with the passed **$data**.
**$data** has to be an array with the same structure as in the example shown.

### _get()_ ###
```
array get( [ string $category = null, string $alias = null])
```
Returns the complete tree of the navigation. To get only the branch below an alias, you have to pass the **$category** and the **$alias** of the target node.

### _getBreadcrumb()_ ###
```
array getBreadcrumb( string $category )
```
Returns an array with information you can use to build a breadcrumb for the actual shown page (and its alias).

### _getPager()_ ###
```
array getPager( string $category [, string $alias = ''])
```
Returns and array with data for the next and the previous page based on the actual page (and its alias) in a given **$category** (f.e. main or alias). You can pass an **$alias** if you want the pager for an other page.

### _setVisible()_ ###
```
setVisible( string $category , string $node [, $status = true])
```
Sets the visibility of a $node in a given **$category**.