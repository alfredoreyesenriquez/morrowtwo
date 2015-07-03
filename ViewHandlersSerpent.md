# Serpent #

## Introduction ##

It's possible to use PHP itself and also [Serpent](ViewHandlersSerpent.md) as template language. PHP is useful, if you need best performance in your application or you are not familiar with Serpent.

## Example ##
**Controller code:**
```
<?php

class PageController extends GlobalController {
	
	public function run() {
		$data = "<p>Documentation you'll find
                         <a href='http://code.google.com/p/morrowtwo/wiki/Homepage'>here</a>	
		         </p>";
		$this->view->setHandler('Serpent');
		$this->view->setContent($data, "data");
	}
	
```

**Notices**
> 'Serpent' is used as handler, more possible handler are available in [ViewHandlers](ViewHandlers.md)

> "data" is used to make variable $data available in view.

**Template code:**
```
~:extend('_index')~

~[body]~
	MorrowTwo Framework is ready :)
	<?= $data; ?>
	
	
	
~[/body]~

```

Furthermore you should know that Serpent is a powerful template engine, which compiles and generate templates in the following directory: _/temp/**templates\_compiled/**. Therefore are write & read rights necessary. If the Serpent engine is not allowed to read and write in that directory, than you should delete the old compiled templates and let them renew again._

## View properties ##
```
MorrowTwo Framework is ready :)

Documentation you'll find here

```

## Serpent project page ##
**See the project page for documentation**

https://code.google.com/p/serpent-php-template-engine/