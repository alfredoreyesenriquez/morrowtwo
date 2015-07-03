# URL Routing #



## Introduction ##

URL Routing is a fine thing if you want to internally redirect URLs to other aliases as the framework would normally use. Imagine them as a simple use of mod\_rewrite but without consideration of the host. Just the path of the query matters.

## Configuration ##

The configuration for the routing rules has to be set in the config files for each project (for example /main/`_`config/). Only the array within the config key "routing" matters.

```
<?php
 
// routing rules
$config['routing'] = array(
    '/' => 'home/',
);
```

Each array entry defines a rule will be run through when an URL is requested. The key is the pattern that have to match the incoming url. The value defines the target of the redirection.

As you can see in the code snippet above, there is already one rule defined. This rule defines that the alias "home" is called when there is no path given. Change that if you want to use an other default controller.

| Do not forget to define the rules for each language! |
|:-----------------------------------------------------|

## Rules ##

There are a few things you have to consider:

```
:[a-z0-9_]
```

Use a colon to define a parameter which will be passed to the input class and is available via $this->input->get(). Nice to create pretty URLs without GET parameters.

```
*[a-z0-9_]
```

Use a asterisk to define a bunch of parameters which will be passed to the input class and are available via $this->input->get(). Useful if you do not know how many parameters you will get.

The asterisk pattern has to be at the end of the rule and may appear only once per pattern.

## Examples ##

### Dynamically named parameters ###

Imagine you want to have URLs like products/category/this-is-the-product/ rather than products/?id=2067

```
$config['routing'] = array(
       'products/:category/:product/' => 'products/',
);
```

### URL layout often used by other frameworks ###

```
$config['routing'] = array(
        ':controller/:action/*myparams' => ':controller/',
);
```